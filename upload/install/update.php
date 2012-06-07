<?php

/**
 * This file is part of LEPTON Core, released under the GNU GPL
 * Please see LICENSE and COPYING files in your package for details, specially for terms and warranties.
 *
 * NOTICE:LEPTON CMS Package has several different licenses.
 * Please see the individual license in the header of each single file or info.php of modules and templates.
 *
 * @author          LEPTON Project
 * @copyright       2010-2012, LEPTON Project
 * @link            http://www.LEPTON-cms.org
 * @license         http://www.gnu.org/licenses/gpl.html
 * @license_terms   please see LICENSE and COPYING files in your package
 * @reformatted 2011-10-04
 * @version     $Id: update.php 1815 2012-03-23 08:28:22Z erpe $
 */

// set error level
// ini_set('display_errors', 1);
// error_reporting(E_ALL|E_STRICT);

require_once('../config.php');
global $admin;
if (!is_object($admin))
{
    require_once(WB_PATH . '/framework/class.admin.php');
    $admin = new admin('Addons', 'modules', false, false);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>LEPTON Update Script</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link href="http://lepton-cms.org/_packinstall/update.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="top">
  <div id="top-logo"></div>
  <div id="top-text">LEPTON update script</div>
</div>
<div id="update-script">
<?php
/**
 *  update LEPTON to 1.1.1 , check release
 */
if (version_compare(LEPTON_VERSION, "1.1.0", "<"))
{
    die("<h4>ERROR:UNABLE TO UPDATE, LEPTON Version : " . LEPTON_VERSION . " </h4>");
}
echo '<h3>Current process : updating to LEPTON 1.1.1</h3>';

//  database modifications above 1.1.0
$all = $database->query(" SELECT * from `" . TABLE_PREFIX . "addons` limit 1");
if ($all)
{
    $temp = $all->fetchRow(MYSQL_ASSOC);
    if (array_key_exists("php_version", $temp))
    {
        $database->query('ALTER TABLE `' . TABLE_PREFIX . 'addons` DROP COLUMN `php_version`, DROP COLUMN `sql_version`');
    }
}

// set new version number
$database->query('UPDATE `' . TABLE_PREFIX . 'settings` SET `value` =\'1.1.1\' WHERE `name` =\'lepton_version\'');

/**
 *  run upgrade.php of all modified modules
 *
 */
$upgrade_modules = array(
    "form",
    "news",
    "initial_page",
    "tiny_mce_jq",
    "show_menu2",
    "wysiwyg_admin"
);

foreach ($upgrade_modules as $module)
{
    $temp_path = WB_PATH . "/modules/" . $module . "/upgrade.php";

    if (file_exists($temp_path))
        require($temp_path);
}


// delete obsolete module phplib
require_once(WB_PATH . '/framework/functions.php');
rm_full_dir(WB_PATH . '/modules/phplib');

echo '<h3>update to LEPTON 1.1.1 successfull!</h3><br /><hr /><br />';

/**
 *  update LEPTON to 1.1.2 , check release
 */
$lepton_version = $database->get_one("SELECT `value` from `" . TABLE_PREFIX . "settings` where `name`='lepton_version'");
if (version_compare($lepton_version, "1.1.1", "<"))
{
    die("<h4>'>ERROR:UNABLE TO UPDATE, LEPTON Version : " . LEPTON_VERSION . " </h4>");
}
echo '<h3>Current process : updating to LEPTON 1.1.2</h3>';

//  database modifications above 1.1.1
$all = $database->query(" SELECT * from `" . TABLE_PREFIX . "users` limit 1");
if ($all)
{
    $temp = $all->fetchRow(MYSQL_ASSOC);
    if (array_key_exists("remember_key", $temp))
    {
        $database->query('ALTER TABLE `' . TABLE_PREFIX . 'users` DROP COLUMN `remember_key`');
    }
}

$all = $database->query(" DELETE from `" . TABLE_PREFIX . "settings` WHERE name = 'smart_login'");

/**
 *  database modifications
 */
$database->query('UPDATE `' . TABLE_PREFIX . 'settings` SET `value` =\'1.1.2\' WHERE `name` =\'lepton_version\'');

/**
 *  run upgrade.php of all modified modules
 *
 */
$upgrade_modules = array(
    "news",
    "initial_page",
    "tiny_mce_jq",
    "addon_file_editor",
    "edit_area",
    "jsadmin",
    "menu_link",
    "output_interface",
    "pclzip",
    "show_menu2",
    "wrapper",
    "phpmailer",
    "wysiwyg_admin",
    "lib_jquery"
);

foreach ($upgrade_modules as $module)
{
    $temp_path = WB_PATH . "/modules/" . $module . "/upgrade.php";

    if (file_exists($temp_path))
        require($temp_path);
}

/**
 *  success message
 */
echo "<h3>update to LEPTON 1.1.2 successfull!</h3><br /><hr /><br />";


/**
 *  update LEPTON to 1.1.3 , check release
 */
$lepton_version = $database->get_one("SELECT `value` from `" . TABLE_PREFIX . "settings` where `name`='lepton_version'");
if (version_compare($lepton_version, "1.1.2", "<"))
{
    die("<h4>'>ERROR:UNABLE TO UPDATE, LEPTON Version : " . LEPTON_VERSION . " </h4>");
}
echo '<h3>Current process : updating to LEPTON 1.1.3</h3>';

/**
 *  run upgrade.php of all modified modules
 *
 */
$upgrade_modules = array(
    "tiny_mce_jq",
    "news",
    "code2",
    "lib_jquery"
);

foreach ($upgrade_modules as $module)
{
    $temp_path = WB_PATH . "/modules/" . $module . "/upgrade.php";

    if (file_exists($temp_path))
        require($temp_path);
}

/**
 *  database modification
 */
$database->query('UPDATE `' . TABLE_PREFIX . 'settings` SET `value` =\'1.1.3\' WHERE `name` =\'lepton_version\'');

/**
 *  success message
 */
echo "<h3>update to LEPTON 1.1.3 successfull!</h3><br /><hr /><br />";


/**
 *  update LEPTON to 1.1.4 , check release
 */
$lepton_version = $database->get_one("SELECT `value` from `" . TABLE_PREFIX . "settings` where `name`='lepton_version'");
if (version_compare($lepton_version, "1.1.3", "<"))
{
    die("<h4>'>ERROR:UNABLE TO UPDATE, LEPTON Version : " . LEPTON_VERSION . " </h4>");
}
echo '<h3>Current process : updating to LEPTON 1.1.4</h3>';

//delete leptoken debug file
$temp_path = WB_PATH."/framework/__debug_token.txt";
if (file_exists($temp_path)) {
	$result = unlink ($temp_path);
	if (false === $result) {
		echo "Cannot delete file ".$temp_path.". Please check file permissions and ownership or delete file manually.";
	}
}

/**
 *	try to remove obsolete column 'license_text'
 *  first check if the COLUMN `license_text` exists in the `addons` TABLE
 */
$checkDbTable = $database->query("SHOW COLUMNS FROM `".TABLE_PREFIX."addons` LIKE 'license_text'");
$column_exists = $checkDbTable->numRows() > 0 ? TRUE : FALSE;

if (true === $column_exists ) {
 $database->query('ALTER TABLE `' . TABLE_PREFIX . 'addons` DROP COLUMN `license_text`');
}


/**
 *  run upgrade.php of all modified modules
 *
 */
$upgrade_modules = array(
    "tiny_mce_jq",
    "news",
    "form",
    "wrapper",
    "wysiwyg",
    "code2",
    "droplets",
    "captcha_control",
    "lib_jquery"
);

foreach ($upgrade_modules as $module)
{
    $temp_path = WB_PATH . "/modules/" . $module . "/upgrade.php";

    if (file_exists($temp_path))
        require($temp_path);
}

/**
 *  database modification
 */
$database->query('UPDATE `' . TABLE_PREFIX . 'settings` SET `value` =\'1.1.4\' WHERE `name` =\'lepton_version\'');

/**
 *  success message
 */
echo "<h3>update to LEPTON 1.1.4 successfull!</h3><br /><hr /><br />";


/**
 *  update LEPTON to 1.1.5 , check release
 */
$lepton_version = $database->get_one("SELECT `value` from `" . TABLE_PREFIX . "settings` where `name`='lepton_version'");
if (version_compare($lepton_version, "1.1.4", "<"))
{
    die("<h4>'>ERROR:UNABLE TO UPDATE, LEPTON Version : " . LEPTON_VERSION . " </h4>");
}
echo '<h3>Current process : updating to LEPTON 1.2.0</h3>';

/**
 *	try to remove obsolete columns from pages_table
 *  first check if the columns exist
 */
$checkDbTable = $database->query("SHOW COLUMNS FROM `".TABLE_PREFIX."pages` LIKE 'page_icon'");
$column_exists = $checkDbTable->numRows() > 0 ? TRUE : FALSE;

if (true === $column_exists ) {
 $database->query('ALTER TABLE `' . TABLE_PREFIX . 'pages` DROP COLUMN `page_icon`');
}

$checkDbTable = $database->query("SHOW COLUMNS FROM `".TABLE_PREFIX."pages` LIKE 'menu_icon_0'");
$column_exists = $checkDbTable->numRows() > 0 ? TRUE : FALSE;

if (true === $column_exists ) {
 $database->query('ALTER TABLE `' . TABLE_PREFIX . 'pages` DROP COLUMN `menu_icon_0`');
}

$checkDbTable = $database->query("SHOW COLUMNS FROM `".TABLE_PREFIX."pages` LIKE 'menu_icon_1'");
$column_exists = $checkDbTable->numRows() > 0 ? TRUE : FALSE;

if (true === $column_exists ) {
 $database->query('ALTER TABLE `' . TABLE_PREFIX . 'pages` DROP COLUMN `menu_icon_1`');
}

/**
 *  run upgrade.php of all modified modules
 *
 */
$upgrade_modules = array(
    "tiny_mce_jq",
    "addon_file_editor",
    "news",
    "wrapper",
    "droplets",
    "phpmailer",
    "lib_jquery"
);

foreach ($upgrade_modules as $module)
{
    $temp_path = WB_PATH . "/modules/" . $module . "/upgrade.php";

    if (file_exists($temp_path))
        require($temp_path);
}

/**
 *  reload all addons
 *  Modules first
 */
// first remove addons entrys for modules that don't exist
$sql = 'SELECT `directory` FROM `' . TABLE_PREFIX . 'addons` WHERE `type` = \'module\' ';
if ($res_addons = $database->query($sql))
{
    while ($value = $res_addons->fetchRow(MYSQL_ASSOC))
    {
        if (!file_exists(WB_PATH . '/modules/' . $value['directory']))
        {
            $sql = "DELETE FROM `" . TABLE_PREFIX . "addons` WHERE `directory` = '" . $value['directory'] . "'";
            $database->query($sql);
        }
    }
}

// now check modules folder with entries in addons
$modules = scan_current_dir(WB_PATH . '/modules');
if (count($modules['path']) > 0)
{
    foreach ($modules['path'] as $value)
    {
        $code_version = get_modul_version($value);
        $db_version   = get_modul_version($value, false);
        if (($db_version != null) && ($code_version != null))
        {
            require(WB_PATH . '/modules/' . $value . "/info.php");
            load_module(WB_PATH . '/modules/' . $value);
        }
    }
}

/**
 *  Reload Templates
 *
 */
if ($handle = opendir(WB_PATH . '/templates'))
{
    // delete not existing templates from database
    $sql = 'DELETE FROM  `' . TABLE_PREFIX . 'addons`  WHERE `type` = \'template\'';
    $database->query($sql);
    // loop over all templates
    while (false !== ($file = readdir($handle)))
    {
        if ($file != '' && substr($file, 0, 1) != '.' && $file != 'index.php')
        {
            require(WB_PATH . '/templates/' . $file . "/info.php");
            load_template(WB_PATH . '/templates/' . $file);
        }
    }
    closedir($handle);
}

/**
 *  Reload Languages
 *
 */
if ($handle = opendir(WB_PATH . '/languages/'))
{
    // delete  not existing languages from database
    $sql = 'DELETE FROM  `' . TABLE_PREFIX . 'addons`  WHERE `type` = \'language\'';
    $database->query($sql);
    // loop over all languages
    while (false !== ($file = readdir($handle)))
    {
        if ($file != '' && substr($file, 0, 1) != '.' && $file != 'index.php')
        {
            load_language(WB_PATH . '/languages/' . $file);
        }
    }
    closedir($handle);
}

  // drop obsolete sik_news_tables for backword compatibility, new xsik_news_tables are created with upgrade.php of news module
  $database->query("DROP TABLE IF EXISTS `".TABLE_PREFIX."sik_news_posts`");
  $database->query("DROP TABLE IF EXISTS `".TABLE_PREFIX."sik_news_groups`");
  $database->query("DROP TABLE IF EXISTS `".TABLE_PREFIX."sik_news_comments`");
  $database->query("DROP TABLE IF EXISTS `".TABLE_PREFIX."sik_news_settings`");
/**
 *  database modification
 */
$database->query('UPDATE `' . TABLE_PREFIX . 'settings` SET `value` =\'1.2.0\' WHERE `name` =\'lepton_version\'');

$database->query('INSERT INTO `' . TABLE_PREFIX . 'settings` SET (name,value) VALUES (\'backend_title\',\'LEPTON CMS\')';

/**
 *  success message
 */
echo "<h3>update to LEPTON 1.2.0 successfull!</h3>";
echo "<br /><h3><a href=\"../admins/login/index.php\">please login and check update</></h3>";
?>
</div>
<div id="update-footer">
      <!-- Please note: the below reference to the GNU GPL should not be removed, as it provides a link for users to read about warranty, etc. -->
      <a href="http://wwww.lepton-cms.org" title="Lepton CMS">Lepton Core</a> is released under the
      <a href="http://www.gnu.org/licenses/gpl.html" title="Lepton Core is GPL">GNU General Public License</a>.
      <!-- Please note: the above reference to the GNU GPL should not be removed, as it provides a link for users to read about warranty, etc. -->
	    <br /><a href="http://wwww.lepton-cms.org" title="Lepton CMS">Lepton CMS Package</a> is released under several different licenses.
</div>
</body>
</html>