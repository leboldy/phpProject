<?php
//    session_start();
//    echo '</br> BEFORE ELSE</br> Controller: ',$controller;
//    echo 'Action: ', $action;

    function call($controller, $action) {
      
         //echo $controller.'</br>';
         //echo $action;
         //echo $_SESSION['username'];
        
        require_once('apps/controllers/' . $controller . 'controller.php');
        switch($controller) {
            case 'pages':
                require_once ('apps/models/receive.php');
                $controller = new PagesController();
                break;
            case 'login':
                $controller = new LoginController();
                break;
            case 'lending':
                require_once ('apps/models/people.php');
                require_once ('apps/models/lending.php');
                $controller = new LendingController();
                break;
            case 'receive':
                require_once ('apps/models/people.php');
                require_once ('apps/models/receive.php');
                require_once ('apps/models/lending.php');
                $controller = new ReceiveController();
                break;
            case 'fees':
                require_once ('apps/models/fees.php');
                $controller = new FeesController();
                break;
            case 'account':
                require_once('apps/models/people.php');
                require_once ('apps/models/account.php');
                $controller = new AccountController();
                break;
            case 'people':
                require_once ('apps/models/people.php');
                $controller = new PeopleController();
                break;
            case 'peopleRoles':
                require_once ('apps/models/peopleRoles.php');
                $controller = new PeopleRolesController();
                break;
        }
        
        $controller->{ $action }();
    }
    
    // we're adding an entry for the new controller and its actions
    $controllers = array('login' =>['userLogout'], 
                        'pages' => ['loginPage','home', 'error'], 
                        'lending' => ['addLendingPage', 'seeLendingPage', 'addLending'], 
                        'receive' => ['seeToReceiveToExpirePage', 'seeToReceivePage', 'updateReceivePage', 'updateReceive'],
                        'fees' => ['feesMovementPage', 'addFeesPage', 'withdrawal'],
                        'account' => ['accountAddPage','accountMovementPage', 'submitAccount'],
                        'people' => ['peopleAddPage', 'peopleMovementPage', 'AddPeople'],
                        'peopleRoles' => ['seePeopleRolesPage']);
    
    if (array_key_exists($controller, $controllers)) {
        if (in_array($action, $controllers[$controller])) {
            call($controller, $action);
        } else {
            call('pages', 'error');
        }
    } else {
        call('pages', 'error');
    }
?>