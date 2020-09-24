<?php
    session_start();
    require_once ('data/connection.php');

    if (isset($_GET['controller']) && isset($_GET['action'])) {
        $controller = $_GET['controller'];
        $action     = $_GET['action'];
    } 
/*     echo "\n DASHBOARD \n";
    echo '</br>',$controller;
    echo $action;
    echo $_SESSION['username'];
    echo $_SESSION['userLogout']; */
    
    
     if (!isset($_SESSION['username']) || ($controller =='login' && $action == 'userLogout')) {
/*         echo 'entrou';
        echo '</br>Dentro Controller: ',$controller;
        echo '</br>Dentro Action: ',$action;
        echo '</br>Dentro SESSION: ',$_SESSION['username'];
        echo '</br>Dentro SESSION LOGOUT: ',$_SESSION['userLogout']; */
                
        require_once('apps/controllers/loginController.php');
        $loginController = new LoginController();
        $loginController->userLogout();
        $loginController->userAuthentication();
    } else {
        require_once('apps/views/pages/index.php');
    } 
    
    
 /*    if ((!$controller ='login' && !$action = 'userLogout') && (isset($_SESSION['username']))) {
        echo 'entrou';
    }
        
    if (isset($_SESSION['username'])) {
            
    
      //  if(isset($_SESSION['userLogout'])) {
        //    echo 'ROUTES';
          //  require_once 'config/routes.php';
       // } else {
            echo 'DASHXX';
            require_once('apps/views/pages/dashboard.php');
        //}
        //require_once 'config/routes.php';        
    } else {
        require_once('apps/controllers/login_controller.php');
        $login_controller = new LoginController();
        $login_controller->userAuthentication();
    }
?> */