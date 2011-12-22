<?php

//*******************************************
//***         Seminar for joomla!         ***
//***            Version 1.4.0            ***
//*******************************************
//***     Copyright (c) Dirk Vollmar      ***
//***                 2011                ***
//***          joomla@vollmar.ws          ***
//***         All rights reserved         ***
//*******************************************
//*     Released under GNU/GPL License      *
//*  http://www.gnu.org/licenses/gpl.html   *
//*******************************************

defined('_JEXEC') or die('Restricted access');

class HTML_FrontSeminar {

// ++++++++++++++++++++++++++++++++++++
// +++ Anzeige der Kursuebersichten +++
// ++++++++++++++++++++++++++++++++++++

  function sem_g001($art,$rows,$search,$limit,$limitstart,$total,$dateid,$catid) {
    $document = &JFactory::getDocument();
    $document->addCustomTag(sem_f027(0));
    $database = &JFactory::getDBO();
    $my = &JFactory::getuser();
    $config = &JComponentHelper::getParams('com_seminar');
    $neudatum = sem_f046();
    JHTML::_('behavior.modal');

// ---------------------------------
// Anzeige Kopfbereich mit Auswahl
// ---------------------------------

    $knopfoben = "";
    $knopfunten = sem_f032(($art+1));
    if($art==2) {
      $knopfoben .= sem_f071("javascript:auf(8,'','');","1832","0060");
      $knopfunten .= sem_f072("auf(8,'','')","1816","0060");
    }
    if(count($rows)>0) {
      if($art==0 AND $config->get('sem_p048',0)==1) {
        $href = JURI::ROOT()."index2.php?option=".JRequest::getCmd('option')."&task=31";
        $knopfoben .= sem_f071($href,"3132","1048","target=\"_new\"");
        $knopfunten .= sem_f072("window.open('".$href."');","3116","1048");
      }
      $knopfoben .= sem_f037(($art+2),'','','');
      $knopfunten .= "&nbsp;".sem_f037(($art+2),'','','b');
    }
    if($config->get('sem_p024',2)==0 OR $config->get('sem_p024',2)==2) {
      echo $knopfoben;
    }
    $html = "</td></tr>".sem_f023("e")."\n".sem_f026(1).sem_f023(4)."<tr><td class=\"sem_anzeige\">";

// ---------------------------------
// Layoutparameter je nach Reiter auswaehlen
// ---------------------------------

$layout = sem_f047();
  
switch($art) {
  case 1:
    $eventlayout = $layout->overview_booking;
    $headerlayout = $layout->overview_booking_header;
    $footerlayout = $layout->overview_booking_footer;
    $prozeile = $layout->overview_nr_of_bookings;
    break;
  case 2:
    $eventlayout = $layout->overview_offer;
    $headerlayout = $layout->overview_offer_header;
    $footerlayout = $layout->overview_offer_footer;
    $prozeile = $layout->overview_nr_of_offers;
    break;
  default:
    $eventlayout = $layout->overview_event;
    $headerlayout = $layout->overview_event_header;
    $footerlayout = $layout->overview_event_footer;
    $prozeile = $layout->overview_nr_of_events;
    break;
}

// ---------------------
// Anzeige Tabellenkopf
// ---------------------

    $n = count($rows);
    $html .= sem_f033($headerlayout,$art,$search,$limit,$limitstart,$total,$n,$dateid,$catid);

// ---------------------------
// Anzeige der einzelnen Kurse
// ---------------------------

    $html .= "<table class=\"sem_event_table\"><tr>";
    if($n>0) {
    
// Schleife beginnen
      for ($i=0, $n; $i < $n; $i++) {
        $row = &$rows[$i];
        $html .= sem_f022(sem_f054($eventlayout,$row,$art),'d','','','sem_event');
        if(($i+1) % $prozeile == 0) {
          $html .= "</tr><tr>";
        }
      }
      while($i % $prozeile!=0) {
        $html .= sem_f022("&nbsp;",'d','','','sem_noevent');
        $i++;
      }
    } else {
      $html .= sem_f022(JTEXT::_('SEM_0062'),'h','','100%','sem_row');
    }
    $html .= "</tr>".sem_f023('e');

// ---------------------
// Anzeige Tabellenfuss
// ---------------------

    $html .= sem_f033($footerlayout,$art,$search,$limit,$limitstart,$total,$n,$dateid,$catid);

// ---------------------------------
// Anzeige Funktionsknoepfe unten
// ---------------------------------

    if($config->get('sem_p024',2)>0) {
      $html .= sem_f023(4)."<tr>".sem_f022($knopfunten,'d','c','100%','sem_nav_d')."</tr>".sem_f023('e');
    }

// ---------------------------------------
// Ausgabe der unsichtbaren Formularfelder
// ---------------------------------------

    if(strpos($headerlayout,"SEM_TAB_NUMBER")===false AND strpos($footerlayout,"SEM_TAB_NUMBER")===false) {
      $html .= "<input type=\"hidden\" name=\"limit\" value=\"".$config->get('sem_p021',5)."\">";
    }
    if(strpos($headerlayout,"SEM_TAB_SEARCH")===false AND strpos($footerlayout,"SEM_TAB_SEARCH")===false) {
      $html .= "<input type=\"hidden\" name=\"search\" value=\"\">";
    }
    if(strpos($headerlayout,"SEM_TAB_CATEGORIES")===false AND strpos($footerlayout,"SEM_TAB_CATEGORIES")===false) {
      $html .= "<input type=\"hidden\" name=\"catid\" value=\"0\">";
    }
    if(strpos($headerlayout,"SEM_TAB_TYPES")===false AND strpos($footerlayout,"SEM_TAB_TYPES")===false) {
      $html .= "<input type=\"hidden\" name=\"dateid\" value=\"1\">";
    }
    $html .= sem_f014($art,"","","",$limitstart,0,"",-1);

    echo $html;
  }

// ++++++++++++++++++++++++++++++++++++
// +++ Anzeige der KursDetails      +++
// ++++++++++++++++++++++++++++++++++++
// art 3 = Detailansicht aus Uebersicht Veranstaltungen (Selbstbucher)
// art 4 = Detailansicht aus Uebersicht Meine Buchungen (Selbstbucher)
// art 5 = Detailansicht Kurs gebucht aus Uebersicht Veranstaltungen (Selbstbucher)
// art 6 = Detailansicht aus Uebersicht Meine Angebote (Fremdbucher)
// art 7 = Detailansicht Kurs gebucht aus Uebersicht Meine Angebote (Fremdbucher)

