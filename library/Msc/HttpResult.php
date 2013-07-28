<?php
class Msc_HttpResult
{
    public $content;
    public $code;
    public $header;
    public function __construct($content, $code = 200, $header = '') {
        $this->content = $content;
        $this->code = $code;
        $this->header = $header;
    }
}