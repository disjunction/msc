<?php
namespace Msc;

class FileProcessor
{
    /**
     * @var FileTask
     */
    protected $_task;
    
    /**
     * @var Checker
     */
    protected $_checker;
    
    public function __construct(FileTask $task, Checker $checker) {
        $this->_task = $task;
        $this->_checker = $checker;
    }
    
    /**
     * @param Function $callback
     */
    public function process($callback = null) {
        $task = $this->_task;
        
        $in = fopen($task->infile, 'r');
        $markers = fgetcsv($in);
        
        $out = fopen($task->outfile, 'w');
        fputcsv($out, $markers);
        fflush($out);
        
        while ($line = fgetcsv($in)) {
            try {
                $site = $line[$task->getInColumn()];
                $result = $this->_checker->check($site);
                
                if ($callback) {
                    call_user_func($callback, $site, $result);
                }
                
                $line[$task->getOutColumn()] = $result->getStatus();
                fputcsv($out, $line);
            } catch (Exception $e) {
                error_log('something happened while processing: ' . var_export($line, true));
                $line[$task->getOutColumn()] = "error";
                fputcsv($out, $line);
            }
        }
    }
}