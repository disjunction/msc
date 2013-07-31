<?php
namespace Msc;

class FileTask
{
    protected $_inColumn;
    protected $_outColumn;
    
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
    
    /**
     * presents the task ready for json encoding and passing to client side
     * @return assoc
     */
    public function toArray() {
        return array(
            'file' => $this->getBaseName(),
            'lines' => $this->getLines(),
            'processed' => $this->getProcessed()
        );
    }
    
    protected function _parseColumns() {
        $f = @fopen($this->outfile, "r");
        if (!$f) {
            throw new Exception("cant read " . $this->outfile);
        }
        $row = fgetcsv($f);
        if (!$row) {
            throw new Exception("failed to read first line in " . $this->outfile);
        }
        for ($i = 0; $i < count($row); $i++) {
            strstr($row[$i], '(in)') and $this->_inColumn = $i;
            strstr($row[$i], '(out)') and $this->_outColumn = $i;
        }
        if ($this->_inColumn === null || $this->_outColumn === null) {
            throw new Exception("first linke doesnt contain in/out markers in " . $this->outfile);
        } 
    }
    
    /**
     * @return int
     */
    public function getInColumn() {
        null === $this->_inColumn and $this->_parseColumns();
        return $this->_inColumn;
    }

    /**
     * @return int
     */
    public function getOutColumn() {
        null === $this->_outColumn and $this->_parseColumns();
        return $this->_outColumn;
    }
}