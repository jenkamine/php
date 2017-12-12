<?php

use Phalcon\Mvc\Controller;
use Phalcon\Tag;

class HomeController extends Controller
{
	public function indexAction()
	{
		//Add some local CSS resources
		$this->assets->addJs('js/output.js?'.time());
		$this->assets->addJs('js/menu.js?'.time());
		$this->assets->addCss('css/style.css?'.time());
		$this->view->setVar('title','홈');
	}
}