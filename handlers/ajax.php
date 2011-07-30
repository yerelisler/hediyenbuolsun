<?php
require_once('ipage.php');

class ajaxHandler extends apage
{
	public function __construct(){
		parent::__construct();
	}
	
	public function run(){
		$r=$this->r;
		
		if(!isset($r['cmm'])){
			$this->generatedOutput='Komut bulunamadı.';
			return false;
		}
		
		$command=$r['cmm'];
		
		switch($command){
			case 'saveWallet':
				$this->saveWallet();
				break;
			case 'getWalletBox':
				$this->getWalletBox();
				break;
			case 'getTransactionTable':
				$this->getTransactionTable();
				break;
		}
		
	}
	
	protected function saveWallet(){
		//kullanıcı kontrol edilecek
		main::loadHandler('wallet');
		$w=new walletHandler();
		$id=$w->saveWallet();
		if(!$id)
			echo $w->error;
		else
			echo $id;
	}
	
	protected function getWalletBox(){
		
		if(!(isset($this->r['id']) && is_numeric($this->r['id']))){
			echo 'Cüzdan kayıt numarası belirtilmemiş.';
			return false;
		}
		
		//kullanıcı kontrol edilecek
		main::loadHandler('wallet');
		$wh=new walletHandler();
		$wm=new wallets();
		$w=$wm->get($this->r['id']);
		
		echo $wh->getWalletBox($w);
	}
	
	protected function getTransactionTable(){
		//kullanıcı kontrol edilecek
		main::loadHandler('transaction');
		$trn=new transactionHandler();
		
		echo $trn->getTransactionTable($trn->fetchTransactions());
		
	}
	
}


?>
