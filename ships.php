<?php
require_once('ipage.php');
class shipsp extends ipage{
	
	public function initialize(){
		parent::initialize();
		$this->addCss('ships.css');
		$this->addJs('ships.js');
		$this->name='ships';
		if(isset($this->r['cmm']))
			$this->cmm=$this->r['cmm'];
		else
			$this->cmm='';
		
	}
	
	public function getBody(){
		
		$h='<h1>Ship List';
		if($this->u->admin) $h.='<a href="#" class="addShip">Add</a>';
		$h.='</h1>';
		
		switch($this->cmm){
			case 'addShip':
				if($this->u->admin && $this->addShip())
					$h.='<p class="success">A new ship is added.</p>';
				else
					$h.='<p class="error">An error occurred.</p>';
				break;
			case 'delShip':
				if($this->u->admin && $this->delShip())
					$h.='<p class="success">The ship is removed.</p>';
				else
					$h.='<p class="error">An error occurred.</p>';
				break;	
		}
		
		$h.=$this->listShips();
		return $h;
	}
	
	public function addShip(){
		$newShip=$this->p['name'];
		return $this->ships->add($newShip);
	}
	
	public function delShip(){
		$shipId=$this->r['shipId'];
		return $this->ships->del($shipId);
	}
	
	public function listShips(){
		
		$sList=$this->ships->getAll();
		
		$h=$this->showShipForm();
		
		
		
		$h.='<ul class="record">';
		foreach($sList as $s){
			$lT=$this->ships->getLastTopic($s->id);
			$tC=$this->ships->getTopicCount($s->id);
			$h.='<li>
				<img class="icon" src="imgs/common/ship72x72.png" alt="Ship" />
				<div class="detail">
					<h3>
						<input type="hidden" name="shipId" 
							value="'.$s->id.'" />
						<a href="topics.php?id='.$s->id.'&cmm=listTopic"
							class="shipName">'.$s->name.'</a>';
						
						if($this->u->admin==1)
						$h.='
							<a href="" class="rename">Rename</a>
							<a href="?cmm=delShip&shipId='.$s->id.'" class="remove">
							<img src="imgs/common/remove.gif" alt="Remove" />
						</a>';
						
					$h.='</h3>';
					if($lT){
						
						if($lT->uDate==null)
							$lT->uDate=strtotime($lT->crtDate);
						else
							$lT->uDate=strtotime($lT->uDate);
							
						$h.='<div class="topic">
							<b>Last: </b>
							<a href="topics.php?id='.$s->id.'&topicId='.$lT->id.'&cmm=listItems"
								>'.$lT->title.'</a>
							<span class="date">at '.date('d M Y H:i',$lT->uDate).'</span>
						</div>';
					}			
					$h.='
					<div class="status">
						'.$tC.' topics 
						<a href="topics.php?cmm=listTopics&id='.$s->id.'">[List All]</a>
						<a href="topics.php?cmm=newTopicForm&id='.$s->id.'">[Create a new]</a>
					</div>
				</div>';
		}
		$h.='</ul>';
		
		return $h;
		
	}
	
	public function showShipForm(){
		$h='<form id="shipForm" action="?" method="post">
		<input type="hidden" name="cmm" value="addShip" />
		<label>Name: </label><input type="text" name="name" value="" />
		<input type="submit" value="Save" />
		<input type="button" class="cancel" value="Cancel" />
		</form>';
		return $h;
	}
	
	
}

$p=new shipsp(); echo $p->getOutput();
?>
