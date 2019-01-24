<?php
require_once '../config/config.php';

function create_data_tables_response($rows, $draw, $total_row){
    return array(
        "data" => $rows, 
        "draw" => $_GET["draw"]+1, 
        "recordsFiltered" => $total_row,
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
        $query = "SELECT * FROM symptoms WHERE name LIKE ? ORDER BY ? {$order_type}"; 
        $params = array($keyword, $order_name);
        $rows = select($query, "ss", $params);
        $total_row = count($rows);

        $query = "SELECT id, name, level FROM symptoms WHERE name LIKE ? ORDER BY ? {$order_type} LIMIT ? OFFSET ?";
        $params = array($keyword, $order_name, $limit_per_page, $offset);
        $rows = select($query, "ssdd", $params);
        
        if(!$rows && count($rows) != 0)
            return;
                
       
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
        $query = "SELECT * FROM diagnosis WHERE name LIKE ? ORDER BY ? {$order_type} ";  
        $params = array($keyword, $order_name);
        $rows = select($query, "ss", $params);
        $total_row = count($rows);
        
        $query = "SELECT * FROM diagnosis WHERE name LIKE ? ORDER BY ? {$order_type} LIMIT ? OFFSET ?";
        $params = array($keyword, $order_name, $limit_per_page, $offset);
        $rows = select($query, "ssdd", $params);
        
        if(!$rows && count($rows) != 0)
            return;
                
        echo json_encode(create_data_tables_response($rows, $_GET["draw"], $total_row));
        break;

    case "get_solutions":
        $id = $_GET["id"] ?? null;
        $query = "SELECT description FROM diagnosis WHERE id = ?";  
        $params = array($id);
        $rows = select($query, "d", $params, true);
        
        if(!$rows)
            return;
                
        echo json_encode($rows);
        return;
    case "get_symptoms":
        $id = $_GET["id"] ?? null;
        $query = "SELECT s.* FROM tree_symptoms_diagnosis t 
            INNER JOIN symptoms s ON t.fk_symptoms_id = s.id
            WHERE t.fk_diagnosis_id = ?";  
        $params = array($id);
        $rows = select($query, "d", $params);
        
        if(!$rows)
            return;
                
        echo json_encode($rows);
        return;
    case "delete_diagnosis":
        $id = $_POST["id"];

        $response = delete("diagnosis", $id);
        delete("tree_symptoms_diagnosis", $id, null, "fk_diagnosis_id");
        echo json_encode($response);    
        break;
}
?>