<?php

define('ROOT', dirname(__DIR__)); //Defile a "ROOT" constant with our current folder's parent path as a value.

require_once ROOT . '/Autoloader.php'; //Include our Autoloader file (required)
Autoloader::register(); //Call our register function which will initialize our autoloader

new Router(); //Then, create an instance of our router
