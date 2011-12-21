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

defined('_JEXEC') or die('Restricted access');

class HTML_Seminar {

// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// + Ausgabe der Kursuebersicht                           +
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  function sem_g027($rows,$listen,$search,$pageNav,$limitstart,$limit) {
    $config = &JComponentHelper::getParams('com_seminar');
    JHTML::_('behavior.modal');
    $html = sem_f026(2)."\n<script type=\"text/javascript\">";
    $html .= "function auf(stask, suid) {";
    $html .= "document.adminForm.task.value = stask;";
    $html .= "document.adminForm.uid.value = suid;";
    $html .= "document.adminForm.submit();}</script>";

// --------------------------------------------------------
// Anlegen der Auswahlmaske
// --------------------------------------------------------

    $html .= "\n<center><table cellpadding=\"2\" cellspacing=\"0\" border=\"0\" width=\"100%\">";
    $temp3 = "\n<input type=\"text\" name=\"search\" value=\"".$search."\" class=\"inputbox\" onChange=\"document.adminForm.submit();\" />";
    $temp4 = "";
    if(count($rows)>0) {
      $temp4 = sem_f038(1,'');
    }
    $temp = array(JTEXT::_('SEM_2015').":",$listen[3],$listen[0],JTEXT::_('SEM_2012').":",$listen[1],$listen[2],JTEXT::_('SEM_0067').":",($temp3),($temp4));
    $tempa = array("nw","","","nw","","","nw","","");
    $tempb = array("r","l","c","r","l","c","r","l","r");
    $html .= "\n".sem_f024( "th", $tempa, $tempb, $temp, "");
    $html .= "\n</table></center>";

// ---------------------------------------
// Ausgabe der Kurstabelle
// ---------------------------------------

    $html .= "\n<table class=\"adminlist\"><thead>";
    $temp3 = "<input type=\"checkbox\" name=\"toggle\" value=\"\" onclick=\"checkAll(".count( $rows ).");\" />";
    $temp = array(($temp3),JTEXT::_('SEM_0007'),JTEXT::_('SEM_2016'),JTEXT::_('SEM_0008'),JTEXT::_('SEM_0009'),JTEXT::_('SEM_0010'),JTEXT::_('SEM_2014'),JTEXT::_('SEM_0095'),JTEXT::_('SEM_0035'),JTEXT::_('SEM_0055'),JTEXT::_('SEM_0058'),JTEXT::_('SEM_0069'),JTEXT::_('SEM_2013'),JTEXT::_('SEM_2003'),JTEXT::_('SEM_0057'));
    $tempa = array("","nw","nw","nw","nw","nw","nw","nw","nw","nw","nw","nw","nw","nw","nw");
    $html .= "\n".sem_f024( "th", $tempa, "", $temp, "");
    $html .= "</thead>";
    $html .= "<tbody>";
    $n = count($rows);
    if( $n > 0 ) {
      $k = 0;
      $neudatum = sem_f046();
      for ($i=0, $n; $i < $n; $i++) {
        $row = &$rows[$i];
        $gebucht = sem_f020($row);
        $gebucht = $gebucht->booked;
        $bild = "2502.png";
        $altbild = JTEXT::_('SEM_0045');
        if( $neudatum > $row->end ) {
          $bild = "2500.png";
          $altbild = JTEXT::_('SEM_0046');
        } else if( $neudatum > $row->begin ) {
          $bild = "2501.png";
          $altbild = JTEXT::_('SEM_0047');
        }
        $abild = "2502.png";
        $altabild = JTEXT::_('SEM_0053');
        if($row->maxpupil - $gebucht < 1 && $row->stopbooking == 1) {
          $abild = "2500.png";
          $altabild = JTEXT::_('SEM_2010');
        } else if($row->maxpupil - $gebucht < 1 && $row->stopbooking == 0) {
          $abild = "2501.png";
          $altabild = JTEXT::_('SEM_0025');
        }
        $bbild = "2502.png";
        $altbbild = JTEXT::_('SEM_0031');
        if($neudatum > $row->booked) {
          $bbild = "2500.png";
          $altbbild = JTEXT::_('SEM_0038');
        }
        $temp1 = "<input type=\"checkbox\" id=\"cb".$i."\" name=\"cid[]\" value=\"".$row->id."\" onclick=\"isChecked(this.checked);\" />";
        $temp2 = "<a href=\"index2.php?option=com_seminar\" onclick=\"return listItemTask('cb".$i."','12')\">"; 
        if(strlen($row->title)<30) {
          $temp2 .= $row->title;
        } else {
          $temp2 .= substr($row->title,0,27)."...";
        }
        $temp2 .= "</a>";
        if(strlen($row->category)<25) {
          $temp3 = $row->category;
        } else {
          $temp3 = substr($row->category,0,22)."...";
        }
        $task = $row->published ? "20" : "18";
        $img = $row->published ? "2201.png" : "2200.png";
        $temp4 = "<a href=\"javascript: void(0);\" onclick=\"return listItemTask('cb".$i."','".$task."')\"><img src=\"".sem_f006().$img."\" border=\"0\" alt=\"\" /></a>";
        $task = $row->cancelled ? "25" : "24";
        $img = $row->cancelled ? "2201.png" : "2200.png";
        $temp12 = "<a href=\"javascript: void(0);\" onclick=\"return listItemTask('cb".$i."','".$task."')\"><img src=\"".sem_f006().$img."\" border=\"0\" alt=\"\" /></a>";
        $temp5 = "<button type=\"button\" onclick=\"auf('29','".$row->id."');\" value=\"".$gebucht."\">".$gebucht."</button>";
        $temp6 = "<img src=\"".sem_f006().$bild."\" border=\"0\" alt=\"".$altbild."\">";
        $temp7 = "<img src=\"".sem_f006().$abild."\" border=\"0\" alt=\"".$altabild."\">";
        $temp8 = "<img src=\"".sem_f006().$bbild."\" border=\"0\" alt=\"".$altbbild."\">";
        $temp9 = "<img src=\"".sem_f006()."240".$row->grade.".png\" border=\"0\" alt=\"".JTEXT::_('SEM_0055')."\">";
        $temp10 = JHTML::_('date',$row->begin,$config->get('sem_p069',JTEXT::_('SEM_0169')),0).", ".JHTML::_('date',$row->begin,$config->get('sem_p070',JTEXT::_('SEM_0170')),0);
        $temp11 = JHTML::_('date',$row->end,$config->get('sem_p069',JTEXT::_('SEM_0169')),0).", ".JHTML::_('date',$row->end,$config->get('sem_p070',JTEXT::_('SEM_0170')),0);
        $temp = array($temp1,$temp2,$row->semnum,$temp3,$temp10,$temp11,$temp4,$temp12,$temp5,$temp9,$row->hits,$temp6,$temp7,$temp8,$row->id);
        $tempa = array("c","","c","","c","c","c","c","c","c","c","c","c","c","c");
        $klasse = "row".$k;
        $html .= "\n".sem_f024( "td", $tempa, "", $temp, $klasse);
        $k = 1 - $k;
      }
    } else {
      $html .= "\n<tr class=\"row0\"><td colspan=\"15\">".JTEXT::_('SEM_0062')."</td></tr>";
    }
    $html .= "\n</tbody>";
    $html .= "\n<tfoot><tr><th colspan=\"3\" nowrap=\"nowrap\">".JTEXT::_('SEM_0050').": ".sem_f040(2,$limit)."</th><th colspan=\"9\" nowrap=\"nowrap\">".$pageNav->getPagesLinks()."&nbsp;</th><th colspan=\"3\" nowrap=\"nowrap\">".$pageNav->getPagesCounter()."&nbsp;</th></tr></tfoot>";
    $html .= "\n</table>";

// ---------------------------------------
// Farbbeschreibungen anzeigen
// ---------------------------------------

    $html .= "\n<br /><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\"><tr>";
    $html .= "\n<th width=\"33%\" valign=\"top\"><table cellpadding=\"3\" cellspacing=\"0\" border=\"0\">";
    $temp1 = "<img src=\"".sem_f006()."2502.png\" border=\"0\" align=\"absmiddle\" /> ".JTEXT::_('SEM_0045');
    $temp = array(JTEXT::_('SEM_0069'),($temp1));
    $tempa = array("l","l");
    $tempb = array("nw","");
    $html .= "\n".sem_f024( "td", $tempa, $tempb, $temp, "");
    $temp1 = "<img src=\"".sem_f006()."2501.png\" border=\"0\" align=\"absmiddle\" /> ".JTEXT::_('SEM_0047');
    $temp = array("",($temp1));
    $tempa = array("","l");
    $html .= "\n".sem_f024( "td", $tempa, "", $temp, "");
    $temp1 = "<img src=\"".sem_f006()."2500.png\" border=\"0\" align=\"absmiddle\" /> ".JTEXT::_('SEM_0046');
    $temp = array("",($temp1));
    $tempa = array("","l");
    $html .= "\n".sem_f024( "td", $tempa, "", $temp, "");
    $html .= "</table></th>";
    $html .= "\n<th width=\"33%\" valign=\"top\"><table cellpadding=\"3\" cellspacing=\"0\" border=\"0\">";
    $temp1 = "<img src=\"".sem_f006()."2502.png\" border=\"0\" align=\"absmiddle\" /> ".JTEXT::_('SEM_0053');
    $temp = array(JTEXT::_('SEM_2013'),($temp1));
    $tempa = array("l","l");
    $tempb = array("nw","");
    $html .= "\n".sem_f024( "td", $tempa, $tempb, $temp, "");
    $temp1 = "<img src=\"".sem_f006()."2501.png\" border=\"0\" align=\"absmiddle\" /> ".JTEXT::_('SEM_0025');
    $temp = array("",($temp1));
    $tempa = array("","l");
    $html .= "\n".sem_f024( "td", $tempa, "", $temp, "");
    $temp1 = "<img src=\"".sem_f006()."2500.png\" border=\"0\" align=\"absmiddle\" /> ".JTEXT::_('SEM_2010');
    $temp = array("",($temp1));
    $tempa = array("","l");
    $html .= "\n".sem_f024( "td", $tempa, "", $temp, "");
    $html .= "</table></th>";
    $html .= "\n<th width=\"33%\" valign=\"top\"><table cellpadding=\"3\" cellspacing=\"0\" border=\"0\">";
    $temp1 = "<img src=\"".sem_f006()."2502.png\" border=\"0\" align=\"absmiddle\" /> ".JTEXT::_('SEM_0031');
    $temp = array(JTEXT::_('SEM_2003'),($temp1));
    $tempa = array("l","l");
    $tempb = array("nw","");
    $html .= "\n".sem_f024( "td", $tempa, $tempb, $temp, "");
    $temp1 = "<img src=\"".sem_f006()."2500.png\" border=\"0\" align=\"absmiddle\" /> ".JTEXT::_('SEM_0038');
    $temp = array("",($temp1));
    $tempa = array("","l");
    $html .= "\n".sem_f024( "td", $tempa, "", $temp, "");
    $html .= "</table></th>";
    $html .= "</tr></table>";

// --------------------------------------------------------
// Anlegen der zusaetzliche Variablen und HTML-Ausgabe
// --------------------------------------------------------

    $html .= "\n<input type=\"hidden\" name=\"option\" value=\"".JRequest::getCmd('option')."\" />";
    $html .= "<input type=\"hidden\" name=\"task\" value=\"\" />";
    $html .= "<input type=\"hidden\" name=\"uid\" value=\"\" />";
    $html .= "<input type=\"hidden\" name=\"boxchecked\" value=\"0\" />";
    $html .= "<input type=\"hidden\" name=\"limitstart\" value=\"".$limitstart."\" />";
    $html .= "\n</form>";
    echo $html;
  }

// +++++++++++++++++++++++++++++++++++++++
// +++ Editierformular anzeigen        +++
// +++++++++++++++++++++++++++++++++++++++

