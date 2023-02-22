<?
##css##
## file = ##

if(empty($attribs['FILE'])){
	echo '<style type="text/css">';
	echo $innerHTML;
	echo '</style>';
} else {
	$attribs['FILE'] = CoyoteProcessor::$server_path.$attribs['FILE'];
	echo '<link rel="stylesheet" type="text/css" href="'.$attribs['FILE'].'" />';
}
?>