<?php
require_once('moduler/moduler.php');
moduler::simportLib('apage');
class ipage extends apage{
	
	/* Ana menünün altında gösterilecek, gözüken sayfaya özgü bağlantılar
	 * */
	protected $subMenu=array();
	
	/* ana menü altındaki yardım ve ipucu metni gözükecek mi?
	 * */
	protected $showHeaderTips=true;
	public $siteTitle='Hediyen bu olsun!';
	
	protected function initialize(){
		
		$this->checkLogin();
		
		$this->addCss(
			array(
				'reset.css',
				'common.css',
				'form.css',
				'menu_style.css'
		));
		
		$this->addJS(
			array(
				'jquery.js',
				'extfunctions.js',
				'createXHR.js'
		));
		
		$this->addLib('db');
		//$this->addPLib();
	}
	
	protected function checkLogin(){
		
	}
	
	public function run(){
		$h=$this->getHeaders();
		$h.='<div id="mcontainer">';
		$h.=$this->getMenu();
		$h.='<div id="mcontent">'.$this->getBody().'</div>';
		$h.='</div>';
		
		$h.=$this->getFoother();
		$this->generatedOutput=$h;
	}
	
	public function getMenu(){
		$n=$this->name;
		$h='
		<div id="header">
		menü
		</div> <!-- header -->
		';
		return $h;
	}
	
	public function getBody(){}
	public function getFoother(){
		return '</body></html>';
	}
}
?>
