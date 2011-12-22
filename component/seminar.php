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

defined('_JEXEC') or die('Restricted access');
require_once(JApplicationHelper::getPath('front_html'));
require_once(JApplicationHelper::getPath('class'));
if(!isset($_REQUEST['tesk'])) {
  $task = trim(JRequest::getInt('task',0));
} else {
  if(isset($_REQUEST['task'])) {
    $task = trim(JRequest::getInt('task',0));
  } else {
    $tesk = trim(JRequest::getString('tesk',''));
    $temp = base64_decode($tesk);
    $temp = explode("|",$temp);
    $task = $temp[0];
    $art = $temp[1];
    $uniqid = $temp[2];
  }
}

if($task!= 25 AND $task!=31 AND $task!=33 AND $task!=99 AND $task!=35 AND $task!="pp2") {
  header("Content-type: text/html; charset=UTF-8");
  $document = &JFactory::getDocument();
  $document->addCustomTag(sem_f030());
}

if(($task>14 AND $task<23) OR $task==27 OR $task==30) {
  echo sem_f031();
}

// ++++++++++++++++++++++++++++++++++
// +++ Auswahl der Aktion         +++
// ++++++++++++++++++++++++++++++++++

$config = JComponentHelper::getParams('com_seminar');

switch ($task) {

  case "0":
// Veranstaltungen zeigen
    sem_f058();
    sem_g001(0);
    break;

  case "1":
// Gebuchte Kurse zeigen
    sem_f043(2);
    sem_g001(1);
    break;

  case "2":
// Angebotene Kurse zeigen
    sem_f043($config->get('sem_p001',3));
    sem_g001(2);
    break;

  case "3":
// Kursdetails anzeigen
    sem_f058();
    sem_g002(3);
    break;

  case "4":
// Details eines gebuchten Kurses zeigen
    sem_f043(2);
    sem_g002(4);
    break;

  case "5":
// Veranstaltung buchen
    sem_f043(1);
    sem_g004();
    break;

  case "6":
// Buchung stornieren
    sem_f043(2);
    sem_g005();
    break;

  case "7":
// Buchung durch den Veranstalter stornieren
    sem_f043($config->get('sem_p001',3));
    sem_g011();
    break;

  case "8":
// Neue Veranstaltung eingeben
    sem_f043($config->get('sem_p001',3));
    sem_g006();
    break;

  case "9":
// Veranstaltung bearbeiten
    sem_f043($config->get('sem_p001',3));
    sem_g006();
    break;

  case "10":
// Veranstaltung speichern
    sem_f043($config->get('sem_p001',3));
    sem_g007();
    break;

  case "11":
// Veranstaltung entfernen
    sem_f043($config->get('sem_p001',3));
    sem_g008();
    break;

  case "12":
// Veranstaltung duplizieren
    sem_f043($config->get('sem_p001',3));
    sem_g009();
    break;

  case "13":
// Benutzer zertifizieren
    sem_f043($config->get('sem_p001',3));
    sem_g013();
    break;

  case "14":
// Buchung als bezahlt markieren
    sem_f043($config->get('sem_p001',3));
    sem_g012();
    break;

  case "15":
// Uebersichten ausdrucken
//    sem_f043(2);
    sem_g018();
    break;

  case "16":
// Zertifikat drucken
    sem_f043(2);
    sem_f051($uniqid);
    break;

  case "17":
// Teilnehmerliste als Unterschriftsliste drucken
    sem_f043($config->get('sem_p001',3));
    sem_f052(1);
    break;

  case "18":
// Teilnehmerliste mit Detailangaben drucken
    sem_f043($config->get('sem_p001',3));
    sem_f052(2);
    break;

  case "19":
// Veranstalter eine E-Mail senden
    sem_f043(2);
    sem_g016(1);
    break;

  case "20":
// Veranstalter bewerten
    sem_f043(2);
    sem_g014();
    break;

  case "21":
// Bewertung in die Datenbank eintragen und Ajax schliessen
    sem_f043(2);
    sem_g015();
    break;

  case "22":
// E-Mail an Veranstalter absenden und Bestaetigung anzeigen
    sem_f043(2);
    sem_g017();
    break;

  case "23":
// Teilnehmer eines Kurses anzeigen
    sem_f043($config->get('sem_p001',3));
    sem_g010(2);
    break;

  case "24":
// Teilnehmer eines Kurses anzeigen
    sem_g010(1);
    break;

  case "25":
// Buchungsliste als CSV herunterladen
    sem_f043($config->get('sem_p001',3));
    sem_f048();
    break;

  case "26":
// Buchungsdaten aendern
    sem_f043(2);
    sem_g003(1);
    break;

  case "27":
// AGB anzeigen
    sem_g020();
    break;

  case "28":
// Details eines gebuchten Kurses zeigen
    sem_f043($config->get('sem_p001',3));
    sem_g002(6);
    break;

  case "29":
// Buchungsdaten aendern
    sem_f043($config->get('sem_p001',3));
    sem_g003(2);
    break;

  case "30":
// Teilnehmern eine E-Mail senden
    sem_f043($config->get('sem_p001',3));
    sem_g016(2);
    break;

  case "31":
// RSS-Feed erzeugen
    sem_g023();
    break;

  case "32":
// Benutzer ausloggen
    sem_g024();
    break;

  case "33":
// Veranstaltung als ICS herunterladen
    sem_f059();
    break;

  case "34":
// Datei herunterladen
    sem_f061();
    break;

  case "35":
// Google-Map Anzeigen
    sem_g027();
    break;

  case "36":
// Buchungsdaten aendern
    sem_f043(2);
    sem_g031();
    break;

  case "pp1":
// PayPal Ruecklauf erfolgreich
    sem_g028($art,$uniqid);
    break;

  case "pp2":
// PayPal Ruecklauf IPN
    sem_g029($uniqid);
    break;

  case "pp3":
// PayPal Ruecklauf Abbruch
    sem_g030($art,$uniqid);
    break;

  case "99":
// Ajax Modul
    sem_g026();
    break;

  default:
    JError::raiseError(403,JText::_("ALERTNOTAUTH") );
    exit();
    break;
}
echo "\n</td></tr></table><br />".sem_f028()."</div></form>";

// ++++++++++++++++++++++++++++++++++++
// +++ Anzeige der Kursuebersichten +++
// ++++++++++++++++++++++++++++++++++++

