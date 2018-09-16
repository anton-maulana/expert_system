function initDataTables(element, type, schema, customDom = null, columnDefs = null){  
    var configDataTables = {
        "processing": true,
        "serverSide": true,
        "ajax": "../api/dataApi.php?type="+type,
        "columns": schema,        
    }
    if(customDom)
        configDataTables["dom"] = customDom;
    if(columnDefs)
        configDataTables["columnDefs"] = columnDefs;

    return $('#'+element).DataTable(configDataTables);
}