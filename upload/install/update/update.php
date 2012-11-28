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

$lepton_version = $database->get_one("SELECT `value` from `" . TABLE_PREFIX . "settings` where `name`='lepton_version'");
if (version_compare($lepton_version, "1.1.0", "="))
{
    echo("<h3>Your LEPTON Version : " . LEPTON_VERSION . " </h3>");
    include 'scripts/111_update.php';
}

/**
 *  update LEPTON to 1.1.2 , check release
 */
$lepton_version = $database->get_one("SELECT `value` from `" . TABLE_PREFIX . "settings` where `name`='lepton_version'");
if (version_compare($lepton_version, "1.1.1", "="))
{
    echo("<h3>Your LEPTON Version : " . LEPTON_VERSION . " </h3>");
    include 'scripts/112_update.php';
}

/**
 *  update LEPTON to 1.1.3 , check release
 */
$lepton_version = $database->get_one("SELECT `value` from `" . TABLE_PREFIX . "settings` where `name`='lepton_version'");
if (version_compare($lepton_version, "1.1.2", "="))
{
    echo("<h3>Your LEPTON Version : " . LEPTON_VERSION . " </h3>");
    include 'scripts/113_update.php';
}

/**
 *  update LEPTON to 1.1.4 , check release
 */
$lepton_version = $database->get_one("SELECT `value` from `" . TABLE_PREFIX . "settings` where `name`='lepton_version'");
if (version_compare($lepton_version, "1.1.3", "="))
{
    echo("<h3>Your LEPTON Version : " . LEPTON_VERSION . " </h3>");
    include 'scripts/114_update.php';
}

/**
 *  update LEPTON to 1.2.0 , check release
 */
$lepton_version = $database->get_one("SELECT `value` from `" . TABLE_PREFIX . "settings` where `name`='lepton_version'");
if (version_compare($lepton_version, "1.1.4", "="))
{
    echo("<h3>Your LEPTON Version : " . LEPTON_VERSION . " </h3>");
    include 'scripts/120_update.php';
}

/**
 *  update LEPTON to 1.2.1 , check release
 */
$lepton_version = $database->get_one("SELECT `value` from `" . TABLE_PREFIX . "settings` where `name`='lepton_version'");
if (version_compare($lepton_version, "1.2.0", "="))
{
    echo("<h3>Your LEPTON Version : " . LEPTON_VERSION . " </h3>");
    include 'scripts/121_update.php';
}

/**
 *  update LEPTON to 1.2.2 , check release
 */
$lepton_version = $database->get_one("SELECT `value` from `" . TABLE_PREFIX . "settings` where `name`='lepton_version'");
if (version_compare($lepton_version, "1.2.1", "="))
{
    echo("<h3>Your LEPTON Version : " . LEPTON_VERSION . " </h3>");
    include 'scripts/122_update.php';
}

/**
 *  reload all addons
 */
if (file_exists('reload.php')) {
    include 'reload.php';
} 

echo "<h3>reload all addons: successfull</h3>";

/**
 *  success message
 */
echo "<br /><h3>Congratulation, update procedure complete!</h3><br /><hr /><br />";

/**
 *  login message
 */

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