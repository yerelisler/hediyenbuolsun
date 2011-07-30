<?php
require_once('ipage.php');
class indexpage extends ipage{
	
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
		
	}
	
}

$p=new indexpage(); echo $p->getOutput();
?>
