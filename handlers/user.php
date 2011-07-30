<?php
require_once('ipage.php');
/**
 * the page of the users profile
 * */
class userHandler extends ipage{
	
	public function initialize(){
		parent::initialize();
		
		$this->addCss(
			'index.css'
		);

		$this->addJs(array(
		));
		
		$this->name='Kullanıcı';

		// Facebook Connect bilgileri
		$fb=new stdClass();
		$fb->url='http://mustafaatik.com/';
		$fb->appId='193214140732346';
		$fb->appSecret='41f212b24028e845b8f873aa0ef8a2ee';
		$this->facebook=$fb;
	}
	
	public function getBody(){
		$this->detectSubmit();
		return $this->getForms();
	}

	/**
	 * kayıt, giriş, fbLogin, hatırlama formlarının
	 * html çıktılarını topluca verir.
	 * */
	public function getForms(){
		$register=$this->getRegistrationForm();
		$login=$this->getLoginForm();
		$fbLogin=$this->getFBLoginForm();
		$pswRecover=$this->getPswRecoveryForm();
		return $register.$login.$fbLogin.$pswRecover;
	}

	/**
	 * kayıt formunu verir
	 * */
	public function detectSubmit(){
		if(!isset($this->p['formName']))
			return null;
		
		$fn=$this->p['formName'];
		arrays::kisset($this->p,array('email','password','repassword'));
		if($fn=='registration')
			return false;
	}
	
	
	/**
	 * kayıt formunu verir
	 * */
	public function getRegistrationForm(){
		return $this->loadView('registrationForm.php');
	}

	/**
	 * giriş formunu verir
	 * */
	public function getLoginForm(){
		return $this->loadView('loginForm.php');
	}

	/**
	 * FacebookLogin butonunu verir
	 * */
	public function getFBLoginForm(){
		$f=$this->facebook;

		//CSRF protection
		$_SESSION['state'] = md5(uniqid(rand(), TRUE)); 
		
		$dialogUrl = "http://www.facebook.com/dialog/oauth?client_id="
			.$f->appId."&redirect_uri=".urlencode($f->url)
			."&scope=email,user_birthday"
			."&state=".$_SESSION['state'];
		
		return $dialogUrl;
	}
	
	/**
	 * Şifre hatırlatma formunu verir
	 * */
	public function getPswRecoveryForm(){
		return $this->loadview('pswRecoveryForm.php');
	}

	
}

?>
