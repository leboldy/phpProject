
<div id="usernameLabel" >
	<label for="username"><?php echo "@",$_SESSION['username']?></label>
</div>

<div id='cssmenu'>
    <ul>
       <li class='active'><a href='?controller=pages&action=home'>Home</a></li>
       <li><a>Contas</a>
          <ul>
             <li><a href='?controller=account&action=accountAddPage'>Adicionar Crédito</a></li>
             <li><a href='?controller=account&action=accountMovementPage'>Movimentação</a></li>
          </ul>
       </li>

       <li><a>Pessoas</a>
          <ul>
             <li><a href='?controller=people&action=peopleAddPage'>Adicionar / Remover</a></li>
          </ul>
       </li>

       <li><a>Emprestimos</a>
          <ul>
             <li><a href='?controller=lending&action=addLendingPage'>Realizar Emprestimo</a></li>
             <li><a href='?controller=lending&action=seeLendingPage'>Movimentação</a></li>
             <li><a href='?controller=receive&action=seeToReceiveToExpirePage'>Consultar a vencer</a></li>
          </ul>
       </li>

       <li><a>Juros</a>
          <ul>
             <li><a href='?controller=fees&action=addFeesPage'>Realizar Retirada</a></li>
             <li><a href='?controller=fees&action=feesMovementPage'>Consultar Retiradas</a></li>
          </ul>
       </li>
       <li><a href='?controller=login&action=userLogout'>Sair</a></li>
    </ul>
</div>