<?php
require_once '../../config/config.php';
$action = $_GET["action"] ?? null;
$id = $_POST["id"] ?? null;
$name = $_POST["name"] ?? null;
$symptoms = $_POST["symptoms"] ?? array();
$description = $_POST["description"] ?? null;
$date_created = date("Y-m-d H:i:s");
$date_modified = date("Y-m-d H:i:s");

if($action == "insert"){
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
    if(count($symptoms) != 0){
        $query = "INSERT INTO tree_symptoms_diagnosis (fk_symptoms_id, fk_diagnosis_id, date_created, date_modified) VALUES {$values}";
        $response = insert($query, $types, $params);
    }
} else if($action == "update"){
    $query = "UPDATE diagnosis SET name = ?, description = ?, date_modified = ? WHERE id = ?";
    $params = array($name, $description, $date_modified, (int)$id);
    $response = update($query, "sssd", $params);

    $last_symptoms = array();
    $old_symptoms = array();

    $query = "SELECT * FROM tree_symptoms_diagnosis WHERE fk_diagnosis_id = ?";
    $rows = select($query, "d", array($id));

    foreach($rows as $row){
        $old_symptoms[] = $row["fk_symptoms_id"];
    }

    foreach ($symptoms as $key => $value) {
        $last_symptoms[] = (int)$value;
    }

    $new_symptoms = array_diff($last_symptoms, $old_symptoms);
    $delete_symptoms = array_diff($old_symptoms, $last_symptoms);

    $values = "";
    $types = "";
    $params = array();

    foreach($new_symptoms as $key => $value){
        $types = $types."ddss";
        $values = $values."(?, ?, ?, ?)";
        array_push($params, $value, $id, $date_created, $date_modified);
        if(isset($new_symptoms[$key +1]))
            $values = $values .", ";
    }

    if(count($new_symptoms) != 0){
        $query = "INSERT INTO tree_symptoms_diagnosis (fk_symptoms_id, fk_diagnosis_id, date_created, date_modified) VALUES {$values}";
        $response = insert($query, $types, $params);
    }

    if(count($delete_symptoms) != 0){
        foreach($delete_symptoms as $key =>$value){
            $conditions = array(
                array(
                    "column_name" => "fk_symptoms_id",
                    "value" => (int)$value,
                    "type" => "d"
                ),
                array(
                    "column_name" => "fk_diagnosis_id",
                    "value" => (int)$id,
                    "type" => "d"
                )            
            );
            delete("tree_symptoms_diagnosis", null, $conditions );
        }
    }

} else if($action == "delete"){
    $response = delete("diagnosis", $id);
}
header ( "location:../?page=diagnosis");