  function sem_g002() {
    global $mainframe;
    $args = func_get_args();
    $art = $args[0];
    $row = $args[1];
    $buchungswerte = "";
    $ueberschrift = "";
    if(count($args)>2) {
      $buchungswerte = $args[2][0];
      $ueberschrift = $args[2][1];
    }
    $document = &JFactory::getDocument();
    $database = &JFactory::getDBO();
    $config = &JComponentHelper::getParams('com_seminar');
    $dateid = JRequest::getInt('dateid',1);
    $uid = JRequest::getInt('uid',0);
    $catid = JRequest::getInt('catid',0);
    $search = JRequest::getVar('search','');
    $limit = JRequest::getInt('limit',5);
    $limitstart = JRequest::getInt('limitstart',0);
    $neudatum = sem_f046();
    JHTML::_('behavior.modal');
    JHTML::_('behavior.tooltip');


// ---------------------------------
// Ist Kurs noch buchbar
// ---------------------------------

    if(empty($buchungswerte)) {
      if($uid>0) {
        $database->setQuery("SELECT * FROM #__sembookings WHERE id='$uid'");
        $buchungswerte = $database->loadObject();
        $user = &JFactory::getuser($buchungswerte->userid);
      } else {
        if($art>5) {
          $user = &JFactory::getuser(0);
        } else {
          $user = &JFactory::getuser();
        }
        $userid = $user->id;
        if($userid==0) {
          $userid = -1;
        }
        $database->setQuery("SELECT * FROM #__sembookings WHERE semid='$row->id' AND userid='$userid'");
        $buchungswerte = $database->loadObject();
      }
    }
    $buchung = sem_f020($row,$user->id);
    $buchbar = sem_f079($row,$user->id,$buchung->free,$buchungswerte->id,$config);
    $nametemp = "";
    $jsart = 2;
    $modify = 26;
    if($art>5) {
      $modify = 29;
// Ist Liste der buchbaren User leer?
      $nametemp = sem_f011($row);
      if(($nametemp=="" AND $buchungswerte->id==0) OR ($buchungswerte->id>0 AND $user->id==0)) {
        $jsart = 2.03;
      }
    }
    $jsleer = $jsart;

// Sind Eingabefelder Bucher leer
    $zusfeld = sem_f017($row);
    $zfleer = 1;
    foreach($zusfeld[0] AS $el) {
      if($el!="") {
        $zfleer = 0;
        $jsart = 2.01;
        if($jsleer==2.03) {
          $jsart = 2.05;
        }
        break;
      }
    }

// Sind Eingabefelder Teilnehmer leer
    $zusfeld = sem_f068($row);
    foreach($zusfeld[0] AS $el) {
      if($el!="") {
        $zrleer = 0;
        $jsart = 2.02;
        if($jsleer==2.03) {
          $jsart = 2.06;
        }
        if($zfleer==0) {
          $jsart = 2.04;
          if($jsleer==2.03) {
            $jsart = 2.07;
          }
          $zfleer = 0;
        }
        break;
      }
    }
    if($row->nrbooked==0) {
      $jsart = 2.3;
    }
    $document->addCustomTag(sem_f027($jsart));

// ---------------------------------
// Anzeige Reiter 
// ---------------------------------

    $knopfunten = "";
    if($art==3 OR $art==5) {
      $knopfunten = sem_f032(1);
      $zurueck = 0;
    } elseif($art==4) {
      $knopfunten = sem_f032(2);
      $zurueck = 1;
    } elseif($art>5) {
      $knopfunten = sem_f032(3);
      $zurueck = 23;
    }

// ---------------------------------
// Anzeige Funktionsknoepfe oben
// ---------------------------------

// Zurueck-Knopf anzeigen
    $knopfoben = sem_f071("javascript:auf('".$zurueck."','".$row->id."','');","1032","1004");
    $knopfunten .= sem_f072("auf('".$zurueck."','".$row->id."','')","1016","1004");

// Knopf fuer ICS-Datei anzeigen
    if($config->get('sem_p052',0)>0) {
      $knopfoben .= sem_f071(sem_f004()."index2.php?s=".sem_f036()."&amp;option=".JRequest::getCmd('option')."&amp;task=33&amp;cid=".$row->id,"3332","0130");
      $knopfunten .= sem_f072("document.location.href='".sem_f004()."index2.php?s=".sem_f036()."&amp;option=".JRequest::getCmd('option')."&amp;task=33&amp;cid=".$row->id,"3316","0130");
    }

// Knopf fuer Nachricht anzeigen
//     if(($usrid!=$row->publisher) AND ($my->id!=$row->publisher) AND $art!=2) {
    if($art<5 AND $user->id!=$row->publisher) {
      $knopfoben .= sem_f034(sem_f006(),$row->id,1);
      $knopfunten .= " ".sem_f034(sem_f006(),$row->id,2);
    }

// Google-Maps-Karte anzeigen
    if($row->gmaploc != "" AND $art!=5) {
      $knopfoben .= "<a title=\"".JTEXT::_('SEM_1016')."\" class=\"modal\" href=\"".sem_f004()."index2.php?option=".JRequest::getCmd('option')."&amp;task=35&amp;cid=".$row->id."\" rel=\"{handler: 'iframe', size: {x: ".$config->get('sem_p097',500).", y: ".$config->get('sem_p098',350)."}}\">".sem_f045("1332",JTEXT::_('SEM_1016'))."</a>";
      $knopfunten .= " <a class=\"modal\" border=\"0\" href=\"".sem_f004()."index2.php?option=".JRequest::getCmd('option')."&amp;task=35&amp;cid=".$row->id."\" rel=\"{handler: 'iframe', size: {x: ".$config->get('sem_p097',500).", y: ".$config->get('sem_p098',350)."}}\"><button class=\"button\" style=\"cursor:pointer;\" type=\"button\">".sem_f045("1316",JTEXT::_('SEM_1016'))."&nbsp;".JTEXT::_('SEM_1016')."</button></a>";
    }

// Druckknopf anzeigen
//     if($art!=5 AND $art!=7) {    
      $knopfoben .= sem_f037(2,$row->id,'','');
      $knopfunten .= " ".sem_f037(2,$row->id,'','b');
//     }

// Buchungsbutton anzeigen
//     if((($buchopt[0]>2 AND $art==0) OR ($art==3 AND $usrid==0 AND ($nametemp!="" OR $config->get('sem_p026',0)==1))) AND $row->cancelled==0 AND $row->nrbooked>0) {
    if((($buchbar AND $art==3) OR ($art==6 AND $uid==0 AND ($nametemp!="" OR $config->get('sem_p026',0)==1))) AND $row->cancelled==0 AND $row->nrbooked>0) {
      $knopfoben .= sem_f071("javascript:auf('5','".$row->id."','');","1132","0087");
      $knopfunten .= sem_f072("auf('5','".$row->id."','')","1116","0087");
    }

// Aenderungen speichern Veranstalter
//      if($art==3 And $usrid!=0 AND ($row->nrbooked>1 OR $zfleer==0)) {
     if($art==6 And $uid>0 AND ($row->nrbooked>1 OR $zfleer==0)) {
      $knopfoben .= sem_f071("javascript:auf('".$modify."','".$row->id."','".$buchungswerte->id."');","1432","1045");
      $knopfunten .= sem_f072("auf('".$modify."','".$row->id."','".$buchungswerte->id."')","1416","1045");
    }

// Aenderungen speichern Benutzer falls noch nicht gezahlt
    if($art==4 AND strtotime("$row->booked")-time()>=($config->get('sem_p018',0)*24*60*60) AND $buchungswerte->paid==0) {
      if($config->get('sem_p022',"")==1 AND ($row->nrbooked>1 OR $zfleer==0)) {
        $knopfoben .= sem_f071("javascript:auf('".$modify."','".$row->id."','".$buchungswerte->id."');","1432","1045");
        $knopfunten .= sem_f072("auf('".$modify."','".$row->id."','".$buchungswerte->id."')","1416","1045");
      }
    }

// PayPal-Bezahlung aus gebuchte Kurse
    if($art==4 AND $buchungswerte->paid==0 AND $row->fees>0 AND (sem_f067($config->get('sem_p109',''),"voll") OR sem_f067($config->get('sem_p110',''),"voll"))) {
      $knopfoben .= sem_f071("javascript:auf('36','".$row->id."','".$buchungswerte->id."');","3432","1060");
      $knopfunten .= sem_f072("auf('36','".$row->id."','".$buchungswerte->id."')","3416","1060");
    }

// PayPal-Bezahlung nach Buchung
      $htxt = "";
      if($art==5 AND $buchungswerte->paid==0 AND $row->fees>0 AND (sem_f067($config->get('sem_p109',''),"voll") OR sem_f067($config->get('sem_p110',''),"voll"))) {
        $knopfoben .= sem_f071("javascript:pp();","3432","1060");
        $knopfunten .= sem_f072("pp()","3416","1060");
        $htxt = sem_f084($buchungswerte->id);
      }

// Buchung stornieren Benutzer falls noch nicht gezahlt
    if($art==4 AND strtotime("$row->booked")-time()>=($config->get('sem_p018',0)*24*60*60) AND $buchungswerte->paid==0) {
      if($config->get('sem_p018',0)>-1) {
        $knopfoben .= sem_f071("javascript:auf('6','".$buchungswerte->id."','');","1532","1012");
        $knopfunten .= sem_f072("auf('6','".$buchungswerte->id."','')","1516","1012");
      }
    }

// obere Knoepfe anzeigen
    if($config->get('sem_p024',2)==0 OR $config->get('sem_p024',2)==2) {
      echo $knopfoben;
    }
    
    $html = "</td></tr>".sem_f023('e').$htxt."\n".sem_f026(1).sem_f023(4)."<tr><td class=\"sem_anzeige\">";
// ---------------------
// Anzeige Kurstitel
// ---------------------

    $layout = sem_f047();
    switch($art) {
      case 5:
        $html .= $layout->booked;
        break;
      case 6:
        $html .= $layout->booking;
        break;
      default:
        $html .= $layout->event;
        break;
    }

// ---------------------------------
// Anzeige Funktionsknoepfe unten
// ---------------------------------

    if($config->get('sem_p024',2)>0) {
      $html .= sem_f023(4)."<tr>".sem_f022($knopfunten,'d','c','100%','sem_nav_d')."</tr>".sem_f023('e');
    }

// ---------------------------------------
// Ausgabe der unsichtbaren Formularfelder
// ---------------------------------------

    if($row->nrbooked <= 1 OR $config->get('sem_p023','') < 1) {
      $html .= "<input type=\"hidden\" id=\"RequestedRecords\" name=\"nrbooked\" value=\"1\">";
    }
    $html .= "<input type=\"hidden\" id=\"sem_fee\" name=\"sem_fee\" value=\"".$row->fees."\">";
    $selfbooked = $buchungswerte->nrbooked;
    if(sem_f067($selfbooked,"leer")) {
      $selfbooked = 0;
    }
    $html .= "<input type=\"hidden\" id=\"sem_selfbooked\" name=\"sem_selfbooked\" value=\"".$selfbooked."\">";
    $html .= "<input type=\"hidden\" id=\"sem_spacesfree\" name=\"sem_spacesfree\" value=\"SEM_FREESPACES\">";
    $html .= "<input type=\"hidden\" id=\"sem_spacesbooked\" name=\"sem_spacesbooked\" value=\"SEM_BOOKEDSPACES\">";
    $uidtemp = -1;
    if($art==6){
      if($buchungswerte->id>0) {
        $uidtemp = $buchungswerte->id;
      } elseif($nametemp=="") {
        $uidtemp = -2;
      } else {
        $uidtemp = "";
      }
    }
    $html .= sem_f014(3,$catid,$search,$limit,$limitstart,$row->id,$dateid,$uidtemp)."</td></tr>";
    switch($art) {
      case 5:
        $html = sem_f054($html,$row,$art,$buchungswerte,$ueberschrift);
        break;
      case 6:
        $html = sem_f054($html,$row,$art,$buchungswerte);
        break;
      default:
        $html = sem_f054($html,$row,$art,"",$ueberschrift);
        break;
    }
    echo $html;
  }

// ++++++++++++++++++++++++++++++++++++
// +++ Seminar bearbeiten +++
// ++++++++++++++++++++++++++++++++++++

