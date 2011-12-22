<?php

//*******************************************
//***         Seminar for joomla!         ***
//***            Version 1.4.0            ***
//*******************************************
//***     Copyright (c) Dirk Vollmar      ***
//***                 2011                ***
//***         seminar@vollmar.ws          ***
//***         All rights reserved         ***
//*******************************************
//*     Released under GNU/GPL License      *
//*  http://www.gnu.org/licenses/gpl.html   *
//*******************************************

function com_install() {
  $database = &JFactory::getDBO();
  if (file_exists(JPATH_ADMINISTRATOR."/components/com_joomfish/config.joomfish.php")) {
    rename(JPATH_ADMINISTRATOR."/components/com_seminar/joomfish/jf_seminar.xml",JPATH_ADMINISTRATOR."/components/com_joomfish/contentelements/seminar.xml");
  } 
  $update = "";

// Upgrade V1.25
  $database->setQuery("SELECT gmaploc FROM #__seminar");
  if (!$database->query()) {
    $database->setQuery("ALTER table #__seminar ADD paid INT(11) NOT NULL DEFAULT '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD gmaploc VARCHAR(120) NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__sembookings ADD nrbooked INT(11) NOT NULL DEFAULT '1'");
    $database->query();
    $update = " - Upgrade";
  }

// Upgrade V1.26
  $database->setQuery("SELECT nrbooked FROM #__seminar");
  if (!$database->query()) {
    $database->setQuery("ALTER table #__seminar ADD nrbooked INT(5) NOT NULL DEFAULT '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz1 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz2 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz3 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz4 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz5 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__sembookings ADD zusatz1 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__sembookings ADD zusatz2 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__sembookings ADD zusatz3 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__sembookings ADD zusatz4 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__sembookings ADD zusatz5 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $update = " - Upgrade";
  }

// Upgrade V1.27
  $database->setQuery("SELECT image FROM #__seminar");
  if (!$database->query()) {
    $database->setQuery("ALTER table #__seminar ADD image VARCHAR(120) NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz6 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz7 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz8 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz9 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz10 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD cancelled TINYINT(1) NOT NULL DEFAULT '0'");
    $database->query();
    $database->setQuery("ALTER table #__sembookings ADD zusatz6 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__sembookings ADD zusatz7 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__sembookings ADD zusatz8 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__sembookings ADD zusatz9 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__sembookings ADD zusatz10 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__sembookings ADD name TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__sembookings ADD email TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER TABLE #__seminar MODIFY target varchar(255)");
    $database->query();
    $update = " - Upgrade";
  }

// Upgrade V1.28 und V1.29
  $database->setQuery("SELECT zusatz11 FROM #__seminar");
  if (!$database->query()) {
    $database->setQuery("ALTER table #__seminar ADD zusatz11 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz12 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz13 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz14 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz15 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz16 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz17 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz18 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz19 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz20 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__sembookings ADD zusatz11 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__sembookings ADD zusatz12 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__sembookings ADD zusatz13 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__sembookings ADD zusatz14 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__sembookings ADD zusatz15 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__sembookings ADD zusatz16 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__sembookings ADD zusatz17 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__sembookings ADD zusatz18 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__sembookings ADD zusatz19 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__sembookings ADD zusatz20 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz1hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz2hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz3hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz4hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz5hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz6hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz7hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz8hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz9hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz10hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz11hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz12hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz13hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz14hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz15hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz16hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz17hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz18hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz19hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz20hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz1show TINYINT(1) NOT NULL DEFAULT '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz2show TINYINT(1) NOT NULL DEFAULT '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz3show TINYINT(1) NOT NULL DEFAULT '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz4show TINYINT(1) NOT NULL DEFAULT '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz5show TINYINT(1) NOT NULL DEFAULT '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz6show TINYINT(1) NOT NULL DEFAULT '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz7show TINYINT(1) NOT NULL DEFAULT '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz8show TINYINT(1) NOT NULL DEFAULT '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz9show TINYINT(1) NOT NULL DEFAULT '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz10show TINYINT(1) NOT NULL DEFAULT '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz11show TINYINT(1) NOT NULL DEFAULT '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz12show TINYINT(1) NOT NULL DEFAULT '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz13show TINYINT(1) NOT NULL DEFAULT '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz14show TINYINT(1) NOT NULL DEFAULT '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz15show TINYINT(1) NOT NULL DEFAULT '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz16show TINYINT(1) NOT NULL DEFAULT '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz17show TINYINT(1) NOT NULL DEFAULT '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz18show TINYINT(1) NOT NULL DEFAULT '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz19show TINYINT(1) NOT NULL DEFAULT '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz20show TINYINT(1) NOT NULL DEFAULT '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD showbegin TINYINT(1) NOT NULL DEFAULT '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD showend TINYINT(1) NOT NULL DEFAULT '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD showbooked TINYINT(1) NOT NULL DEFAULT '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar MODIFY title varchar(255)");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD pattern VARCHAR(100) NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD file1 VARCHAR(100) NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD file2 VARCHAR(100) NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD file3 VARCHAR(100) NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD file4 VARCHAR(100) NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD file5 VARCHAR(100) NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD file1desc VARCHAR(255) NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD file2desc VARCHAR(255) NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD file3desc VARCHAR(255) NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD file4desc VARCHAR(255) NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD file5desc VARCHAR(255) NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD file1down TINYINT(1) NOT NULL DEFAULT '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD file2down TINYINT(1) NOT NULL DEFAULT '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD file3down TINYINT(1) NOT NULL DEFAULT '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD file4down TINYINT(1) NOT NULL DEFAULT '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD file5down TINYINT(1) NOT NULL DEFAULT '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD file1code MEDIUMTEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD file2code MEDIUMTEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD file3code MEDIUMTEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD file4code MEDIUMTEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD file5code MEDIUMTEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD updated timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP");
    $database->query();
    $database->setQuery("ALTER table #__sembookings ADD updated timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP");
    $database->query();
    $database->setQuery("SELECT * FROM #__seminar");
    $rows = $database->loadObjectList();
    foreach($rows AS $row) {
      $zusaetze = array($row->zusatz1,$row->zusatz2,$row->zusatz3,$row->zusatz4,$row->zusatz5,$row->zusatz6,$row->zusatz7,$row->zusatz8,$row->zusatz9,$row->zusatz10);
      $optional = array($row->zusatz1opt,$row->zusatz2opt,$row->zusatz3opt,$row->zusatz4opt,$row->zusatz5opt,$row->zusatz6opt,$row->zusatz7opt,$row->zusatz8opt,$row->zusatz9opt,$row->zusatz10opt);
      for($i=0;$i<count($zusaetze);$i++) {
        if($zusaetze[$i]!="") {
          $zusart = explode("|",$zusaetze[$i]);
          $zusart = array_merge(array_slice($zusart, 0, 1), array($optional[$i],""), array_slice($zusart, 1));
          $zusaetze[$i] = implode("|",$zusart);
        }
      }
      $database->setQuery( "UPDATE #__seminar SET zusatz1='$zusaetze[0]', zusatz2='$zusaetze[1]', zusatz3='$zusaetze[2]', zusatz4='$zusaetze[3]', zusatz5='$zusaetze[4]', zusatz6='$zusaetze[5]', zusatz7='$zusaetze[6]', zusatz8='$zusaetze[7]', zusatz9='$zusaetze[8]', zusatz10='$zusaetze[9]' WHERE id='$row->id'" );
      $database->query();
    }
    $database->setQuery("ALTER table #__seminar DROP COLUMN zusatz1opt");
    $database->query();
    $database->setQuery("ALTER table #__seminar DROP COLUMN zusatz2opt");
    $database->query();
    $database->setQuery("ALTER table #__seminar DROP COLUMN zusatz3opt");
    $database->query();
    $database->setQuery("ALTER table #__seminar DROP COLUMN zusatz4opt");
    $database->query();
    $database->setQuery("ALTER table #__seminar DROP COLUMN zusatz5opt");
    $database->query();
    $database->setQuery("ALTER table #__seminar DROP COLUMN zusatz6opt");
    $database->query();
    $database->setQuery("ALTER table #__seminar DROP COLUMN zusatz7opt");
    $database->query();
    $database->setQuery("ALTER table #__seminar DROP COLUMN zusatz8opt");
    $database->query();
    $database->setQuery("ALTER table #__seminar DROP COLUMN zusatz9opt");
    $database->query();
    $database->setQuery("ALTER table #__seminar DROP COLUMN zusatz10opt");
    $database->query();
    @unlink(JPATH_ADMINISTRATOR."/components/com_seminar/toolbar.seminar.php");
    @unlink(JPATH_ADMINISTRATOR."/components/com_seminar/toolbar.seminar.html.php");
    @unlink(JPATH_SITE."/components/com_seminar/seminar.0.css");
    @unlink(JPATH_SITE."/components/com_seminar/seminar.1.css");
    $update = " - Upgrade";
  }
// Upgrade V1.3.0
  $database->setQuery("SELECT request1 FROM #__seminar");
  if (!$database->query()) {
    $database->setQuery("ALTER table #__seminar `payctrl` int(10) unsigned NOT NULL DEFAULT '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz1nl TINYINT(1) NOT NULL DEFAULT '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz2nl TINYINT(1) NOT NULL DEFAULT '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz3nl TINYINT(1) NOT NULL DEFAULT '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz4nl TINYINT(1) NOT NULL DEFAULT '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz5nl TINYINT(1) NOT NULL DEFAULT '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz6nl TINYINT(1) NOT NULL DEFAULT '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz7nl TINYINT(1) NOT NULL DEFAULT '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz8nl TINYINT(1) NOT NULL DEFAULT '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz9nl TINYINT(1) NOT NULL DEFAULT '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz10nl TINYINT(1) NOT NULL DEFAULT '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz11nl TINYINT(1) NOT NULL DEFAULT '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz12nl TINYINT(1) NOT NULL DEFAULT '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz13nl TINYINT(1) NOT NULL DEFAULT '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz14nl TINYINT(1) NOT NULL DEFAULT '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz15nl TINYINT(1) NOT NULL DEFAULT '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz16nl TINYINT(1) NOT NULL DEFAULT '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz17nl TINYINT(1) NOT NULL DEFAULT '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz18nl TINYINT(1) NOT NULL DEFAULT '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz19nl TINYINT(1) NOT NULL DEFAULT '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD zusatz20nl TINYINT(1) NOT NULL DEFAULT '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request1 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request2 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request3 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request4 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request5 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request6 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request7 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request8 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request9 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request10 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request1hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request2hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request3hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request4hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request5hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request6hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request7hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request8hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request9hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request10hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request1show TINYINT(1) NOT NULL default '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request2show TINYINT(1) NOT NULL default '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request3show TINYINT(1) NOT NULL default '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request4show TINYINT(1) NOT NULL default '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request5show TINYINT(1) NOT NULL default '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request6show TINYINT(1) NOT NULL default '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request7show TINYINT(1) NOT NULL default '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request8show TINYINT(1) NOT NULL default '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request9show TINYINT(1) NOT NULL default '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request10show TINYINT(1) NOT NULL default '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request1nl TINYINT(1) NOT NULL default '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request2nl TINYINT(1) NOT NULL default '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request3nl TINYINT(1) NOT NULL default '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request4nl TINYINT(1) NOT NULL default '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request5nl TINYINT(1) NOT NULL default '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request6nl TINYINT(1) NOT NULL default '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request7nl TINYINT(1) NOT NULL default '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request8nl TINYINT(1) NOT NULL default '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request9nl TINYINT(1) NOT NULL default '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request10nl TINYINT(1) NOT NULL default '1'");
    $database->query();
  }
  $database->setQuery("SELECT request11 FROM #__seminar");
  if (!$database->query()) {
    $database->setQuery("ALTER table #__seminar ADD request11 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request12 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request13 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request14 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request15 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request16 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request17 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request18 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request19 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request20 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request11hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request12hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request13hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request14hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request15hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request16hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request17hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request18hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request19hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request20hint TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request11show TINYINT(1) NOT NULL default '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request12show TINYINT(1) NOT NULL default '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request13show TINYINT(1) NOT NULL default '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request14show TINYINT(1) NOT NULL default '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request15show TINYINT(1) NOT NULL default '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request16show TINYINT(1) NOT NULL default '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request17show TINYINT(1) NOT NULL default '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request18show TINYINT(1) NOT NULL default '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request19show TINYINT(1) NOT NULL default '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request20show TINYINT(1) NOT NULL default '0'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request11nl TINYINT(1) NOT NULL default '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request12nl TINYINT(1) NOT NULL default '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request13nl TINYINT(1) NOT NULL default '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request14nl TINYINT(1) NOT NULL default '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request15nl TINYINT(1) NOT NULL default '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request16nl TINYINT(1) NOT NULL default '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request17nl TINYINT(1) NOT NULL default '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request18nl TINYINT(1) NOT NULL default '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request19nl TINYINT(1) NOT NULL default '1'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD request20nl TINYINT(1) NOT NULL default '1'");
    $database->query();
  }
  $database->setQuery("SELECT request11 FROM #__semattendees");
  if (!$database->query()) {
    $database->setQuery("ALTER table #__semattendees ADD request11 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__semattendees ADD request12 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__semattendees ADD request13 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__semattendees ADD request14 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__semattendees ADD request15 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__semattendees ADD request16 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__semattendees ADD request17 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__semattendees ADD request18 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__semattendees ADD request19 TEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__semattendees ADD request20 TEXT NOT NULL DEFAULT ''");
    $database->query();
  }
  $database->setQuery("SELECT booked FROM #__semlayouts");
  if (!$database->query()) {
    $database->setQuery("ALTER table #__semlayout ADD booked MEDIUMTEXT NOT NULL DEFAULT ''");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD pubbegin DATETIME NOT NULL default '2000-01-01 00:00:00'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD pubend DATETIME NOT NULL default '2000-01-01 00:00:00'");
    $database->query();
    $database->setQuery("ALTER table #__seminar ADD prebooked INT(5) NOT NULL default '0'");
    $database->query();
    $database->setQuery("UPDATE #__seminar SET pubend = end");
    $database->query();
    $database->setQuery("ALTER table #__sembookings ADD paiddate DATETIME NOT NULL default '2000-01-01 00:00:00'");
    $database->query();
    $database->setQuery("ALTER table #__sembookings ADD uniqid TEXT NOT NULL DEFAULT ''");
    $database->query();
  }
// uniqids ergaenzen
  $database->setQuery("SELECT * FROM #__sembookings WHERE uniqid IS NULL OR uniqid=''");
  $rows = $database->loadObjectList();
  foreach ($rows AS $row) {
    $database->setQuery("UPDATE #__sembookings SET uniqid='".md5(uniqid(mt_rand(),true))."' WHERE id='".$row->id."'");
    $database->query();
  }
// Werte im Layout vorbelegen
  $database->setQuery("SELECT * FROM #__semlayouts");
  $anzahl = $database->loadObjectList();
  if(count($anzahl)<1) {
    $database->setQuery("INSERT INTO #__semlayouts (`id`, `chosen`, `title`, `overview_event_header`, `overview_nr_of_events`, `overview_event`, `overview_event_footer`, `overview_booking_header`, `overview_nr_of_bookings`, `overview_booking`, `overview_booking_footer`, `overview_offer_header`, `overview_nr_of_offers`, `overview_offer`, `overview_offer_footer`, `event`, `booking`, `booked`, `certificate`) VALUES (1, 1, 'Standard', '<table cellpadding=\"2\" width=\"100%\">\r\n<tr>\r\n<td class=\"sem_cat_title\">SEM_TAB_TITLE</td>\r\n</tr>[sem_tabdescription]\r\n<tr>\r\n<td class=\"sem_cat_desc\">SEM_TAB_DESCRIPTION</td>\r\n</tr>[/sem_tabdescription]\r\n</table>\r\n<table cellpadding=\"2\" width=\"100%\">\r\n<tr>\r\n<td class=\"sem_nav\" style=\"text-align:left;\">SEM_TAB_NUMBER</td>\r\n<td class=\"sem_nav\" style=\"text-align:center;\">SEM_TAB_SEARCH</td>\r\n<td class=\"sem_nav\" style=\"text-align:center;\">SEM_TAB_CATEGORIES</td>\r\n<td class=\"sem_nav\" style=\"text-align:right;\">SEM_TAB_RESET</td>\r\n</tr>\r\n</table>[sem_tabnavigation]\r\n<table cellpadding=\"2\" width=\"100%\">\r\n<tr>\r\n<td class=\"sem_nav\">SEM_TAB_NAVIGATION</td>\r\n</tr>\r\n</table>[/sem_tabnavigation]', 2, '<table>\r\n<tr>\r\n<td>SEM_IMAGESTATUS1LINK</td>\r\n<td width=\"98%\">\r\n[sem_fee]<span class=\"SEM_CSS_FEE\">SEM_CURRENCY SEM_FEE</span>[/sem_fee]\r\n[sem_displaybegin]<span class=\"sem_date\">SEM_BEGIN_OVERVIEW</span>\r\n[sem_canceled]\r\n<span class=\"sem_cancelled\"> - SEM_CANCELED_EXPR</span>\r\n[/sem_canceled]\r\n<br />[/sem_displaybegin]SEM_TITLELINK<br />\r\n<span class=\"sem_shortdesc\">SEM_SHORTDESCRIPTION</span><br />\r\n<span class=\"sem_cat\">\r\n[sem_displayclosing][sem_bookableonline]\r\n[sem_!booked]SEM_CLOSING_EXPR: SEM_CLOSING_OVERVIEW[/sem_!booked]\r\n[sem_booked]SEM_BOOKINGDATE_EXPR: SEM_BOOKINGDATE_OVERVIEW[/sem_booked]\r\n[/sem_bookableonline][/sem_displayclosing]\r\n[sem_!bookableonline]SEM_NOTBOOKABLEONLINE_EXPR[/sem_!bookableonline]\r\n</span><br />\r\n<span class=\"sem_cat\">SEM_CATEGORY_EXPR: SEM_CATEGORY\r\n[sem_bookableonline] - SEM_BOOKEDSPACES_EXPR: SEM_BOOKEDSPACES - SEM_FREESPACES_EXPR: SEM_FREESPACES[/sem_bookableonline] \r\n- SEM_HITS_EXPR: SEM_HITS</span></td>\r\n<td align=\"center\">\r\n[sem_bookableonline]SEM_STATUSIMAGE2[/sem_bookableonline]\r\n[sem_!bookableonline]<div style=\"width:18px\"> </div>[/sem_!bookableonline]\r\n</td>\r\n</tr>\r\n</table>', '[sem_tabevents]\r\n<table cellpadding=\"2\" width=\"100%\">\r\n[sem_tabnavigation]\r\n<tr>\r\n<td class=\"sem_nav\">SEM_TAB_NAVIGATION</td>\r\n</tr>\r\n[/sem_tabnavigation]\r\n<tr>\r\n<td class=\"sem_nav\">SEM_TAB_LEGEND</td>\r\n</tr>\r\n</table>\r\n[/sem_tabevents]', '<table cellpadding=\"2\" width=\"100%\">\r\n<tr>\r\n<td class=\"sem_cat_title\">SEM_TAB_TITLE</td>\r\n</tr>\r\n[sem_tabdescription]\r\n<tr>\r\n<td class=\"sem_cat_desc\">SEM_TAB_DESCRIPTION</td>\r\n</tr>\r\n[/sem_tabdescription]\r\n</table>\r\n<table cellpadding=\"2\" width=\"100%\">\r\n<tr>\r\n<td class=\"sem_nav\" style=\"text-align:left;\">SEM_TAB_NUMBER</td>\r\n<td class=\"sem_nav\" style=\"text-align:center;\">SEM_TAB_SEARCH</td>\r\n<td class=\"sem_nav\" style=\"text-align:center;\">SEM_TAB_TYPES</td>\r\n<td class=\"sem_nav\" style=\"text-align:right;\">SEM_TAB_RESET</td>\r\n</tr>\r\n</table>\r\n[sem_tabnavigation]\r\n<table cellpadding=\"2\" width=\"100%\">\r\n<tr>\r\n<td class=\"sem_nav\">SEM_TAB_NAVIGATION</td>\r\n</tr>\r\n</table>\r\n[/sem_tabnavigation]', 1, '<table>\r\n<tr>\r\n<td>SEM_IMAGESTATUS1LINK</td>\r\n<td width=\"98%\">\r\n[sem_fee]<span class=\"SEM_CSS_FEE\">SEM_CURRENCY SEM_FEE</span>[/sem_fee]\r\n[sem_displaybegin]<span class=\"sem_date\">SEM_BEGIN_OVERVIEW</span>\r\n[sem_canceled]\r\n<span class=\"sem_cancelled\"> - SEM_CANCELED_EXPR</span>\r\n[/sem_canceled]\r\n<br />[/sem_displaybegin]\r\nSEM_TITLELINK\r\n<br />\r\n<span class=\"sem_shortdesc\">SEM_SHORTDESCRIPTION</span>\r\n<br />\r\n[sem_displayclosing]\r\n<span class=\"sem_cat\">SEM_BOOKINGDATE_EXPR: SEM_BOOKINGDATE_OVERVIEW</span>\r\n<br />\r\n[/sem_displayclosing]\r\n<span class=\"sem_cat\">SEM_CATEGORY_EXPR: SEM_CATEGORY - SEM_BOOKEDSPACES_EXPR: SEM_BOOKEDSPACES - SEM_FREESPACES_EXPR: SEM_FREESPACES - SEM_HITS_EXPR: SEM_HITS</span>\r\n</td>\r\n[sem_certificated]\r\n<td>SEM_CERTIFICATED_IMAGE_PRINT</td>\r\n[/sem_certificated]\r\n<td align=\"center\">SEM_BUTTON_ATTENDEES\r\n[sem_ended]\r\n<div style=\"padding-top:5px;text-align:center;\">SEM_FEEDBACK</div>\r\n[/sem_ended]\r\n</td>\r\n<td align=\"center\">SEM_STATUSIMAGE2</td>\r\n</tr>\r\n</table>', '[sem_tabevents]\r\n<table cellpadding=\"2\" width=\"100%\">\r\n[sem_tabnavigation]\r\n<tr>\r\n<td class=\"sem_nav\">SEM_TAB_NAVIGATION</td>\r\n</tr>\r\n[/sem_tabnavigation]\r\n<tr>\r\n<td class=\"sem_nav\">SEM_TAB_LEGEND</td>\r\n</tr>\r\n</table>\r\n[/sem_tabevents]', '<table cellpadding=\"2\" width=\"100%\">\r\n<tr>\r\n<td class=\"sem_cat_title\">SEM_TAB_TITLE</td>\r\n</tr>\r\n[sem_tabdescription]\r\n<tr>\r\n<td class=\"sem_cat_desc\">SEM_TAB_DESCRIPTION</td>\r\n</tr>\r\n[/sem_tabdescription]\r\n</table>\r\n<table cellpadding=\"2\" width=\"100%\">\r\n<tr>\r\n<td class=\"sem_nav\" style=\"text-align:left;\">SEM_TAB_NUMBER</td>\r\n<td class=\"sem_nav\" style=\"text-align:center;\">SEM_TAB_SEARCH</td>\r\n<td class=\"sem_nav\" style=\"text-align:center;\">SEM_TAB_TYPES</td>\r\n<td class=\"sem_nav\" style=\"text-align:right;\">SEM_TAB_RESET</td>\r\n</tr>\r\n</table>\r\n[sem_tabnavigation]\r\n<table cellpadding=\"2\" width=\"100%\">\r\n<tr>\r\n<td class=\"sem_nav\">SEM_TAB_NAVIGATION</td>\r\n</tr>\r\n</table>\r\n[/sem_tabnavigation]', 1, '<table>\r\n<tr>\r\n<td>SEM_IMAGESTATUS1LINK</td>\r\n<td width=\"98%\">\r\n[sem_fee]\r\n<span class=\"SEM_CSS_FEE\">SEM_CURRENCY SEM_FEE</span>\r\n[/sem_fee]\r\n[sem_displaybegin]\r\n<span class=\"sem_date\">SEM_BEGIN_OVERVIEW</span>\r\n[sem_canceled]\r\n<span class=\"sem_cancelled\"> - SEM_CANCELED_EXPR</span>\r\n[/sem_canceled]\r\n<br />[/sem_displaybegin]\r\nSEM_TITLELINK\r\n<br />\r\n<span class=\"sem_shortdesc\">SEM_SHORTDESCRIPTION</span>\r\n<br />\r\n<span class=\"sem_cat\">[sem_displayclosing][sem_bookableonline]\r\nSEM_CLOSING_EXPR: SEM_CLOSING_OVERVIEW\r\n[/sem_bookableonline][/sem_displayclosing][sem_!bookableonline]SEM_NOTBOOKABLEONLINE_EXPR[/sem_!bookableonline]</span>\r\n<br />\r\n<span class=\"sem_cat\">SEM_CATEGORY_EXPR: SEM_CATEGORY - SEM_BOOKEDSPACES_EXPR: SEM_BOOKEDSPACES - SEM_FREESPACES_EXPR: SEM_FREESPACES - SEM_HITS_EXPR: SEM_HITS</span>\r\n</td>\r\n<td align=\"center\">\r\nSEM_BUTTON_ATTENDEES\r\n[sem_ended]\r\n<div style=\"padding-top:5px;text-align:center;\">SEM_FEEDBACK</div>\r\n[/sem_ended]\r\n</td>\r\n<td align=\"center\">SEM_STATUSIMAGE2</td>\r\n</tr>\r\n</table>', '[sem_tabevents]\r\n<table cellpadding=\"2\" width=\"100%\">\r\n[sem_tabnavigation]\r\n<tr>\r\n<td class=\"sem_nav\">SEM_TAB_NAVIGATION</td>\r\n</tr>\r\n[/sem_tabnavigation]\r\n<tr>\r\n<td class=\"sem_nav\">SEM_TAB_LEGEND</td>\r\n</tr>\r\n</table>\r\n[/sem_tabevents]', '<table cellpadding=\"4\" width=\"100%\">\r\n<tr><td class=\"sem_cat_title\" colspan=\"2\">SEM_TITLE[sem_canceled] <span class=\"sem_cancelled\"> - SEM_CANCELED_EXPR</span>[/sem_canceled]</td></tr>\r\n<tr><td class=\"sem_cat_desc\" colspan=\"2\">\r\n[sem_description]SEM_DESCRIPTION[/sem_description]\r\n[sem_!description]SEM_SHORTDESCRIPTION[/sem_!description]\r\n</td></tr>\r\n<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_NUMBER_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_NUMBER</td>\r\n</tr>\r\n<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_STATUS_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_STATUS</td>\r\n</tr>\r\n[sem_displaybegin]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_BEGIN_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_BEGIN_DETAIL</td>\r\n</tr>[/sem_displaybegin]\r\n[sem_displayend]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_END_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_END_DETAIL</td>\r\n</tr>[/sem_displayend]\r\n[sem_displayclosing][sem_bookableonline]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_CLOSING_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_CLOSING_DETAIL</td>\r\n</tr>[/sem_bookableonline][/sem_displayclosing]\r\n[sem_!bookableonline]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"100%\" colspan=\"2\">SEM_NOTBOOKABLEONLINE_EXPR</td>\r\n</tr>[/sem_!bookableonline]\r\n[sem_tutor]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_TUTOR_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_TUTOR</td>\r\n</tr>[/sem_tutor]\r\n[sem_targetgroup]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_TARGETGROUP_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_TARGETGROUP</td>\r\n</tr>[/sem_targetgroup]\r\n<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_LOCATION_EXPR: SEM_GMAPICON</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_LOCATION</td>\r\n</tr>\r\n[sem_bookableonline]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_FREESPACES_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_FREESPACES_DIV</td>\r\n</tr>[/sem_bookableonline]\r\n[sem_fee]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_FEE_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_CURRENCY SEM_AMOUNT_DIV_INKLADD</td>\r\n</tr>[/sem_fee][sem_files]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_FILES_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_FILES</td>\r\n</tr>[/sem_files][sem_bookableonline][sem_attendeeinput]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_ATTENDEEINPUT_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_ATTENDEEINPUT</td>\r\n</tr>[/sem_attendeeinput][sem_bookerinput]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_BOOKERINPUT_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_BOOKERINPUT</td>\r\n</tr>[/sem_bookerinput][sem_!logedin]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_CAPTCHA_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_CAPTCHA</td>\r\n</tr>[/sem_!logedin][sem_tandc]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:center;\" width=\"100%\" colspan=\"2\">SEM_TANDC</td>\r\n</tr>[/sem_tandc][sem_requiredfields]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:right;\" width=\"100%\" colspan=\"2\">SEM_REQUIREDFIELDS_EXPR</td>\r\n</tr>[/sem_requiredfields][/sem_bookableonline]\r\n</table>', '<table cellpadding=\"4\" width=\"100%\">\r\n<tr><td class=\"sem_cat_title\" colspan=\"2\">SEM_TITLE[sem_canceled] <span class=\"sem_cancelled\"> - SEM_CANCELED_EXPR</span>[/sem_canceled]</td></tr>\r\n<tr><td class=\"sem_cat_desc\" colspan=\"2\">\r\n[sem_description]SEM_DESCRIPTION[/sem_description]\r\n[sem_!description]SEM_SHORTDESCRIPTION[/sem_!description]\r\n</td></tr>\r\n<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_NUMBER_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_NUMBER</td>\r\n</tr>\r\n<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_STATUS_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_STATUS</td>\r\n</tr>\r\n<tr><td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_BOOKINGDATE_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_BOOKINGDATE_DETAIL</td>\r\n</tr>[sem_displaybegin]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_BEGIN_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_BEGIN_DETAIL</td>\r\n</tr>[/sem_displaybegin]\r\n[sem_displayend]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_END_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_END_DETAIL</td>\r\n</tr>[/sem_displayend]\r\n[sem_displayclosing][sem_bookableonline]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_CLOSING_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_CLOSING_DETAIL</td>\r\n</tr>[/sem_bookableonline][/sem_displayclosing]\r\n[sem_!bookableonline]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"100%\" colspan=\"2\">SEM_NOTBOOKABLEONLINE_EXPR</td>\r\n</tr>[/sem_!bookableonline]\r\n[sem_tutor]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_TUTOR_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_TUTOR</td>\r\n</tr>[/sem_tutor]\r\n[sem_targetgroup]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_TARGETGROUP_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_TARGETGROUP</td>\r\n</tr>[/sem_targetgroup]\r\n<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_LOCATION_EXPR: SEM_GMAPICON</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_LOCATION</td>\r\n</tr>\r\n[sem_bookableonline]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_FREESPACES_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_FREESPACES_DIV</td>\r\n</tr>[/sem_bookableonline]\r\n[sem_fee]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_FEE_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_CURRENCY SEM_AMOUNT_DIV_INKLADD</td>\r\n</tr>[/sem_fee][sem_files]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_FILES_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_FILES</td>\r\n</tr>[/sem_files][sem_bookableonline][sem_attendeeinput]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_ATTENDEEINPUT_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_ATTENDEEINPUT</td>\r\n</tr>[/sem_attendeeinput][sem_bookerinput]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_BOOKERINPUT_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_BOOKERINPUT</td>\r\n</tr>[/sem_bookerinput][sem_tandc]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:center;\" width=\"100%\" colspan=\"2\">SEM_TANDC</td>\r\n</tr>[/sem_tandc][sem_requiredfields]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:right;\" width=\"100%\" colspan=\"2\">SEM_REQUIREDFIELDS_EXPR</td>\r\n</tr>[/sem_requiredfields][/sem_bookableonline]\r\n</table>', '<table cellpadding=\"4\" width=\"100%\">\r\n<tr><td class=\"sem_cat_title\" colspan=\"2\">SEM_TITLE[sem_canceled] <span class=\"sem_cancelled\"> - SEM_CANCELED_EXPR</span>[/sem_canceled]</td></tr>\r\n<tr><td class=\"sem_cat_desc\" colspan=\"2\">\r\n[sem_description]SEM_DESCRIPTION[/sem_description]\r\n[sem_!description]SEM_SHORTDESCRIPTION[/sem_!description]\r\n</td></tr>\r\n<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_NUMBER_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_NUMBER</td>\r\n</tr>\r\n<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_STATUS_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_STATUS</td>\r\n</tr>\r\n[sem_displaybegin]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_BEGIN_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_BEGIN_DETAIL</td>\r\n</tr>[/sem_displaybegin]\r\n[sem_displayend]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_END_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_END_DETAIL</td>\r\n</tr>[/sem_displayend]\r\n[sem_displayclosing][sem_bookableonline]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_CLOSING_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_CLOSING_DETAIL</td>\r\n</tr>[/sem_bookableonline][/sem_displayclosing]\r\n[sem_!bookableonline]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"100%\" colspan=\"2\">SEM_NOTBOOKABLEONLINE_EXPR</td>\r\n</tr>[/sem_!bookableonline]\r\n[sem_tutor]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_TUTOR_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_TUTOR</td>\r\n</tr>[/sem_tutor]\r\n[sem_targetgroup]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_TARGETGROUP_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_TARGETGROUP</td>\r\n</tr>[/sem_targetgroup]\r\n<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_LOCATION_EXPR: SEM_GMAPICON</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_LOCATION</td>\r\n</tr>\r\n[sem_bookableonline]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_FREESPACES_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_FREESPACES</td>\r\n</tr>[/sem_bookableonline]\r\n[sem_fee]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_FEE_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_CURRENCY SEM_AMOUNT_INKLADD</td>\r\n</tr>[/sem_fee][sem_files]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_FILES_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_FILES</td>\r\n</tr>[/sem_files][sem_attendeeinput]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_ATTENDEEINPUT_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_ATTENDEEINPUT_VALUES</td>\r\n</tr>[/sem_attendeeinput][sem_bookerinput]<tr>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"20%\">SEM_BOOKERINPUT_EXPR:</td>\r\n<td class=\"sem_rowd\" style=\"text-align:left;\" width=\"80%\">SEM_BOOKERINPUT_VALUES</td>\r\n</tr>[/sem_bookerinput]</table>', '<div style=\"position: absolute; top:0; left:0; z-index: 0;\"><img src=\"SEM_IMAGEDIR1certificate.png\" /></div><div style=\"position: absolute; top:0; left:0; z-index: 1;\"><table width=\"734pt\" height=\"1080pt\"><tr><td width=\"180pt\" height=\"1080pt\" rowspan=\"8\"> </td><th width=\"554pt\" height=\"150pt\"><span style=\"color: #330099; font-size: 48pt; font-family: Verdana;\">Zertifikat</span></th></tr><tr><th width=\"554pt\" height=\"150pt\"><span style=\"color: #000000; font-size: 28pt; font-family: Verdana;\">SEM_NAME</span></center></th></tr><tr><td width=\"554pt\" height=\"100pt\"><span style=\"color: #000000; font-size: 24pt; font-family: Verdana;\">hat erfolgreich an der Veranstaltung</span></td></tr><tr><th width=\"554pt\" height=\"150pt\"><span style=\"color: #000000; font-size: 28pt; font-family: Verdana;\">SEM_TITLE</span></th></tr><tr><td width=\"554pt\" height=\"100pt\"><span style=\"color: #000000; font-size: 24pt; font-family: Verdana;\">teilgenommen.</span></td></tr><tr><td width=\"554pt\" height=\"230pt\"><span style=\"color: #000000; font-size: 18pt; font-family: Verdana; \">SEM_BEGIN_EXPR: SEM_BEGIN</span><p style=\"margin-top: 20pt; margin-bottom: 8pt;\" /><span style=\"color: #000000; font-size: 18pt; font-family: Verdana; \">SEM_END_EXPR: SEM_END</span><p style=\"margin-top: 20pt; margin-bottom: 8pt;\" /><span style=\"color: #000000; font-size: 18pt; font-family: Verdana; \">SEM_LOCATION_EXPR: SEM_LOCATION</span></td></tr><tr><td width=\"554pt\" height=\"100pt\"><span style=\"color: #000000; font-size: 18pt; font-family: Verdana; \">SEM_TUTOR_EXPR: SEM_TUTOR</span></td></tr><tr><td width=\"554pt\" height=\"100pt\"><span style=\"color: #000000; font-size: 18pt; font-family: Verdana; \">SEM_DATE_EXPR: SEM_TODAY</span></td></tr></table></div>')");
    $database->query();
  }
// Werte der E-Mails vorbelegen
  $database->setQuery("SELECT * FROM #__sememails");
  $anzahl = $database->loadObjectList();
  if(count($anzahl)<1) {
    $database->setQuery("INSERT INTO #__sememails (`id`, `chosen`, `title`, `new`, `new_type`, `changed`, `changed_type`, `unpublished_recent`, `unpublished_recent_type`, `unpublished_over`, `unpublished_over_type`, `republished_recent`, `republished_recent_type`, `republished_over`, `republished_over_type`, `booked`, `booked_type`, `canceled`, `canceled_type`, `bookingchanged`, `bookingchanged_type`, `paid`, `paid_type`, `unpaid`, `unpaid_type`, `certificated`, `certificated_type`, `uncertificated`, `uncertificated_type`) VALUES (1, 1, 'Standard', 'SEM_EMAILTEXT\r\n\r\nSEM_TITLE_EXPR: SEM_TITLE\r\n\r\nSEM_SHORTDESCRIPTION_NOTAGS\r\n\r\n[sem_displaybegin]\r\nSEM_BEGIN_EXPR: SEM_BEGIN\r\n[/sem_displaybegin][sem_displayend]SEM_END_EXPR: SEM_END\r\n[/sem_displayend][sem_displayclosing]SEM_CLOSING_EXPR: SEM_CLOSING\r\n[/sem_displayclosing]\r\nSEM_CATEGORY_EXPR: SEM_CATEGORY[sem_bookableonline]\r\nSEM_FREESPACES_EXPR: SEM_FREESPACES[/sem_bookableonline]', 0, 'SEM_EMAILTEXT\r\n\r\nSEM_TITLE_EXPR: SEM_TITLE\r\n\r\nSEM_SHORTDESCRIPTION_NOTAGS\r\n\r\n[sem_displaybegin]\r\nSEM_BEGIN_EXPR: SEM_BEGIN\r\n[/sem_displaybegin][sem_displayend]SEM_END_EXPR: SEM_END\r\n[/sem_displayend][sem_displayclosing]SEM_CLOSING_EXPR: SEM_CLOSING\r\n[/sem_displayclosing]\r\nSEM_CATEGORY_EXPR: SEM_CATEGORY[sem_bookableonline]\r\nSEM_FREESPACES_EXPR: SEM_FREESPACES[/sem_bookableonline]', 0, 'SEM_EMAILTEXT\r\n\r\nSEM_STATUS', 0, '0', 0, 'SEM_EMAILTEXT\r\n\r\nSEM_STATUS', 0, '0', 0, '', 0, '', 0, '', 0, '', 0, '', 0, '', 0, '', 0)");
    $database->query();
  }

  $imagedir = "../components/com_seminar/images/";
  $lang = JFactory::getLanguage();
  $sprache = strtolower(substr($lang->getName(),0,2));
  $html = "<img src=\"".$imagedir."menulogo.png\" valign=\"middle\"><font size=\"+1\" color=\"#0B55C4\"> Seminar".$update."</font>";
  $html .= "<div align=\"center\"><table border=\"0\" width=\"90%\"><tbody>";
  $html .= "<tr><td width=\"18%\"><b>Autor:</b></td><td width=\"80%\">Dirk Vollmar</td></tr>";
  $html .= "<tr><td width=\"18%\"><b>Internet:</b></td><td width=\"80%\"><a target=\"_blank\" href=\"http://seminar.vollmar.ws\">http://seminar.vollmar.ws</a></td></tr>";
  $html .= "<tr><td width=\"18%\"><b>Version:</b></td><td width=\"80%\">1.4 BETA (1.3.91)</td></tr>";
  switch($sprache) {
    case "de":
      $html .= "<tr><td colspan=\"2\">";
      $html .= "Mit <i>Seminar f&uuml;r Joomla!</i> haben Sie sich f&uuml;r ein leistungsstarkes Buchungssystem f&uuml;r Ihre joomla!-Seite entschieden. "; 
      $html .= "Egal, ob Sie Fortbildungen anbieten, Ihr Verein Ausfl&uuml;ge veranstaltet oder Sie zu einer Party einladen m&ouml;chten: Mit <i>Seminar für joomla!</i> ist die Verwaltung der Veranstaltungen kein Problem. <p>";
      if($upgrade=="") {
        $html .= "<font color=\"#FF0000\">Bevor Sie die ersten Kurse eingeben, sollten Sie &uuml;ber die Parameter die gew&uuml;nschten Funktionen freischalten (Versand von Best&auml;tigungs-E-Mails, Bewertungssystem, Zertifizierungssystem, etc.).</font><p>";
      } else {
        $html .= "<font color=\"#FF0000\">Da viele neue Parameter hinzugekommen sind, überprüfen Sie bitte als erstes die Einstellungen von Seminar.</font><p>";
      }
      $html .= "<i>Seminar f&uuml;r joomla!</i> wurde unter der <a href=\"http://www.gnu.org/licenses/gpl.html\" target=\"_new\">GNU General Public License</a> ver&ouml;ffentlicht.<p>";
      $html .= "<b>Neu in Version 1.4</b><p>";
      $html .= "<ul>";
      $html .= "<li>Die grundlegenden Datumsformate werden durch die Sprachdateien festgelegt. Darüberhinaus können Sie aber durch Angaben in den Einstellungen überschrieben werden.";
      $html .= "<li>Die Bezahlung der Seminare kann mit PayPal durchgeführt werden.";
      $html .= "<li>Bei den Vorbelegungen der zusätzlichen Eingabefelder können die Werte aus \"JomSocial\", \"Community Builder\" und \"Community Builder Enhanced\" entnommen werden."; 
      $html .= "<li>Bei jeder Veranstaltung kann die Zahl der \"vorgebuchten Plätze\" festgelegt werden, dadurch ist es möglich, durch eine einfach Zahleingabe z. B. 4 als bereits gebucht festzulegen. So kann man das händische Buchen von \"Dummies\" z. B. bei paralleler Telefonbuchung umgehen.  Diese Angabe ist natürlich zu jedem Zeitpunkt änderbar."; 
      $html .= "<li>Der Zeitraum der Veröffentlichung einer Veranstaltung kann nun frei gewählt werden. Alternativ können die Zeiträume \"Jetzt bis Beginn\", \"Jetzt bis Ende\" oder \"Jetzt bis Anmeldeschluss\" eingestellt werden."; 
      $html .= "<li>Die Tags zur Steuerung der Ansicht von Inhalten wurden komplett überarbeitet und erheblich erweitert."; 
      $html .= "<li>Die CSS-Dateien können nun direkt in den Einstellungen bearbeitet werden."; 
      $html .= "<li>Die Inhalte und das Aussehen der E-Mails können frei konfiguriert werden. Zahlreiche weitere E-Mail sind hinzugekommen."; 
      $html .= "<li>Alle Bildschirmdarstellungen können nun mittels HTML/XML, Steuertags, Variablen und Konstanten frei definiert werden. So ist das Aussehen und die angezeigten Inhalte von Seminar auf nahezu jeden Wunsch anpassbar."; 
      $html .= "<li>Im Backendbereich wurde ein Kontrollzentrum eingebaut. Dort gibt es unter anderem eine Versionüberprüfung, die ein Herunterladen einer neuen Version bzw. eine direkte Installation des Updates ermöglicht."; 
      $html .= "<li>Im Modul können nun auch die zugehörigen Kategorie- oder Veranstaltungsbilder angezeigt werden. Auch eine Statusgrafik wie in der Komponente (Veranstaltung, Meine Buchungen, Meine Angebote) kann eingeblendet werden."; 
      $html .= "<li>Im Modul kann nach \"alle Veranstaltungen\", \"Meine Buchungen\" und \"Meine Veranstaltungen\" unterschieden werden. Die Verlinkung führt zur Veranstaltung im zugehörigen Bereich."; 
      $html .= "<li>Das Trennzeichen beim CSV-Export der Teilnehmerdaten kann beliebig festgelegt werden."; 
      $html .= "<li>Jede automatisch verschickte Mail kann zusätzlich an eine beliebige, in den Einstellungen festgelegte Adresse verschickt werden."; 
      $html .= "<li>Ein Benutzer kann nun für andere Personen Plätze buchen, ohne selbst Teilnehmer sein zu müssen. Dabei können zusätzliche Eingabefelder für jeden Teilnehmer abgefragt werden."; 
      $html .= "<li>Auch ein einfacher registrierter Benutzer kann Veranstaltungen eingeben und verwalten, falls dies in den Einstellungen erlaubt wurde. Somit kann nun jeder Benutzertyp als Veranstalter festgelegt werden."; 
      $html .= "<li>Der Kalender des Moduls kann in einem Ajax-Frame angezeigt werden. Dadurch kann der Kalender durchgeblättert werden, ohne dass die gesamte Seite neu geladen wird."; 
      $html .= "<li>In den Einstellungen kann festgelegt werden, welche Knöpfe (Benutzername vergessen, Kennwort vergessen, Registrieren) beim Anmeldeformular angezeigt werden sollen."; 
      $html .= "</ul>";
      $html .= "<font color=\"#FF0000\">Diese BETA-Version ist NICHT für den Produktiveinsatz verwendbar! Diese BETA-Version dient nur der Fehlerfindung!</font><p>";
      $html .= "</td>";
      break;
    default:
      $html .= "<tr><td colspan=\"2\">";
      $html .= "Please fill in the parameters first.<p>";
      $html .= "<i>Seminar for joomla!</i> has been released under the <a href=\"http://www.gnu.org/licenses/gpl.html\" target=\"_new\">GNU general public license</a>.<p>";
      $html .= "</td>";
      break;
  }
  $html .= "</tr></tbody></table></div>";
  echo $html;
}

?>
