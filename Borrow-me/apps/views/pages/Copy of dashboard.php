<html>
  <head>
  </head>
  <body>
    <header>
      <?php echo "Usuario: ",$_SESSION['username']?>
      <a href='?controller=pages&action=dashboard'> <img alt="Home" src="web/icons/house-icon.png" width="40" height="40"> </a> 
      <a href='?controller=login&action=userLogout'><img alt="Logout" src="web/icons/logout-icon.png" width="40" height= "40"></a>
      
      <p>CONTAS
      	<a href='?controller=account&action=addAccountPage'>Adicionar Crédito</a>
      	<a href='?controller=account&action=seeAccountListPage'>Consultar Créditos</a>
	  </p>
	  <p>PESSOAS
      	<a href='?controller=people&action=addPeoplePage'>Adicionar Pessoas</a>
      	<a href='?controller=people&action=seePeoplePage'>Consultar Pessoas</a>
	  </p>       
      <p>EMPRESTIMOS
      	<a href='?controller=lending&action=addLendingPage'>Realizar Empréstimo</a> 
      	<a href='?controller=lending&action=seeLendingPage'>Consultar Empréstimo</a> 
      	<a href='?controller=receive&action=seeToReceiveToExpirePage'>Consultar Empréstimos a vencer</a>
      </p>
      <p>JUROS
      	<a href='?controller=fees&action=addFeesPage'>Realizar Retirada</a> 
      	<a href='?controller=fees&action=seeFeesPage'>Consultar Retiradas</a> 
      </p>
    </header>
		<?php require_once 'config/routes.php';?>
    <footer>
      Copyright
    </footer>
  <body>
<html>