<?php
/**
 * Constructor called whenever our user request the url "/welcome"
 * This page is the default page for every non-logged users.
 */
class WelcomeController extends Controller
{
    public function index()
    {
        $additionalStyles = [
            "./styles/welcome/base.css"
        ];
        $this->render("welcome/base", ['additionalStyles' => $additionalStyles]);
    }
}