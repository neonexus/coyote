<?
## textbox ##
## alias: textarea ##
## alias: numberfield ##
## alias: password ##
## alias: filefield ##

// This is for the TextArea
## preventScrollbars = false ##

// These are for the NumberField
## allowDecimals = true ##
## allowNegative = true ##
## baseChars = ##
## decimalPrecision = ##
## deciamlSeparator = ##
## maxText = ##
## maxValue = ##
## minText = ##
## minValue = ##
## nanText = ##

$output = '';

//require(CoyoteProcessor::$inc_dir.'ext_nesting.php');
CoyoteProcessor::$ext->startNest($attribs);

if($attribs['PREVENTSCROLLBARS'] != 'false' && $tag_name == 'TEXTAREA'){ $output .= 'preventScrollbars:true,'; }

if($tag_name == 'NUMBERFIELD'){
	if($attribs['ALLOWDECIMALS'] != 'true'){ $output .= 'allowDecimals:false,'; }
	if($attribs['ALLOWNEGATIVE'] != 'true'){ $output .= 'allowNegative:false,'; }
	if(!empty($attribs['BASECHARS'])){ $output .= 'baseChars:\''.$attribs['BASECHARS'].'\','; }
	if(!empty($attribs['DECIMALPRECISION'])){ $output .= 'decimalPrecision:'.$attribs['DECIMALPRECISION'].','; }
	if(!empty($attribs['DECIMALSEPARATOR'])){ $output .= 'decimalSeparator:\''.$attribs['DECIMALSEPARATOR'].'\','; }
	if(!empty($attribs['MAXTEXT'])){ $output .= 'maxText:\''.$attribs['MAXTEXT'].'\','; }
	if(!empty($attribs['MAXVALUE'])){ $output .= 'maxValue:'.$attribs['MAXVALUE'].','; }
	if(!empty($attribs['MINTEXT'])){ $output .= 'minText:\''.$attribs['MINTEXT'].'\','; }
	if(!empty($attribs['MINVALUE'])){ $output .= 'minValue:'.$attribs['MINVALUE'].','; }
	if(!empty($attribs['NANTEXT'])){ $output .= 'nanText:\''.$attribs['NANTEXT'].'\','; }
} else if($tag_name == 'FILEFIELD'){
	$attribs['INPUTTYPE'] = 'file';
	$attribs['EMPTYTEXT'] = '';
} else if($tag_name == 'PASSWORD'){
	$attribs['INPUTTYPE'] = 'password';
}

$output .= CoyoteProcessor::$ext->run_textField($attribs);

if($tag_name == 'TEXTBOX' || $tag_name == 'PASSWORD' || $tag_name == 'FILEFIELD')
	CoyoteProcessor::$ext->nest('TextField', 'form.TextField', $output, $parent, $attribs);
else if($tag_name == 'TEXTAREA')
	CoyoteProcessor::$ext->nest('TextArea', 'form.TextArea', $output, $parent, $attribs);
else
	CoyoteProcessor::$ext->nest('NumberField', 'form.NumberField', $output, $parent, $attribs);
?>