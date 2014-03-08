<?php

/**
 * This file is part of LEPTON Core, released under the GNU GPL
 * Please see LICENSE and COPYING files in your package for details, specially for terms and warranties.
 *
 * NOTICE:LEPTON CMS Package has several different licenses.
 * Please see the individual license in the header of each single file or info.php of modules and templates.
 *
 * @author          LEPTON Project
 * @copyright       2010-2014 LEPTON Project
 * @link            http://www.LEPTON-cms.org
 * @license         http://www.gnu.org/licenses/gpl.html
 * @license_terms   please see LICENSE and COPYING files in your package
 */

// set error level
// ini_set('display_errors', 1);
// error_reporting(E_ALL|E_STRICT);

echo '<h3>Current process : updating to LEPTON 1.2.0</h3>';

/**
 *  database modification
 */

//	try to remove obsolete columns from pages_table, first check if the columns exist
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
  // drop obsolete sik_news_tables for backword compatibility, new xsik_news_tables are created with upgrade.php of news module
  $database->query("DROP TABLE IF EXISTS `".TABLE_PREFIX."sik_news_posts`");
  $database->query("DROP TABLE IF EXISTS `".TABLE_PREFIX."sik_news_groups`");
  $database->query("DROP TABLE IF EXISTS `".TABLE_PREFIX."sik_news_comments`");
  $database->query("DROP TABLE IF EXISTS `".TABLE_PREFIX."sik_news_settings`");

// insert backend_title in settings table
$checkField = $database->query("SELECT * FROM ".TABLE_PREFIX."settings WHERE name = 'backend_title'");
$field_exists = $checkField->numRows() > 0 ? TRUE : FALSE;

if (true === $field_exists ) {
 echo "backend_title already exists, no new entry";
}
else {
$database->query("INSERT INTO ".TABLE_PREFIX."settings (name,value) VALUES ('backend_title', 'LEPTON-CMS')");
}

echo "<h3>database modifications: successfull</h3>";

/**
 *  run upgrade.php of all modified modules
 *
 */
$upgrade_modules = array(
    "addon_file_editor",
    "captcha_control",
    "code2",
    "droplets",
    "form",
    "lib_jquery", 
    "menu_link",
    "news", 
    "phpmailer", 
    "show_menu2",              
    "tiny_mce_jq",
    "wrapper",
    "wysiwyg",    
    "wysiwyg_admin"    
);

foreach ($upgrade_modules as $module)
{
    $temp_path = WB_PATH . "/modules/" . $module . "/upgrade.php";

    if (file_exists($temp_path))
        require($temp_path);
}
echo "<h3>run upgrade.php of modified modules: successfull</h3>";


// at last: set db to current release-no
$database->query('UPDATE `' . TABLE_PREFIX . 'settings` SET `value` =\'1.2.0\' WHERE `name` =\'lepton_version\'');

/**
 *  success message
 */
echo "<h3>update to LEPTON 1.2.0 successfull!</h3><br /><hr /><br />";

?>
