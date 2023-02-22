<?
if(!defined('IN_COYOTE'))
    die("Can not access this file directly!");

// Main configuration file
// DO NOT edit unless you know what you are doing!

// First we have to define where our folders are
// This is in relation to the location of "coyote.php" in the "system" folder
// Unless you use absolute paths

// NOTE: Take into consideration, the PHP INCLUDE_PATH is used

// This is the full path to our server (actuall location of Coyote Installation)
self::$server_path = 'http://localhost/coyote/';

// This is where the Coyote folder is located (should be full path)
self::$system_dir = '/opt/lampp/htdocs/coyote/';

// This is where our tag definition files are found (if not using a database for storage)
self::$tag_dir = self::$system_dir.'tags/';

// This is where our cache files are created and used (should never be used outside of Coyote!)
self::$cache_dir = self::$system_dir.'cache/';

// This is where our page files are stored (if not using a database for storage)
self::$main_dir = self::$system_dir.'pages/';

// This is where our includes files are stored
self::$inc_dir = self::$system_dir.'includes/';

// Do we want the system to clean the cache folder? (This is per class instance)
// This feature is only intended for sites in development, and should not be used for production sites
self::$clean_cache_folder = true; // Either "true" or "false"

// Do we want ExtJS to be auto-loaded?
self::$load_ext = true;

// Now, we have to tell Coyote if we are using a database or not

// Here, we tell the class if our tags are stored in a database
self::$db_for_tags = false; // Either "true" or "false"

// Here, we tell the class if our pages are stored in a database
self::$db_for_pages = false; // Either "true" or "false"
?>