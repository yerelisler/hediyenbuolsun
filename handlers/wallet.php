<?php
require_once('ipage.php');
class walletHandler extends ipage{
	
	protected function initialize(){
		parent::initialize();
		$this->addCss('wallet.css');
		$this->addJs('wallets.js');
		$this->name='walletForm';
		$this->siteTitle='CÜZDAN FORMU';
		$this->addPLib('wallets');
		$this->wlt=new wallets();
		$this->users=new users();
	}
	
	public function getBody(){
		$h='';
		$h.=$this->getList();
		$h.=$this->showForm();
		return $h;
	}
	
	protected function getHeaderTips(){
		return 'yılında yaptığı açıklamayla sadece bazı google 
		kullanıcılarını google wave\'ye davet etmişti ve gmail\'deki 
		gibi davetiye sistemiyle çalışıyordu. deneme sürümünün bitiminin 
		ardından tamamen açılacağını duyuran google yetkilileri, google 
		wave\'yi tamamen halka açtılar.';
	}
	
	public function saveWallet(){
		$r=$this->r;
		
		// gerekli parametreler doğrulanıyor. 
		if(
			!isset($r['id'],$r['name'],$r['description']) 
			|| mb_strlen($r['name'])<2
		){
			$this->error='Cüzdan formu parametreleri geçersiz.';
			return false;
		}
		
		// yeni cüzdan formlarında id bilgisi "n123123" gibi 
		// rastgele bir veri olacaktır
		
		// yeni cüzdan kayıt formuysa
		if(!is_numeric($r['id'])){
			$o=$this->wlt->addWallet(
				$this->u->id,
				$r['name'],
				$r['description']
			);
		}
		else{
			$o=$this->wlt->updateWallet(
				$r['id'],
				$this->u->id,
				$r['name'],
				$r['description']
			);
		}
		
		if($o==true) return $o;
		
		$this->error=$this->wlt->error;
		return false;
		
	}
	
	protected function showForm(){
		
		$h='
		<form id="wForm" class="stdForm wForm" action="" method="post">
		<input type="hidden" name="id" value="n" />
		<h5 class="fTitle">YENİ CÜZDAN EKLE</h5>
		<div class="ffield">
			<label class="flabel">Adı: </label>
			<div class="finput">
				<input type="text" class="tbox name" name="name" />
			</div>
		</div>
		<div class="ffield">
			<label class="flabel">Açıklaması: </label>
			<div class="finput">
				<textarea class="description" name="description"
					></textarea>
			</div>
		</div>
		<div class="ffield">
			<div class="finput fbuttons">
				<input type="submit" value="Ekle" />
				<input type="reset" value="Temizle" />
			</div>
		</div>
		</form>
		
		<script type="text/javascript">
			var wlt=new wallets();
		</script>
		
		';
		
		return $h;
		
		$users=new users();
		$p->people=$users->fetchSharingUsers(1);
		$p->privileges=$users->fetchPrivileges();
		$p->form->title='BİLGİLERİ';
		return $this->applyViewer('walletForm.php',$p);
	}
	
	public function getList(){
		$wallets=$this->wlt->getAll($this->u->id);
		
		$h='<ul class="wallets">';
		foreach($wallets as $w){
			$h.=$this->getWalletBox($w);
			
		}
		$h.='</ul>';
		return $h;
	}
	
	public function getWalletBox($w){
		
		$h='<li class="wlt">
		<h4>'.$w->name.'</h4>
		<div class="remainder field">
			<span class="number">'.$w->remainder.'</span>
		</div>
		<div class="avg field">
			<span class="field"><b>Ort.Gelir: </b>
				<span class="number">'.$w->avgIncome.'</span>
			</span>
			<span class="field"><b>Ort.Gider: </b>
				<span class="number">'.$w->avgOutgoing.'</span>
			</span>
		</div>
		<div class="sum field">
			<span class="field"><b>Topl.Gelir: </b>
				<span class="number">'.$w->sIncome.'</span>
			</span>
			<span class="field"><b>Topl.Gider: </b>
				<span class="number">'.$w->sOutgoing.'</span>
			</span>
		</div>
		<div class="lastTransaction field">';
		if($w->last!=false){
			$h.='<b>Son: </b>
			'.$this->dt->getTurkishFormat($w->last->tTime).' -
			'.$w->last->tTitle.' 
			<span class="number">'.$w->last->tAmount.'</span>';
		}
		$h.='</div>
		<div class="description field">'.$w->description.'</div>
		<div class="toolbar field">
			<a class="del" href="">Kişi</a>
			<a class="del" href="">Gelir</a>
			<a class="del" href="">Gider</a>
			<a class="del" href="">Sil</a>
		</div>
		</li>';
		
		return $h;
	}
	
}
?>
