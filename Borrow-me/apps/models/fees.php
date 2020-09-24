<?php
class Fees {

    public $feesId;
    public $peopleId;
    public $feesDate;
    public $feesValue;
    public $feesFlgCredit;
    public $feesToReceive;
    public $feesReceived;
    public $peopleFullName;
    
    public function __construct($feesId, $peopleId, $feesDate, $feesValue, $feesFlgCredit, $feesToReceive, $feesReceived, $peopleFullName) {
        $this->feesId = $feesId;
        $this->peopleId = $peopleId;
        $this->feesDate = $feesDate;
        $this->feesValue = $feesValue;
        $this->feesFlgCredit = $feesFlgCredit;
        $this->feesToReceive = $feesToReceive;
        $this->feesReceived = $feesReceived;
        $this->peopleFullName = $peopleFullName;
    }
    
    /* 
    
    public static function getFeesByFeesId($feesId){
        $db = Db::getInstance();
        $req = $db->prepare('SELECT * FROM fees WHERE fee_id = :feesId');
        $req->execute(array('feesId' => $feesId));
        
        $fees = $req->fetch(); 
        return new Fees($fees['fee_id'], $fees['peo_id'], $fees['fee_date'], $fees['fee_value'], NULL, NULL);;
    }
     */
    
    public static function getFeesList(){
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM fees order by fee_date DESC');
        foreach ($req->fetchAll() as $fees) {
            $list[] = new Fees($fees['fee_id'], $fees['peo_id'], $fees['fee_date'], $fees['fee_value'], boolval($fees['fee_flg_credit']), NULL, NULL, NULL);
        }
        return $list;
    }
    
    public static function updateFees() {
        
        parse_str(file_get_contents("php://input"),$fees);
        
        $feesId = intval($_GET['feesId']);
        
        //verifies if POST is defined. If not, the variable keeps NULL, then the COALESCE is applyed to the DB, not saving NULL values
        if(isset($fees['feesDate'])) {
            $feesDate = $fees['feesDate'];
        }
        
        $db = Db::getInstance();
        $req = $db->prepare('UPDATE fees SET fee_date = COALESCE(:feesDate, fee_date) WHERE fee_id = :feesId');
        $req->execute(array('feesId' => $feesId, 'feesDate' => $feesDate));
    }
    
    public static function deleteFees() {
        $feesId = intval($_GET['feesId']);
        
        $db = Db::getInstance();
        $req = $db->prepare('DELETE FROM fees WHERE fee_id = :feesId');
        $req->execute(array('feesId' => $feesId));
    }
    
    public static function submitWithdrawal() {
        $peopleId = $_POST['peopleId'];
        $feesDate = $_POST['feesDate'];
        $feesValue = floatval($_POST['feesValue']);
        $feesFlgCredit = $_POST['feesFlgCredit'] === 'true'? 1 : 0;

        $db = Db::getInstance();
        $req = $db->prepare('INSERT INTO fees (peo_id, fee_date, fee_value, fee_flg_credit) values (:peopleId, :feesDate, :feesValue, :feesFlgCredit)');
        $req->execute(array('peopleId'=>$peopleId, 'feesDate'=>$feesDate, 'feesValue'=>$feesValue, 'feesFlgCredit'=>$feesFlgCredit));
        
        if ($feesFlgCredit == TRUE) {
            require_once ('apps/models/account.php');
            Account::submitAccountFromFees($peopleId, $feesDate, $feesValue, '##Adicionado pelo sistema##');
        }
    }
    
    public static function getTotalPayedFeesById($peopleId) {
        $db = Db::getInstance();
        
        $req = $db->prepare('SELECT sum(fee_value) FROM fees WHERE peo_id = :peopleId');
        $req->execute(array('peopleId' => $peopleId));
        
        return $req->fetchColumn();
    }
    
