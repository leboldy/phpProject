var source = new DevExpress.data.DataSource({
 
    load: function(loadOptions) {
        return $.getJSON("http://localhost/github/Borrow-me/apps/services/peopleServices.php");
    },
 
    key: "peopleId",
/*
    insert: function (values) {
        return $.ajax({
            url: "http://localhost/github/Borrow-me/apps/services/peopleServices.php",
            method: "POST",
            data: values
        })
    },*/
    
    remove: function (key) {
        return $.ajax({
            url: "http://localhost/github/Borrow-me/apps/services/peopleServices.php?peopleId="+ encodeURIComponent(key),
            method: "DELETE"
        })
    },
    
    update: function (key, values) {
        return $.ajax({
            url: "http://localhost/github/Borrow-me/apps/services/peopleServices.php?peopleId="+ encodeURIComponent(key),
            method: "PUT",
            data: values
        })
    }
 
});

$(function(){   
    $("#gridContainer").dxDataGrid({
    	dataSource: source, 
      /*  filterRow: {
            visible: true,
            applyFilter: "auto"
        },*/
        /* headerFilter: {
        visible: true
    	},*/
        
        searchPanel: {
            visible: true,
            width: 240,
            placeholder: "Search..."
        },

        paging: {
            pageSize: 10
        },
       // hoverStateEnabled: true,
        showRowLines: true,
        rowAlternationEnabled: true,
        pager: {
            showPageSizeSelector: true,
            allowedPageSizes: [5, 10, 20],
            showInfo: true
        },
        editing: {
            mode: "row",
            allowUpdating: true,
            allowDeleting: true
            //allowAdding: true
        }, 
        columns: [
        	{
                dataField: "peopleId",
                allowEditing: false,
                visible: false
            },{
                dataField: "peopleFullName",
                caption: "Nome Completo",
                sortOrder: "asc",
                validationRules: [{ type: 'required' }]
            },{
                dataField: "peopleNickname",
                caption: "Apelido"
            }
        ]
       
    });
});