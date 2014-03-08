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
echo "<h3>run upgrade.php of modified modules: successfull</h3>";


// at last: set db to current release-no
$database->query('UPDATE `' . TABLE_PREFIX . 'settings` SET `value` =\'1.1.4\' WHERE `name` =\'lepton_version\'');

/**
 *  success message
 */
echo "<h3>update to LEPTON 1.1.4 successfull!</h3><br /><hr /><br />";

?>
