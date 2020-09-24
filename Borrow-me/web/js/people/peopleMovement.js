var serviceURL = window.location.protocol + "//" + window.location.host + "/" + window.location.pathname;

var source = new DevExpress.data.DataSource({
	 
    load: function(loadOptions) {
        return $.getJSON(serviceURL + "apps/services/peopleServices.php");
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
            allowDeleting: true,
            allowAdding: true
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
            },{
                dataField: "peopleEmail",
                caption: "Email",
                validationRules: [{ 
                	type: "email" 
                }]
            },{
                dataField: "peoplePhone",
                caption: "Telephone",
                validationRules: [{
                    type: "stringLength",
                    message: "Máximo 15 caracteres.",
                    max: 15
                }]
            },{
                dataField: "peopleReference",
                caption: "Referência"
            },{
                dataField: "Title",
                cellTemplate: function(container, options) {
                	container.append("<a href=?controller=people&action=peopleAddPage&peopleId="+ options.data.peopleId + ">Alterar</a>")
                            .css("color", "blue");
                }
            }
        ]
       
    });
});

