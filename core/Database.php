<?php

/**
 * This class extend from PDO, it will be used to connect our client to our database.
 */
class Database extends PDO
{
    private static $instance;
    
    private const db_host = 'localhost'; //database's host
    private const db_name = 'ToDoList-PHP'; //database's name

    private const dbuser = 'todolist_manage'; //database account's name
    private const dbpass = 'YOUR_PASSWORD_HERE'; //database account's password

    /**
     * Our class' construct function
     */
    public function __construct()
    {
        $database = 'mysql:host=' . self::db_host . ';dbname=' . self::db_name;
        try {
            parent::__construct($database, self::dbuser, self::dbpass); //Call PDO's class constructor.

            //Set some PDO's paramaters.
            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8'); 
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } 
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * Return the instance of the current class, it creates it automatically if it doesn't exist already.
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}