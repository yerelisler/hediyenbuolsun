<?php
moduler::simportLib('antiFlood');
class iRating{
	protected $db;
	public $table='iRating';
	public $ctg;
	protected $aflood;
	
	public function __construct($table,$ctg){
		if($table!==null) $this->table=$table;
		if($ctg!==null) $this->ctg=$ctg;
		$this->db=new db();
		$this->aflood=new antiFlood($this->db);
		$this->aflood->type=$ctg;
	}
	
	public function rate($parentId,$point){
		
		$ctg=$this->db->escape($this->ctg);
		$ip=$this->db->escape($_SERVER['REMOTE_ADDR']);
		
		if(!$this->canBeRate($ctg,$parentId,$point,$ip))
			return false;
		
		$sql='insert into '.$this->table.' (ctg,parentId,point,ip)
		values(\''.$ctg.'\','.$parentId.','.$point.',\''.$ip.'\')';
		
		$this->db->query($sql);
		if($this->db->affectedRows){
			$this->aflood->add($ip,$parentId);
			return true;
		}
	}
	
	public function canBeRate($ctg,$parentId,$point,$ip){
		$this->aflood->type=$ctg;
		
		/*
		 * aynı ip adresnden tek bir konu için oylama sınırı aşılmış mı?
		 * */
		if(!$this->aflood->checkByIp($ip,$parentId)) return false;
		
		/*
		 * ip adresi farketmeksizin bir konu için oylama sınırı aşılmış mı?
		 * */
		if(!$this->aflood->checkByTag($parentId)) return false;
		
		/*
		 * hala izin verilen sınırlar içindeyse oylama yapılabilir.
		 * */
		return true;
	}
	
	public function get($parentId){
		$ctg=$this->db->escape($this->ctg);
		
		$sql='select count(id) as c from '.$this->table.' where
		ctg=\''.$ctg.'\' and parentId='.$parentId;
		$n=$this->db->fetchFirst($sql);
		if($n->c>0){
			$sql='select avg(point) as a from '.$this->table.' where
			ctg=\''.$ctg.'\' and parentId='.$parentId;
			$a=$this->db->fetchFirst($sql);
			$r->point=$a->a;
		}
		else
			$r->point=0;
		$r->count=$n->c;
		return $r;
	}
}
?>
