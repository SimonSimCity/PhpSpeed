<?php 

// phpSysInfo - A PHP System Information Script
// http://phpsysinfo.sourceforge.net/
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
// $Id: index.php,v 1.116 2006/06/16 09:00:13 bigmichi1 Exp $
// phpsysinfo release version number

define('IN_PHPSPEED', true);
include "config_db.php";

include "inc/mysql.php";
include "inc/functions.server.php";

$self = $_SERVER['PHP_SELF'];

$db = new sql_db($dbhost, $dbuname, $dbpass, $dbname, false);

$sql = "SELECT * FROM phpspeed_config";
$result = $db->sql_query($sql);
$ver = mysql_fetch_assoc($result);

session_start();

if (isset($_GET['action']) and $_GET['action'] == 'logout') {
	session_start();
	session_destroy();
	header("Location: $self");
}

if(isset($_SESSION['logged']) && $_SESSION['logged'] == 'yes') {
	$login = "<a href=\"$self?action=logout\"><img align=\"middle\" src=\"inc/images/exit.gif\" border=\"0\" hspace=\"6\" alt=\"logout\"></a>";
} else {
	$login = "<span class=\"gen\"><form name=\"login\" action=\"$self\" method=\"POST\" style=\"margin:0;\"><input type=\"hidden\" name=\"submit\">Name:&nbsp;<input type=\"text\" name=\"user\" size=\"10\" class=\"post\">&nbsp;Pass:&nbsp;<input type=\"password\" name=\"pass\" size=\"10\" class=\"post\">&nbsp;<input name=\"Submit\" type=\"submit\" class=\"button\" value=\"Login\"></form></span>";
}

$u = isset($_POST['user']) ? $_POST['user'] : ''; //username from form
$p = isset($_POST['pass']) ? $_POST['pass'] : ''; // password from form.

if ($u == "$admin" && $p == "$pass"){
	$_SESSION['user'] = $u;
	$_SESSION['logged'] = "yes";
	header("Location: $self");
}

$VERSION = "2.5.2_rc3";
$startTime = array_sum( explode( " ", microtime() ) );

define('APP_ROOT', dirname(__FILE__));
define('IN_PHPSYSINFO', true);

ini_set('magic_quotes_runtime', 'off');
ini_set('register_globals', 'off');
// ini_set('display_errors','on');

require_once(APP_ROOT . '/includes/class.error.inc.php');
$error = new Error;

// Figure out which OS where running on, and detect support
if ( file_exists( APP_ROOT . '/includes/os/class.' . PHP_OS . '.inc.php' ) ) {
} else {
	$error->addError('include(class.' . PHP_OS . '.php.inc)' , PHP_OS . ' is not currently supported', __LINE__, __FILE__ );
}

if (!extension_loaded('xml')) {
	$error->addError('extension_loaded(xml)', 'phpsysinfo requires the xml module for php to work', __LINE__, __FILE__);
}
if (!extension_loaded('pcre')) {
	$error->addError('extension_loaded(pcre)', 'phpsysinfo requires the pcre module for php to work', __LINE__, __FILE__);
}

if (!file_exists(APP_ROOT . '/config.php')) {
	$error->addError('file_exists(config.php)', 'config.php does not exist in the phpsysinfo directory.', __LINE__, __FILE__);
} else {
	require_once(APP_ROOT . '/config.php'); 			// get the config file
}

if ( !empty( $sensor_program ) ) {
	$sensor_program = basename( $sensor_program );
	if( !file_exists( APP_ROOT . '/includes/mb/class.' . $sensor_program . '.inc.php' ) ) {
		$error->addError('include(class.' . htmlspecialchars($sensor_program, ENT_QUOTES) . '.inc.php)', 'specified sensor programm is not supported', __LINE__, __FILE__ );
	}
}

if ( !empty( $hddtemp_avail ) && $hddtemp_avail != "tcp" && $hddtemp_avail != "suid" ) {
	$error->addError('include(class.hddtemp.inc.php)', 'bad configuration in config.php for $hddtemp_avail', __LINE__, __FILE__ );
}

