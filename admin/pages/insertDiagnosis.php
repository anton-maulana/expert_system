<?php
require_once '../config/config.php';
$query = "SELECT * FROM symptoms";
$rows = select($query);

?>
<div class="container">
    <form class="form" style="margin-top:100px" method="POST" action="core/insertDiagnosis.php">
        <h2>
            Masukan Diagnosa
        </h2>
        <div class="form-group">
            <label for="diagnosis-name">Nama Diagnosa</label>
            <input type="text" class="form-control" name="name" id="diagnosis-name" placeholder="Syakit Hati">
        </div>
        <div class="form-group">
            <label for="diagnosis-name">Gejala</label>
            <select class="symptoms-lists form-control" name="symptoms[]" multiple="multiple">
                <?php foreach($rows as $row) {?>
                    <option value="<?php echo $row["id"] ?>"><?php echo $row["name"] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="diagnosis-name">Solusi</label>
            <textarea rows="20"  class="form-control" name="description">

            </textarea>
        </div>
        <button type="submit" class="btn btn-primary mb-2">Kirim</button>
    </form>              
</div>
<script src="../assets/js/tinymce/tinymce.min.js"></script>
<script src="./scripts/insertDiagnosis.js"></script>