  function sem_g006($row,$search,$catid,$limit,$limitstart,$dateid) {
    JFilterOutput::objectHTMLSafe($row);
    $config = &JComponentHelper::getParams('com_seminar');
    $document = &JFactory::getDocument();
    $document->addCustomTag(sem_f027(3 + $config->get('sem_p032',0)));
    JHTML::_('behavior.modal');
    JHTML::_('behavior.calendar');
    JHTML::_('behavior.tooltip');

// ---------------------------------
// Anzeige Kopfbereich mit Auswahl
// ---------------------------------

    echo sem_f026(3);
    $knopfunten = sem_f032(3);
    $knopfoben = sem_f071("javascript:auf(2,'','');","1032","1004");
    $knopfunten .= sem_f072("auf(2,'','')","1016","1004");
    $knopfoben .= sem_f071("javascript:auf(10,'".$row->id."','');","1432","1037");
    $knopfunten .= sem_f072("auf(10,'".$row->id."','')","1416","1037");
    if($row->id>0) {
      $knopfoben .= sem_f071("javascript:auf(12,'".$row->id."','');","1232","0044");
      $knopfunten .= sem_f072("auf(12,'".$row->id."','')","1216","0044");
      $knopfoben .= sem_f071("javascript:auf(11,'".$row->id."','');","1532","1014");
      $knopfunten .= sem_f072("auf(11,'".$row->id."','')","1516","1014");
    }
    if($config->get('sem_p024',2)==0 OR $config->get('sem_p024',2)==2) {
      echo $knopfoben;
    }
    $html = "</td></tr>".sem_f023('e')."\n".sem_f023(4)."<tr><td class=\"sem_anzeige\">";

// ---------------------------------
// Anzeige Bereichsueberschrift
// ---------------------------------

    if($row->id == "") {
      $temp1 = JTEXT::_('SEM_0060');
      $temp2 = JTEXT::_('SEM_1029');
    } else {
      $temp1 = JTEXT::_('SEM_0051');
      $temp2 = JTEXT::_('SEM_1015');
    }
    $html .= "<table cellpadding=\"2\" cellspacing=\"0\" border=\"0\" width=\"100%\">";
    $html .= "\n<tr><td class=\"sem_cat_title\">".$temp1."</td></tr>";
    if($temp2!="") {
      $html .= "\n<tr><td class=\"sem_cat_desc\">".$temp2."</td></tr>";
    }
    $html .= "\n</table>";

// ---------------------------------
// Anzeige Eingabefelder
// ---------------------------------

    $html .= sem_f023(4).sem_f008($row,1).sem_f023('e');

// ---------------------------------
// Anzeige Funktionsknoepfe unten
// ---------------------------------

    if($config->get('sem_p024',2)>0) {
      $html .= sem_f023(4)."<tr>".sem_f022($knopfunten,'d','c','100%','sem_nav_d')."</tr>".sem_f023('e');
    }

// ---------------------------------------
// Ausgabe der unsichtbaren Formularfelder
// ---------------------------------------

    if($row->published == "") {
      $html .= "\n<input type=\"hidden\" name=\"published\" value=\"1\" />";
    } else {
      $html .= "\n<input type=\"hidden\" name=\"published\" value=\"".$row->published."\" />";
    }
    if(sem_f042()<6) {
      $html .= "<input type=\"hidden\" name=\"publisher\" value=\"".$row->publisher."\" />";
    }
    $html .= "<input type=\"hidden\" name=\"id\" value=\"".$row->id."\" />";
    $html .= sem_f014("",$catid,$search,$limit,$limitstart,0,$dateid,-1);
    echo $html;
  }
  
// ++++++++++++++++++++++++++++++++++++
// +++ Buchungen ansehen            +++
// ++++++++++++++++++++++++++++++++++++

