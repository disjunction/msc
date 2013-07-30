<?php
namespace Msc;

interface HttpClientInterface
{
    /**
     * @param string $url
     * @param string $agent
     * @return Msc_HttpResult
     */
    public function setFollow($follow);
    
    /**
     * @param string $url
     * @param string $agent
     * @return Msc_HttpResult
     */
    public function get($url, $agent);
}