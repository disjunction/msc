<?php
include 'bootstrap.php';

class Front_Gw
{
    public function run() {
        $in = new Msc_FileRepo("in");
        $out = new Msc_FileRepo("out");
        $tc = new Msc_TaskController($in, $out);
        echo $tc->actionFullList();
    }

    public static function runStatic() {
        $o = new self();
        $o->run();
    }
}

Front_Gw::runStatic();