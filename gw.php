<?php
namespace Msc;

include 'bootstrap.php';

/**
 * front controller for web application
 */
class Front_Gw
{
    public static function runStatic() {
        $tc = new TaskController(new FileRepo("in"), new FileRepo("out"), $_REQUEST);
        switch (@$_REQUEST['a']) {
            case 'upload' :
                $result = $tc->actionUpload();
                break;
            case 'remove' :
                $result = $tc->actionRemove();
                break;
            default :
                $result = $tc->actionFullList();
        }

        echo $result;
    }
}

Front_Gw::runStatic();