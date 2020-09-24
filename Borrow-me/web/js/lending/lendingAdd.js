
var vendors = new DevExpress.data.CustomStore({
    loadMode: "raw",
    load: function() {
        return $.getJSON("apps/services/peopleServices.php?roleType=V");
    }
});

var investorsMoney = new DevExpress.data.CustomStore({
    loadMode: "raw",
    load: function() {
        return $.getJSON("apps/services/investorsMoneyServices.php");
    }
});

var clients = new DevExpress.data.CustomStore({
    loadMode: "raw",
    load: function() {
        return $.getJSON("apps/services/peopleServices.php?roleType=C");
    }
});


$(function(){
    $("#form").dxForm({
       // readOnly: false,
        showColonAfterLabel: true,
        showValidationSummary: true,
        validationGroup: "customerData",
        items: [{
            dataField: "vendorId",
            label: {
                text: "Vendedor"
            },
            editorType: "dxLookup",
            editorOptions: {
                dataSource: vendors,
	        	valueExpr: 'peopleId',
	            displayExpr: 'peopleFullName'
            },
            validationRules: [{ type: "required" }]
        },{
            dataField: "investorId",
            label: {
                text: "Investidor"
            },
            editorType: "dxLookup",
            editorOptions: {
                dataSource: investorsMoney,
	        	valueExpr: 'investorId',
	            displayExpr: 'peopleFullName'
            },
            validationRules: [{ type: "required" }]
        },{
            dataField: "clientId",
            label: {
                text: "Cliente"
            },
            editorType: "dxLookup",
            editorOptions: {
                dataSource: clients,
	        	valueExpr: 'peopleId',
	            displayExpr: 'peopleFullName'
            },
            validationRules: [{ type: "required" }]
        },{
            dataField: "lendingDate",
            editorType: "dxDateBox",
            label: {
                text: "Data Empréstimo"
            },
            editorOptions: {
                value: new Date()
            },
            validationRules: [{ type: "required" }]
        },{
            dataField: "totalLended",
            label: {
                text: "Valor Emprestado"
            },
            format: {
                type: "currency",
                currency: "BRL",
                precision: 2
            },
            editorOptions: {
                format: "R$ #.##0,##"
            },
            editorType: "dxNumberBox",
            validationRules: [{ type: "required"}]
        }]
    }).dxForm("instance");
    
    $("#form-container").on("submit", function(e) {
        //alert("The Button was clicked");

        DevExpress.ui.notify({
            message: "Crédito realizado com sucesso!",
            position: {
                my: "center top",
                at: "center top"
            }
        }, "success", 50000);

    });
    

    $("#button").dxButton({
        text: "Salvar",
        type: "success",

        useSubmitBehavior: true,
        validationGroup: "customerData"
    });
});