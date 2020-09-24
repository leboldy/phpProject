<?php
    class Account {
  /*       public $id;
        public $accountValueCredited;
        
        public function __construct($id, $accountValueCredited) {
            $this->id = $id;
            $this->accountValueCredited  = $accountValueCredited;
        } */
        
        public $accountId;
        public $peopleId;
        public $accountDate;
        public $accountValue;
        public $accountNotes;
        public $sumAccountValue;
        
        public function __construct($accountId, $peopleId, $accountDate, $accountValue, $accountNotes, $sumAccountValue) {
            $this->accountId = $accountId;
            $this->peopleId = $peopleId;
            $this->accountDate = $accountDate;
            $this->accountValue = $accountValue;
            $this->accountNotes = $accountNotes;            
            $this->sumAccountValue = $sumAccountValue;
        }
        
        public static function submitAccountFromFees($peopleId, $accountDate, $accountValue, $accountNotes) {
            $db = Db::getInstance();
            $req = $db->prepare('INSERT INTO account (peo_id, acc_date, acc_value, acc_notes)
                                values (:peopleId, :accountDate, :accountValue, :accountNotes)');
            $req->execute(array('peopleId' => $peopleId, 'accountDate' => $accountDate, 'accountValue' => $accountValue, 'accountNotes' => $accountNotes));
        }
        
        /*
        public static function getAccountById($accountId) {
            $db = Db::getInstance();
            $req = $db->prepare('SELECT * FROM account where acc_id = :accountId');
            $req->execute(array('accountId' => $accountId));
            $account = $req->fetch();
            return new Account($account['acc_id'], $account['peo_id'], $account['acc_date'], floatval($account['acc_value']), $account['acc_notes']);
        }
        
            
                    public static function getTotalAccountValueCredited($peopleId){
            $totalAccountValue = NULL;
            $db = Db::getInstance();
            $req = $db->prepare('SELECT acc_value FROM account where peo_id = :peopleId');
            $req->execute(array('peopleId' => $peopleId));
            
            // we create a list of all people from the database results
            foreach($req->fetchAll() as $account){
                $totalAccountValue += $account['acc_value'];
            }
            return $totalAccountValue;
        }
        }*/
        
        //SERVICES
        public static function getAccountList() {
            $list = [];
            $db = Db::getInstance();
            $req = $db->query('SELECT * FROM account order by acc_date DESC');
            foreach ($req->fetchAll() as $account) {
                $list[] = new Account(intval($account['acc_id']), intval($account['peo_id']), $account['acc_date'], floatval($account['acc_value']), $account['acc_notes'], null);
            }
            return $list;
        }
        
        public static function submitAccount() {
            $peopleId = intval($_POST['peopleId']);
            $accountDate = $_POST['accountDate'];
            $accountValue = floatval($_POST['accountValue']);
            $accountNotes = strval($_POST['accountNotes']);
            
            $db = Db::getInstance();
            $req = $db->prepare('INSERT INTO account (peo_id, acc_date, acc_value, acc_notes)
                                values (:peopleId, :accountDate, :accountValue, :accountNotes)');
            $req->execute(array('peopleId' => $peopleId, 'accountDate' => $accountDate, 'accountValue' => $accountValue, 'accountNotes' => $accountNotes));
            
        }
        
        public static function updateAccount() {
            $peopleId = null;
            $accountDate = null;
            $accountValue = null;
            $accountNotes = null;
            
            parse_str(file_get_contents("php://input"),$account);

            $accountID = intval($_GET['accountId']);
            
            //verifies if POST is defined. If not, the variable keeps NULL, then the COALESCE is applyed to the DB, not saving NULL values
            if(isset($account['peopleId'])) {
                $peopleId = intval($account['peopleId']);
            }
            
            if(isset($account['accountDate'])) {
                $accountDate = $account['accountDate'];
            }
            
            if(isset($account['accountValue'])) {
                $accountValue = floatval($account['accountValue']);
            }
            
            if(isset($account['accountNotes'])) {
                $accountNotes = strval($account['accountNotes']);
            }
            
            $db = Db::getInstance();
            $req = $db->prepare('UPDATE account SET peo_id = COALESCE(:peopleId, peo_id), acc_date = COALESCE(:accountDate, acc_date), 
                                acc_value = COALESCE(:accountValue, acc_value), acc_notes = COALESCE(:accountNotes, acc_notes)
                                WHERE acc_id = :accountId');
            $req->execute(array('accountId' => $accountID, 'peopleId' => $peopleId, 'accountDate' => $accountDate, 'accountValue' => $accountValue, 'accountNotes' => $accountNotes));
        }
        
        public static function deleteAccount() {
            $accountId = intval($_GET['accountId']);
            
            $db = Db::getInstance();
            $req = $db->prepare('DELETE FROM account WHERE acc_id = :accountId');
            $req->execute(array('accountId' => $accountId));
        }
        
        public static function getPeopleAddedCreditList(){
            $list = [];
            $db = Db::getInstance();
            
            $req = $db->query("SELECT DISTINCT a.peo_id, round(sum(a.acc_value), 2) as acc_total_added FROM account a, people b, people_roles c where a.peo_id = b.peo_id and b.peo_id = c.peo_id and c.rol_type = 'I' GROUP by a.peo_id ORDER BY b.peo_full_name");
            //$req = $db->query('SELECT DISTINCT a.peo_id, round(sum(a.acc_value), 2) as acc_total_added FROM account a, people b where a.peo_id = b.peo_id GROUP by a.peo_id ORDER BY b.peo_full_name');
            
            foreach ($req->fetchAll() as $account) {
                $list[] = new Account(null, intval($account['peo_id']), null, null, null, floatval($account['acc_total_added']));
            }
            return $list;
        }
}
?>