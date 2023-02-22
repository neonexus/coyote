<?
## grid ##
## alias: editorgrid ##
## stripeRows = true ##
## autoHeight = true ##

$output = '';

CoyoteProcessor::$ext->startNest($attribs);

if(!empty($attribs['STORAGE'])){ $attribs['STORE'] = $attribs['STORAGE']; }

if($tag_name == 'GRID'){
	$tmp = '';
	$output .= CoyoteProcessor::$ext->run_gridPanel($attribs);
} else {
	$tmp = 'Editor';
	$output .= CoyoteProcessor::$ext->run_editorGridPanel($attribs);
}

if(!empty($innerHTML)){
	$innerHTML = str_replace('}{', '},{', $innerHTML);
	if($attribs['NUMBERROWS'] == 'true')
		$output .= 'columns:[new Ext.grid.RowNumberer(),'.$innerHTML.']';
	else
		$output .= 'columns:['.$innerHTML.']';
}

CoyoteProcessor::$ext->nest($tmp.'Grid', 'grid.'.$tmp.'GridPanel', $output, $parent, $attribs);
?>