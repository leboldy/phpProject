<?php
    session_start();
   
    if (!isset($_SESSION['username'])) {
        require_once ('../views/pages/error.php');
    } else {
        require_once ('../controllers/peopleController.php');
        require_once ('../models/people.php');
        require_once ('../../data/connection.php');
        
        switch($_SERVER['REQUEST_METHOD']){
            case 'GET':
                PeopleController::getInvestorJson();
                break;
        }
    }
    
?>