function sem_g001($art) {
  $database = JFactory::getDBO();
  $config = JComponentHelper::getParams('com_seminar');
  $dateid = JRequest::getInt('dateid',1);
  $catid = JRequest::getInt('catid',0);
  $search = JRequest::getString('search','');
  $search = str_replace("'","",$search);
  $search = str_replace("\"","",$search);
  $limit = JRequest::getInt('limit',$config->get('sem_p021',5));
  $limitstart = JRequest::getInt('limitstart',0);
  $my = JFactory::getuser();
  $neudatum = sem_f046();
  $where = array();

// Nur veroeffentlichte Kurse anzeigen
  $where[] = "a.published = '1'";
  $where[] = "a.pattern = ''";

// Festgelegte Felder ermitteln und fehlende auf Standardwert setzen
  $layout = sem_f047();
  switch($art) {
    case 1:
      $headerlayout = $layout->overview_booking_header;
      $footerlayout = $layout->overview_booking_footer;
      break;
    case 2:
      $headerlayout = $layout->overview_offer_header;
      $footerlayout = $layout->overview_offer_footer;
      break;
    default:
      $headerlayout = $layout->overview_event_header;
      $footerlayout = $layout->overview_event_footer;
      break;
  }
  if(strpos($headerlayout,"SEM_TAB_NUMBER")===false AND strpos($footerlayout,"SEM_TAB_NUMBER")===false) {
    $limit = $config->get('sem_p021',5);
  }
  if(strpos($headerlayout,"SEM_TAB_SEARCH")===false AND strpos($footerlayout,"SEM_TAB_SEARCH")===false) {
    $search = "";
  }
  if(strpos($headerlayout,"SEM_TAB_CATEGORIES")===false AND strpos($footerlayout,"SEM_TAB_CATEGORIES")===false) {
    $catid = 0;
  }
  if(strpos($headerlayout,"SEM_TAB_TYPES")===false AND strpos($footerlayout,"SEM_TAB_TYPES")===false) {
    $dateid = 1;
  }

// nur Kurse anzeigen, deren Kategorie fuer den Benutzer erlaubt ist
  $reglevel = sem_f042();
  $accesslvl = 1;
  if($reglevel>2) {
    $accesslvl=3;
  } elseif ($reglevel>1) {
    $accesslvl=2;
  }
  $database->setQuery("SELECT id, access FROM #__categories WHERE section='".JRequest::getCmd('option')."'");
  $cats = $database->loadObjectList();
  $allowedcat = array();
  foreach($cats AS $cat) {
    if($cat->access<$accesslvl) {
      $allowedcat[] = $cat->id;
    }
  }
  if(count($allowedcat)>0) {
    $allowedcat = implode(',',$allowedcat);
    $where[] = "a.catid IN ($allowedcat)";
  }

// Anzeigezeitraum festlegen
  $showbegin = $neudatum;
  switch ($config->get('sem_p064',2)) {
    case "0":
      $showend = "a.begin";
      break;
    case "1":
      $showend = "a.booked";
      break;
    case "2":
      $showend = "a.end";
      break;
    case "3":
      if($dateid==1 && $art==0) {
        $showbegin = "a.pubbegin";
        $showend = "a.pubend";
      } else {
        $showend = "a.end";
      }
      break;
  }
// Aktuelle, alte oder alle Veranstaltungen zeigen
  switch ($dateid) {
    case "1":
      if($showbegin!=$neudatum) {
        $where[] = "$showbegin <= '$neudatum'";
      }
      $where[] = "$showend > '$neudatum'";
      break;
    case "2":
      $where[] = "$showend <= '$neudatum'";
      break;
  }

// Anzuzeigende Kategorie ermitteln
  if($catid>0) {
    $where[] = "a.catid ='$catid'";
  }

// Anzeige je nach Reiter differenzieren
  switch ($art) {
    case "0":
//    Uebersicht der buchbaren Kurse anzeigen
      $leftjoin = "";
      $bookdate = "";
      $anztyp = array(JTEXT::_('SEM_0083'),0);
      break;
    case "1":
//    Gebuchte Kurse anzeigen
      $where[] = "cc.userid = '".$my->id."'";
      $leftjoin = "\n LEFT JOIN #__sembookings AS cc ON cc.semid = a.id";
      $bookdate = ", cc.bookingdate AS bookingdate, cc.id AS sid";
      $anztyp = array(JTEXT::_('SEM_1005'),1);
      break;
    case "2":
//    Eingestellte Kurse anzeigen
      if(sem_f042()<6) {
        $where[] = "a.publisher = '".$my->id."'";
      }
      $leftjoin = "";
      $bookdate = "";
      $anztyp = array(JTEXT::_('SEM_1031'),2);
      break;
  }
  $suche = "\nAND (a.semnum LIKE '%".$search."%' OR a.gmaploc LIKE '%".$search."%' OR a.target LIKE '%".$search."%' OR a.place LIKE '%".$search."%' OR a.teacher LIKE '%".$search."%' OR a.title LIKE '%".$search."%' OR a.shortdesc LIKE '%".$search."%' OR a.description LIKE '%".$search."%')";

  $database->setQuery("SELECT a.* FROM #__seminar AS a LEFT JOIN #__categories AS cat ON cat.id = a.catid"
    . $leftjoin
    . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
    . $suche
  );
  $rows = $database->loadObjectList();

// Abzug der Kurse, die wegen Ausbuchung nicht angezeigt werden sollen
  $abzug = 0;
  $abid = array();
  if($art==0) {
    foreach($rows as $row) {
      if($row->stopbooking==2) {
        $gebucht = sem_f020($row);
        if($row->maxpupil-$gebucht->booked<1) {
          $abzug++;
          $abid[] = $row->id;
        };
      }
    }
  }
  if(count($abid)>0) {
    $abid = implode(',',$abid);
    $where[] = "a.id NOT IN ($abid)";
  }
  $total = count($rows)-$abzug;

  if (!is_numeric($limitstart)) {
    $limitstart = explode("=",$limitstart);
    $limitstart = end($limitstart);
    if (!is_numeric($limitstart)) {
      $limitstart = 0;
    }
  }
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
  $database->setQuery("SELECT a.*, cat.title AS category, cat.image as catimage".$bookdate." FROM #__seminar AS a LEFT JOIN #__categories AS cat ON cat.id = a.catid"
    . $leftjoin
    . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
    . $suche
    . "\nORDER BY a.begin"
    . $ttlimit
  );
  $rows = $database->loadObjectList();

// Navigationspfad erweitern
  sem_f019($anztyp[0],"javascript:auf(".$anztyp[1].",'','');");

// Ausgabe der Kursuebersicht
  HTML_FrontSeminar::sem_g001($art,$rows,$search,$limit,$limitstart,$total,$dateid,$catid);
}

// +++++++++++++++++++++++++++++++++++++
// +++ Anzeige des gewaehlten Kurses +++
// +++++++++++++++++++++++++++++++++++++

function sem_g002($art) {
  $database = JFactory::getDBO();
  $cid = JRequest::getInt('cid',0);

// Werte des angegebenen Kurses ermitteln
  $database->setQuery("SELECT * FROM #__seminar WHERE id='$cid'");
  $row = $database->loadObject();
  if($art==3) {
// Hits erhoehen
    $database->setQuery( "UPDATE #__seminar SET hits=hits+1 WHERE id='$cid'" );
    if (!$database->query()) {
      JError::raiseError( 500, $row->getError() );
      exit();
    }

// Ausgabe des Kurses
    sem_f019(JTEXT::_('SEM_0083'),"javascript:auf(0,'','');");
  } elseif($art==4 OR $art==5) {
    sem_f019(JTEXT::_('SEM_1005'),"javascript:auf(1,'','');");
  } else {
    sem_f019(JTEXT::_('SEM_1031'),"javascript:auf(2,'','');");
  }
  sem_f019($row->title,"");
  HTML_FrontSeminar::sem_g002($art,$row);
}

// +++++++++++++++++++++++++++++++++++++
// +++ Buchungsdaten aendern         +++
// +++++++++++++++++++++++++++++++++++++

function sem_g003($art) {
  $database = &JFactory::getDBO();
  $neu = new mossembookings( $database );
  $id = JRequest::getInt('uid',0);
  if (!$neu->bind( $_POST )) {
    JError::raiseError( 500, $database->stderr() );
    exit();
  }
  $neu->id = $id;
  $neu = sem_g025($neu,"","");
  if($art==1) {
    sem_g001(1);
  } else {
    sem_g010(2);
  }
}

// +++++++++++++++++++++++++++++++++++++
// +++ Kurs buchen                   +++
// +++++++++++++++++++++++++++++++++++++