  function sem_g010($art,$rows,$search,$limit,$limitstart,$kurs,$catid,$dateid) {
    $document = &JFactory::getDocument();
    $document->addCustomTag(sem_f027(0));
    $config = &JComponentHelper::getParams('com_seminar');
    $database = &JFactory::getDBO();
    $my = &JFactory::getuser();
    JHTML::_('behavior.modal');
    JHTML::_('behavior.tooltip');

// ---------------------------------
// Anzeige Kopfbereich mit Auswahl
// ---------------------------------

    $buchopt = sem_f021(0,$kurs,0);
    echo sem_f026(1);
    $knopfunten = sem_f032(($art+1));
    $zurueck = array(0,1,2,24);
    $knopfoben = sem_f071("javascript:auf(".$zurueck[$art].",'','');","1032","1004");
    $knopfunten .= sem_f072("auf(".$zurueck[$art].",'','')","1016","1004");
    if($art>1) {
      $knopfoben .= sem_f034(sem_f006(),$kurs->id,3);
      $knopfunten .= " ".sem_f034(sem_f006(),$kurs->id,4);
    }
    if( count($rows)>0 AND $art>1) {
      $knopfoben .= sem_f037(7,$kurs->id,'','');
      $knopfunten .= " ".sem_f037(7,$kurs->id,'','b');
      $knopfoben .= sem_f037(5,$kurs->id,'','');
      $knopfunten .= " ".sem_f037(5,$kurs->id,'','b');
//       $database->setQuery("SELECT COUNT(*) AS count FROM #__semattendees WHERE semid = $kurs->id");
//       $temp = $database->loadObject();
//       if ($temp->count > 0) {
        $knopfoben .= sem_f071("javascript:auf(25,'".$kurs->id."','');","1632","0181");
        $knopfunten .= sem_f072("auf(25,'".$kurs->id."','')","1616","0181");
//       }
    }
    $nametemp = sem_f011($kurs);
    if($art>1 AND ($nametemp!="" OR $config->get('sem_p026',0)==1) AND $kurs->cancelled==0 AND $kurs->nrbooked>0) {
      $knopfoben .= sem_f071("javascript:auf('28','".$kurs->id."','');","1132","0087");
      $knopfunten .= sem_f072("auf('28','".$kurs->id."','')","1116","0087");
    }
    if($config->get('sem_p024',2)==0 OR $config->get('sem_p024',2)==2) {
      echo $knopfoben;
    }
    $html = "</td></tr>".sem_f023('e')."\n".sem_f023(4)."<tr><td class=\"sem_anzeige\">";

// ---------------------------------
// Anzeige Bereichsueberschrift
// ---------------------------------

    $htxt = $kurs->title;
    if($kurs->cancelled==1) {
      $htxt .= " (<span class=\"sem_cancelled\">".JTEXT::_('SEM_0103')."</span>)";
    }
    $temp1 = str_replace('SEM_TITLE',$htxt,JTEXT::_('SEM_1040'));
    $html .= "<table cellpadding=\"2\" cellspacing=\"0\" border=\"0\" width=\"100%\">";
    $html .= "\n<tr><td class=\"sem_cat_title\">".JTEXT::_('SEM_1041')."</td></tr>";
    if($temp1!="") {
      $html .= "\n<tr><td class=\"sem_cat_desc\">".$temp1."</td></tr>";
    }
    $html .= "\n</table>";

// ---------------------------------
// Anzeige der Spaltenueberschriften
// ---------------------------------

    $html .= sem_f023(4)."<tr>";
    if($art==2) {
      $html .= sem_f022('&nbsp;','h','c',14,'sem_row');
    }
    $html .= sem_f022(JTEXT::_('SEM_0059'),'h','l','','sem_row');
    if($art==2) {
      $html .= sem_f022(JTEXT::_('SEM_0052'),'h','l','','sem_row');
      $html .= sem_f022(JTEXT::_('SEM_0032'),'h','c','','sem_row');
    }

    $zusfeld = sem_f017($kurs);
    for($i=0;$i<count($zusfeld[0]);$i++) {
      if($zusfeld[3][$i]==1) {
        $zustmp = explode("|",$zusfeld[0][$i]);
        $html .= sem_f022($zustmp[0],'h','l','','sem_row');
      }
    }
    $html .= sem_f022(JTEXT::_('SEM_0080'),'h','c','','sem_row');
    if($art==2) {
      if( $kurs->fees > 0) {
        $html .= sem_f022(JTEXT::_('SEM_0065'),'h','c','','sem_row');
      }        
      $html .= sem_f022(JTEXT::_('SEM_0040'),'h','c','','sem_row');
      if($config->get('sem_p004',0)>0) {
        $html .= sem_f022(JTEXT::_('SEM_0055'),'h','c','','sem_row');
      }
    }
    $html .= sem_f022(JTEXT::_('SEM_0069'),'h','c',12,'sem_row');
    $html .= "</tr>";

// ---------------------------------
// Anzeige der einzelnen Buchungen
// ---------------------------------

    $n = count($rows);
    if( $n > 0 ) {
      $neudatum = sem_f046();
      $anzahl = 0;
      foreach ($rows as $row) {
        if($config->get('sem_p058',0)==0 AND $art<2) {
          $row->name = $row->username;
        }
        if($row->userid==0) {
          $row->name = $row->aname;
          $row->email = $row->aemail;
        }
        $anzahl = $anzahl + $row->nrbooked;
        $bild = "2502.png";
        $altbild = JTEXT::_('SEM_0030');
        if( $anzahl > $kurs->maxpupil ) {
          if( $kurs->stopbooking < 1 ) {
            $bild = "2501.png";
            $altbild = JTEXT::_('SEM_0025');
          } else {
            $bild = "2500.png";
            $altbild = JTEXT::_('SEM_0029');
          }
        }
        if($kurs->cancelled==1) {
          $bild = "2500.png";
          $altbild = JTEXT::_('SEM_0029');
        }
        $certtitel = JTEXT::_('SEM_0091');
        if($row->certificated == 1) {
          $certtitel = JTEXT::_('SEM_0090');
        }
        $paidtitel = JTEXT::_('SEM_0064');
        if($row->paid == 1) {
          $paidtitel = JTEXT::_('SEM_0063');
        }
        $html .= "\n<tr>";
        if($art==2) {
          $htxt = "<a title=\"".JTEXT::_('SEM_1012')."\" href=\"javascript:auf(7,'".$row->sid."','');\"><img src=\"".sem_f006()."2202.png\" border=\"0\"></a>";
          $html .= sem_f022($htxt,'d','c',14,"sem_row");
        }
        $htxt = $row->name;
        if($art==2) {
          $htxt = "<a href=\"javascript:auf('28','".$kurs->id."','".$row->sid."');\">".$row->name."</a>";
        }
        $html .= sem_f022($htxt,'d','l','',"sem_row");
        if($art==2) {
          $html .= sem_f022("<a href=\"mailto:".$row->email."\">".$row->email."</a>",'d','l','',"sem_row");
          $html .= sem_f022(JHTML::_('date',$row->bookingdate,$config->get('sem_p068',JTEXT::_('SEM_0168')),0),'d','c','',"sem_row");
        }
        $zustemp = sem_f017($row);
        for($i=0;$i<count($zusfeld[0]);$i++) {
          if($zusfeld[3][$i]==1) {
            $html .= sem_f022($zustemp[0][$i],'d','l','','sem_row');
          }
        }
        $html .= sem_f022($row->nrbooked,'d','c','',"sem_row");
        if($art==2) {
          if($kurs->fees>0) {
            $htxt = "&nbsp;";
            if($anzahl <= $kurs->maxpupil) {
              $htxt = "<a title=\"".$paidtitel."\" href=\"javascript:auf(14,'".$row->sid."','');\"><img src=\"".sem_f006()."220".$row->paid.".png\" border=\"0\" align=\"absmiddle\"></a>";
            }
            $html .= sem_f022($htxt,'d','c','',"sem_row");
          }

// Zertifikat
          $htxt = "&nbsp;";
          if($anzahl <= $kurs->maxpupil) {
            $htxt = "<a title=\"".$certtitel."\" href=\"javascript:auf(13,'".$row->sid."','');\"><img src=\"".sem_f006()."220".$row->certificated.".png\" border=\"0\" align=\"absmiddle\"></a>";
            if($row->certificated == 1) {
              $htxt .= "<a title=\"".JTEXT::_('SEM_0092')."\" class=\"modal\" href=\"".sem_f004()."index2.php?option=com_seminar&amp;tesk=".base64_encode("16||".$row->uniqid)."\" rel=\"{handler: 'iframe', size: {x: ".$config->get('sem_p097',500).", y: ".$config->get('sem_p098',350)."}}\">".sem_f045("2900",JTEXT::_('SEM_0092'))."</a>";
            }
          }
          $html .= sem_f022($htxt,'d','c','',"sem_row");

// Bewertung
          if($config->get('sem_p004',0)>0) {
            $hinttext = JTEXT::_('SEM_0055')."::".htmlspecialchars($row->comment);
            $htxt = "<img src=\"".sem_f006()."240".$row->grade.".png\" class=\"editlinktip hasTip\" title=\"".$hinttext."\">";
            $html .= sem_f022($htxt,'d','c','',"sem_row");
          }
        }
        $html .= sem_f022("<img src=\"".sem_f006().$bild."\" border=\"0\" alt=\"".$altbild."\">",'d','c','',"sem_row");
        $html .= "\n</tr>";
      }
    } else {
      $spalten = 3;
      if($art==2) {
        $spalten = 9;
      }
      $html .= "\n<tr>".sem_f022(JTEXT::_('SEM_0061'),'d','l','','sem_row',$spalten)."</tr>";
    }
    $html .= sem_f023('e');

// ---------------------------------------
// Ausgabe der unsichtbaren Formularfelder
// ---------------------------------------

    if($kurs->nrbooked <= 1 || $config->get('sem_p023','') < 1) {
      $html .= "<input type=\"hidden\" name=\"nrbooked\" value=\"1\">";      
    }
    $html .= sem_f014($zurueck[$art],$catid,$search,$limit,$limitstart,0,$dateid,-1);

// ---------------------------------------
// Farbbeschreibungen anzeigen
// ---------------------------------------

    $html .= sem_f029(JTEXT::_('SEM_0030'),JTEXT::_('SEM_0025'),JTEXT::_('SEM_0029'));

// ---------------------------------
// Anzeige Funktionsknoepfe unten
// ---------------------------------

    if($config->get('sem_p024',2)>0) {
      $html .= sem_f023(4)."<tr>".sem_f022($knopfunten,'d','c','100%','sem_nav_d')."</tr>".sem_f023('e');
    }
    echo $html;
  }

// +++++++++++++++++++++++++++++++++++++++++++++++
// +++ Bewertungsfenster ausgeben        +++
// +++++++++++++++++++++++++++++++++++++++++++++++

