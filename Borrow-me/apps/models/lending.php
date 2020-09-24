<?php

    class Lending {
        
        public $lendingId;
        public $vendorId;
        public $investorId;
        public $clientId;
        public $adminId;
        public $lendingDate;
        public $totalLended;
        public $peopleFullName;
        //public $receive;
        
        public function __construct($lendingId, $vendorId, $investorId, $clientId, $adminId, $lendingDate, $totalLended, $peopleFullName) {
           // $this->receive = [];
            $this->lendingId = $lendingId;
            $this->vendorId = $vendorId;
            $this->investorId = $investorId;
            $this->clientId = $clientId;
            $this->adminId = $adminId;
            $this->lendingDate = $lendingDate;
            $this->totalLended = $totalLended;
            $this->peopleFullName = $peopleFullName;
            
          /*   foreach ($receive as $rec) {
                $this->receive[] = new Receive($rec->receiveId, $rec->lendingId, $rec->valueToReceive, $rec->dateToReceive, $rec->adminFeeToReceive, 
                    $rec->investorFeeToReceive, $rec->vendorFeeToReceive, $rec->valueReceived, $rec->dateReceived, $rec->adminFeeReceived, 
                    $rec->investorFeeReceived, $rec->vendorFeeReceived);
            } */
            
            //echo 'merda';
            //print $receive[0];
            //print_r ($receive);
            //echo '</br>';
        }
        
       /*  
        
        public static function getTotalAvailableToLendPerInvestor($peopleId){
            $totalLended = NULL;
            $db = Db::getInstance();
            $req = $db->prepare('SELECT len_total_lended FROM lending where len_investor_id = :peopleId');
            $req->execute(array('peopleId' => $peopleId));
            foreach ($req->fetchAll() as $lending){
                $totalLended += $lending['len_total_lended'];
            }
            
            require_once ('apps/models/account.php');
            $totalAccountValueCredited = Account::getTotalAccountValueCredited($peopleId);
            $totalAvailableToLend = $totalAccountValueCredited - $totalLended;
            
            return $totalAvailableToLend;
        }
        
        public static function getInvestorIdList(){
            $list =[];
            $db = Db::getInstance();
            $req = $db->query('SELECT DISTINCT len_investor_id FROM lending');
            
            foreach ($req->fetchAll() as $investor){
                $list[] = new Lending(null, null, $investor['len_investor_id'], null, null, null, null);
            }
            return $list;
        }
        
        public static function getTotalAvailableToLend(){
            $totalAvailableToLendList = [];
            $investorList = Lending::getInvestorIdList();
            foreach ($investorList as $lending){
                echo $lending->investorId;
                $totalAvailableToLend = Lending::getTotalAvailableToLendPerInvestor($lending->investorId);
                echo $totalAvailableToLend;
                $totalAvailableToLendList = [$lending->investorId][$totalAvailableToLend];
            }
            
            echo count($totalAvailableToLendList);
            
            for ($i=1; $i<=count($totalAvailableToLendList); $i++ ) {
                echo $totalAvailableToLendList[$i]; 
                echo 'entrou';
               //  $totalAvailableToLend = Lending::getTotalAvailableToLendPerInvestor($investorList[$i]);
               // $totalAvailableToLendList = [$investorList[$i]][$totalAvailableToLend];
            } 
            
            return $totalAvailableToLendList;
        }

        public static function getLendingById($lendingId){
            $db = Db::getInstance();
            $req = $db->prepare('SELECT * FROM lending WHERE len_id = :lendingId');
            $req->execute(array('lendingId' => $lendingId));
            
            $lending = $req->fetch();
            
            return new Lending($lending['len_id'], $lending['len_vendor_id'], $lending['len_investor_id'], $lending['len_client_id'],
                $lending['len_admin_id'], $lending['len_lending_date'], $lending['len_total_lended']);
        }
        
 */
            
        
       /*         public static function getClientIdByLendingId($lendingId){
        $db = Db::getInstance();
        $req = $db->prepare('SELECT len_client_id FROM lending WHERE len_id = :lendingId');
        $req->execute(array('lendingId' => $lendingId));
        
        return $req->fetchColumn();
        } */
        
        //SERVICES  TO BE DELETED 
        public static function getLendingListWithReceive(){
            $list =[];
            $db = Db::getInstance();
            $req = $db->query('SELECT * FROM lending order by len_lending_date DESC');
            
            foreach ($req->fetchAll() as $lending){
                $receive = Receive::getToReceiveListByLendingId($lending['len_id']);
                
                //$receive = (object) $receive;
                //print_r(json_encode($rec));
                
                
                $list[] = new Lending(intval($lending['len_id']), intval($lending['len_vendor_id']), intval($lending['len_investor_id']), 
                    intval($lending['len_client_id']), intval($lending['len_admin_id']), $lending['len_lending_date'], floatval($lending['len_total_lended'], null), 
                    $receive);
            }
            
            return $list;
        }
            
        //SERVICES  
        public static function getLendingList(){
            $list =[];
            $db = Db::getInstance();
            $req = $db->query('SELECT * FROM lending order by len_lending_date DESC, len_id DESC');
            
            foreach ($req->fetchAll() as $lending){
                
                $list[] = new Lending(intval($lending['len_id']), intval($lending['len_vendor_id']), intval($lending['len_investor_id']),
                    intval($lending['len_client_id']), intval($lending['len_admin_id']), $lending['len_lending_date'], floatval($lending['len_total_lended']), null);
            }
            
            return $list;
        }
        
        public static function updateLanding () {
            $totalLended = null;
            $lendingDate = null;
            
            parse_str(file_get_contents("php://input"),$lending);
            
            $lendingId = intval($_GET['lendingId']);
            
            if(isset($lending['lendingDate'])) {
                $lendingDate = date('Y-m-d', strtotime($lending['lendingDate']));
            }
            
            if(isset($lending['totalLended'])) {
                $totalLended = floatval($lending['totalLended']);
            }
            
            $db = Db::getInstance();
            $req = $db->prepare('UPDATE lending SET len_lending_date = COALESCE(:lendingDate, len_lending_date), len_total_lended = COALESCE(:totalLended, len_total_lended)
                                 WHERE len_id = :lendingId');
            $req->execute(array('lendingDate'=> $lendingDate,'totalLended'=> $totalLended, 'lendingId'=>$lendingId));
        }
        
        public static function deleteLending() {
            $lendingId = intval($_GET['lendingId']);
            
            $db = Db::getInstance();
            Receive::deleteReceiveByLendingId($lendingId);
            $req = $db->prepare('DELETE FROM lending WHERE len_id = :lendingId');
            $req->execute(array('lendingId' => $lendingId));
        }
        
        public static function submitLending () {
            $clientId = intval($_POST['clientId']);
            $vendorId = intval($_POST['vendorId']);
            $investorId = intval($_POST['investorId']);
            $adminId = intval($_SESSION['userId']);
            $lendingDate = $_POST['lendingDate'];
            $totalLended = floatval($_POST['totalLended']);
            
            $db = Db::getInstance();
            $req = $db->prepare('INSERT INTO lending (len_vendor_id, len_investor_id, len_client_id, len_admin_id, len_lending_date, len_total_lended)
                                         values (:vendorId, :investorId, :clientId, :adminId, :lendingDate, :totalLended)');
            $req->execute(array('vendorId'=> $vendorId, 'investorId' => $investorId, 'clientId'=> $clientId, 'adminId'=> $adminId, 'lendingDate'=> $lendingDate,
                'totalLended'=> $totalLended));
        }
        
        public static function getPeopleLendedMoneyList(){
            $list = [];
            $db = Db::getInstance();
            $req = $db->query('SELECT DISTINCT len_investor_id, round(sum(len_total_lended), 2) as len_total_lended FROM lending GROUP BY len_investor_id');
            
            foreach ($req->fetchAll() as $lending) { 
                //echo ' len'.$lending['len_investor_id'];
                //echo ' value'.$lending['len_total_lended'];
                $list[] = new Lending(null, null, intval($lending['len_investor_id']), null, null, null, floatval($lending['len_total_lended']), null);
            }
            return $list; 
        }
        
        public static function getInvestorWithMoneyToLendList() {
            $list = [];
            $totalAvailableToLend = null;
            require_once ('../models/account.php');
            require_once ('../models/people.php');
            $acc = Account::getPeopleAddedCreditList();
            $lend = Lending::getPeopleLendedMoneyList();
            //echo 'merda'.count($lend);
           // echo ' merda2'.count($lend);
            
            //var_dump($acc);
            //echo 'te'.$acc[8]->peopleId;
            /* for ($i=0; $i < count($acc); $i++) {
                for ($z=0; $z < count($lend); $z++) {

                    if ($acc[$i]->peopleId == $lend[$z]->investorId) {
                        $totalAvailableToLend = $acc[$i]->sumAccountValue - $lend[$z]->totalLended;
                    }
                }
                if ($totalAvailableToLend == null) {
                    $totalAvailableToLend = $acc[$i]->sumAccountValue;
                }
                $people = People::getPeoplebyId($acc[$i]->peopleId);
                
                $list[] = new Lending(null, NULL, $acc[$i]->peopleId, NULL, NULL, NULL, round($totalAvailableToLend, 2),
                    $people->peopleFullName." (R$ ".number_format(round($totalAvailableToLend, 2), 2, ',', ' ').")");
                $totalAvailableToLend = null;
            } */
            
             foreach ($acc as $account) {
                $investorId = $account->peopleId;
                
                foreach ($lend as $lending) {
                    if ($account->peopleId == $lending->investorId) {
                        $totalAvailableToLend = $account->sumAccountValue - $lending->totalLended;
                        //echo ' id'.$account->peopleId.' val'.$totalAvailableToLend;
                    } 
                }
                if ($totalAvailableToLend == null) {
                    $totalAvailableToLend = $account->sumAccountValue;
                }
                $people = People::getPeoplebyId($investorId);
                
                // to save only investors that have money available to lend 
                
                if ($totalAvailableToLend > 0) {
                    $list[] = new Lending(null, NULL, $investorId, NULL, NULL, NULL, round($totalAvailableToLend, 2), 
                        $people->peopleFullName." (R$ ".number_format(round($totalAvailableToLend, 2), 2, ',', '.').")");
                }
                
                $totalAvailableToLend = null;
            } 
            return $list;
        }
}
?>