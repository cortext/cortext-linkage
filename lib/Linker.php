<?php

/**
 * Manage the linkage between datasets
 *
 * @author Philippe Breucker
 * @version 1 - 2017-11
 */

class Linker{

    /**
     * constructor
     */
    public function __construct($dataSource){
        $this->log("linker for $dataSource created");
    }

    /**
     * linking
     */
    public function link(){
        $this->log("linking in progress...");
    }

    /**
     * logging
     */
    public function log($message){
        echo "\n<br><pre>".$message."</pre>"; //todo use a real logger
    }
}