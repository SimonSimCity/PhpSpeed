<?php
/***************************************************************************
 *
 *   PHPspeed.com | PHP Benchmarking Script
 *   http://www.phpspeed.com 
 *   November 4, 2006
 *   
 *   This is a commercial script.  You MAY modify this script for your
 *   personal use.  You MAY NOT redistrubute modified code without the
 *   written permission of the author.  Please see the included license
 *   for additional restrictions.  
 *
 ***************************************************************************/

define('IN_PHPSPEED', true);

include "../config_db.php";
include "mysql.php";

$db = new sql_db($dbhost, $dbuname, $dbpass, $dbname, false);
if(!$db->db_connect_id)
{
	message_die(CRITICAL_ERROR, "Could not connect to the database");
}

$sql = "SELECT * FROM phpspeed_config";
$result = $db->sql_query($sql);
$ver = mysql_fetch_assoc($result);

$result = $db->sql_query("SELECT timestamp, score FROM results1 ORDER BY score DESC LIMIT 0,1");

header("Content-type: image/png"); 
$image = imagecreatefrompng("images/phpspeed_bg.png"); 

$clr_black = imagecolorallocate($image, 0, 0, 0); 
$clr_tc = ImageColorAllocate ($image, 255, 255, 255); 
$clr_yellow = ImageColorAllocate ($image, 255, 255, 0); 
$clr_gray = ImageColorAllocate ($image, 204, 204, 204); 
$clr_red  = ImageColorAllocate ($image, 255, 0, 0); 

$font = 2; 
$x_pos = 7; 
$y_inc = 1; 

$line_number = 2; 

//imagestring($image, $font, $x_pos, $y_inc * $line_number, "version", $clr_black); 

$row = mysql_fetch_array($result);

imagestring($image, 2, 7, 4, 'PHPspeed', $clr_tc);
imagestring($image, 2, 72, 4, number_format($row["score"]), $clr_tc); 
    
imagepng($image); 
imagedestroy($image); 

?>