if( $error->ErrorsExist() ) {
	echo $error->ErrorsAsHTML();
	exit;
}

require_once(APP_ROOT . '/includes/common_functions.php'); 	// Set of common functions used through out the app

// commented for security
// Check to see if where running inside of phpGroupWare
//if (file_exists("../header.inc.php") && isset($_REQUEST['sessionid']) && $_REQUEST['sessionid'] && $_REQUEST['kp3'] && $_REQUEST['domain']) {
//  define('PHPGROUPWARE', 1);
//  $phpgw_info['flags'] = array('currentapp' => 'phpsysinfo-dev');
//  include('../header.inc.php');
//} else {
//  define('PHPGROUPWARE', 0);
//}

// DEFINE TEMPLATE_SET
if (isset($_POST['template'])) {
	$template = $_POST['template'];
} elseif (isset($_GET['template'])) {
	$template = $_GET['template'];
} elseif (isset($_COOKIE['template'])) {
	$template = $_COOKIE['template'];
} else {
	$template = $default_template;
}

// check to see if we have a random
if ($template == 'random') {
	$buf = gdc( APP_ROOT . "/templates/" );
	$template = $buf[array_rand($buf, 1)];
}

if ($template != 'xml' && $template != 'wml') {
	// figure out if the template exists
	$template = basename($template);
	if (!file_exists(APP_ROOT . "/templates/" . $template)) {
		// use default if not exists.
		$template = $default_template;
	}
	// Store the current template name in a cookie, set expire date to 30 days later
	// if template is xml then skip
	setcookie("template", $template, (time() + 60 * 60 * 24 * 30));
	$_COOKIE['template'] = $template; //update COOKIE Var
}

// get our current language
// default to english, but this is negotiable.
if ($template == "wml") {
	$lng = "en";
} elseif (isset($_POST['lng'])) {
	$lng = $_POST['lng'];
} elseif (isset($_GET['lng'])) {
	$lng = $_GET['lng'];
} elseif (isset($_COOKIE['lng'])) {
	$lng = $_COOKIE['lng'];
} else {
	$lng = $default_lng;
}

if ($lng == 'browser') {
	// see if the browser knows the right languange.
	if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
		$plng = split(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
		if (count($plng) > 0) {
			while (list($k, $v) = each($plng)) {
				$k = split(';', $v, 1);
				$k = split('-', $k[0]);
				if (file_exists(APP_ROOT . '/includes/lang/' . $k[0] . '.php')) {
					$lng = $k[0];
					break;
				}
			}
		}
	}
}

$lng = basename($lng);
if (file_exists(APP_ROOT . '/includes/lang/' . $lng . '.php')) {
	$charset = 'iso-8859-1';
	require_once(APP_ROOT . '/includes/lang/' . $lng . '.php'); // get our language include
	// Store the current language selection in a cookie, set expire date to 30 days later
	setcookie("lng", $lng, (time() + 60 * 60 * 24 * 30));
	$_COOKIE['lng'] = $lng; //update COOKIE Var
} else {
	$error->addError('include(' . $lng . ')', 'we do not support this language', __LINE__, __FILE__ );
	$lng = $default_lng;
}

// include the files and create the instances
define('TEMPLATE_SET', $template);
require_once( APP_ROOT . '/includes/os/class.' . PHP_OS . '.inc.php' );
$sysinfo = new sysinfo;
if( !empty( $sensor_program ) ) {
	require_once(APP_ROOT . '/includes/mb/class.' . $sensor_program . '.inc.php');
	$mbinfo = new mbinfo;
}
if ( !empty($hddtemp_avail ) ) {
	require_once(APP_ROOT . '/includes/mb/class.hddtemp.inc.php');
}

require_once(APP_ROOT . '/includes/xml/vitals.php');
require_once(APP_ROOT . '/includes/xml/network.php');
require_once(APP_ROOT . '/includes/xml/hardware.php');
require_once(APP_ROOT . '/includes/xml/memory.php');
require_once(APP_ROOT . '/includes/xml/filesystems.php');
require_once(APP_ROOT . '/includes/xml/mbinfo.php');
require_once(APP_ROOT . '/includes/xml/hddtemp.php');

