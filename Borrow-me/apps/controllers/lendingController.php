<?php
    class LendingController {
       
        //VIEW 
        public function addLendingPage()
        {
            require_once ('apps/views/pages/lending/addLendingPage.php');
        }
        
        public function seeLendingPage()
        {
            require_once ('apps/views/pages/lending/seeLendingPage.php');
        }
        
        //SERVICES
        public static function getLendingListJson() {
            $lending = Lending::getLendingList();
            print_r(json_encode($lending));
        }
        
        public static function updateLending() {
            Lending::updateLanding();
        }
        
        public static function deleteLending() {
            Lending::deleteLending();
        }
        
        public static function addLending() {
            Lending::submitLending();
            //$controller = 'lending';
            //$action = 'seeLendingPage';
            require_once ('apps/views/global/successPage.php');
            
            //require_once ('apps/views/pages/index.php');
            //header('Location: apps/views/pages/lending/seeLendingPage.php');
            //exit;
            
        }
        
        public static function getInvestorWithMoneyListJson() {
            $investor = Lending::getInvestorWithMoneyToLendList();
            print_r(json_encode($investor));
            
        }
    }
?>