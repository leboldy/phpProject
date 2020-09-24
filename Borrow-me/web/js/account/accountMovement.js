var serviceURL = window.location.protocol + "//" + window.location.host + "/" + window.location.pathname;

var source = new DevExpress.data.DataSource({
 
    load: function(loadOptions) {
        return $.getJSON(serviceURL + "apps/services/accountServices.php");
    },
 
    key: "accountId",

    insert: function (values) {
        return $.ajax({
            url: serviceURL + "apps/services/accountServices.php",
            method: "POST",
            data: values
        })
    },
    
    remove: function (key) {
        return $.ajax({
            url: serviceURL + "apps/services/accountServices.php?accountId="+ encodeURIComponent(key),
            method: "DELETE"
        })
    },
    
    update: function (key, values) {
        return $.ajax({
            url: serviceURL + "apps/services/accountServices.php?accountId="+ encodeURIComponent(key),
            method: "PUT",
            data: values
        })
    }
 
});

var people = new DevExpress.data.CustomStore({
    loadMode: "raw",
    load: function() {
        return $.getJSON(serviceURL + "apps/services/peopleServices.php");
    }
});


$(function(){   
	
    $("#gridContainer").dxDataGrid({
    	dataSource: source, 
        allowColumnResizing: true,
        searchPanel: {
            visible: true,
            width: 240,
            placeholder: "Pesquisar..."
        },

        paging: {
            pageSize: 10
        },
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
        }, 
        columns: [
        	{
                dataField: "accountId",
                allowEditing: false,
                visible: false
            },{
                dataField: "accountDate",
                caption: "Data do depósito",
                sortOrder: "desc",
                dataType: "date",
                validationRules: [{ type: 'required' }]
            },{
                caption: "Investidor",
                dataField: "peopleId",
                allowEditing: false,
                lookup: {
                    dataSource: people,
                    valueExpr: "peopleId",
                    displayExpr: "peopleFullName"
                },
                validationRules: [{ type: 'required' }]
            },{
                dataField: "accountValue",
                caption: "Valor",
                dataType: "number",
                format: {
                    type: "currency",
                    currency: "BRL"
                   // precision: 2
                },
                editorOptions: {
                    format: "R$ #.##0,##"
                },
                /*format: "currency",
                editorOptions: {
                    format: "R$ #.##0,##"
                },*/
                validationRules: [{ type: 'required' }]
            },{
                dataField: "accountNotes",
                caption: "Comentário"
            }
        ],
        onCellClick: function (clickedCell) {
            clickedCell.cellElement.hasClass("clicked") ? clickedCell.cellElement.removeClass("clicked") : clickedCell.cellElement.addClass("clicked")

/*            DevExpress.ui.notify({
                alert
            	message: "Your phone number is submitted.",
                position: {
                    my: "left top",
                    at: "left top",
                }
            }, "Success", 3000000);
  */      },
        summary: {
        	totalItems: [{
        		column: "accountValue",
        		summaryType: "sum",
                valueFormat: "currency"
        	}]
        }
    });
});