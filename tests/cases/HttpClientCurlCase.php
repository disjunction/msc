<?php
namespace Msc;

class Test_HttpClientCurl extends \PHPUnit_Framework_TestCase
{
    public function testGetContent() {
        $client = new HttpClientCurl();
        $response = $client->get('http://local.pluseq.com/msc/tests/sites/same_styles.html', 'some');
        $this->assertGreaterThan(0, strlen($response->content));
        $this->assertGreaterThan(0, strlen($response->header));
        $this->assertEquals(200, $response->code);
    }
    
    public function testRedirectPage() {
        $client = new HttpClientCurl();
        $response = $client->get('http://local.pluseq.com/msc/tests/sites/same_redirect.php', 'some');
        $this->assertGreaterThan(0, strlen($response->content));
        $this->assertGreaterThan(0, strlen($response->header));
        $this->assertEquals(302, $response->code);
        $this->assertEquals('same_styles.html', $response->getRedirectLocation());
    }
}