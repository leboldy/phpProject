<?php
class Receive{
    
    public $receiveId;
    public $lendingId;
    public $valueToReceive;
    public $dateToReceive;
    public $adminFeeToReceive;
    public $vendorFeeToReceive;
    public $investorFeeToReceive;
    public $valueReceived;
    public $dateReceived;
    public $adminFeeReceived;
    public $vendorFeeReceived;
    public $investorFeeReceived;
    public $clientId;
    
    public function __construct($receiveId, $lendingId, $valueToReceive, $dateToReceive, $adminFeeToReceive, $investorFeeToReceive, $vendorFeeToReceive,
                                $valueReceived, $dateReceived, $adminFeeReceived, $investorFeeReceived, $vendorFeeReceived, $clientId) {
        $this->receiveId = $receiveId;
        $this->lendingId = $lendingId;
        $this->valueToReceive = $valueToReceive;
        $this->dateToReceive = $dateToReceive;
        $this->adminFeeToReceive = $adminFeeToReceive;
        $this->investorFeeToReceive = $investorFeeToReceive;
        $this->vendorFeeToReceive = $vendorFeeToReceive;
        $this->valueReceived = $valueReceived;
        $this->dateReceived = $dateReceived;
        $this->adminFeeReceived = $adminFeeReceived;
        $this->vendorFeeReceived = $vendorFeeReceived;
        $this->investorFeeReceived = $investorFeeReceived;
        $this->clientId = $clientId;
    }
    
/*     public static function getToReceiveByReceiveId($receiveId){
        $db = Db::getInstance();
        $req = $db->prepare('SELECT * FROM receive WHERE rec_id = :receiveId');
        $req->execute(array('receiveId' => $receiveId));
        
        $toReceive = $req->fetch();
        
        return new  Receive($toReceive['rec_id'], $toReceive['len_id'], $toReceive['rec_value_to_receive'], $toReceive['rec_date_to_receive'],
            $toReceive['rec_admin_fee_to_receive'], $toReceive['rec_investor_fee_to_receive'], $toReceive['rec_vendor_fee_to_receive'],
            $toReceive['rec_value_received'],$toReceive['rec_date_received'], $toReceive['rec_admin_fee_received'], $toReceive['rec_investor_fee_received'],
            $toReceive['rec_vendor_fee_received']);
    }
    
     */
    
    
    //SERVICES
    public static function getToReceiveListByLendingId($lendingId){
        $list =[];
        $db = Db::getInstance();
        $req = $db->prepare('SELECT * FROM receive WHERE len_id = :lendingId');
        $req->execute(array('lendingId' => $lendingId));
        
        foreach ($req->fetchAll() as $toReceive){
            $list[] = new Receive(intval($toReceive['rec_id']), intval($toReceive['len_id']), $toReceive['rec_value_to_receive'], 
                $toReceive['rec_date_to_receive'], $toReceive['rec_admin_fee_to_receive'], $toReceive['rec_investor_fee_to_receive'], 
                $toReceive['rec_vendor_fee_to_receive'], $toReceive['rec_value_received'],$toReceive['rec_date_received'], 
                $toReceive['rec_admin_fee_received'], $toReceive['rec_investor_fee_received'], $toReceive['rec_vendor_fee_received'], null);
        }
        //echo $list->lendingDate;
        return $list;
    }
    
