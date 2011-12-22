<?php

// *******************************************
// ***         Seminar for joomla!         ***
// ***            Version 1.4.0            ***
// *******************************************
// ***     Copyright (c) Dirk Vollmar      ***
// ***             2004 / 2010             ***
// ***          joomla@vollmar.ws          ***
// ***         All rights reserved         ***
// *******************************************
// *     Released under GNU/GPL License      *
// *  http://www.gnu.org/licenses/gpl.html   *
// *******************************************

function com_uninstall() {
  $lang = JFactory::getLanguage();
  $sprache = strtolower(substr($lang->getName(),0,2));
  switch($sprache) {
    case "de":
      $html = "<b><i>Seminar f&uuml;r joomla!</i> wurde erfolgreich deinstalliert.</b>";
      break;
    default:
      $html = "<b><i>Seminar for joomla!</i> has been uninstalled.</b>";
      break;
  }
  echo $html;
}

?>