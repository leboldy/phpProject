
var investors = new DevExpress.data.CustomStore({
    loadMode: "raw",
    load: function() {
        return $.getJSON("apps/services/investorsServices.php");
    }
});


$(function(){
    $("#form").dxForm({
       // readOnly: false,
        showColonAfterLabel: true,
        showValidationSummary: true,
        validationGroup: "customerData",
        items: [{
            dataField: "accountDate",
            editorType: "dxDateBox",
            label: {
                text: "Data depósito"
            },
            editorOptions: {
                value: new Date()
            },
            validationRules: [{ type: "required" }]
        },{
            dataField: "peopleId",
            label: {
                text: "Investidor"
            },
            displayExpr: "Name",

            editorType: "dxLookup",
            editorOptions: {
                dataSource: investors,
	        	valueExpr: 'peopleId',
	            displayExpr: 'peopleFullName'
            },
            validationRules: [{ type: "required" }]
        },{
            dataField: "accountValue",
            label: {
                text: "Valor"
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
        },{
            dataField: "accountNotes",
            label: {
                text: "Notas"
            },
            editorType: "dxTextArea",
            helpText: "Ex.: transferido via banco, pago via gordinho, etc.",  
        }]
    }).dxForm("instance");
    
    $("#form-container").on("submit", function(e) {
        //alert("The Button was clicked");

        DevExpress.ui.animation({
            message: "Crédito realizado com sucesso!",
            position: {
                my: "center top",
                at: "center top"
            }
        }, "success", 5000);
        //e.preventDefault();
    });
    
    

    $("#button").dxButton({
        text: "Salvar",
        type: "success",

        useSubmitBehavior: true,
        validationGroup: "customerData"
        	
    	/*onClick: function (params) {
            var result = params.validationGroup.validate();
            if (result.isValid) {
                DevExpress.ui.notify({
                    message: "Your phone number is submitted.",
                    position: {
                        my: "left top",
                        at: "left top",
                    }
                }, "Success", 3000000);
            }
        }*/
    });
});