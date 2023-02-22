<?
## north ##
## alias: south ##
## alias: east ##
## alias: west ##
## alias: center ##

$output = '';

$attribs['REGION'] = strtolower($tag_name);

if(!empty($innerHTML)){
	$tmp = substr($innerHTML, 0, 1);
	if($tmp == '{'){
		$innerHTML = str_replace('}{', '},{', $innerHTML);
		$output .= 'items:['.$innerHTML.'],';
	} else {
		$attribs['HTML'] = trim($innerHTML);
	}
}

$output .= CoyoteProcessor::$ext->run_panel($attribs);

echo '{'.$output.'}';
?>