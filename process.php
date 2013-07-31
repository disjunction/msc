<?php
namespace Msc;

include 'bootstrap.php';

class Front_Process
{
    public function run() {
        global $argv;
        
        $checker = new Checker(new HttpClientCurl());
        $fileName = $argv[1];
        $task = new FileTask('data/in/' . $fileName, 'data/out/' . $fileName);
        $processor = new FileProcessor($task, $checker);
        $processor->process(function($site, $result) {echo $site, ":\n", $result, "\n";});
    }

    public static function runStatic() {
        $o = new self();
        $o->run();
    }
}

Front_Process::runStatic();