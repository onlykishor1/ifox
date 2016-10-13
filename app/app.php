<?php
declare (strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

// Kickstart the framework
//$f3=require('lib/base.php');
$f3 = \Base::instance();

// $f3->set('DEBUG',4);
if ((float)PCRE_VERSION<7.9)
	trigger_error('PCRE version is out of date');

// Load configuration
$f3->config('config.ini');

if($f3->get('DEBUG') === 4) {
	$whoops = new \Whoops\Run;
	$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
	$whoops->register();
}

new Session();

// $db=new DB\SQL(
//     $f3->get('devdb'),
//     $f3->get('devdbusername'),
//     $f3->get('devdbpassword'),
//     array( \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION )
// );

// BEGIN CSRF

$f3->DB=new DB\SQL('mysql:host=127.0.0.1;port=3306;dbname=f3;','root','');

$f3->route('GET|POST /test-csrf',function($f3,$params){

    // new DB\SQL\Session($f3->DB,'sessions',TRUE,NULL,'CSRF');
    // or:
    $sess = new DB\SQL\Session($f3->DB);
    $f3->CSRF=$sess->csrf();

    if ($f3->VERB=='POST') {
        if ($f3->get('POST.token')!=$f3->get('SESSION.csrf'))
            echo 'CSRF attack!';
        else
            echo 'Your name is '.$f3->get('POST.name');
        die();
    }

    $f3->copy('CSRF','SESSION.csrf');

    echo '<form action="" method="post">'.
        '<input type="text" name="name" value="" placeholder="Your name"/>'.
        '<input type="hidden" name="token" value="'.$f3->CSRF.'"/>'.
        '<button type="submit">Submit</button></form>';

});

// END CSRF

$f3->route('GET /',
	function($f3) {
		$classes=array(
			'Base'=>
				array(
					'hash',
					'json',
					'session'
				),
			'Cache'=>
				array(
					'apc',
					'memcache',
					'wincache',
					'xcache'
				),
			'DB\SQL'=>
				array(
					'pdo',
					'pdo_dblib',
					'pdo_mssql',
					'pdo_mysql',
					'pdo_odbc',
					'pdo_pgsql',
					'pdo_sqlite',
					'pdo_sqlsrv'
				),
			'DB\Jig'=>
				array('json'),
			'DB\Mongo'=>
				array(
					'json',
					'mongo'
				),
			'Auth'=>
				array('ldap','pdo'),
			'Bcrypt'=>
				array(
					'mcrypt',
					'openssl'
				),
			'Image'=>
				array('gd'),
			'Lexicon'=>
				array('iconv'),
			'SMTP'=>
				array('openssl'),
			'Web'=>
				array('curl','openssl','simplexml'),
			'Web\Geo'=>
				array('geoip','json'),
			'Web\OpenID'=>
				array('json','simplexml'),
			'Web\Pingback'=>
				array('dom','xmlrpc')
		);
		$f3->set('classes',$classes);
		$f3->set('content','welcome.htm');
		echo View::instance()->render('layout.htm');
	}
);

$f3->route('GET /reference',
	function($f3) {
		$f3->set('content','userref.htm');
		// $f3->set('content', Markdown::instance()->convert(Base::instance()->read('readme.md')));
		echo View::instance()->render('layout.htm');
	}
);

$f3->route('GET /hive',
	function($f3) {
		//$f3->set('content','userref.htm');
		// $f3->set('content', Markdown::instance()->convert(Base::instance()->read('readme.md')));
		echo '<pre>';
		echo $f3->get('AUTOLOAD') . '<br>';
		print_r($f3->hive());
	}
);

// $f3->route('GET /login',
// 	function($f3) {
// 		$f3->set('content','auth/login.php');
// 		echo View::instance()->render('template.htm');
// 	}
// );

$f3->route('GET /login', 'UserController->login');
$f3->route('POST /login', 'UserController->authenticate');

$f3->route('GET /register', 'UserController->registerPage');
$f3->route('POST /register', 'UserController->register');

$f3->route('GET /logout', 'UserController->logout');
$f3->route('GET /dashboard', 'DashboardController->render');

$f3->route('GET /profile', 'UserController->profilePage');
$f3->route('POST /profile', 'UserController->profile');

$f3->run();
