<?php
    session_start();
   
    if (!isset($_SESSION['username'])) {
        require_once ('../views/pages/error.php');
    } else {
        require_once ('../controllers/lendingController.php');
        require_once ('../models/lending.php');
        require_once ('../../data/connection.php');
        
        switch($_SERVER['REQUEST_METHOD']){
            case 'GET':
                LendingController::getInvestorWithMoneyListJson();
                break;
        }
    }
    
?>