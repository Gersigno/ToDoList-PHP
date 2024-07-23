<?php

/**
 * This controller is used to fetch our tasks informations.
 */
class TasksController extends Controller
{
    /**
     * Prevent the user to manually go to /tasks url
     * Will auto-redirect our user to the main page.
     */
    public function index() {
        header("location: /");
    }

    /**
     * Return an array of every tasks owned by the current logged in user.
     */
    public function getAll() {
        //If server request containt XMLHttpRequest header property
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest") {
            $tasks = new Tasks();
            $result = $tasks->getAllTasks();
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(200);
            echo(json_encode($result));
        } else {
            echo("Forbiden");
        }
    }

    /**
     * Will switch the 'done' value of the intended task from 0 to 1 OR 1 to 0.
     * @param Int Intended task ID
     */
    public function switchDone($id) {
        //If server request containt XMLHttpRequest header property
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest") {
            $tasks = new Tasks();
            $tasks->switchDone($id);
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(200);
            echo(json_encode($tasks->isDone($id)));
        } else {
            echo("Forbiden");
        }
    }

    /**
     * Will remove the intended task from the 'tasks' table.
     * The tasks also need to be owned by the current user !
     */
    public function remove($id) {
        //If server request containt XMLHttpRequest header property
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest") {
            $tasks = new Tasks();
            $tasks->remove($id);
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(200);
            echo("1");
        } else {
            echo("Forbiden");
        }
    }

    /**
     * Return the expiration date of the intended task (NULL if no expiration date defined.)
     * The tasks also need to be owned by the current user !
     */
    public function getExpiration($id) {
        //If server request containt XMLHttpRequest header property
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest") {
            $tasks = new Tasks();
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(200);
            echo(json_encode($tasks->getExpiration($id)));
        } else {
            echo("Forbiden");
        }
    }
}