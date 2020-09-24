var serviceURL = window.location.protocol + "//" + window.location.host + "/" + window.location.pathname;

var source = new DevExpress.data.DataSource({
	 
    load: function(loadOptions) {
        return $.getJSON(serviceURL + "apps/services/lendingServices.php");
    },
 
    key: "lendingId",

    insert: function (values) {
        return $.ajax({
            url: serviceURL + "apps/services/lendingServices.php",
            method: "POST",
            data: values
        })
    },
    
    remove: function (key) {
        return $.ajax({
            url: serviceURL + "apps/services/lendingServices.php?lendingId="+ encodeURIComponent(key),
            method: "DELETE"
        })
    },
    
    update: function (key, values) {
        return $.ajax({
            url: serviceURL + "apps/services/lendingServices.php?lendingId="+ encodeURIComponent(key),
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

      
        showRowLines: true,
        rowAlternationEnabled: true,
        pager: {
            showPageSizeSelector: true,
            //allowedPageSizes: [5, 10, 20],
            showInfo: true
        },
        editing: {
            mode: "row",
            allowUpdating: true,
            allowDeleting: true
        }, 
        columns: [{
                dataField: "lendingId",
                caption: "ID",
                allowEditing: false,
                visible: false
            },{
                caption: "Data Empréstimo",
                dataField: "lendingDate",
                sortOrder: "desc",
                dataType: "date",
                validationRules: [{ type: 'required' }]
            },{
                caption: "Cliente",
                dataField: "clientId",
                allowEditing: false,
                lookup: {
                    dataSource: people,
                    valueExpr: "peopleId",
                    displayExpr: "peopleFullName"
                }
            },{
                caption: "Total",
                dataField: "totalLended",
                dataType: "number",
                format: "currency",
                editorOptions: {
                    format: "R$ #.##0,##"
                },
                validationRules: [{ type: 'required' }]
            },{
                caption: "Vendedor",
                dataField: "vendorId",
                allowEditing: false,
                lookup: {
                    dataSource: people,
                    valueExpr: "peopleId",
                    displayExpr: "peopleFullName"
                }
            },{
                caption: "Investidor",
                dataField: "investorId",
                allowEditing: false,
                lookup: {
                    dataSource: people,
                    valueExpr: "peopleId",
                    displayExpr: "peopleFullName"
                }
            },{
                caption: "Administrador",
                dataField: "adminId",
                allowEditing: false,
                lookup: {
                    dataSource: people,
                    valueExpr: "peopleId",
                    displayExpr: "peopleFullName"
                }
            }
        ],
        masterDetail: {
            enabled: true,
            template: function(container, options) { 
                var currentLendingData = options.data;

                $("<div>")
                    .addClass("master-detail-caption")
                    .text("Detalhes do empréstimo")
                    .appendTo(container);

                $("<div>")
                    .dxDataGrid({
                        columnAutoWidth: true,
                        showBorders: true,
                        editing: {
                            mode: "row",
                            allowAdding: true,
                            allowUpdating: true,
                            allowDeleting: true
                        },

                        dataSource: new DevExpress.data.DataSource({
                            load: function() {
                                var d = new $.Deferred();
                                $.getJSON(serviceURL + "apps/services/receiveServices.php?lendingId=" + encodeURIComponent(options.data.lendingId))
                                    .done(function (dataItem) {
                                        d.resolve(dataItem);
                                    });
                                return d.promise();
                            },
                            
                            insert: function (values) {
                                return $.ajax({
                                    url: serviceURL + "apps/services/receiveServices.php?lendingId=" + encodeURIComponent(options.data.lendingId),
                                    method: "POST",
                                    data: values
                                })
                            },
                           
                            key: "receiveId",

                            remove: function (key) {
                                return $.ajax({
                                    url: serviceURL + "apps/services/receiveServices.php?receiveId=" + encodeURIComponent(key),
                                    method: "DELETE"
                                })
                            },
                            
                            update: function (key, values) {
                                return $.ajax({
                                    url: serviceURL + "apps/services/receiveServices.php?receiveId=" + encodeURIComponent(key),
                                    method: "PUT",
                                    data: values
                                })
                            }
                        }),
                        columns: [{
                            dataField: "receiveId",
                            caption: "ID",
                            allowEditing: false,
                            visible: false
                        }, {
                        	caption: "À receber",
                        	columns: [
                        		{
                                    dataField: "dateToReceive",
                                    dataType: "date",
                                    caption: "Data",
                                    sortOrder: "asc",
                                    validationRules: [{ type: 'required' }]
                                },{
                                    dataField: "valueToReceive",
                                    caption: "Valor",
                                    dataType: "number",
                                    format: "currency",
                                    editorOptions: {
                                    	format: "R$ #.##0,##"
                                    },
                                    validationRules: [{ type: 'required' }]
                                },{
                                    dataField: "adminFeeToReceive",
                                    caption: "Juros admin",
                                    dataType: "number",
                                    format: "currency",
                                    editorOptions: {
                                    	format: "R$ #.##0,##"
                                    }
                                },{
                                    dataField: "vendorFeeToReceive",
                                    caption: "Juros vendedor",
                                    dataType: "number",
                                    format: "currency",
                                    editorOptions: {
                                    	format: "R$ #.##0,##"
                                    }
                                
                                },{
                                    dataField: "investorFeeToReceive",
                                    caption: "Juros investidor",
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
                                },{
                                	dataField: "lendingId",
                                	visible: false
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
                    }).appendTo(container);
            }
        },
        summary: {
        	totalItems: [{
        		column: "totalLended",
        		summaryType: "sum",
                valueFormat: "currency"
        	}]
        }
    });
});