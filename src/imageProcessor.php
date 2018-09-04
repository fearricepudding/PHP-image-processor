<?php

class imageProcessor{

	// publics
	public $resampleCropSize = '500';
	public $maxsize = '20971520';
	public $imagePath = '';
	public $imageType = '';
	public $imageSize = '';
	public $imageWidth = '';
	public $imageHeight = '';
	public $storePath = 'images/';

	//Privates
	private $tmpName = '';
	private $imageSrc = '';
	private $tempImage = '';


	
	public function __construct($imagePath = null){
		if(null !== $imagePath){
			$this->imagePath = (string) stripslashes(htmlspecialchars($imagePath['name']));
			$this->imageType = strtolower($this->getExtension($imagePath['name']));
			$this->tmpName = $imagePath['tmp_name'];
			$this->imageSize = filesize($imagePath['tmp_name']);
			list($this->imageWidth,$this->imageHeight) = getimagesize($this->tmpName);
		}else{
			$this->error = 'No image selected.';
			return false;
		};
	}

	public function selectImage($imagePath){
		if(null !== $imagePath){
			$this->imagePath = (string) stripslashes(htmlspecialchars($imagePath['name']));
			$this->imageType = strtolower($this->getExtension($imagePath['name']));
			$this->tmpName = $imagePath['tmp_name'];
			$this->imageSize = filesize($imagePath['tmp_name']);
			list($this->imageWidth,$this->imageHeight) = getimagesize($this->tmpName);
		}else{
			$this->error = 'No image selected';
			return false;
		};
	}

	public function resample(){

		if($this->validExtension($this->imageType)){

			switch($this->imageType) {
	            case "jpg" : $this->imageSrc = imagecreatefromjpeg($this->tmpName); break;
	            case "jpeg" : $this->imageSrc = imagecreatefromjpeg($this->tmpName); break;
	            case "png" : $this->imageSrc = imagecreatefrompng($this->tmpName); break;
	            case "gif" : $this->imageSrc = imagecreatefromgif($this->tmpName); break;
	        }

	        $this->tempImage = imagecreatetruecolor($this->resampleCropSize, $this->resampleCropSize); 
	        $color = imagecolorallocatealpha($this->tempImage, 255, 255, 255, 127); 
	        //fill transparent back
	        imagefill($this->tempImage, 0, 0, $color);
	        imagesavealpha($this->tempImage, true);
	        
	        imagecopyresampled($this->tempImage, $this->imageSrc, 0, 0, 0, 0, $this->resampleCropSize, $this->resampleCropSize, $this->imageWidth, $this->imageHeight);

	        switch ($this->imageType) {
	            case "jpg":
	                imagejpeg($this->tempImage, $this->storePath.$this->getNewResoultion().'_'.$this->imagePath, 100);
	                break;
	            case "jpeg":
	                imagejpeg($this->tempImage, $this->storePath.$this->getNewResoultion().'_'.$this->imagePath, 100);
	                break;
	            case "png":
	                imagepng($this->tempImage, $this->storePath.$this->getNewResoultion().'_'.$this->imagePath, 0);
	                break;
	            case "gif":
	                imagegif($this->tempImage, $this->storePath.$this->getNewResoultion().'_'.$this->imagePath );
	                break;
	        }

	        imagedestroy($this->tempImage);

	        return $this->storePath.$this->getNewResoultion().'_'.$this->imagePath;

	    }else{

	    	$this->error = 'File type not supported for resample';
	    	return false;

	    };

	}

	public function getResolution(){
		return $this->imageWidth.'x'.$this->imageHeight;
	}

	private function getNewResoultion(){
		return $this->resampleCropSize.'x'.$this->resampleCropSize;
	}

	private function getExtension($str){
	    //Check for the dot in the string
	    $i = strrpos($str,".");
	    //if no dot is returned do nothing
		if (!$i) { return ""; }
	    //what the index based on length of string 
	    $l = strlen($str) - $i;
	    $ext = substr($str, $i+1, $l);
	    return $ext;
	}

	private function validExtension($ext){
	    if($ext =="jpg"  || $ext =="jpeg" || $ext =="gif") {
	        return true;
	    } else {
	        return false;
	    }
	}



}