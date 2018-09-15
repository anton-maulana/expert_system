<?php   

    //$page in index.php
    switch($page){
        case "list_diagnosis":
            include("./pages/listDiagnosis.php");
            break;
        default:
            include("./pages/home.php");
            break;
    }
    
?>