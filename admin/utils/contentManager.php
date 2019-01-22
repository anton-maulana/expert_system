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
        case "create_or_update_diagnosis":
            include("./pages/createOrUpdateDiagnosis.php");
            break;
        default:
            include("./pages/404.php");
            break;
    }
    
?>