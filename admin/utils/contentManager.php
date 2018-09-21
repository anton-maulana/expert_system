<?php   

    //$page in index.php
    switch($page){
        case null:
        case "list_symptoms":
            include("./pages/listSymptoms.php");
            break;
        case "diagnosis":
            include("./pages/diagnosis.php");
            break;
        case "diagnosis":
            include("./pages/diagnosis.php");
            break;
        case "insert_diagnosis":
            include("./pages/insertDiagnosis.php");
            break;
        default:
            include("./pages/404.php");
            break;
    }
    
?>