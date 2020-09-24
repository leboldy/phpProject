var serviceURL = window.location.protocol + "//" + window.location.host + "/" + window.location.pathname;

var source = new DevExpress.data.DataSource({
	 
    load: function(loadOptions) {
        return $.getJSON(serviceURL + "apps/services/receiveServices.php");
    },
 
    key: "receiveId",
    
    update: function (key, values) {
        return $.ajax({
            url: serviceURL + "apps/services/receiveServices.php?receiveId="+ encodeURIComponent(key),
            method: "PUT",
            data: values
        })
    }
 
});

var people = new DevExpress.data.CustomStore({
    key: "peopleId",

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
        headerFilter: {
            visible: true
        },
      
        showRowLines: true,
        rowAlternationEnabled: true,
        pager: {
            showPageSizeSelector: true,
            //allowedPageSizes: [5, 10, 20],
            showInfo: true
        },
        editing: {
            mode: "row",
            allowUpdating: true
        }, 
        columns: [{
            dataField: "receiveId",
            caption: "ID",
            allowEditing: false,
            visible: false
        },{
            caption: "Cliente",
            dataField: "clientId",
            allowEditing: false,
            lookup: {
                dataSource: people,
                valueExpr: "peopleId",
                displayExpr: "peopleFullName"
            }
        }, {
        	caption: "À receber",
        	columns: [
        		{
                    dataField: "dateToReceive",
                    dataType: "date",
                    caption: "Data",
                    allowEditing: false,
                    sortOrder: "asc",
                    cssClass: 'red',
                    //https://js.devexpress.com/Documentation/Guide/Widgets/DataGrid/Summaries/Format_Text_and_Value/

                    
                    validationRules: [{ type: 'required' }]
                },{
                    dataField: "valueToReceive",
                    caption: "Valor",
                    allowEditing: false,
                	dataType: "number",
                    format: "currency",
                    headerFilter: {
                        dataSource: [ {
                            text: "Menos que $1000",
                            value: ["valueToReceive", "<", 1000]
                        }, {
                            
                            text: "$1000 - $2000",
                            value: [["valueToReceive", ">=", 1000], ["valueToReceive", "<", 2000]]
                        }, {
                            
                            text: "$2000 - $3000",
                            value: [["valueToReceive", ">=", 2000], ["valueToReceive", "<", 3000]]
                        }, {
                            
                            text: "$3000 - $4000",
                            value: [["valueToReceive", ">=", 3000], ["valueToReceive", "<", 4000]]
                        }, {                    
                            text: "Maior que $4000",
                            value: ["valueToReceive", ">=", 4000]
                        }]
                    },
                    editorOptions: {
                        format: "$ #.##0,##"
                    },
                    validationRules: [{ type: 'required' }]
                },{
                    dataField: "adminFeeToReceive",
                    caption: "Juros admin",
                    allowEditing: false,
                    dataType: "number",
                    format: "currency",
                    editorOptions: {
                        format: "R$ #.##0,##"
                    }
                },{
                    dataField: "vendorFeeToReceive",
                    caption: "Juros vendedor",
                    allowEditing: false,
                    dataType: "number",
                    format: "currency",
                    editorOptions: {
                        format: "R$ #.##0,##"
                    }
                
                },{
                    dataField: "investorFeeToReceive",
                    caption: "Juros investidor",
                    allowEditing: false,
                    dataType: "number",
                    format: "currency",
                    editorOptions: {
                        format: "R$ #.##0,##"
                    }
                }
        	]
        }, {
        	caption: "Recebido",
        	columns: [
        		{
                	dataField: "dateReceived",
                    dataType: "date",
                    caption: "Data"
                
                },{
                    dataField: "valueReceived",
                    caption: "Valor",
                    dataType: "number",
                    format: "currency",
                    editorOptions: {
                        format: "R$ #.##0,##"
                    }
                },{
                    dataField: "adminFeeReceived",
                    caption: "Juros admin",
                    dataType: "number",
                    format: "currency",
                    editorOptions: {
                        format: "R$ #.##0,##"
                    }
                
                },{
                    dataField: "vendorFeeReceived",
                    caption: "Juros vendedor",
                    dataType: "number",
                    format: "currency",
                    editorOptions: {
                        format: "R$ #.##0,##"
                    }
                
                },{
                    dataField: "investorFeeReceived",
                    caption: "Juros investidor",
                    dataType: "number",
                    format: "currency",
                    editorOptions: {
                        format: "R$ #.##0,##"
                    }
                }]
        }],
        summary: {
        	totalItems: [{
        		column: "valueToReceive",
        		summaryType: "sum",
                valueFormat: "currency"
        	},{
        		column: "adminFeeToReceive",
        		summaryType: "sum",
                valueFormat: "currency"
        	},{
        		column: "vendorFeeToReceive",
        		summaryType: "sum",
                valueFormat: "currency"
        	},{
        		column: "investorFeeToReceive",
        		summaryType: "sum",
                valueFormat: "currency"
        	},{
        		column: "valueReceived",
        		summaryType: "sum",
                valueFormat: "currency"
        	},{
        		column: "adminFeeReceived",
        		summaryType: "sum",
                valueFormat: "currency"
        	},{
        		column: "vendorFeeReceived",
        		summaryType: "sum",
                valueFormat: "currency"
        	},{
        		column: "investorFeeReceived",
        		summaryType: "sum",
                valueFormat: "currency"
        	}]
        }
    });
});