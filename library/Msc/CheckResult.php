<?php
namespace Msc;

class CheckResult
{
    public $isMobile;
    public $reason;
    
    public function __construct($isMobile = false, $reason = 'unkown') {
        $this->isMobile = $isMobile;
        $this->reason = $reason;
    }
    
    public function __toString() {
        return ($this->isMobile? '' : 'not ') . "mobile\n" . $this->reason;
    }
}