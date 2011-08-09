<?php
/***************************************************************************
 *   Copyright (C) 2006 by phpSysInfo - A PHP System Information Script    *
 *   http://phpsysinfo.sourceforge.net/                                    *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 *                                                                         *
 *   This program is distributed in the hope that it will be useful,       *
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of        *
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the         *
 *   GNU General Public License for more details.                          *
 *                                                                         *
 *   You should have received a copy of the GNU General Public License     *
 *   along with this program; if not, write to the                         *
 *   Free Software Foundation, Inc.,                                       *
 *   59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.             *
 ***************************************************************************/

// $Id: network.php,v 1.14 2006/06/16 09:02:30 bigmichi1 Exp $

//
// xml_network()
//
function xml_network () {
	global $sysinfo;
	
	$arrNet = $sysinfo->network();
	
	$_text = "  <Network>\n";
	foreach( $arrNet as $strDev => $arrStats ) {
		$_text .= "    <NetDevice>\n"
			.  "      <Name>" . htmlspecialchars( trim( $strDev ), ENT_QUOTES ) . "</Name>\n"
			.  "      <RxBytes>" . htmlspecialchars( $arrStats['rx_bytes'], ENT_QUOTES ) . "</RxBytes>\n"
			.  "      <TxBytes>" . htmlspecialchars( $arrStats['tx_bytes'], ENT_QUOTES ) . "</TxBytes>\n"
			.  "      <Errors>" . htmlspecialchars( $arrStats['errs'], ENT_QUOTES ) . "</Errors>\n"
			.  "      <Drops>" . htmlspecialchars( $arrStats['drop'], ENT_QUOTES ) . "</Drops>\n"
			.  "    </NetDevice>\n";
	}
	$_text .= "  </Network>\n";
	
	return $_text;
}

//
// html_network()
//
function html_network () {
	global $XPath;
	global $text;
	
	$textdir = direction();
	
	$_text = "<table border=\"0\" align=\"center\" cellpadding=\"4\" cellspacing=\"1\" width=\"95%\" class=\"forumline\">\n"
		. "  <tr>\n"
		. "    <th align=\"" . $textdir['center'] . "\" valign=\"top\"><font size=\"-1\"><b>" . $text['device'] . "</b></font></th>\n"
		. "    <th align=\"" . $textdir['center'] . "\" valign=\"top\"><font size=\"-1\"><b>" . $text['received'] . "</b></font></th>\n"
		. "    <th align=\"" . $textdir['center'] . "\" valign=\"top\"><font size=\"-1\"><b>" . $text['sent'] . "</b></font></th>\n"
		. "    <th align=\"" . $textdir['center'] . "\" valign=\"top\"><font size=\"-1\"><b>" . $text['errors'] . "</b></font></th>\n"
		. "  </tr>\n";
	for( $i = 1, $max = sizeof( $XPath->getDataParts( "/phpsysinfo/Network" ) ); $i < $max; $i++ ) {
		if( $XPath->match( "/phpsysinfo/Network/NetDevice[" . $i . "]/Name" ) ) {
			$_text .= "  <tr>\n";
			$_text .= "    <td class=\"row1\" align=\"" . $textdir['left'] . "\" valign=\"top\"><font size=\"-1\">" . $XPath->getData( "/phpsysinfo/Network/NetDevice[" . $i . "]/Name" ) . "</font></td>\n";
			$_text .= "    <td class=\"row1\" align=\"" . $textdir['right'] . "\" valign=\"top\"><font size=\"-1\">" . format_bytesize( $XPath->getData( "/phpsysinfo/Network/NetDevice[" . $i . "]/RxBytes" ) / 1024 ) . "</font></td>\n";
			$_text .= "    <td class=\"row1\" align=\"" . $textdir['right'] . "\" valign=\"top\"><font size=\"-1\">" . format_bytesize( $XPath->getData( "/phpsysinfo/Network/NetDevice[" . $i . "]/TxBytes" ) / 1024 ) . "</font></td>\n";
			$_text .= "    <td class=\"row1\" align=\"" . $textdir['right'] . "\" valign=\"top\"><font size=\"-1\">" . $XPath->getData( "/phpsysinfo/Network/NetDevice[" . $i . "]/Errors" ) . '/' . $XPath->getData( "/phpsysinfo/Network/NetDevice[" . $i . "]/Drops" ) . "</font></td>\n";
			$_text .= "  </tr>\n";
		}
	}
	$_text .= "</table>";
	
	return $_text;
}

function wml_network() {
	global $XPath;
	global $text;
	
	$_text = "<card id=\"network\" title=\"" . $text['netusage'] . "\">\n";
	for( $i = 1, $max = sizeof( $XPath->getDataParts( "/phpsysinfo/Network" ) ); $i < $max; $i++ ) {
		if( $XPath->match( "/phpsysinfo/Network/NetDevice[" . $i . "]/Name" ) ) {
			$_text .= "<p>" . $text['device'] . ": " . $XPath->getData( "/phpsysinfo/Network/NetDevice[" . $i . "]/Name" ) . "<br/>"
				. "- U: " . format_bytesize( $XPath->getData("/phpsysinfo/Network/NetDevice[" . $i . "]/TxBytes" ) / 1024 ) . "<br/>"
				. "- D: " . format_bytesize( $XPath->getData("/phpsysinfo/Network/NetDevice[" . $i . "]/RxBytes" ) / 1024 ) . "<br/>"
				. "- E: " . $XPath->getData( "/phpsysinfo/Network/NetDevice[" . $i . "]/Errors" ) . '/' . $XPath->getData( "/phpsysinfo/Network/NetDevice[" . $i . "]/Drops" ) . "</p>\n";
		}
	}
	$_text .= "</card>\n";
	
	return $_text;
}
?>
