<?php

//*******************************************
//***         Seminar for joomla!         ***
//***            Version 1.3.0            ***
//*******************************************
//***     Copyright (c) Dirk Vollmar      ***
//***             2004 / 2009             ***
//***          joomla@vollmar.ws          ***
//***         All rights reserved         ***
//*******************************************
//*     Released under GNU/GPL License      *
//*  http://www.gnu.org/licenses/gpl.html   *
//*******************************************

header("Content-type: text/html; charset=UTF-8");
$breite = 500;
if( $_GET['wh'] != "" ) {
  $breite = $_GET['wh'];
}
$hoehe = 350;
if( $_GET['ht'] != "" ) {
  $hoehe = $_GET['ht'];
}
$schluessel = "ABQIAAAAD3xjwsHpkF_oIn9OdC78aBRi_j0U6kJrkFvY4-OX2XYmEAa76BTo8jfLEtnrz_tH655PHFVG_hwlRQ";
if( $_GET['key'] != "" ) {
  $schluessel = $_GET['key'];
}
$infowin = 1;
if( $_GET['iw'] != "" ) {
  $infowin = $_GET['iw'];
}

$html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"  \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">";
$html .= "\n<html xmlns=\"http://www.w3.org/1999/xhtml\">";
$html .= "\n<head><meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\"/>";
$html .= "\n<title>Seminar Google Map</title>";
$html .= "\n<script src=\"http://maps.google.com/maps?file=api&amp;v=2&amp;key=".$schluessel."\"></script>\n<script type=\"text/javascript\">";
$html .= "\nvar map = null;";
$html .= "\nvar geocoder = null;";
$html .= "\nvar myIcon = [];";
$html .= "\nfunction load() {";
$html .= "\n if (GBrowserIsCompatible()) {";
$html .= "\n  map = new GMap2(document.getElementById(\"map\"));";
$html .= "\n  geocoder = new GClientGeocoder();";
$html .= "\n }";
$html .= "\n}";
$html .= "\n function showAddress() {";  
$html .= "\n    myIcon[\"pin\"] = new GIcon();"; 
$html .= "\n    myIcon[\"pin\"].image = \"./images/pin.png\";"; 
$html .= "\n    myIcon[\"pin\"].shadow = \"./images/shadow.png\";";
$html .= "\n    myIcon[\"pin\"].iconSize = new GSize(20, 34);"; 
$html .= "\n    myIcon[\"pin\"].shadowSize = new GSize(40, 34);"; 
$html .= "\n    myIcon[\"pin\"].iconAnchor = new GPoint(9, 34);"; 
$html .= "\n    myIcon[\"pin\"].infoWindowAnchor = new GPoint(13, 2);"; 
$html .= "\n   var address = \"";
if( $_GET['ziel'] != "" ) {
  $html .= $_GET['ziel'];
}
$html .= "\";";
$html .= "\n   geocoder.getLatLng(";
$html .= "\n   address,";
$html .= "\n   function(point) {";
$html .= "\n   if (point) {";
$html .= "\n    map.setCenter(point, 15);";
$html .= "\n    map.addControl(new GLargeMapControl());";
$html .= "\n    map.addControl(new GMapTypeControl());";
$html .= "\n    map.addMapType(G_PHYSICAL_MAP);";
$html .= "\n    map.addControl(new GOverviewMapControl());";
$html .= "\n    var marker = new GMarker(point, {icon:myIcon[\"pin\"],title:\"\"});";
$html .= "\n    map.addOverlay(marker);";
$ziel = "<td><div style='font-family: Arial, Tahoma; font-size: 11px;font-weight: bold; line-height: 1;'>".str_replace(chr(13),"",$_GET['ort'])."</div></td>";
$link = "<td align='center' valign='center'><form name='gmap' target='_new' method='get' action='http://maps.google.com/maps'><input type='hidden' name='daddr' value='".$_GET['ziel']."'><input type='hidden' name='f' value='d'><input type='hidden' name='hl' value=''><input type='hidden' name='ie' value='UTF8'><input type='hidden' name='z' value=''><input type='hidden' name='om' value='0'><input type='text' size='15' name='saddr'  style='font-family: Verdana, Tahome; font-size: 10px;'><br /><button type='button' onclick='document.gmap.submit();' style='font-family: Verdana, Tahome; font-size: 10px;'>&gt;&gt;&gt;</button></td></form>";
$text = "<table cellpadding='5'><tr>".$link.$ziel."</tr></table>";
if( $infowin == 1 ) {
  $html .= "\n    marker.openInfoWindowHtml(\"".$text."\");";
}
$html .= "\n    GEvent.addListener(marker, \"click\", function() {";
$html .= "\n     marker.openInfoWindowHtml(\"".$text."\");";
$html .= "\n    });";
$html .= "\n   }";
$html .= "\n  }";
$html .= "\n );";
$html .= "\n}";    
$html .= "\n//]]>";
$html .= "\n</script>";
$html .= "\n</head>";
$html .= "\n<body bgcolor=\"#000000\" marginwidth=\"0\" marginheight=\"0\" topmargin=\"0\" leftmargin=\"0\" onload=\"load(); showAddress();\" onunload=\"GUnload();\">";
$html .= "\n<div id=\"map\" style=\"width: ".$breite."px; height: ".$hoehe."px\"></div>";
$html .= "\n</body></html>";

echo $html;