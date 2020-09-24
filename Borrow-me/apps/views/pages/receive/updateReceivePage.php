<link rel="stylesheet" type ="text/css" href ="web/css/styles.css" />

<p>ALTERAR EMPRESTIMO</p>
<?php
    $vendor = People::getPeoplebyId($lending->vendorId);
    $investor = People::getPeoplebyId($lending->investorId);
    $client = People::getPeoplebyId($lending->clientId);
    $admin = People::getPeoplebyId($lending->adminId);
    echo 'ID: ',$lending->lendingId; 
    echo ' Vendedor: ',$vendor->fullName; 
    echo ' Investidor: ',$investor->fullName; 
    echo ' Cliente: ',$client->fullName;
    echo ' Admin: ',$admin->fullName; 
    echo ' Data do Emprestimo: ',$lending->lendingDate; 
    echo ' Valor do Emprestimo: ',$lending->totalLended; 
?>     
     
<form action="/github/Borrow-me/index.php?controller=receive&action=updateReceive" method="POST">
	<input type="hidden" name="receiveId" value="<?php echo $toReceive->receiveId;?>">
    <p>Data a receber: <input type="date" name="dateToReceive" required value="<?php echo $toReceive->dateToReceive;?>"></p>
    <p>Valor a receber: <input id="valueToReceive" type="number" name="valueToReceive" required="required" value="<?php echo $toReceive->valueToReceive;?>"></p>
    <p>Juros Admin: <input id="adminFee" type="number" name="adminFee" value="<?php echo $toReceive->adminFeeToReceive;?>"></p>
    <p>Juros Vendor: <input id="vendorFee" type="number" name="vendorFee" value="<?php echo $toReceive->vendorFeeToReceive;?>"></p>
    <p>Juros Investor: <input id="investorFee" type="number" name="investorFee" value="<?php echo $toReceive->investorFeeToReceive;?>"></p>
    
    <p>Data pagamento: <input type="date" name="dateReceived" required value="<?php echo $toReceive->dateReceived;?>"></p>
    <p>Valor pago: <input id="valueReceived" type="number" name="valueReceived" required="required" value="<?php echo $toReceive->valueReceived;?>"></p>
    <p>Juros pago Admin: <input id="adminFeeReceived" type="number" name="adminFeeReceived" value="<?php echo $toReceive->adminFeeReceived;?>"></p>
    <p>Juros pago Vendor: <input id="vendorFeeReceived" type="number" name="vendorFeeReceived" value="<?php echo $toReceive->vendorFeeReceived;?>"></p>
    <p>Juros pago Investor: <input id="investorFeeReceived" type="number" name="investorFeeReceived" value="<?php echo $toReceive->investorFeeReceived;?>"></p>
    
    <button id="sub" >Salvar</button>
</form>
   
