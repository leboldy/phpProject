<?php
session_start();

class PagesController
{

    public function home()
    {
        if (isset($_SESSION['username'])) {
            require_once ('apps/views/pages/index.php');
        } else
            $this->error();
    }

    public function loginPage()
    {
        require_once ('apps/views/pages/login.php');
    }
    
    public function error()
    {
        require_once ('apps/views/pages/error.php');
    }
}
?>