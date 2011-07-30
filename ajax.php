<?php
require_once('moduler/moduler.php');
moduler::simportLib('apage');
class ajax extends apage
{
	public function run(){
		
		$r=$this->r;
		if(!isset($r['cmm'])) return false;
		$this->addLib('db');
		
		switch($r['cmm']){
			case 'shipReanme':
				$this->renameShip();
		}
	
	}
	
	public function renameShip(){
		
		$r=$this->r;
		
		if(!isset($r['shipId'],$r['nName']) 
			|| !is_numeric($r['shipId'])
			|| $this->u->admin!=1
		)
			return false;
		
		$this->addPLib('ships.php');
		$s=new pships();
		
		if($s->reanme($r['shipId'],$r['nName']))
			echo 1;
		else
			echo 0;
		
	}
	
}

$p=new ajax();

?>