  function sem_g006($row,$art) {
    JRequest::setVar( 'hidemainmenu',1);
    JFilterOutput::objectHTMLSafe($row);
    $config = &JComponentHelper::getParams('com_seminar');
    $document = &JFactory::getDocument();
    $htxt = 5;
    if($art==3) {
      $htxt = 7;
    }
    $document->addCustomTag(sem_f027($htxt + $config->get('sem_p032',0)));
    JHTML::_('behavior.calendar');
    JHTML::_('behavior.tooltip');

    $html = sem_f026(4)."\n<table class=\"adminform\">".sem_f008($row,$art)."</table>";
    
// Automatisches Setzen eines neuen Seminars auf published

    $html .= sem_f015();
    if($row->published == "") {
      $row->published = 1;
    }
    $html .= "\n<input type=\"hidden\" name=\"published\" value=\"".$row->published."\" />";
    $html .= "\n<input type=\"hidden\" name=\"id\" value=\"".$row->id."\" />";
    $html .= "\n<input type=\"hidden\" name=\"option\" value=\"".JRequest::getCmd('option')."\" />";
    $html .= "\n<input type=\"hidden\" name=\"task\" value=\"\" /></form>";
    echo $html;
    echo JHTML::_('behavior.keepalive');
  }

// +++++++++++++++++++++++++++++++++++++++
// +++ Buchung fuer Kurs anzeigen      +++
// +++++++++++++++++++++++++++++++++++++++

