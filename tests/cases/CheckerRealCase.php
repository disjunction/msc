<?php
namespace Msc;

class Test_CheckerRealCase extends \PHPUnit_Framework_TestCase
{
    public function testSameStyles() {
        $checker = new Checker(new HttpClientCurl());
        $this->assertEquals(false, $checker->check('http://local.pluseq.com/msc/tests/sites/same_styles.html')->isMobile);
    }
    
    public function testSameRedirect() {
        $checker = new Checker(new HttpClientCurl());
        $this->assertEquals(false, $checker->check('http://local.pluseq.com/msc/tests/sites/same_redirect.php')->isMobile);
    }
    
    public function testUsualAndRedirect() {
        $checker = new Checker(new HttpClientCurl());
        $this->assertEquals(true, $checker->check('http://local.pluseq.com/msc/tests/sites/usual_and_redirect.php')->isMobile);
    }
    
    public function testDifferentRedirects() {
        $checker = new Checker(new HttpClientCurl());
        $this->assertEquals(true, $checker->check('http://local.pluseq.com/msc/tests/sites/different_redirects.php')->isMobile);
    }
}