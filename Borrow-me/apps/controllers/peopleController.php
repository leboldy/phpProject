<?php
class PeopleController {
    
    //VIEW
    
    public function peopleMovementPage() {
        require_once ('apps/views/pages/people/peopleMovementPage.php');
    }
    
    public function peopleAddPage() {
        require_once ('apps/views/pages/people/peopleAddPage.php');
    }
    
    public function clientMovementPage() {
        require_once ('apps/views/pages/people/clientMovementPage.php');
    }
    
    public function investorMovementPage() {
        require_once ('apps/views/pages/people/investorMovementPage.php');
    }
    
    public function adminMovementPage() {
        require_once ('apps/views/pages/people/adminMovementPage.php');
    }
    
    public function vendorMovementPage() {
        require_once ('apps/views/pages/people/vendoMovementPage.php');
    }
   /*  
    public function addPeoplePage() {
        require_once ('apps/views/pages/people/peopleMovementPage.php');
    }
    
    public function seePeoplePage() {
       // $peo = People::getListPeople();
        //require_once ('apps/models/peopleRoles.php');
        require_once ('apps/views/pages/people/seePeoplePage.php');
    }
    
    public function seePeopleDetailed() {
        if(!isset($_GET['peopleId']))
            return call('pages', 'error');
            
            $people = People::getPeoplebyId($_GET['peopleId']);
            
            require_once ('apps/models/peopleRoles.php');
            $peoRole = PeopleRoles::getPeopleRoleByPeopleId($_GET['peopleId']);
            
            require_once ('apps/views/pages/people/updatePeoplePage.php');
    } 
    
    // ==========================================================

    
    public function updatePeople() {
        People::updatePeople();
        //$this->seePeoplePage();
    }*/
    
    //CLIENT SERVICES
    public static function getPeopleJson() {
        if (isset($_GET['roleType'])) {
            $roleType = $_GET['roleType'];
            $peo = People::getPeopleByRoleType($roleType);
        } else if (isset($_GET['notRoleType'])) {
            $roleType = $_GET['notRoleType'];
            $peo = People::getPeopleExceptByRoleType($roleType);
        } else {
            $peo = People::getListPeople();
        }
        print_r(json_encode($peo));
    } 
    
    public static function updatePeopleAndRole() {
        People::updatePeopleAndRole();
    }
    
    public static function deletePeopleById() {
        People::deletePeopleById();
    }
    
    public static function getInvestorJson() {
        $investor = People::getPeopleByRoleType('I');
        print_r(json_encode($investor));
    }
    
    public static function addPeople() {
        People::submitPeople();
    }
}
?>