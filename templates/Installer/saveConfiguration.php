<html lang="" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://ogp.me/ns/fb#">
    <head>
        <!--[if IE]>
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <![endif]-->
        <meta charset="utf-8">
        <meta name="robots" content="noindex,nofollow">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Setup Wizard | Eventic</title>
        <link rel="shortcut icon" href="assets/img/favicon.png">

        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/HoldOn.min.css">

    </head>
    <body>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
        <script src="assets/js/HoldOn.min.js"></script>
        <script>
            HoldOn.open({
                theme: "sk-fading-circle",
                content: 'Please wait while saving your configuration...',
                backgroundColor: "#fff",
                textColor: "#f67611"
            });
        </script>
    </body>
</html>
<?php

function updateEnv($key, $value) {
    if (!$key || !$value) {
        return;
    }
    $envFile = '../../.env';
    $lines = file($envFile);
    $newLines = [];
    foreach ($lines as $line) {
        preg_match('/' . $key . '/i', $line, $matches);
        if (!count($matches)) {
            $newLines[] = $line;
            continue;
        }
        $newLine = trim($key) . "=" . trim($value) . "\n";
        $newLines[] = $newLine;
    }
    $newContent = implode('', $newLines);
    file_put_contents($envFile, $newContent);
}

header('Location: ' . str_replace("/install/saveConfiguration.php", "", strtok((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", '?')));
die;
?>