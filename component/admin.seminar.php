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
defined('_JEXEC') or die('Restricted access');
require_once(JApplicationHelper::getPath('admin_html'));
require_once(JApplicationHelper::getPath('class'));
$document = &JFactory::getDocument();
$document->addCustomTag("<link rel=\"stylesheet\" href=\"components/".JRequest::getCmd('option')."/css/icon.css\" type=\"text/css\" />");
$mainframe = JFactory::getApplication();
$task = trim(JRequest::getVar('task','show'));
$cid = JRequest::getVar('cid', array(0));
$uid = JRequest::getVar('uid', array(0));

// ++++++++++++++++++++++++++++++++++
// +++ Auswahl der Aktion         +++
// ++++++++++++++++++++++++++++++++++

switch ($task) {
  case "10":
// Neue Veranstaltung erstellen
    sem_g006(0,2);
    break;

  case "11":
// Neue Vorlage erstellen
    sem_g006(0,3);
    break;

  case "12":
// Veranstaltung bearbeiten
    sem_g006($cid[0],2);
    break;

  case "13":
// Vorlage bearbeiten
    sem_g006($cid[0],3);
    break;

  case "14":
// Veranstaltung speichern
    sem_g007(2);
    break;

  case "15":
// Vorlage speichern
    sem_g007(3);
    break;

  case "16":
// Veranstaltung loeschen
    sem_g023($cid,2);
    break;

  case "17":
// Vorlage loeschen
    sem_g023($cid,3);
    break;

  case "18":
// Veranstaltung publishen
    sem_g024($cid,1,2);
    break;

  case "19":
// Vorlage publishen
    sem_g024($cid,1,3);
    break;

  case "20":
// Veranstaltung unpublishen
    sem_g024($cid,0,2);
    break;

  case "21":
// Vorlage unpublishen
    sem_g024($cid,0,3);
    break;

  case "22":
// Veranstaltung duplizieren
    sem_g009($cid,2);
    break;

  case "23":
// Vorlage duplizieren
    sem_g009($cid,3);
    break;

  case "24":
// Kurs absagen
    sem_g025($cid,1);
    break;

  case "25":
// Absage zuruecknehmen
    sem_g025($cid,0);
    break;

  case "26":
// Teilnehmer zertifizieren
    sem_g013($cid,$uid);
    break;

  case "27":
// Bezahlung markieren
    sem_g012($cid,$uid);
    break;

  case "2":
// Veranstaltungsuebersicht anzeigen
    sem_g027();
    break;

  case "28":
// Buchung loeschen
    sem_g028($cid,$uid);
    break;

  case "29":
// Teilnehmer anzeigen
    sem_g029($uid);
    break;

  case "4":
// Gesamtstatistik anzeigen
    sem_g030();
    break;

  case "30":
// Einzelstatistik anzeigen
    sem_g031();
    break;

  case "36":
// Veranstaltungen drucken
    sem_g018();
    break;

  case "35":
// Zertifikat drucken
    sem_g019($uid);
    break;

  case "34":
// Teilnehmerliste drucken
    sem_f052(4);
    break;

  case "33":
// Unterschriftenliste drucken
    sem_f052(3);
    break;

  case "32":
// CSV-Datei herunterladen
    sem_f048();
    break;

  case "1":
// Vorlagenuebersicht anzeigen 
    sem_g032();
    break;

  case "3":
// Einstellungen anzeigen
    sem_g033();
    break;

  case "31":
// Eintellungen speichern
    sem_g034();
    break;

  default:
// Veranstaltungsuebersicht anzeigen
    sem_g027();
    break;
}

echo sem_f062()."\n<br />".sem_f028();

// ++++++++++++++++++++++++++++++++++
// +++ Kurse editieren            +++
// ++++++++++++++++++++++++++++++++++

function sem_g006($uid,$art) {
  if($art==2) {
    if($uid==0) {
      TOOLBAR_seminar::_NEW();
    } else {
      TOOLBAR_seminar::_EDIT();
    }
  } else {
    if($uid==0) {
      TOOLBAR_seminar::_TNEW();
    } else {
      TOOLBAR_seminar::_TEDIT();
    }
  }
  $database = &JFactory::getDBO();
  $my = &JFactory::getuser();

  $vorlage = JRequest::getInt('vorlage',0);
  if($vorlage>0) {
    $uid = $vorlage;
  }

  $args = func_get_args();
  if(count($args)>2) {
    $row = $args[2];
  } else {
    $row = new mosSeminar($database);
    $row->load($uid);
  }

  if($vorlage>0) {
    $row->id = "";
    $row->pattern = "";
  }
  $row->vorlage = $vorlage;

// Zeit festlegen
  if ($uid==0) {
    $row->begin = date( "Y-m-d" )." 14:00:00";
    $row->end = date( "Y-m-d" )." 17:00:00";
    $row->booked = date( "Y-m-d" )." 12:00:00";
    $row->publisher = $my->id;
    $row->semnum = sem_f064(date('Y'));
  }
  $zeit = explode(" ",$row->begin);
  $row->begin_date = $zeit[0];
  $zeit = explode(":",$zeit[1]);
  $row->begin_hour = $zeit[0];
  $row->begin_minute = $zeit[1];
  $zeit = explode(" ",$row->end);
  $row->end_date = $zeit[0];
  $zeit = explode(":",$zeit[1]);
  $row->end_hour = $zeit[0];
  $row->end_minute = $zeit[1];
  $zeit = explode(" ",$row->booked);
  $row->booked_date = $zeit[0];
  $zeit = explode(":",$zeit[1]);
  $row->booked_hour = $zeit[0];
  $row->booked_minute = $zeit[1];

  HTML_seminar::sem_g006($row,$art);
}

// ++++++++++++++++++++++++++++++++++
// +++ Kurs speichern             +++
// ++++++++++++++++++++++++++++++++++

