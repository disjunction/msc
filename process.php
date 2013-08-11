<?php
namespace Msc;

include 'library/bootstrap.php';
set_time_limit(0);

/**
 * front controller for CLI application
 */
class Front_Process
{
    
    public static function spawnProcesses() {
        exec('ps aux | grep process.php | grep -v grep | grep -v bin/sh', $result);
        if (count($result) > 1) {
            die("already running\n");
        }
        
        $in = new FileRepo('in');
        foreach ($in->getAllFilenames() as $fileName) {
            $fileTask = new FileTask('data/in/' . $fileName, 'data/out/' . $fileName);
            if ($fileTask->getProcessed() < $fileTask->getLines()) {
                echo "processing $fileName ...\n";
                exec('php process.php ' . $fileName);
            }
        }
    }
    
    public static function processFile() {
        global $argv;
        
        $fileName = $argv[1];
        $checker = new Checker(new HttpClientCurl());
        $task = new FileTask('data/in/' . $fileName, 'data/out/' . $fileName);
        $processor = new FileProcessor($task, $checker);
        $processor->process(function($site, $result) {echo $site, ":\n", $result, "\n";});
    }
    
    public static function runStatic() {
        global $argv;
        
        if (count($argv) <= 1) {
            self::spawnProcesses();
        } else {
            self::processFile();
        }
    }
}

Front_Process::runStatic();