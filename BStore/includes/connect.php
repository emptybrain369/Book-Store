<?php

 require 'Query_builder/vendor/autoload.php';
 
 $config = array(
             'driver'    => 'mysql',
             'host'      => 'localhost',
             'database'  => 'bstore',
             'username'  => 'root',
             'password'  => '',
             'charset'   => 'utf8',
             'collation' => '', 
             'prefix'    => '', 
         );
 
 new \Pixie\Connection('mysql', $config, 'QB');
?>