  function sem_g014($row,$buchung) {
    $htxt = str_replace("SEM_TITLE",$row->title,JTEXT::_('SEM_1017'));
    $html = "\n<body onload=\"parent.sbox-window.focus();\">";
    $html .= sem_f026(1)."<div class=\"sem_cat_title\">".JTEXT::_('SEM_1020')."</div><br />";
    $html .= "<div class=\"sem_shortdesc\">".$htxt."</div>";
    $html .= "<br /><center><table cellpadding=\"2\" cellspacing=\"0\" border=\"0\">";
    $tempa = "";
    $tempb = "";
    for ($i=6; $i>0; $i=$i-1) {
      $tempa .= "<th><img src=\"".sem_f006()."240".$i.".png\"></th><td width=\"10px\">&nbsp;</td>";
      $tempb .= "<th><input type=\"radio\" name=\"grade\" value=\"".$i."\"";
      if( $i==$buchung->grade) {
        $tempb .= " checked";
      }
      $tempb .= "></th><td width=\"10px\">&nbsp;</td>";
    }
    $html .= "<tr>".$tempa."</tr>";
    $html .= "<tr>".$tempb."</tr>";
    $html .= "</table></center>";
    $html .= "<br /><div class=\"sem_shortdesc\">".JTEXT::_('SEM_0042').":</div>";
    $html .= "<br /><center><input type=\"text\" name=\"text\" size=\"70\" maxlength=\"200\" value=\"".$buchung->comment."\"></center><br />";
    $html .= "<input type=\"hidden\" name=\"option\" value=\"".JRequest::getCmd('option')."\"><input type=\"hidden\" name=\"cid\" value=\"".$row->id."\"><input type=\"hidden\" name=\"task\" value=\"21\">";
    $html .= "<center><button class=\"button\" style=\"cursor:pointer;\" type=\"button\" onclick=\"this.disabled=true;document.FrontForm.submit();\">".JTEXT::_('SEM_1038')."</button></center>";
    $html .= "</form>";
    $html .= "</body></html>";
    echo $html;
    exit;
  }

// +++++++++++++++++++++++++++++++++++++++++++++++
// +++ Nachricht an Veranstalter senden        +++
// +++++++++++++++++++++++++++++++++++++++++++++++

