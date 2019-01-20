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

function showToaster(data, successMessages){
    if(data["status"] == "success"){
        $.toast({
            heading: 'Success',
            text: successMessages,
            showHideTransition: 'slide',
            icon: 'success'
        });
        table.ajax.reload();
    }
    else {
        $.toast({
            heading: 'Error',
            text: 'Terjadi Kesalahan \n'+ data["error"],
            showHideTransition: 'slide',
            icon: 'error'
        });
    }
}