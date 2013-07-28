<?php
require_once MSC_LIB . '/HttpResult.php';
require_once MSC_LIB . '/CheckResult.php';
require_once MSC_LIB . '/HttpClientInterface.php';

class Msc_Checker
{
    const UA_DESKTOP = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:9.0) Gecko/20100101 Firefox/9.0';
    const UA_MOBILE = 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_3_2 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8H7 Safari/6533.18.5';
    
    /**
     * @var Msc_HttpClientInterface
     */
    protected $_client;
    
    public function __construct(Msc_HttpClientInterface $client)
    {
        $this->_client = $client;
    }
    
    
    
    /**
     * @param string $url
     * @return Msc_CheckResult
     */
    public function check($url) {
        $results = array();
        $results[] = $this->_client->get($url, self::UA_MOBILE);
        $results[] = $this->_client->get($url, self::UA_DESKTOP);
        
        $result = new Msc_CheckResult();
        
        if (!$this->compareStyles($results[0]->content, $results[1]->content)) {
            return new Msc_CheckResult(true, 'different styles');
        }
        
        return new Msc_CheckResult(false, 'none of tests matched');
    }
    
    public function collectStyles($content) {
        $result = array();
        $r = preg_match_all('/<link[^>]*rel\s*=\s*"?stylesheet.*>/Umsi', $content, $matches);
        if ($r) {
            foreach ($matches[0] as $match) {
                $r = preg_match('/href\s*=\s*"?([^?">\s]+)/msi', $match, $styleMatch);
                if ($r) {
                    $result[] = $styleMatch[1];
                }
            }
        }
        sort($result);
        return $result;
    }
    
    public function compareStyles($content1, $content2) {
        $styles1 = $this->collectStyles($content1);
        $styles2 = $this->collectStyles($content2);
        return $styles1 == $styles2;
    }
}