<?php

class main 
{
	public static function serve($handler){
		
		if(preg_replace('/(\.)|(\/)|(\\\\)/i','',$handler)!==$handler){
			echo 'Zararlı parametre!';
			return false;
		}
		main::loadHandler($handler);
		$className=$handler.'Handler';
		$n=new $className();
		echo $n->getOutput();
	}
	
	public static function loadHandler($handler){
		require_once('handlers/'.$handler.'.php');
	}
}

main::serve($_GET['_handler']);
?>
