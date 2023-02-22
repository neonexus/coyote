<?
if(!defined('IN_COYOTE'))
    die("Can not access this file directly!");

self::$tag_files = array();
//self::$tag_info = array();

$this->tag_loop(self::$tag_dir);
self::$num = 1;

// Let's make sure we sort our files
sort(self::$tag_files);

// Let's be sure to move everything down the list by 1
array_unshift(self::$tag_files, 'dummy data');

if(self::is_cached('our main cache page file')){
	$page = unserialize(self::read_cache('our main cache page file'));
	$cnt = count($page);
	for($i=0; $i<$cnt; ++$i){
		if(md5_file($page[$i]['file']) != $page[$i]['file_md5']){
			self::delete_cache('internal_'.$page[$i]['name']);
		} else if(self::is_cached('internal_'.$page[$i]['name'])){
			self::$tags[$page[$i]['name']] = $page[$i]['tag'];
			$cnt2 = count($page[$i]['aliases']);
			for($y=0; $y<$cnt2; ++$y){
				self::$tags[$page[$i]['aliases'][$y]]['parent'] = $page[$i]['name'];
			}
			$ignore[] = $page[$i]['file'];
			$master[] = $page[$i];
		}
	}
}

// Define patterns
$p[0] = "/^<\\?(?:PHP)?[\\n\\r]*##\\s*([a-z0-9_]+)\\s*##[\\n\\r]+/i";
$p[1] = "/##\\s*([a-z0-9_-]+)\\s*=\\s*(.+?)\\s*##[\\n\\r]+/i";
$p[2] = "/##\\s*alias:\\s*([a-z0-9]+)\\s*##[\\n\\r]+/i";

// Now, let's read through our tag files and get the data we need
$cnt = count(self::$tag_files);
$cnt2 = count($ignore);
$i = 1;
do{
	$doIt = true;
	if(!empty($ignore)){
		for($y=0; $y<$cnt2; ++$y){
			if($ignore[$y] == self::$tag_files[$i]){
				$doIt = false;
				$y = $cnt2;
			}
		}
	}
	if($doIt){
		if($file = file_get_contents(self::$tag_files[$i])){
			// Get the tag name
			$tmp = preg_match($p[0], $file, $matches);
			if($tmp > 0){
				$name = strtoupper($matches[1]);
				self::$tags[$name]['file'] = $i;
				// Get all of our default attributes
				$tmp2 = preg_match_all($p[1], $file, $matches);
				if($tmp2 > 0){
					$cnt2 = count($matches[1]);
					//for($j = 0; $j < $cnt2; ++$j){
					$j = 0;
					do{
						// be consitant
						$attr_name = strtoupper($matches[1][$j]);
						self::$tags[$name]['attr'][$attr_name] = $matches[2][$j];
						++$j;
					} while($j < $cnt2);
				}
				// Get all of our alias names
				$tmp2 = preg_match_all($p[2], $file, $matches);
				if($tmp2 > 0){
					$cnt2 = count($matches[1]);
					//for($j = 0; $j < $cnt2; ++$j){
					$j = 0;
					do{
						$alias = strtoupper($matches[1][$j]);
						$aliases[] = $alias;
						self::$tags[$alias]['parent'] = $name;
						++$j;
					} while($j < $cnt2);
				}
				//if(!self::is_cached($name)){
					$tmp3 = array('', '', '');
					$p[0] = "/##\\s*([a-z0-9_]+)\\s*##[\\n\\r]+/i";
					$tmp3[0] = 'function Coyote_'.$name.'($tag_name, $attribs, $innerHTML, $parent, $breadcrumbs){'."\n";
					$file = preg_replace($p, $tmp3, $file);
					$file .= "<?\n";
					$file .= 'unset($tag_name, $attribs, $innerHTML, $parent, $breadcrumbs);';
					$file .= "\n}\n?>";
					//self::$tag_info[$i] = $file;
					self::write_cache('internal_'.$name, $file);
				//}
				$cnt3 = count($master);
				$master[$cnt3]['tag'] = self::$tags[$name];
				$master[$cnt3]['name'] = $name;
				if(!empty($aliases))
					$master[$cnt3]['aliases'] = $aliases;
				$master[$cnt3]['file'] = self::$tag_files[$i];
				$master[$cnt3]['file_md5'] = md5_file(self::$tag_files[$i]);
				$aliases = '';
			} else {
				die('<strong>ERROR:</strong> Poorly formated tag definition file ('.self::$tag_files[$i].')!');
			}
		} else {
			die('<strong>ERROR:</strong> Could not obtain file data ('.self::$tag_files[$i].')!');
		}
	}
	++$i;
} while($i < $cnt);
self::write_cache('our main cache page file', serialize($master));
unset($file, $name, $tmp, $tmp2, $ignore, $page, $alias, $aliases, $master, $i, $j, $y, $p1, $p2, $p3, $cnt, $cnt2, $cnt3);
?>