<?php
require_once '../config/config.php';
$symptoms = array();
$diagnosis = array();
$id = $_GET["id"] ?? null;
$symptoms_selected = array();

if($id){
    $query = "SELECT * FROM diagnosis WHERE id = ?";
    $diagnosis = select($query, "d", array($id), true);

    $query = "SELECT * FROM tree_symptoms_diagnosis WHERE fk_diagnosis_id = ?";
    $rows = select($query, "d", array($id));
    foreach($rows as $row){
        array_push($symptoms_selected, $row["fk_symptoms_id"]);
    }
}

$query = "SELECT * FROM symptoms";
$symptoms = select($query);

?>
<div class="container">
    <form class="form" style="margin-top:100px" method="POST" action="core/insertDiagnosis.php">
        <h2>
            Tambah Diagnosa
        </h2>
        <?php if($id){?>
            <input type="hidden" class="form-control" name="id" id="diagnosis-name" placeholder="Syakit Hati" value="<?php echo $id ? $diagnosis["name"] : "" ?>">
        <?php }?>
        <div class="form-group">
            <label for="diagnosis-name">Nama Diagnosa</label>
            <input type="text" class="form-control" name="name" id="diagnosis-name" placeholder="Syakit Hati" value="<?php echo $id ? $diagnosis["name"] : "" ?>">
        </div>
        <div class="form-group">
            <label for="diagnosis-name">Gejala</label>
            <select class="symptoms-lists form-control" name="symptoms[]" multiple="multiple">
                <?php foreach($symptoms as $row) {?>
                    <option value="<?php echo $row["id"] ?>" <?php echo in_array($row["id"], $symptoms_selected, true) ? "selected" : ""?>><?php echo $row["name"] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="diagnosis-name">Solusi</label>
            <textarea rows="20"  class="form-control" name="description">
                <?php echo $id ? $diagnosis["description"] : "" ?>
            </textarea>
        </div>
        <button type="submit" class="btn btn-primary mb-2">Kirim</button>
    </form>              
</div>
<script src="../assets/js/tinymce/tinymce.min.js"></script>
<script src="./scripts/insertDiagnosis.js"></script>