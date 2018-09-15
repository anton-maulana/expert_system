<?php
include '../config/config.php';

$type = isset($_GET["type"]) ? $_GET["type"] : null;

switch($type){
    case "list_diagnosis":
        $query = "SELECT id, name, level FROM questions";
        $conn = $connect->query($query);
        $rows = array();

        while ($row = mysqli_fetch_row($conn)) {
            array_push($rows, $row);
        }

        $data_tables_results = array(
            "data" => $rows, 
            "draw" => $_GET["draw"]+1, 
            "recordsFiltered" => count($rows),
            "recordsTotal" => count($rows)
        );
        echo json_encode($data_tables_results);
        break;
}



?>