function sem_g007($art) {
  $database = &JFactory::getDBO();
  $config = &JComponentHelper::getParams('com_seminar');
  $caid = JRequest::getInt('caid',0);
  $cancel = JRequest::getInt('cancel',0);
  $inform = JRequest::getInt('inform',0);
  $infotext = sem_f018(JRequest::getVar('infotext',''));
  $deldatei1 = JRequest::getVar('deldatei1',0);
  $deldatei2 = JRequest::getVar('deldatei2',0);
  $deldatei3 = JRequest::getVar('deldatei3',0);
  $deldatei4 = JRequest::getVar('deldatei4',0);
  $deldatei5 = JRequest::getVar('deldatei5',0);
  $vorlage = JRequest::getInt('vorlage',0);
  $id = JRequest::getInt('id',0);
  $neudatum = sem_f046();

// Zeit formatieren
  $_begin_date = JRequest::getVar('_begin_date','0000-00-00');
  $_begin_hour= JRequest::getVar('_begin_hour','00');
  $_begin_minute = JRequest::getVar('_begin_minute','00');
  $_end_date = JRequest::getVar('_end_date','0000-00-00');
  $_end_hour= JRequest::getVar('_end_hour','00');
  $_end_minute = JRequest::getVar('_end_minute','00');
  $_booked_date = JRequest::getVar('_booked_date','0000-00-00');
  $_booked_hour= JRequest::getVar('_booked_hour','00');
  $_booked_minute = JRequest::getVar('_booked_minute','00');

  if($id>0) {
    $kurs = new mosSeminar($database);
    $kurs->load($id);
  }
  if($vorlage>0) {
    $kurs = new mosSeminar($database);
    $kurs->load($vorlage);
  }
  $post = JRequest::get('post');
  $post['description'] = JRequest::getVar('description', '', 'post', 'string', JREQUEST_ALLOWHTML);
  $row = new mosSeminar($database);
  $row->load($cid);
  if (!$row->bind($post)) {
    return JError::raiseError( 500, $row->getError() );
    exit();
  }
// Zuweisung der aktuellen Zeit
  if($id==0) {
    $row->publishdate = $neudatum;
  }
  $row->updated = $neudatum;
  if($cancel!=$row->cancelled) {
    $tempmail = 9 + $cancel;
    $database->setQuery( "SELECT * FROM #__sembookings WHERE semid='$row->id'" );
    $rows = $database->loadObjectList();
    for ($i=0, $n=count($rows); $i < $n; $i++) {
      sem_f050($row->id, $rows[$i]->id, $tempmail);
    }
  }
  $row->cancelled = $cancel;
  $row->catid = $caid;

// Zuweisung der Startzeit
  if (intval( $_begin_date )) {
      $dt = "$_begin_date $_begin_hour:$_begin_minute:00";
  } else {
    $dt = date( "Y-m-d 14:00:00" );
  }
  $row->begin = strftime( "%Y-%m-%d %H:%M:%S", strtotime( $dt ) );

// Zuweisung der Endzeit
  if (intval( $_end_date)) {
      $dt = "$_end_date $_end_hour:$_end_minute:00";
  } else {
    $dt = date( "Y-m-d 17:00:00" );
  }
  $row->end = strftime( "%Y-%m-%d %H:%M:%S", strtotime( $dt ) );

// Zuweisung der Buchungszeit
  if (intval( $_booked_date)) {
      $dt = "$_booked_date $_booked_hour:$_booked_minute:00";
  } else {
    $dt = date( "Y-m-d 12:00:00" );
  }
  $row->booked = strftime( "%Y-%m-%d %H:%M:%S", strtotime( $dt ) );

// neue Daten eintragen
  $row->description = str_replace('<br>','<br />',$row->description);
  $row->description = str_replace('\"','"',$row->description);
  $row->description = str_replace("\'","'",$row->description);
  $row->semnum = sem_f018($row->semnum);
  $row->title = sem_f018($row->title);
  $row->target = sem_f018($row->target);
  $row->shortdesc = sem_f018($row->shortdesc);
  $row->place = sem_f018($row->place);
  $row->fees = str_replace(",",".",sem_f018($row->fees));
  $row->maxpupil = sem_f018($row->maxpupil);
  $row->gmaploc = sem_f018($row->gmaploc);
  $row->nrbooked = sem_f018($row->nrbooked);
  $row->zusatz1 = sem_f018($row->zusatz1);
  $row->zusatz2 = sem_f018($row->zusatz2);
  $row->zusatz3 = sem_f018($row->zusatz3);
  $row->zusatz4 = sem_f018($row->zusatz4);
  $row->zusatz5 = sem_f018($row->zusatz5);
  $row->zusatz6 = sem_f018($row->zusatz6);
  $row->zusatz7 = sem_f018($row->zusatz7);
  $row->zusatz8 = sem_f018($row->zusatz8);
  $row->zusatz9 = sem_f018($row->zusatz9);
  $row->zusatz10 = sem_f018($row->zusatz10);
  $row->zusatz11 = sem_f018($row->zusatz11);
  $row->zusatz12 = sem_f018($row->zusatz12);
  $row->zusatz13 = sem_f018($row->zusatz13);
  $row->zusatz14 = sem_f018($row->zusatz14);
  $row->zusatz15 = sem_f018($row->zusatz15);
  $row->zusatz16 = sem_f018($row->zusatz16);
  $row->zusatz17 = sem_f018($row->zusatz17);
  $row->zusatz18 = sem_f018($row->zusatz18);
  $row->zusatz19 = sem_f018($row->zusatz19);
  $row->zusatz20 = sem_f018($row->zusatz20);
  $row->zusatz1hint = sem_f018($row->zusatz1hint);
  $row->zusatz2hint = sem_f018($row->zusatz2hint);
  $row->zusatz3hint = sem_f018($row->zusatz3hint);
  $row->zusatz4hint = sem_f018($row->zusatz4hint);
  $row->zusatz5hint = sem_f018($row->zusatz5hint);
  $row->zusatz6hint = sem_f018($row->zusatz6hint);
  $row->zusatz7hint = sem_f018($row->zusatz7hint);
  $row->zusatz8hint = sem_f018($row->zusatz8hint);
  $row->zusatz9hint = sem_f018($row->zusatz9hint);
  $row->zusatz10hint = sem_f018($row->zusatz10hint);
  $row->zusatz11hint = sem_f018($row->zusatz11hint);
  $row->zusatz12hint = sem_f018($row->zusatz12hint);
  $row->zusatz13hint = sem_f018($row->zusatz13hint);
  $row->zusatz14hint = sem_f018($row->zusatz14hint);
  $row->zusatz15hint = sem_f018($row->zusatz15hint);
  $row->zusatz16hint = sem_f018($row->zusatz16hint);
  $row->zusatz17hint = sem_f018($row->zusatz17hint);
  $row->zusatz18hint = sem_f018($row->zusatz18hint);
  $row->zusatz19hint = sem_f018($row->zusatz19hint);
  $row->zusatz20hint = sem_f018($row->zusatz20hint);
  $row->file1desc = sem_f018($row->file1desc);
  $row->file2desc = sem_f018($row->file2desc);
  $row->file3desc = sem_f018($row->file3desc);
  $row->file4desc = sem_f018($row->file4desc);
  $row->file5desc = sem_f018($row->file5desc);
  if($row->id>0 OR $vorlage>0) {
    if($deldatei1!=1) {
      $row->file1 = $kurs->file1;
      $row->file1code = $kurs->file1code;
    }
    if($deldatei2!=1) {
      $row->file2 = $kurs->file2;
      $row->file2code = $kurs->file2code;
    }
    if($deldatei3!=1) {
      $row->file3 = $kurs->file3;
      $row->file3code = $kurs->file3code;
    }
    if($deldatei4!=1) {
      $row->file4 = $kurs->file4;
      $row->file4code = $kurs->file4code;
    }
    if($deldatei5!=1) {
      $row->file5 = $kurs->file5;
      $row->file5code = $kurs->file5code;
    }
  }
  if($row->id>0) {
    $row->hits = $kurs->hits;
  }
	$fileext = explode(' ',strtolower($config->get('sem_p057','txt zip pdf')));
  $filesize = $config->get('sem_p056',200)*1024; 
  $fehler = array('','','','','','','','','','');
  if(is_file($_FILES['datei1']['tmp_name']) AND $_FILES['datei1']['size']>0) {
    if($_FILES['datei1']['size']>$filesize) {
      $fehler[0] = str_replace("SEM_FILE",$_FILES['datei1']['name'],JTEXT::_('SEM_0141'));
    }
		$datei1ext = array_pop(explode( ".",strtolower($_FILES['datei1']['name'])));
  	if(!in_array($datei1ext,$fileext)) {
      $fehler[1] = str_replace("SEM_FILE",$_FILES['datei1']['name'],JTEXT::_('SEM_0142'));
    }
    if($fehler[0]=="" AND $fehler[1]=="") {
      $row->file1 = $_FILES['datei1']['name'];
      $row->file1code = base64_encode(file_get_contents($_FILES['datei1']['tmp_name']));
    }
  }
  if(is_file($_FILES['datei2']['tmp_name']) AND $_FILES['datei2']['size']>0) {
    if($_FILES['datei2']['size']>$filesize) {
      $fehler[2] = str_replace("SEM_FILE",$_FILES['datei2']['name'],JTEXT::_('SEM_0141'));
    }
		$datei2ext = array_pop(explode( ".",strtolower($_FILES['datei2']['name'])));
  	if(!in_array($datei2ext,$fileext)) {
      $fehler[3] = str_replace("SEM_FILE",$_FILES['datei2']['name'],JTEXT::_('SEM_0142'));
    }
    if($fehler[2]=="" AND $fehler[3]=="") {
      $row->file2 = $_FILES['datei2']['name'];
      $row->file2code = base64_encode(file_get_contents($_FILES['datei2']['tmp_name']));
    }
  }
  if(is_file($_FILES['datei3']['tmp_name']) AND $_FILES['datei3']['size']>0) {
    if($_FILES['datei3']['size']>$filesize) {
      $fehler[4] = str_replace("SEM_FILE",$_FILES['datei3']['name'],JTEXT::_('SEM_0141'));
    }
		$datei3ext = array_pop(explode( ".",strtolower($_FILES['datei3']['name'])));
  	if(!in_array($datei3ext,$fileext)) {
      $fehler[5] = str_replace("SEM_FILE",$_FILES['datei3']['name'],JTEXT::_('SEM_0142'));
    }
    if($fehler[4]=="" AND $fehler[5]=="") {
      $row->file3 = $_FILES['datei3']['name'];
      $row->file3code = base64_encode(file_get_contents($_FILES['datei3']['tmp_name']));
    }
  }
  if(is_file($_FILES['datei4']['tmp_name']) AND $_FILES['datei4']['size']>0) {
    if($_FILES['datei4']['size']>$filesize) {
      $fehler[6] = str_replace("SEM_FILE",$_FILES['datei4']['name'],JTEXT::_('SEM_0141'));
    }
		$datei4ext = array_pop(explode( ".",strtolower($_FILES['datei4']['name'])));
  	if(!in_array($datei4ext,$fileext)) {
      $fehler[7] = str_replace("SEM_FILE",$_FILES['datei4']['name'],JTEXT::_('SEM_0142'));
    }
    if($fehler[6]=="" AND $fehler[7]=="") {
      $row->file4 = $_FILES['datei4']['name'];
      $row->file4code = base64_encode(file_get_contents($_FILES['datei4']['tmp_name']));
    }
  }
  if(is_file($_FILES['datei5']['tmp_name']) AND $_FILES['datei5']['size']>0) {
    if($_FILES['datei5']['size']>$filesize) {
      $fehler[8] = str_replace("SEM_FILE",$_FILES['datei5']['name'],JTEXT::_('SEM_0141'));
    }
		$datei5ext = array_pop(explode( ".",strtolower($_FILES['datei5']['name'])));
  	if(!in_array($datei5ext,$fileext)) {
      $fehler[9] = str_replace("SEM_FILE",$_FILES['datei5']['name'],JTEXT::_('SEM_0142'));
    }
    if($fehler[8]=="" AND $fehler[9]=="") {
      $row->file5 = $_FILES['datei5']['name'];
      $row->file5code = base64_encode(file_get_contents($_FILES['datei5']['tmp_name']));
    }
  }

// Eingaben ueberpruefen
  $speichern = TRUE;
  if($art==3) {
    if(!sem_f067($row->pattern,'leer')) {
      $speichern = FALSE;
      $fehler[] = JTEXT::_('SEM_2044');
    }
  } else {
    if(!sem_f067($row->semnum,'leer') OR !sem_f067($row->title,'leer') OR $row->catid==0 OR !sem_f067($row->shortdesc,'leer') OR !sem_f067($row->place,'leer')) {
      $speichern = FALSE;
      $fehler[] = JTEXT::_('SEM_2044');
    } elseif(!sem_f067($row->maxpupil,'nummer') OR !sem_f067($row->nrbooked,'nummer')) {
      $speichern = FALSE;
      $fehler[] = JTEXT::_('SEM_2045');
    } else {
      $database->setQuery("SELECT id FROM #__seminar WHERE semnum='$row->semnum' AND id!='$row->id'");
      $rows = $database->loadObjectList();
      if(count($rows)>0) {
        $speichern = FALSE;
        $htxt = JTEXT::_('SEM_0151');
        if($id<1) {
          $htxt .= " ".JTEXT::_('SEM_0152');
        }
        $fehler[] = $htxt;
      }
    }
  }

// Kurs speichern
  if($speichern==TRUE) {
    if (!$row->check()) {
      JError::raiseError( 500, $database->stderr() );
      return false;
    }
    if (!$row->store()) {
      JError::raiseError( 500, $database->stderr() );
      return false;
    }
    $row->checkin();
    $row->reorder( "catid='$row->catid'" );
  }
// Ausgabe der Kurse
  $fehlerzahl = array_unique($fehler);
  if (count($fehlerzahl)>1) {
    $fehler = array_unique($fehler);
    if($fehler[0]=="") {
      $fehler = array_slice($fehler,1);
    }
    $fehler = implode("<br />",$fehler);
    JError::raiseWarning(1,$fehler);
  }
// Ausgabe der Kurse
  if(count($fehlerzahl)>1 AND $speichern == TRUE) {
    sem_g006($row->id,$art);
  } elseif (count($fehlerzahl)>1 AND $speichern == FALSE) {
    sem_g006($row->id,$art,$row);
  } else {
    if($art==2) {
      sem_g027();
    } else {
      sem_g032();
    }
  }
}

