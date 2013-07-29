<?php
include 'bootstrap.php';

class Front_Check
{
    public function run() {
        header('Content-Type: text/plain; charset=utf8');
        
        if (!isset($_GET['s'])) {
            die('0 missing parameter s');
        }
        
        $url = $_GET['s'];
        if (substr($_GET['s'], 0, 4) != 'http') {
            $url = 'http://' . $url;
        }
        
        $checker = new Msc_Checker(new Msc_HttpClientCurl(), @$_GET['debug']);
        
        try {
            $result = $checker->check($url);
            die($result . ' ' . $result->reason);
        } catch (Msc_Exception $e) {
            die('0 site unavailable: ' . $e->getMessage());
        } catch (Exception $e) {
            die('0 unexpected exception :(');
        }
        
    }
    
    public static function runStatic() {
        $o = new self();
        $o->run();
    }
}

Front_Check::runStatic();