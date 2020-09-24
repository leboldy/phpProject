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

<p>LISTA DE PESSOAS</p>

<table>
  <thead align="left">
  <tr>
     <th>ID </th>
     <th>Nome</th>
     <th>Apelido</th>
     <th>Roles</th>
     <th>-</th>
  </tr>
  </thead>
<tbody>
<?php 
foreach ($peo as $people) {?>
  <tr class="item_row">
        <td> <?php echo $people->peopleId; ?></td>
        <td> <?php echo $people->peopleFullName; ?></td>
        <td> <?php echo $people->peopleNickname; ?></td>
        <td> <?php 
                $peoRole = PeopleRoles::getPeopleRoleByPeopleId($people->id);
        
                foreach ($peoRole as $peopleRole) {
                    $role = $peopleRole->roleDescription;
                    $role = $role.' ';
                    echo $role;
                }
              ?>
        </td>
        <td> <a href='?controller=people&action=seePeopleDetailed&peopleId=<?php echo $people->peopleId; ?>'>Editar</a></td>
  </tr>
</tbody>
<?php }?>
</table>
