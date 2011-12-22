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

header("Content-type: text/html; charset=UTF-8");
defined('_JEXEC') or die('Restricted access');
require_once(JApplicationHelper::getPath('admin_html'));
require_once(JApplicationHelper::getPath('class'));
$document = &JFactory::getDocument();
$document->addStyleSheet("components/".JRequest::getCmd('option')."/css/icon.css");
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

  case "5":
// Zahlungsarten anzeigen
    sem_g035();
    break;

  case "37":
// Zahlungsart publishen
    sem_g037($cid,1);
    break;

  case "38":
// Zahlungsart publishen
    sem_g037($cid,0);
    break;

  case "39":
// Neue zahlungsart erstellen
    sem_g036(0);
    break;

  case "40":
// Zahlungsart bearbeiten
    sem_g036($cid[0]);
    break;

  case "41":
// Zahlungsart loeschen
    sem_g038($cid,3);
    break;

  case "42":
// Zahlungsart speichern
    sem_g039();
    break;

  case "6":
// Kontrollzentrum anzeigen
    sem_g001();
    break;

  default:
// Kontrollzentrum anzeigen
    sem_g001();
    break;
}

echo sem_f028();

// ++++++++++++++++++++++++++++++++++
// +++ Kontrollzentrum            +++
// ++++++++++++++++++++++++++++++++++

function sem_g001() {
  TOOLBAR_seminar::_HOME();
  $database = &JFactory::getDBO();
  $where[] = "pattern = ''";
  $where[] = "published = 1";
  $database->setQuery("SELECT * FROM #__seminar WHERE pattern = '' AND published = 1 AND end > '".sem_f046()."' ORDER BY begin LIMIT 5");
  $rows = $database->loadObjectList();
  HTML_seminar::sem_g001($rows);
}

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
  $neudatum = sem_f046();
  $vorlage = JRequest::getInt('vorlage',0);
  $semnum = JRequest::getVar('semnum','');
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
    $row->publisher = $my->id;
    $row->semnum = $semnum;
  }
  $row->vorlage = $vorlage;

