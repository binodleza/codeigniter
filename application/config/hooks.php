<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/*$hook['pre_controller'] = array(
    'class' => 'Lawyer',
    'function' => 'getHook',
    'filename' => 'Lawyer.php',
    'filepath' => 'hooks',
    'params' => array('element1', 'element2', 'element3')
);*/

/*$hook['pre_controller'] = array(
    'class' => 'Exm',
    'function' => 'tut',
    'filename' => 'exm.php',
    'filepath' => 'hooks',
    'params' => array('element4', 'element5', 'element6')
);*/

$hook['post_controller'] = array(
    'class'    => 'Blocker',
    'function' => 'requestBlocker',
    'filename' => 'Blocker.php',
    'filepath' => 'hooks',
    'params'   => ""
);