    public static function getAdminListFees() {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT a.len_admin_id as peopleId, ROUND(SUM(b.rec_admin_fee_to_receive), 2) as feeToReceive, ROUND(SUM(b.rec_admin_fee_received), 2) as feeReceived
                            FROM lending a, receive b
                            WHERE a.len_id = b.len_id AND b.rec_admin_fee_received is not null AND b.rec_admin_fee_received > 0 group by a.len_admin_id');
        foreach ($req->fetchAll() as $fees) {
            $list[] = new Fees(NULL, $fees['peopleId'], NULL, NULL, NULL, $fees['feeToReceive'], $fees['feeReceived'], NULL);
        }
        return $list;
    }
    
    public static function getVendorListFees() {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT a.len_vendor_id as peopleId, ROUND(SUM(b.rec_vendor_fee_to_receive), 2) as feeToReceive, ROUND(SUM(b.rec_vendor_fee_received), 2) as feeReceived
                            FROM lending a, receive b
                            WHERE a.len_id = b.len_id AND b.rec_vendor_fee_received is not null AND b.rec_vendor_fee_received > 0 group by a.len_vendor_id');
        foreach ($req->fetchAll() as $fees) {
            $list[] = new Fees(NULL, $fees['peopleId'], NULL, NULL, NULL, $fees['feeToReceive'], $fees['feeReceived'], NULL);
        }
        return $list;
    }
    
    public static function getInvestorListFees() {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT a.len_investor_id as peopleId, ROUND(SUM(b.rec_investor_fee_to_receive), 2) as feeToReceive, ROUND(SUM(b.rec_investor_fee_received), 2) as feeReceived
                            FROM lending a, receive b
                            WHERE a.len_id = b.len_id AND b.rec_investor_fee_received is not null AND b.rec_investor_fee_received > 0 group by a.len_investor_id');
        foreach ($req->fetchAll() as $fees) {
            $list[] = new Fees(NULL, $fees['peopleId'], NULL, NULL, NULL, $fees['feeToReceive'], $fees['feeReceived'], NULL);
        }
        return $list;
    }
    
    public static function getPeopleListFeesToPay() {
        $adminListFee = Fees::getAdminListFees();
        $investorListFee = Fees::getInvestorListFees();
        $vendorListFee = Fees::getVendorListFees();
        
        $list = [];
        $feesToReceive = NULL;
        $feesReceived= NULL;
        
        $person = People::getListPeople();
        foreach ($person as $people) {
            
            foreach ($adminListFee as $fees){
                // echo ' P:' .$people->id;
                // echo ' A:' .$fees->peopleId;
                if ($people->peopleId == $fees->peopleId) {
                    $feesToReceive = $feesToReceive + $fees->feesToReceive;
                    $feesReceived = $feesReceived + $fees->feesReceived;
                    //    echo 'merda';
                }
            }
            
            foreach ($investorListFee as $fees){
                if ($people->peopleId == $fees->peopleId) {
                    $feesToReceive = $feesToReceive + $fees->feesToReceive;
                    $feesReceived = $feesReceived + $fees->feesReceived;
                }
            }
            
            foreach ($vendorListFee as $fees){
                if ($people->peopleId == $fees->peopleId) {
                    $feesToReceive = $feesToReceive + $fees->feesToReceive;
                    $feesReceived = $feesReceived + $fees->feesReceived;
                }
            }
            if($feesToReceive != NULL) {
                $feesPayed = Fees::getTotalPayedFeesById($people->peopleId);
                
                //only add to the object if != of zero
                if ($feesReceived-$feesPayed !=0) {
                    $list[] = new Fees(NULL, $people->peopleId, NULL, NULL, NULL, round($feesToReceive, 2), round($feesReceived-$feesPayed, 2), 
                        $people->peopleFullName." (R$ ".number_format(round($feesReceived-$feesPayed, 2), 2, ',', '.').")");
                }
                $feesToReceive = NULL;
                $feesReceived= NULL;
            }
        }
        return $list;
    }
}