// Zeit festlegen
  if ($uid==0) {
    $row->begin = date( "Y-m-d" )." 14:00:00";
    $row->end = date( "Y-m-d" )." 17:00:00";
    $row->pubbegin = $neudatum;
    $row->pubend = $row->end;
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

  $zeit = explode(" ",$row->pubbegin);
  $row->pubbegin_date = $zeit[0];
  $zeit = explode(":",$zeit[1]);
  $row->pubbegin_hour = $zeit[0];
  $row->pubbegin_minute = $zeit[1];

  $zeit = explode(" ",$row->pubend);
  $row->pubend_date = $zeit[0];
  $zeit = explode(":",$zeit[1]);
  $row->pubend_hour = $zeit[0];
  $row->pubend_minute = $zeit[1];

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
  $id = JRequest::getInt('id',0);

  $emailart = 1;
  if($id>0) {
    $emailart = 2;
  }
  $kurs = sem_f077($id);
  $row = $kurs[0];
  $fehler = $kurs[1];

// Eingaben ueberpruefen
  $speichern = TRUE;
  $fehler1 = array();
  if($art==3) {
    if(sem_f067($row->pattern,'leer')) {
      $fehler1[] = JTEXT::_('SEM_2058');
    }
  } else {
    $fehler1 = sem_f078($row);
  }
  if(count($fehler1)>0) {
    $speichern = FALSE;
  }
  $fehler = array_unique(array_merge($fehler1,$fehler));

// Kurs speichern
  if($speichern==TRUE) {
    if (!$row->check()) {
      JError::raise(E_ERROR,500,$database->stderr());
      return false;
    }
    if (!$row->store()) {
      JError::raise(E_ERROR,500,$database->stderr());
      return false;
    }
    $row->checkin();
  }

// Ausgabe der Kurse
  if(count($fehler)>0) {
    JError::raise(E_WARNING,1,implode("</li><li>",$fehler));
    if($speichern==TRUE) {
      sem_g006($row->id,$art);
    } else {
      sem_g006($row->id,$art,$row);
    }
  } else {
    if($art==2) {
      if(JRequest::getInt('inform',0)>0) {
        sem_f075($row,$emailart,JRequest::getVar('infotext',''));  
      }
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
  if (count($cid)) {
    $cids = implode(',',$cid);
    if($art==2) {
      foreach ($cid AS $semid) {
        sem_f075($semid,3);
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
  if(count($cid)) {
    $cids = implode(',',$cid);
    if($art==2) {
      foreach ($cid AS $semid) {
        if($publish==0) {
         sem_f075($semid,3);
        } else {
         sem_f075($semid,4);
        }
      }
    }
    $database->setQuery( "UPDATE #__seminar SET published='$publish' WHERE id IN ($cids) ");
    if(!$database->query()) {
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

function sem_g025($cid,$cancelled) {
  $database = &JFactory::getDBO();
  $catid = JRequest::getVar('catid',array(0));
  if(count( $cid )) {
    $cids = implode( ',', $cid );
    $database->setQuery( "UPDATE #__seminar SET cancelled='$cancelled' WHERE id IN ($cids) ");
    if (!$database->query()) {
      JError::raiseError(500,$database->stderr());
      exit();
    }
    foreach ($cid AS $semid) {
      if($cancelled==0) {
       sem_f075($semid,2,JTEXT::_('SEM_0100'));
      } else {
       sem_f075($semid,2,JTEXT::_('SEM_0098'));
      }
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
//  $database = &JFactory::getDBO();
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
  $database = &JFactory::getDBO();
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
    JError::raiseError(500, $table->getError());
    return false;
  }
  if (!$table->store()) {
    JError::raiseError(500, $table->getError());
    return false;
  }
  $meldung = array();
  $pfad = JPATH_COMPONENT_SITE.DS."css".DS;
  $css0code=JRequest::getVar('css0code','','post','string',JREQUEST_ALLOWHTML);
  if(!file_put_contents($pfad."seminar.0.css",$css0code)) {
    $meldung[] = str_replace("SEM_FILE","seminar.0.css",JTEXT::_('SEM_E071'));
  }
  $css1code=JRequest::getVar('css1code','','post','string',JREQUEST_ALLOWHTML);
  if(!file_put_contents($pfad."seminar.1.css",$css1code)) {
    $meldung[] = str_replace("SEM_FILE","seminar.1.css",JTEXT::_('SEM_E071'));
  }
  $set = array();
  $set[] = "overview_event_header='".JRequest::getVar('overview_event_header','','post','string',JREQUEST_ALLOWHTML)."'";
  $set[] = "overview_nr_of_events='".JRequest::getInt('overview_nr_of_events',1,'post')."'";
  $set[] = "overview_event='".JRequest::getVar('overview_event','','post','string',JREQUEST_ALLOWHTML)."'";
  $set[] = "overview_event_footer='".JRequest::getVar('overview_event_footer','','post','string', JREQUEST_ALLOWHTML)."'";
  $set[] = "overview_booking_header='".JRequest::getVar('overview_booking_header','','post','string',JREQUEST_ALLOWHTML)."'";
  $set[] = "overview_nr_of_bookings='".JRequest::getInt('overview_nr_of_bookings',1,'post')."'";
  $set[] = "overview_booking='".JRequest::getVar('overview_booking','','post','string',JREQUEST_ALLOWHTML)."'";
  $set[] = "overview_booking_footer='".JRequest::getVar('overview_booking_footer','','post','string', JREQUEST_ALLOWHTML)."'";
  $set[] = "overview_offer_header='".JRequest::getVar('overview_offer_header','','post','string',JREQUEST_ALLOWHTML)."'";
  $set[] = "overview_nr_of_offers='".JRequest::getInt('overview_nr_of_offers',1,'post')."'";
  $set[] = "overview_offer='".JRequest::getVar('overview_offer','','post','string',JREQUEST_ALLOWHTML)."'";
  $set[] = "overview_offer_footer='".JRequest::getVar('overview_offer_footer','','post','string', JREQUEST_ALLOWHTML)."'";
  $set[] = "event='".JRequest::getVar('event','','post','string', JREQUEST_ALLOWHTML)."'";
  $set[] = "booking='".JRequest::getVar('booking','','post','string', JREQUEST_ALLOWHTML)."'";
  $set[] = "booked='".JRequest::getVar('booked','','post','string', JREQUEST_ALLOWHTML)."'";
  $set[] = "certificate='".JRequest::getVar('certificate','','post','string', JREQUEST_ALLOWHTML)."'";
  $database->setQuery( "UPDATE #__semlayouts"
  . (count($set) ? "\nSET " . implode( ', ', $set ) : "")
  . "\nWHERE chosen = 1"
  );
  if (!$database->query()) {
    JError::raiseError(500,$database->stderr());
    exit();
  }
  $set = array();
  $set[] = "new='".JRequest::getVar('new','','post','string', JREQUEST_ALLOWHTML)."'";
  $set[] = "new_type='".JRequest::getInt('new_type',0,'post')."'";
  $set[] = "changed='".JRequest::getVar('changed','','post','string', JREQUEST_ALLOWHTML)."'";
  $set[] = "changed_type='".JRequest::getInt('changed_type',0,'post')."'";
  $set[] = "unpublished_recent='".JRequest::getVar('unpublished_recent','','post','string', JREQUEST_ALLOWHTML)."'";
  $set[] = "unpublished_recent_type='".JRequest::getInt('unpublished_recent_type',0,'post')."'";
  $set[] = "unpublished_over='".JRequest::getVar('unpublished_over','','post','string', JREQUEST_ALLOWHTML)."'";
  $set[] = "unpublished_over_type='".JRequest::getInt('unpublished_over_type',0,'post')."'";
  $set[] = "republished_recent='".JRequest::getVar('republished_recent','','post','string', JREQUEST_ALLOWHTML)."'";
  $set[] = "republished_recent_type='".JRequest::getInt('republished_recent_type',0,'post')."'";
  $set[] = "republished_over='".JRequest::getVar('republished_over','','post','string', JREQUEST_ALLOWHTML)."'";
  $set[] = "republished_over_type='".JRequest::getInt('republished_over_type',0,'post')."'";
  $set[] = "booked='".JRequest::getVar('booked2','','post','string', JREQUEST_ALLOWHTML)."'";
  $set[] = "booked_type='".JRequest::getInt('booked2_type',0,'post')."'";
  $set[] = "bookingchanged='".JRequest::getVar('bookingchanged','','post','string', JREQUEST_ALLOWHTML)."'";
  $set[] = "bookingchanged_type='".JRequest::getInt('bookingchanged_type',0,'post')."'";
  $set[] = "canceled='".JRequest::getVar('canceled','','post','string', JREQUEST_ALLOWHTML)."'";
  $set[] = "canceled_type='".JRequest::getInt('canceled_type',0,'post')."'";
  $set[] = "paid='".JRequest::getVar('paid','','post','string', JREQUEST_ALLOWHTML)."'";
  $set[] = "paid_type='".JRequest::getInt('paid_type',0,'post')."'";
  $set[] = "unpaid='".JRequest::getVar('unpaid','','post','string', JREQUEST_ALLOWHTML)."'";
  $set[] = "unpaid_type='".JRequest::getInt('unpaid_type',0,'post')."'";
  $set[] = "certificated='".JRequest::getVar('certificated','','post','string', JREQUEST_ALLOWHTML)."'";
  $set[] = "certificated_type='".JRequest::getInt('certificated_type',0,'post')."'";
  $set[] = "uncertificated='".JRequest::getVar('uncertificated','','post','string', JREQUEST_ALLOWHTML)."'";
  $set[] = "uncertificated_type='".JRequest::getInt('uncertificated_type',0,'post')."'";
  $database->setQuery( "UPDATE #__sememails"
  . (count($set) ? "\nSET " . implode( ', ', $set ) : "")
  . "\nWHERE chosen = 1"
  );
  if (!$database->query()) {
    JError::raiseError(500,$database->stderr());
    exit();
  }
  $meldung[] = JTEXT::_('SEM_2030');
  JError::raiseNotice(1,implode("<br />",$meldung));
  sem_g033();
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Toolbar erzeugen               +++
// ++++++++++++++++++++++++++++++++++++++

class TOOLBAR_seminar {
  function _HOME() {
    JToolBarHelper::title(JText::_('SEM_0043'),'sem_home');
  }
  function _NEW() {
    JToolBarHelper::title(JText::_('SEM_0060'),'sem_event');
    JToolBarHelper::save('14');
    JToolBarHelper::cancel('0');
  }
  function _EDIT() {
    JToolBarHelper::title(JText::_('SEM_0051'),'sem_event');
    JToolBarHelper::save('14');
    JToolBarHelper::cancel('2');
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
    JToolBarHelper::custom("2","back.png","back_f2.png","Back",false);
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
