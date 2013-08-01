<?php
namespace Msc;

include 'bootstrap.php';

/**
 * front controller for CLI application
 */
class Front_Process
{
    public static function runStatic() {
        global $argv;
        
        $checker = new Checker(new HttpClientCurl());
        $fileName = $argv[1];
        $task = new FileTask('data/in/' . $fileName, 'data/out/' . $fileName);
        $processor = new FileProcessor($task, $checker);
        $processor->process(function($site, $result) {echo $site, ":\n", $result, "\n";});
    }
}

Front_Process::runStatic();