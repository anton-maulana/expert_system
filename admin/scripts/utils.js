function initDataTables(element, type, schema, customDom = null){  
    var configDataTables = {
        "processing": true,
        "serverSide": true,
        "ajax": "../api/dataApi.php?type="+type,
        "columns": schema,
        "dom": customDom
    }
    if(customDom)
        configDataTables["dom"] = customDom;
    window ["datatable"] = $('#'+element).DataTable(configDataTables);
}