// ++++++++++++++++++++++++++++++++++
// +++ Seminar kopieren           +++
// ++++++++++++++++++++++++++++++++++

function sem_g009($cid,$art) {
  $database = &JFactory::getDBO();
  if (count( $cid )) {
    $cids = implode( ',', $cid );
    $database->setQuery( "SELECT * FROM #__seminar WHERE id IN ($cids)" );
    $rows = $database->loadObjectList();
    if ($database->getErrorNum()) {
      JError::raiseError(500,$database->stderr());
      exit();
    }
    foreach ($rows as $item) {
      $row = new mosseminar( $database );
      if (!$row->bind( $item )) {
        JError::raiseError( 500, $row->getError() );
        exit();
      }
      $row->id = NULL;
      $row->hits = 0;
      $row->grade = 0;
      $row->certificated = 0;
      $row->sid = $item->id;
      $unique = "";
      if($art==2) {
        $unique = sem_f064(date('Y'));
      }
      $row->semnum = $unique;
      if (!$row->check()) {
        JError::raiseError( 500, $row->getError() );
        return false;
      }
      if (!$row->store()) {
        JError::raiseError( 500, $row->getError() );
        return false;
      }
    }
  }
  if($art==2) {
    sem_g027();
  } else {
    sem_g032();
  }
}

