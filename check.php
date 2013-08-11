<?php
namespace Msc;

include 'library/bootstrap.php';

class Front_Check
{
    public function run() {
        header('Content-Type: text/plain; charset=utf8');
        
        if (!isset($_GET['s'])) {
            die('0 missing parameter s');
        }
        
        $url = $_GET['s'];
        $checker = new Checker(new HttpClientCurl(), @$_GET['debug']);
        
        try {
            die($checker->check($url));
        } catch (Exception $e) {
            die("not mobile\nsite unavailable: " . $e->getMessage());
        } catch (\Exception $e) {
            die('not mobile\nunexpected exception :(');
        }
        
    }
    
    public static function runStatic() {
        $o = new self();
        $o->run();
    }
}

Front_Check::runStatic();