<?php
class FeesController {
    
    //VIEW
    public function feesMovementPage() {
        require_once ('apps/views/pages/fees/feesMovementPage.php');
    }
    
     public function addFeesPage() {
        //$fee = Fees::getAdminListFeesToPay();
       // require_once ('apps/models/people.php');
       // $peopleListToPay = Fees::getPeopleListFeesToPay();
        require_once ('apps/views/pages/fees/addFeesPage.php');
    }
   /* 

    
    public function updateFeesPage() {
        if (!isset($_GET['feesId']))
            return call('page', 'error');
        $fee = Fees::getFeesByFeesId($_GET['feesId']);
        require_once ('apps/models/people.php');
        $peopleListToPay = Fees::getPeopleListFeesToPay();
        require_once ('apps/views/pages/fees/updateFeesPage.php');
    }
    
    // ==========================================================
    
*/
     // SERVICES
    public static function getFeesListJson() {
        $fee = Fees::getFeesList();
        print_r(json_encode($fee));
    }
    
    public static function updateFees() {
        Fees::updateFees();
    } 
    
    public static function deleteFees() {
        Fees::deleteFees();
    }
    
    public static function getPeopleListFeesToPay (){
        require_once ('../models/people.php');
        $people = Fees::getPeopleListFeesToPay();
        print_r(json_encode($people));
    }
    
    public function withdrawal() {
        Fees::submitWithdrawal();
        require_once ('apps/views/global/successPage.php');
    }
}
?>