  function sem_g016($art,$row) {
    if($art==1) {
      $htxt = str_replace("SEM_TITLE",$row->title,JTEXT::_('SEM_1021'));
    } else {
      $htxt = str_replace("SEM_TITLE",$row->title,JTEXT::_('SEM_1047'));
    }
    $html = "\n<body onload=\"parent.sbox-window.focus();\">";
    $html .= sem_f026(1)."<div class=\"sem_cat_title\">".JTEXT::_('SEM_1028')."</div><br />";
    $html .= "<div id=\"loader\" style=\"position: absolute; top:113; left:188; width:124px; height:124px; z-Index:10001; display: none;\"><img src=\"".sem_f006()."loader.gif\" width=\"124px\" height=\"124px\" style=\"width:124px; height:124px;\"></div>";
    $html .= "<div class=\"sem_shortdesc\">".$htxt."</div><br />";
    $html .= "<center><textarea name=\"text\" rows=\"10\" cols=\"50\"></textarea></center>";
    $html .= "<input type=\"hidden\" name=\"option\" value=\"".JRequest::getCmd('option')."\"><input type=\"hidden\" name=\"cid\" value=\"".$row->id."\"><input type=\"hidden\" name=\"uid\" value=\"".$art."\"><input type=\"hidden\" name=\"task\" value=\"22\">";
    $html .= "<br /><center><button class=\"button\" style=\"cursor:pointer;\" type=\"button\" onclick=\"this.disabled=true;document.FrontForm.submit();\">".JTEXT::_('SEM_1038')."</button></center>";
    $html .= "</form>";
    $html .= "</body></html>";
    echo $html;
    exit;
  }

// +++++++++++++++++++++++++++++++++++++++++++++++
// +++ Bewertung abgegeben                     +++
// +++++++++++++++++++++++++++++++++++++++++++++++

