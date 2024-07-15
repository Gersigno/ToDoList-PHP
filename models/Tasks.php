<?php

class Tasks extends Model {
    public function __construct() {
        $this->table = 'tasks';
    }

    /**
     * Return an array of task objects owned by the current connected user.
     */
    public function getAllTasks() {
        return array_reverse($this->findBy(['owner_id' => $_SESSION['userId']]));
    }

    /**
     * Insert our new task in our database's table "tasks"
     * @param String Task's new Title. (Required)
     * @param String Tasks' new description (Required)
     * @param String Date-Time type formated string, empty for null.
     */
    public function createNewTask($title, $description, $expiration) {
        $expiration == "" ? $expiration = "NULL" : $expiration = "\"" . str_replace("T", " ", $expiration) . "\"";
        $this->runQuery("INSERT INTO `$this->table` (`owner_id`, `title`, `description`, `done`, `creation_date`, `expiration_date`) VALUES (" . $_SESSION['userId'] . ", \"$title\", \"$description\", 0, \"" . date_create('now')->format('y-m-d H:i:s') . "\", $expiration)");
    }

    /**
     * Update the intended task's informations.
     * @param Int Task's id. (Required)
     * @param String Task's new Title. (Required)
     * @param String Tasks' new description (Required)
     * @param String Date-Time type formated string, empty for null.
     */
    public function editTask($task_id, $task_title, $description, $expiration) {
        $expiration == "" ? $expiration = "NULL" : $expiration = "\"" . str_replace("T", " ", $expiration) . "\"";
        $this->runQuery("UPDATE `$this->table` SET `title`=\"" . $task_title . "\", `description`=\"" . $description . "\", `expiration_date`=$expiration WHERE `id`=" . $task_id . " AND `owner_id`=" . $_SESSION['userId'] . ";");
    }

    /**
     * Will switch the "Done" status of the target task.
     * @param Int Target task's ID.
     */
    public function switchDone($id) {
        $status = $this->isDone($id);
        $status == 0 ? $status = 1 : $status = 0;
        $this->runQuery("UPDATE `$this->table` SET `done` = '$status' WHERE `id` = $id AND `owner_id` = " . $_SESSION['userId'] . ";");
    }

    /**
     * Remove the target task from the database
     * @param Int Target task's ID.
     */
    public function remove($id) {
        $this->runQuery("DELETE FROM `$this->table` WHERE `id` = $id AND `owner_id` = " . $_SESSION['userId'] . ";");
    }

    /**
     * Return the "done" status of the target task.
     * @param Int Target task's ID.
     * @return Int 0 or 1 
     */
    public function isDone($id) {
        return $this->findById($id)->done;
    }
}