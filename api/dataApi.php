<?php
require_once '../config/config.php';

function create_data_tables_response($rows, $draw, $total_row){
    return array(
        "data" => $rows, 
        "draw" => $_GET["draw"]+1, 
        "recordsFiltered" => count($rows),
        "recordsTotal" => $total_row
    );
}

$type = $_GET["type"] ?? null;
if($type == "list_symptoms" || $type == "diagnosis"){
    $columns = array("id", "name", "level");
    $keyword = "%{$_GET['search']['value']}%";    
    $limit_per_page = $_GET["length"];
    $offset = $_GET["start"];
    $order_name = $columns[$_GET['order'][0]['column']];
    $order_type = $_GET['order'][0]['dir'] == "asc" ? "asc" : "desc";
}

switch($type){
    case "list_symptoms":  
        //mengambil total rows untuk
        $query = "SELECT count(*) as total FROM symptoms WHERE name LIKE ? ORDER BY ? {$order_type} LIMIT ? OFFSET ?"; 
        $params = array($keyword, $order_name, $limit_per_page, $offset);
        $row = select($query, "ssdd", $params, true);

        $query = "SELECT id, name, level FROM symptoms WHERE name LIKE ? ORDER BY ? {$order_type} LIMIT ? OFFSET ?";
        $rows = select($query, "ssdd", $params);
        
        if(!$row || !$rows && count($rows) != 0)
            return;
                
        $total_row = $row["total"];
        echo json_encode(create_data_tables_response($rows, $_GET["draw"], $total_row));
        break;
    case "add_symptoms":
        $level = $_POST["level"];
        $name = $_POST["name"];
        $date_created = date("Y-m-d H:i:s");
        $date_modified = date("Y-m-d H:i:s");
        $query = "INSERT INTO symptoms (name, level, date_created, date_modified) VALUES (?, ?, ?, ?)";
        $params = array($name, $level, $date_created, $date_modified);
        
        $response = insert($query, "sdss", $params);
        echo json_encode($response);
        break;

    case "edit_symptoms":
        $id = $_POST["id"];
        $level = $_POST["level"];
        $name = $_POST["name"];
        $date_modified = date("Y-m-d H:i:s");
        $query = "UPDATE symptoms SET  name = ?, level = ?, date_modified = ? WHERE id = ?";
        $params = array($name, $level, $date_modified, $id);

        $response = update($query, "sdsd",  $params);
        echo json_encode($response);   
        break;

    case "delete_symptoms":
        $id = $_POST["id"];

        $response = delete("symptoms", $id);
        echo json_encode($response);    
        break;

    case "diagnosis":
        $query = "SELECT count(*) as total FROM diagnosis WHERE name LIKE ? ORDER BY ? {$order_type} LIMIT ? OFFSET ?";  
        $params = array($keyword, $order_name, $limit_per_page, $offset);
        $row = select($query, "ssdd", $params, true);
        
        $query = "SELECT * FROM diagnosis WHERE name LIKE ? ORDER BY ? {$order_type} LIMIT ? OFFSET ?";
        $rows = select($query, "ssdd", $params);
        
        if(!$row || !$rows && count($rows) != 0)
            return;
                
        $total_row = $row["total"];
        echo json_encode(create_data_tables_response($rows, $_GET["draw"], $total_row));
        
}
?>