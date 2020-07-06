<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Recycle{
    public function direction($url){
        header("Location:{$url}");
    }
	public function redir($url){
			header("Location:$url",true);
			exit();
	}
    
    public function uploadFile($file,$urlFile,$arExt,$maxSize,$NewImgName){
        $f = '';
        $erCode = '';
        $fObj           = $file;//$_FILES['txtimgname']['tmp_name'];
        $fLocationName  = $fObj['tmp_name'];
        $fName          = $fObj['name']; 
        $fSize          = $fObj['size'];
        $Ext = $this->getExt($fName); //jpg;
        $fNameUrl  =time().'_'.$NewImgName.'.'.$Ext;
        
        if(!in_array($Ext,$arExt)){
            $erCode = "100";
        }
        if($fSize>$maxSize){
            $erCode = "101";
        }
        if(strlen($erCode)==0){
            if(move_uploaded_file($fLocationName,$urlFile.$fNameUrl)){
                $f = $fNameUrl;
            }
        }else{
            $f = $erCode;
        }
        return $f;
    }
    public function uploadFileMuti($file,$urlFile,$arExt,$maxSize,$NewImgName){
        $f = array();
        $erCode = '';
        $fObj           = $file;//$_FILES['txtimgname']['tmp_name'];
        $total =count($file['name']);
        for($i=0 ;$i < $total; $i++){
            $fLocationName  = $fObj['tmp_name'][$i];
            $fName          = $fObj['name'][$i]; 
            $fSize          = $fObj['size'][$i];
            $Ext = $this->getExt($fName); //jpg;
            $fNameUrl  =time().'_'.$i.'_'.$NewImgName.'.'.$Ext;
            
            if(!in_array($Ext,$arExt)){
                $erCode = "100";
            }
            if($fSize>$maxSize){
                $erCode = "101";
            }
            if(strlen($erCode)==0){
                if(move_uploaded_file($fLocationName,$urlFile.$fNameUrl)){
                    $f[$i] =$fNameUrl;

                }
            }else{
                $f = $erCode;
            }  

        }
        
        return $f;
    }
    protected function getExt($str){
        $ext    = '';
        $rpos   = strrpos($str,'.');
        $ext    = substr($str,$rpos+1);
        return strtolower($ext);
    }
	public function getRandomString($len){
			$planText ="abcdefghijklmnopqxyz0123456789@#";
			$lenPlt = strlen($planText);
			$randomStr = '';
			$i=0;
			while($i<$len){
				$pos = rand(0,$lenPlt-1);
				$randomStr .=$planText[$pos];
				$i++;
			}
			return $randomStr; 
	}
}

