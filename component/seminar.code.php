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
//*   Based on PHP Barcode Generator v1.0   *
//*        by Charles J. Scheffold          *
//*******************************************

function Code39 ($Asc) {
  switch ($Asc) {
    case ' ':
      return "011000100";     
    case '$':
      return "010101000";             
    case '%':
      return "000101010"; 
    case '*':
      return "010010100";
    case '+':
      return "010001010"; 
    case '|':
      return "010000101"; 
    case '.':
      return "110000100"; 
    case '/':
      return "010100010"; 
    case '-':
      return "010000101";
    case '0':
      return "000110100"; 
    case '1':
      return "100100001"; 
    case '2':
      return "001100001"; 
    case '3':
      return "101100000"; 
    case '4':
      return "000110001"; 
    case '5':
      return "100110000"; 
    case '6':
      return "001110000"; 
    case '7':
      return "000100101"; 
    case '8':
      return "100100100"; 
    case '9':
      return "001100100"; 
    case 'A':
      return "100001001"; 
    case 'B':
      return "001001001"; 
    case 'C':
      return "101001000";
    case 'D':
      return "000011001";
    case 'E':
      return "100011000";
    case 'F':
      return "001011000";
    case 'G':
      return "000001101";
    case 'H':
      return "100001100";
    case 'I':
      return "001001100";
    case 'J':
      return "000011100";
    case 'K':
      return "100000011";
    case 'L':
      return "001000011";
    case 'M':
      return "101000010";
    case 'N':
      return "000010011";
    case 'O':
      return "100010010";
    case 'P':
      return "001010010";
    case 'Q':
      return "000000111";
    case 'R':
      return "100000110";
    case 'S':
      return "001000110";
    case 'T':
      return "000010110";
    case 'U':
      return "110000001";
    case 'V':
      return "011000001";
    case 'W':
      return "111000000";
    case 'X':
      return "010010001";
    case 'Y':
      return "110010000";
    case 'Z':
      return "011010000";
    default:
      return "011000100"; 
  }
}

if(isset($_GET["code"])) $code=$_GET["code"];
$text = 1;
$width = 300;
$height = 50;

header ("Content-type: image/jpeg");
$im = ImageCreate ($width, $height)
or die ("Cannot Initialize new GD image stream");
$White = ImageColorAllocate ($im, 255, 255, 255);
$Black = ImageColorAllocate ($im, 0, 0, 0);
ImageInterLace ($im, 1);
$NarrowRatio = 20;
$WideRatio = 55;
$QuietRatio = 35;
$nChars = (strlen($code)+2) * ((6 * $NarrowRatio) + (3 * $WideRatio) + ($QuietRatio));
$Pixels = $width / $nChars;
$NarrowBar = (int)(20 * $Pixels);
$WideBar = (int)(55 * $Pixels);
$QuietBar = (int)(35 * $Pixels);
$ActualWidth = (($NarrowBar * 6) + ($WideBar*3) + $QuietBar) * (strlen ($code)+2);
if (($NarrowBar == 0) || ($NarrowBar == $WideBar) || ($NarrowBar == $QuietBar) || ($WideBar == 0) || ($WideBar == $QuietBar) || ($QuietBar == 0)) {
  ImageString ($im, 1, 0, 0, "Image is too small!", $Black);
  ImagePNG($im);
  exit;
}
$CurrentBarX = (int)(($width - $ActualWidth) / 2);
$Color = $White;
$BarcodeFull = "*".strtoupper ($code)."*";
settype ($BarcodeFull, "string");
$FontNum = 3;
$FontHeight = ImageFontHeight ($FontNum);
$FontWidth = ImageFontWidth ($FontNum);
if ($text != 0) {
  $CenterLoc = (int)(($width-1) / 2) - (int)(($FontWidth * strlen($BarcodeFull)) / 2);
  ImageString ($im, $FontNum, $CenterLoc, $height-$FontHeight, "$BarcodeFull", $Black);
} else {
  $FontHeight=-2;
}
for ($i=0; $i<strlen($BarcodeFull); $i++) {
  $StripeCode = Code39 ($BarcodeFull[$i]);
  for ($n=0; $n < 9; $n++) {
    if ($Color == $White) {
      $Color = $Black;
    } else {
      $Color = $White;
    }
    switch ($StripeCode[$n]) {
      case '0':
        ImageFilledRectangle ($im, $CurrentBarX, 0, $CurrentBarX+$NarrowBar, $height-1-$FontHeight-2, $Color);
        $CurrentBarX += $NarrowBar;
        break;
      case '1':
        ImageFilledRectangle ($im, $CurrentBarX, 0, $CurrentBarX+$WideBar, $height-1-$FontHeight-2, $Color);
        $CurrentBarX += $WideBar;
        break;
    }
  }
  $Color = $White;
  ImageFilledRectangle ($im, $CurrentBarX, 0, $CurrentBarX+$QuietBar, $height-1-$FontHeight-2, $Color);
  $CurrentBarX += $QuietBar;
}
ImagePNG($im);

?>
