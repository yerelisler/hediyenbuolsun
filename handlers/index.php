<?php
require_once('ipage.php');
class indexHandler extends ipage{
	
	public function initialize(){
		parent::initialize();
		
		$this->addCss(
			'index.css'
		);
		$this->addJs(array(
		));
		
		$this->name='home';
	}
	
	public function getBody(){
		return $this->showRegistrationForm();
	}


	public function showRegistrationForm(){
		main::loadHandler('user');
		$m=new userHandler();
		return $m->getRegistrationForm();
	}
	
}

?>
