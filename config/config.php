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
    
    function select($query, $types = null, $params = null, $isOutputObject = false){
        global $connect;
        $results = array();
        
        $conn = $connect->prepare($query);
        if(!$conn){
            echo $connect->error;
            return false;
        }
        
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

    function insert($query, $types, $params){
        global $connect;

        $conn = $connect->prepare($query);
        if(!$conn)            
            return array("status" => "failed", "error" => $connect->error);
        
        $conn->bind_param($types, ...$params);
    
        if(!$conn->execute()) 
            return array("status" => "failed", "error" => $connect->error);

        return array("status" => "success", "response" => $connect->insert_id);
    }

    function update($query, $types, $params){
        global $connect;

        $conn = $connect->prepare($query);
        if(!$conn)            
            return array("status" => "failed", "error" => $connect->error);
        
        $conn->bind_param($types, ...$params);
    
        if(!$conn->execute()) 
            return array("status" => "failed", "error" => $connect->error);

        return array("status" => "success");
    }

    function delete($table, $id, $multiConditions = null, $customColumName= null) {
        // Connect to the database
        global $connect;
        

        if($multiConditions){
            $params = array();
            $conditions = "";
            $types = "";

            foreach($multiConditions as $key => $row){
                $params[] = $row["value"];
                $types = $types.$row["type"];
                $conditions = $conditions.$row["column_name"]." = ?";

                if(isset($multiConditions[$key + 1]))
                    $conditions = $conditions." AND ";
            }

            $conn = $connect->prepare("DELETE FROM {$table} WHERE {$conditions}");
            $conn->bind_param($types, ...$params);
        } else {        
            // Prepary our query for binding
            $column_name = $customColumName ?? "ID";
            $conn = $connect->prepare("DELETE FROM {$table} WHERE {$column_name} = ?");

            // Dynamically bind values
             $conn->bind_param('d', $id);
        }
        
        

        if(!$conn)            
            return array("status" => "failed", "error" => $connect->error);
        // Execute the query
        $conn->execute();

        if(!$conn->execute())
            return array("status" => "failed", "error" => $connect->error);
        
        return array("status" => "success");
        
    }


    // if ( !class_exists( 'DB' ) ) {
    //     class DB {
    //         public function __construct($user, $password, $database, $host = 'localhost') {
    //             $this->user = $user;
    //             $this->password = $password;
    //             $this->database = $database;
    //             $this->host = $host;
    //         }
            
    //         protected function connect() {
    //             return new mysqli($this->host, $this->user, $this->password, $this->database);
    //         }
            
    //         public function query($query) {
    //             $db = $this->connect();
    //             $result = $db->query($query);
                
    //             while ( $row = $result->fetch_object() ) {
    //                 $results[] = $row;
    //             }
                
    //             return $results;
    //         }
    //         public function insert($table, $data, $format) {
    //             // Check for $table or $data not set
    //             if ( empty( $table ) || empty( $data ) ) {
    //                 return false;
    //             }
                
    //             // Connect to the database
    //             $db = $this->connect();
                
    //             // Cast $data and $format to arrays
    //             $data = (array) $data;
    //             $format = (array) $format;
                
    //             // Build format string
    //             $format = implode('', $format); 
    //             $format = str_replace('%', '', $format);
                
    //             list( $fields, $placeholders, $values ) = $this->prep_query($data);
                
    //             // Prepend $format onto $values
    //             array_unshift($values, $format); 
    //             // Prepary our query for binding
    //             $stmt = $db->prepare("INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})");
    //             // Dynamically bind values
    //             call_user_func_array( array( $stmt, 'bind_param'), $this->ref_values($values));
                
    //             // Execute the query
    //             $stmt->execute();
                
    //             // Check for successful insertion
    //             if ( $stmt->affected_rows ) {
    //                 return true;
    //             }
                
    //             return false;
    //         }
    //         public function update($table, $data, $format, $where, $where_format) {
    //             // Check for $table or $data not set
    //             if ( empty( $table ) || empty( $data ) ) {
    //                 return false;
    //             }
                
    //             // Connect to the database
    //             $db = $this->connect();
                
    //             // Cast $data and $format to arrays
    //             $data = (array) $data;
    //             $format = (array) $format;
                
    //             // Build format array
    //             $format = implode('', $format); 
    //             $format = str_replace('%', '', $format);
    //             $where_format = implode('', $where_format); 
    //             $where_format = str_replace('%', '', $where_format);
    //             $format .= $where_format;
                
    //             list( $fields, $placeholders, $values ) = $this->prep_query($data, 'update');
                
    //             //Format where clause
    //             $where_clause = '';
    //             $where_values = '';
    //             $count = 0;
                
    //             foreach ( $where as $field => $value ) {
    //                 if ( $count > 0 ) {
    //                     $where_clause .= ' AND ';
    //                 }
                    
    //                 $where_clause .= $field . '=?';
    //                 $where_values[] = $value;
                    
    //                 $count++;
    //             }
    //             // Prepend $format onto $values
    //             array_unshift($values, $format);
    //             $values = array_merge($values, $where_values);
    //             // Prepary our query for binding
    //             $stmt = $db->prepare("UPDATE {$table} SET {$placeholders} WHERE {$where_clause}");
                
    //             // Dynamically bind values
    //             call_user_func_array( array( $stmt, 'bind_param'), $this->ref_values($values));
                
    //             // Execute the query
    //             $stmt->execute();
                
    //             // Check for successful insertion
    //             if ( $stmt->affected_rows ) {
    //                 return true;
    //             }
                
    //             return false;
    //         }
    //         public function select($query, $data, $format) {
    //             // Connect to the database
    //             $db = $this->connect();
                
    //             //Prepare our query for binding
    //             $stmt = $db->prepare($query);
                
    //             //Normalize format
    //             $format = implode('', $format); 
    //             $format = str_replace('%', '', $format);
                
    //             // Prepend $format onto $values
    //             array_unshift($data, $format);
                
    //             //Dynamically bind values
    //             call_user_func_array( array( $stmt, 'bind_param'), $this->ref_values($data));
                
    //             //Execute the query
    //             $stmt->execute();
                
    //             //Fetch results
    //             $result = $stmt->get_result();
                
    //             //Create results object
    //             while ($row = $result->fetch_object()) {
    //                 $results[] = $row;
    //             }
    //             return $results;
    //         }

    //         public function delete($table, $id) {
    //             // Connect to the database
    //             $db = $this->connect();
                
    //             // Prepary our query for binding
    //             $stmt = $db->prepare("DELETE FROM {$table} WHERE ID = ?");
                
    //             // Dynamically bind values
    //             $stmt->bind_param('d', $id);
                
    //             // Execute the query
    //             $stmt->execute();
                
    //             // Check for successful insertion
    //             if ( $stmt->affected_rows ) {
    //                 return true;
    //             }
    //         }
    //         private function prep_query($data, $type='insert') {
    //             // Instantiate $fields and $placeholders for looping
    //             $fields = '';
    //             $placeholders = '';
    //             $values = array();
                
    //             // Loop through $data and build $fields, $placeholders, and $values			
    //             foreach ( $data as $field => $value ) {
    //                 $fields .= "{$field},";
    //                 $values[] = $value;
                    
    //                 if ( $type == 'update') {
    //                     $placeholders .= $field . '=?,';
    //                 } else {
    //                     $placeholders .= '?,';
    //                 }
                    
    //             }
                
    //             // Normalize $fields and $placeholders for inserting
    //             $fields = substr($fields, 0, -1);
    //             $placeholders = substr($placeholders, 0, -1);
                
    //             return array( $fields, $placeholders, $values );
    //         }
    //         private function ref_values($array) {
    //             $refs = array();
    //             foreach ($array as $key => $value) {
    //                 $refs[$key] = &$array[$key]; 
    //             }
    //             return $refs; 
    //         }
    //     }
    // }

    // date_default_timezone_set("Asia/Jakarta");
    // defined("DBDRIVER")or define('DBDRIVER','mysql');
    // defined("DBHOST")or define('DBHOST','127.0.0.1');
    // defined("DBNAME")or define('DBNAME','expert_system');
    // defined("DBUSER")or define('DBUSER','root');
    // defined("DBPASS")or define('DBPASS','root'); 

    // $db = new DB(DBUSER, DBPASS, DBNAME, DBHOST);
    
?>
    