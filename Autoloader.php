<?php

/**
 * This class contains everything we need to automatically load our files without having to include them.
 */
class Autoloader {

    /**
     * This function initialize our autoloader by adding our
     */
    static function register(){
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * Include our class' file
     * @param $class string Class' name intended to be loaded
     */
    static function autoload($class){
        $directory = array(
            'core\\', 
            'models\\', 
            'controllers\\'
        ); //A list (array) of all of our folders that should be check by our autoloader to find our files.

        $root = dirname($_SERVER['DOCUMENT_ROOT']); //Define a root variable witch contain our root directory's path.
        $found = false; //This variable will be used to check if our file was found in one of our folders.
        $file; //This variable will store our possible file path if it was found in one of our folders.
        foreach ($directory as $current_dir)
        {
            if(file_exists($root . "/" .  $current_dir . $class . '.php')) { //If our file exist in the current directory
                $found = true; //Set the found state to true
                $file = $root . "/" .  $current_dir . $class . '.php'; //Set the file's path
                break; //Then break our foreach
            }
        }
        if($found) {
            //If our file was found, we include it with require_once.
            require_once $file;
        } else {
            //If our file wasn't found in any of our folders
            echo("Error : File not found !");
        }
    }
}