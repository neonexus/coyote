<?
## tab ##
## closable = false ##

if(!empty($attribs['AUTOLOAD'])){
	$str = substr($attribs['AUTOLOAD'], 0, 1);
	if($str != "{"){
		$attribs['AUTOLOAD'] = '\''.CoyoteProcessor::$server_path.$attribs['AUTOLOAD'].'\'';
	} else {
		$attribs['AUTOLOAD'] = preg_replace('/url:\s*\'(.*?)\'/i', 'url: \''.CoyoteProcessor::$server_path.'${1}\'', $attribs['AUTOLOAD']);
	}
}

if(!isset($attribs['BODYSTYLE'])){ $attribs['BODYSTYLE'] = 'overflow:auto;'; }

echo '{';

$tmp = substr($innerHTML, 0, 1);
if($tmp != '{'){
	if(empty($attribs['CONTENT'])){
		if(!empty(CoyoteProcessor::$ext->content_id)){
			$attribs['CONTENT'] = CoyoteProcessor::$ext->content_id;
			unset(CoyoteProcessor::$ext->content_id);
		} else {
			//$attribs['CONTENT'] = 'myEl'.substr(MD5(rand(0, 100000000)), rand(0, 15), rand(1,17));
			//$tmp = '<div id="'.$attribs['CONTENT'].'" class="x-hidden">'.$innerHTML.'</div>';
			//CoyoteProcessor::$ext->block($tmp);
			$attribs['STYLE'] .= 'background:#DFE8F6;';
			$attribs['HTML'] = trim($innerHTML);
			$attribs['FRAME'] = (empty($attribs['FRAME'])) ? 'true' : $attribs['FRAME'];
			$innerHTML = '';
		}
	} else {
		if(empty($attribs['HTML']) && !empty($innerHTML)){
			$attribs['HTML'] = trim($innerHTML);
			$attribs['STYLE'] .= 'background:#DFE8F6;';
			$attribs['FRAME'] = (empty($attribs['FRAME'])) ? 'true' : $attribs['FRAME'];
		}
	}
} else {
	if(!empty($innerHTML)){
		$innerHTML = str_replace('}{', '},{', $innerHTML);
		echo 'items:['.$innerHTML.'],';
	}
}
echo CoyoteProcessor::$ext->run_panel($attribs);
if($attribs['CLOSABLE'] != "false"){ echo 'closable:true'; }

echo '}';
?>