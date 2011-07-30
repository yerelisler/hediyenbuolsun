<?php
require_once('ipage.php');
/**
 * the page of the users profile
 * */
class meHandler extends ipage{
	
	public function initialize(){
		parent::initialize();
		
		$this->addCss(
			'index.css'
		);

		$this->addJs(array(
		));
		
		$this->name='Kullanıcı';
	}
	
	public function getBody(){
		return $this->getForms();
	}

	/**
	 * kayıt, giriş, fbLogin, hatırlama formlarının
	 * html çıktılarını topluca verir.
	 * */
	public function getForms(){
	}

	/**
	 * kayıt formunu verir
	 * */
	public function getRegistrationForm(){
	}

	/**
	 * giriş formunu verir
	 * */
	public function getLogin(){
	}

	/**
	 * FacebookLogin butonunu verir
	 * */
	public function getFBLogin(){
	}
	
	/**
	 * Şifre hatırlatma formunu verir
	 * */
	public function getPswRecoveryForm(){
	}

	
}

?>
