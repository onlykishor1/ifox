<?php

class Controller {

    protected $f3;
    protected $db;

    function beforeRoute()
    {
        // redirect to login page if no session
        $this->checkLogin();
    }

    function afterRoute()
    {
        // your code comes here
    }

    function checkLogin()
    {
        if(!$this->isLoggedIn()) {
            $this->f3->reroute('/login');
        }
    }

    function isLoggedIn()
    {
        return !($this->f3->get('SESSION.userid') === NULL);
    }

    function __construct()
    {   
        $f3=Base::instance();
        $this->f3=$f3;
        $this->db=$f3->DB;
    }
}