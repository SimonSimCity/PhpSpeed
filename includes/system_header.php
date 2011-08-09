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

// $Id: system_header.php,v 1.29 2006/06/15 18:42:30 bigmichi1 Exp $

if( ! defined( 'IN_PHPSYSINFO' ) ) {
	die( "No Hacking" );
}

setlocale( LC_ALL, $text['locale'] );
global $XPath;

echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"DTD/xhtml1-transitional.dtd\">\n";

echo "<html>\n";
echo created_by();

echo "<head>\n";

echo "\t<meta http-equiv=\"content-language\" content=\"en-us\" />\n";
echo "\t<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" />\n";

echo "\t<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"inc/Style.css\">\n";

echo "</head>\n";

?>

