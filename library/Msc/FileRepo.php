<?php
namespace Msc;

class FileRepo
{
    public $dir;
    public $fullDir;
    protected static $_instance = null;
    
    public function __construct($dir) {
        $this->dir = $dir;
        $this->fullDir = MSC_ROOT . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . $dir;
    }
    
    public function getContentByFilename($filename) {
        $full = $this->fullDir . DIRECTORY_SEPARATOR . $filename;
        if (!file_exists($full)) {
            throw new Exception('file not found: ' . $full);
        }
        return file_get_contents($full);
    }
    
    /**
     * @return multitype:string
     */
    public function getAllFilenames() {
        $files = scandir($this->fullDir);
        $result = array();
        foreach ($files as $file) substr($file, 0, 1) != '.' && $result[] = $file;
        return $result;
    }
    
    public function remove($file) {
        $fullFilename = $this->fullDir . DIRECTORY_SEPARATOR . $file;
        file_exists($fullFilename) && unlink($fullFilename);
    }
    
    public function upload($details) {
        $destination = $this->fullDir . DIRECTORY_SEPARATOR . basename($details['name']);
        move_uploaded_file($details['tmp_name'], $destination);
    }
}