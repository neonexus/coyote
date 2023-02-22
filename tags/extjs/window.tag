<?
## window ##
## animateTarget = ##
## closable = true ##
## closeAction = close ##
## constrain = false ##
## constrainHeader = true ##
## defaultButton = ##
## elements = ##
## maximizable = true ##
## minimizable = true ##
## minHeight = ##
## minWidth = ##
## modal = false ##
## plain = false ##
## resizable = true ##
## resizeHandles = ##

$output = '';

if(!empty(CoyoteProcessor::$ext->content_id) && empty($attribs['CONTENT']))
	$attribs['CONTENT'] = CoyoteProcessor::$ext->content_id;

//require(CoyoteProcessor::$inc_dir.'ext_nesting.php');
CoyoteProcessor::$ext->startNest($attribs);

if(!empty($attribs['ANIMATETARGET'])){ $output .= 'animateTaget:'.$attribs['ANIMATETARGET'].','; }
if($attribs['CLOSABLE'] != 'true'){ $output .= 'closable:false,'; }
if($attribs['CLOSEACTION'] != 'close'){ $output .= 'closeAction:\'hide\','; }
if($attribs['CONSTRAIN'] != 'false'){ $output .= 'constrain:true,'; }
if($attribs['CONSTRAINHEADER'] != 'false'){ $output .= 'constrainHeader:true,'; }
if(!empty($attribs['DEFAULTBUTTON'])){ $output .= 'defaultButton:'.$attribs['DEFAULTBUTTON'].','; }
if(!empty($attribs['ELEMENTS'])){ $output .= 'elements:\''.$attribs['ELEMENTS'].'\','; }
if($attribs['MAXIMIZABLE'] == 'true'){ $output .= 'maximizable:true,'; }
if($attribs['MINIMIZABLE'] == 'true'){ $output .= 'minimizable:true,'; }
if(!empty($attribs['MINHEIGHT'])){ $output .= 'minHeight:'.$attribs['MINHEIGHT'].','; }
if(!empty($attribs['MINWIDTH'])){ $output .= 'minWidth:'.$attribs['MINWIDTH'].','; }
if($attribs['MODAL'] != 'false'){ $output .= 'modal:true,'; }
if($attribs['PLAIN'] != 'false'){ $output .= 'plain:true,'; }
if($attribs['RESIZABLE'] != 'true'){ $output .= 'resizable:false,'; }
if(!empty($attribs['RESIZEHANDLES'])){ $output .= 'resizeHandles:\''.$attribs['RESIZEHANDLES'].'\','; }

$attribs['RENDERTO'] = '';

$output .= CoyoteProcessor::$ext->run_panel($attribs);

if(!empty($innerHTML)){
	$tmp = substr($innerHTML, 0, 1);
	if($tmp == '{'){
		$innerHTML = str_replace('}{', '},{', $innerHTML);
		$output .= 'items:['.$innerHTML.']';
	}
}

CoyoteProcessor::$ext->nest('Window', '', $output, $parent, $attribs);
?>