// ++++++++++++++++++++++++++++++++++
// +++ Kursuebersicht anzeigen    +++
// ++++++++++++++++++++++++++++++++++

function sem_g027() {
  TOOLBAR_seminar::_EVENTS();
  $database = &JFactory::getDBO();
  jimport('joomla.html.pagination');
  $katid = JRequest::getInt('katid',0);
  $ordid = JRequest::getInt('ordid',0);
  $ricid = JRequest::getInt('ricid',0);
  $einid = JRequest::getInt('einid',0);
  $search = JRequest::getVar('search','');
  $limit = JRequest::getInt('limit',5);
  $limitstart = JRequest::getInt('limitstart',0);
  $neudatum = sem_f046();

  $where = array();
  $where[] = "a.pattern = ''";

  if ($katid > 0) {
    $where[] = "a.catid='$katid'";
  }
  if ($search) {
    $where[] = "LOWER(a.title) LIKE '%$search%' OR LOWER(a.shortdesc) LIKE '%$search%' OR LOWER(a.description) LIKE '%$search%'";
  }
  switch ($einid) {
    case "1":
      $where[] = "a.published = '1'";
      break;
    case "2":
      $where[] = "a.published = '0'";
      break;
    case "3":
      $where[] = "a.end > '$neudatum'";
      break;
    case "4":
      $where[] = "a.end <= '$neudatum'";
      break;
  }

  $sorte = array("a.semnum","a.id","a.title","category","a.begin","a.end","a.booked","a.certificated","a.grade","a.maxpupil","a.hits");
  $richt = array(" ASC"," DESC");

  // get the total number of records
  $database->setQuery( "SELECT count(*) FROM #__seminar AS a"
    . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
  );
  $total = $database->loadResult();
  if( $total<=$limitstart ) {
    $limitstart = $limitstart - $limit;    
  }
  if( $limitstart < 0) {
    $limitstart = 0;
  }
  $ttlimit = "";
  if($limit > 0) {
    $ttlimit = "\nLIMIT $limitstart, $limit";
  }

  $pageNav = new JPagination( $total, $limitstart, $limit );

  $database->setQuery( "SELECT a.*, cc.title AS category, u.name AS editor"
    . "\nFROM #__seminar AS a"
    . "\nLEFT JOIN #__categories AS cc ON cc.id = a.catid"
    . "\nLEFT JOIN #__users AS u ON u.id = a.checked_out"
    . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
    . "\nORDER BY " . $sorte[$ordid] . $richt[$ricid]
    . $ttlimit
  );
  $rows = $database->loadObjectList();

  // get list of categories
  $kategorien[] = JHTML::_('select.option', '0', JTEXT::_('SEM_0027') );
  $database->setQuery( "SELECT id AS value, title AS text FROM #__categories WHERE section='com_seminar' ORDER BY ordering" );
  $kategorien = array_merge( $kategorien, $database->loadObjectList() );
  $clist = JHTML::_('select.genericlist', $kategorien, 'katid', 'class="inputbox" size="1" onchange="document.adminForm.limitstart.value=0;document.adminForm.submit();"',
    'value', 'text', $katid );

  $sortierung[] = JHTML::_('select.option', '0', JTEXT::_('SEM_0003') );
  $sortierung[] = JHTML::_('select.option', '1', JTEXT::_('SEM_0057') );
  $sortierung[] = JHTML::_('select.option', '2', JTEXT::_('SEM_0007') );
  $sortierung[] = JHTML::_('select.option', '3', JTEXT::_('SEM_0008') );
  $sortierung[] = JHTML::_('select.option', '4', JTEXT::_('SEM_0009') );
  $sortierung[] = JHTML::_('select.option', '5', JTEXT::_('SEM_0010') );
  $sortierung[] = JHTML::_('select.option', '6', JTEXT::_('SEM_0011') );
  $sortierung[] = JHTML::_('select.option', '7', JTEXT::_('SEM_0040') );
  $sortierung[] = JHTML::_('select.option', '8', JTEXT::_('SEM_0055') );
  $sortierung[] = JHTML::_('select.option', '9', JTEXT::_('SEM_0020') );
  $sortierung[] = JHTML::_('select.option', '10', JTEXT::_('SEM_0058') );
  $olist = JHTML::_('select.genericlist', $sortierung, 'ordid', 'class="inputbox" size="1" onchange="document.adminForm.limitstart.value=0;document.adminForm.submit();"',
    'value', 'text', $ordid );

  $richtung[] = JHTML::_('select.option', '0', JTEXT::_('SEM_2004') );
  $richtung[] = JHTML::_('select.option', '1', JTEXT::_('SEM_2005') );
  $rlist = JHTML::_('select.genericlist', $richtung, 'ricid', 'class="inputbox" size="1" onchange="document.adminForm.limitstart.value=0;document.adminForm.submit();"',
    'value', 'text', $ricid );

  $allekurse[] = JHTML::_('select.option', '0', JTEXT::_('SEM_0028') );
  $allekurse[] = JHTML::_('select.option', '1', JTEXT::_('SEM_2014') );
  $allekurse[] = JHTML::_('select.option', '2', JTEXT::_('SEM_2021') );
  $allekurse[] = JHTML::_('select.option', '3', JTEXT::_('SEM_0039') );
  $allekurse[] = JHTML::_('select.option', '4', JTEXT::_('SEM_0037') );
  $elist = JHTML::_('select.genericlist', $allekurse, 'einid', 'class="inputbox" size="1" onchange="document.adminForm.limitstart.value=0;document.adminForm.submit();"',
    'value', 'text', $einid );
  
  $listen = array($clist, $olist, $rlist, $elist);

  HTML_seminar::sem_g027($rows,$listen,$search,$pageNav,$limitstart,$limit);
}