  function sem_g029($kurs,$rows,$uid) {
    global $my;
    $config = &JComponentHelper::getParams('com_seminar');
    JHTML::_('behavior.modal');

// ---------------------------------------
// Ueberschrift
// ---------------------------------------

    $html = sem_f026(2)."\n<table width=\"100%\"><tr><th width=\"90%\" style=\"text-align:left\">".JTEXT::_('SEM_0048').": ".$kurs->title."</th>";
    $html .= "<td style=\"text-align: right; white-space: nowrap\">".sem_f038(2,$kurs->id).sem_f038(4,$kurs->id).sem_f038(5,$kurs->id)."</td></tr></table>";

// ---------------------------------------
// Ausgabe der Kurstabelle
// ---------------------------------------

    $html .= "\n<table class=\"adminlist\"><thead>";
    $temp3 = "<input type=\"checkbox\" name=\"toggle\" value=\"\" onclick=\"checkAll(".count( $rows ).");\" />";
    $temp = array($temp3,JTEXT::_('SEM_0059'),JTEXT::_('SEM_0052'),JTEXT::_('SEM_0032'),JTEXT::_('SEM_0033'));
    if( $kurs->fees > 0) {
      $temp[] = JTEXT::_('SEM_0065');
    }
    array_push($temp,JTEXT::_('SEM_0040'),JTEXT::_('SEM_0055'),JTEXT::_('SEM_0042'),JTEXT::_('SEM_0069'));
    $html .= "\n".sem_f024( "th", "", "", $temp, "");
    $html .= "</thead><tbody>";

// Schleife fuer die einzelnen Kurse

    $n = count($rows);
    if( $n > 0 ) {
      $k = 0;
      $neudatum = sem_f046();
      $anzahl = 0;
      $i = 0;
      foreach ($rows as $row) {
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
        $temp = array();
        $temp[] = "<input type=\"checkbox\" id=\"cb".$i."\" name=\"cid[]\" value=\"".$row->sid."\" onclick=\"isChecked(this.checked);\" />";
        $temp[] = $row->name;
        $temp[] = "<a href=\"mailto:".$row->email."\">".$row->email."</a>";
        $temp[] = JHTML::_('date',$row->bookingdate,$config->get('sem_p069',JTEXT::_('SEM_0169')),0).", ".JHTML::_('date',$row->bookingdate,$config->get('sem_p070',JTEXT::_('SEM_0170')),0);
        $temp[] = $row->nrbooked;
        $tempa = array("c","","","c","c");
        if( $kurs->fees > 0) {
          $htxt = "&nbsp;";
          if($anzahl<=$kurs->maxpupil) {
            $paidbild = "2200.png";
            $paidtitel = JTEXT::_('SEM_0064');
            if( $row->paid == 1) {
              $paidbild = "2201.png";
              $paidtitel = JTEXT::_('SEM_0063');
            }
            $htxt = "<a title=\"".$paidtitel."\" href=\"javascript: void(0);\" onclick=\"return listItemTask('cb".$i."','27')\"><img src=\"".sem_f006().$paidbild."\" border=\"0\" alt=\"".JTEXT::_('SEM_0065')."\"></a>";
          }
          $temp[] = $htxt;
          $tempa[] = "c";
        }
        $htxt = "&nbsp;";
        if($anzahl<=$kurs->maxpupil) {
          $certbild = "2200.png";
          $certtemp = "";
          $certtitel = JTEXT::_('SEM_0091');
          if($row->certificated == 1) {
            $certbild = "2201.png";
            $certtemp = " ".sem_f038(3,$row->sid);
            $certtitel = JTEXT::_('SEM_0090');
          }
          $htxt = "<a title=\"".$certtitel."\" href=\"javascript: void(0);\" onclick=\"return listItemTask('cb".$i."','26')\"><img src=\"".sem_f006().$certbild."\" border=\"0\" alt=\"".JTEXT::_('SEM_0040')."\"></a>".$certtemp;
        }
        $temp[] = $htxt;
        $tempa[] = "c";
        $temp [] = "<img src=\"".sem_f006()."240".$row->grade.".png\" border=\"0\" alt=\"".JTEXT::_('SEM_0055')."\">";
        $tempa[] = "c";
        $temp[] = $row->comment;
        $tempa[] = "";
        $temp[] = "<img src=\"".sem_f006().$bild."\" border=\"0\" alt=\"".$altbild."\">";
        $tempa[] = "c";
        $klasse = "row".$k;
        $html .= "\n".sem_f024( "td", $tempa, "", $temp, $klasse);
        $k = 1 - $k;
        $i++;
      }
    } else {
      $html .= "\n<tr class=\"row0\"><td colspan=\"10\">.".JTEXT::_('SEM_0061')."</td></tr>";
    }
    $html .= "\n</tbody></table>";

// ---------------------------------------
// Farbbeschreibungen anzeigen
// ---------------------------------------

    $html .= "\n<br /><center><table cellpadding=\"4\" cellspacing=\"0\" border=\"0\" width=\"100%\"><tr>";
    $html .= "\n<td align=\"center\" width=\"33%\"><img src=\"".sem_f006()."2502.png\" border=\"0\" align=\"absmiddle\" /> <b>".JTEXT::_('SEM_0030')."</b></td>";
    $html .= "\n<td align=\"center\" width=\"33%\"><img src=\"".sem_f006()."2501.png\" border=\"0\" align=\"absmiddle\" /> <b>".JTEXT::_('SEM_0025')."</b></td>";
    $html .= "\n<td align=\"center\" width=\"33%\"><img src=\"".sem_f006()."2500.png\" border=\"0\" align=\"absmiddle\" /> <b>".JTEXT::_('SEM_0029')."</b></td>";
    $html .= "\n</tr></table></center>";

// ---------------------------------------
// Zusaetzliche Variablen uebergeben
// ---------------------------------------

    $html .= sem_f015();
    $html .= "\n<input type=\"hidden\" name=\"uid\" value=\"".$uid."\" />";
    $html .= "\n<input type=\"hidden\" name=\"option\" value=\"".JRequest::getCmd('option')."\" />";
    $html .= "\n<input type=\"hidden\" name=\"task\" value=\"\" />";
    $html .= "\n<input type=\"hidden\" name=\"boxchecked\" value=\"0\" />";
    $html .= "\n</form>";
    echo $html;
  }

// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// + Statistikuebersicht anzeigen                         +
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  function sem_g030($stats,$mstats) {
    $database = &JFactory::getDBO();
    $html = sem_f026(2)."\n<script type=\"text/javascript\">";
    $html .= "function auf(semy, semm) {";
    $html .= "document.adminForm.year.value = semy;";
    $html .= "document.adminForm.month.value = semm;";
    $html .= "document.adminForm.submit();}</script>";

// --------------------------------------------------------
// Anlegen des Kopfs und der Ueberschrift
// --------------------------------------------------------

    $n = count($stats);
    if( $n == 2) {
      $o = 1;
    } else {
      $o = 0;
    }
    for ($i=$o, $n; $i < $n; $i++) {
      $daten = $mstats[$i];
      $m = count($daten);
      if($n>($o+1)) {
        $html .= "\n<div style=\"border: 1px solid #C0C0F0;width: 100%;border-style: ridge;\">";
      }
      $html .= "\n<br /><center><a style=\"font-size:18px; font-weight: bold;\" href=\"#\" onclick=\"auf('".$stats[$i]->year."','');\">".$stats[$i]->year."</a></center>";
      $html0 = "";
      $html1 = "\n<table class=\"adminlist\">";
// --------------------------------------------------------
// Anlegen Tabellenkopfes
// --------------------------------------------------------

      $html1 .= "\n<thead>";
      $temp = array(JTEXT::_('SEM_2009'),JTEXT::_('SEM_0018'),JTEXT::_('SEM_0058'),JTEXT::_('SEM_0035'),JTEXT::_('SEM_0040'),JTEXT::_('SEM_0020'),JTEXT::_('SEM_2022'),JTEXT::_('SEM_0058')." / ".JTEXT::_('SEM_0048'),JTEXT::_('SEM_0035')." / ".JTEXT::_('SEM_0048'),JTEXT::_('SEM_0020')." / ".JTEXT::_('SEM_0048'));
      $tempa = array("nw","nw","nw","nw","nw","nw","c2","","","");
      $html1 .= "\n".sem_f024( "th", $tempa, "", $temp, "");
      $html1 .= "\n</thead>";

// --------------------------------------------------------
// Anlegen des Tabellenkoerpers
// --------------------------------------------------------

      $html1 .= "<tbody>";
      if( $m > 0 ) {
        $image = "http://chart.apis.google.com/chart?cht=lc";
        $image .= "&amp;chs=400x200";
        $image .= "&amp;chco=ffa844,44cc44,4444ff,ff4444";
        $image .= "&amp;chm=b,ff8800,0,4,0|b,00cc00,1,4,0|b,0000ff,2,4,0|b,ff0000,3,4,0";
        $image .= "&amp;chg=0,50";
        $image .= "&amp;chdl=".JTEXT::_('SEM_0058')."|".JTEXT::_('SEM_0035')."|".JTEXT::_('SEM_0040')."|".JTEXT::_('SEM_0018');
        $image .= "&amp;chxt=x,y";
        $chl = array(JTEXT::_('JANUARY_SHORT'),JTEXT::_('FEBRUARY_SHORT'),JTEXT::_('MARCH_SHORT'),JTEXT::_('APRIL_SHORT'),JTEXT::_('MAY_SHORT'),JTEXT::_('JUNE_SHORT'),JTEXT::_('JULY_SHORT'),JTEXT::_('AUGUST_SHORT'),JTEXT::_('SEPTEMBER_SHORT'),JTEXT::_('OCTOBER_SHORT'),JTEXT::_('NOVEMBER_SHORT'),JTEXT::_('DECEMBER_SHORT'));
        $imagea = "http://chart.apis.google.com/chart?cht=p3&amp;chs=230x100&amp;&amp;chco=";
        $imagehi = $imagea."ff8800&amp;chd=t:";
        $imagebo = $imagea."00cc00&amp;chd=t:";
        $imagece = $imagea."0000ff&amp;chd=t:";
        $imageco = $imagea."ff0000&amp;chd=t:";
        $highest = array();
         for ($l=0, $m; $l < $m; $l++) {
          $highest[] = $daten[$l]->hits;
        }
        $maximum = max($highest);
        if($maximum<1) {
          $maximum = 1;
        }
        $image .= "&amp;chxl=0:|".implode('|',$chl)."|1:|0|".(round($maximum*0.25))."|".(round($maximum*0.5))."|".(round($maximum*0.75))."|".$maximum;
        $image .= "&amp;chd=t:";
        $ihits = array();
        $ibookings = array();
        $icertificated = array();
        $icourses = array();
        $phits = array();
        $pbookings = array();
        $pcertificated = array();
        $pcourses = array();
        $plhits = array();
        $plbookings = array();
        $plcertificated = array();
        $plcourses = array();
        
        $k = 0;
        for ($l=0, $m; $l < $m; $l++) {
          if($daten[$l]->maxpupil == "" OR $daten[$l]->maxpupil == 0) {
            $temp0 = 0;
          } else {
            $temp0 = round($daten[$l]->bookings * 100 / $daten[$l]->maxpupil,0);
          }
          $temp1 = sem_f016($temp0);
          $temp11 = $temp0."%";
          if($daten[$l]->hits == "" OR $daten[$l]->hits == 0) {
            $temp2 = 0;
            $teiler = 1;
          } else {
            $temp2 = $daten[$l]->hits;
            $phits[] = $stats[$i]->hits!=0 ? round(($temp2*100)/$stats[$i]->hits) : 100;
            $plhits[] = $chl[$l];
          }
          $ihits[] = round(($temp2*100)/$maximum);
          if($daten[$l]->bookings == "" OR $daten[$l]->bookings == 0) {
            $temp3 = 0;
          } else {
            $temp3 = $daten[$l]->bookings;
            $pbookings[] = $stats[$i]->bookings!=0 ? round(($temp3*100)/$stats[$i]->bookings) : 100;
            $plbookings[] = $chl[$l];
          }
          $ibookings[] = round(($temp3*100)/$maximum);
          if($daten[$l]->certificated =="" OR $daten[$l]->certificated==0) {
            $temp9 = 0;
          } else {
            $temp9 = $daten[$l]->certificated;
            $pcertificated[] = $stats[$i]->certificated!=0 ? round(($temp9*100)/$stats[$i]->certificated) : 100;
            $plcertificated[] = $chl[$l];
          }
          $icertificated[] = round(($temp9*100)/$maximum);
          if($daten[$l]->maxpupil == "" OR $daten[$l]->maxpupil == 0) {
            $temp4 = 0;
          } else {
            $temp4 = $daten[$l]->maxpupil;
          }
          if($daten[$l]->courses == "" OR $daten[$l]->courses == 0) {
            $temp5 = 0;
            $temp6 = 0;
            $temp7 = 0;
          } else {
            $temp5 = $daten[$l]->courses!=0 ? round($daten[$l]->hits/$daten[$l]->courses) : $daten[$l]->hits;
            $temp6 = $daten[$l]->courses!=0 ? round($daten[$l]->bookings/$daten[$l]->courses) : $daten[$l]->bookings;
            $temp7 = $daten[$l]->courses!=0 ? round($daten[$l]->maxpupil/$daten[$l]->courses) : $daten[$l]->maxpupil;
            $pcourses[] = $stats[$i]->courses!=0 ? round((($daten[$l]->courses)*100)/$stats[$i]->courses) : 100;
            $plcourses[] = $chl[$l];
          }
          $icourses[] = round((($daten[$l]->courses)*100)/$maximum);
          $temp8 = "<a href=\"#\" onclick=\"auf('".$stats[$i]->year."','".($l+1)."')\">".$daten[$l]->year."</a>";
          $temp = array(($temp8),($daten[$l]->courses),($temp2),($temp3),($temp9),($temp4),($temp1),($temp11),($temp5),($temp6),($temp7));
          $tempa = array("c","r","r","r","r","r","r","r","r","r","r");
          $tempb = array("","","","","","","nw","","","","");
          $html1 .= "\n".sem_f024( "td", $tempa, "", $temp, "row".$k);
          $k = 1 - $k;
        }
        $image .= implode(',',$ihits)."|".implode(',',$ibookings)."|".implode(',',$icertificated)."|".implode(',',$icourses)."|0,0";
        
        $imagehi .= implode(',',$phits)."&amp;chl=".implode('|',$plhits);
        $imagebo .= implode(',',$pbookings)."&amp;chl=".implode('|',$plbookings);
        $imagece .= implode(',',$pcertificated)."&amp;chl=".implode('|',$plcertificated);
        $imageco .= implode(',',$pcourses)."&amp;chl=".implode('|',$plcourses);
        $html0 .= "<br /><center><table width= \"100\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";
        $html0 .= "<tr><th colspan=\"2\" rowspan=\"2\"><img src=\"".$image."\" border=\"0\"></th>";
        $html0 .= "<th><img src=\"".$imagehi."\" border=\"0\"></th>";
        $html0 .= "<th><img src=\"".$imagebo."\" border=\"0\"></th></tr>";
        $html0 .= "<tr><th><img src=\"".$imagece."\" border=\"0\"></th>";
        $html0 .= "<th><img src=\"".$imageco."\" border=\"0\"></th></tr>";
        $html0 .= "</table></center><br />";
      } else {
          $html1 .= "<tr class=\"row0\"><td colspan=\"9\">".JTEXT::_('SEM_2011')."</td>";
      }
      $html .= $html0.$html1."</tbody>";

// --------------------------------------------------------
// Anlegen des Tabellenfusses
// --------------------------------------------------------

      if( $m > 0 ) {
        $html .= "<tfoot>";
        if($stats[$i]->hits == "") {
          $temp1 = 0;
        } else {
          $temp1 = $stats[$i]->hits;
        }
        if($stats[$i]->bookings == "") {
          $temp2 = 0;
        } else {
          $temp2 = $stats[$i]->bookings;
        }
        if($stats[$i]->certificated == "") {
          $temp9 = 0;
        } else {
          $temp9 = $stats[$i]->certificated;
        }
        if($stats[$i]->maxpupil == "") {
          $temp3 = 0;
        } else {
          $temp3 = $stats[$i]->maxpupil;
        }
         if ($stats[$i]->maxpupil==0) {
           $temp4 = "0%";
         } else {
           $temp4 = round($stats[$i]->bookings * 100 / $stats[$i]->maxpupil,0)."%";
         }
         if ($stats[$i]->courses==0) {
          $temp5 = 0;
          $temp6 = 0;
          $temp7 = 0;
        } else {
          $temp5 = round($stats[$i]->hits / $stats[$i]->courses);
          $temp6 = round($stats[$i]->bookings / $stats[$i]->courses);
          $temp7 = round($stats[$i]->maxpupil / $stats[$i]->courses);
        }
         $temp = array(JTEXT::_('SEM_2020'),($stats[$i]->courses),($temp1),($temp2),($temp9),($temp3),($temp4),($temp5),($temp6),($temp7));
         $tempa = array("c","r","r","r","r","r","r","r","r","r");
         $tempb = array("","","","","","","c2","","","");
         $html .= "\n".sem_f024( "th", $tempa, $tempb, $temp, "");
         $html .= "\n</tfoot>";
      }
// --------------------------------------------------------
// Anlegen des Seitenendes und Ausgabe
// --------------------------------------------------------

      $html .= "</table>";
      if($n>($o+1)) {
        $html .= "</div>";
      }
      $html .= "<br />";
    }
    if($n>0) {
      $html .= JTEXT::_('SEM_2017')."<br />";
    }
    $html .= "\n<input type=\"hidden\" name=\"option\" value=\"".JRequest::getCmd('option')."\" />";
    $html .= "<input type=\"hidden\" name=\"task\" value=\"30\" />";
    $html .= "<input type=\"hidden\" name=\"year\" value=\"\" />";
    $html .= "<input type=\"hidden\" name=\"month\" value=\"\" />";
    $html .= "\n</form>";

    echo $html;
  }

// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// + Statistik pro Monat - Jahr anzeigen                  +
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  function sem_g031($rows,$mon,$yea) {
    $config = &JComponentHelper::getParams('com_seminar');
    $database = &JFactory::getDBO();

// --------------------------------------------------------
// Anlegen des Monats und des Jahrs
// --------------------------------------------------------

    $html = sem_f026(2)."\n<center><div style=\"font-size:18px; font-weight: bold;\">".$yea.$mon."</div></center><br />";
    $html .= "\n<table class=\"adminlist\">";

// --------------------------------------------------------
// Anlegen des Tabellenkopfes
// --------------------------------------------------------

    $html .= "\n<thead>";
    $temp = array(JTEXT::_('SEM_2016'),JTEXT::_('SEM_0007'),JTEXT::_('SEM_0008'),JTEXT::_('SEM_0009'),JTEXT::_('SEM_0010'),JTEXT::_('SEM_0058'),JTEXT::_('SEM_0035'),JTEXT::_('SEM_0040'),JTEXT::_('SEM_0020'),JTEXT::_('SEM_2022'));
    $tempa = array("nw","nw","nw","nw","nw","nw","nw","nw","nw","c2");
    $html .= "\n".sem_f024( "th", $tempa, "", $temp, "");
    $html .= "\n</thead>";

// --------------------------------------------------------
// Anlegen des Tabellenkoerpers
// --------------------------------------------------------

    $html .= "\n<tbody>";
    $n = count($rows);
    if( $n > 0 ) {
      $k = 0;
      for ($i=0, $n; $i < $n; $i++) {
        $row = $rows[$i];
        $gebucht = sem_f020($row);
        $gebucht = $gebucht->booked;
        if($row->maxpupil == 0) {
          $temp0 = 0;
        } else {
          $temp0 = round($gebucht * 100 / $row->maxpupil,0);
        }
        $usage = sem_f016($temp0);
        $temp1 = $temp0."%";
        $temp2 = JHTML::_('date',$row->begin,$config->get('sem_p069',JTEXT::_('SEM_0169')),0).", ".JHTML::_('date',$row->begin,$config->get('sem_p070',JTEXT::_('SEM_0170')),0);
        $temp3 = JHTML::_('date',$row->end,$config->get('sem_p069',JTEXT::_('SEM_0169')),0).", ".JHTML::_('date',$row->end,$config->get('sem_p070',JTEXT::_('SEM_0170')),0);
        $temp = array($row->semnum,$row->title,$row->category,$temp2,$temp3,$row->hits,$gebucht,$row->certificated,$row->maxpupil,$usage,$temp1);
        $tempa = array("r","l","l","c","c","r","r","r","r","r","r");
        $klasse = "row".$k;
        $html .= "\n".sem_f024( "td", $tempa, "", $temp, $klasse);
        $k = 1 - $k;
      }
    } else {
      $html .= "\n<tr class=\"row0\"><td colspan=\"10\">".JTEXT::_('SEM_2011')."</td></tr>";
    }
    $html .= "\n</tbody>";

// --------------------------------------------------------
// Anlegen der zusaetzliche Variablen und HTML-Ausgabe
// --------------------------------------------------------

    $html .= "\n</table>";
    $html .= "\n<input type=\"hidden\" name=\"option\" value=\"".JRequest::getCmd('option')."\" />";
    $html .= "<input type=\"hidden\" name=\"task\" value=\"\" />";
    $html .= "\n</form>";
    echo $html;
  }

// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// + Ausgabe der Vorlagenuebersicht                       +
// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++

