<?php

/**
 * This is our main controller.
 */
class HomeController extends Controller
{
    public function index()
    {    
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tasks = new Tasks();
            if(array_key_exists("task_id", $_POST)) {
                //If our post method come from the Edit panel
                $_POST = filter_input_array(INPUT_POST, [
                    'task_id' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                    'title' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                    'desc' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                    'edittask_use_expire' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                    'expiration' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
                ]);
        
                $task_id = $_POST['task_id'] ?? '';
                $task_title = $_POST['title'] ?? '';
                $task_description = $_POST['desc'] ?? '';
                $task_expiration = $_POST['edittask_use_expire'] ? $_POST['expiration'] : '';
        
                //Check if our task's id, title and description are not empty, the expiration date can be empty
                if(isset($task_id) && isset($task_title) && isset($task_description)) {
                    $tasks->editTask($task_id, $task_title, $task_description, $task_expiration);
                    header("Location: /");
                }
            } else {
                //If our post method come from the Create panel
                $_POST = filter_input_array(INPUT_POST, [
                    'title' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                    'desc' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                    'newtask_use_expire' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                    'expiration' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
                ]);
        
                $task_title = $_POST['title'] ?? '';
                $task_description = $_POST['desc'] ?? '';
                $task_expiration = $_POST['newtask_use_expire'] ? $_POST['expiration'] : '';
        
                //Check if our task's title and description are not empty, the expiration date can be empty
                if(isset($task_title) && isset($task_description)) {
                    $tasks->createNewTask($task_title, $task_description, $task_expiration);
                    header("Location: /");
                }
            }
        }
        
        $additionalStyles = [
            "./styles/tasks.css"
        ];

        $this->render('home/base', ['additionalStyles' => $additionalStyles]);
    }
}