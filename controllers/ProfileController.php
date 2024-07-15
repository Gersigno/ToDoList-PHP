<?php

/**
 * This is our main controller.
 */
class ProfileController extends Controller
{
    public function index()
    {    
        $users = new Users();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //If our request method is POST.

            //Filter all our inputs to prevents injections.
            $_POST = filter_input_array(INPUT_POST, [
                'current_pass' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                'new_pass' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                'new_pass-retype' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                'set_newpass' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
            ]);

            $current_pass = $_POST['current_pass'] ?? '';
            $new_pass = $_POST['new_pass'] ?? '';
            $new_pass_retype = $_POST['new_pass-retype'] ?? '';

            $reg_password = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$@!%&*?])[A-Za-z\d#$@!%&*?]{8,30}$/';

            //If non of our inputs are empty.
            if($current_pass != '' && $new_pass != '' && $new_pass_retype != '') {
                if($new_pass == $new_pass_retype) {
                    if(preg_match($reg_password, $new_pass)) { 
                        if(password_verify($current_pass, $users->findById($_SESSION['userId'])->pass_hash)) {
                            //Our inputs data match our requirements, we can now update the stored hashed password to the new one.
                            $users->runQuery("UPDATE `users` SET `pass_hash` = '" . password_hash($new_pass, PASSWORD_DEFAULT) . "' WHERE `id` = " . $_SESSION['userId'] . ";");
                            $_SESSION['profile_msg'] = "✅ Profile updated !";
                            header('Location: /profile'); 
                        } else {
                            $_SESSION['profile_error_msg'] = "Incorrect password !";
                        }
                    } else {
                        $_SESSION['profile_error_msg'] = "Your password must be between 8 and 30 characters long, <br>contain a lower case, a capital letter, at least one number <br>and a special character (#?!@$% &*-)";
                    }
                } else {
                    $_SESSION['profile_error_msg'] = "Please enter the same password !";
                }
            } else {
                $_SESSION['profile_error_msg'] = "Please fill every inputs !";
            }
        }

        $username = $users->getUsername($_SESSION['userId']);

        $additionalStyles = [
            "./styles/profile.css"
        ];
        
        $this->render('profile/base', ['additionalStyles' => $additionalStyles, 'username' => $username]);
    }

    /**
     * Attempt to delete the current account and all tasks associated with it.
     */
    public function deleteMyAccount() {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest") {
            //If server request containt XMLHttpRequest header property
            $tasks = new Tasks();
            $tasks->runQuery("DELETE FROM `tasks` WHERE `owner_id` = " . $_SESSION['userId'] . ";");
            if(count($tasks->getAllTasks()) == 0) {
                $users = new Users();
                $users->runQuery("DELETE FROM `users` WHERE `id` = " . $_SESSION['userId'] . ";");
                if(count($users->findBy(['id' => $_SESSION['userId']])) == 0) {
                    echo("1");
                } else {
                    echo("0");
                }
            } else {
                echo("0");
            }
        } else {
            echo("Forbiden");
        }
    }
}