function sem_g004() {
  $database = &JFactory::getDBO();
  $my = &JFactory::getuser();
  $cid = JRequest::getInt('cid',0);
  $uid = JRequest::getInt('uid',0);
  $nrbooked = JRequest::getInt('nrbooked',0);
  $name = JRequest::getVar('name','');
  $email = JRequest::getVar('email','');
  $reason = JTEXT::_('SEM_0086');
  $book4user = JRequest::getVar('book4user','');
  $allesok = 1;

// Werte des angegebenen Kurses ermitteln
  $row = new mosSeminar($database);
  $row->load($cid);

  if (!empty($book4user)) {
    $database->setQuery( "SELECT id FROM #__users WHERE username='$book4user' LIMIT 1" );
    $temp = $database->loadObject();
    if (isset($temp->id) and $temp->id>0 ) {
      $usrid = $temp->id;
    } else {
      $allesok = 0;
      $ueber1 = JTEXT::_('SEM_1009');
      $reason = JTEXT::_('SEM_0189');
      $usrid = 0;
    }
  } else {
    $usrid = $my->id;
  }

  $art = 5;
  if($uid!=0) {
    $usrid = $uid;
    $art = 7;
    if($usrid<0) {
      $usrid = 0;
    }
  }
  $sqlid = $usrid;
  if(($name!="" AND $email!="") OR $usrid==0) {
    $usrid = 0;
    $sqlid = -1;
  }

// Pruefung ob Buchung erfolgreich durchfuehrbar
  if($allesok > 0) {
    $database->setQuery( "SELECT * FROM #__sembookings WHERE semid='$cid' AND userid='$sqlid'" );
    $temp = $database->loadObjectList();
    $gebucht = sem_f020($row);
    $gebucht = $gebucht->booked;
    $ueber1 = JTEXT::_('SEM_1011');
    $reason = JTEXT::_('SEM_1013');
    if( count( $temp ) > 0 ) {
// Bereits gebucht
      $allesok = 0;
      $ueber1 = JTEXT::_('SEM_1009');
      $reason = JTEXT::_('SEM_1003');
    } else if( sem_f046() > $row->booked ) {
// Anmeldeschluss vorbei
      $allesok = 0;
      $ueber1 = JTEXT::_('SEM_1009');
      $reason = JTEXT::_('SEM_0038');
    } else if($row->maxpupil - $gebucht - $nrbooked < 0 && $row->stopbooking == 1) {
// ausgebucht
      $allesok = 0;
      $ueber1 = JTEXT::_('SEM_1009');
      $reason = JTEXT::_('SEM_1030');
    } else if($row->maxpupil - $gebucht - $nrbooked < 0 && $row->stopbooking == 0) {
// Buchung auf Warteliste
      $allesok = 2;
      $reason = JTEXT::_('SEM_0084');
    }
    if($art==7) {
      $allesok = 1;
    }

  // Alles in Ordnung
    if($allesok > 0) {

    // Buchung eintragen
      $neu = new mossembookings($database);
      if (!$neu->bind( $_POST )) {
        JError::raiseError(500,$database->stderr());
        exit();
      }
      $neu->semid = $cid;
      $neu->userid = $usrid;
      $neu->bookingdate = sem_f046();
      $neu->uniqid = md5(uniqid(mt_rand(),true));
      $neu = sem_g025($neu,$row->id,$row->fees );
    }
  }
  if($art==7 and $allesok > 0) {
//    sem_f050($cid,$neu->id,8);
    sem_f075($cid,5);
    sem_g010(2);
  } else {
    if (!isset($neu->id)) {
      $neu->id=0;
    }
    
    if ($allesok > 0) {
      $database->setQuery( "SELECT * FROM #__sembookings WHERE uniqid='$neu->uniqid'" );
      $neu = $database->loadObject();
      sem_f075($cid,5,"",$neu);
    }
    $ueberschrift = array($ueber1,$reason);

// Ausgabe des Kurses
    sem_f019(JTEXT::_('SEM_0083'),"javascript:auf('','','');");
    sem_f019($row->title,"");
    HTML_FrontSeminar::sem_g002($art,$row,array($neu,$ueberschrift));
  }
}

// +++++++++++++++++++++++++++++++++++++
// +++ Buchung loeschen              +++
// +++++++++++++++++++++++++++++++++++++

function sem_g005() {
  $database = &JFactory::getDBO();
  $my = &JFactory::getuser();
  $cid = JRequest::getInt('cid',0);
  $database->setQuery("SELECT * FROM #__sembookings WHERE id='$cid'");
  $rows = $database->loadObjectList();
  if(count($rows)>0) {
    sem_f050($rows[0]->semid,$cid,2);
    $database->setQuery("DELETE FROM #__sembookings WHERE id='$cid'");
    if (!$database->query()) {
      JError::raiseError(500,$database->getError());
      exit();
    }
    $database->setQuery("DELETE FROM #__semattendees WHERE sembid='$cid'");
    if (!$database->query()) {
      JError::raiseError(500,$database->getError());
      exit();
    }
  }
  sem_g001(1);
}

// ++++++++++++++++++++++++++++++++++
// +++ Kurse editieren            +++
// ++++++++++++++++++++++++++++++++++

