<?
## checkbox ##
## alias: radio ##
## var = ##
## boxLabel = ##
## checked = false ##
## checkedCls = ##
## focusCls = ##
## inputValue = ##
## mouseDownCls = ##
## overCls = ##

if(!empty($attribs['LABEL'])){
	$attribs['BOXLABEL'] = $attribs['LABEL'];
	unset($attribs['LABEL']);
}
if(!empty($attribs['VALUE'])){
	$attribs['INPUTVALUE'] = $attribs['VALUE'];
	unset($attribs['VALUE']);
}

$output = '';	

//require(CoyoteProcessor::$inc_dir.'ext_nesting.php');
CoyoteProcessor::$ext->startNest($attribs);

if(!empty($attribs['BOXLABEL'])){ $output .= 'boxLabel:\''.$attribs['BOXLABEL'].'\','; }
if($attribs['CHECKED'] != 'false'){ $output .= 'checked:true,'; }
if(!empty($attribs['CHECKEDCLS'])){ $output .= 'checkedCls:\''.$attribs['CHECKEDCLS'].'\','; }
if(!empty($attribs['FOCUSCLS'])){ $output .= 'focusCls:\''.$attribs['FOCUSCLS'].'\','; }
if(!empty($attribs['INPUTVALUE'])){ $output .= 'inputValue:\''.$attribs['INPUTVALUE'].'\','; }
if(!empty($attribs['MOUSEDOWNCLS'])){ $output .= 'mouseDownCls:\''.$attribs['MOUSEDOWNCLS'].'\','; }
if(!empty($attribs['OVERCLS'])){ $output .= 'overCls:\''.$attribs['OVERCLS'].'\','; }

$output .= CoyoteProcessor::$ext->run_field($attribs);

if($tag_name == 'CHECKBOX')
	CoyoteProcessor::$ext->nest('Checkbox', 'form.Checkbox', $output, $parent, $attribs);
else
	CoyoteProcessor::$ext->nest('Radio', 'form.Radio', $output, $parent, $attribs);
?>