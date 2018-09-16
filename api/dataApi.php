<?php
include '../config/config.php';

$type = isset($_GET["type"]) ? $_GET["type"] : null;

switch($type){
    case "list_symptoms":  
        $columns = array("id", "name", "level");
        $keyword = $_GET["search"]["value"];    
        $limit_per_page = $_GET["length"];
        $offset = $_GET["start"];
        $order_name = $columns[$_GET['order'][0]['column']];
        $order_type = $_GET['order'][0]['dir'];

        $query = "SELECT count(*) as total FROM symptoms WHERE name LIKE '$keyword%' ORDER BY $order_name $order_type LIMIT $limit_per_page OFFSET $offset";  
        $conn= $connect->query($query);
        $total_row = mysqli_fetch_array($conn)["total"];
        
        $query = "SELECT id, name, level FROM symptoms WHERE name LIKE '$keyword%' ORDER BY $order_name $order_type LIMIT $limit_per_page OFFSET $offset";
        $conn = $connect->query($query);
        $rows = array();

        while ($row = mysqli_fetch_assoc($conn)) {
            array_push($rows, $row);
        }

        $data_tables_results = array(
            "data" => $rows, 
            "draw" => $_GET["draw"]+1, 
            "recordsFiltered" => count($rows),
            "recordsTotal" => $total_row
        );
        echo json_encode($data_tables_results);
        break;
}



?>