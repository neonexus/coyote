<?
## storage ##

$output = '';

if(!empty($attribs['NS'])){
	$output .= 'Ext.ns(\''.$attribs['NS'].'\');';
	$output .= $attribs['NS'].'=new Ext.data.SimpleStore({';
	if(isset($attribs['DATATABLE'])){ $attribs['DATA'] = $attribs['DATATABLE']; }
	if(!empty($attribs['DATA'])){ $output .= 'data:'.$attribs['DATA'].','; }
	
	if(!empty($innerHTML)){
		$innerHTML = str_replace('}{', '},{', $innerHTML);
		$output .= 'fields:['.$innerHTML.']';
	}
	$output .= '});';
	CoyoteProcessor::$ext->script($output);
} else if(!empty($attribs['VAR'])){
	$output .= 'var '.$attribs['VAR'].'=new Ext.data.SimpleStore({';
	if(isset($attribs['DATATABLE'])){ $attribs['DATA'] = $attribs['DATATABLE']; }
	if(!empty($attribs['DATA'])){ $output .= 'data:'.$attribs['DATA'].','; }
	
	if(!empty($innerHTML)){
		$innerHTML = str_replace('}{', '},{', $innerHTML);
		$output .= 'fields:['.$innerHTML.']';
	}
	$output .= '});';
	CoyoteProcessor::$ext->script($output);
}
?>