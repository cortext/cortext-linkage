<?php

/**
 * Manage the matching operations of the DLM
 *
 * @author Philippe Breucker
 * @version 1 - 2017-11
 */

class Matcher{
    private $db;
    private $matchingParams = array(
        'matchingAlgorithm'=>'exactMatch', 
        'refFieldToMatch'=>'entitycurrentname',
        'externalFieldToMatch' =>'name',
        'externalTable'=>'demoExternal', 
        'refTable'=>'demoRef',
        'refIdField'=>'entityid'
        );
    private $matches;

    /**
     * constructor
     */
    public function __construct($matchingParams = null, $db){
        $this->log("matcher created");
        if($matchingParams != null) { 
            $this->matchingParams = $matchingParams;
        }
        $this->db = $db;
        $this->log("matcher object created");
    }

    /**
    * matching creation 
    */
    public function createMatching(){
        //creating a new match with a uniq id
        $this->uid = 'matching'.uniqid(); //todo insert new matching in db and store the id

        $res = $this->db->query("CREATE TABLE ".$this->uid. "('ExternalName', 'Matches');");
        if($res===false){
            $this->log('problem with table creation: '. print_r($this->db->errorInfo()));
            return false;
        }
            
        $this->log("Matching $this->uid created.".var_dump($res));
    }

    /**
    * run the match algorithm 
    */
    public function run(){
        $this->log("matching ".$this->matchingParams['matchingAlgorithm']." in progress...");
        switch ($this->matchingParams['matchingAlgorithm']) {
            case 'exactMatch':
                $this->matcher_exactMatch();
            break;

            default:
                trigger_error("no matching method recognized", E_USER_ERROR);
                break;
        }
    }

    /**
    * Match algorithm : exact match 
    */
    private function matcher_exactMatch(){
        //extracting params
        extract($this->matchingParams);

        //select name to match and prepare search query
        $this->log("[exactMatch] Executing : SELECT `$externalFieldToMatch` FROM $externalTable");
        $externalListRes = $this->db->query("SELECT `$externalFieldToMatch` FROM $externalTable");
        $externalList=$externalListRes->fetchAll();
        $this->log("[exactMatch] external list:".count($externalList)." lines");
        //$matchQuery = $this->db->prepare("SELECT `$refIdField` FROM $refTable WHERE $refFieldToMatch LIKE '%:needle%'");
        //$matchQuery->bindParam(":needle",$needle);

        foreach ( $externalList as $row) {
            //searching matches
            $needle=$row[$externalFieldToMatch];
            $this->log("[exactMatch] matching : [SELECT `$refIdField` FROM $refTable WHERE $refFieldToMatch LIKE '%$needle%']");
            $matchQuery = $this->db->query("SELECT `$refIdField` FROM $refTable WHERE $refFieldToMatch LIKE '%$needle%'");
            //$matchQuery->execute(array('needle' =>$needle));
            //fetching results
            $result = $matchQuery->fetchAll();
            $this->log("[exactMatch] res: ".print_r($result, true));
            //insert result in current matching table
            $res = $this->db->query("INSERT INTO `".$this->uid."`('ExternalName','Matches') VALUES ('$needle', '". json_encode($result)."')");
            if($res === FALSE){
                $this->log("error inserting : INSERT INTO `".$this->uid."`('ExternalName','Matches') VALUES ".json_encode($result)." ".print_r($this->db->errorInfo(), true));
            }
            else
            {
                $this->log("results inserted ". print_r($res, true));
            }
        }
    }

    /**
     * logging
     */
    public function log($message){
        echo "\n<br><pre>[matcher]".$message."</pre>"; //todo use a real logger
    }
}