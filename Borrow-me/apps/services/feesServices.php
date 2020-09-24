<?php
    session_start();
   
    if (!isset($_SESSION['username'])) {
        require_once ('../views/pages/error.php');
    } else {
        require_once ('../controllers/feesController.php');
        require_once ('../models/fees.php');
        require_once ('../../data/connection.php');
        
        switch($_SERVER['REQUEST_METHOD']){
            case 'GET':
                FeesController::getFeesListJson();
                break;
            case 'POST':
                //FeesController::withdrawal();
                break;
            case 'PUT':
                FeesController::updateFees();
                break;
            case 'DELETE':
                FeesController::deleteFees();
                break;
        }
    }
    
?>