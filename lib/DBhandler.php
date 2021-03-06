<?php

/**
 * Manage database (for now Sqlite3)
 *
 * @author Philippe Breucker
 * @version 1 - 2017-11
 */

Class DBHandler{
    private $db;
    private $databaseName;

    /**
     * constructor
     */
    public function __construct(){
        $this->dbConnect();
    }

    /**
     * returns the db instance
     */
    public function getDB(){
        return $this->db;
    }

    /**
    * query wrapper
    */
    public function query($query){
        return $this->db->query($query);
    }

    /**
    * create a new database (for now Sqlite without password)
    */
    private function dbConnect(){
        $this->databaseName = date("Ymd-His")."-".uniqid().'.db';
        $this->db = new PDO("sqlite:".dirname(__FILE__)."/../data/".$this->databaseName);
    }
}