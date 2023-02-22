<?
## ext ##
## alias: js ##
## alias: json ##
## noTags = false ##
## file = ##
## json = false ##

//CoyoteProcessor::$ext->clear();

if(empty($parent) && $json == 'false' && $tag_name != 'JSON'){
	//if(!isset(CoyoteProcessor::$ext->ext_is_defined)){
		CoyoteProcessor::do_include('includes/ext_header.html');
	//}
}

if($attribs['NOTAGS'] != 'true' && $tag_name != 'JS'){
	// We need these special place holders so the system can place the javascript and blocks in the proper places
	echo '{{* blocks *}}';
	echo '{{* javascript *}}';
	echo $innerHTML;
} else if($attribs['NOTAGS'] != 'true' && $parent != 'JSON') {
	if(!empty($attribs['FILE'])){
		$attribs['FILE'] = CoyoteProcessor::$server_path.$attribs['FILE'];
		echo '<script type="text/javascript" src="'.$attribs['FILE'].'"></script>';
		
		//echo '<script language="text/javascript">';
		//echo file_get_contents($attribs['FILE']);
		//echo '</script>';
	
		//CoyoteProcessor::$ext->script(file_get_contents($attribs['FILE']));
	} else {
		if($parent == 'EXT'){
			CoyoteProcessor::$ext->script(trim($innerHTML));
		} else {
			echo '<script language="text/javascript">';
			echo trim($innerHTML);
			echo '</script>';
		}
	}
} else if($tag_name == 'JS'){
	$innerHTML = str_replace("\n", '', $innerHTML);
	$innerHTML = str_replace("\r", '', $innerHTML);
	$innerHTML = str_replace("\t", '', $innerHTML);
	CoyoteProcessor::$ext->script($innerHTML);
} else {
	echo $innerHTML;
}
?>