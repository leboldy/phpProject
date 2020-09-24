<?php
    session_start();
   
    if (!isset($_SESSION['username'])) {
        require_once ('../views/pages/error.php');
    } else {
        require_once ('../controllers/lendingController.php');
        require_once ('../models/lending.php');
        require_once ('../controllers/receiveController.php');
        require_once ('../models/receive.php');
        
        
        require_once ('../../data/connection.php');
        
        switch($_SERVER['REQUEST_METHOD']){
            case 'GET':
                LendingController::getLendingListJson();
                break;
            case 'PUT':
                LendingController::updateLending();
                break;
            case 'DELETE':
                LendingController::deleteLending();
                break;
            case 'POST':
                LendingController::addLending();
                break;
        }
    }
    
?>