<?php
class PeopleRolesController {
    
    public function seePeopleRolesPage() {
        // $peo = People::getListPeople();
        //require_once ('apps/models/peopleRoles.php');
        require_once ('apps/views/pages/people/seePeopleRolesPage.php');
    }
    
    public static function getPeopleRolesJson() {
        //$peopleId = $_GET['peopleId'];
        $peo = People::getPeoplebyId($peopleId);
        
        $peoRol = PeopleRoles::getPeopleRoleByPeopleId($peopleId); 
        print_r(json_encode($peoRol));
    } 
   
}
?>