<?php

class Users extends Model {
    protected const ERROR_INVALID_USERNAME = 'Your username needs to follow these rules : <br> - Cannot contain white spaces <br> - Cannot contain any special characters other than "-", "_" ou "." <br> - Need to be between 3 and 20 characters long.';
    protected const ERROR_DUPLICATED_USERNAME = 'This username is not available!';
    protected const ERROR_REQUIRED = 'This field is required !';
    protected const ERROR_UNKNOW_WHEN_ADDED = 'An error occurred while creating your account, <br>please try again !';
    protected const ERROR_PASSWORD_UNSAFE = 'Your password must be between 8 and 30 characters long, <br>contain a lower case, a capital letter, at least one number <br>and a special character (#?!@$% &*-)';
    protected const ERROR_LOGIN_WRONG_CREDENTIALS = 'Your email and password do not match. <br>Please try again.';

    public function __construct()
    {
        $this->table = 'users';
    }

    /**
     * Attempt to add a new user to our table
     * @param String New username
     * @param String Un-hash password
     * @return String Error message
     */
    public function register($username, $password) {
        //Sanitize our inputs to prevent injections
        $username   = filter_var($username, FILTER_SANITIZE_SPECIAL_CHARS);
        $password   = filter_var($password, FILTER_SANITIZE_SPECIAL_CHARS);

        $reg_username   = '/^[a-zA-Z0-9_.-]{3,20}$/';
        $reg_password   = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$@!%&*?])[A-Za-z\d#$@!%&*?]{8,30}$/';

        // Is username valid ?
        if(preg_match($reg_username, $username)) {
            // Is password valid before hash ?
            if(preg_match($reg_password, $password)) {
                //Does username exists ?
                if(!$this->doesUsernameExists($username)) {
                    //Create our SQL command to insert our user's informations in our user table
                    $sqlInsert = "INSERT INTO users (`username`, `pass_hash`) VALUES (\"" . $username . "\", \"" . password_hash($password, PASSWORD_DEFAULT) . "\")";
                    $this->runQuery($sqlInsert); //Run our SQL command

                    //Finally, we check if our new username exists in our database to make sure our user was added correctly
                    if($this->doesUsernameExists($username)) {
                        //If our newly created account now exists in our table, we redirect our user to the login page
                        header('Location: /login'); 
                    } else {
                        return self::ERROR_UNKNOW_WHEN_ADDED;
                    }
                } else {
                    return self::ERROR_DUPLICATED_USERNAME;
                }
            } else {
                return self::ERROR_PASSWORD_UNSAFE;
            }
        } else {
            return self::ERROR_INVALID_USERNAME;
        }
    }

    /**
     * Attempt to log the current user to the target account
     * @param String Username
     * @param String Un-hash password
     * @return String Error message
     */
    public function login($username, $password) {
        //Sanitize our inputs to prevent injections
        $username   = filter_var($username, FILTER_SANITIZE_SPECIAL_CHARS);
        $password   = filter_var($password, FILTER_SANITIZE_SPECIAL_CHARS);

        $user = $this->findBy(["username" => $username]);
        if(count($user) == 1 && password_verify($password, $user[0]->pass_hash)) {
            $_SESSION['userId'] = $user[0]->id;
            header('Location: /');
        } else {
            return self::ERROR_LOGIN_WRONG_CREDENTIALS;
        }
    }

    /**
     * Does this username exists in the user table.
     * @return bool Does username exists ?
     */
    private function doesUsernameExists($username) {
        $exists = true;
        count($this->findBy(["username" => $username])) == 0 ? $exists = false : $exists = true;
        return $exists;
    }

    /**
     * Return the user's username corresponding to the target user id.
     */
    public function getUsername($id) {
        return $this->findById($id)->username;
    }
}