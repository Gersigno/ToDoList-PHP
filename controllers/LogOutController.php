<?php

/**
 * Controller called whenever our user request the url "/logout"
 * This controller will call on construct the index function which will destroy the current session and redirect our user to the home controller
 */
class LogOutController extends Controller
{
    public function index()
    {
        $_SESSION = array(); //Empty the current session
        session_destroy(); //Then destroy it
        header('Location: /'); //Finally, redirect to the root page, the root page should then redirect our user to the welcome page because there is no active session anymore.
    }
}