<?
## spacer ##
## alias: spring ##
## width = ##
## height = ##

if($tag_name == 'SPACER'){
	if(strpos($breadcrumbs, 'EXT') !== false)
		CoyoteProcessor::$ext->block('<img src="'.CoyoteProcessor::$server_path.'extjs/resources/images/default/s.gif" width="'.$attribs['WIDTH'].'" height="'.$attribs['HEIGHT'].'"/>');
	else
		echo '<img src="'.CoyoteProcessor::$server_path.'extjs/resources/images/default/s.gif" width="'.$attribs['WIDTH'].'" height="'.$attribs['HEIGHT'].'"/>';
} else {
	echo '\'->\'';
}
?>