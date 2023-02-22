<?
## itemset ##
## alias: datatable ##

$output = '';

if(!empty($attribs['NS'])){
	$output .= 'Ext.ns(\''.$attribs['NS'].'\');';
	$output .= $attribs['NS'].'=[';
	if($tag_name != 'DATATABLE'){
		$innerHTML = str_replace('}{', '},{', $innerHTML);
		$innerHTML = str_replace('}\'-\'', '},\'-\',', $innerHTML);
		$innerHTML = str_replace('}\'->\'', '},\'->\',', $innerHTML);
		$innerHTML = str_replace('\'-\'{', '\'-\',{', $innerHTML);
		$innerHTML = str_replace('\'->\'{', '\'->\',{', $innerHTML);
	} else {
		$innerHTML = str_replace('][', '],[', $innerHTML);
	}
	$output .= $innerHTML;
	$output .= '];';
	CoyoteProcessor::$ext->script($output);
} else if(!empty($attribs['VAR'])){
	$output .= 'var '.$attribs['VAR'].'=[';
	if($tag_name != 'DATATABLE'){
		$innerHTML = str_replace('}{', '},{', $innerHTML);
		$innerHTML = str_replace('}\'-\'', '},\'-\',', $innerHTML);
		$innerHTML = str_replace('}\'->\'', '},\'->\',', $innerHTML);
		$innerHTML = str_replace('\'-\'{', '\'-\',{', $innerHTML);
		$innerHTML = str_replace('\'->\'{', '\'->\',{', $innerHTML);
	} else {
		$innerHTML = str_replace('][', '],[', $innerHTML);
	}
	$output .= $innerHTML;
	$output .= '];';
	CoyoteProcessor::$ext->script($output);
}
?>