// ++++++++++++++++++++++++++++++++++++
// +++ Kurse oder Vorlagen loeschen +++
// ++++++++++++++++++++++++++++++++++++

function sem_g023($cid,$art) {
  $database = &JFactory::getDBO();
  if (count( $cid )) {
    $cids = implode( ',', $cid );
    if($art==2) {
      $database->setQuery( "SELECT * FROM #__sembookings WHERE semid IN ($cids)" );
      $rows = $database->loadObjectList();
      if ($database->getErrorNum()) {
        JError::raiseError(500,$database->stderr());
        exit();
      }
      foreach ($rows AS $row) {
        sem_f050( $row->semid, $row->id, 4);
      }
      $database->setQuery( "DELETE FROM #__sembookings WHERE semid IN ($cids)" );
      if (!$database->query()) {
        JError::raiseError(500,$database->stderr());
        exit();
      }
    }
    $database->setQuery( "DELETE FROM #__seminar WHERE id IN ($cids)" );
    if (!$database->query()) {
      JError::raiseError(500,$database->stderr());
      exit();
    }
  }
  if($art==2) {
    sem_g027();
  } else {
    sem_g032();
  }
}

// ++++++++++++++++++++++++++++++++++
// +++ Kurse veroeffentlichen     +++
// ++++++++++++++++++++++++++++++++++

function sem_g024($cid,$publish,$art) {
  $database = &JFactory::getDBO();
  $catid = JRequest::getVar('catid',array(0));

  if (count( $cid )) {
    $cids = implode( ',', $cid );
    if($art==2) {
      $database->setQuery( "SELECT * FROM #__sembookings WHERE semid IN ($cids)" );
      $rows = $database->loadObjectList();
      if ($database->getErrorNum()) {
        JError::raiseError(500,$database->stderr());
        exit();
      }
      foreach ($rows AS $row) {
        If($publish==0) {
         sem_f050( $row->semid, $row->id, 4);
        } else {
         sem_f050( $row->semid, $row->id, 5);
        }
      }
    }
    $database->setQuery( "UPDATE #__seminar SET published='$publish' WHERE id IN ($cids) ");
    if (!$database->query()) {
      JError::raiseError(500,$database->stderr());
      exit();
    }
  }
  if($art==2) {
    sem_g027();
  } else {
    sem_g032();
  }
}

// ++++++++++++++++++++++++++++++++++
// +++ Kurse absagen              +++
// ++++++++++++++++++++++++++++++++++

function sem_g025($cid=null,$cancelled=1) {
  $database = &JFactory::getDBO();
  $catid = JRequest::getVar('catid',array(0));
  if (count( $cid )) {
    $cids = implode( ',', $cid );
    $database->setQuery( "SELECT * FROM #__sembookings WHERE semid IN ($cids)" );
    $rows = $database->loadObjectList();
    if ($database->getErrorNum()) {
      JError::raiseError(500,$database->stderr());
      exit();
    }
    foreach ($rows AS $row) {
      If($cancelled==0) {
       sem_f050( $row->semid, $row->id, 9);
      } else {
       sem_f050( $row->semid, $row->id, 10);
      }
    }
    $database->setQuery( "UPDATE #__seminar SET cancelled='$cancelled' WHERE id IN ($cids) ");
    if (!$database->query()) {
      JError::raiseError(500,$database->stderr());
      exit();
    }
  }
  sem_g027();
}

// +++++++++++++++++++++++++++++++++++
// +++ Teilnehmer am Kurs anzeigen +++
// +++++++++++++++++++++++++++++++++++

function sem_g029($uid) {
  TOOLBAR_seminar::_VIEW_BOOK();
  $database = &JFactory::getDBO();
  $config = &JComponentHelper::getParams('com_seminar');
  $kurs = new mosseminar( $database );
  $kurs->load( $uid );
  $database->setQuery( "SELECT a.*, cc.*, a.id AS sid, a.name AS aname, a.email AS aemail FROM #__sembookings AS a LEFT JOIN #__users AS cc ON cc.id = a.userid WHERE a.semid = '$kurs->id' ORDER BY a.id");
  $rows = $database->loadObjectList();
  HTML_seminar::sem_g029($kurs,$rows,$uid);
}

// ++++++++++++++++++++++++++++++++++
// +++ Buchungen loeschen         +++
// ++++++++++++++++++++++++++++++++++

function sem_g028($cid,$uid) {
  $mainframe = JFactory::getApplication();
  $database = &JFactory::getDBO();

// Loeschvorgang
  if (count( $cid )) {
    $cids = implode( ',', $cid );

// Zaehler der gebuchten Kurse zuruecksetzen
    $database->setQuery( "SELECT * FROM #__sembookings WHERE id IN ($cids)" );
    $rows = $database->loadObjectList();
    if ($database->getErrorNum()) {
      JError::raiseError(500,$database->stderr());
      exit();
    }
    foreach( $rows as $row) {
      sem_f050( $row->semid, $row->id, 3);
    }

// Buchung loeschen
    $database->setQuery( "DELETE FROM #__sembookings WHERE id IN ($cids)" );
    if (!$database->query()) {
      JError::raiseError(500,$database->stderr());
      exit();
    }
  }
  $mainframe->redirect( JURI::base()."index2.php?option=".JRequest::getCmd('option')."&task=29&uid=".$uid);
}

