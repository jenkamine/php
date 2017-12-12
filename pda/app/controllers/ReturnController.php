<?php

use Phalcon\Mvc\Controller;
use Phalcon\Tag;

class ReturnController extends Controller
{
	public static $dbid = 6;//0->live,6->test
	
	public function indexAction()
	{
		//Add some local CSS resources
		$this->assets->addJs('js/menu.js');
		$this->assets->addCss('css/style.css');
		$this->view->setVar('w_chk1','');
		$this->view->setVar('w_chk2','');
		$this->view->setVar('w_chk3','');
		$this->view->setVar('w_chk4','checked');
		$this->view->setVar('w_chk5','');
		$this->view->setVar('title','반품');
	}
}