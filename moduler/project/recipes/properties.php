<?php
class properties{
	public $table='properties';
	public $parentId;
	public $pIdField='parentId';
	
	public function __construct($t=null,$p=null){
		$this->table=$t;
		$this->parentId=$p;
		$this->db=new db();
	}
	
	public function add($p){
		$sql='insert into '.$this->table.' 
		('.$this->pIdField.',name,value) values
		('.$this->parentId.',\''.$p->name.'\',\''.$p->value.'\')';
		
		$this->db->query($sql);
		if($this->db->affectedRows>0) 
			return true; 
		else 
			return false;
	}

	public function set($ps){
		$sql='insert into '.$this->table.' 
		('.$this->pIdField.',name,value) values';
		
		foreach($ps as $p){
			$sql.='('.$this->parentId.',
				\''.$p->name.'\',\''.$p->value.'\'),';
		}
		
		$sql=mb_substr($sql,0,-1);
		
		$this->db->query($sql);
		echo $sql;
		if($this->db->affectedRows>0) 
			return true; 
		else 
			return false;
	}
	
	public function get($name){
		$sql='select * from '.$this->table.' 
		where '.$this->pIdField.'='.$this->parentId.' and name=\''.$name.'\'
		limit 1';
		$r=$this->db->fetchFirstRecord($sql);
		if($r===false) return false;
		return $r->value;
	}
	
	public function getAll($namePrefix=null){
		
		if($namePrefix!=null)
			$sql='and name like \''.$name.'%\'';
		else 
			$sql='';
		
		$sql='select * from '.$this->table.' 
		where '.$this->pIdField.'='.$this->parentId.' '.$sql;
		
		$rs=$this->db->fetchListByQuery($sql);
		if($rs===false) return false;
		return $rs;
	}
	
}
?>
