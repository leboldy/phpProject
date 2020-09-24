
var peopleFeesToPay = new DevExpress.data.CustomStore({
    loadMode: "raw",
    load: function() {
        return $.getJSON("apps/services/peopleFeesToPayServices.php");
    }
});


$(function(){
    $("#form").dxForm({
       // readOnly: false,
        showColonAfterLabel: true,
        showValidationSummary: true,
        validationGroup: "customerData",
        items: [{
            dataField: "feesDate",
            editorType: "dxDateBox",
            label: {
                text: "Data da Retirada"
            },
            validationRules: [{ type: "required" }]
        },{
            dataField: "peopleId",
            label: {
                text: "Pessoa"
            },

            editorType: "dxLookup",
            editorOptions: {
                dataSource: peopleFeesToPay,
	        	valueExpr: 'peopleId',
	            displayExpr: 'peopleFullName'
            },
            validationRules: [{ type: "required" }]
        },{
            dataField: "feesValue",
            label: {
                text: "Valor Retirado"
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
            dataField: "feesFlgCredit",
            editorType: "dxCheckBox",
            dataSource: [1,0],

            label: {
                text: "Adicionar como crédito*"
            },
            helpText: "*Caso selecionado, irá adicionar o 'Valor Retirado' como crédito à pessoa. ESSA OPERAÇÃO NÃO PODE SER DESFEITA!"
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
        }, "success", 5000);

    });
    

    $("#button").dxButton({
        text: "Salvar",
        type: "success",

        useSubmitBehavior: true,
        validationGroup: "customerData"
    });
});