<?php
    date_default_timezone_set("Asia/Jakarta");
    defined("DBDRIVER")or define('DBDRIVER','mysql');
    defined("DBHOST")or define('DBHOST','127.0.0.1');
    defined("DBNAME")or define('DBNAME','expert_system');
    defined("DBUSER")or define('DBUSER','root');
    defined("DBPASS")or define('DBPASS','root'); 

    $connect = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);

    function secureExecute($query, $types = null, $params = null, $isOutputObject = false){
        global $connect;
        $results = array();
        $conn = $connect->prepare($query);
        if($types && $params)
            $conn->bind_param($types, ...$params);
    
        if(!$conn->execute()) return false;
        
        $rows =  $conn->get_result();
        if(!$rows) return false;
        if($isOutputObject) {
            while ( $row = mysqli_fetch_assoc ( $rows )) {
                $results = $row;
            }
        } else {
            while ( $row = mysqli_fetch_assoc ( $rows )) {
                $results[]= $row;
            }
        }
    
        return $results;
    }

    function onlyExecute($query, $types = null, $params = null){
        global $connect;
        $results = array();
        $conn = $connect->prepare($query);
        if($types && $params)
            $conn->bind_param($types, ...$params);
    
        if(!$conn->execute()) return false;
        return true;
        
    }
    
?>