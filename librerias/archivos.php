<?php	
	function count_files($reggex=""){
		$elem=glob($reggex,GLOB_BRACE);
		if(!empty($elem))
			return count($elem);
		return 0;
	}
	
	function file_ext($resource){
		$fileinfo=getimagesize($resource);		
		$tmp=explode("/",$fileinfo['mime']);	
		return $tmp[1];
	}
	
	function upload_file(){
		
	}
	
	function image($resource){	
		return image_ext(exif_imagetype($resource));
	}
	
	function image_ext($S){
			switch ($S){ 
             case 1: 
                 return 'gif'; 
             case 2: 
                 return 'jpg'; 
             case 3: 
                 return 'png'; 
             case 4: 
                 return 'swf'; 
             case 5: 
                 return 'psd'; 
             case 6: 
                 return 'bmp'; 
             case 7: 
                 return 'tiff'; 
             case 8: 
                 return 'tiff'; 
             case 9: 
                 return 'jpc'; 
             case 10: 
                 return 'jp2'; 
             case 11: 
                 return 'jpx'; 
             case 12: 
                 return 'jb2'; 
             case 13: 
                 return 'swc'; 
             case 14: 
                 return 'iff'; 
             case 15: 
                 return 'wbmp'; 
             case 16: 
                 return 'xbm'; 
             default: 
                 return false; 
			} 
	}

?>
