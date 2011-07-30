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
	
	
	protected function initialize(){
		$this->addCss(array('reset.css','common.css','form.css'));
		$this->addJS(array('jquery.js','extfunctions.js','createXHR.js'));
		$this->addJS('http://connect.facebook.net/en_US/all.js#xfbml=1');
		$this->addLib('db');
		$this->addPLib('recipes');
		$this->addPLib('recipeComment');
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
		
		$h='
		<div id="header">
		
<div class="left">
	<a href="/" id="logo">
		<img src="imgs/common/logo.png" alt="FOOD Recipes" title="go to Home Page" />
	</a>
</div>

<div class="right">

<form id="search" class="ropts" action="">
	<label class="ropt">Search: </label>
	<input type="text" name="receipeKeyword" id="recipeKeyword" 
		value="" />
	<select name="">
		<option>in recipes</option>
		<option>in ingredients</option>
	</select>
	<input type="submit" value="Search" />
</form>
<div class="ropts">
	<label class="ropt">Letters: </label>
	<a href="#">A</a>
	<a href="#">B</a>
	<a href="#">C</a>
	<a href="#">Ç</a>
	<a href="#">D</a>
	<a href="#">E</a>
	<a href="#">F</a>
	<a href="#">G</a>
	<a href="#">I</a>
	<a href="#">İ</a>
	<a href="#">J</a>
	<a href="#">K</a>
	<a href="#">L</a>
	<a href="#">M</a>
	<a href="#">N</a>
	<a href="#">O</a>
	<a href="#">Ö</a>
	<a href="#">P</a>
	<a href="#">R</a>
	<a href="#">S</a>
	<a href="#">Ş</a>
	<a href="#">T</a>
	<a href="#">U</a>
	<a href="#">Ü</a>
	<a href="#">V</a>
	<a href="#">Y</a>
	<a href="#">Z</a>
</div>
<div class="ropts" class="ctgs">
	<label class="ropt">Categories: </label>
	<select>
		<option>Desserts</option>
		<option>Appetizers</option>
	</select>
	<span class="qlinks">
		| <a href="">Top 50</a> | <a href="">Newest</a> | <a href="">Daily</a>
	</span>
</div>

</div> <!-- right side -->

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