    public static function getToReceiveListToExpire(){
        $list = [];
        $db = Db::getInstance();
     
        /*$req = $db->query('SELECT * from receive WHERE (`rec_date_received` is null and `rec_date_to_receive` <= NOW()) or
                            (`rec_date_received` is null and `rec_date_to_receive` <= NOW() + INTERVAL 7 DAY) order by rec_date_to_receive');*/
        
        $req = $db->query('SELECT a.rec_id, a.len_id, b.len_client_id, a.rec_value_to_receive, a.rec_date_to_receive, a.rec_admin_fee_to_receive, 
                            a.rec_investor_fee_to_receive, a.rec_vendor_fee_to_receive, a.rec_value_received, a.rec_date_received, a.rec_admin_fee_received, 
                            a.rec_investor_fee_received, a.rec_vendor_fee_received FROM receive a, lending b 
                        WHERE a.len_id = b.len_id AND a.rec_date_received is null');
        
        foreach ($req->fetchAll() as $toReceive){
            $list[] = new Receive($toReceive['rec_id'], $toReceive['len_id'], $toReceive['rec_value_to_receive'], $toReceive['rec_date_to_receive'],
                $toReceive['rec_admin_fee_to_receive'], $toReceive['rec_investor_fee_to_receive'], $toReceive['rec_vendor_fee_to_receive'],
                $toReceive['rec_value_received'],$toReceive['rec_date_received'], $toReceive['rec_admin_fee_received'], $toReceive['rec_investor_fee_received'],
                $toReceive['rec_vendor_fee_received'], $toReceive['len_client_id']);
        }
        return $list;
    }
    
    public static function submitReceive() {
        $valueReceived = null;
        $dateReceived = null;
        $adminFeeReceived = null;
        $vendorFeeReceived = null;
        $investorFeeReceived = null;
        
        $dateToReceive = null;
        $valueToReceive = null;
        $adminFeeToReceive = null;
        $vendorFeeToReceive = null;
        $investorFeeToReceive = null;
        
        $lendingId = intval($_GET['lendingId']);
    
        if (isset($_POST['dateReceived'])) {
            $dateReceived = date('Y-m-d', strtotime($_POST['dateReceived']));
        }
        
        if(isset($_POST['valueReceived'])) {
            $valueReceived = floatval($_POST['valueReceived']);
        }
        
        if(isset($_POST['adminFeeReceived'])) {
            $adminFeeReceived = floatval($_POST['adminFeeReceived']);
        }
        
        if(isset($_POST['vendorFeeReceived'])) {
            $vendorFeeReceived = floatval($_POST['vendorFeeReceived']);
        }
        
        if(isset($_POST['investorFeeReceived'])) {
            $investorFeeReceived = floatval($_POST['investorFeeReceived']);
        }
        
        if(isset($_POST['dateToReceive'])) {
            $dateToReceive = date('Y-m-d', strtotime($_POST['dateToReceive']));
        }
        
        if(isset($_POST['valueToReceive'])) {
            $valueToReceive = floatval($_POST['valueToReceive']);
        }
        
        if(isset($_POST['adminFeeToReceive'])) {
            $adminFeeToReceive = floatval($_POST['adminFeeToReceive']);
        }
        
        if(isset($_POST['vendorFeeToReceive'])) {
            $vendorFeeToReceive = floatval($_POST['vendorFeeToReceive']);
        }
        
        if(isset($_POST['investorFeeToReceive'])) {
            $investorFeeToReceive = floatval($_POST['investorFeeToReceive']);
        }
        
        $db = Db::getInstance();
        $req = $db->prepare('INSERT INTO receive (len_id, rec_value_to_receive, rec_date_to_receive, rec_admin_fee_to_receive, 
                                rec_investor_fee_to_receive, rec_vendor_fee_to_receive, rec_value_received, rec_date_received, rec_admin_fee_received,
                                rec_investor_fee_received, rec_vendor_fee_received)
                             values (:lendingId, :rec_value_to_receive, :rec_date_to_receive, :rec_admin_fee_to_receive, 
                                :rec_investor_fee_to_receive, :rec_vendor_fee_to_receive, :rec_value_received, :rec_date_received, :rec_admin_fee_received,
                                :rec_investor_fee_received, :rec_vendor_fee_received)');
        $req->execute(array('lendingId'=> $lendingId, 'rec_value_to_receive'=> $valueToReceive, 'rec_date_to_receive' => $dateToReceive,
                            'rec_admin_fee_to_receive'=> $adminFeeToReceive, 'rec_investor_fee_to_receive'=> $vendorFeeToReceive, 
                            'rec_vendor_fee_to_receive'=> $investorFeeToReceive, 'rec_value_received'=> $valueReceived, 'rec_date_received'=>$dateReceived,
                            'rec_admin_fee_received'=>$adminFeeReceived, 'rec_investor_fee_received'=>$investorFeeReceived, 'rec_vendor_fee_received'=>$vendorFeeReceived
        ));
    }
    
    public static function updateToReceiveById () {
        $valueReceived = null;
        $dateReceived = null;
        $updatingDateReceivedNull = false;
        $adminFeeReceived = null;
        $vendorFeeReceived = null;
        $investorFeeReceived = null;
        
        $dateToReceive = null;
        $valueToReceive = null;
        $adminFeeToReceive = null;
        $vendorFeeToReceive = null;
        $investorFeeToReceive = null;
        
        parse_str(file_get_contents("php://input"),$receive);
        
        $receiveId = intval($_GET['receiveId']);
        //verifies if POST is defined. If not, the variable keeps NULL, then the COALESCE is applyed to the DB, not saving NULL values
        if(isset($receive['valueReceived'])) {
            $valueReceived = floatval($receive['valueReceived']);
        }
        
        if(isset($receive['dateReceived'])) {
            
            if (!empty($receive['dateReceived'])) {
                $dateReceived = date('Y-m-d', strtotime($receive['dateReceived']));
            } else {
                $updatingDateReceivedNull = true;
            }
        }
            
        if(isset($receive['adminFeeReceived'])) {
            $adminFeeReceived = floatval($receive['adminFeeReceived']);
            
        }
        
        if(isset($receive['vendorFeeReceived'])) {
            $vendorFeeReceived = floatval($receive['vendorFeeReceived']);
        }
        
        if(isset($receive['investorFeeReceived'])) {
            $investorFeeReceived = floatval($receive['investorFeeReceived']);
        }
        
        if(isset($receive['dateToReceive'])) {
            $dateToReceive = date('Y-m-d', strtotime($receive['dateToReceive']));
        }
        
        if(isset($receive['valueToReceive'])) {
            $valueToReceive = floatval($receive['valueToReceive']);
        }
        
        if(isset($receive['adminFeeToReceive'])) {
            $adminFeeToReceive = floatval($receive['adminFeeToReceive']);
        }
        
        if(isset($receive['vendorFeeToReceive'])) {
            $vendorFeeToReceive = floatval($receive['vendorFeeToReceive']);
        }
        
        if(isset($receive['investorFeeToReceive'])) {
            $investorFeeToReceive = floatval($receive['investorFeeToReceive']);
        }
        
        $db = Db::getInstance();
        $req = $db->prepare('UPDATE receive SET rec_value_to_receive = COALESCE(:valueToReceive, rec_value_to_receive), 
                            rec_date_to_receive = COALESCE(:dateToReceive, rec_date_to_receive), rec_admin_fee_to_receive = COALESCE(:adminFeeToReceive, rec_admin_fee_to_receive),
                            rec_vendor_fee_to_receive = COALESCE(:vendorFeeToReceive, rec_vendor_fee_to_receive), rec_investor_fee_to_receive = COALESCE(:investorFeeToReceive, rec_investor_fee_to_receive), 
                            rec_value_received = COALESCE(:valueReceived, rec_value_received), 
                            rec_date_received = IF(:updatingDateReceivedNull = TRUE, NULL, COALESCE(:dateReceived, rec_date_received)),
                            rec_admin_fee_received = COALESCE(:adminFeeReceived, rec_admin_fee_received), rec_investor_fee_received = COALESCE(:investorFeeReceived, rec_investor_fee_received),
                            rec_vendor_fee_received = COALESCE(:vendorFeeReceived, rec_vendor_fee_received) WHERE rec_id = :receiveId');
        $req->execute(array('receiveId' => $receiveId, 'valueToReceive' => $valueToReceive, 'dateToReceive' => $dateToReceive,
            'adminFeeToReceive' => $adminFeeToReceive, 'vendorFeeToReceive' => $vendorFeeToReceive, 'investorFeeToReceive' => $investorFeeToReceive,
            'valueReceived' => $valueReceived, 'dateReceived' => $dateReceived, 'adminFeeReceived' => $adminFeeReceived, 'vendorFeeReceived' => $vendorFeeReceived,
            'investorFeeReceived' => $investorFeeReceived, 'updatingDateReceivedNull' => $updatingDateReceivedNull));
    }
    
    public static function deleteReceive() {
        $receiveId = intval($_GET['receiveId']);
        
        $db = Db::getInstance();
        $req = $db->prepare('DELETE FROM receive WHERE rec_id = :receiveId');
        $req->execute(array('receiveId' => $receiveId));
    }
    
    public static function deleteReceiveByLendingId($lendingId) {
        
        $db = Db::getInstance();
        $req = $db->prepare('DELETE FROM receive WHERE len_id = :lendingId');
        $req->execute(array('lendingId' => $lendingId));
    }
}
?>