<?php
require_once('properties.php');
moduler::simport('iRating');
class recipes{
	public $db;
	public $ingreduents;
	public $properties;
	public function __construct(){
		$this->db=new db();
		
		$this->ingreduents=new properties();
		$this->ingreduents->table='ingreduents';
		$this->ingreduents->pIdField='reciepId';
		
		$this->properties=new properties();
		$this->properties->table='reciepProperties';
		$this->properties->pIdField='reciepId';
		
		/*
		 * yemek tarifi oylama modülü ekleniyor
		 * */
		moduler::simportLib('iRating');
		$this->rating=new iRating(null,'recipeRating');
	}
	
	public function add($ctg,$title,$preparation,$ingreduents,$properties){
		$sql='insert into recieps (categoryId,title,preparation)
		values('.$ctg.',\''.$title.'\',\''.$preparation.'\')';		
		$this->db->query($sql);
		if($this->db->affectedRows==1){
			$this->ingreduents->parentId=$this->db->getInsertId();
			$this->properties->parentId=$this->db->getInsertId();
			$this->ingreduents->set($ingreduents);
			$this->properties->set($properties);
			return true;
		}
		return false;
	}
	
	public function update($id,$ctg,$title,$preparation,$ingreduents,$properties){
		$sql='update recieps set
		categoryId='.$ctg.' and title=\''.$title.'\' and preparation=\''.$preparation.'\'
		where id='.$id.' limit 1';
		$this->db->query($sql);
		if($this->db->affectedRows==1){
			$this->ingreduents->parentId=$this->db->getInsertId();
			$this->properties->parentId=$this->db->getInsertId();
			$this->ingreduents->set($ingreduents);
			$this->properties->set($properties);
			return true;
		}
		return false;
	}
	public function del($id){
		$sql='delete * from recieps where id='.$id.' limit 1';
		$this->db->query($sql);
		if($this->db->affectedRows==1){
			return true;
		}
		return false;
	}
	public function get($id){
		$sql='select * from recieps where id='.$id.' limit 1';
		$r=$this->db->fetchFirst($sql);
		if($r){
			
			$r->rate=$this->rating->get($id);
			
			$this->properties->parentId=$id;
			$r->properties=$this->properties->getAll();
			
			$this->ingreduents->parentId=$id;
			$r->ingreduents=$this->ingreduents->getAll();
		}
		return $r;
	}
	public function filter(){
		
	}
	public function getAll(){
		$sql='select * from recieps';
		$rs=$this->db->fetch($sql);
		foreach($rs as $r){
			
			$r->rate=$this->rating->get($r->id);
			
			$this->properties->parentId=$r->id;
			$r->properties=$this->properties->getAll();
			
			$this->ingreduents->parentId=$r->id;
			$r->ingreduents=$this->ingreduents->getAll();
		}
		return $rs;
	}
	
	public function getByCtg(){
	}
	
	public function getAllCtg(){
		$sql='select * from categories order by name';
		return $this->db->fetch($sql);
	}
	
	public function rate($id,$point){
		return $this->rating->rate($id,$point);
	}
	
	public function goruntulemeArttir(){
	}
	
	
}
?>
