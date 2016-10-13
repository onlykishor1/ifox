<?php

class DashboardController extends Controller {

    function render()
    {
        $this->f3->set('content','dashboard.php');
        echo View::instance()->render('template.htm');
    }
}
