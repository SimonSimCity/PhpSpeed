/*
// +----------------------------------------------------------------------+
// | jamroom_pngfix.inc.js - Jamroom PNG fix for IE                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003-2004 by Brian Johnson                             |
// +----------------------------------------------------------------------+
// | This javascript function will "fix" IE so PNG transparency will      |
// | render correctly.                                                    |
// +----------------------------------------------------------------------+
// | Author: Brian Johnson <bigguy@jamroom.net>                           |
// +----------------------------------------------------------------------+
// $Id: jamroom_pngfix.inc.js,v 3.0.0.1 2006-06-18 15:38:39 bigguy Exp $
*/

function correctPNG()
{
    for(var i=0; i<document.images.length; i++) {
        var img = document.images[i]
        var imgName = img.src.toUpperCase()
        if (imgName.substring(imgName.length-3, imgName.length) == "PNG") {
            var imgID = (img.id) ? "id='" + img.id + "' " : ""
            var imgClass = (img.className) ? "class='" + img.className + "' " : ""
            var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' "
            var imgStyle = "display:inline-block;" + img.style.cssText
            if (img.align == "left") imgStyle = "float:left;" + imgStyle
            if (img.align == "right") imgStyle = "float:right;" + imgStyle
            if (img.parentElement.href) imgStyle = "cursor:hand;" + imgStyle
            var strNewHTML = "<span " + imgID + imgClass + imgTitle
             + " style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";"
             + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
             + "(src=\'" + img.src + "\', sizingMethod='scale');\"></span>"
             img.outerHTML = strNewHTML
             i = i-1
        }
    }
}
window.attachEvent("onload", correctPNG);
