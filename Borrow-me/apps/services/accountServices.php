<?php
    session_start();
   
    if (!isset($_SESSION['username'])) {
        require_once ('../views/pages/error.php');
    } else {
        require_once ('../controllers/AccountController.php');
        require_once ('../models/account.php');
        require_once ('../../data/connection.php');
        
        switch($_SERVER['REQUEST_METHOD']){
            case 'GET':
                AccountController::getListAccountJson();
                break;
            case 'POST':
                AccountController::submitAccount();
                break;
            case 'PUT':
                AccountController::updateAccount();
                break;
            case 'DELETE':
                Account::deleteAccount();
                break;
        }
    }
    
?>