  function sem_g021($grade,$cid) {
    $html = "\n<body onload=\"parent.sbox-window.focus();\">";
    $html .= "<script language=\"javascript\">window.parent.document.getElementById('graduate".$cid."').src='".sem_f006()."240".$grade.".png';window.parent.document.getElementById('sbox-window').close();</script>";
    echo $html;
    exit;
  }

// +++++++++++++++++++++++++++++++++++++++++++++++
// +++ AGB anzeigen                            +++
// +++++++++++++++++++++++++++++++++++++++++++++++

  function sem_g020() {
    $config = &JComponentHelper::getParams('com_seminar');
    $html = "\n<body onload=\"parent.sbox-window.focus();\">";
    $html .= nl2br($config->get('sem_p020',""));
    $html .= "</body></html>";
    echo $html;
    exit;
  }

// +++++++++++++++++++++++++++++++++++++++++++++++
// +++ Nachricht an Veranstalter verschickt    +++
// +++++++++++++++++++++++++++++++++++++++++++++++

  function sem_g022($reason) {
    $html = "\n<body onload=\"parent.sbox-window.focus();\">";
    $html .= "<center><table width=\"80%\" height=\"100%\" border=\"0\"><tr><td align=\"center\"><div class=\"sem_title\">".$reason."</div>";
    $html .= "</td></tr></table></center>";
    $html .= "</body></html>";
    echo $html;
    exit;
  }

// +++++++++++++++++++++++++++++
// +++ RSS-Feed erzeugen     +++
// +++++++++++++++++++++++++++++

  function sem_g023($rows) {
    header("Content-Type: application/rss+xml; charset=UTF-8");
    $mainconfig =& JFactory::getConfig();
    $config = &JComponentHelper::getParams('com_seminar');
    $sprache =& JFactory::getLanguage();
    $html = "\n<rss version=\"2.0\">";
    $html .= "\n<channel>";
    $html .= "\n<title>".$mainconfig->getValue('config.sitename')." - ".JTEXT::_('SEM_0083')."</title>";
    $html .= "\n<link>".JURI::ROOT()."index2.php?s=".sem_f036()."&amp;option=".JRequest::getCmd('option')."&amp;task=31</link>";
    $html .= "\n<description>Kurze Beschreibung des Feeds</description>";
    $html .= "\n<language>".$sprache->getTag()."</language>";
    $html .= "\n<copyright>".$mainconfig->getValue('config.fromname')."</copyright>";
    $html .= "\n<ttl>60</ttl>";
    $html .= "\n<pubDate>".date("r")."</pubDate>";
    
    foreach($rows AS $row) {
      $user = &JFactory::getuser($row->publisher);
      $cancelled = "";
      if($row->cancelled==1) {
        $cancelled = " - ".JTEXT::_('SEM_0103');
      }
      $html .= "\n<item>";
      $html .= "\n<title>".$row->title.$cancelled."</title>";
      $html .= "\n<description>".JTEXT::_('SEM_0009').": ".JHTML::_('date',$row->begin,$config->get('sem_p067',JTEXT::_('SEM_0167')),0)." - ".$row->shortdesc."</description>";
      $html .= "\n<link>".JURI::ROOT()."index.php?option=".JRequest::getCmd('option')."&amp;task=3&amp;cid=".$row->id."</link>";
      if($config->get('sem_p050',0)>0) {
        $html .= "\n<author>".$user->name.", ".$user->email."</author>";
      }
      $html .= "\n<guid>".sem_f002($row->id)."</guid>";
      $html .= "\n<category>".$row->category."</category>";
      $html .= "\n<pubDate>".date("r",strtotime($row->publishdate))."</pubDate>";
      $html .= "\n</item>";
    }
    $html .= "\n</channel>";
    $html .= "\n</rss>";
    echo $html;
    exit;
  }

// +++++++++++++++++++++++++++++
// +++ Google-Map ausgeben   +++
// +++++++++++++++++++++++++++++

