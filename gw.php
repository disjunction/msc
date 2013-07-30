<?php
namespace Msc;

include 'bootstrap.php';

class Front_Gw
{
    public function run() {
        $in = new FileRepo("in");
        $out = new FileRepo("out");
        $tc = new TaskController($in, $out);
        echo $tc->actionFullList();
    }

    public static function runStatic() {
        $o = new self();
        $o->run();
    }
}

Front_Gw::runStatic();