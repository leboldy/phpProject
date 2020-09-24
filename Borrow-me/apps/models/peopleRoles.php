<?php
class PeopleRoles {
    public $peopleId;
    public $roleType;
    public $roleDescription;
    
    public function __construct($peopleId, $roleType, $roleDescription) {
        $this->peopleId = $peopleId;
        $this->roleType = $roleType;
        $this->roleDescription = $roleDescription;
        
    }
    /*
    public static function countRoleTypeByPeopleId($peopleId, $roleType){
        $db = Db::getInstance();
        $req = $db->prepare('SELECT * FROM people_roles where peo_id = :peopleId and rol_type = :roleType');
        $req->execute(array('peopleId' => $peopleId, 'roleType' => $roleType));
        $count = $req->rowCount();
        return $count;
    }
    

    
    // used on servies
    public static function getAllPeopleAndAllRoles() {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT a.peo_id, a.rol_type, b.peo_full_name, b.peo_nickname, c.rol_description FROM people_roles a, people b, roles c 
                            WHERE a.peo_id = b.peo_id and a.rol_type = c.rol_type');

        foreach ($req->fetchAll() as $peopleRoles) {
            //parei aqui 
            $list[] = new PeopleRoles(intval($peopleRoles['peo_id']), $peopleRoles['peo_full_name'], $peopleRoles['peo_nickname']);
        }
        
        return $list;
    }*/
    
    //OK
    public static function getPeopleRoleByPeopleId($peopleId){
        $list = [];
        $db = Db::getInstance();
        
        $req = $db->prepare('SELECT a.peo_id, a.rol_type, b.rol_description FROM people_roles a, roles b where a.rol_type = b.rol_type and a.peo_id = :peopleId');
        $req->execute(array('peopleId' => $peopleId));
        
        foreach ($req->fetchAll() as $peopleRole) {
            $list[] = new PeopleRoles($peopleRole['peo_id'], $peopleRole['rol_type'], $peopleRole['rol_description']);
        }
        return $list;
    }
    
    public static function getPeopleRoleByPeopleIdAndRoleType($peopleId, $roleType){
        $db = Db::getInstance();
        
        $req = $db->prepare('SELECT * FROM people_roles where rol_type = :roleType and peo_id = :peopleId');
        $req->execute(array('peopleId' => $peopleId, 'roleType' => $roleType));
        
        return $req->fetchColumn();
    }
    
    public static function submitPeopleRole($peopleId, $roleType) {
        $db = Db::getInstance();
        $req = $db->prepare('INSERT INTO people_roles (peo_id, rol_Type)
                            values (:peopleId, :roleType)');
        $req->execute(array('peopleId' => $peopleId, 'roleType' => $roleType));
    }
    
    public static function deletePeopleRoleByPeopleIdAndRoleType($peopleId, $roleType) {
        $db = Db::getInstance();
        $req = $db->prepare('DELETE FROM people_roles WHERE peo_id = :peopleId AND rol_type = :roleType');
        $req->execute(array('peopleId' => $peopleId, 'roleType' => $roleType));
    } 
    
    public static function deletePeopleRoleByPeopleId($peopleId) {
        $db = Db::getInstance();
        $req = $db->prepare('DELETE FROM people_roles WHERE peo_id = :peopleId');
        $req->execute(array('peopleId' => $peopleId));
    } 
}
?>