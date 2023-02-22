<?
## date ##
## altFormats = ##
## disabledDates = ##
## disabledDatesText = ##
## disabledDays = ##
## disabledDaysText = ##
## format = ##
## maxText = ##
## maxValue = ##
## minText = ##
## showToday = true ##

$output = '';

//require(CoyoteProcessor::$inc_dir.'ext_nesting.php');
CoyoteProcessor::$ext->startNest($attribs);

if(!empty($attribs['ALTFORMATS'])){ $output .= 'altFormats:\''.$attribs['ALTFORMATS'].'\','; }
if(!empty($attribs['DISABLEDDATES'])){ $output .= 'disabledDates:'.$attribs['DISABLEDDATES'].','; }
if(!empty($attribs['DISABLEDDATESTEXT'])){ $output .= 'disabledDatesText:\''.$attribs['DISABLEDDATESTEXT'].'\','; }
if(!empty($attribs['DISABLEDDAYS'])){ $output .= 'disabledDays:'.$attribs['DISABLEDDAYS'].','; }
if(!empty($attribs['DISABLEDDAYSTEXT'])){ $output .= 'disabledDaysText:\''.$attribs['DISABLEDDAYSTEXT'].'\','; }
if(!empty($attribs['FORMAT'])){ $output .= 'format:\''.$attribs['FORMAT'].'\','; }
if(!empty($attribs['MAXTEXT'])){ $output .= 'maxText:\''.$attribs['MAXTEXT'].'\','; }
if(!empty($attribs['MAXVALUE'])){ $output .= 'maxValue:\''.$attribs['MAXVALUE'].'\','; }
if(!empty($attribs['MINTEXT'])){ $output .= 'minText:\''.$attribs['MINTEXT'].'\','; }
if(!empty($attribs['MINVALUE'])){ $output .= 'minValue:\''.$attribs['MINVALUE'].'\','; }
if($attribs['SHOWTODAY'] != 'true'){ $output .= 'showToday:false,'; }

$output .= CoyoteProcessor::$ext->run_triggerField($attribs);

CoyoteProcessor::$ext->nest('DateField', 'form.DateField', $output, $parent, $attribs);
?>