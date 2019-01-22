var listSymptomsSchema = [
    { "data": "id", "name": "id", "title": "Id" },
    { "data": "name", "name": "gejala", "title": "Gejala"},
    { "data": "probability", "name": "probability", "title": "Probabilitas"},
    { "data": "id", render: function(data, type, full){
            return  "<button type='button' title='lihat solusi' style='background: transparent' class='btn btn-default btn-sm' onclick='viewSolutions("+data+")'><i class='fa fa-eye'></i></button>"+
            "<a href='?page=create_or_update_diagnosis&id="+data+"'title='edit diagnosa' style='background: transparent' class='btn btn-default btn-sm' onclick='editSymptoms("+data+")'><i class='fa fa-edit'></i></a>"+
            "<button type='button' title='hapus diagnosa' style='background: transparent' class='btn btn-default btn-sm' onclick='removeSymptoms("+data+")'><i class='fas fa-trash-alt'></i></button>"
        }
    },
];

var customDom = "<'row'<'col-sm-4 col-md-2 insert-diagnosa'><'col-sm-4 col-md-2 calculate'>"+
                "<'col-sm-4 col-md-2'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";

var columnDefs = [ {
        "targets": 3,
        "data": null,
    } ];

var table = initDataTables("table-list-diagnosis", "diagnosis", listSymptomsSchema, customDom, columnDefs);
$(".insert-diagnosa").append("<a href='?page=create_or_update_diagnosis' class='btn btn-primary btn-sm'>Tambah Diagnosa</a>");
$(".calculate").append("<a href='?page=insert_diagnosis' class='btn btn-primary btn-sm'>Kalkulasi</a>");

function viewSolutions(id){
    $("#view-solutions")["modal"]("show");
    $.get("/api/dataApi.php?type=get_solutions&id="+id,function(responses, status){
        var data = JSON.parse(responses);
        $("#view-solutions .modal-body").html("");
        $("#view-solutions .modal-body").html(data["description"]);
    });
}
// window['table'] = table;
// $("#form-add-symptoms").submit(function(e) {
//     var form = $(this);
//     var url = form.attr('action');
//     var me = this;

//     $("#add-symptoms")["modal"]("hide");
//     $.ajax({
//            type: "POST",
//            url: url,
//            data: form.serialize(), // serializes the form's elements.
//            success: function(data){ showToaster(JSON.parse(data), 'Gejala berhasil ditambahkan.') }
//          });

//     e.preventDefault(); // avoid to execute the actual submit of the form.
// });


// $("#form-edit-symptoms").submit(function(e) {
//     var form = $(this);
//     var url = form.attr('action');
//     var me = this;

//     $("#modal-edit-symptoms")["modal"]("hide");
//     $.ajax({
//            type: "POST",
//            url: url,
//            data: form.serialize(), // serializes the form's elements.
//            success: function(data){ showToaster(JSON.parse(data), 'Edit data berhasil.') }
//          });

//     e.preventDefault(); // avoid to execute the actual submit of the form.
// });

// $("#form-remove-symptoms").submit(function(e) {
//     var form = $(this);
//     var url = form.attr('action');
//     var me = this;

//     $("#modal-remove-symptoms")["modal"]("hide");
//     $.ajax({
//            type: "POST",
//            url: url,
//            data: form.serialize(), // serializes the form's elements.
//            success: function(data){ showToaster(JSON.parse(data), 'Hapus data berhasil.') }
//          });

//     e.preventDefault(); // avoid to execute the actual submit of the form.
// });

// function showToaster(data, successMessages){
//     if(data["response"] == "success"){
//         $.toast({
//             heading: 'Success',
//             text: successMessages,
//             showHideTransition: 'slide',
//             icon: 'success'
//         });
//         table.ajax.reload();
//     }
//     else {
//         $.toast({
//             heading: 'Error',
//             text: 'Terjadi Kesalahan '+data["error"],
//             showHideTransition: 'slide',
//             icon: 'error'
//         });
//     }
// }

// function editSymptoms(elements){
//     var row = $(elements).closest("tr");
//     var id = $($('td', row)[0]).html();
//     var name = $($('td', row)[1]).html();
//     var level = $($('td', row)[2]).html();

//     $("#form-edit-symptoms .id-gejala").val(id);
//     $("#form-edit-symptoms .nama-gejala").val(name);
//     $("#form-edit-symptoms .level-gejala").val(level);
//     $("#modal-edit-symptoms")["modal"]("show");
//     return id;
// }

// function removeSymptoms(elements){
//     var row = $(elements).closest("tr");
//     var id = $($('td', row)[0]).html();
//     var name = $($('td', row)[1]).html();
//     var messages = "Apakah anda yakin akan menghapus gejala "+name+" ini?, data akan permanen dihapus dari sistem."

//     $(".modal-confirm .modal-body p").html(messages);
//     $("#form-remove-symptoms .id-gejala").val(id);
//     $("#modal-remove-symptoms")["modal"]("show");
//     return id;
// }



