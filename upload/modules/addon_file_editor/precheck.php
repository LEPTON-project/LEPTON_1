<?php
/**
 * Admin tool: Addon File Editor
 *
 * This tool allows you to "edit", "delete", "create", "upload" or "backup" files of installed 
 * Add-ons such as modules, templates and languages via the Website Baker backend. This enables
 * you to perform small modifications on installed Add-ons without downloading the files first.
 *
 * This file contains the installation checks executed prior to the installation of the module
 * 
 * LICENSE: GNU General Public License 3.0
 * 
 * @author		Christian Sommer (doc)
 * @copyright	(c) 2008-2010
 * @license		http://www.gnu.org/licenses/gpl.html
 * @version		1.0.0
 * @platform	Website Baker 2.8
*/

// prevent this file from being accessed directly
if (!defined('WB_PATH')) die(header('Location: ../../index.php'));

/**
 * Check if minimum requirements for this module are fullfilled
 */
$PRECHECK = array(
	// make sure LEPTON version is 2.0 or higher
	'VERSION'	=> array('VERSION' => '2.0', 'OPERATOR' => '>='),
	
	// make sure PHP version is 4.3.11 or higher
	'PHP_VERSION'	=> array('VERSION' => '5.3.0', 'OPERATOR' => '>=')
	);
?>