<?php

use Phalcon\Mvc\Controller;
use Phalcon\Tag;

class IndexController extends Controller
{
	public static $dbid = 6;//0->live,6->test
	
	public function indexAction()
	{
		//if(isset($this->session->get('user'))) $this->session->set('user',array('pda_id'=>'','name'=>'');
		//Add some local CSS resources
		$this->assets->addJs('js/menu.js');
		$this->assets->addCss('css/style.css');
		$this->view->setVar('title','로그인');
	}
}