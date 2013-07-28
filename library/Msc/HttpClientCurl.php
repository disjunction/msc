<?php
class Msc_HttpClientCurl implements Msc_HttpClientInterface
{
    protected $_curlOpts = array(
                    CURLOPT_REFERER => "http://traffic.comboapp.com/apps/traffrouter/",
                    CURLOPT_HTTPHEADER => array("Content-Type:application/x-www-form-urlencoded"),
                    CURLOPT_FOLLOWLOCATION => false,
                    CURLOPT_HEADER => true,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_MAXREDIRS => 5);
    
    public function setFollow($value)
    {
        $this->_curlOpts[CURLOPT_FOLLOWLOCATION] = $value;
    }
    
    /**
     * @param string $url
     * @throws Tr_DriverException
     * @return curl handle
     */
    public function makeCurl()
    {
        $ch = curl_init();
        foreach ($this->_curlOpts as $key => $val) {
            curl_setopt($ch, $key, $val);
        }
        return $ch;
    }
    
    public function get($url, $agent) {
        $ch = $this->makeCurl();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        $result = curl_exec($ch);
        
        if (curl_errno($ch)) {
            $message = 'CURL ERROR: ' . curl_error($ch) . '; url=' . $url;
            throw new Msc_Exception($message);
        }
        
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = trim(substr($result, 0, $headerSize));
        $content = trim(substr($result, $headerSize));
        return new Msc_HttpResult($content, curl_getinfo($ch, CURLINFO_HTTP_CODE), $header);
    }
}