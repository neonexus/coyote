<?
## img ##
##src=##
$attribs['SRC'] = CoyoteProcessor::$server_path.$attribs['SRC'];
$tmp = '';
foreach($attribs as $key => $val){
	if($key != 'SRC')
		$tmp .= ' '.strtolower($key).'="'.$val.'"';
}
?>
<img src="<?=$attribs['SRC']?>"<?=$tmp?>/>