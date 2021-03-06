<?php
namespace Msc;

class Mock_HttpClient implements HttpClientInterface
{
    protected $_results = array();
    
    public function __construct($filename) {
        $str = file_get_contents(__DIR__ . '/../data/' . $filename);
        $parts = explode('===', $str);
        foreach ($parts as $part) {
            $this->_results[] = new HttpResult(trim($part));
        }
    }
    
    public function get($url, $agent) {
        return strstr($agent, 'Mobile')? $this->_results[1] : $this->_results[0];
    }
    
    public function setFollow($follow) {}
}