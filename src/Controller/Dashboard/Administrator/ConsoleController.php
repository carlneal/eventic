<?php

namespace App\Controller\Dashboard\Administrator;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Contracts\Translation\TranslatorInterface;

class ConsoleController extends Controller {

    /**
     * @Route("/console", name="console", methods="GET")
     */
    public function index() {
        return $this->render('Dashboard/Administrator/Console/index.html.twig');
    }

    /**
     * @Route("/console/execute-command/{command}/{optionKey}/{optionValue}", name="console_execute_command", methods="GET")
     */
    public function executeCommand($command, $optionKey, $optionValue, KernelInterface $kernel, TranslatorInterface $translator) {

        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput([
            'command' => $command,
            $optionKey => $optionValue,
        ]);

        $output = new NullOutput();
        $application->run($input, $output);

        return new JsonResponse($translator->trans('Successfully executed the command') . ' ' . $command . ' ' . $optionKey . '=' . $optionValue);
    }

}
