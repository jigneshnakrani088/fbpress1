<?php
session_start();
require_once 'lib/facebook/facebook.php';
$facebook = new facebook(array(						 //	JigsApp								demo
	'appId'  => '1523273831269396',   				 // 815325925197979  					1523273831269396
	'secret' => '05e1d394341cb408eda496cd4d174a4f',  // e6dcecf8b128ca7dcbd5b2a3797c0661   	05e1d394341cb408eda496cd4d174a4f
    'cookie'    => true
));
?>