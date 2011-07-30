<?php
require_once('ipage.php');
class transactionHandler extends ipage{
	
	protected function initialize(){
		parent::initialize();
		
		$this->addCss(array(
			'jquery.datepicker.css'
		));
		
		$this->addJs(array(
			'jquery.date.js',
			'jquery.datePicker.js',
			'dateRangePicker.js',
			'transactions.js'
		));
		
		$this->name='transactions';
		$this->siteTitle='Para Giriş/Çıkış İşlemleri';
		
		$this->addPLib('wallets');
		$this->wlt=new wallets();
		$this->users=new users();
	}
	
	public function fetchTransactions(){
		$walletIds=$this->wlt->isPrivilegedTo(
			array(1,2,3),$this->u->id
		);
		$walletIds=explode(',',arrays::makeCloud($walletIds,'id',','));
		
		$t=$this->wlt->getTransactions(
			$walletIds,'both','2000-12-12','2011-11-11'
		);
		return $t;
	}
	
	public function getBody(){
		
		
		$t=$this->fetchTransactions();
		
		$h=$this->getTransactionTableFilter();
		$h.='<div class="trnTable">'.$this->getTransactionTable($t).'</div>';
		return $h;
	}
	
	public function getTransactionTableFilter(){
		$wallets=$this->wlt->getWalletsByUser($this->u->id);
		$h='<form action="?" method="post">
		<label>Gelir <input type="checkbox" name="incomeON" 
			class="incomeON"" /></label>
		<label>Gider <input type="checkbox" name="outgoingON"
			class="outgoingON" /></label>
		<select name="wallets">
		<option value="0">Hepsi</option>
		';
		foreach($wallets as $w)
			$h.='<option value="'.$w->id.'">'.$w->name.'</option>';
		$h.='</select>
		
		<div id="dateRange">
			<input type="hidden" class="sDatei" value="" />
			<input type="hidden" class="fDatei" value="" />
			<input class="sDate date-pick" value="23 Ekim 2010" />
			<input class="fDate date-pick" value="23 Ocak 2011" />
		</div>
		
		<div>
			<input type="text" name="keyword" class="tbox keyword" />
		</div>
		</form>';
		
		$h.='<script type="text/javascript">
			var trn=new transactions();
			makeDateRangePicker($("#dateRange"),trn.dateChanged);
		</script>';
		
		return $h;
	}
	
	public function getTransactionTable($transactions){
		$h='<table border=1 >
		<thead>
			<tr><th>Seç</th>
			<th>Yön</th>
			<th>Cüzdan</th>
			<th>Ne</th>
			<th>Tutar</th>
			<th>Tarih</th></tr>
		</thead>
		<tbody>';
		
		foreach($transactions as $t){
			$h.='<tr>
			<td><input type="checkbox" name="id" value="'.$t->id.'" /></td>
			<td>'.$t->type.'</td>
			<td>'.$t->walletName.'</td>
			<td>'.$t->tTitle.'</td>
			<td>'.$t->tAmount.'</td>
			<td>'.$t->tTime.'</td>
			</tr>';
		}
		
		$h.='</tbody>
		</table>';
		return $h;
	}
	
	
}
?>
