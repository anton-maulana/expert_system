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

<style>
ul.breadcrumb {
  padding: 10px 16px;
  list-style: none;
  background-color: #eee;
}
ul.breadcrumb li {
  display: inline;
  font-size: 18px;
}
ul.breadcrumb li+li:before {
  padding: 8px;
  color: black;
  content: "/\00a0";
}
ul.breadcrumb li a {
  color: #0275d8;
  text-decoration: none;
}
ul.breadcrumb li a:hover {
  color: #01447e;
  text-decoration: underline;
}
</style>
<div class="container">
    <ul class="breadcrumb">
        <li><a href="/admin">Admin</a></li>
        <li><a href="/admin/?page=diagnosis">Diagnosis</a></li>
        <li><?php echo $id ? "Update Diagnosa" : "Tambah Diagnosa" ?></li>
    </ul>
    <form class="form" style="margin-top:100px" method="POST" action="core/diagnosis.php?action=<?php echo $id ? "update" : "insert" ?>">
        <h2>
            <?php echo $id ? "Update" : "Tambah" ?> Diagnosa
        </h2>
        <?php if($id){?>
            <input type="hidden" class="form-control" name="id" id="diagnosis-name" placeholder="Syakit Hati" value="<?php echo $id ? $diagnosis["id"] : "" ?>">
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
<script src="./scripts/createOrUpdateDiagnosis.js"></script>