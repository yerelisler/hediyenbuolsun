<?php
require_once('ipage.php');
class indexHandler extends ipage{
	
	public function initialize(){
		parent::initialize();
		$this->xmlns='xmlns:fb="https://www.facebook.com/2008/fbml';

		$this->addCss(
			'index.css'
		);
		$this->addJs(array(
		));
		
		$this->name='home';
	}
	
	public function getBody(){
		echo 'OK';
	}
	
}

?>
