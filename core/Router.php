<?php


/**
 * Our router's class
 */
class Router
{
    /**
     * Redirect our user to our error page
     */
    private function Redirect_Unknown() {
        http_response_code(404);
    }

    /**
     * Remove any / at the end of the url
     * @param $request_uri target url
     */
    private function trailing($request_uri) {
        if (!empty($request_uri) && $request_uri != "/" && $request_uri[-1] === "/") {
            //If our uri is not emptry and endup with an '/'
            $request_uri = substr($request_uri, 0, -1); //Remove our last character, aka our / from our uri
            http_response_code(301); //send http response code 301 (premanent url redirection)
            header('Location: ' . $request_uri); //Set the current location to our new uri
        }
        return $request_uri; //Then, return our new url
    }

    /**
     * Our class' constructor magic function, automatically called whenever our class is instanced.
     */
    public function __construct() {
        $uri = $this->trailing($_SERVER['REQUEST_URI']); //Remove any "/" at the end of our request url
        
        $params = explode('/', $_GET['p']); //split our url into an array of parameters for sub pages
        
        if ($params[0] != '') {
            //We have at least one parameter
            $fileController = ROOT . '/Controllers/' . ucfirst($params[0]) . 'Controller.php'; //Build our target controller file's full path
            if (file_exists($fileController)) {
                //if the controller's file exists, we can create a new instance of it :
                $controller = ucfirst(array_shift($params)) . 'Controller'; //Build our target constoller's name
                $controller = new $controller(); //Create an instance of our page's controller

                //If the requested uri contains more params and the first param is not "index" (which is our default rending function for our controllers.)
                $action = (isset($params[0])) ? array_shift($params) : 'index';
                
                if (method_exists($controller, $action)) {
                    //Try to call any function in our controller that match with the first param's name, and use every other params as our fonction's parameters.
                    (isset($params[0])) ? call_user_func_array([$controller, $action], $params) : $controller->$action();
                } else {
                    $this->Redirect_Unknown();
                }
            } else {
                //If our controller's file doesn't exists. we redirect our user to our error page.
                $this->Redirect_Unknown();
            }
        } else {
            //No parameters, we are in our main page.
            $controller = new HomeController(); //Create a new instance of our MainController.
            $controller->index(); //Then, we call the index function of our MainController.
        }
    }
}