function sem_g006() {
  $database = &JFactory::getDBO();
  $my = &JFactory::getuser();

  $dateid = JRequest::getInt('dateid',1);
  $catid = JRequest::getInt('catid',0);
  $search = JRequest::getVar('search','');
  $limit = JRequest::getInt('limit',5);
  $limitstart = JRequest::getInt('limitstart',0);
  $vorlage = JRequest::getInt('vorlage',0);
  $cid = JRequest::getInt('cid',0);
  $semnum = JRequest::getVar('semnum','');
  $neudatum = sem_f046();
  
  $args = func_get_args();
  if(count($args)==1) {
    $vorlage = $args[0];
    $cid = $vorlage;
  }
  if(count($args)>1) {
    $cid = $args[0];
  }
  if(count($args)>2) {
    $row = $args[2];
  } else {
    $row = new mosSeminar($database);
    $row->load($cid);
  }

// Ist es eine Vorlage
  if($vorlage>0) {
    $row->id = "";
    $row->pattern = "";
    $row->publisher = $my->id;
    $row->semnum = $semnum;
  }
  if($cid<1) {
    $row->publisher = $my->id;
    $row->semnum = sem_f064(date('Y'));
  }
  $row->vorlage = $vorlage;

// Zeit festlegen
  if($row->begin=="0000-00-00 00:00:00") {
    $row->begin = date( "Y-m-d" )." 14:00:00";
    $row->end = date( "Y-m-d" )." 17:00:00";
    $row->pubbegin = $neudatum;
    $row->pubend = $row->end;
    $row->booked = date( "Y-m-d" )." 12:00:00";
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

  sem_f019(JTEXT::_('SEM_1031'),"javascript:auf(2,'','');");
  if ($cid) {
    sem_f019($row->title,"");
  } else {
    sem_f019(JTEXT::_('SEM_0060'),"");
  }
  HTML_FrontSeminar::sem_g006($row,$search,$catid,$limit,$limitstart,$dateid);
}

// +++++++++++++++++++++++++++++++++++++
// +++ Neuen Kurs speichern          +++
// +++++++++++++++++++++++++++++++++++++

function sem_g007() {
  $id = JRequest::getInt('cid',0);

  $emailart = 1;
  if($id>0) {
    $emailart = 2;
  }
  $kurs = sem_f077($id);
  $row = $kurs[0];
  $fehler = $kurs[1];
  $fehler1 = array();

// Eingaben ueberpruefen
  $speichern = TRUE;
  if(sem_f067($row->pattern,'leer')) {
    $fehler1 = sem_f078($row);
    if(count($fehler1)>0) {
      $speichern = FALSE;
    }
  }
  $fehler = array_unique(array_merge($fehler1,$fehler));

// speichern
  if($speichern == TRUE) {
    if (!$row->check()) {
      JError::raise(E_ERROR,500,$database->stderr());
      return false;
    }
    if (!$row->store()) {
      JError::raise(E_ERROR,500,$database->stderr());
      return false;
    }
  }

// Ausgabe der Kurse
  if(sem_f067($row->pattern,'voll')) {
    sem_g006($row->id);
  } elseif(count($fehler)>0) {
    JError::raise(E_WARNING,1,implode("</li><li>",$fehler));
    if($speichern == TRUE) {
      sem_g006($row->id,1);
    } else {
      sem_g006($row->id,1,$row);
    }
  } else {
    if(JRequest::getInt('inform',0)>0) {
      sem_f075($row,$emailart,JRequest::getVar('infotext',''));  
    }
    sem_g001(2);
  }
}

// +++++++++++++++++++++++++++++++++++++
// +++ Kurs unpublishen              +++
// +++++++++++++++++++++++++++++++++++++

function sem_g008() {
  $database = &JFactory::getDBO();
  $cid = JRequest::getInt('cid',0);
  $vorlage = JRequest::getInt('vorlage',0);

// Email an alle gebuchten Benutzer, dass eine Veranstaltung aus dem Programm genommen wurde
  if($vorlage==0) {
    sem_f075($cid,3);
  }  

  $database->setQuery( "UPDATE #__seminar SET published=0 WHERE id='$cid'" );
  if (!$database->query()) {
    JError::raiseError( 500, $row->getError() );
    exit();
  }
  if($vorlage>0) {
    sem_g006(0);
  } else {
    sem_g001(2);
  }
}

// ++++++++++++++++++++++++++++++++++
// +++ Seminar kopieren           +++
// ++++++++++++++++++++++++++++++++++

function sem_g009() {
  $database = &JFactory::getDBO();
  $cid = JRequest::getInt('cid',0);
  $database->setQuery( "SELECT * FROM #__seminar WHERE id='$cid'" );
  $rows = $database->loadObjectList();
  if ($database->getErrorNum()) {
    JError::raiseError( 500, $row->getError() );
    return false;
  }
  $item = $rows[0];
  $row = new mosseminar( $database );
  if (!$row->bind( $item )) {
    JError::raiseError( 500, $row->getError() );
    exit();
  }
  $row->id = NULL;
  $row->hits = 0;
  $row->grade = 0;
  $row->certificated = 0;
  $row->sid =  $item->id;
  $row->publishdate = sem_f046();
  $row->semnum = sem_f064(date('Y'));
  if (!$row->check()) {
    JError::raiseError( 500, $row->getError() );
    return false;
  }
  if (!$row->store()) {
    JError::raiseError( 500, $row->getError() );
    return false;
  }
  sem_g001(2);
}

// +++++++++++++++++++++++++++++++++++++
// +++ Buchungen ansehen             +++
// +++++++++++++++++++++++++++++++++++++

function sem_g010($arte) {
  $database = &JFactory::getDBO();
  $config = &JComponentHelper::getParams('com_seminar');
  $dateid = JRequest::getInt('dateid',1);
  $catid = JRequest::getInt('catid',0);
  $search = JRequest::getVar('search','');
  $limit = JRequest::getInt('limit',5);
  $limitstart = JRequest::getInt('limitstart',0);
  $cid = JRequest::getInt('cid',0);
  $art = JRequest::getInt('uid',0);
  $args = func_get_args();
  if(count($args)>1) {
    $cid = $args[1];
  }
  if($arte==2) {
    $art = 2;
  }
  $kurs = new mosSeminar( $database );
  $kurs->load($cid);
  
  if($art==0) {
    $anztyp = array(JTEXT::_('SEM_0083'),0);
  } elseif($art==1) {
    $anztyp = array(JTEXT::_('SEM_1005'),1);
  } elseif($art==2) {
    $anztyp = array(JTEXT::_('SEM_1031'),2);
  }

  $database->setQuery( "SELECT a.*, cc.*, a.id AS sid, a.name AS aname, a.email AS aemail FROM #__sembookings AS a LEFT JOIN #__users AS cc ON cc.id = a.userid WHERE a.semid = '$kurs->id' ORDER BY a.id");
  $rows = $database->loadObjectList();
  if ($database->getErrorNum()) {
    echo $database->stderr();
    return false;
  }
  sem_f019($anztyp[0],"javascript:auf(".$anztyp[1].",'','');");
  sem_f019($kurs->title,"");
  HTML_FrontSeminar::sem_g010($art,$rows,$search,$limit,$limitstart,$kurs,$catid,$dateid);
}

// +++++++++++++++++++++++++++++++++++++++++++
// +++ Buchung durch Veranstalter loeschen +++
// +++++++++++++++++++++++++++++++++++++++++++

function sem_g011() {
  $database = &JFactory::getDBO();
  $cid = JRequest::getInt('cid',0);
  $database->setQuery("SELECT * FROM #__sembookings WHERE id='$cid'");
  $rows = $database->loadObjectList();
  if($rows[0]->userid >0 ) {
    sem_f050($rows[0]->semid,$rows[0]->id, 3);
  }
  $database->setQuery("DELETE FROM #__sembookings WHERE id='$cid'");
  if (!$database->query()) {
    JError::raiseError( 500, $database->getError() );
    exit();
  }
  $database->setQuery("DELETE FROM #__semattendees WHERE sembid='$cid'");
  if (!$database->query()) {
    JError::raiseError(500,$database->getError());
    exit();
  }
  sem_g010(2,$rows[0]->semid);
}

// +++++++++++++++++++++++++++++++++++++++++++
// +++ Bezahlung markieren                 +++
// +++++++++++++++++++++++++++++++++++++++++++

function sem_g012() {
  $database = &JFactory::getDBO();
  $cid = JRequest::getInt('cid',0);
  $database->setQuery("SELECT * FROM #__sembookings WHERE id='$cid'");
  $rows = $database->loadObjectList();
  if($rows[0]->paid == 0) {
    $paid = 1;
    $art = 11;
  } else {
    $paid = 0;
    $art = 12;
  }
  $database->setQuery("UPDATE #__sembookings SET paid='$paid' WHERE id='$cid'");
  if (!$database->query()) {
    JError::raiseError( 500, $row->getError() );
    exit();
  }
  
  sem_g010(2,$rows[0]->semid);
  sem_f050($rows[0]->semid,$rows[0]->id,$art);
}

// +++++++++++++++++++++++++++++++++++++++++++
// +++ Teilnehmer zertifizieren            +++
// +++++++++++++++++++++++++++++++++++++++++++

function sem_g013() {
  $database = &JFactory::getDBO();
  $cid = JRequest::getInt('cid',0);
  $database->setQuery( "SELECT * FROM #__sembookings WHERE id='$cid'" );
  $rows = $database->loadObjectList();
  if($rows[0]->certificated == 0) {
    $cert = 1;
    $certmail = 6;
  } else {
    $cert = 0;
    $certmail = 7;
  }
  $database->setQuery( "UPDATE #__sembookings SET certificated='$cert' WHERE id='$cid'" );
  if (!$database->query()) {
    JError::raiseError( 500, $row->getError() );
    exit();
  }
  sem_f050($rows[0]->semid,$cid,$certmail);
  sem_g010(2,$rows[0]->semid);
}

// +++++++++++++++++++++++++++++++++++++++++++
// +++ Bewertungsfenster ausgeben          +++
// +++++++++++++++++++++++++++++++++++++++++++

function sem_g014() {
  $my = &JFactory::getuser();
  $database = &JFactory::getDBO();
  $cid = JRequest::getInt('cid',0);
  $database->setQuery( "SELECT * FROM #__seminar WHERE id='$cid'" );
  $rows = $database->loadObject();
  $database->setQuery( "SELECT * FROM #__sembookings WHERE semid='$cid' AND userid='$my->id'" );
  $buchung = $database->loadObject();
  HTML_FrontSeminar::sem_g014($row,$buchung);
}

// +++++++++++++++++++++++++++++++++++++++++++
// +++ Bewertung abspeichern               +++
// +++++++++++++++++++++++++++++++++++++++++++

function sem_g015() {
  $mainframe = JFactory::getApplication();
  $config = &JComponentHelper::getParams('com_seminar');
  jimport( 'joomla.mail.helper' );
  $my = &JFactory::getuser();
  $database = &JFactory::getDBO();
  $cid = JRequest::getInt('cid',0);
  $grade = JRequest::getInt('grade',0);
  $text = JRequest::getVar('text','');
  $text = str_replace(array("\"","\'"),"",$text);
  $text = JMailHelper::cleanBody($text);
  $database->setQuery( "UPDATE #__sembookings SET grade='$grade', comment='$text' WHERE semid='$cid' AND userid='$my->id'" );
  if (!$database->query()) {
    JError::raiseError( 500, $row->getError() );
    exit();
  }
  $database->setQuery( "SELECT * FROM #__sembookings WHERE semid='$cid'" );
  $rows = $database->loadObjectList();
  $zaehler = 0;
  $wertung = 0;
  foreach ($rows AS $row) {
    if($row->grade > 0) {
      $wertung = $wertung + $row->grade;
      $zaehler = $zaehler + 1;
    }
  }
  if( $zaehler>0) {
    $geswert = round($wertung/$zaehler);
  } else {
    $geswert = 0;
  }
  $database->setQuery( "UPDATE #__seminar SET grade='$geswert' WHERE id='$cid'" );
  if (!$database->query()) {
    JError::raiseError( 500, $row->getError() );
    exit();
  }
  if($config->get('sem_p009',0)>0) {
    $database->setQuery( "SELECT * FROM #__sembookings WHERE semid='$cid' AND userid='$my->id'" );
    $rows = $database->loadObjectList();
    $buchung = &$rows[0];
    $database->setQuery( "SELECT * FROM #__seminar WHERE id='$cid'" );
    $rows = $database->loadObjectList();
    $row = &$rows[0];
    $publisher = &JFactory::getuser($row->publisher);
    $body = "\n<head>\n<style type=\"text/css\">\n<!--\nbody {\nfont-family: Verdana, Tahoma, Arial;\nfont-size:12pt;\n}\n-->\n</style></head><body>";
    $body .= "<p><div style=\"font-size: 10pt\">".JTEXT::_('SEM_1019')."</div>";
    $body .= "<p><div style=\"font-size: 10pt\">".JTEXT::_('SEM_0055').":</div>";
    $htxt = str_replace('SEM_POINTS',$grade,JTEXT::_('SEM_0054'));
    $body .= "<div style=\"border: 1px solid #A0A0A0; width: 100%; padding: 5px;\">".$htxt."</div>";
    $body .= "<p><div style=\"font-size: 10pt\">".JTEXT::_('SEM_0042').":</div>";
    $body .= "<div style=\"border: 1px solid #A0A0A0; width: 100%; padding: 5px;\">".htmlspecialchars($text)."</div>";
    $body .= "<p><div style=\"font-size: 10pt\">".JTEXT::_('SEM_1018').":</div>";
    $htxt = str_replace('SEM_POINTS',$geswert,JTEXT::_('SEM_0054'));
    $body .= "<div style=\"border: 1px solid #A0A0A0; width: 100%; padding: 5px;\">".$htxt."</div>";
    $body .= "<p>".sem_f049($row,$buchung,$my);
    $sender = $mainframe->getCfg('fromname');
    $from = $mainframe->getCfg('mailfrom');
    $replyname = $my->name;
    $replyto = $my->email;
    $email = $publisher->email;
    $subject = JTEXT::_('SEM_0048');
    if($row->semnum!="") {
      $subject .= " ".$row->semnum;
    }
    $subject .= ": ".$row->title;
    $subject = JMailHelper::cleanSubject($subject);
    JUtility::sendMail($from, $sender, $email, $subject, $body, 1, null, null, null, $replyto, $replyname);
  }
  HTML_FrontSeminar::sem_g021($grade,$cid);
}

// +++++++++++++++++++++++++++++++++++++++++++
// +++ Nachricht an Veranstalter schreiben +++
// +++++++++++++++++++++++++++++++++++++++++++

function sem_g016($art) {
  $database = &JFactory::getDBO();
  $cid = JRequest::getInt('cid',0);
  $database->setQuery( "SELECT * FROM #__seminar WHERE id='$cid'" );
  $rows = $database->loadObjectList();
  $row = &$rows[0];
  HTML_FrontSeminar::sem_g016($art,$row);
}

// ++++++++++++++++++++++++++++++++++++++++++++
// +++ Nachricht an Veranstalter abschicken +++
// ++++++++++++++++++++++++++++++++++++++++++++

function sem_g017() {
  $mainframe = JFactory::getApplication();
  jimport( 'joomla.mail.helper' );
  $my = &JFactory::getuser();
  $database = &JFactory::getDBO();
  $cid = JRequest::getInt('cid',0);
  $uid = JRequest::getInt('uid',0);
  $text = JMailHelper::cleanBody(nl2br(JRequest::getVar('text','')));
  if($text != "") {
    $reason = JTEXT::_('SEM_1027');
    $database->setQuery( "SELECT * FROM #__seminar WHERE id='$cid'" );
    $rows = $database->loadObjectList();
    $kurs = &$rows[0];
    if($row->semnum!="") {
      $subject .= " ".$kurs->semnum;
    }
    $subject .= ": ".$kurs->title;
    $subject = JMailHelper::cleanSubject($subject);
    $sender = $mainframe->getCfg('fromname');
    $from = $mainframe->getCfg('mailfrom');
    if($my->id==0) {
      $replyname = $mainframe->getCfg('fromname');
      $replyto = $mainframe->getCfg('mailfrom');
    } else {
      $replyname = $my->name;
      $replyto = $my->email;
    }
    $body = "\n<head>\n<style type=\"text/css\">\n<!--\nbody {\nfont-family: Verdana, Tahoma, Arial;\nfont-size:12pt;\n}\n-->\n</style></head><body>";
    if($uid==1 AND $my->id!=0) {
      $body .= "<p><div style=\"font-size: 10pt\">".JTEXT::_('SEM_1022')."</div><p>";
    }
    $body .= "<div style=\"border: 1px solid #A0A0A0; width: 100%; padding: 5px;\">".$text."</div><p>";
    $temp = array();
    if($uid==1) {
      $body .= sem_f049($kurs,$temp,$my);
      $publisher = &JFactory::getuser($kurs->publisher);
      $email = $publisher->email;
      JUtility::sendMail($from, $sender, $email, $subject, $body, 1, null, null, null, $replyto, $replyname);
    } else {
      $database->setQuery( "SELECT * FROM #__sembookings WHERE semid='$kurs->id'" );
      $rows = $database->loadObjectList();
      foreach ($rows as $row) {
        if($row->userid==0) {
          $user->email = $row->email;
          $user->name = $row->name;
        } else {
          $user = &JFactory::getuser($row->userid);
        }     
        $text = $body.sem_f049($kurs,$row,$user);
        JUtility::sendMail($from, $sender, $user->email, $subject, $text, 1, null, null, null, $replyto, $replyname);
      }
    }
  } else {
    $reason = JTEXT::_('SEM_1024');
  }  
  HTML_FrontSeminar::sem_g022($reason);
}

// ++++++++++++++++++++++++++++++++++++++++
// +++ Ausdruck der Seminaruebersichten +++
// ++++++++++++++++++++++++++++++++++++++++

function sem_g018() {
  $database = &JFactory::getDBO();
  $config = &JComponentHelper::getParams('com_seminar');
  $my = &JFactory::getuser();
  $dateid = JRequest::getInt('dateid',1);
  $catid = JRequest::getInt('catid',0);
  $search = JRequest::getVar('search','');
  $limit = JRequest::getInt('limit',5);
  $limitstart = JRequest::getInt('limitstart',0);
  $cid = JRequest::getInt('cid',0);
  $uid = JRequest::getInt('uid',0);
  $OIO = JRequest::getVar('OIO','');
  if( $OIO!="65O9805443904" AND $OIO!="6530387504345" AND $OIO!="653O875032490" ) {
    JError::raiseError( 403, JText::_("ALERTNOTAUTH") );
    exit;
  }
  $neudatum = sem_f046();
  if( $limitstart < 0) {
    $limitstart = 0;
  }
  $ttlimit = "";
   if($limit > 0) {
    $ttlimit = "\nLIMIT $limitstart, $limit";
  }
  
  $where = array();
  $where[] = "a.pattern = ''";
  $where[] = "a.published = '1'";
  switch ($OIO) {
    case "65O9805443904":
      $navioben = explode(" ",$config->get('sem_p053','SEM_NUMBER SEM_SEARCH SEM_CATEGORIES SEM_RESET'));
      break;
    case "6530387504345":
      $navioben = explode(" ",$config->get('sem_p054','SEM_NUMBER SEM_SEARCH SEM_CATEGORIES SEM_RESET'));
      break;
    case "653O875032490":
      $navioben = explode(" ",$config->get('sem_p055','SEM_NUMBER SEM_SEARCH SEM_CATEGORIES SEM_RESET'));
      break;
  }
  if(in_array('SEM_TYPES',$navioben)) {
    switch ($dateid) {
      case "1":
        $where[] = "a.end > '$neudatum'";
        break;
      case "2":
        $where[] = "a.end <= '$neudatum'";
        break;
    }
  }
  switch($OIO) {
    case "65O9805443904":
      if(!in_array('SEM_TYPES',$navioben)) {
        $where[] = "a.end > '$neudatum'";
      }
      if((isset($_GET["catid"]) OR in_array('SEM_CATEGORIES',$navioben)) AND $catid>0) {
        $where[] = "a.catid ='$catid'";
      }
      $headertext = JTEXT::_('SEM_0083');
      if ($cid) {
        $where[] = "a.id= '$cid'";
        $headertext = JTEXT::_('SEM_0048');
      }
      $database->setQuery( "SELECT a.*, cc.title AS category FROM #__seminar AS a"
        . "\nLEFT JOIN #__categories AS cc"
        . "\nON cc.id = a.catid"
         . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
        . "\nAND (a.semnum LIKE'%$search%' OR a.teacher LIKE '%$search%' OR a.title LIKE '%$search%' OR a.shortdesc LIKE '%$search%' OR a.description LIKE '%$search%')"
      );
      $rows = $database->loadObjectList();

// Abzug der Kurse, die wegen Ausbuchung nicht angezeigt werden sollen
      if (!$cid) {
        $abid = array();
        foreach($rows as $row) {
          if($row->stopbooking==2) {
            $gebucht = sem_f020($row);
            if($row->maxpupil-$gebucht->booked<1) {
              $abid[] = $row->id;
            };
          }
        }
        if(count($abid)>0) {
          $abid = implode(',',$abid);
          $where[] = "a.id NOT IN ($abid)";
        }
      }

      $database->setQuery( "SELECT a.*, cc.title AS category FROM #__seminar AS a"
        . "\nLEFT JOIN #__categories AS cc"
        . "\nON cc.id = a.catid"
         . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
        . "\nAND (a.semnum LIKE'%$search%' OR a.teacher LIKE '%$search%' OR a.title LIKE '%$search%' OR a.shortdesc LIKE '%$search%' OR a.description LIKE '%$search%')"
        . "\nORDER BY a.begin"
        . $ttlimit
      );
      $rows = $database->loadObjectList();
      $status = array();
      $paid = array();
      $abid = array();
      for ($i=0, $n=count($rows); $i < $n; $i++) {
        $row = &$rows[$i];
        $gebucht = sem_f020($row);
        $gebucht = $gebucht->booked;
        if(sem_f046()>$row->booked OR ($row->maxpupil-$gebucht<1 AND $row->stopbooking==1) OR ($my->id==$row->publisher AND $config->get('sem_p002',0)==0)) {
          $status[$i] = JTEXT::_('SEM_0088');
        } else if($row->maxpupil-$gebucht<1 && $row->stopbooking==0) {
          $status[$i] = JTEXT::_('SEM_0036');
        } else if($row->maxpupil-$gebucht<1 && $row->stopbooking==2) {
          $abid[] = $row->id;
        } else {
          $status[$i] = JTEXT::_('SEM_0031');
        }
        $database->setQuery( "SELECT * FROM #__sembookings WHERE semid='$row->id' AND userid='$my->id'" );
        $temp = $database->loadObjectList();
        if( count( $temp ) > 0 ) {
          $status[$i] = JTEXT::_('SEM_1007');
          if( $temp[0]->paid == 1) {
            $rows[$i]->fees = $rows[$i]->fees." - ".JTEXT::_('SEM_0065');
          }
        }
        $rows[$i]->codepic = "";
      }
      break;
      
    case "6530387504345":
      sem_f043(1);
      $headertext = JTEXT::_('SEM_1005')." - ".$my->name;
      if(in_array('SEM_CATEGORIES',$navioben) AND $catid>0) {
        $where[] = "a.catid ='$catid'";
      }
      $where[] = "cc.userid = '".$my->id."'";
      if($cid) {
        $where[] = "cc.semid = '".$cid."'";
        $headertext = JTEXT::_('SEM_1008')." - ".$my->name;
      }
      $database->setQuery( "SELECT a.*, cat.title AS category, cc.bookingdate AS bookingdate, cc.id AS bookid FROM #__seminar AS a LEFT JOIN #__sembookings AS cc ON cc.semid = a.id LEFT JOIN #__categories AS cat ON cat.id = a.catid"
        . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
        . "\nAND (a.semnum LIKE'%$search%' OR a.teacher LIKE '%$search%' OR a.title LIKE '%$search%' OR a.shortdesc LIKE '%$search%' OR a.description LIKE '%$search%')"
        . "\nORDER BY a.begin"
         . $ttlimit
      );
      $rows = $database->loadObjectList();
      $status = array();
      for ($i=0, $n=count($rows); $i < $n; $i++) {
        $row = &$rows[$i];
        $database->setQuery( "SELECT * FROM #__sembookings WHERE semid='$row->id' ORDER BY id" );
        $temps = $database->loadObjectList();
        $status[$i] = JTEXT::_('SEM_0030');
        $rows[$i]->codepic = $row->bookid;
        if( count($temps) > $row->maxpupil) {
          if ( $row->stopbooking == 0 ) {
            for ($l=0, $m=count( $temps ); $l < $m; $l++) {
              $temp = &$temps[$l];
              if($temp->userid == $my->id) {
                break;
              }
            }
            if( $l+1 > $row->maxpupil ) {
              $status[$i] = JTEXT::_('SEM_0025');
            }
          } else {
            $status[$i] = JTEXT::_('SEM_0029');
          }
        } 
        if( $temps[0]->paid == 1) {
          $rows[$i]->fees = $rows[$i]->fees." - ".JTEXT::_('SEM_0065');
        }
      }
      break;
      
    case "653O875032490":
      sem_f043(2);
      if(in_array('SEM_CATEGORIES',$navioben) AND $catid>0) {
        $where[] = "a.catid ='$catid'";
      }
      $where[] = "a.publisher = '".$my->id."'";
      $database->setQuery( "SELECT a.*, cat.title AS category FROM #__seminar AS a LEFT JOIN #__categories AS cat ON cat.id = a.catid"
        . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
        . "\nAND (a.semnum LIKE'%$search%' OR a.teacher LIKE '%$search%' OR a.title LIKE '%$search%' OR a.shortdesc LIKE '%$search%' OR a.description LIKE '%$search%')"
        . "\nORDER BY a.begin"
        . $ttlimit
      );
      $rows = $database->loadObjectList();
      $status = array();
      $headertext = JTEXT::_('SEM_1031')." - ".$my->name;
      for ($i=0, $n=count($rows); $i < $n; $i++) {
        $row = &$rows[$i];
        $gebucht = sem_f020($row);
        $gebucht = $gebucht->booked;
        if( (sem_f046() > $row->booked) OR ($row->maxpupil - $gebucht < 1 && $row->stopbooking == 1) ) {
          $status[$i] = JTEXT::_('SEM_0088');
        } else if($row->maxpupil - $gebucht < 1 && $row->stopbooking == 0) {
          $status[$i] = JTEXT::_('SEM_0036');
        } else {
          $status[$i] = JTEXT::_('SEM_0031');
        }
        $rows[$i]->codepic = "";
      }
      break;
  }
  sem_f056($rows,$status,$headertext);
}

// ++++++++++++++++++++++++++
// +++ Freie Funktion     +++
// ++++++++++++++++++++++++++

function sem_g019() {
}

// +++++++++++++++++++++++++++++
// +++ AGB anzeigen          +++
// +++++++++++++++++++++++++++++

function sem_g020() {
  HTML_FrontSeminar::sem_g020();
}

// +++++++++++++++++++++++++++++
// +++ RSS-Feed erzeugen     +++
// +++++++++++++++++++++++++++++

function sem_g023() {
  $config = &JComponentHelper::getParams('com_seminar');
  if($config->get('sem_p048',0)==0) {
    JError::raiseError( 403, JText::_("ALERTNOTAUTH") );
    exit;
  }
  $database = JFactory::getDBO();
  $neudatum = sem_f046();
  $where = array();
  $database->setQuery("SELECT id, access FROM #__categories WHERE section='".JRequest::getCmd('option')."'");
  $cats = $database->loadObjectList();
  $allowedcat = array();
  foreach($cats AS $cat) {
    if($cat->access<1) {
      $allowedcat[] = $cat->id;
    }
  }
  if(count($allowedcat)>0) {
    $allowedcat = implode(',',$allowedcat);
    $where[] = "a.catid IN ($allowedcat)";
  }
  $where[] = "a.published = '1'";
  $where[] = "a.pattern = ''";
  $where[] = "a.end > '$neudatum'";
  $where[] = "a.booked > '$neudatum'";
  $database->setQuery("SELECT a.*, cat.title AS category FROM #__seminar AS a LEFT JOIN #__categories AS cat ON cat.id = a.catid"
    . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
    . "\nORDER BY a.publishdate DESC"
  );
  $rows = $database->loadObjectList();
  HTML_FrontSeminar::sem_g023($rows);
}
// +++++++++++++++++++++++++++++++++++++++++++++++
// +++ Benutzer ausloggen                      +++
// +++++++++++++++++++++++++++++++++++++++++++++++

function sem_g024() {
  $mainframe = JFactory::getApplication();
  $userid = null;
  $mainframe->logout($userid);
  sem_g001(0);
}

// +++++++++++++++++++++++++++++++++++++++++++++++++
// +++ Teilnehmer/Attendees speichern            +++
// +++++++++++++++++++++++++++++++++++++++++++++++++

function sem_g025($neu,$semid,$fees) {
  $database = &JFactory::getDBO();

// Seminar-ID holen
  if (!isset($semid) or empty($semid)) {
    $database->setQuery( "SELECT semid FROM #__sembookings WHERE id='$neu->id' LIMIT 1" );
    $semid = $database->loadResult();
  }
// Veranstaltungswerte holen
  $database->setQuery( "SELECT * FROM #__seminar WHERE id='$semid'" );
  $row = $database->loadObject();

  $neu->semid = $semid;
  $neu->name = sem_f018($neu->name);
  $neu->email = sem_f018($neu->email);
  $neu->zusatz1 = sem_f018($neu->zusatz1);
  $neu->zusatz2 = sem_f018($neu->zusatz2);
  $neu->zusatz3 = sem_f018($neu->zusatz3);
  $neu->zusatz4 = sem_f018($neu->zusatz4);
  $neu->zusatz5 = sem_f018($neu->zusatz5);
  $neu->zusatz6 = sem_f018($neu->zusatz6);
  $neu->zusatz7 = sem_f018($neu->zusatz7);
  $neu->zusatz8 = sem_f018($neu->zusatz8);
  $neu->zusatz9 = sem_f018($neu->zusatz9);
  $neu->zusatz10 = sem_f018($neu->zusatz10);
  $neu->zusatz11 = sem_f018($neu->zusatz11);
  $neu->zusatz12 = sem_f018($neu->zusatz12);
  $neu->zusatz13 = sem_f018($neu->zusatz13);
  $neu->zusatz14 = sem_f018($neu->zusatz14);
  $neu->zusatz15 = sem_f018($neu->zusatz15);
  $neu->zusatz16 = sem_f018($neu->zusatz16);
  $neu->zusatz17 = sem_f018($neu->zusatz17);
  $neu->zusatz18 = sem_f018($neu->zusatz18);
  $neu->zusatz19 = sem_f018($neu->zusatz19);
  $neu->zusatz20 = sem_f018($neu->zusatz20);
  if (!$neu->check()) {
    JError::raiseError(500,$database->stderr());
    exit();
  }
  if (!$neu->store()) {
    JError::raiseError(500,$database->stderr());
    exit();
  }
  $neu->checkin();
  // repair function, do not leave empty fields
  $database->setQuery( "UPDATE #__sembookings AS a JOIN #__users AS b ON a.userid=b.id SET a.name=b.name, a.email=b.email WHERE a.name='' AND b.name>''" );
  $database->Query();
  // attendees
  $database->setQuery( "SELECT fees,request1,request2,request3,request4,request5,request6,request7,request8,request9,request10,request11,request12,request13,request14,request15,request16,request17,request18,request19,request20 FROM #__seminar WHERE id='$semid' LIMIT 1" );
  $row = $database->loadObject();
  if(count($row)==0) {
    JError::raiseError( 403, JText::_("ALERTNOTAUTH") );
    exit();
  }
  if (empty($row->request1)) {
    return;
  }
  $requestfields = array($row->request1,$row->request2,$row->request3,$row->request4,$row->request5,$row->request6,$row->request7,$row->request8,$row->request9,$row->request10,$row->request11,$row->request12,$row->request13,$row->request14,$row->request15,$row->request16,$row->request17,$row->request18,$row->request19,$row->request20);
  $preset = array('','','','','','','','','','');
  for($i=0;$i<count($requestfields);$i++) {
    $reqart = explode("|",$requestfields[$i]);
    if (!empty($reqart[2]) and (empty($reqart[3]) or $reqart[3] == "text" or $reqart[3] == "email")) {
      $preset[$i] = $reqart[2];
    }
  }
  if ( !isset($fees) or empty($fees) ) {
  // fetch fees
    $fees = $row->fees;
  }
  // drop old attendee lines
  $database->setQuery( "DELETE FROM #__semattendees WHERE sembid='$neu->id'" );
  $database->Query();
  
  // add attendees
  $nb=0;
  $i=0;
  while ($nb < $neu->nrbooked) {
    if ( $i++ > 999) break; // catch endless loop just in case, should never occur
    // check for an existing record
    $reqid = JRequest::getVar("reqid".$i,'');
    if ( empty($reqid) ) continue;
    // we have a displayed record
    $request1  = JRequest::getVar("request1".$i,'');
    $request2  = JRequest::getVar("request2".$i,'');
    $request3  = JRequest::getVar("request3".$i,'');
    $request4  = JRequest::getVar("request4".$i,'');
    $request5  = JRequest::getVar("request5".$i,'');
    $request6  = JRequest::getVar("request6".$i,'');
    $request7  = JRequest::getVar("request7".$i,'');
    $request8  = JRequest::getVar("request8".$i,'');
    $request9  = JRequest::getVar("request9".$i,'');
    $request10  = JRequest::getVar("request10".$i,'');
    $request11  = JRequest::getVar("request11".$i,'');
    $request12  = JRequest::getVar("request12".$i,'');
    $request13  = JRequest::getVar("request13".$i,'');
    $request14  = JRequest::getVar("request14".$i,'');
    $request15  = JRequest::getVar("request15".$i,'');
    $request16  = JRequest::getVar("request16".$i,'');
    $request17  = JRequest::getVar("request17".$i,'');
    $request18  = JRequest::getVar("request18".$i,'');
    $request19  = JRequest::getVar("request19".$i,'');
    $request20  = JRequest::getVar("request20".$i,'');
    // remove presets
    if (!empty($preset[0]) and $request1 == $preset[0]) $request1 = ""; 
    if (!empty($preset[1]) and $request2 == $preset[1]) $request2 = ""; 
    if (!empty($preset[2]) and $request3 == $preset[2]) $request3 = ""; 
    if (!empty($preset[3]) and $request4 == $preset[3]) $request4 = ""; 
    if (!empty($preset[4]) and $request5 == $preset[4]) $request5 = ""; 
    if (!empty($preset[5]) and $request6 == $preset[5]) $request6 = ""; 
    if (!empty($preset[6]) and $request7 == $preset[6]) $request7 = ""; 
    if (!empty($preset[7]) and $request8 == $preset[7]) $request8 = ""; 
    if (!empty($preset[8]) and $request9 == $preset[8]) $request9 = ""; 
    if (!empty($preset[9]) and $request10 == $preset[9]) $request10 = "";
    if (!empty($preset[10]) and $request11 == $preset[10]) $request11 = ""; 
    if (!empty($preset[11]) and $request12 == $preset[11]) $request12 = ""; 
    if (!empty($preset[12]) and $request13 == $preset[12]) $request13 = ""; 
    if (!empty($preset[13]) and $request14 == $preset[13]) $request14 = ""; 
    if (!empty($preset[14]) and $request15 == $preset[14]) $request15 = ""; 
    if (!empty($preset[15]) and $request16 == $preset[15]) $request16 = ""; 
    if (!empty($preset[16]) and $request17 == $preset[16]) $request17 = ""; 
    if (!empty($preset[17]) and $request18 == $preset[17]) $request18 = ""; 
    if (!empty($preset[18]) and $request19 == $preset[18]) $request19 = ""; 
    if (!empty($preset[19]) and $request20 == $preset[19]) $request20 = "";
    // increment ordering
    $nb++;
    // write new record
    $neuattendee = new mossemattendees( $database );
    if (!$neuattendee->bind( $_POST )) {
      JError::raiseError( 500, $database->stderr() );
      exit();
    }
    $neuattendee->semid = $semid;
    $neuattendee->sembid = $neu->id;
    $neuattendee->ordering = $nb;
    $neuattendee->fees = $fees;
    $neuattendee->publishdate = sem_f046();
    $neuattendee->request1 =  $request1;
    $neuattendee->request2 =  $request2;
    $neuattendee->request3 =  $request3;
    $neuattendee->request4 =  $request4;
    $neuattendee->request5 =  $request5;
    $neuattendee->request6 =  $request6;
    $neuattendee->request7 =  $request7;
    $neuattendee->request8 =  $request8;
    $neuattendee->request9 =  $request9;
    $neuattendee->request10 =  $request10;
    $neuattendee->request11 =  $request11;
    $neuattendee->request12 =  $request12;
    $neuattendee->request13 =  $request13;
    $neuattendee->request14 =  $request14;
    $neuattendee->request15 =  $request15;
    $neuattendee->request16 =  $request16;
    $neuattendee->request17 =  $request17;
    $neuattendee->request18 =  $request18;
    $neuattendee->request19 =  $request19;
    $neuattendee->request20 =  $request20;
    if (!$neuattendee->check()) {
      JError::raiseError( 500, $database->stderr() );
      exit();
    }
    if (!$neuattendee->store()) {
      JError::raiseError( 500, $database->stderr() );
      exit();
    }
    $neuattendee->checkin();
  }
  return $neu;
}

// +++++++++++++++++++++++++++++++++++++++++++++++
// +++ Ajax Modul                      +++
// +++++++++++++++++++++++++++++++++++++++++++++++

function sem_g026() {
  $document = &JFactory::getDocument();
  $params = &JComponentHelper::getParams('mod_seminar');
  $renderer = $document->loadRenderer('module');
  $mainframe =& JFactory::getApplication();
  $params = array();
  $sem_midx = $mainframe->getUserStateFromRequest("sem_midx",'sem_midx',0);
  $sem_jidx = $mainframe->getUserStateFromRequest("sem_jidx",'sem_jidx',0);
  $mod = JModuleHelper::getModule('seminar');
  $html = $renderer->render($mod,$params);
  echo $html;
  exit;
}

// +++++++++++++++++++++++++++++++++++++
// +++ Google-Map-Fenster ausgeben +++
// +++++++++++++++++++++++++++++++++++++

function sem_g027() {
  $database = JFactory::getDBO();
  $cid = JRequest::getInt('cid',0);
  $ziel = JRequest::getString('zl','');
  $ort = JRequest::getString('ot','');
// Werte des angegebenen Kurses ermitteln
  $database->setQuery("SELECT * FROM #__seminar WHERE id='$cid'");
  $row = $database->loadObject();
  HTML_FrontSeminar::sem_g027($row,$ziel,$ort);
}

// +++++++++++++++++++++++++++++++++++++
// +++ PayPal erfolgreich            +++
// +++++++++++++++++++++++++++++++++++++

function sem_g028($art,$uniqid) {
  $database = JFactory::getDBO();
  $database->setQuery("UPDATE #__sembookings SET paid=1, paiddate='".sem_f046()."' WHERE uniqid='".$uniqid."'");
  if (!$database->query()) {
    JError::raiseError( 500, $row->getError() );
    exit();
  }
  $ueber1 =  JTEXT::_('SEM_1062');
  $ueber2 = JTEXT::_('SEM_1063');
  $ueberschrift = array($ueber1,$ueber2);
  $database->setQuery("SELECT * FROM #__sembookings WHERE uniqid='".$uniqid."'");
  $neu = $database->loadObject();
  $database->setQuery("SELECT * FROM #__seminar WHERE id='".$neu->semid."'");
  $row = $database->loadObject();
  HTML_FrontSeminar::sem_g002($art,$row,array($neu,$ueberschrift));
}
// +++++++++++++++++++++++++++++++++++++
// +++ PayPal IPN                    +++
// +++++++++++++++++++++++++++++++++++++

function sem_g029($uniqid) {
  $database = JFactory::getDBO();
  $database->setQuery("UPDATE #__sembookings SET paid=1, paiddate='".sem_f046()."' WHERE uniqid='".$uniqid."'");
  $database->query();
  exit();
}
// +++++++++++++++++++++++++++++++++++++
// +++ PayPal Abbruch                +++
// +++++++++++++++++++++++++++++++++++++

function sem_g030($art,$uniqid) {
  $database = JFactory::getDBO();
  $ueber1 =  JTEXT::_('SEM_1064');
  $ueber2 = JTEXT::_('SEM_1065');
  $ueberschrift = array($ueber1,$ueber2);
  $database->setQuery("SELECT * FROM #__sembookings WHERE uniqid='".$uniqid."'");
  $neu = $database->loadObject();
  $database->setQuery("SELECT * FROM #__seminar WHERE id='".$neu->semid."'");
  $row = $database->loadObject();
  HTML_FrontSeminar::sem_g002($art,$row,array($neu,$ueberschrift));
}
// +++++++++++++++++++++++++++++++++++++
// +++ Buchungsdaten aendern         +++
// +++++++++++++++++++++++++++++++++++++

function sem_g031() {
  $database = &JFactory::getDBO();
  $config = &JComponentHelper::getParams('com_seminar');
  $id = JRequest::getInt('uid',0);
  $neu = new mossembookings( $database );
  if (!$neu->bind( $_POST )) {
    JError::raiseError( 500, $database->stderr() );
    exit();
  }
  $neu->id = $id;
  $neu = sem_g025($neu,"","");
  $url = sem_f085($id);
  header("Location: ".$url);
  exit();
}

?>