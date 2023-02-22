<?
if(!defined('IN_COYOTE'))
    die("Can not access this file directly!");

self::$db->Query('SELECT * FROM '.self::$db_perms_table);
if(self::$db->GetNumRows() > 0){
	while($row = self::$db->FetchArray()){
		if(!$row['val'])
			self::add_filter($row['name']);
	}
}

self::$db->Query('SELECT * FROM '.self::$db_tags_table);
if(self::$db->GetNumRows() > 0){
	$count = 1;
	while($row = self::$db->FetchArray()){
		$name = strtoupper($row['name']);
		self::$tags[$name]['file'] = $count;
		$aliases = explode(',', $row['aliases']);
		$cnt = count($aliases);
		for($i=0; $i<$cnt; ++$i){
			$aliases[$i] = strtoupper($aliases[$i]);
			self::$tags[$aliases[$i]]['parent'] = $name;
		}
		$defs = explode('|;|', $row['defaults']);
		$cnt = count($defs);
		for($i=0; $i<$cnt; ++$i){
			$defs[$i] = explode('=', $defs[$i]);
			$defs[$i][0] = strtoupper($defs[$i][0]);
			self::$tags[$name]['attr'][$defs[$i][0]] = $defs[$i][1];
		}
		$row['tag'] = '<? function Coyote_'.$name.'($tag_name, $attribs, $innerHTML, $parent, $breadcrumbs){?>'.$row['tag'].'<? } ?>';
		//self::$tag_info[$count] = $row['tag'];
		self::write_cache($name, $row['tag']);
		++$count;
	}
	unset($count, $cnt, $row, $name, $aliases, $i, $defs);
} else {
	require_once('tags_in_file.php');
}
?>