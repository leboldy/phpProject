var serviceURL = window.location.protocol + "//" + window.location.host + "/" + window.location.pathname;

var url_string = window.location.href;
var url = new URL(url_string);
var peopleId = url.searchParams.get("peopleId");
//console.log(peopleId);

//alert (window.location.href);

var test = {
	"peopleId" : "24",
	"peopleFullName" : "br\u00e1ulio da Silva \u00c7auros",
	"peopleNickname" : "z\u00f3i\u00e3o",
	"peopleEmail" : 'test@te.com',
	"peoplePhone" : '326325099',
	"peopleReference" : 'amigo do gordinho'
}


var source1 = $.ajax(serviceURL + "apps/services/peopleRolesServices.php?peopleId=" + encodeURIComponent(peopleId));
	    

var source = new DevExpress.data.DataSource({
	    load: function(){
	        return  $.getJSON(serviceURL + "apps/services/peopleRolesServices.php?peopleId=" + encodeURIComponent(peopleId));
	    }
	});

	
console.log(encodeURIComponent(peopleId));
console.log(test);

console.log(source);
console.log(source1);

console.log(source1.peopleFullName);

$(function(){
    $("#form").dxForm({
       // readOnly: false,
        formData: source,
        showColonAfterLabel: true,
        showValidationSummary: true,
        validationGroup: "customerData",
        items: [{
            dataField: "peopleFullName",
            label: {
                text: "Nome Completo"
            },
            validationRules: [{ type: 'required' }],
            editorType: "dxTextBox"
        },{
            dataField: "peopleNickname",
            label: {
                text: "Apelido"
            },
            editorType: "dxTextBox"
        },{
            dataField: "peopleEmail",
            label: {
                text: "Email"
            },
            validationRules: [{ 
            	type: "email" 
            }],
            editorType: "dxTextBox"
        },{
            dataField: "peoplePhone",
            editorType: "dxTextBox",
            label: {
                text: "Telefone"
            },
            validationRules: [{
                type: "stringLength",
                message: "Máximo 15 caracteres.",
                max: 15
            }]
        },{
            dataField: "peopleReference",
            label: {
                text: "Referência"
            },
            editorType: "dxTextArea",
            helpText: "Ex.: Amigo do gordinho, Cabeleireiro de macatuba, etc.",  
        },{
            dataField: "peopleFlgClient",
            editorType: "dxCheckBox",
            dataSource: [1,0],

            label: {
                text: "Cliente"
            }
        },{
            dataField: "peopleFlgAdmin",
            editorType: "dxCheckBox",
            dataSource: [1,0],

            label: {
                text: "Administrador"
            }
        },{
            dataField: "peopleFlgVendor",
            editorType: "dxCheckBox",
            dataSource: [1,0],

            label: {
                text: "Vendedor"
            }
        },{
            dataField: "peopleFlgInvestor",
            editorType: "dxCheckBox",
            dataSource: [1,0],

            label: {
                text: "Investidor"
            }
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