<?
if(!defined('IN_COYOTE'))
    die("Can not access this file directly!");

# Main database configuration file
# DO NOT edit unless you know what you are doing!

// In this block, we tell the database class what credentials we want to use for our connection
self::$mHost = 'localhost'; // usually "localhost"
self::$mPort = 3306; // usually "3306"
self::$mUser = 'root';
self::$mPassword = '';
self::$mDatabase = 'coyote';

// This is how we tell Coyote what table to use for the pages, using the connection created using the above credentials
// This call can ONLY BE DONE ONCE! Any additional attempts will be dismissed
CoyoteProcessor::set_pages_table('pages');

// Same as above, only for tags
CoyoteProcessor::set_tags_table('tags');

// Same as above, only for permissions
CoyoteProcessor::set_perms_table('perms');
?>