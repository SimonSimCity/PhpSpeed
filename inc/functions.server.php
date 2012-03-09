<?php
/**
*  PHPspeed
*
* @author     http://www.phpspeed.com
* @copyright  2006 http://www.phpspeed.com
* @license    GPLv2 (or later)
*/

/**
 * 2012/03/03 Modified by Kenji Suzuki <https://github.com/kenjis/>
 */

/***************************************************************************
*
*   PHPspeed.com | PHP Benchmarking Script
*   http://www.phpspeed.com
*
*   Sat Mar 17, 2007 3:53 pm
*   PHPspeed is now GPL licensed!!
*   See http://www.phpspeed.com/phpspeed-forums-f1/phpspeed-is-now-gpl-licensed-t18.html
*
***************************************************************************/

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

/***************************************************************************
*    Portions of this file have been copied from phpSYSTEM
*    Original Author: J.P. Pasnak <pasnak@warpedsystems.sk.ca>
****************************************************************************/

if (!defined('IN_PHPSPEED')) {
	die("No Hacking");
}

//Display CPU information
$cpuinfo = file("/proc/cpuinfo");
$total_cpu=0;
for ($i = 0; $i < count($cpuinfo); $i++) {
	if (trim($cpuinfo[$i]) != "") {
		list($item, $data) = explode(":", $cpuinfo[$i], 2);
		$item = chop($item);
		$data = chop($data);
		if ($item == "processor") {
				$total_cpu++;
				$cpu_info = $total_cpu;
		}
		if ($item == "vendor_id") { $cpu_info .= $data; }
		if ($item == "model name") { $cpu_info .= $data; }
		if ($item == "cpu MHz") { 
				$cpu_info .= " " . floor($data); 
				$found_cpu = "yes";
		}
		if ($item == "cache size") { $cache = $data;}
		if ($item == "bogomips") { $bogomips = $data;}
	}
}
if($found_cpu != "yes") { $cpu_info .= " <b>unknown</b>"; } 
$cpu_info .= " MHz\n";

//This provides server uptime
  $data = shell_exec('uptime');
  $uptime = explode(' up ', $data);
  $uptime = explode(',', $uptime[1]);
  $uptime = $uptime[0].', '.$uptime[1];
//echo ('<br />Current server uptime: '.$uptime.'');

//THIS PROVIDES MEMORY INFO
$meminfo = file("/proc/meminfo");
$total_mem  = 0;
$free_mem   = 0;
$total_swap = 0;
$free_swap  = 0;
$buffer_mem = 0;
$cache_mem  = 0;
$shared_mem = 0;
for ($i = 0; $i < count($meminfo); $i++) {
		list($item, $data) = explode(":", $meminfo[$i], 2);
		$item = chop($item);
		$data = chop($data);
		if ($item == "MemTotal") { $total_mem =$data;	}
		if ($item == "MemFree") { $free_mem = $data; }
		if ($item == "SwapTotal") { $total_swap = $data; }
		if ($item == "SwapFree") { $free_swap = $data; }
		if ($item == "Buffers") { $buffer_mem = $data; }
		if ($item == "Cached") { $cache_mem = $data; }
		if ($item == "MemShared") {$shared_mem = $data; }
		if ($item == "Shmem") {$shared_mem = $data; }
}
$used_mem = ( $total_mem - $free_mem ); 
$used_swap = ( $total_swap - $free_swap );
$percent_free = round( $free_mem / $total_mem * 100 );
$percent_used = round( $used_mem / $total_mem * 100 );

// Checks to see if there is no swap - contributed by Joacher
if ($total_swap != 0) 
{ 
$percent_swap = round( ( $total_swap - $free_swap ) / $total_swap * 100 ); 
$percent_swap_free = round( $free_swap / $total_swap * 100 ); 
} else { 
$percent_swap = "N/A "; 
$percent_swap_free = "N/A "; 
}; 
$percent_buff = round( $buffer_mem / $total_mem * 100 );
$percent_cach = round( $cache_mem / $total_mem * 100 );
$percent_shar = round( $shared_mem / $total_mem * 100 );

$tot_mem = ($total_mem/1024);
$fre_mem = ($free_mem/1024);
$tot_swap = ($total_swap/1024);
$fre_swap = ($free_swap/1024);
$buf_mem = ($buffer_mem/1024);
$cac_mem = ($cache_mem/1024);
$sha_mem = ($shared_mem/1024);

?>
