<?php
namespace Msc;

require_once MSC_LIB . '/HttpResult.php';
require_once MSC_LIB . '/CheckResult.php';
require_once MSC_LIB . '/HttpClientInterface.php';
require_once MSC_LIB . '/Exception.php';

class Checker
{
    const UA_DESKTOP = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:9.0) Gecko/20100101 Firefox/9.0';
    const UA_MOBILE = 'Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_3_2 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8H7 Safari/6533.18.5';
    
    /**
     * @var HttpClientInterface
     */
    protected $_client;

    /**
     * @var boolean
     */
    protected $_debug;
    
    public function __construct(HttpClientInterface $client, $debug = false)
    {
        $this->_client = $client;
        $this->_debug = $debug;
    }
    
    /**
     * @param string $url
     * @return CheckResult
     */
    public function check($url) {
        $results = array();
        $this->_client->setFollow(false);
        $results[] = $this->_client->get($url, self::UA_MOBILE);
        $results[] = $this->_client->get($url, self::UA_DESKTOP);

        if ($this->_debug) {
            print_r($results);
        }
        
        $result = new CheckResult();
        
        if ($results[0]->code != $results[1]->code) {
            return new CheckResult(true, 'different codes: ' . $results[0]->code . ' and ' . $results[1]->code);
        }
        
        // if both are redirects
        if (substr($results[0]->code, 0, 1) == '3') {
            if ($results[0]->getRedirectLocation() == $results[1]->getRedirectLocation()) {
                // if both have same redirection, then follow till the end and continue analysing
                $this->_client->setFollow(true);
                $results = array();
                $results[] = $this->_client->get($url, self::UA_MOBILE);
                $results[] = $this->_client->get($url, self::UA_DESKTOP);
                
                if ($this->_debug) {
                    print_r($results);
                }
                
                if ($results[0]->effectiveUrl != $results[1]->effectiveUrl) {
                    return new CheckResult(true, 'different final locations');
                }
            } else {
                return new CheckResult(true, 'different redirections ' . $results[0]->getRedirectLocation() . ' | ' . $results[1]->getRedirectLocation() );
            }
        }
        
        for ($i = 0; $i < count($results); $i++) {
            if ($results[$i]->code >= 400) {
                return new CheckResult(false, 'http response ' . $results[$i]->code);
            }
        }
        
        if (!$this->compareStyles($results[0]->content, $results[1]->content)) {
            return new CheckResult(true, 'different styles');
        }
        
        return new CheckResult(false, 'none of tests matched');
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