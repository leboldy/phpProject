<?php
    class People {
        public $peopleId;
        public $peopleFullName;
        public $peopleNickname;
        public $peopleEmail;
        public $peoplePhone;
        public $peopleReference;
        //public $peopleRoles;
        
        public function __construct($peopleId, $peopleFullName, $peopleNickname, $peopleEmail, $peoplePhone, $peopleReference, $peopleRoleClient, 
                                    $peopleRoleAdmin, $peopleRoleVendor, $peopleRoleInvestor /*, $peopleRoles*/) {
            $this->peopleId = $peopleId;
            $this->peopleFullName  = $peopleFullName;
            $this->peopleNickname = $peopleNickname;
            $this->peopleEmail = $peopleEmail;
            $this->peoplePhone = $peoplePhone;
            $this->peopleReference = $peopleReference;
            $this->peopleRoleClient = $peopleRoleClient;
            $this->peopleRoleAdmin = $peopleRoleAdmin;
            $this->peopleRoleVendor = $peopleRoleVendor;
            $this->peopleRoleInvestor = $peopleRoleInvestor;
            
            /*foreach ($peopleRoles as $peoRole) {
                $this->peopleRoles[] = new PeopleRoles($peoRole->peopleId, $peoRole->roleType, $peoRole->roleDescription);
            } */
        }
        
        public static function getPeopleRoleBoolen($peopleId, $roleType) {
            
            require_once ('../models/peopleRoles.php');
            $peopleRoles = PeopleRoles::getPeopleRoleByPeopleIdAndRoleType($peopleId, $roleType);

            if (!$peopleRoles == null) {
                return true;   
            } else {
                return false;
            }
        }
        
        public static function getPeopleByRoleType($rolType){
            $list =[];
            $db = Db::getInstance();
            
            // Type => A= Admin | C= Client | V= Vendor | I= Investor
            $type= strval($rolType);
            $req = $db->prepare('SELECT a.peo_id, a.peo_full_name, a.peo_nickname, a.peo_email, a.peo_phone, a.peo_reference
                                FROM people a, people_roles b where a.peo_id = b.peo_id AND b.rol_type= :rolType order by peo_full_name');
            $req->execute(array('rolType' => $type));
            
            // we create a list of all people from the database results
            require_once ('../models/peopleRoles.php');
            
            foreach($req->fetchAll() as $people){
                $peoRole = PeopleRoles::getPeopleRoleByPeopleId($people['peo_id']);
                
                $list[] = new People(intval($people['peo_id']), $people['peo_full_name'], $people['peo_nickname'], $people['peo_email'],
                    $people['peo_phone'], $people['peo_reference'], null, null, null, null);
            }
            return $list;
        }
        
        public static function getPeoplebyId($peopleId){
            $db = Db::getInstance();
            $req = $db->prepare('SELECT * FROM people WHERE peo_id = :peopleId');
            $req->execute(array('peopleId' => $peopleId));
            
            require_once ('../models/peopleRoles.php');
            $people = $req->fetch();
            $peoRole = PeopleRoles::getPeopleRoleByPeopleId($people['peo_id']);
            
            return new People($people['peo_id'], $people['peo_full_name'], $people['peo_nickname'], $people['peo_email'], $people['peo_phone'], $people['peo_reference'], null, null, null, null);
        }
        
        public static function getListPeople() {
            $list = [];
            $peoRole = [];
            $db = Db::getInstance();
            $req = $db->query('SELECT * FROM people order by peo_full_name');
            
            foreach ($req->fetchAll() as $people) {
                $list[] = new People(intval($people['peo_id']), $people['peo_full_name'], $people['peo_nickname'], $people['peo_email'],
                    $people['peo_phone'], $people['peo_reference'], People::getPeopleRoleBoolen($people['peo_id'], 'C'),
                    People::getPeopleRoleBoolen($people['peo_id'], 'A'), People::getPeopleRoleBoolen($people['peo_id'], 'V'),
                    People::getPeopleRoleBoolen($people['peo_id'], 'I'));
            }
            
            return $list;
        }
        
        public static function submitPeople() {
            require_once ('../models/peopleRoles.php');
            
            $peopleFullName = strval($_POST['peopleFullName']);
            $peopleNickname = strval($_POST['peopleNickname']);
            $peopleEmail = strval($_POST['peopleEmail']);
            $peoplePhone = strval($_POST['peoplePhone']);
            $peopleReference = strval($_POST['peopleReference']);
            $peopleRoleClient = $_POST['peopleRoleClient'] === 'true'? true : false;
            $peopleRoleAdmin = $_POST['peopleRoleAdmin'] === 'true'? true : false;
            $peopleRoleVendor = $_POST['peopleRoleVendor'] === 'true'? true : false;
            $peopleRoleInvestor = $_POST['peopleRoleInvestor'] === 'true'? true : false;
            
            $db = Db::getInstance();
            $req = $db->prepare('INSERT INTO people (peo_full_name, peo_nickname, peo_email, peo_phone, peo_reference)
                                values (:peopleFullName, :peopleNickname, :peopleEmail, :peoplePhone, :peopleReference)');
            $req->execute(array('peopleFullName' => $peopleFullName, 'peopleNickname' => $peopleNickname, 'peopleEmail'=> $peopleEmail,
                'peoplePhone'=> $peoplePhone, 'peopleReference' => $peopleReference));
            
            $peopleId = $db->lastInsertId();
            if ($peopleRoleAdmin == true) {
                PeopleRoles::submitPeopleRole($peopleId, 'A');
                echo " entrouA";
            }
            
            if ($peopleRoleClient == true) {
                PeopleRoles::submitPeopleRole($peopleId, 'C');
                echo " entrouC";
            }
            
            if ($peopleRoleVendor == true) {
                PeopleRoles::submitPeopleRole($peopleId, 'V');
                echo " entrouV";
            }
            
            if ($peopleRoleInvestor == true) {
                PeopleRoles::submitPeopleRole($peopleId, 'I');
                echo " entrouI";
            }
        }
        
        public static function updatePeopleAndRole() {
            $peopleFullName = null;
            $peopleNickname = null;
            $peopleEmail = null;
            $peoplePhone = null;
            $peopleReference = null;
            
            //parse to receive the data from PUT
            parse_str(file_get_contents("php://input"),$people);
            $peopleId = intval($_GET['peopleId']);
            
            
            //verifies if POST is defined. If not, the variable keeps NULL, then the COALESCE is applyed to the DB, not saving NULL values
            if(isset($people['peopleFullName'])) {
                $peopleFullName = strval($people['peopleFullName']);
            }
            
            if(isset($people['peopleNickname'])) {
                $peopleNickname = strval($people['peopleNickname']);
            }
            
            if(isset($people['peopleEmail'])) {
                $peopleEmail = strval($people['peopleEmail']);
            }
            
            if(isset($people['peoplePhone'])) {
                $peoplePhone = strval($people['peoplePhone']);
            }
            
            if(isset($people['peopleReference'])) {
                $peopleReference = strval($people['peopleReference']);
            }

            $db = Db::getInstance();
            $req = $db->prepare('UPDATE people SET peo_full_name = COALESCE(:peopleFullName, peo_full_name), peo_nickname = COALESCE(:peopleNickname, peo_nickname),
                                peo_email = COALESCE(:peopleEmail, peo_email), peo_phone = COALESCE(:peoplePhone, peo_phone),
                                peo_reference = COALESCE(:peopleReference, peo_reference) WHERE peo_id = :peopleId');
            $req->execute(array('peopleId' => $peopleId, 'peopleFullName' => $peopleFullName, 'peopleNickname' => $peopleNickname,
                'peopleEmail'=> $peopleEmail, 'peoplePhone'=> $peoplePhone, 'peopleReference' => $peopleReference));
            
            //PeopleRole
            require_once ('../models/peopleRoles.php');
            
            $peopleRoleClient = $people['peopleRoleClient'] === 'true'? true : false;
            $peopleRoleAdmin = $people['peopleRoleAdmin'] === 'true'? true : false;
            $peopleRoleVendor = $people['peopleRoleVendor'] === 'true'? true : false;
            $peopleRoleInvestor = $people['peopleRoleInvestor'] === 'true'? true : false;
            
            if (isset($people['peopleRoleAdmin'])) {
                if ($peopleRoleAdmin == true) {
                    PeopleRoles::submitPeopleRole($peopleId, 'A');
                } else {
                    PeopleRoles::deletePeopleRoleByPeopleIdAndRoleType($peopleId, 'A');
                }
            }
            
            if (isset($people['peopleRoleClient'])) {
                if ($peopleRoleClient == true) {
                    PeopleRoles::submitPeopleRole($peopleId, 'C');
                } else {
                    PeopleRoles::deletePeopleRoleByPeopleIdAndRoleType($peopleId, 'C');
                }
            }
            
            if (isset($people['peopleRoleVendor'])) {
                if ($peopleRoleVendor == true) {
                    PeopleRoles::submitPeopleRole($peopleId, 'V');
                } else {
                    PeopleRoles::deletePeopleRoleByPeopleIdAndRoleType($peopleId, 'V');
                }
            }
            
            if (isset($people['peopleRoleInvestor'])) {
                if ($peopleRoleInvestor == true) {
                    PeopleRoles::submitPeopleRole($peopleId, 'I');
                } else {
                    PeopleRoles::deletePeopleRoleByPeopleIdAndRoleType($peopleId, 'I');
                }
            }
        }
        
        public static function deletePeopleById() {
            $peopleId = intval($_GET['peopleId']);
            
            $db = Db::getInstance();
            $req = $db->prepare('DELETE FROM people WHERE peo_id = :peopleId');
            $req->execute(array('peopleId' => $peopleId));
            
            require_once ('../models/peopleRoles.php');
            PeopleRoles::deletePeopleRoleByPeopleId($peopleId);
        }
        
        /*
        
        
        public static function getPeopleByLendingId($lendingId){
            $db = Db::getInstance();
            $req = $db->prepare('SELECT b.peo_id, b.peo_full_name, b.peo_nickname FROM lending a, people b 
                                WHERE a.len_client_id = b.peo_id AND a.len_id = :lendingId');
            $req->execute(array('lendingId' => $lendingId));
            
            require_once ('../models/peopleRoles.php');
            $people = $req->fetch();
            $peoRole = PeopleRoles::getPeopleRoleByPeopleId($people['peo_id']);
            
            return new People($people['peo_id'], $people['peo_full_name'], $people['peo_nickname'], $people['peo_email'], $people['peo_phone'], $people['peo_reference'], null, null, null, null);
        }
        
        public static function updatePeople() {
            //$peopleId = intval($_POST['peopleId']);
            //$people = file_get_contents("php://input");
            $peopleFullName = null;
            $peopleNickname = null;
            
            $peopleId = intval($_GET['peopleId']);
           
            //verifies if POST is defined. If not, the variable keeps NULL, then the COALESCE is applyed to the DB, not saving NULL values
            if(isset($_POST['peopleFullName'])) {
                $peopleFullName = strval($_POST['peopleFullName']);
            }
            
            if(isset($_POST['peopleNickname'])) { 
                $peopleNickname = strval($_POST['peopleNickname']);
            }
            
            $roleType = $_POST['roleType'];
            
            /* foreach ($peopleId as $p) {
                echo $p->peopleFullName;
            } * /
            //print_r($people);
            echo ($_SERVER["REQUEST_METHOD"]);
            echo $peopleId, $peopleFullName;
            print_r($peopleNickname);
            //echo "merda";
            
            $db = Db::getInstance();
            $req = $db->prepare('UPDATE people SET peo_full_name = COALESCE(:peopleFullName, peo_full_name), peo_nickname = COALESCE(:peopleNickname, peo_nickname) 
                                WHERE peo_id = :peopleId');
            $req->execute(array('peopleId' => $peopleId, 'peopleFullName' => $peopleFullName, 'peopleNickname' => $peopleNickname));
            
            /* require_once ('apps/models/peopleRoles.php');
            PeopleRoles::deletePeopleRoleByPeopleId($peopleId);
            
            for ($i = 0; $i < count($roleType); $i++ ){
                $peopleRoles = PeopleRoles::submitPeopleRole($peopleId, $roleType[$i]);
            } * /
        }
        
        
        //using for SERVICES
        
        
        
        
        public static function getPeopleExceptByRoleType($rolType){
            $list =[];
            $db = Db::getInstance();
            
            // Type => A= Admin | C= Client | V= Vendor | I= Investor
            $type= strval($rolType);
            $req = $db->prepare('SELECT a.peo_id, a.peo_full_name, a.peo_nickname, a.peo_email, a.peo_phone, a.peo_reference 
                                FROM people a, people_roles b where a.peo_id = b.peo_id AND b.rol_type<> :rolType order by peo_full_name');
            $req->execute(array('rolType' => $type));
            
            // we create a list of all people from the database results
            require_once ('../models/peopleRoles.php');
            
            foreach($req->fetchAll() as $people){
                $peoRole = PeopleRoles::getPeopleRoleByPeopleId($people['peo_id']);
                
                $list[] = new People(intval($people['peo_id']), $people['peo_full_name'], $people['peo_nickname'], $people['peo_email'],
                    $people['peo_phone'], $people['peo_reference'], null, null, null, null);
            }
            return $list;
        }
        
        public static function updatePeopleWithoutRole() {
            $peopleFullName = null;
            $peopleNickname = null;
            $peopleEmail = null;
            $peoplePhone = null;
            $peopleReference = null;
            //parse to receive the data from PUT
            parse_str(file_get_contents("php://input"),$people);
            $peopleId = intval($_GET['peopleId']);

            
            //verifies if POST is defined. If not, the variable keeps NULL, then the COALESCE is applyed to the DB, not saving NULL values
            if(isset($people['peopleFullName'])) {
                $peopleFullName = strval($people['peopleFullName']);
            }
            
            if(isset($people['peopleNickname'])) {
                $peopleNickname = strval($people['peopleNickname']);
            }
            
            if(isset($people['peopleEmail'])) {
                $peopleEmail = strval($people['peopleEmail']);
            }
            
            if(isset($people['peoplePhone'])) {
                $peoplePhone = strval($people['peoplePhone']);
            }
            
            if(isset($people['peopleReference'])) {
                $peopleReference = strval($people['peopleReference']);
            }
            
            echo $peopleReference;
            
            $db = Db::getInstance();
            $req = $db->prepare('UPDATE people SET peo_full_name = COALESCE(:peopleFullName, peo_full_name), peo_nickname = COALESCE(:peopleNickname, peo_nickname),
                                peo_email = COALESCE(:peopleEmail, peo_email), peo_phone = COALESCE(:peoplePhone, peo_phone), 
                                peo_reference = COALESCE(:peopleReference, peo_reference) WHERE peo_id = :peopleId');
            $req->execute(array('peopleId' => $peopleId, 'peopleFullName' => $peopleFullName, 'peopleNickname' => $peopleNickname,
                                'peopleEmail'=> $peopleEmail, 'peoplePhone'=> $peoplePhone, 'peopleReference' => $peopleReference));
        }
        

        
        public static function submitPeople() {
            $peopleFullName = strval($_POST['peopleFullName']);
            $peopleNickname = strval($_POST['peopleNickname']);
            $peopleEmail = strval($_POST['peopleEmail']);
            $peoplePhone = strval($_POST['peoplePhone']);
            $peopleReference = strval($_POST['peopleReference']);
            
            $db = Db::getInstance();
            $req = $db->prepare('INSERT INTO people (peo_full_name, peo_nickname, peo_email, peo_phone, peo_reference)
                                values (:peopleFullName, :peopleNickname, :peopleEmail, :peoplePhone, :peopleReference)');
            $req->execute(array('peopleFullName' => $peopleFullName, 'peopleNickname' => $peopleNickname, 'peopleEmail'=> $peopleEmail, 
                                'peoplePhone'=> $peoplePhone, 'peopleReference' => $peopleReference));
        } */
}
?>