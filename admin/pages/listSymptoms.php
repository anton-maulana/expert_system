<div class="container" style="margin-top:10px; margin-bottom:10px">
    <table id="table-list-symptoms" class="table" style="width:100%">
    </table>
</div>

<div class="modal fade" id="add-symptoms" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-add-symptoms" action="../api/dataApi.php?type=add_symptoms">
                    <div class="form-group">
                        <label for="nama-gejjala">Nama Gejala</label>
                        <input name ="name" type="text" class="form-control" id="nama-gejala" aria-describedby="" placeholder="contoh: panas">
                    </div>
                    <div class="form-group" style="display:none">
                        <label for="level">Level</label>
                        <input name="level" type="number" class="form-control" id="level" value="1">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" form="form-add-symptoms" class="btn btn-primary">Tambah</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit-symptoms" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-edit-symptoms" action="../api/dataApi.php?type=edit_symptoms" method="POST">
                    <input name ="id" type="hidden" class="form-control id-gejala">
                    <div class="form-group">
                        <label for="nama-gejala">Nama Gejala</label>
                        <input name ="name" type="text" class="form-control nama-gejala" id="nama-gejala" aria-describedby="" placeholder="contoh: panas">
                    </div>
                    <div class="form-group" style="display:none">
                        <label for="level">Level</label>
                        <input name="level" type="number" class="form-control level-gejala" id="level" placeholder="contoh: 1">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" form="form-edit-symptoms" class="btn btn-primary">Edit</button>
            </div>
        </div>
    </div>
</div>

<div id="modal-remove-symptoms" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="fas fa-times"></i>
                </div>				
                <h4 class="modal-title">Apakah anda yakin?</h4>	
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">                
                <p></p>
                <form id="form-remove-symptoms" action="../api/dataApi.php?type=delete_symptoms" method="POST">
                    <input name ="id" type="hidden" class="form-control id-gejala">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Tutup</button>
                <button type="submit" form="form-remove-symptoms" class="btn btn-danger">Hapus</button>
            </div>
        </div>
    </div>
</div>    

<script src="../assets/js/datatables.min.js"></script>
<script src="./scripts/listSymptoms.js"></script>


