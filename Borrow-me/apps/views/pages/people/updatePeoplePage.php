<link rel="stylesheet" type ="text/css" href ="web/css/styles.css" />

<p>ALTERAR PESSOA</p>
<?php
    echo 'ID: ',$people->peopleId; 
    echo ' Nome: ',$people->peopleFullName; 
    echo ' Apelido: ',$people->peopleNickname;
    echo ' Roles:';    
    foreach ($peoRole as $peopleRole) {
        $role = $peopleRole->roleDescription;
        $role = $role.' ';
        echo $role;
    }
    
 ?>     
     
<form action="/github/Borrow-me/index.php?controller=people&action=updatePeople" method="POST">
    <input type="hidden" name="peopleId" value="<?php echo $people->peopleId?>">
    <p>Nome: <input type="text" name="peopleFullName" required="required" value ="<?php echo $people->peopleFullName?>"></p>
    <p>Apelido: <input id="nickname" type="text" name="peopleNickname" value ="<?php echo $people->peopleNickname?>"></p>
    <p>Administrador: <input id="roleType" type="checkbox" name="roleType[]" value="A" <?php 
                                $count = PeopleRoles::countRoleTypeByPeopleId($people->peopleId, 'A');
                                if($count == 1) {?>
                                	checked<?php }?>> </br>
    	Investidor: <input id="roleType" type="checkbox" name="roleType[]" value="I" <?php 
    	                        $count = PeopleRoles::countRoleTypeByPeopleId($people->peopleId, 'I');
                                if($count == 1) {?>
                                	checked<?php }?>> </br>
    	Vendedor: <input id="roleType" type="checkbox" name="roleType[]" value="V" <?php 
    	                        $count = PeopleRoles::countRoleTypeByPeopleId($people->peopleId, 'V');
                                if($count == 1) {?>
                                	checked<?php }?>> </br>
    	Cliente: <input id="roleType" type="checkbox" name="roleType[]" value="C" <?php 
    	                        $count = PeopleRoles::countRoleTypeByPeopleId($people->peopleId, 'C');
                                if($count == 1) {?>
                                	checked<?php }?>> </br>
    </p>
    
    <button id="sub" >Salvar</button>
</form>
   
