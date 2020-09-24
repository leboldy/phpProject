<?php
    class ReceiveController {
        
        //VIEW
        public function seeToReceiveToExpirePage(){
            //$toReceive = Receive::getToReceiveListToExpire();
            require_once ('apps/views/pages/receive/seeToReceiveToExpire.php');
        }
        
       /*  public function seeToReceivePage() {
            if (!isset($_GET['lendingId']))
                return call('pages', 'error');
                
                // we use the given id to get the right post
                $lending = Lending::getLendingById($_GET['lendingId']);
                $toReceive = Receive::getToReceiveListByLendingId($_GET['lendingId']);
                require_once ('apps/views/pages/receive/seeToReceivePage.php');
        }
        
        public function seeToReceiveToExpirePage(){
            $toReceive = Receive::getToReceiveListToExpire();
            require_once ('apps/views/pages/receive/seeToReceiveToExpire.php');
        }
        
        public function updateReceivePage()
        {
            // we expect a url of form ?controller=posts&action=show&id=x
            // without an id we just redirect to the error page as we need the post id to find it in the database
            if (!isset($_GET['receiveId']))
                return call('pages', 'error');
                
                // we use the given id to get the right post
                //$toReceive = Receive::getToReceiveListByLendingId($_GET['lendingId']);
                $lending = Lending::getLendingById($_GET['lendingId']);
                $toReceive = Receive::getToReceiveByReceiveId($_GET['receiveId']);
                require_once('apps/views/pages/receive/updateReceivePage.php');
        } */
        
        // ==========================================================

        
       // SERVICE
        public static function getReceiveListJson() {
            
            if (isset($_GET['lendingId'])) {
                $receive = Receive::getToReceiveListByLendingId($_GET['lendingId']);
            } else {
                $receive = Receive::getToReceiveListToExpire();
            }
            
            print_r(json_encode($receive));
        }
        
        public static function addReceive() {
            Receive::submitReceive();
        }
        
        public static function updateReceive() {
            Receive::updateToReceiveById();
        }
        
        public static function deleteReceive() {
            Receive::deleteReceive();
        }
    }
?>