<p>ALTERAR RETIRADA</p>
<?php
    $people = People::getPeoplebyId($fee->peopleId);
    echo 'ID: ',$fee->feesId; 
    echo ' Pessoa: ',$people->fullName;
    echo ' Data da Retirada: ',$fee->feesDate;
    echo ' Total Retirado: ',$fee->feesValue;
 ?>   
 
<form action="/github/Borrow-me/index.php?controller=fees&action=updateFees" method="POST">
    <input type="hidden" name="feesId" value="<?php echo $fee->feesId?>">
    
    <p>Pessoa: 
        <select required name="peopleId" id="peopleId" >
          <option value="">Selecione</option>
          <?php foreach($peopleListToPay as $fees) { ?>
              <option value="<?php echo $fees->peopleId?>" <?php if ($fees->peopleId == $fee->peopleId) {?>
              selected="selected" <?php }?>>
              	<?php $people = People::getPeoplebyId($fees->peopleId); echo $people->fullName,' (R$ ', $fees->feesReceived,')' ?>
              </option>
          <?php } ?>
        </select>
        
    <p>Data da Retirada: <input type="date" name="feesDate" required value="<?php echo $fee->feesDate;?>"></p>
    <p>Total Retirado: <input id="totalWithdrawn" type="number" name="feesValue" required="required" value="<?php echo $fee->feesValue;?>"></p>
    <button id="sub" >Salvar</button>
</form>