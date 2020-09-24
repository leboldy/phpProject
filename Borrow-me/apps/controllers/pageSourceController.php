<?php 
    
if (isset($controller) && isset($action)) {
    
    //ACCOUNT
    if ($controller == 'account' && $action == 'accountAddPage') { ?>
        
        <title>Adicionar conta</title>
        <?php require_once ('web/sources/dataGrid.php');?>
               
   		<link rel="stylesheet" type="text/css" href="web/css/account/accountAdd.css" />
		<script src="web/js/account/accountAdd.js"></script>
        
    <?php }

    if ($controller == 'account' && $action == 'accountMovementPage') { ?>
        
        <title>Movimentação de créditos</title>
        <?php require_once ('web/sources/dataGrid.php');?>
               
        <link rel="stylesheet" type="text/css" href="web/css/account/accountMovement.css" />
        
    	<script src="web/js/account/accountMovement.js"></script>      
    <?php }
    
    // LENDING
    if ($controller == 'lending' && $action == 'addLendingPage') { ?>
        
        <title>Realizar empréstimos</title>
        <?php require_once ('web/sources/dataGrid.php');?>
               
        <link rel="stylesheet" type ="text/css" href ="web/css/lending/lendingAdd.css" />
        <script src="web/js/lending/lendingAdd.js"></script>
    <?php }
    
    if ($controller == 'lending' && $action == 'seeLendingPage') { ?>
        
        <title>Movimentação de empréstimos</title>
        <?php require_once ('web/sources/dataGrid.php');?>
               
        <link rel="stylesheet" type ="text/css" href ="web/css/lending/lendingMovement.css" />
        <script src="web/js/lending/lendingMovement.js"></script>
    <?php }
    
    // RECEIVE
    if ($controller == 'receive' && $action == 'seeToReceiveToExpirePage') { ?>
        
        <title>Empréstimos à vencer</title>
        <?php require_once ('web/sources/dataGrid.php');?>
               
        <link rel="stylesheet" type ="text/css" href ="web/css/receive/receiveMovement.css" />
        <script src="web/js/receive/receiveMovement.js"></script>
    <?php }
    
    // FEES
    if ($controller == 'fees' && $action == 'addFeesPage') { ?>
        
        <title>Realizar retirada</title>
        <?php require_once ('web/sources/dataGrid.php');?>
               
        <link rel="stylesheet" type ="text/css" href ="web/css/fees/feesAdd.css" />
        <script src="web/js/fees/feesAdd.js"></script>
    <?php }
    
    if ($controller == 'fees' && $action == 'feesMovementPage') { ?>
        
        <title>Retiradas realizadas</title>
        <?php require_once ('web/sources/dataGrid.php');?>
               
        <link rel="stylesheet" type ="text/css" href ="web/css/fees/feesMovement.css" />
        <script src="web/js/fees/feesMovement.js"></script>
    <?php }
    
    // PEOPLE 
    if ($controller == 'people' && $action == 'peopleAddPage') { ?>
        
        <title>Adicionar / remover pessoas</title>
        <?php require_once ('web/sources/dataGrid.php');?>
               
        <link rel="stylesheet" type ="text/css" href ="web/css/people/peopleMovement.css" />
        <script src="web/js/people/peopleAdd.js"></script>
    <?php }
}
?>


