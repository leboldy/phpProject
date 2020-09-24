var serviceURL = window.location.protocol + "//" + window.location.host + "/" + window.location.pathname;

var source = new DevExpress.data.DataSource({
	 
	load: function() {
        var d = new $.Deferred();
        $.getJSON(serviceURL + "apps/services/lendingServices.php")
            .done(function (dataItem) {
                d.resolve(dataItem);
            });
        return d.promise();
    },
 
    key: "lendingId",

    insert: function (values) {
        return $.ajax({
            url: serviceURL + "apps/services/lendingServices.php",
            method: "POST",
            data: values
        })
    }
});

var investor = new DevExpress.data.CustomStore({
    key: "investorId",

	loadMode: "raw",
    load: function() {
        return $.getJSON(serviceURL + "apps/services/investorsMoneyServices.php");
    }
});

var client = new DevExpress.data.CustomStore({
    key: "peopleId",

	loadMode: "raw",
    load: function() {
        return $.getJSON(serviceURL + "apps/services/peopleServices.php?roleType=C");
    }
});

var vendor = new DevExpress.data.CustomStore({
    key: "peopleId",

	loadMode: "raw",
    load: function() {
        return $.getJSON(serviceURL + "apps/services/peopleServices.php?roleType=V");
    }
});

$(function(){
    $("#gridContainer").dxDataGrid({
        dataSource: source,
        allowColumnResizing: true,
        showRowLines: true,
        rowAlternationEnabled: true,
        pager: {
            showPageSizeSelector: true,
            //allowedPageSizes: [5, 10, 20],
            showInfo: true
        },
        editing: {
            mode: "row",
            allowAdding: true
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
                lookup: {
                    dataSource: client,
                    valueExpr: "peopleId",
                    displayExpr: "peopleFullName"
                },
                validationRules: [{ type: 'required' }]
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
                lookup: {
                    dataSource: vendor,
                    valueExpr: "peopleId",
                    displayExpr: "peopleFullName"
                },
                validationRules: [{ type: 'required' }]
            },{
                caption: "Investidor",
                dataField: "investorId",
                lookup: {
                    dataSource: investor,
                    valueExpr: "investorId",
                    displayExpr: "peopleFullName"
                },
                validationRules: [{ type: 'required' }]
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