// ++++++++++++++++++++++++++++++++++
// +++ Statistik anzeigen         +++
// ++++++++++++++++++++++++++++++++++

function sem_g030() {
  TOOLBAR_seminar::_STAT();
  $database = &JFactory::getDBO();

  $startjahr = 2007;
  $stats = array();
  $mstats = array();
  $temp = array();
  $Monate = array(JTEXT::_('JANUARY'),JTEXT::_('FEBRUARY'),JTEXT::_('MARCH'),JTEXT::_('APRIL'),JTEXT::_('MAY'),JTEXT::_('JUNE'),JTEXT::_('JULY'),JTEXT::_('AUGUST'),JTEXT::_('SEPTEMBER'),JTEXT::_('OCTOBER'),JTEXT::_('NOVEMBER'),JTEXT::_('DECEMBER'));

  $stats[0]->courses = 0;
  $stats[0]->bookings = 0;
  $stats[0]->certificated = 0;
  $stats[0]->hits = 0;
  $stats[0]->maxpupil = 0;
  $stats[0]->year = JTEXT::_('SEM_2001');
  for ($i=0, $n=12; $i < $n; $i++) {
    $month = $i + 1;
    $database->setQuery( "SELECT * FROM #__seminar WHERE MONTH(begin)='$month' AND pattern = ''");
    $rows = $database->loadObjectList();
    $bookings = 0;
    $certificated = 0;
    $hits = 0;
    $maxpupil = 0;
    foreach($rows AS $row) {
      $gebucht = sem_f020($row);
      $bookings = $bookings + $gebucht->booked;
      $certificated = $certificated + $gebucht->certificated;
      $hits = $hits + $row->hits;
      $maxpupil = $maxpupil + $row->maxpupil;
    }
    $temp[$i]->courses = count($rows);
    $stats[0]->courses += $temp[$i]->courses;
    $temp[$i]->bookings = $bookings;
    $stats[0]->bookings += $temp[$i]->bookings;
    $temp[$i]->certificated = $certificated;
    $stats[0]->certificated += $temp[$i]->certificated;
    $temp[$i]->hits = $hits;
    $stats[0]->hits += $temp[$i]->hits;
    $temp[$i]->maxpupil = $maxpupil;
    $stats[0]->maxpupil += $temp[$i]->maxpupil;
    $temp[$i]->year = $Monate[$i];
  }
  $mstats[0] = $temp;

  $zaehler = 0;
  for ($i=0, $n=25; $i < $n; $i++) {
    $aktjahr = $startjahr + $i;
    $database->setQuery( "SELECT COUNT(*) AS courses FROM #__seminar WHERE YEAR(begin)='$aktjahr' AND pattern = ''" );
    $rows = $database->loadObjectList();
    if ($rows[0]->courses==0) {
      continue;
    }
    $temp = array();
    $zaehler++;
    $stats[$zaehler]->courses = 0;
    $stats[$zaehler]->bookings = 0;
    $stats[$zaehler]->certificated = 0;
    $stats[$zaehler]->hits = 0;
    $stats[$zaehler]->maxpupil = 0;
    $stats[$zaehler]->year = $aktjahr;
    for ($l=0, $m=12; $l < $m; $l++) {
      $month = $l + 1;
      $database->setQuery( "SELECT * FROM #__seminar WHERE MONTH(begin)='$month' AND YEAR(begin)='$aktjahr' AND pattern = ''");
      $rows = $database->loadObjectList();
      $bookings = 0;
      $certificated = 0;
      $hits = 0;
      $maxpupil = 0;
      foreach($rows AS $row) {
        $gebucht = sem_f020($row);
        $bookings = $bookings + $gebucht->booked;
        $certificated = $certificated + $gebucht->certificated;
        $hits = $hits + $row->hits;
        $maxpupil = $maxpupil + $row->maxpupil;
      }
      $temp[$l]->courses = count($rows);
      $stats[$zaehler]->courses += $temp[$l]->courses;
      $temp[$l]->bookings = $bookings;
      $stats[$zaehler]->bookings += $temp[$l]->bookings;
      $temp[$l]->certificated = $certificated;
      $stats[$zaehler]->certificated += $temp[$l]->certificated;
      $temp[$l]->hits = $hits;
      $stats[$zaehler]->hits += $temp[$l]->hits;
      $temp[$l]->maxpupil = $maxpupil;
      $stats[$zaehler]->maxpupil += $temp[$l]->maxpupil;
      $temp[$l]->year = $Monate[$l];
    }
    $mstats[$zaehler] = $temp;
  }

  HTML_seminar::sem_g030($stats,$mstats);
}

// +++++++++++++++++++++++++++++++++++++++++++
// +++ Teilnehmer zertifizieren            +++
// +++++++++++++++++++++++++++++++++++++++++++

function sem_g013($cid,$uid) {
  $mainframe = JFactory::getApplication();
  $database = &JFactory::getDBO();

  if (count( $cid )) {
    $cids = implode( ',', $cid );
    $database->setQuery( "SELECT * FROM #__sembookings WHERE id IN ($cids)" );
    $rows = $database->loadObjectList();
    if ($database->getErrorNum()) {
      echo $database->stderr();
      return false;
    }
    foreach( $rows as $row) {
      if($row->certificated == 0) {
        $cert = 1;
        $certmail = 6;
      } else {
        $cert = 0;
        $certmail = 7;
      }
      $database->setQuery( "UPDATE #__sembookings SET certificated='$cert' WHERE id='$row->id'");
      if (!$database->query()) {
        JError::raiseError(500,$database->stderr());
        exit();
      }
      sem_f050($row->semid, $row->id, $certmail);

    }
  }
  $mainframe->redirect( JURI::base()."index2.php?option=".JRequest::getCmd('option')."&task=29&uid=".$uid."&limit=".trim(JRequest::getVar('limit',0))."&limitstart=".trim(JRequest::getVar('limitstart',0))."&einid=".trim(JRequest::getVar('einid',0))."&katid=".trim(JRequest::getVar('katid',0))."&ordid=".trim(JRequest::getVar('ordid',0))."&ricid=".trim(JRequest::getVar('ricid',0))."&search=".trim(JRequest::getVar('search',0)));
}

