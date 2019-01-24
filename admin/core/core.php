<?php
require_once './config/config.php';

// Define the custom sort function
function custom_sort($a,$b) {
    return $a['percentage']<$b['percentage'];
}

$symptoms_selected = array();
$s = $_POST["symptoms"] ?? null;

if(!$s && count($s) == 0){
    echo json_encode(array());
    return;
}

//Cast to Integer from string number
foreach($s as $key => $value)
    $symptoms_selected[] = (int)$value;

$query = "SELECT * from diagnosis";
$diagnosis = select($query);
$total_diagnosis = count($diagnosis);

$probabilities = array();
$bayes = array();
$bayes_temp = array();

foreach($diagnosis as $diagnosa){
    $query = "SELECT * from tree_symptoms_diagnosis WHERE fk_diagnosis_id =".$diagnosa["id"];
    $rows = select($query);

    $all_symptoms = array();
    foreach($rows as $s)
        $all_symptoms[] = $s["fk_symptoms_id"];
    
    $in_selected = array_diff($symptoms_selected, $all_symptoms);
    //jika tidak ada gejala di diagnosa tersebut lanjutkan
    if(count($in_selected) == count($symptoms_selected))
        continue;

    $probability_to_diagnosa = array(
        "diagnosis_id" => $diagnosa["id"],
        "diagnosa_name" => $diagnosa["name"],
        "all_symptoms" => $all_symptoms,
        "probability" => round((1/$total_diagnosis ), 3),//karena kerusakan hanya muncul 1 kali di data maka 1, jumlah kemungkinan / jumlah kerusakan
        "probability_to_symptoms" => array()   
    );

    foreach($all_symptoms as $i => $val){
        $in_array = in_array($val, $symptoms_selected, true);
        $total_kemunculan = $in_array ? 1 : 0; //kenapa hanya 0 dan 1 karena untuk data saat ini hanya dibuat 1 kemunculan saja untuk setiap gejala dan penyakit yang sama
        
        $s = array(
            "symptom_id" => $val,
            "probability" => round(($total_kemunculan/count($all_symptoms)), 3)
        );
        $probability_to_diagnosa["probability_to_symptoms"][] = $s;
    }

    $probabilities[] = $probability_to_diagnosa;   

}
$total_all_bayes = array();
foreach($probabilities as $p){
    $bayes_symptoms = array();
    $total_bayes = array();
    foreach($p["probability_to_symptoms"] as $s){
        $ph = $s["probability"] * $p["probability"];
        
        $temp = array();
        foreach($probabilities as $t){
            $in_array = in_array($s["symptom_id"], $t["all_symptoms"]);
            $total_kemunculan = $in_array ? 1 : 0; //kenapa hanya 0 dan 1 karena untuk data saat ini hanya dibuat 1 kemunculan saja untuk setiap gejala dan penyakit yang sama

            $temp[] = round(($s["probability"] * $total_kemunculan) * $p["probability"],3);

        }   
        $px = array_sum($temp);
        if($ph == 0 and $px == 0)
            $by = 0;
        else
            $by = round($ph / $px, 3);
        $bayes_symptoms[] = array(
            "symptoms_id" => $s["symptom_id"],
            "ph" => $ph,
            "px" => $px,
            "bayes" => $by           
        );
        $total_bayes[] = $by;
    }
    $sum_bayes_diag = array_sum($total_bayes);
    $p["bayes_symptoms"] = $bayes_symptoms;
    $p["total_bayes"] = $sum_bayes_diag;
    $p["percentage"] = 0;
    $total_all_bayes[] = $sum_bayes_diag;
    $bayes_temp[] = $p; 
}

$total = array_sum($total_all_bayes);
foreach($bayes_temp as $i => $b){
    $b["percentage"] = round(($b["total_bayes"] / $total) *100, 2);
    $bayes[] = $b;
}

usort($bayes, "custom_sort");


// foreach($symptoms as $key => $value){
//     $query = "SELECT d.id from diagnosis d INNER JOIN tree_symptoms_diagnosis t ON t.fk_diagnosis_id = d.id WHERE t.fk_symptoms_id = ?";
//     $rows = select($query, "d", array((int)$value));

//     foreach($rows as $row){
//         $probability_to_diagnosa = array(
//             "diagnosis_id" => $row["id"],
//             "probability" => round((1/$total_diagnosis ), 3),
//             "probability_to_symptoms" => array()    
//         );
//         $query = "SELECT * FROM tree_symptoms_diagnosis t WHERE t.fk_diagnosis_id = ".$row['id'];
//         $diagnosis = select($query);

//         foreach($symptoms as $i => $val){
//             $in_array = array_filter($diagnosis, function ($var) {
//                 global $val;
//                 return ($var['fk_symptoms_id'] == (int)$val);
//             });

//             if(count($in_array) != 0){
//                 $s = array(
//                     "symptom_id" => (int)$val,
//                     "probability" => round((1/count($diagnosis)), 3)
//                 );
               
//             } else {
//                 $s = array(
//                     "symptom_id" => (int)$val,
//                     "probability" => 0
//                 );
//             }
//             $probability_to_diagnosa["probability_to_symptoms"][] = $s;
            
//         }
//         $probabilities[] = $probability_to_diagnosa;    
//     }    
// }

// foreach($probabilities as $prob){
//     $p = $prob["probability"];

//     foreach($prob["probability_to_symptoms"] as $s){

//     }
// }





