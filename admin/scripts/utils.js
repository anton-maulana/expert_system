function initDataTables(element, type){  
    console.log("masuk ke sini");  
    $('#'+element).DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "../api/dataApi.php?type="+type
    } );
}