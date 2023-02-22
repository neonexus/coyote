<?
## fieldset ##
## checkboxName = ##
## checkboxToggle = false ##
## itemCls = ##
## labelWidth = ##
## layout = form ##
## autoHeight = true ##

$output = '';

//require(CoyoteProcessor::$inc_dir.'ext_nesting.php');
CoyoteProcessor::$ext->startNest($attribs);

if(!empty($attribs['CHECKBOXNAME'])){ $output .= 'checkboxName:\''.$attribs['CHECKBOXNAME'].'\','; }
if($attribs['CHECKBOXTOGGLE'] != 'false'){ $output .= 'checkboxToggle:'.$attribs['CHECKBOXTOGGLE'].','; }
if(!empty($attribs['ITEMCLS'])){ $output .= 'itemCls:\''.$attribs['ITEMCLS'].'\','; }
if(!empty($attribs['LABELWIDTH'])){ $output .= 'labelWidth:'.$attribs['LABELWIDTH'].','; }
if($attribs['LAYOUT'] != 'form'){ $output .= 'layout:\''.$attribs['LAYOUT'].'\','; }

$output .= CoyoteProcessor::$ext->run_panel($attribs);

if(!empty($innerHTML)){
	$innerHTML = str_replace('}{', '},{', $innerHTML);
	$output .= 'items:['.$innerHTML.']';
}

CoyoteProcessor::$ext->nest('FieldSet', 'form.FieldSet', $output, $parent, $attribs);
?>