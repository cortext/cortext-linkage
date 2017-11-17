<?php

/**
 * Manage the linkage between datasets
 *
 * @author Philippe Breucker
 * @version 1 - 2017-11
 */

class Linker{
    public function __construct($dataSource){
        $this->log("linker for $dataSource created");
    }

    public function link(){
        $this->log("linking in progress...");
    }

    public function log($message){
        echo "\n<br><pre>".$message."</pre>"; //todo use a real logger
    }
}