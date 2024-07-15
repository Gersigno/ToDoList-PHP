<?php

/**
 * Constructor called whenever our user request the url "/login"
 */
class LoginController extends Controller
{
    public function index()
    {
        $ERROR_REQUIRED = 'This field is required !';

        $errors = [
            'username' => '',
            'password' => ''
        ];

        $message = '';

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $_POST = filter_input_array(INPUT_POST, [
                'username' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                'password' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
            ]);

            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if(!$username) {
                $errors['username'] = $ERROR_REQUIRED;
            }
            if(!$password) {
                $errors['password'] = $ERROR_REQUIRED;
            }

            if($username && $password) {
                $users = new Users();
                $message = $users->login($username, $password);
            }
        }
        $additionalStyles = [
            "./styles/welcome/base.css"
        ];
        $this->render("welcome/login", [
            'additionalStyles' => $additionalStyles,
            'errors' => $errors,
            'message' => $message
        ]);
    }
}