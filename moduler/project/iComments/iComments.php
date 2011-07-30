<?php
moduler::simportLib('db');
class iComments{
	
	public $table='comments';
	public $parentId;
	public $pIdField='parentId';
	
	public function __construct($t=null,$p=null){
		if($t!=null) $this->table=$t;
		if($p!=null) $this->pIdField=$p;
		$this->db=new db();
	}
	
	public function isValid($author,$comment){
		$this->error='';
		if(mb_strlen($author)<2 || mb_strlen($author)>30){
			$this->error='Yazar adı çok kısa.';
			return false;
		}
		if(mb_strlen($comment)<2 || mb_strlen($comment)>1500){
			$this->error='Yorumçok kısa.';
			return false;
		}
		return true;
	}
	
	public function add($author,$comment){
		if(!$this->isValid($author,$comment))
			return false;
		
		$ip=$_SERVER['REMOTE_ADDR'];
		$author=$this->db->escape($author);
		$comment=$this->db->escape($comment);
		
		$sql='insert into '.$this->table.' 
		('.$this->pIdField.',author,comment,ip) values
		('.$this->parentId.',\''.$author.'\',\''.$comment.'\',\''.$ip.'\')';
		
		$this->db->query($sql);
		return $this->db->affectedRows;
	}

	public function getAll($parentId=null){
		if($parentId!=null) $this->parentId=$parentId;
		
		$sql='select * from '.$this->table.' 
		where '.$this->pIdField.'='.$this->parentId.' 
		order by crtDate desc';
		
		$rs=$this->db->fetchListByQuery($sql);
		if($rs===false) return false;
		return $rs;
	}
	
	public function deleteByParent($parentId=null){
		if($parentId!=null) $this->parentId=$parentId;
		
		$sql='delete  from '.$this->table.' 
		where '.$this->pIdField.'='.$this->parentId.' ';
		
		$this->db->query($sql);
		return $this->db->affectedRows;
	}
}
?>
