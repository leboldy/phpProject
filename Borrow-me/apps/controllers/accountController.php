<?php
class AccountController {
    
    // VIEW
    public function accountAddPage() {
        require_once ('apps/views/pages/account/accountAddPage.php');
    }
    
    public function accountMovementPage() {
        //$acc = Account::getAccountList();
        require_once ('apps/views/pages/account/accountMovementPage.php');
    }
    
    // ==========================================================
    
    //SERVICES
    public static function getListAccountJson(){
        $acc = Account::getAccountList();
        print_r(json_encode($acc));
    }
    
    public static function submitAccount() {
        Account::submitAccount();
        require_once ('apps/views/global/successPage.php');
    }
    
    public static function updateAccount() {
        Account::updateAccount();
    }
    
    public static function deleteAccount() {
        Account::deleteAccountById();
    }
}
?>