  function sem_g032($rows,$clist,$search,$pageNav,$limitstart,$limit) {
    $config = &JComponentHelper::getParams('com_seminar');
    $html = sem_f026(2)."\n<script type=\"text/javascript\">";
    $html .= "function auf(stask, suid) {";
    $html .= "document.adminForm.task.value = stask;";
    $html .= "document.adminForm.uid.value = suid;";
    $html .= "document.adminForm.submit();}</script>";

// --------------------------------------------------------
// Anlegen der Auswahlmaske
// --------------------------------------------------------

    $html .= "\n<center><table cellpadding=\"2\" cellspacing=\"0\" border=\"0\" width=\"100%\">";
    $temp3 = "\n<input type=\"text\" name=\"search\" value=\"".$search."\" class=\"inputbox\" onChange=\"document.adminForm.submit();\" />";
    $temp = array(JTEXT::_('SEM_2015').":",$clist,JTEXT::_('SEM_0067').":",($temp3));
    $tempa = array("nw","","nw","");
    $tempb = array("r","l","r","l");
    $html .= "\n".sem_f024( "th", $tempa, $tempb, $temp, "");
    $html .= "\n</table></center>";

// ---------------------------------------
// Ausgabe der Kurstabelle
// ---------------------------------------

    $html .= "\n<table class=\"adminlist\"><thead>";
    $temp3 = "<input type=\"checkbox\" name=\"toggle\" value=\"\" onclick=\"checkAll(".count( $rows ).");\" />";
    $temp = array(($temp3),JTEXT::_('SEM_0122'),JTEXT::_('SEM_0008'),JTEXT::_('SEM_2024'),JTEXT::_('SEM_2032'),JTEXT::_('SEM_2028'),JTEXT::_('SEM_2014'),JTEXT::_('SEM_0057'));
    $tempa = array("","nw","nw","nw","nw","nw","nw");
    $html .= "\n".sem_f024( "th", $tempa, "", $temp, "");
    $html .= "</thead>";
    $html .= "<tbody>";
    $n = count($rows);
    if( $n > 0 ) {
      $k = 0;
      $neudatum = sem_f046();
      for ($i=0, $n; $i < $n; $i++) {
        $row = &$rows[$i];
        $gebucht = sem_f020($row);
        $gebucht = $gebucht->booked;
        $bild = "2502.png";
        $altbild = JTEXT::_('SEM_0045');
        if( $neudatum > $row->end ) {
          $bild = "2500.png";
          $altbild = JTEXT::_('SEM_0046');
        } else if( $neudatum > $row->begin ) {
          $bild = "2501.png";
          $altbild = JTEXT::_('SEM_0047');
        }
        $abild = "2502.png";
        $altabild = JTEXT::_('SEM_0053');
        if($row->maxpupil - $gebucht < 1 && $row->stopbooking == 1) {
          $abild = "2500.png";
          $altabild = JTEXT::_('SEM_2010');
        } else if($row->maxpupil - $gebucht < 1 && $row->stopbooking == 0) {
          $abild = "2501.png";
          $altabild = JTEXT::_('SEM_0025');
        }
        $bbild = "2502.png";
        $altbbild = JTEXT::_('SEM_0031');
        if($neudatum > $row->booked) {
          $bbild = "2500.png";
          $altbbild = JTEXT::_('SEM_0038');
        }
        $temp1 = "<input type=\"checkbox\" id=\"cb".$i."\" name=\"cid[]\" value=\"".$row->id."\" onclick=\"isChecked(this.checked);\" />";
        $temp2 = "<a href=\"index2.php?option=com_seminar\" onclick=\"return listItemTask('cb".$i."','13')\">"; 
        if(strlen($row->pattern)<30) {
          $temp2 .= $row->pattern;
        } else {
          $temp2 .= substr($row->pattern,0,27)."...";
        }
        $temp2 .= "</a>";
        if(strlen($row->category)<25) {
          $temp3 = $row->category;
        } else {
          $temp3 = substr($row->category,0,22)."...";
        }
        $task = $row->published ? "21" : "19";
        $img = $row->published ? "2201.png" : "2200.png";
        $temp4 = "<a href=\"javascript: void(0);\" onclick=\"return listItemTask('cb".$i."','".$task."')\"><img src=\"".sem_f006().$img."\" border=\"0\" alt=\"\" /></a>";
        $temp = JFactory::getuser($row->publisher);
        $temp10 = $temp->name;
        $temp11 = JHTML::_('date',$row->publishdate,$config->get('sem_p069',JTEXT::_('SEM_0169')),0).", ".JHTML::_('date',$row->publishdate,$config->get('sem_p070',JTEXT::_('SEM_0170')),0);
        $temp12 = JHTML::_('date',$row->updated,$config->get('sem_p069',JTEXT::_('SEM_0169')),0).", ".JHTML::_('date',$row->updated,$config->get('sem_p070',JTEXT::_('SEM_0170')),0);
        $temp = array($temp1,$temp2,$temp3,$temp10,$temp11,$temp12,$temp4,$row->id);
        $tempa = array("c","c","","","c","c","c","c");
        $klasse = "row".$k;
        $html .= "\n".sem_f024( "td", $tempa, "", $temp, $klasse);
        $k = 1 - $k;
      }
    } else {
      $html .= "\n<tr class=\"row0\"><td colspan=\"15\">".JTEXT::_('SEM_0062')."</td></tr>";
    }
    $html .= "\n</tbody>";
    $html .= "\n<tfoot><tr><th colspan=\"2\" nowrap=\"nowrap\">".JTEXT::_('SEM_0050').": ".sem_f040(2,$limit)."</th><th colspan=\"4\" nowrap=\"nowrap\">".$pageNav->getPagesLinks()."&nbsp;</th><th colspan=\"2\" nowrap=\"nowrap\">".$pageNav->getPagesCounter()."&nbsp;</th></tr></tfoot>";
    $html .= "\n</table>";

// --------------------------------------------------------
// Anlegen der zusaetzliche Variablen und HTML-Ausgabe
// --------------------------------------------------------

    $html .= "\n<input type=\"hidden\" name=\"option\" value=\"".JRequest::getCmd('option')."\" />";
    $html .= "<input type=\"hidden\" name=\"task\" value=\"1\" />";
    $html .= "<input type=\"hidden\" name=\"uid\" value=\"\" />";
    $html .= "<input type=\"hidden\" name=\"boxchecked\" value=\"0\" />";
    $html .= "<input type=\"hidden\" name=\"limitstart\" value=\"".$limitstart."\" />";
    $html .= "\n</form>";
    echo $html;
  }

// ++++++++++++++++++++++++++++++
// + Ausgabe der Einstellungen  +
// ++++++++++++++++++++++++++++++

  function sem_g033($params) {
    $html = sem_f026(4);
    $html .= $params->render();
    $html .= "\n<input type=\"hidden\" name=\"option\" value=\"".JRequest::getCmd('option')."\" />";
    $html .= "<input type=\"hidden\" name=\"task\" value=\"\" />";
    $html .= "<input type=\"hidden\" name=\"uid\" value=\"\" />";
    $html .= "\n</form>";
    echo $html;
  }

}
?>
