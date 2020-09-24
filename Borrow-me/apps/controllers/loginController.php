<?php
session_start();
require_once ('apps/models/authentication.php');

class LoginController
{

    public $authentication;

    public function __construct()
    {
        $this->authentication = new Authentication();
        $auth = FALSE;
    }

    public function userAuthentication()
    {
        $auth = $this->authentication->getLogin();
        if ($auth == TRUE) {
            $controller = 'pages';
            $action = 'home';
            $_SESSION['username'] = $_REQUEST['username'];
        } else {
            if (isset($_REQUEST['username'])) {
                //echo 'Usuario ou senha invalidas';
                $_SESSION['loginError'] = TRUE;
            }
            $controller = 'pages';
            $action = 'loginPage';
        }
        require_once ('config/routes.php');
    }

    public function userLogout()
    {
        session_unset();
    }
}
?>