  function sem_g027($row,$ziel,$ort) {
    header("Content-type: text/html; charset=UTF-8");
    $config = &JComponentHelper::getParams('com_seminar');
    if($ziel=="") {
      $ziel = $row->gmaploc;
    }
    if($ort=="") {
      $ort = nl2br($row->place);
    } else {
      $ort = str_replace("|","<br />",$ort);
    }
    $html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"  \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">";
    $html .= "\n<html xmlns=\"http://www.w3.org/1999/xhtml\">";
    $html .= "\n<head><meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\"/>";
    $html .= "\n<title>Seminar Google Map</title>";
    $html .= "\n<script type=\"text/javascript\" src=\"http://maps.google.com/maps/api/js?sensor=false\"></script>\n<script type=\"text/javascript\">";
    $html .= "\nvar map = null;";
    $html .= "\nvar geocoder = null;";
    $html .= "\nfunction load() {";
    $html .= "\n  map = new google.maps.Map(document.getElementById(\"map\"), {";
    $html .= "\n    zoom: 15,";
    $html .= "\n    mapTypeId: google.maps.MapTypeId.ROADMAP,";
    $html .= "\n    mapTypeControl: true,";
    $html .= "\n    mapTypeControlOptions: {";
    $html .= "\n      position: google.maps.ControlPosition.TOP_RIGHT,";
    $html .= "\n      style: google.maps.MapTypeControlStyle.DEFAULT";
    $html .= "\n    },";
    $html .= "\n    navigationControl: true,";
    $html .= "\n    navigationControlOptions: {";
    $html .= "\n      position: google.maps.ControlPosition.TOP_LEFT,";
    $html .= "\n      style: google.maps.NavigationControlStyle.DEFAULT";
    $html .= "\n    }";
    $html .= "\n  });";
    $html .= "\n  geocoder = new google.maps.Geocoder();";
    $html .= "\n}";
    $html .= "\n function showAddress() {";  
    $html .= "\n   var address = \"".$ziel."\";";
    $html .= "\n  geocoder.geocode(";
    $html .= "\n    { 'address': address },";
    $html .= "\n    function(point, status) {";
    $html .= "\n      if (status == google.maps.GeocoderStatus.OK) {";
    $html .= "\n        map.setCenter(point[0].geometry.location);";
    $html .= "\n        var marker = new google.maps.Marker({";
    $html .= "\n          map: map,";
    $html .= "\n          position: point[0].geometry.location,";
    $html .= "\n          icon: new google.maps.MarkerImage (";
    $html .= "\n            \"".sem_f006()."pin.png\",";
    $html .= "\n            new google.maps.Size(20, 34),";
    $html .= "\n            new google.maps.Point(0, 0),";
    $html .= "\n            new google.maps.Point(0, 34)";
    $html .= "\n          ),";
    $html .= "\n          shadow: new google.maps.MarkerImage (";
    $html .= "\n            \"".sem_f006()."shadow.png\",";
    $html .= "\n            new google.maps.Size(40, 34),";
    $html .= "\n            new google.maps.Point(0, 0),";
    $html .= "\n            new google.maps.Point(0, 34)";
    $html .= "\n          ),";
    $html .= "\n          title: \"".JTEXT::_('SEM_0197')."\"";
    $html .= "\n        });";

    $text = "<div id='content' style='font-family: Arial, Tahoma; font-size: 11px; line-height: 1.5;'>";
    $text .= "<form name='gmap' target='_new' method='get' action='http://maps.google.com/maps' style='display: inline;'>";
    $text .= "<input type='hidden' name='daddr' value='".$ziel."'>";
    $text .= "<input type='hidden' name='f' value='d'>";
    $text .= "<input type='hidden' name='hl' value=''>";
    $text .= "<input type='hidden' name='ie' value='UTF8'>";
    $text .= "<input type='hidden' name='z' value=''>";
    $text .= "<input type='hidden' name='om' value='0'>";
    $text .= "<b>".JTEXT::_('SEM_0198').":</b><br/>";
    $text .= "<input type='text' size='35' name='saddr' style='font-family: Arial, Tahoma; font-size: 10px; margin-left: 10px;'><br />";
    $text .= "<b>".JTEXT::_('SEM_0199').":</b><br/>";
    $text .= "<div style='margin-left: 10px; font-size: 10px;'>".preg_replace("(\r\n|\n|\r)","",$ort)."</div>";
    $text .= "<div style='text-align: center; padding-top: 5px;'>".str_replace("\"","\'",sem_f072("document.gmap.submit()","1312","0197","font-family: Arial, Tahoma; font-size: 10px;"))."</div>";
    $text .= "</form>";
    $text .= "</div>";

    $html .= "\n        var infowindow = new google.maps.InfoWindow({ content: \"".$text."\" });";
    if($config->get('sem_p013',1)==1) {
      $html .= "\n        infowindow.open(map, marker);";
    }
    $html .= "\n        google.maps.event.addListener(marker, 'click', function() {";
    $html .= "\n          infowindow.open(map, marker);";
    $html .= "\n        });";
    $html .= "\n      }";
    $html .= "\n    }";
    $html .= "\n  );";
    $html .= "\n}";
    $html .= "\n</script>";
    $html .= "\n</head>";
    $html .= "\n<body bgcolor=\"#000000\" marginwidth=\"0\" marginheight=\"0\" topmargin=\"0\" leftmargin=\"0\" onload=\"load(); showAddress();\">";
    $html .= "\n<div id=\"map\" style=\"width: ".$config->get('sem_p097',500)."px; height: ".$config->get('sem_p098',350)."px\"></div>";
    $html .= "\n</body></html>";
    echo $html;
    exit;
  }
}
?>