<?php

/**
 * This file is part of LEPTON Core, released under the GNU GPL
 * Please see LICENSE and COPYING files in your package for details, specially for terms and warranties.
 * 
 * NOTICE:LEPTON CMS Package has several different licenses.
 * Please see the individual license in the header of each single file or info.php of modules and templates.
 *
 * @author          Website Baker Project, LEPTON Project
 * @copyright       2004-2010 Website Baker Project
 * @copyright       2010-2013 LEPTON Project
 * @link            http://www.LEPTON-cms.org
 * @license         http://www.gnu.org/licenses/gpl.html
 * @license_terms   please see LICENSE and COPYING files in your package
 *
 */

// include class.secure.php to protect this file and the whole CMS!
if (defined('WB_PATH')) {	
	include(WB_PATH.'/framework/class.secure.php'); 
} else {
	$oneback = "../";
	$root = $oneback;
	$level = 1;
	while (($level < 10) && (!file_exists($root.'/framework/class.secure.php'))) {
		$root .= $oneback;
		$level += 1;
	}
	if (file_exists($root.'/framework/class.secure.php')) { 
		include($root.'/framework/class.secure.php'); 
	} else {
		trigger_error(sprintf("[ <b>%s</b> ] Can't include class.secure.php!", $_SERVER['SCRIPT_NAME']), E_USER_ERROR);
	}
}
// end include class.secure.php

/* Include  phpLib-template parser */
require_once(WB_PATH . '/include/phplib/template.inc');

// see if there exists a template file in "account-htt" folder  inside the current template
$paths = array(
	WB_PATH."/templates/".TEMPLATE,
	WB_PATH."/templates/".TEMPLATE."/templates",
	WB_PATH."/templates/".DEFAULT_TEMPLATE."/templates",
	dirname(__FILE__) . '/htt'
);

$template_path = NULL;
foreach($paths as $p) {
	$temp = $p."/login_form.htt";
	if (file_exists($temp)) {
		$template_path = &$p;
		break;
	}
}

if ($template_path === NULL) die("Can't find a valid template for this form!");

$tpl = new Template($template_path);

$tpl->set_unknowns('remove');


/**
 *	set template file name
 *
 */
$tpl->set_file('login', 'login_form.htt');

/**	*********
 *	languages
 *
 */
$tpl->set_block('login', 'languages_values_block', 'languages_values_output');

$query = "SELECT `directory`,`name` from `".TABLE_PREFIX."addons` where `type`='language'";
$result = $database->query( $query );
if (!$result) die ($database->get_error());

while( false != ($data = $result->fetchRow( MYSQL_ASSOC ) ) ) {

	$sel = (LANGUAGE == $data['directory']) ? " selected='selected'" : "";
	$tpl->set_var('LANG_SELECTED', $sel);
	$tpl->set_var(array(
			'LANG_CODE' 	=>	$data['directory'],
			'LANG_NAME'		=>	$data['name']
		)
	);
	$tpl->parse('languages_values_output', 'languages_values_block',true);
}


/**
 *
 *
 */
$hash = sha1( microtime().$_SERVER['HTTP_USER_AGENT'] );
$_SESSION['wb_apf_hash'] = $hash;

/**
 *
 *
 */
$r_value = md5( microtime(true)."sah ein knab ein roesslein stehen".$_SERVER['HTTP_USER_AGENT']);


$tpl->set_var(array(
	'TEMPLATE_DIR' 		=>	TEMPLATE_DIR,
	'WB_URL'					=>	WB_URL,
	'LOGIN_URL'			  =>	LOGIN_URL,
	'LOGOUT_URL'			=>	LOGOUT_URL,
	'FORGOT_URL'			=>	FORGOT_URL,  
	'TEXT_USERNAME'		=>	$TEXT['USERNAME'],
	'TEXT_PASSWORD'		=>	$TEXT['PASSWORD'],
	'MESSAGE'					=>	$thisApp->message,  
	'REDIRECT_URL'		=>	$thisApp->redirect_url,   
	'TEXT_LOGIN'			=>	$MENU['LOGIN'],
	'TEXT_LOGOUT'			=>	$MENU['LOGOUT'],
	'TEXT_RESET'			=>	$TEXT['RESET'],
	'HASH'						=>	$hash,
	'TEXT_FORGOTTEN_DETAILS' => $TEXT['FORGOTTEN_DETAILS']
	)
);

unset($_SESSION['result_message']);

// for use in template <!-- BEGIN/END comment_block -->
$tpl->set_block('login', 'comment_block', 'comment_replace'); 
$tpl->set_block('comment_replace', '');

// ouput the final template
$tpl->pparse('output', 'login');
?>