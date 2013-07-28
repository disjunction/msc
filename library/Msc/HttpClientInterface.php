<?php
interface Msc_HttpClientInterface
{
    /**
     * 
     * @param string $url
     * @param string $agent
     * @return Msc_HttpResult
     */
    public function get($url, $agent);
}