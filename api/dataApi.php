<?php
include '../config/config.php';

function execute_query($query){
    global $connect;
    if ($connect->query ( $query ) === TRUE) {
        echo json_encode(array("response" => "success"));
    } else {
        echo json_encode(array("response" => "failed", "error" => $connect->error));                                                    
    }   
}

function create_data_tables_response($rows, $draw, $total_row){
    return array(
        "data" => $rows, 
        "draw" => $_GET["draw"]+1, 
        "recordsFiltered" => count($rows),
        "recordsTotal" => $total_row
    );
}

$type = isset($_GET["type"]) ? $_GET["type"] : null;
if($type == "list_symptoms" || $type == "diagnosis"){
    $columns = array("id", "name", "level");
    $keyword = $_GET["search"]["value"];    
    $limit_per_page = $_GET["length"];
    $offset = $_GET["start"];
    $order_name = $columns[$_GET['order'][0]['column']];
    $order_type = $_GET['order'][0]['dir'];
}

switch($type){
    case "list_symptoms":  
        $query = "SELECT count(*) as total FROM symptoms WHERE name LIKE '$keyword%' ORDER BY $order_name $order_type LIMIT $limit_per_page OFFSET $offset";  
        $conn= $connect->query($query);
        $total_row = mysqli_fetch_array($conn)["total"];
        
        $query = "SELECT id, name, level FROM symptoms WHERE name LIKE '$keyword%' ORDER BY $order_name $order_type LIMIT $limit_per_page OFFSET $offset";
        $conn = $connect->query($query);
        $rows = array();

        while ($row = mysqli_fetch_assoc($conn)) {
            array_push($rows, $row);
        }
       
        echo json_encode(create_data_tables_response($rows, $_GET["draw"], $total_row));
        break;
    case "add_symptoms":
        $level = $_POST["level"];
        $name = $_POST["name"];
        $date_created = date("Y-m-d H:i:s");
        $date_modified = date("Y-m-d H:i:s");
        $query = "INSERT INTO symptoms (name, level, date_created, date_modified) VALUES ('$name', '$level', '$date_created', '$date_modified')";
        execute_query($query);    
        break;
    case "edit_symptoms":
        $id = $_POST["id"];
        $level = $_POST["level"];
        $name = $_POST["name"];
        $date_modified = date("Y-m-d H:i:s");
        $query = "UPDATE symptoms SET  name = '$name', level = '$level', date_modified = '$date_modified' WHERE id = $id";
        execute_query($query);     
        break;
    case "delete_symptoms":
        $id = $_POST["id"];
        $query = "DELETE FROM symptoms WHERE id = $id";
        execute_query($query);
        break;
    case "diagnosis":
        $query = "SELECT count(*) as total FROM diagnosis WHERE name LIKE '$keyword%' ORDER BY $order_name $order_type LIMIT $limit_per_page OFFSET $offset";  
        $conn= $connect->query($query);
        $total_row = mysqli_fetch_array($conn)["total"];
        
        $query = "SELECT id, name FROM diagnosis WHERE name LIKE '$keyword%' ORDER BY $order_name $order_type LIMIT $limit_per_page OFFSET $offset";
        $conn = $connect->query($query);
        $rows = array();

        while ($row = mysqli_fetch_assoc($conn)) {
            array_push($rows, $row);
        }
    
        echo json_encode(create_data_tables_response($rows, $_GET["draw"], $total_row));
        break;
        
}




?>