<?php   

    //$page in index.php
    switch($page){
        case "list_symptoms":
            include("./pages/listSymptoms.php");
            break;
        default:
            include("./pages/home.php");
            break;
    }
    
?>