var serviceURL = window.location.protocol + "//" + window.location.host + "/" + window.location.pathname;

var source = new DevExpress.data.DataSource({
 
    load: function(loadOptions) {
        return $.getJSON(serviceURL + "apps/services/feesServices.php");
    },
 
    key: "feesId",
    
    remove: function (key) {
        return $.ajax({
            url: serviceURL + "apps/services/feesServices.php?feesId="+ encodeURIComponent(key),
            method: "DELETE"
        })
    },
    
    update: function (key, values) {
        return $.ajax({
            url: serviceURL + "apps/services/feesServices.php?feesId="+ encodeURIComponent(key),
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
        grouping: {
	        autoExpandAll: false,
	    },
        paging: {
            pageSize: 15
        },
        showRowLines: true,
        rowAlternationEnabled: true,
        pager: {
            showPageSizeSelector: true,
            showInfo: true
        },
        editing: {
            mode: "row",
            allowUpdating: true,
            allowDeleting: true
        }, 
        columns: [
        	{
                dataField: "feesId",
                allowEditing: false,
                visible: false
            },{
            	caption: "Pessoa",
                dataField: "peopleId",
                sortOrder: "asc",
                allowEditing: false,
                lookup: {
                    dataSource: people,
                    valueExpr: "peopleId",
                    displayExpr: "peopleFullName"
                },
                groupIndex: 0
            },{
                dataField: "feesDate",
                caption: "Data da retirada",
                dataType: "date",
                validationRules: [{ type: 'required' }]
            },{
                dataField: "feesValue",
                caption: "Valor",
                allowEditing: false,
                dataType: "number",
                format: "currency",
                editorOptions: {
                    format: "$ #.##0,##"
                },
                validationRules: [{ type: 'required' }]
            },{
                dataField: "feesFlgCredit",
                caption: "Adicionado como crédito",
                dataType: "boolean",
                allowEditing: false
            }
        ],
        sortByGroupSummaryInfo: [{
            summaryItem: "count"
        }],
        summary: {
            groupItems: [{
                column: "feesId",
                summaryType: "count",
                displayFormat: "{0} retiradas",
            },{
                column: "feesValue",
                summaryType: "sum",
                valueFormat: "currency",
                displayFormat: "Total: {0}"            }]
        }
    });
});