// +++++++++++++++++++++++++++++++++++++++++++
// +++ Bezahlung markieren                 +++
// +++++++++++++++++++++++++++++++++++++++++++

function sem_g012($cid,$uid) {
  $mainframe = JFactory::getApplication();
  $database = &JFactory::getDBO();

  if (count( $cid )) {
    $cids = implode( ',', $cid );
    $database->setQuery( "SELECT * FROM #__sembookings WHERE id IN ($cids)" );
    $rows = $database->loadObjectList();
    if ($database->getErrorNum()) {
      JError::raiseError(500,$database->stderr());
      exit();
    }
    foreach( $rows as $row) {
      if($row->paid == 0) {
        $paid = 1;
      } else {
        $paid = 0;
      }
      $database->setQuery( "UPDATE #__sembookings SET paid='$paid' WHERE id='$row->id'");
      if (!$database->query()) {
        JError::raiseError(500,$database->stderr());
        exit();
      }
    }
  }
  $mainframe->redirect( JURI::base()."index2.php?option=".JRequest::getCmd('option')."&task=29&uid=".$uid."&limit=".trim(JRequest::getVar('limit',0))."&limitstart=".trim(JRequest::getVar('limitstart',0))."&einid=".trim(JRequest::getVar('einid',0))."&katid=".trim(JRequest::getVar('katid',0))."&ordid=".trim(JRequest::getVar('ordid',0))."&ricid=".trim(JRequest::getVar('ricid',0))."&search=".trim(JRequest::getVar('search',0)));
}

// +++++++++++++++++++++++++++++++++++++++++++++++
// +++ Statistik nach Monat - Jahr anzeigen    +++
// +++++++++++++++++++++++++++++++++++++++++++++++

function sem_g031() {
  TOOLBAR_seminar::_VIEW_STAT();
  $database = &JFactory::getDBO();

  $month = JRequest::getVar('month');
  $year = JRequest::getVar('year');
  
  $yea = $year;
  $where = array();
  $where[] = "a.pattern = ''";

  if( $year != JTEXT::_('SEM_2001') ) {
    $where[] = "YEAR(begin)='$year'";
  }
  if($month != "") {
    $where[] = "MONTH(begin)='$month'";
  }

  $database->setQuery( "SELECT a.*, cc.title AS category FROM #__seminar AS a"
    . "\nLEFT JOIN #__categories AS cc ON cc.id = a.catid"
    . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
    . "\nORDER BY a.begin"
  );

  $rows = $database->loadObjectList();
  if ($database->getErrorNum()) {
    JError::raiseError(500,$database->stderr());
    exit();
  }
  $Monate = array(JTEXT::_('JANUARY'),JTEXT::_('FEBRUARY'),JTEXT::_('MARCH'),JTEXT::_('APRIL'),JTEXT::_('MAY'),JTEXT::_('JUNE'),JTEXT::_('JULY'),JTEXT::_('AUGUST'),JTEXT::_('SEPTEMBER'),JTEXT::_('OCTOBER'),JTEXT::_('NOVEMBER'),JTEXT::_('DECEMBER'));
  if($month == "") {
    $mon = "";
  } else {
    $mon = " - " . $Monate[($month-1)];
  }
  HTML_seminar::sem_g031($rows,$mon,$yea);

}

// ++++++++++++++++++++++++++++++++++
// +++ Seminaruebersicht drucken  +++ 
// ++++++++++++++++++++++++++++++++++

function sem_g018() {
  $database = &JFactory::getDBO();
  $katid = JRequest::getInt('katid',0);
  $ordid = JRequest::getInt('ordid',0);
  $ricid = JRequest::getInt('ricid',0);
  $einid = JRequest::getInt('einid',0);
  $search = JRequest::getVar('search','');
  $limit = JRequest::getInt('limit',5);
  $limitstart = JRequest::getInt('limitstart',0);

  $neudatum = sem_f046();

  $where = array();
  $where[] = "a.pattern=''";

  if ($katid > 0) {
    $where[] = "a.catid='$katid'";
  }
  if ($search) {
    $where[] = "LOWER(a.title) LIKE '%$search%' OR LOWER(a.shortdesc) LIKE '%$search%' OR LOWER(a.description) LIKE '%$search%'";
  }
  switch ($einid) {
    case "1":
      $where[] = "a.published = '1'";
      break;
    case "2":
      $where[] = "a.published = '0'";
      break;
    case "3":
      $where[] = "a.end > '$neudatum'";
      break;
    case "4":
      $where[] = "a.end <= '$neudatum'";
      break;
  }

  $sorte = array("a.semnum","a.title","category","a.begin","a.end","a.booked","a.certificated","a.grade","a.maxpupil","a.hits");
  $richt = array(" ASC"," DESC");
  $ttlimit = "";
  if($limit > 0) {
    $ttlimit = "\nLIMIT $limitstart, $limit";
  }
  $database->setQuery( "SELECT a.*, cc.title AS category, u.name AS editor"
    . "\nFROM #__seminar AS a"
    . "\nLEFT JOIN #__categories AS cc ON cc.id = a.catid"
    . "\nLEFT JOIN #__users AS u ON u.id = a.checked_out"
    . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
    . "\nORDER BY " . $sorte[$ordid] . $richt[$ricid]
    . $ttlimit
  );
  $rows = $database->loadObjectList();
  $status = array();
  $headertext = JTEXT::_('SEM_0083');
  for ($i=0, $n=count($rows); $i < $n; $i++) {
    $row = &$rows[$i];
    $gebucht = sem_f020($row);
    $gebucht = $gebucht->booked;
    if( sem_f046() > $row->booked ) {
      $status[] = JTEXT::_('SEM_0088');
    } else if($row->maxpupil - $gebucht < 1 && $row->stopbooking == 1) {
      $status[] = JTEXT::_('SEM_0088');
    } else if($row->maxpupil - $gebucht < 1 && $row->stopbooking == 0) {
      $status[] = JTEXT::_('SEM_0036');
    } else {
       $status[] = JTEXT::_('SEM_0031');
    }
    $rows[$i]->codepic = "";
  }
  sem_f056($rows,$status);
}

// ++++++++++++++++++++++++++
// +++ Zertifikat drucken +++
// ++++++++++++++++++++++++++

function sem_g019() {
  $cid = trim(JRequest::getVar('cid',0));
  echo sem_f031();
  sem_f051($cid);
}

