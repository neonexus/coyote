<?
## include ##
## type = tags ##
if(!empty($attribs['FILE'])){
	switch(strtolower($attribs['TYPE'])){
		case "tags":
		case "xml":
			$file = CoyoteProcessor::process($attribs['FILE']);
			$file = CoyoteProcessor::run($file);
			echo $file;
			unset($file);
		break;
		
		case "html":
		case "php":
		case "txt":
		default:
			CoyoteProcessor::do_include($attribs['FILE']);
		break;
	}
}
?>