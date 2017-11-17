<?php

/**
 * Manage the global operations for the Dataset Linkage Module
 *
 * @author Philippe Breucker
 * @version 1 - 2017-11
 */

require "Linker.php";
require "Matcher.php";
require "Importer.php";


class DLM{
    public $matcher;
    public $linker;
    public $dataSource;
    private $matches;
    private $db; //todo add a real db engine

    public function __construct($matcherParams, $dataSource, &$db){
        $this->db = $db;
        $this->matcher = new Matcher($matcherParams,$db);
        $this->linker = new Linker($dataSource,$db);
        $this->importer = new Importer($db);
        $this->dataSource = $dataSource;
        $this->log("DLM created");
        $this->log(print_r($this, true));
    }

    public function importRefData($source){
        //importing data into db
        $this->log("importing ref: $source...");
        $res = $this->importer->importCsv($source);
        $this->log("import finished : \n".print_r($res, true));

    }

    public function importExternalData($source){
        //importing data into db
        $this->log("importing external: $source...");
        $res = $this->importer->importCsv($source);
        $this->log("import finished : \n".print_r($res, true));

    }

    public function match(){
        $this->log("matching");
        $this->matcher->createMatching();
        $this->matches = $this->matcher->run();
    }

    public function link(){
        $this->linker->link();
    }

    public function displayMatches()
    {
        echo "<h1>List of matches found</h1>";
        print_r($this->matches);
    }

    public function log($message){
        echo "\n<pre>[dlm] ".$message."</pre>"; //todo use a real logger
    }
}