// build the xml
$xml = "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n";
$xml .= "<!DOCTYPE phpsysinfo SYSTEM \"phpsysinfo.dtd\">\n\n";
$xml .= created_by();
$xml .= "<phpsysinfo>\n";
$xml .= "  <Generation version=\"$VERSION\" timestamp=\"" . time() . "\"/>\n";
$xml .= xml_vitals();
$xml .= xml_network();
$xml .= xml_hardware($hddtemp_devices);
$xml .= xml_memory();
$xml .= xml_filesystems();
if ( !empty( $sensor_program ) ) {
	$xml .= xml_mbinfo();
}
if ( !empty($hddtemp_avail ) ) {
	$hddtemp = new hddtemp($hddtemp_devices);
	$xml .= xml_hddtemp($hddtemp);
}
$xml .= "</phpsysinfo>";
replace_specialchars($xml);

// output
if (TEMPLATE_SET == 'xml') {
	// just printout the XML and exit
	header("Content-Type: text/xml\n\n");
	print $xml;
} elseif (TEMPLATE_SET == 'wml') {
	require_once(APP_ROOT . '/includes/XPath.class.php');
	$XPath = new XPath();
	$XPath->importFromString($xml);

	header("Content-type: text/vnd.wap.wml; charset=iso-8859-1");
	header("");
	header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");

	echo "<?xml version='1.0' encoding='iso-8859-1'?>\n";
	echo "<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\" \"http://www.wapforum.org/DTD/wml_1.1.xml\" >\n";
	echo "<wml>\n";
	echo "<card id=\"start\" title=\"phpSysInfo - Menu\">\n";
	echo "<p><a href=\"#vitals\">" . $text['vitals'] . "</a></p>\n";
	echo "<p><a href=\"#network\">" . $text['netusage'] . "</a></p>\n";
	echo "<p><a href=\"#memory\">" . $text['memusage'] . "</a></p>\n";
	echo "<p><a href=\"#filesystem\">" . $text['fs'] . "</a></p>\n";
	if (!empty($sensor_program) || (isset($hddtemp_avail) && $hddtemp_avail)) {
		echo "<p><a href=\"#temp\">" . $text['temperature'] . "</a></p>\n";
	}
	if (!empty($sensor_program)) {
		echo "<p><a href=\"#fans\">" . $text['fans'] . "</a></p>\n";
		echo "<p><a href=\"#volt\">" . $text['voltage'] . "</a></p>\n";
	}
	echo "</card>\n";
	echo wml_vitals();
	echo wml_network();
	echo wml_memory();
	echo wml_filesystem();

	$temp = "";
	if (!empty($sensor_program)) {
		echo wml_mbfans();
		echo wml_mbvoltage();
		$temp .= wml_mbtemp();
	}
	if (isset($hddtemp_avail) && $hddtemp_avail)
	if ($XPath->match("/phpsysinfo/HDDTemp/Item"))
	$temp .= wml_hddtemp();
	if(strlen($temp) > 0)
	echo "<card id=\"temp\" title=\"" . $text['temperature'] . "\">" . $temp . "</card>";
	echo "</wml>\n";

} else {
	$image_height = get_gif_image_height(APP_ROOT . '/templates/' . TEMPLATE_SET . '/images/bar_middle.gif');
	define('BAR_HEIGHT', $image_height);

	//  if (PHPGROUPWARE != 1) {
	require_once(APP_ROOT . '/includes/class.Template.inc.php'); // template library
	//  }
	// fire up the template engine
	$tpl = new Template(APP_ROOT . '/templates/' . TEMPLATE_SET);
	$tpl->set_file(array('form' => 'form.tpl'));
	// print out a box of information
	function makebox ($title, $content)
	{
		if (empty($content)) {
			return "";
		} else {
			global $webpath;
			$textdir = direction();
			$t = new Template(APP_ROOT . '/templates/' . TEMPLATE_SET);
			$t->set_file(array('box' => 'box.tpl'));
			$t->set_var('title', $title);
			$t->set_var('content', $content);
			$t->set_var('webpath', $webpath);
			$t->set_var('text_dir', $textdir['direction']);
			return $t->parse('out', 'box');
		}
	}
	// Fire off the XPath class
	require_once(APP_ROOT . '/includes/XPath.class.php');
	$XPath = new XPath();
	$XPath->importFromString($xml);
	// let the page begin.

	setlocale( LC_ALL, $text['locale'] );
	global $XPath;

	echo "<!DOCTYPE html>\n";

	echo "<html>\n";
	echo created_by();

	echo "<head>\n";

	echo "\t<meta http-equiv=\"content-language\" content=\"en-us\" />\n";
	echo "\t<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" />\n";

	echo "\t<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"inc/Style.css\">\n";

	echo "</head>\n";

	//Start session test
	if(isset($_SESSION['logged']) && $_SESSION['logged'] == 'yes') {

		$tpl->set_var('title', $text['title'] . ': ' . $XPath->getData('/phpsysinfo/Vitals/Hostname') . ' (' . $XPath->getData('/phpsysinfo/Vitals/IPAddr') . ')');
		$tpl->set_var('vitals', makebox($text['vitals'], html_vitals()));
		$tpl->set_var('network', makebox($text['netusage'], html_network()));
		$tpl->set_var('hardware', makebox($text['hardware'], html_hardware()));
		$tpl->set_var('memory', makebox($text['memusage'], html_memory()));
		$tpl->set_var('filesystems', makebox($text['fs'], html_filesystems()));
		// Timo van Roermund: change the condition for showing the temperature, voltage and fans section
		$html_temp = "";
		if (!empty($sensor_program)) {
			if ($XPath->match("/phpsysinfo/MBinfo/Temperature/Item")) {
				$html_temp = html_mbtemp();
			}
			if ($XPath->match("/phpsysinfo/MBinfo/Fans/Item")) {
				$tpl->set_var('mbfans', makebox($text['fans'], html_mbfans()));
			} else {
				$tpl->set_var('mbfans', '');
			};
			if ($XPath->match("/phpsysinfo/MBinfo/Voltage/Item")) {
				$tpl->set_var('mbvoltage', makebox($text['voltage'], html_mbvoltage()));
			} else {
				$tpl->set_var('mbvoltage', '');
			};
		}
		if (isset($hddtemp_avail) && $hddtemp_avail) {
			if ($XPath->match("/phpsysinfo/HDDTemp/Item")) {
				$html_temp .= html_hddtemp();
			};
		}
		if (strlen($html_temp) > 0) {
			$tpl->set_var('mbtemp', makebox($text['temperature'], "\n<table width=\"100%\">\n" . $html_temp . "</table>\n"));
		}

		if ( $error->ErrorsExist() && isset($showerrors) && $showerrors ) {
			$tpl->set_var('errors', makebox("ERRORS", $error->ErrorsAsHTML() ));
		}

		$bottom = "<br /><center><span class=\"gen\">Created by: <a href=\"http://phpsysinfo.sourceforge.net\" target=\"_blank\">phpSysInfo-2.5.2.rc3</a> {time1} in {time2} Seconds
           </span></center>";

		$tpl->set_var('bottom', $bottom);

		$nologin = '';

		//If no session
	} else {

		$nologin = "<table width=\"95%\" align=\"center\">
         <tr>
             <td width=\"100%\">
                  <table class=\"forumline\" cellpadding=\"8\">
                        <tr>
                            <td class=\"row1\">You need to login to view this page...</td>
                        </tr>
                  </table>
            </td>
         </tr>
     </table>";

	}

	$tpl->set_var('time1', strftime( $text['gen_time'] , time() ));
	$tpl->set_var('time2', round( ( array_sum( explode( " ", microtime() ) ) - $startTime ), 4 ));
	$tpl->set_var('httphost', $_SERVER['HTTP_HOST']);
	$tpl->set_var('login', $login);
	$tpl->set_var('nologin', $nologin);
	$tpl->set_var('ver', $ver['version']);

////$tpl->set_var('apav', $aph);
//	$tpl->set_var('gde', $gds);
//	$tpl->set_var('gdv', $gdv);
	$tpl->set_var('apav');
	$tpl->set_var('gde');
	$tpl->set_var('gdv');
	//    $tpl->set_var('time2', round( ( array_sum( explode( " ", microtime() ) ) - $startTime ), 4 ));

	// parse our the template
	$tpl->pfp('out', 'form');

	// finally our print our footer
	$arrDirection = direction();

	if( ! $hide_picklist ) {
		echo "<center>\n";
		$update_form = "<form method=\"POST\" action=\"" . $_SERVER['PHP_SELF'] . "\">\n" . "\t" . $text['template'] . ":&nbsp;\n" . "\t<select name=\"template\">\n";

		$resDir = opendir( APP_ROOT . '/templates/' );
		while( false !== ( $strFile = readdir( $resDir ) ) ) {
			if( $strFile != 'CVS' && $strFile[0] != '.' && is_dir( APP_ROOT . '/templates/' . $strFile ) ) {
				$arrFilelist[] = $strFile;
			}
		}
		closedir( $resDir );
		asort( $arrFilelist );
		foreach( $arrFilelist as $strVal ) {
			if( $_COOKIE['template'] == $strVal ) {
				$update_form .= "\t\t<option value=\"" . $strVal . "\" SELECTED>" . $strVal . "</option>\n";
			} else {
				$update_form .= "\t\t<option value=\"" . $strVal . "\">" . $strVal . "</option>\n";
			}
		}
		$update_form .= "\t\t<option value=\"xml\">XML</option>\n";
		$update_form .= "\t\t<option value=\"wml\">WML - experimental</option>\n";
		$update_form .= "\t\t<option value=\"random\"";
		if( $_COOKIE['template'] == 'random' ) {
			$update_form .= " SELECTED";
		}
		$update_form .= ">random</option>\n";
		$update_form .= "\t</select>\n";

		$update_form .= "\t&nbsp;&nbsp;" . $text['language'] . ":&nbsp;\n" . "\t<select name=\"lng\">\n";
		unset( $filelist );
		$resDir = opendir( APP_ROOT . "/includes/lang/" );
		while( false !== ( $strFile = readdir( $resDir ) ) ) {
			if ( $strFile[0] != '.' && is_file( APP_ROOT . "/includes/lang/" . $strFile ) && preg_match( "/\.php$/", $strFile ) ) {
				$arrFilelist[] = preg_replace("/\.php$/", "", $strFile );
			}
		}
		closedir($resDir);
		asort( $arrFilelist );
		foreach( $arrFilelist as $strVal ) {
			if( $_COOKIE['lng'] == $strVal ) {
				$update_form .= "\t\t<option value=\"" . $strVal . "\" SELECTED>" . $strVal . "</option>\n";
			} else {
				$update_form .= "\t\t<option value=\"" . $strVal . "\">" . $strVal . "</option>\n";
			}
		}
		$update_form .= "\t\t<option value=\"browser\"";
		if( $_COOKIE['lng'] == "browser" ) {
			$update_form .= " SELECTED";
		}
		$update_form .= ">browser default</option>\n\t</select>\n";

		$update_form .= "\t<input type=\"submit\" value=\"" . $text['submit'] . "\">\n" . "</form>\n";
		echo $update_form;
		echo "</center>\n";
	} else {
		echo "<br>\n";
	}

	//Section below added to bottom of template file instead so it would appear 'above' the common footer

	//echo "<hr>\n";
	//echo "<table width=\"100%\">\n\t<tr>\n";
	//echo "\t\t<td align=\"" . $arrDirection['left'] . "\"><font size=\"-1\">" . $text['created'] . "&nbsp;<a href=\"http://phpsysinfo.sourceforge.net\" target=\"_blank\">phpSysInfo-" . $VERSION . "</a>" . strftime( $text['gen_time'], time() ) . "</font></td>\n";
	//echo "\t\t<td align=\"" . $arrDirection['right'] . "\"><font size=\"-1\">" . round( ( array_sum( explode( " ", microtime() ) ) - $startTime ), 4 ). " sec</font></td>\n";
	//echo "\t</tr>\n</table>\n";
	//echo "\n</body>\n</html>\n";
}

?>
