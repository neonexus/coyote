<?
## panel ##
## alias: borderlayout ##
## alias: viewport ##

$output = '';

if(!empty(CoyoteProcessor::$ext->content_id))
	$attribs['CONTENT'] = CoyoteProcessor::$ext->content_id;

//require(CoyoteProcessor::$inc_dir.'ext_nesting.php');
CoyoteProcessor::$ext->startNest($attribs);

if($tag_name == 'BORDERLAYOUT'){
	$attribs['LAYOUT'] = 'border';
	if($parent == 'EXT' || empty($parent))
		$nest_name = 'Viewport';
	else
		$nest_name = 'Panel';
} else if($tag_name == 'VIEWPORT'){
	$nest_name = 'Viewport';
} else {
	$nest_name = 'Panel';
}

if(!empty(CoyoteProcessor::$ext->tbar)){
	$output .= 'tbar:[';
	$output .= CoyoteProcessor::$ext->tbar;
	$output .= '],';
}

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

CoyoteProcessor::$ext->nest($nest_name, '', $output, $parent, $attribs);
unset($nest_name);
?>