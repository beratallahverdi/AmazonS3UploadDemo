<?php
class S3_upload {

	function __construct()
	{
		$this->CI =& get_instance();			// Codeigniter Kütüphane Dosyasında Codeigniter özelliklerini çağırmak için gerekli instance'ın tanımlanması
		$this->CI->load->library('s3');			// Amazon S3 PHP SDK kütüphanesinin Eklenmesi

		$this->CI->config->load('s3', TRUE);	// Config Dosyalarında Oluşturulan S3 Ayarlarının Eklenmesi
		$s3_config = $this->CI->config->item('s3');			// Config Dosyasının değişkene alınması
		$this->bulut_adi = $s3_config['bucket_name'];		// Config Dosyasında tanımlı Bucket'ın Alınması
		$this->klasor_adi = $s3_config['folder_name'];		// Config Dosyasında tanımlı Klasörün Alınması
		$this->s3_url = $s3_config['s3_url'];				// Config Dosyasında tanımlı S3 Sunucu URL Sinin alınması
	}
	function getBulut(){											// Buckettan Dosyaların Alınma Metodu
		$kayitedilen = $this->CI->s3->getBucket($this->bulut_adi);		// Bucketta Yüklenmiş Dosyaların Alınması
		$dosyalar = array();
		foreach($kayitedilen as $anahtar => $deger){
			$dosyalar[] = array("url"=>$this->s3_url.$this->bulut_adi.'/'.$deger["name"],"boyut"=>$this->dosya_boyutu($deger["size"]));		// Bunların Dizi yardımıyla istenilen Yapıya çevirilmesi
		}
		return $dosyalar;											// Dosyaların geri Controller'a Döndürülmesi
	}
	function dosya_boyutu($size)
	{
		$units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
		$power = $size > 0 ? floor(log($size, 1024)) : 0;
		return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
	}
	function dosya_yukleme($file_path)								// Yükleme Metodu
	{
		$file = pathinfo($file_path);								// Yüklenecek Dosyanın bilgilerinin alınması
		$s3_file = $file['filename'].'-'.rand(1000,1).'.'.$file['extension'];	// Bilgelerin Rastgele Sayı Üreten Fonksiyon Yardımıyla çakışmasının Önüne Geçilmesi
		$mime_type = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $file_path);	// Yüklenen Dosyanın türününü belirlenmesi

		$kayitedilen = $this->CI->s3->putObjectFile(									// Amazon S3 PHP SDK yardımıyla Dosyanın upload Edilmesi
			$file_path,															// Yüklenecek Dosya yolu
			$this->bulut_adi,													// Yüklenecek Bucket
			$this->klasor_adi.$s3_file,										// Yüklenecek Konum
			S3::ACL_PUBLIC_READ,												// Dosyanın İzin Durumu
			array(),															// Varsa Meta Etiketinin Eklenmesi
			$mime_type															// Dosyanın Tipi
		);
		if ($kayitedilen) {															// Dosya Yüklenmişse konumunun Döndürülmesi
			return $this->s3_url.$this->bulut_adi.'/'.$this->klasor_adi.$s3_file;
		}
	}
}