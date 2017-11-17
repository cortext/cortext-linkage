<?php

error_reporting(E_ALL);
ini_set('display_errors', 'sdtout');

require_once "lib/DBhandler.php";
require_once "lib/DLM.php";

//test data sources
$externalSource="./data/demoExternal.csv";
$referenceSource="./data/demoRef.csv";

//creating db
$dbHandler = new DBHandler();
$db = $dbHandler->getDB() ; //todo db object creation here
//var_dump($db->query("create table test(id, name)"));die();

//creating DLM
$matcherParams = array(
        'matchingAlgorithm'=>'exactMatch', 
        'refFieldToMatch'=>'entitycurrentname',
        'externalFieldToMatch' =>'name',
        'externalTable'=>'demoexternalcsv', 
        'refTable'=>'demorefcsv',
        'refIdField'=>'entityid'
 );
$dlm = new DLM($matcherParams, "demoDatasource", $db);

//Import data
$dlm->importRefData($referenceSource);
$dlm->importExternalData($externalSource);

//Matching
$dlm->match();

//Linking
$dlm->link();

//Display restults
$dlm->displayMatches();