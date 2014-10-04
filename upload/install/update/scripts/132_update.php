<?php

/**
 * This file is part of LEPTON Core, released under the GNU GPL
 * Please see LICENSE and COPYING files in your package for details, specially for terms and warranties.
 *
 * NOTICE:LEPTON CMS Package has several different licenses.
 * Please see the individual license in the header of each single file or info.php of modules and templates.
 *
 * @author          LEPTON Project
 * @copyright       2014 LEPTON Project
 * @link            http://www.LEPTON-cms.org
 * @license         http://www.gnu.org/licenses/gpl.html
 * @license_terms   please see LICENSE and COPYING files in your package
 */

// set error level
 ini_set('display_errors', 1);
 error_reporting(E_ALL|E_STRICT);

echo '<h3>Current process : updating to LEPTON 1.3.2</h3>';

/**
 *  database modifications
 */
// GUID is part of config.php and not needed in database 
$database->query( "DELETE FROM `".TABLE_PREFIX."settings` WHERE `name`= 'lepton_guid'" );

/**
 *  run upgrade.php of all modified modules
 *
 */
$upgrade_modules = array(
    "captcha_control",
    "initial_page",
    "jsadmin",
	"output_interface",
    "lib_jquery",	
    "edit_area",
	"wysiwyg_admin",
    "wrapper",
	"code2",
	"news",
	"show_menu2",
    "tiny_mce_jq"
);

foreach ($upgrade_modules as $module)
{
    $temp_path = WB_PATH . "/modules/" . $module . "/upgrade.php";

    if (file_exists($temp_path))
        require($temp_path);
}
echo "<h3>run upgrade.php of modified modules: successfull</h3>";

//  write config file for LEPTON_2 
echo '<h5>Current process : ceate new config file</h5>';
// copy config file

$file = WB_PATH.'/config.php';
$newfile = WB_PATH.'/config_sik.php';

if (!copy($file, $newfile)) {
    die ("failed to copy $file...\n");
}

// prepare config file
$config_content = "" .
"<?php\n".
"\n".
"if(defined('LEPTON_PATH')) { die('By security reasons it is not permitted to load \'config.php\' twice!! ".
"Forbidden call from \''.\$_SERVER['SCRIPT_NAME'].'\'!'); }\n\n".
"\n\n// new during update to LEPTON 1.3.2\n".
"define('DB_TYPE', 'mysql');\n".
"define('DB_HOST', '".DB_HOST."');\n".
"define('DB_PORT', '".DB_PORT."');\n".
"define('DB_USERNAME', '".DB_USERNAME."');\n".
"define('DB_PASSWORD', '".DB_PASSWORD."');\n".
"define('DB_NAME', '".DB_NAME."');\n".
"define('TABLE_PREFIX', '".TABLE_PREFIX."');\n".
"\n".
"define('LEPTON_PATH', dirname(__FILE__));\n".
"define('LEPTON_URL', '".WB_URL."');\n".
"define('ADMIN_PATH', LEPTON_PATH.'/admins');\n".
"define('ADMIN_URL', LEPTON_URL.'/admins');\n".
"\n".
"define('LEPTON_GUID', '".LEPTON_GUID."');\n".
"define('LEPTON_SERVICE_FOR', '');\n".
"define('LEPTON_SERVICE_ACTIVE', 0);\n".
"define('WB_URL', LEPTON_URL);\n".
"define('WB_PATH', LEPTON_PATH);\n".
"\n".
"if (!defined('LEPTON_INSTALL')) require_once(LEPTON_PATH.'/framework/initialize.php');\n".
"\n".
"?>";

// Check if the file exists and is writable first.
$config_filename = WB_PATH.'/config.php';
if(($handle = @fopen($config_filename, 'w')) === false) {
	set_error("Cannot open the configuration file ($config_filename)");
} else {
	if (fwrite($handle, $config_content, strlen($config_content) ) === false) {
		fclose($handle);
		set_error("Cannot write to the configuration file ($config_filename)");
	}
	// Close file
	fclose($handle);
}
echo "<h3>config file written successfully</h3>";

// at last: set db to current release-no
$database->query('UPDATE `' . TABLE_PREFIX . 'settings` SET `value` =\'1.3.2\' WHERE `name` =\'lepton_version\'');

// drop unique key: if update script stops here installation has been updated from WB. Update process was complete. Please log in backend
echo "<h3>if update script stops here installation has been updated from WB. Update process is complete anyway. Please login in backend</h3>";
$database->execute_query("ALTER TABLE `".TABLE_PREFIX."addons` DROP INDEX `type`;");
/**
 *  success message
 */
echo "<h3>update to LEPTON 1.3.2 successfull!</h3><br /><hr /><br />";

?>