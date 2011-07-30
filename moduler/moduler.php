<?php
class moduler 
{
	private $dcroot='/';	// projenin kök dizini
	private $_mdldir='moduler';  // moduler mekanizmasını tutan dizin
	private $_ldir='libraries';  // genel kütüphanelerin bulunduğu dizin
	private $_pdir='project'; // projeye özgü sınıflarının bulunduğu dizin
	
	public function __construct(){
		$this->dcroot=$_SERVER['DOCUMENT_ROOT'].'';
	}
	
	
	/* @brief verilen mesajı, hata mesajı yapar. bunları günlükler.
	 * @params emsg		hatayı açıklayan metin mesajı
	 * @params log		hata mesajının günlüklenip günlüklenemyeceğini belirtir. 
	 * true ise günlüklenir, false ise günlüklenmez.
	 * @return			işlem başarılıysa true, başarısızsa false döndürür.
	 */
	private function throwError($emsg,$log=true){
		$this->error=$emsg;
		if($log) return $this->sendErrorLog();
		return false;
	}
	
	
	/* @brief 			verilen metin mesajı, hata günlük tablosuna ekler
	 * @params emsg		hatayı açıklayan metin mesajı
	 * @return			işlem başarılıysa true, başarısızsa false döndürür.
	 */
	private function sendErrorLog($emsg){
		// gelen mesajı veritabanına yazan bir kod olacak
	}
	
	
	/* @brief 			proje, modül ve temel dosyaları yükler.
	 * @params m		yüklenecek php dosyasının adı veya dosya adlarından
	 * oluşan bir dizi değişkendir. Dosya adlarında, dosya uzantıları olmaz.
	 * Dosya adında, dosyanın içinde bulunduğu dizin adı da olabilir.
	 * @paarms type		yüklenecek dosyaların türünü belirtir. 
	 * alabileceği değerler: project, base, core	
	 * @return			işlem başarılıysa true, başarısızsa false döndürür.
	 */
	public function importFiles($m,$type='project'){
		if($type=='project') 
			$sdir=$this->_pdir;
		elseif($type=='lib')
			$sdir=$this->_ldir;
		
		$path=$this->dcroot.'/'.$this->_mdldir.'/'.$sdir.'/';
		
		if(!is_array($m)){
			$m=array($m);
		}
		
		foreach($m as $f){
			if(file_exists($path.$f)){
				if(is_dir($path.$f)) 
					require_once($path.$f.'/'.$f.'.php');
				elseif(is_file($path.$f))
					require_once($path.$f);
				else
					return $this->throwError(
						'\''.$f
						.'\' isimli modül ne dizin ne de dosya bulundu.');
			}
		}
		return true;
	}
	
	
	/* @brief 			projeye özgü sınıf dosyalarını yükler.
	 * @params m		yüklenecek php dosyasının adı veya dosya adlarından
	 * oluşan bir dizi değişkendir. Dosya adlarında, dosya uzantıları olmaz.
	 * Dosya adında, dosyanın içinde bulunduğu dizin adı da olabilir.
	 * @return			işlem başarılıysa true, başarısızsa false döndürür.
	 */
	public function import($m){return $this->importFiles($m,'project');}
	public static function simport($m){	//static kopyası
		$o=new moduler();
		return $o->importFiles($m,'project');
	}
	
	/* @brief 			temel sınıf dosyalarını yükler.
	 * @params m		yüklenecek php dosyasının adı veya dosya adlarından
	 * oluşan bir dizi değişkendir. Dosya adlarında, dosya uzantıları olmaz.
	 * Dosya adında, dosyanın içinde bulunduğu dizin adı da olabilir.
	 * @return			işlem başarılıysa true, başarısızsa false döndürür.
	 */
	public function importLib($m){return $this->importFiles($m,'lib');}
	public static function simportLib($m){	//static kopyası
		$o=new moduler();
		return $o->importFiles($m,'lib');
	}
}
?>
