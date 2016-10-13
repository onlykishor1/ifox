<?php

class UserController extends Controller {

    function beforeroute()
    {
        # code...
    }

   	// get
    function login()
    {
         // $this->f3->get('SERVER.SERVER_PORT');
        if(!$this->f3->exists('notification')) {
            $this->f3->set('notification','');
        }
        $this->f3->set('content','auth/login.php');
        echo View::instance()->render('template.htm');
    }

    // get
    function registerPage()
    {
        $this->f3->set('content','auth/register.php');
        echo View::instance()->render('template.htm');
    }

    // post
    function register()
    {
        // models/user.php
        $user = new User($this->db);
        $user->copyFrom('POST');
        $user->save();

        $this->f3->set('notification','You have been registered!');

        $this->login();
    }

    function authenticate()
    {
    	// models/user.php
    	$user = new User($this->db);
    	$user->getByEmail($this->f3->get('POST.email'));

    	if($user->dry()) // no records
    	{
            $this->f3->set('notification','No data.');
    		$this->f3->reroute('/login');
    	}

    	// if(password_verify($this->f3->get('POST.password'), password_hash($user->password,PASSWORD_DEFAULT)))
        if($this->f3->get('POST.password') == $user->password)
    	{
    		$this->f3->set('SESSION.userid', $user->id);
    		$this->f3->reroute('/dashboard');
    	} else {
            $this->f3->set('notification','Your login details did not match.');
    		// $this->f3->reroute('/login');
            $this->login();
    	}
    }

    function logout()
    {
    	$this->f3->set('SESSION.userid', NULL);
    	$this->f3->reroute('/login');
    }

    function profilePage()
    {
        // redirect to login page if no session
        $this->checkLogin(); // Controller method

        $user = new User($this->db);
        $user->getById($this->f3->get('SESSION.userid'));

        if(!$user->dry()) {
            $this->f3->set('user',$user);
            $this->f3->set('content','user/profile.php');
            echo View::instance()->render('template.htm');
        }
    }
}