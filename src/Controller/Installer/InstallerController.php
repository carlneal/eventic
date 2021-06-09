<?php

namespace App\Controller\Installer;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\AppServices;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

class InstallerController extends AbstractController {

    /**
     * @Route("/", name="install")
     */
    public function index(AppServices $services, KernelInterface $kernel) {

        if ($services->getEnv("IS_WEBSITE_CONFIGURED") == "1") {
            return $this->redirectToRoute("homepage");
        }

        $phpVersion = phpversion();
        $phpOk = version_compare($phpVersion, '7.1.30') >= 0;
        $ctypeOk = extension_loaded('ctype');
        $iconvOk = extension_loaded('iconv');
        $jsonOk = extension_loaded('json');
        $pcreOk = extension_loaded('pcre');
        $sessionOk = extension_loaded('session');
        $SimpleXMLOk = extension_loaded('SimpleXML');
        $tokenizerOk = extension_loaded('tokenizer');
        $intlOk = extension_loaded('intl');
        $opensslOk = extension_loaded('openssl');
        $domOk = extension_loaded('dom');
        $mbstringOk = extension_loaded('mbstring');
        $curlOk = extension_loaded('curl');
        $fileinfoOk = extension_loaded('fileinfo');
        $gdOk = extension_loaded('gd');
        $libxmlOk = extension_loaded('libxml');
        $xmlOk = extension_loaded('xml');
        $xmlreaderOk = extension_loaded('xmlreader');
        $xmlwriterOk = extension_loaded('xmlwriter');
        $zipOk = extension_loaded('zip');
        $zlibOk = extension_loaded('zlib');
        $requirementsOk = $phpOk && $ctypeOk && $iconvOk && $jsonOk && $pcreOk && $sessionOk && $SimpleXMLOk && $tokenizerOk && $intlOk && $opensslOk && $domOk && $mbstringOk && $curlOk && $fileinfoOk && $gdOk && $libxmlOk && $xmlOk && $xmlreaderOk && $xmlwriterOk && $zipOk && $zlibOk;

        $cacheFolderWritable = is_writable($kernel->getProjectDir() . '/var/cache/');
        $logFolderWritable = is_writable($kernel->getProjectDir() . '/var/log/');
        $mediaFolderWritable = is_writable($kernel->getProjectDir() . '/public/media/');
        $uploadsFolderWritable = is_writable($kernel->getProjectDir() . '/public/uploads/');
        $sessionsFolderWritable = is_writable($kernel->getProjectDir() . '/sessions/');
        $jsTranslationsFolderWritable = is_writable($kernel->getProjectDir() . '/assets/js/translations/');
        $envWritable = is_writable($kernel->getProjectDir() . '/.env');
        $folderPermissions = $cacheFolderWritable && $logFolderWritable && $mediaFolderWritable && $uploadsFolderWritable && $sessionsFolderWritable && $jsTranslationsFolderWritable && $envWritable;


        return $this->render('Installer/install.html.twig', [
                    "requirementsOk" => $requirementsOk,
                    "phpOk" => $phpOk,
                    "ctypeOk" => $ctypeOk,
                    "iconvOk" => $iconvOk,
                    "jsonOk" => $jsonOk,
                    "pcreOk" => $pcreOk,
                    "sessionOk" => $sessionOk,
                    "SimpleXMLOk" => $SimpleXMLOk,
                    "tokenizerOk" => $tokenizerOk,
                    "intlOk" => $intlOk,
                    "opensslOk" => $opensslOk,
                    "domOk" => $domOk,
                    "mbstringOk" => $mbstringOk,
                    "curlOk" => $curlOk,
                    "fileinfoOk" => $fileinfoOk,
                    "gdOk" => $gdOk,
                    "libxmlOk" => $libxmlOk,
                    "xmlOk" => $xmlOk,
                    "xmlreaderOk" => $xmlreaderOk,
                    "xmlwriterOk" => $xmlwriterOk,
                    "zipOk" => $zipOk,
                    "zlibOk" => $zlibOk,
                    "folderPermissions" => $folderPermissions,
                    "cacheFolderWritable" => $cacheFolderWritable,
                    "logFolderWritable" => $logFolderWritable,
                    "mediaFolderWritable" => $mediaFolderWritable,
                    "uploadsFolderWritable" => $uploadsFolderWritable,
                    "sessionsFolderWritable" => $sessionsFolderWritable,
                    "jsTranslationsFolderWritable" => $jsTranslationsFolderWritable,
                    "envWritable" => $envWritable,
        ]);
    }

    function importDatabase($host, $username, $password, $name, $sqlFilePath) {
        $sql = file_get_contents($sqlFilePath);
        $mysqli = new \mysqli($host, $username, $password, $name);
        $mysqli->multi_query($sql);
        while (mysqli_more_results($mysqli) && mysqli_next_result($mysqli));
    }

    /**
     * @Route("/save-conviguration", name="save_conviguration")
     */
    public function saveConviguration(Request $request, AppServices $services, KernelInterface $kernel) {

        $host = $request->query->get('host');
        $username = $request->query->get('username');
        $password = $request->query->get('password');
        $name = $request->query->get('name');

        $databaseConfigLine = 'mysql://username:password@host/name';
        $databaseConfigLine = str_replace("host", $host, $databaseConfigLine);
        $databaseConfigLine = str_replace("username", $username, $databaseConfigLine);
        if (strlen($password) > 0) {
            $databaseConfigLine = str_replace("password", $password, $databaseConfigLine);
        } else {
            $databaseConfigLine = str_replace(":password", "", $databaseConfigLine);
        }
        $databaseConfigLine = str_replace("name", $name, $databaseConfigLine);

        $this->importDatabase($host, $username, $password, $name, $kernel->getProjectDir() . '/assets/sql/initial-database.sql');

        $services->updateEnv('DATABASE_URL', $databaseConfigLine);
        $services->updateEnv('IS_WEBSITE_CONFIGURED', '1');
        $this->addFlash('success', 'Eventic was successfully configured');
        return $this->redirectToRoute("homepage");
    }

    /**
     * @Route("/test-database-connection", name="test_database_connection")
     */
    public function testDatabaseConnection(Request $request, AppServices $services) {

        $host = $request->query->get('host');
        $username = $request->query->get('username');
        $password = $request->query->get('password');
        $name = $request->query->get('name');

        try {
            $connect = mysqli_connect($host, $username, $password);
        } catch (\ErrorException $e) {
            return new Response('Unable to connect to ' . $host);
        }

        if (!(mysqli_select_db($connect, $name))) {
            return new Response('Could not open the database ' . $name);
        }
        return new Response('1');
    }

}
