<?php
class Msc_HttpResult
{
    public $content;
    public $code;
    public $header;
    public $effectiveUrl;
    
    public function __construct($content, $code = 200, $header = '', $effectiveUrl = null) {
        $this->content = $content;
        $this->code = $code;
        $this->header = $header;
        $this->effectiveUrl = $effectiveUrl;
    }
    
    public function getRedirectLocation() {
        if ($this->code < 300 || $this->code >= 400) return false;
        $r = preg_match('/^Location\s*:\s*(.+)$/mxi', $this->header, $matches);
        if (!$r) {
            throw new Msc_Exception('redirection response has no Location header');
        }
        return trim($matches[1]);
    }
}