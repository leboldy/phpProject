var serviceURL = window.location.protocol + "//" + window.location.host + "/" + window.location.pathname;

var source = new DevExpress.data.DataSource({
	 
    load: function(loadOptions) {
        return $.getJSON(serviceURL + "apps/services/peopleServices.php?roleType=C");
    },
 
    key: "peopleId",

    insert: function (values) {
        return $.ajax({
            url: serviceURL + "apps/services/peopleServices.php",
            method: "POST",
            data: values
        })
    },
    
    remove: function (key) {
        return $.ajax({
            url: serviceURL + "apps/services/peopleServices.php?peopleId="+ encodeURIComponent(key),
            method: "DELETE"
        })
    },
    
    update: function (key, values) {
        return $.ajax({
            url: serviceURL + "apps/services/peopleServices.php?peopleId="+ encodeURIComponent(key),
            method: "PUT",
            data: values
        })
    }
 
});

var peopleNotClient = new DevExpress.data.CustomStore({
    key: "peopleId",

	loadMode: "raw",
    load: function() {
        return $.getJSON(serviceURL + "apps/services/peopleServices.php?notRoleType=C");
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
            placeholder: "Pesquisar..."
        },

        paging: {
            pageSize: 15
        },
       // hoverStateEnabled: true,
        showRowLines: true,
        rowAlternationEnabled: true,
        pager: {
            showPageSizeSelector: true,
            showInfo: true
        },
        editing: {
            mode: "row",
            allowUpdating: false,
            allowEditing: false,
            allowDeleting: true,
            allowAdding: true
        }, 
        columns: [
        	{
                dataField: "peopleId",
                allowEditing: false,
                visible: true
            },{
                caption: "Nome completo",
                dataField: "peopleId",
                lookup: {
                    dataSource: peopleNotClient,
                    valueExpr: "peopleId",
                    displayExpr: "peopleFullName"
                }
            },{
                dataField: "Title",
                cellTemplate: function(container, options) {
                	container.append("<a href=www.google.com?peopleId="+ options.data.peopleId + ">Alterar</a>")
                            .css("color", "blue");
                }
            }]
    });
});

