<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

tr:hover {
    background-color: #f5f5f5;
}
</style>
<p>DETALHES DO EMPRÉSTIMO</p>
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


<table>
  <thead align="left">
  <tr>
     <th>ID </th>
     <th>EMP-ID </th>
     <th>Valor a receber</th>
     <th>Data a receber</th>
     <th>Juros a receber Admin</th>
     <th>Juros a receber Vendedor</th>
     <th>Juros a receber Investidor</th>
     <th>Valor pago</th>
     <th>Data do pagamento</th>
     <th>Juros recebido Admin</th>
     <th>Juros recebido Vendedor</th>
     <th>Juros recebido Investidor</th>
     <th>-</th>
  </tr>
  </thead>
<tbody>
<?php 
$total = 0;
foreach ($toReceive as $receive) {?>
  <tr class="item_row">
        <td> <?php echo $receive->receiveId; ?></td>
        <td> <?php echo $receive->lendingId; ?></td>
        <td> <?php echo $receive->valueToReceive; ?></td>
        <td> <?php echo $receive->dateToReceive; ?></td>
        <td> <?php echo $receive->adminFeeToReceive; ?></td>
        <td> <?php echo $receive->vendorFeeToReceive; ?></td>
        <td> <?php echo $receive->investorFeeToReceive; ?></td>
        <td> <?php echo $receive->valueReceived; ?></td>
        <td> <?php echo $receive->dateReceived; ?></td>
        <td> <?php echo $receive->adminFeeReceived; ?></td>
        <td> <?php echo $receive->vendorFeeReceived; ?></td>
        <td> <?php echo $receive->investorFeeReceived; ?></td>
        <td> <a href='?controller=receive&action=updateReceivePage&lendingId=<?php echo $lending->lendingId; ?>&receiveId=<?php echo $receive->receiveId; ?>'>Alterar</a></td>
  </tr>
</tbody>
<?php }?>
</table>
