<?php
require_once '../../config/config.php';
$name = $_POST["name"] ?? null;
$symptoms = $_POST["symptoms"] ?? null;
$description = $_POST["description"] ?? null;


$date_created = date("Y-m-d H:i:s");
$date_modified = date("Y-m-d H:i:s");

$query = "INSERT INTO diagnosis (name, description, date_created, date_modified) VALUES (?, ?, ?, ?)";
$params = array($name, $description, $date_created, $date_modified);
$response = insert($query, "ssss", $params);

if($response["status"] == "failed")
    return;

$id_diagnosis = $response["response"];

$values = "";
$params = array();
$types = "";
foreach($symptoms as $key => $value){
    $types = $types."ddss";
    $values = $values."(?, ?, ?, ?)";
    array_push($params, $value, $id_diagnosis, $date_created, $date_modified);
    if(isset($symptoms[$key +1]))
        $values = $values .", ";
}

$query = "INSERT INTO tree_symptoms_diagnosis (fk_symptoms_id, fk_diagnosis_id, date_created, date_modified) VALUES {$values}";
$response = insert($query, $types, $params);


header ( "location:../?page=diagnosis");
