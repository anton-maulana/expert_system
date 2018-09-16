var listSymptomsSchema = [
    { "data": "id", "name": "id", "title": "Id" },
    { "data": "name", "name": "gejala", "title": "Gejala"},
    { "data": "level", "level": "level", "title": "Level"},
];
var customDom = "<'row'<'col-sm-6 col-md-2 add-symptoms'><'col-sm-6 col-md-4'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";

initDataTables("table-list-symptoms", "list_symptoms", listSymptomsSchema, customDom);
$(".add-symptoms").append("<button class='btn btn-primary btn-sm'>Tambah Gejala</button>");
