<?php

/**
 * This file is part of LEPTON Core, released under the GNU GPL
 * Please see LICENSE and COPYING files in your package for details, specially for terms and warranties.
 *
 * NOTICE:LEPTON CMS Package has several different licenses.
 * Please see the individual license in the header of each single file or info.php of modules and templates.
 *
 * @author          LEPTON Project
 * @copyright       2010-2012 LEPTON Project
 * @link            http://www.LEPTON-cms.org
 * @license         http://www.gnu.org/licenses/gpl.html
 * @license_terms   please see LICENSE and COPYING files in your package
 */

// set error level
// ini_set('display_errors', 1);
// error_reporting(E_ALL|E_STRICT);

echo '<h3>Current process : updating to LEPTON 1.2.2</h3>';

/**
 *  database modification
 */

/**
 *  run upgrade.php of all modified modules
 *
 */
$upgrade_modules = array(
    "lib_jquery",               
    "tiny_mce_jq",      
    "news"
);

foreach ($upgrade_modules as $module)
{
    $temp_path = WB_PATH . "/modules/" . $module . "/upgrade.php";

    if (file_exists($temp_path))
        require($temp_path);
}
echo "<h3>run upgrade.php of modified modules: successfull</h3>";


// at last: set db to current release-no
$database->query('UPDATE `' . TABLE_PREFIX . 'settings` SET `value` =\'1.2.2\' WHERE `name` =\'lepton_version\'');

/**
 *  success message
 */
echo "<h3>update to LEPTON 1.2.2 successfull!</h3><br /><hr /><br />";

?>
