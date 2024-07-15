<?php

/**
 * Default controller class
 */
abstract class Controller
{
    public function __construct() {
        session_start(); //Open a new session each time a controller is created. (Everytime our url change)

        //This array contains all whitelisted pages for non-logged users, every other page not present in this list will automatically redirect to the welcome page.
        $NonLogged_Whitelist = [
            '/welcome',
            '/login',
            '/register'
        ]; 

        //This array contains all blacklisted pages for logged users.
        $Logged_Blacklist = array(
            '/welcome',
            "/login",
            "/register"
        ); 

        if(isset($_SESSION['userId'])) {
            //Our user is logged in his account, check if the current uri is blacklisted
            foreach($Logged_Blacklist as $path) {
                if($_SERVER['REQUEST_URI'] == $path) {
                    //the current uri is blacklisted, redirection to our main page.
                    header('Location: /');
                    break;
                }
            }
        } else {
            //Our user is not logged in any account, check if the current uri is blacklisted
            $whitelisted = false;
            foreach($NonLogged_Whitelist as $path) {
                if($_SERVER['REQUEST_URI'] == $path) {
                    $whitelisted = true;
                    break;
                }
            }
            if($whitelisted == false) {
                //No whitelisted uri match with the current one, redirect to the welcome page.
                header('Location: /welcome');
            }
        }
    }

    /**
     * Called when our controller is called from our router.
     */
    public function index()
    {
        
    }

    /**
     * Will render our View's content inside our base view thank's to our "content" variable
     */
    public function render(string $view, array $data = []) {
        extract($data); //Extract our potential data
        ob_start();
        require_once ROOT . '/views/' . $view . '.php';
        $content = ob_get_clean();
        require_once ROOT . '/views/base.php';
    }
}