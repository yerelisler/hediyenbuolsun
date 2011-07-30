<?php
class pships{
	public $db;
	
	public function __construct(){
		$this->db=new db();
		
	}
	
	public function add($name,$companyId=1){
		$sql='insert into ships (name,companyId)
		values(\''.$name.'\',\''.$companyId.'\')';
		return $this->db->query($sql);
	}
	
	public function del($id){
		$sql='update ships set active=0 where id=\''.$id.'\' limit 1 ';
		return $this->db->query($sql);
	}
	
	public function reanme($shipId,$nName){
		$sql='
		update ships set name=\''.$this->db->escape($nName).'\' 
		where id=\''.$this->db->escape($shipId).'\' 
		limit 1 ';
		return $this->db->query($sql);
	}
	
	public function getAll(){
		$sql='select * from ships where active=1 order by name ';
		return $this->db->fetch($sql);
	}
	
	public function get($id){
		$sql='select * from ships 
		where active=1 and id=\''.$id.'\' limit 1';
		return $this->db->fetchFirst($sql);
	}
	
	
	
	public function createTopic($userId,$shipId,$title,$content){
		$sql='insert into topics (userId,shipId,title,message)
		values(
			\''.$this->db->escape($userId).'\',
			\''.$this->db->escape($shipId).'\',
			\''.$this->db->escape($title).'\',
			\''.$this->db->escape($content).'\')';
		
		if($this->db->query($sql))
			return $this->db->getInsertId();
		return false;
	}
	
	public function addTopicItem($userId,$topicId,$message){
		$sql='insert into topicItems (userId,topicId,message) 
		values(
			\''.$this->db->escape($userId).'\',
			\''.$this->db->escape($topicId).'\',
			\''.$this->db->escape($message).'\')';
		if($this->db->query($sql))
			return $this->db->getInsertId();
		return false;
	}
	
	public function deactiveTopic($topicId){
		$sql='update topics set active=0 where 
		id=\''.$this->db->escape($topicId).'\'
		limit 1';
		return $this->db->query($sql);
	}
	
	/**
	 * bir gemi için yazılmış son konuyu ve konunun son güncelleme tarihini
	 * verir.
	 * */
	public function getLastTopic($shipId){
		$sql='select t.*,ti.crtDate as uDate from 
		topics as t left join topicItems as ti on ti.topicId=t.id
		where t.active=1 and t.shipId=\''.$shipId.'\'
		order by ti.crtDate desc,t.crtDate desc limit 1';
		return $this->db->fetchFirst($sql);
	}
	
	/**
	 * bir gemi için yazılmış son konuyu ve konunun son güncelleme tarihini
	 * verir.
	 * */
	public function getLastItemOfTopic($topicId){
		$sql='select t.*,u.id as userId, u.username,u.fname,u.lname from 
		topicItems as t left join users as u on u.id=t.userId
		where t.topicId=\''.$this->db->escape($topicId).'\'
		order by t.crtDate desc limit 1';
		return $this->db->fetchFirst($sql);
	}
		
	/**
	 * bir gemiye ait konu adetini verir
	 * verir.
	 * */
	public function getTopics($shipId){
		$sql='select t.*,u.id as userId, u.username,u.fname,u.lname from 
		topics as t left join users as u on u.id=t.userId
		where t.active=1 and t.shipId=\''.$shipId.'\' order by t.crtDate desc';
		return $this->db->fetch($sql);
	}
	
	/**
	 * id'si belirtilen konu kaydını verir
	 * */
	public function getTopic($topicId){
		$sql='select t.*,u.id as userId, u.username,u.fname,u.lname from 
		topics as t left join users as u on u.id=t.userId
		where t.id=\''.$this->db->escape($topicId).'\' and t.active=1 limit 1';
		return $this->db->fetchFirst($sql);
	}
	
	/**
	 * id'si belirtilen konu kayıtlarını verir
	 * */
	public function getTopicsByIds($ids){
		foreach($ids as $k=>$i)
			$ids[$k]=$this->db->escape($i);
		
		$sql='select t.*,u.id as userId, u.username,u.fname,u.lname from 
		topics as t left join users as u on u.id=t.userId
		where t.id in (\''.implode('\',\'',$ids).'\') and t.active=1';
		return $this->db->fetch($sql);
	}
	
	/**
	 * id'si belirtilen konu kaydını verir
	 * */
	public function getTopicItems($topicId){
		$sql='select t.*,u.id as userId, u.username,u.fname,u.lname from 
		topicItems as t left join users as u on u.id=t.userId
		where t.topicId=\''.$this->db->escape($topicId).'\' ';
		return $this->db->fetch($sql);
	}
	
	/**
	 * id'si belirtilen konu maddesini(post/reply) verir
	 * */
	public function getItemById($itemId){
		$sql='select t.*,u.id as userId, u.username,u.fname,u.lname from 
		topicItems as t left join users as u on u.id=t.userId
		where t.id=\''.$this->db->escape($itemId).'\' ';
		return $this->db->fetchFirst($sql);
	}
	
	/**
	 * id'si belirtilen konu maddesini(post/reply) siler
	 * verir.*/
	public function delTopicItem($itemId){
		$sql='delete from topicItems 
		where id=\''.$this->db->escape($itemId).'\' limit 1';
		return $this->db->query($sql);
	}
	
	
	/**
	 * bir gemiye ait konu adetini verir
	 * verir.
	 * */
	public function getTopicCount($shipId){
		$sql='select count(id) as c from 
		topics as t where t.active=1 and t.shipId=\''.$shipId.'\' ';
		$c=$this->db->fetchFirst($sql);
		return $c->c;
	}
	
	/**
	 * bir gemiye ait konu adetini verir
	 * verir.
	 * */
	public function getTopicItemCount($topicId){
		$sql='select count(id) as c from 
		topicItems as ti where ti.topicId=\''.$topicId.'\' ';
		$c=$this->db->fetchFirst($sql);
		return $c->c;
	}
	
	/**
	 * kayıtlı bütün kullanıcıları verir
	 * */
	public function getUsers(){
		$sql='select * from users';
		return $this->db->fetch($sql);
	}
	
	/**
	 * id'si belirtilen kullanıcı kaydını alır
	 * */
	public function getUser($id){
		$sql='select * from users where 
		id=\''.$this->db->escape($id).'\'
		limit 1';
		return $this->db->fetchFirst($sql);
	}
	
	/**
	 * kullanıcı ekler
	 * */
	public function addUser($username,$password,$fname,$lname,$email,
		$active,$admin)
	{
		$sql='insert into users
		(companyId,username,password,fname,lname,email,active,admin)
		values(
			1,
			\''.$this->db->escape($username).'\',
			\''.$this->db->escape($password).'\',
			\''.$this->db->escape($fname).'\',
			\''.$this->db->escape($lname).'\',
			\''.$this->db->escape($email).'\',
			\''.$this->db->escape($active).'\',
			\''.$this->db->escape($admin).'\'
		)';
		return $this->db->query($sql);
	}
	
	/**
	 * kullanıcı kaydını günceller
	 * */
	public function updateUser($id,$username,$fname,$lname,$email,
		$active,$admin)
	{
		$sql='update users set
			username=\''.$this->db->escape($username).'\',
			fname=\''.$this->db->escape($fname).'\',
			lname=\''.$this->db->escape($lname).'\',
			email=\''.$this->db->escape($email).'\',
			active=\''.$this->db->escape($active).'\',
			admin=\''.$this->db->escape($admin).'\'
		where id=\''.$this->db->escape($id).'\' limit 1';
		return $this->db->query($sql);
	}
	
	/**
	 * kullanıcı kaydınını pasif yapar. bağlı topic ve topic mesajları da silinir
	 * */
	public function changeActive($id){
		$sql='update users set active=not active where 
		id='.$this->db->escape($id).'
		limit 1';
		return $this->db->query($sql);
	}
	
}
?>
