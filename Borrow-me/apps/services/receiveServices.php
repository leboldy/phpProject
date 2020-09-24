<?php
    session_start();
   
    if (!isset($_SESSION['username'])) {
        require_once ('../views/pages/error.php');
    } else {
        require_once ('../controllers/receiveController.php');
        require_once ('../models/receive.php');
        require_once ('../../data/connection.php');
        
        switch($_SERVER['REQUEST_METHOD']){
            case 'GET':
                ReceiveController::getReceiveListJson();
                break;
            case 'POST':
                ReceiveController::addReceive();
                break;
            case 'PUT';
                ReceiveController::updateReceive();
                break;
            case 'DELETE':
                ReceiveController::deleteReceive();
                break;
        }
    }
    
?>