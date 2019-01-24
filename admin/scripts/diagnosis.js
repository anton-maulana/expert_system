var listSymptomsSchema = [
    {
        "className":      'details-control',
        "orderable":      false,
        "data":           null,
        "defaultContent": ''
    },
    { "data": "name", "name": "diagnosa", "title": "Diagnosa"},
    { "data": "description", "name": "description", "title": "Solusi", render: function ( data, type, row ) {
        return type === 'display' && data.length > 50 ?
            data.substr( 0, 50 ) +'…' :
            data;
        }
    },
    { "data": "id", render: function(data, type, full){
            return  "<button type='button' title='lihat solusi' style='background: transparent' class='btn btn-default btn-sm' onclick='viewSolutions("+data+")'><i class='fa fa-eye'></i></button>"+
            "<a href='?page=create_or_update_diagnosis&id="+data+"' title='edit diagnosa' style='background: transparent' class='btn btn-default btn-sm'><i class='fa fa-edit'></i></a>"+
            "<button type='button' title='hapus diagnosa' style='background: transparent' class='btn btn-default btn-sm' onclick='removeDiagnosis(this)'><i class='fas fa-trash-alt'></i></button>"
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

 // Add event listener for opening and closing details
$('#table-list-diagnosis tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = table.row( tr );

    if ( row.child.isShown() ) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
    }
    else {
        // Open this row
        //row.child( format(row.data()) ).show();
        var symptoms = getSymptomsLists(row.data()["id"]);
        row.child(format(symptoms)).show();
        tr.addClass('shown');
    }
} );

$("#form-remove-diagnosa").submit(function(e) {
    var form = $(this);
    var url = form.attr('action');

    $("#modal-remove-diagnosa")["modal"]("hide");
    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data){ showToaster(JSON.parse(data), 'Hapus data berhasil.') }
         });

    e.preventDefault(); // avoid to execute the actual submit of the form.
});

function viewSolutions(id){
    $("#view-solutions")["modal"]("show");
    $.get("/api/dataApi.php?type=get_solutions&id="+id,function(responses, status){
        var data = JSON.parse(responses);
        $("#view-solutions .modal-body").html("");
        $("#view-solutions .modal-body").html(data["description"]);
    });
}

function format ( symptoms ) {
    var tableRow = "";
    symptoms.forEach((row, i) => {
        tableRow = tableRow + 
        '<tr>'+
            '<td>Gejala ke  '+(i+1)+' </td>'+
            '<td>'+row.name+'</td>'+
        '</tr>';
    });
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+tableRow+'</table>';
}

function getSymptomsLists(id){
    var data = [];
    jQuery.ajax({
        url: '/api/dataApi.php?type=get_symptoms&id='+id,
        success: function (results) {
            data = JSON.parse(results);
        },
        async: false
    });
    return data;
}

function removeDiagnosis(elements){
    var tr = $(elements).closest('tr');
    var row = table.row( tr );

    var id = row.data()["id"];
    var name = row.data()["name"];
    var messages = "Apakah anda yakin akan menghapus <b>Diagnosa "+name+"</b> ini?, data akan permanen dihapus dari sistem."

    $(".modal-confirm .modal-body p").html(messages);
    $("#form-remove-diagnosa .id-gejala").val(id);
    $("#modal-remove-diagnosa")["modal"]("show");
    return id;
}


