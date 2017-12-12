<?php
use Phalcon\Tag;
use Phalcon\Loader;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\DI\FactoryDefault;
use Phalcon\Logger\Adapter\File as Logger;
use Phalcon\Session\Adapter\Files as Session;
use Phalcon\Http\Response;

class Sql
{
	public $db, $logger, $stmt;

	public function execute($prepare, $bind_params = array(), $dbnum = 6)
	{
		if(isset($this->db[$dbnum]))
		{
			$stmt = $this->db[$dbnum]->prepare($prepare);
			$stmt->execute($bind_params);
			$this->logger->log(strtr($stmt->queryString,$bind_params));
			return $stmt;
		}
		return NULL;
	}
}
 
try {
	// Register an autoloader
	$loader = new Loader();
	$loader->registerDirs(
		array(
			'../app/controllers/',
			'../app/models/'
		)
	)->register();

	// Create a DI
	$di = new FactoryDefault();

	//use session for use security->checkToken
	$di['session'] = function() {
		$session = new Session();
		$session->start();
		return $session;
	};

	//check cache for login
	if( $_GET['_url'] != '/sign/in' && empty($di['session']->get('user')['pda_id']) )
	{
		$_GET['_url'] = '/';
	}

	//use logger after DI created
	$di['logger'] = function() {
		$logger = new Logger('/var/log/php-fpm/pda'.date("Ymd").'.log');
		return $logger;
	};
	
	// Set the database service
	$di['sql'] = function() use ($di) {
		$sql = new Sql();
		require_once("/var/lib/php/db_info.php");
		$sql->db[6] = new PDO($pg_dsn);
		$sql->logger = $di['logger'];
		return $sql;
	};

	// Setting up the view component, 
	// use ($di) for not define error
	$di['view'] = function() use ($di) {
		$view = new View();
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
		if(strpos($userAgent, 'iPhone') !== false) {
                    $d_width = 223;
                    $scale = '1.65';
                }
		else if(strpos($userAgent, 'compatible') !== false) {
                    $d_width = 223;
                    $scale = '1.0';
                }
		else if(strpos($userAgent, 'Windows') !== false) {
                    $d_width = 223;
                    $scale = '1.0';
                }
		else if(strpos($userAgent, 'Android') !== false) {
                    $d_width = 223;
                    $scale = '1.65';
                }
		$view->setVar('d_width',$d_width);
                $view->setVar('scale',$scale);
		$view->setViewsDir('../app/views/');
		$view->registerEngines(array(
			'.volt' => function($view, $di) {
			$volt = new VoltEngine($view, $di);
			$volt->setOptions(array(
				'compileAlways' => true
			));
			return $volt;
		},
			'.volt' => 'Phalcon\Mvc\View\Engine\Volt'
		));
		return $view;
	};

	// Setup a base URI so that all generated URIs include the 'tutorial' folder
	$di['url'] = function() {
		$url = new Url();
		$url->setBaseUri('/');
		return $url;
	};

	// Setup the tag helpers
	$di['tag'] = function() {
		return new Tag();
	};

	ini_set('include_path', '/home/webapps/ROOT/php/pda/public');
	// Handle the request
	$application = new Application($di);
	echo $application->handle()->getContent();

} catch (Exception $e) {
	$di['logger']->log($e->getMessage());
}