// +++++++++++++++++++++++++++++++++++
// +++ Vorlagenuebersicht anzeigen +++
// +++++++++++++++++++++++++++++++++++

function sem_g032() {
  TOOLBAR_seminar::_TMPL();
  $database = &JFactory::getDBO();
  jimport('joomla.html.pagination');
  $katid = JRequest::getInt('katid',0);
  $search = JRequest::getVar('search','');
  $limit = JRequest::getInt('limit',5);
  $limitstart = JRequest::getInt('limitstart',0);
  $neudatum = sem_f046();

  $where = array();
  $where[] = "a.pattern != ''";

  if ($katid > 0) {
    $where[] = "a.catid='$katid'";
  }
  if ($search) {
    $where[] = "LOWER(a.title) LIKE '%$search%' OR LOWER(a.shortdesc) LIKE '%$search%' OR LOWER(a.description) LIKE '%$search%'";
  }

  // get the total number of records
  $database->setQuery( "SELECT count(*) FROM #__seminar AS a"
    . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
  );
  $total = $database->loadResult();
  if( $total<=$limitstart ) {
    $limitstart = $limitstart - $limit;    
  }
  if( $limitstart < 0) {
    $limitstart = 0;
  }
  $ttlimit = "";
  if($limit > 0) {
    $ttlimit = "\nLIMIT $limitstart, $limit";
  }

  $pageNav = new JPagination( $total, $limitstart, $limit );

  $database->setQuery( "SELECT a.*, cc.title AS category, u.name AS editor"
    . "\nFROM #__seminar AS a"
    . "\nLEFT JOIN #__categories AS cc ON cc.id = a.catid"
    . "\nLEFT JOIN #__users AS u ON u.id = a.checked_out"
    . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
    . $ttlimit
  );
  $rows = $database->loadObjectList();

// get list of categories
  $kategorien[] = JHTML::_('select.option', '0', JTEXT::_('SEM_0027') );
  $database->setQuery( "SELECT id AS value, title AS text FROM #__categories WHERE section='com_seminar' ORDER BY ordering" );
  $kategorien = array_merge( $kategorien, $database->loadObjectList() );
  $clist = JHTML::_('select.genericlist', $kategorien, 'katid', 'class="inputbox" size="1" onchange="document.adminForm.submit();"',
    'value', 'text', $katid );
  HTML_seminar::sem_g032($rows,$clist,$search,$pageNav,$limitstart,$limit);
}

// +++++++++++++++++++++++++++++++++++
// +++ Konfiguration anzeigen      +++
// +++++++++++++++++++++++++++++++++++

function sem_g033() {
  TOOLBAR_seminar::_CONFIG();
  $table =& JTable::getInstance('component');
  $option = JRequest::getCmd('option');
  if (!$table->loadByOption($option)) {
    JError::raiseWarning( 500, 'Not a valid component' );
    return false;
  }
  $path = JPATH_ADMINISTRATOR.DS.'components'.DS.$option.DS.'config.xml';
  $params = new JParameter($table->params,$path);
  HTML_seminar::sem_g033($params);
}

// +++++++++++++++++++++++++++++++++++
// +++ Konfiguration speichern     +++
// +++++++++++++++++++++++++++++++++++

function sem_g034() {
  $table =& JTable::getInstance('component');
  $option = JRequest::getCmd('option');
  if (!$table->loadByOption($option)) {
    JError::raiseWarning( 500, 'Not a valid component' );
    return false;
  }
  $post = JRequest::get('post');
  $post['option'] = $option;
  $table->bind($post);
  if (!$table->check()) {
    JError::raiseWarning(500, $table->getError());
    return false;
  }
  if (!$table->store()) {
    JError::raiseWarning(500, $table->getError());
    return false;
  }
  JError::raiseNotice(1,JTEXT::_('SEM_2030'));
  sem_g033();
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Toolbar erzeugen               +++
// ++++++++++++++++++++++++++++++++++++++

class TOOLBAR_seminar {
  function _NEW() {
    JToolBarHelper::title(JText::_('SEM_0060'),'sem_event');
    JToolBarHelper::save('14');
    JToolBarHelper::cancel('0');
  }
  function _EDIT() {
    JToolBarHelper::title(JText::_('SEM_0051'),'sem_event');
    JToolBarHelper::save('14');
    JToolBarHelper::cancel('0');
  }
  function _STAT() {
    JToolBarHelper::title(JText::_('SEM_2018'),'sem_statistic');
  }
  function _HELP() {
    JToolBarHelper::title(JText::_('SEM_HELP'),'sem_help');
  }
  function _INFO() {
    JToolBarHelper::title(JText::_('SEM_2006'),'sem_info');
  }
  function _VIEW_BOOK() {
    JToolBarHelper::title(JText::_('SEM_0035'),'sem_event');
    JToolBarHelper::deleteList('','28');
    JToolBarHelper::custom("show","back.png","back_f2.png","Back",false);
  }
  function _VIEW_STAT() {
    JToolBarHelper::title(JText::_('SEM_2018'),'sem_statistic');
    JToolBarHelper::custom("4","back.png","back_f2.png","Back",false);
  }
  function _TMPL() {
    JToolBarHelper::title(JText::_('SEM_2023'),'sem_pattern');
    JToolBarHelper::publishList('19');
    JToolBarHelper::unpublishList('21');
    JToolBarHelper::deleteList('','17');
    JToolBarHelper::editList('13');
    JToolBarHelper::addNew('11');
    JToolBarHelper::custom( '23', 'copy.png', 'copy_f2.png', JText::_('SEM_0044') );
  }
  function _TNEW() {
    JToolBarHelper::title(JText::_('SEM_2026'),'sem_pattern');
    JToolBarHelper::save('15');
    JToolBarHelper::cancel('1');
  }
  function _TEDIT() {
    JToolBarHelper::title(JText::_('SEM_2027'),'sem_pattern');
    JToolBarHelper::save('15');
    JToolBarHelper::cancel('1');
  }
  function _CONFIG() {
    JToolBarHelper::title(JText::_('SEM_2029'),'sem_config');
    JToolBarHelper::save('31');
  }
  function _EVENTS() {
    JToolBarHelper::title(JText::_('SEM_0083'),'sem_event');
    JToolBarHelper::publishList('18');
    JToolBarHelper::unpublishList('20');
    JToolBarHelper::deleteList('','16');
    JToolBarHelper::editList('12');
    JToolBarHelper::addNew('10');
    JToolBarHelper::custom('22','copy.png','copy_f2.png',JText::_('SEM_0044') );
  }
}

?>
