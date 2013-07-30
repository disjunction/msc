<?php
class Msc_FileTask
{
    public $infile;
    public $outfile;
    protected $_lines;
    protected $_processed;
    
    public function __construct($infile, $outfile) {
        $this->infile = $infile;
        $this->outfile = $outfile;
    }
    
    public function getBaseName() {
        return basename($this->infile);
    }
    
    public function isFinished() {
        return $this->lines == $this->processed;
    }
    
    protected function _countLines($file) {
        $linecount = 0;
        
        $handle = @fopen($file, "r");
        if (!$handle) {
            return -1;
        }
        
        while(!feof($handle)){
            fgets($handle);
            $linecount++;
        }
        fclose($handle);
        return $linecount;
    }
    
    public function getLines() {
        return $this->_countLines($this->infile);
    }
    
    public function getProcessed() {
        return $this->_countLines($this->outfile);
    }
    
    public function toArray() {
        return array(
            'file' => $this->getBaseName(),
            'lines' => $this->getLines(),
            'processed' => $this->getProcessed()
        );
    }
}