<?
clean_cache();
$json['resp'] = 'Cache folder has been emptied.';
function clean_cache($dir = '../cache/'){
	if(is_string($dir)){
		if($handle = opendir($dir)){
			while(false !== ($file = readdir($handle))){
				if($file != '.' && $file != '..' && is_file($dir.$file)){
					unlink($dir.$file);
				} else if($file != '.' && $file != '..' && is_dir($dir.$file.'/') && $file != 'funcs') {
					clean_cache($dir.$file.'/');
				}
			}
			closedir($handle);
		} else {
			die('<strong>ERROR:</strong> Could not open the cache folder for cleaning ('.$dir.').');
		}
	} else {
		die('<strong>ERROR:</strong> Input paramater must be a <strong>string</strong> in <strong>CoyoteProcessor::clean_cache()</strong>');
	}
} # End of clean_cache()
?>