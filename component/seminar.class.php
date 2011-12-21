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

// ++++++++++++++++++++++++++++++++++++++
// +++ Versionsnummer ausgeben        +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f001() {
  return "1.3.0";
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Buchungs-ID ausgeben          +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f002($id) {
  return strtoupper(substr(sha1($id),0,10));
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Buchungs-ID-Codebild ausgeben  +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f003($id) {
  $config = &JComponentHelper::getParams('com_seminar');
  $temp = $config->get('sem_p029',1);
  if($temp==1) {
    return "<img src=\"http://chart.apis.google.com/chart?cht=qr&amp;chs=100x100&amp;choe=UTF-8&amp;chld=H|4&amp;chl=".urlencode(sem_f002($id))."\"><br /><code><b>".sem_f002($id)."</b></code>";
  } else if($temp==2) {
    return "<img src=\"".sem_f005()."seminar.code.php?code=".sem_f002($id)."\">";
  }
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Basisverzeichnis ausgeben      +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f004() {
  $htxt = JURI::BASE();
  return str_replace("/administrator","",$htxt);
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Komponentenverzeichnis ausgeben ++
// ++++++++++++++++++++++++++++++++++++++

function sem_f005() {
  return sem_f004()."components/".JRequest::getCmd('option')."/";
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Bildverzeichnis 1 ausgeben     +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f006() {
  return sem_f005()."images/";
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Bildverzeichnis 2 ausgeben     +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f007($art) {
  $config = &JComponentHelper::getParams('com_seminar');
  $htxt = "";
  if($config->get('sem_p033','')!="" AND $art>0) {
    $htxt = trim($config->get('sem_p033',''),"/")."/";
  }
  return sem_f004()."images/stories/".$htxt;
}

// ++++++++++++++++++++++++++++++++++++++++++++
// +++ Editierbereich der Seminare ausgeben +++
// ++++++++++++++++++++++++++++++++++++++++++++

function sem_f008($row,$art) {
  jimport('joomla.html.pane');
  $database = &JFactory::getDBO();
  $editor = &JFactory::getEditor();
  $config = &JComponentHelper::getParams('com_seminar');
  $catlist = sem_f010($row->catid);
  $reglevel = sem_f042();
  $reqfield = " <span class=\"sem_reqfield\">*</span>";

// Vorlage
  $html = "";
  if($art==1 OR $art==2) {
    $html = "<input type=\"hidden\" name=\"pattern\" value=\"\"><input type=\"hidden\" name=\"vorlage\" value=\"0\">";
  }
  if($row->id==0 AND ($art==1 OR $art==2)) {
    $html = sem_f057($row->vorlage,$art);
  }
  $html .= "<tr><td width=\"100%\">";

  $pane =& JPane::getInstance('sliders',array('allowAllClose' => true));
  $html .= $pane->startPane('pane');

// ### Panel 1 ###

  $html .= $pane->startPanel(JTEXT::_('SEM_0127'),'panel1');
  $html .= "<table>";
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0113'),'d','l','100%','sem_edit',2)."</tr>";

// Vorlagenname und Besitzer
  if($art==3) {
    $html .= "<tr>".sem_f022(JTEXT::_('SEM_0122').':','d','r','20%','sem_edit').sem_f022("<input class=\"sem_inputbox\" type=\"text\" name=\"pattern\" size=\"50\" maxlength=\"100\" value=\"".$row->pattern."\" />".$reqfield,'d','l','80%','sem_edit')."</tr>";
    $html .= "<tr>".sem_f022(JTEXT::_('SEM_2024').':','d','r','20%','sem_edit').sem_f022(sem_f009($row->publisher).$reqfield,'d','l','80%','sem_edit')."</tr>";
    $reqfield = "";
  }

// ID der Veranstaltung
  if($row->id < 1) {
    $htxt = JTEXT::_('SEM_0147');
    $htx2 = JTEXT::_('SEM_0105');
    $htx3 = JTEXT::_('SEM_0104');
    $htx4 = "";
    $htx5 = " checked=\"checked\"";
  } else {
    $htxt = $row->id;
    $htx2 = JTEXT::_('SEM_0107');
    $htx3 = JTEXT::_('SEM_0106');
    if($row->cancelled==0) {
      $htx4 = "";
      $htx5 = " checked=\"checked\"";
      if($art!=3) {
        $htx4 = " onClick=\"infotext.value='".JTEXT::_('SEM_0098')."'\"";
        $htx5 = " onClick=\"infotext.value='".JTEXT::_('SEM_0106')."'\"".$htx5;
      }
    } else {
      $htx4 = " checked=\"checked\"";
      $htx5 = "";
      if($art!=3) {
        $htx4 = " onClick=\"infotext.value='".JTEXT::_('SEM_0106')."'\"".$htx4;
        $htx5 = " onClick=\"infotext.value='".JTEXT::_('SEM_0100')."'\"";
      }
    }
  }
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0057').':'.sem_f055(JTEXT::_('SEM_0146')),'d','r','20%','sem_edit');
  $html .= sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";


// Kursnummer
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0003').':'.sem_f055(JTEXT::_('SEM_0116')),'d','r','20%','sem_edit');
  $html .= sem_f022("<input class=\"sem_inputbox\" type=\"text\" name=\"semnum\" size=\"10\" maxlength=\"100\" value=\"".$row->semnum."\" />".$reqfield,'d','l','80%','sem_edit')."</tr>";

// Abgesagt
  $htxt ="<input type=\"radio\" name=\"cancel\" id=\"cancel\" value=\"1\" class=\"sem_inputbox\"".$htx4." /><label for=\"cancel\">".JTEXT::_('SEM_0005')."</label> <input type=\"radio\" name=\"cancel\" id=\"cancel\" value=\"0\" class=\"sem_inputbox\"".$htx5."/><label for=\"cancel\">".JTEXT::_('SEM_0006')."</label>";
  $html .= "\n<tr>".sem_f022(JTEXT::_('SEM_0095').':'.sem_f055(JTEXT::_('SEM_0161')),'d','r','20%','sem_edit').sem_f022($htxt.$reqfield,'d','l','80%','sem_edit')."<input type=\"hidden\" name=\"cancelled\" value=\"".$row->cancelled."\"></tr>";

// Titel
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0007').':','d','r','20%','sem_edit').sem_f022("<input class=\"sem_inputbox\" type=\"text\" name=\"title\" size=\"50\" maxlength=\"250\" value=\"".$row->title."\" />".$reqfield,'d','l','80%','sem_edit')."</tr>";

// Kategorie
  $htxt = $catlist[0];
  if($config->get('sem_p032','')==1) {
    foreach($catlist[1] as $el) {
      $htxt .= "<input type=\"hidden\" id=\"im".$el->id."\" value=\"".$el->image."\">";
    }
  }
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0008').':'.sem_f055(JTEXT::_('SEM_0160')),'d','r','20%','sem_edit').sem_f022($htxt.$reqfield,'d','l','80%','sem_edit')."</tr>";

  $radios = array();      
  $radios[] = JHTML::_('select.option',1,JTEXT::_('SEM_0005'));
  $radios[] = JHTML::_('select.option',0,JTEXT::_('SEM_0006'));

// Veranstaltungsbeginn
  $htxt = JHTML::_('calendar',$row->begin_date,'_begin_date','_begin_date','%Y-%m-%d',array('class'=>'inputbox','size'=>'12','maxlength'=>'10'));
  $htxt .= JHTML::_('select.integerlist', 0, 23, 1, '_begin_hour','class="sem_inputbox" size="1"', $row->begin_hour, "%02d" );
  $htxt .= JHTML::_('select.integerlist', 0, 55, 5, '_begin_minute','class="sem_inputbox" size="1"', $row->begin_minute, "%02d" );
  $htxt .= $reqfield." - ".JTEXT::_('SEM_0121')." ".JHTML::_('select.radiolist',$radios,'showbegin','class="sem_inputbox"','value','text',$row->showbegin);
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0009').':'.sem_f055(JTEXT::_('SEM_0145')),'d','r','20%','sem_edit').sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";

// Veranstaltungsende
  $htxt = JHTML::_('calendar',$row->end_date,'_end_date','_end_date','%Y-%m-%d',array('class'=>'inputbox','size'=>'12','maxlength'=>'10'));
  $htxt .= JHTML::_('select.integerlist', 0, 23, 1, '_end_hour','class="sem_inputbox" size="1"', $row->end_hour, "%02d" );
  $htxt .= JHTML::_('select.integerlist', 0, 55, 5, '_end_minute','class="sem_inputbox" size="1"', $row->end_minute, "%02d" );
  $htxt .= $reqfield." - ".JTEXT::_('SEM_0121')." ".JHTML::_('select.radiolist',$radios,'showend','class="sem_inputbox"','value','text',$row->showend);
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0010').':'.sem_f055(JTEXT::_('SEM_0145')),'d','r','20%','sem_edit').sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";

// Anmeldeschluss
  $htxt = JHTML::_('calendar',$row->booked_date,'_booked_date','_booked_date','%Y-%m-%d',array('class'=>'inputbox','size'=>'12','maxlength'=>'10'));
  $htxt .= JHTML::_('select.integerlist', 0, 23, 1, '_booked_hour','class="sem_inputbox" size="1"', $row->booked_hour, "%02d" );
  $htxt .= JHTML::_('select.integerlist', 0, 55, 5, '_booked_minute','class="sem_inputbox" size="1"', $row->booked_minute, "%02d" );
  $htxt .= $reqfield." - ".JTEXT::_('SEM_0121')." ".JHTML::_('select.radiolist',$radios,'showbooked','class="sem_inputbox"','value','text',$row->showbooked);
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0011').':'.sem_f055(JTEXT::_('SEM_0145')),'d','r','20%','sem_edit').sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";

// Kurzbeschreibung
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0013').':'.sem_f055(JTEXT::_('SEM_0115')),'d','r','20%','sem_edit').sem_f022("<textarea class=\"sem_inputbox\" cols=\"50\" rows=\"3\" name=\"shortdesc\" style=\"width:500px\" width=\"500\">".$row->shortdesc."</textarea>".$reqfield,'d','l','80%','sem_edit')."</tr>";

// Veranstaltungsort
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0015').':','d','r','20%','sem_edit').sem_f022("<textarea class=\"sem_inputbox\" cols=\"50\" rows=\"3\" name=\"place\" style=\"width:500px\" width=\"500\">".$row->place."</textarea>".$reqfield,'d','l','80%','sem_edit')."</tr>";

// Veranstalter
  if($reglevel>5 AND $art!=3) {
    $html .= "<tr>".sem_f022(JTEXT::_('SEM_0094').':'.sem_f055(JTEXT::_('SEM_0159')),'d','r','20%','sem_edit').sem_f022(sem_f009($row->publisher).$reqfield,'d','l','80%','sem_edit')."</tr>";
  }

// Plätze
  $htxt = "<input class=\"sem_inputbox\" type=\"text\" name=\"maxpupil\" size=\"3\" maxlength=\"5\" value=\"".$row->maxpupil."\" /> - ".JTEXT::_('SEM_0024').": ";
  $radios = array();
  $radios[] = JHTML::_('select.option',0,JTEXT::_('SEM_0025'));
  $radios[] = JHTML::_('select.option',1,JTEXT::_('SEM_0070'));
  $radios[] = JHTML::_('select.option',2,JTEXT::_('SEM_0139'));
  $htxt .= JHTML::_('select.genericlist',$radios,'stopbooking','class="sem_inputbox" ','value','text',$row->stopbooking);
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0020').':','d','r','20%','sem_edit').sem_f022($htxt.$reqfield,'d','l','80%','sem_edit')."</tr>";

// max. Buchung
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0021').':'.sem_f055(JTEXT::_('SEM_0138')),'d','r','20%','sem_edit');
  if($config->get('sem_p023','')>0){
    $htxt = "<input class=\"sem_inputbox\" type=\"text\" name=\"nrbooked\" size=\"3\" maxlength=\"3\" value=\"".$row->nrbooked."\" />";
  } else {
    $radios = array();
    $radios[] = JHTML::_('select.option',0,"0");
    $radios[] = JHTML::_('select.option',1,"1");
    $htxt = JHTML::_('select.genericlist',$radios,'nrbooked','class="sem_inputbox" ','value','text',$row->nrbooked);
  }
  $html .= sem_f022($htxt.$reqfield,'d','l','80%','sem_edit')."</tr>";
  $html .= "</table>";
  $html .= $pane->endPanel() ;

// ### Panel 2 ###

  $html .= $pane->startPanel(JTEXT::_('SEM_0128'),'panel2');
  $html .= "<table>";
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0114'),'d','l','100%','sem_edit',2)."</tr>";
     
// Beschreibung
  $name = "editor1";
  $htxt = $editor->display("description",$row->description,"500","300","50","5");
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0014').':','d','r','20%','sem_edit').sem_f022(JTEXT::_('SEM_0163').$htxt,'d','l','80%','sem_edit')."</tr>";

// Veranstaltungsbild
  if($config->get('sem_p032','')==1) {
    jimport( 'joomla.filesystem.folder' );
    $htxt = "";
    if($config->get('sem_p033','')!="") {
      $htxt = trim($config->get('sem_p033',''),"/")."/";
    }
    $htxt = JPATH_SITE."/images/stories/".$htxt;
    if(!is_dir($htxt)) {
      mkdir($htxt,0755);
    }
    $imageFiles = JFolder::files($htxt);
    $images = array(JHTML::_('select.option','','- '.JText::_('SEM_0096').' -'));
    foreach ($imageFiles as $file) {
      if (eregi("gif|jpg|png", $file)) {
        $images[]=JHTML::_('select.option',$file);
      }
    }
    $imagelist = JHTML::_('select.genericlist', $images,'image','class="sem_inputbox" size="1" ','value','text',$row->image);
    $htxt = "<span style=\"position:absolute;display:none;border:3px solid #FF9900;background-color:#FFFFFF;\" id=\"1\"><img id=\"toolbild\" src=\"images/stories/".$row->image."\" \></span><span style=\"position:absolute;display:none;border:3px solid #FF9900;background-color:#FFFFFF;\" id=\"2\"><img src=\"".sem_f006()."2601.png\" \></span>";
    $htxt .= $imagelist."&nbsp;<img src=\"".sem_f006()."2116.png\" border=\"0\" onmouseover=\"showSemTip('1');\" onmouseout=\"hideSemTip();\" />";
    $html .= "<tr>".sem_f022(JTEXT::_('SEM_0093').':','d','r','20%','sem_edit').sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";
  }

// Google-Map
  if($config->get('sem_p012','') != "") {
    $htxt = "<input class=\"sem_inputbox\" type=\"text\" name=\"gmaploc\" size=\"50\" maxlength=\"250\" value=\"".$row->gmaploc."\" /> ";
    $actform = "FrontForm";
    $gmaphref = JURI::BASE();
    if(strstr($gmaphref,"/administrator")) {
      $actform = "adminForm";
    }
    $htxt .= "<a href=\"\" title=\"".JTEXT::_('SEM_0017')."\" class=\"modal\" onclick=\"href='".sem_f005()."/seminar.gmap.php?key=".$config->get('sem_p012','')."&amp;iw=".$config->get('sem_p013',1)."&amp;ziel=' + unescape(document.".$actform.".gmaploc.value) + '&amp;ort=' + unescape(document.".$actform.".place.value.replace(/\\n/gi, '<br />'));\" rel=\"{handler: 'iframe', size: {x: 500, y: 350}}\">".JTEXT::_('SEM_0017')."</a>";
    $html .= "<tr>".sem_f022(JTEXT::_('SEM_0016').':','d','r','20%','sem_edit').sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";
  }

// Leitung
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0019').':','d','r','20%','sem_edit').sem_f022("<input class=\"sem_inputbox\" type=\"text\" name=\"teacher\" size=\"50\" maxlength=\"250\" value=\"".$row->teacher."\" />",'d','l','80%','sem_edit')."</tr>";

// Zielgruppe
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0012').':','d','r','20%','sem_edit').sem_f022("<input class=\"sem_inputbox\" type=\"text\" name=\"target\" size=\"50\" maxlength=\"500\" value=\"".$row->target."\" />",'d','l','80%','sem_edit')."</tr>";

// Gebuehr
  $htxt = $config->get('sem_p017',JTEXT::_('SEM_0165'))."&nbsp;<input class=\"sem_inputbox\" type=\"text\" name=\"fees\" size=\"8\" maxlength=\"10\" value=\"".$row->fees."\" />";
  if($config->get('sem_p023',0)>0) {
    $htxt .= " ".JTEXT::_('SEM_0085');
  }
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0022').':','d','r','20%','sem_edit').sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";
  $html .= "</table>";
  $html .= $pane->endPanel() ;

// ### Panel 3 ###

  $html .= $pane->startPanel(JTEXT::_('SEM_0129'),'panel3');
  $html .= "<table>";
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0156')."<br />&nbsp;<br />".JTEXT::_('SEM_0158')."<br />&nbsp;<br />".JTEXT::_('SEM_0162')."<br />&nbsp;<br />",'d','l','100%','sem_edit',2)."</tr>";

// Zusatzfelder
  $zusfeld = sem_f017($row);
  for($i=0;$i<count($zusfeld[0]);$i++) {
    $html .= "<tr>".sem_f022(JTEXT::_('SEM_0023')." ".($i+1).":",'d','r','20%','sem_edit');
    $htxt = "<input class=\"sem_inputbox\" type=\"text\" name=\"zusatz".($i+1)."\" size=\"50\" value=\"".$zusfeld[0][$i]."\" />";
    $html .= sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";
    $html .= "<tr>".sem_f022("&nbsp;",'d','r','20%','sem_edit');
    $htxt = JTEXT::_('SEM_0112').": <input class=\"sem_inputbox\" type=\"text\" name=\"zusatz".($i+1)."hint\" size=\"50\" maxlength=\"120\" value=\"".$zusfeld[1][$i]."\" />";
    $html .= sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";
    $html .= "<tr>".sem_f022("&nbsp;",'d','r','20%','sem_edit');
    $radios = array();      
    $radios[] = JHTML::_('select.option',1,JTEXT::_('SEM_0005'));
    $radios[] = JHTML::_('select.option',0,JTEXT::_('SEM_0006'));
    $htxt = str_replace("SEM_FNUM",$i+1,JTEXT::_('SEM_0117'));
    $htxt = $htxt." ".JHTML::_('select.radiolist', $radios,'zusatz'.($i+1).'show', 'class="sem_inputbox" ','value','text',$zusfeld[2][$i]);
    $html .= sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";
  }
  $html .= "</table>";
  $html .= $pane->endPanel() ;

// ### Panel 5 ###
  if($config->get('sem_p056',200)>0) {
    $html .= $pane->startPanel(JTEXT::_('SEM_0131'),'panel4');
    $htxt = str_replace("SEM_FILESIZE",$config->get('sem_p056',200),JTEXT::_('SEM_0143'));
    $htxt = str_replace("SEM_FILETYPES",strtoupper($config->get('sem_p057','txt zip pdf')),$htxt);
    $html .= "<table>";
    $html .= "<tr>".sem_f022($htxt,'d','l','100%','sem_edit',2)."</tr>";
    $datfeld = sem_f060($row);
    $select = array();      
    $select[] = JHTML::_('select.option',0,JTEXT::_('SEM_0135'));
    $select[] = JHTML::_('select.option',1,JTEXT::_('SEM_0136'));
    $select[] = JHTML::_('select.option',2,JTEXT::_('SEM_0137'));
    $select[] = JHTML::_('select.option',3,JTEXT::_('SEM_0140'));
    for($i=0;$i<count($datfeld[0]);$i++) {
      $html .= "<tr>".sem_f022(JTEXT::_('SEM_0132')." ".($i+1).":",'d','r','20%','sem_edit');
      if($datfeld[0][$i]!="") {
        $htxt = "<b>".$datfeld[0][$i]."</b> - <input class=\"sem_inputbox\" type=\"checkbox\" name=\"deldatei".($i+1)."\" value=\"1\" onClick=\"if(this.checked==true) {datei".($i+1).".disabled=true;} else {datei".($i+1).".disabled=false;}\"> ".JTEXT::_('SEM_0144'); 
        $html .= sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";
        $html .= "<tr>".sem_f022("&nbsp;",'d','r','20%','sem_edit');
      }
      $htxt = "<input class=\"sem_inputbox\" name=\"datei".($i+1)."\" type=\"file\">";
      $html .= sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";
      $html .= "<tr>".sem_f022("&nbsp;",'d','r','20%','sem_edit');
      $htxt = JTEXT::_('SEM_0014').": <input class=\"sem_inputbox\" type=\"text\" name=\"file".($i+1)."desc\" size=\"50\" maxlength=\"255\" value=\"".$datfeld[1][$i]."\" />";
      $html .= sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";
      $html .= "<tr>".sem_f022("&nbsp;",'d','r','20%','sem_edit');
      $htxt = JHTML::_('select.genericlist', $select,'file'.($i+1).'down', 'class="sem_inputbox" ','value','text',$datfeld[2][$i]);
      $html .= sem_f022(JTEXT::_('SEM_0134')." ".$htxt,'d','l','80%','sem_edit')."</tr>";
    }
    $html .= "</table>";
    $html .= $pane->endPanel() ;
  }

  $html .= $pane->endPane() ;
  $html .= "\n</td></tr><tr>".sem_f022("&nbsp;* ".JTEXT::_('SEM_0118'),'d','r','100%','sem_nav',2);

// Benutzer informieren
//   if($art!=3) {
//     $html .= "</tr></td></tr>";
//     $radios = array();
//     $radios[] = JHTML::_('select.option',1,JTEXT::_('SEM_0005'));
//     $radios[] = JHTML::_('select.option',0,JTEXT::_('SEM_0006'));
//     $htx2 .= "<br />".JHTML::_('select.radiolist',$radios,'inform','class="sem_inputbox"','value','text',0);
//     $htx2 .= "<br />".JTEXT::_('SEM_0108').": <input class=\"sem_inputbox\" type=\"text\" name=\"infotext\" id=\"infotext\" size=\"70\" value=\"".$htx3."\" />";
//     $html .= "\n<tr>".sem_f022($htx2,'d','c','100%','sem_nav',2);
//   }

  return $html;
}
// ++++++++++++++++++++++++++++++++++++++
// +++ Veranstalterliste ausgeben     +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f009($pub) {
  $config = &JComponentHelper::getParams('com_seminar');
  $publevel = $config->get('sem_p001',3);
  $database = &JFactory::getDBO();
  $publevel = $config->get('sem_p001',3);
  $where = array();
  $where [] = "usertype<>'Registered'";
  if($publevel>3) {
    $where [] = "usertype<>'Author'";
  } else if($publevel>4) {
    $where [] = "usertype<>'Editor'";
  } else if($publevel>5) {
    $where [] = "usertype<>'Publisher'";
  } else if($publevel>6) {
    $where [] = "usertype<>'Manager'";
  } else if($publevel>7) {
    $where [] = "usertype<>'Administrator'";
  }
  $database->setQuery( "SELECT id AS value, name AS text FROM #__users"
    . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
  . "\nORDER BY name"
  );
  $benutzer = $database->loadObjectList();
  return JHTML::_('select.genericlist', array_merge($benutzer), 'publisher', 'class="sem_inputbox" size="1"', 'value', 'text', $pub);
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Kategorienliste ausgeben     +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f010($catid) {
  $database = &JFactory::getDBO();
  $reglevel = sem_f042();
  $accesslvl = 1;
  if($reglevel>=6) {
    $accesslvl=3;
  } else if ($reglevel>=2) {
    $accesslvl=2;
  }
  $categories[] = JHTML::_('select.option','0',JTEXT::_('SEM_0041'));
  $database->setQuery( "SELECT id AS value, title AS text, image AS image FROM #__categories". " WHERE section='".JRequest::getCmd('option')."' AND access<".$accesslvl." ORDER BY ordering" );
  $dats = $database->loadObjectList();
  $categories = array_merge($categories,$dats);
  $clist = JHTML::_('select.genericlist', $categories, 'caid', 'class="sem_inputbox" size="1"','value', 'text', intval($catid) );
  $ilist = array();
  foreach($dats as $el) {
    $bild = "";
    if($el->image!="") {
      $bild->id = $el->value;
      $bild->image = $el->image;
      $ilist[] = $bild;
    }
  }
  return array($clist,$ilist);
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Benutzerliste ausgeben         +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f011($row) {
  $config = &JComponentHelper::getParams('com_seminar');
  $database = &JFactory::getDBO();
//  $database->setQuery( "SELECT a.*, cc.*, a.id AS sid FROM #__sembookings AS a LEFT JOIN #__users AS cc ON cc.id = a.userid WHERE a.semid = '$row->id' ORDER BY a.id");
  $database->setQuery( "SELECT userid AS id FROM #__sembookings WHERE semid = '$row->id'");
  $users = $database->loadObjectList();
  if ($database->getErrorNum()) {
    echo $database->stderr();
    return false;
  }
  if((count($users)>= $row->maxpupil) AND ($row->stopbooking>0)) {
    $blist = "";
  } else {
    $userout = array();
    if($config->get('sem_p002','') == 0) {
      $userout[] = $row->publisher;
    }
    foreach ($users as $user) {
      $userout[] = $user->id; 
    }
    $where = "";
    if( count($userout)>0 ) {
      $userout = implode( ',', $userout );
      $where = "\nWHERE id NOT IN ($userout)";
    }
    $database->setQuery( "SELECT id AS value, name AS text FROM #__users"
    . $where
    . "\nORDER BY name"
    );
    $benutzer = $database->loadObjectList();
    if($config->get('sem_allow_notregpub','') > 0) {
      
    }
    if( count($benutzer) ) {
      $benutzer = array_merge($benutzer);
      $blist = JHTML::_('select.genericlist', $benutzer, 'uid', 'class="sem_inputbox" size="1"', 'value', 'text', '');
    } else {
      $blist = "";
    }
  }
  return $blist;
}

// ++++++++++++++++++++++++++++++++++++++++++++++++
// +++ Name und Beschreibung der Kategorie ausgeben
// ++++++++++++++++++++++++++++++++++++++++++++++++

function sem_f012($catid) {
  $database = &JFactory::getDBO();
  $database->setQuery( "Select * FROM #__categories WHERE section='com_seminar' AND id = '$catid'");
  $rows = $database->loadObjectList();
  return array($rows[0]->title,$rows[0]->description);
}

// +++++++++++++++++++++++++++++++++++++++
// +++ Ausgabe des Prozentbalkens         
// +++++++++++++++++++++++++++++++++++++++

function sem_f013($max,$frei,$art) {
  if($max==0) {$max = 1;}
  $hoehe = 30;
  $hoehefrei = round($frei*$hoehe/$max);
  $hoehebelegt = $hoehe-$hoehefrei;
  $html = "<span class=\"sem_bar\">".$max."</span><br />";
  $html .= "<img src=\"".sem_f006()."2100.png\" width=\"18\" height=\"1\"><br />";
  if($hoehefrei>0) {
    $html .= "<img src=\"".sem_f006()."212".$art.".png\" width=\"18\" height=\"".$hoehefrei."\"><br />";
  }
  if($hoehebelegt>0) {
    $html .= "<img src=\"".sem_f006()."211".$art.".png\" width=\"18\" height=\"".$hoehebelegt."\"><br />";
  }
  $html .= "<img src=\"".sem_f006()."2100.png\" width=\"18\" height=\"1\"><br />";
  $html .= "<span class=\"sem_bar\">0</span>";
  return $html;
}

// +++++++++++++++++++++++++++++++++++++++++++++++++++
// +++ Anzeige der versteckten Variablen im Frontend +
// +++++++++++++++++++++++++++++++++++++++++++++++++++

function sem_f014($task, $catid, $search, $limit, $limitstart, $cid, $dateid, $uid) {
  $html = "<input type=\"hidden\" name=\"task\" value=\"".$task."\" />";
  $html .= "<input type=\"hidden\" name=\"limitstart\" value=\"".$limitstart."\" />";
  $html .= "<input type=\"hidden\" name=\"cid\" value=\"".$cid."\" />";
  if($catid!="") {
   $html .= "<input type=\"hidden\" name=\"catid\" value=\"".$catid."\" />";
  }
  if($search!="") {
    $html .= "<input type=\"hidden\" name=\"search\" value=\"".$search."\" />";
  }
  if($limit!="") {
   $html .= "<input type=\"hidden\" name=\"limit\" value=\"".$limit."\" />";
  }
  if($uid!="") {
    if($uid==-1) {
      $uid = "";
    }
    $html .= "<input type=\"hidden\" name=\"uid\" value=\"".$uid."\" />";
  }
  if($dateid!="") {
    $html .= "<input type=\"hidden\" name=\"dateid\" value=\"".$dateid."\" />";
  }
  return $html;
}

// ++++++++++++++++++++++++++++++++++++++++++++++++++
// +++ Ausgabe der Versteckten Variablen im Backend +
// ++++++++++++++++++++++++++++++++++++++++++++++++++

function sem_f015() {
  $html = "<input type=\"hidden\" name=\"katid\" value=\"".trim(JRequest::getVar('katid',0))."\">";
  $html .= "<input type=\"hidden\" name=\"ordid\" value=\"".trim(JRequest::getVar('ordid',0))."\">";
  $html .= "<input type=\"hidden\" name=\"ricid\" value=\"".trim(JRequest::getVar('ricid',0))."\">";
  $html .= "<input type=\"hidden\" name=\"einid\" value=\"".trim(JRequest::getVar('einid',0))."\">";
  $html .= "<input type=\"hidden\" name=\"limit\" value=\"".trim(JRequest::getVar('limit',0))."\">";
  $html .= "<input type=\"hidden\" name=\"limitstart\" value=\"".trim(JRequest::getVar('limitstart',0))."\">";
  $html .= "<input type=\"hidden\" name=\"search\" value=\"".trim(strtolower(JRequest::getVar('search','')))."\">";
  return $html;
}

// +++++++++++++++++++++++++++++++++++++++
// +++ Ausgabe eines Prozentbalkens
// +++++++++++++++++++++++++++++++++++++++

function sem_f016($done) {
  $max = 100;
  if ($done < 0) {
    $done = 0;
  }
  if ($done > $max) {
    $done = $max;
  }
  $displayValue = $done/$max*100;
  $displayValue = number_format($displayValue, 0, '.', '');
  return "<span style=\"white-space: nowrap;\"><img src=\"".sem_f006()."3000.png\" height=\"10\" width=\"".$displayValue."\"><img src=\"".sem_f006()."3001.png\" height=\"10\" width=\"".(100-$displayValue)."\"></span>";
}

// ++++++++++++++++++++++++++++++++++
// +++ Aray mit Zusatzfeldern erzeugen
// ++++++++++++++++++++++++++++++++++

function sem_f017($row) {
  $zusfeld = array();
  $zusfeld[] = array($row->zusatz1,$row->zusatz2,$row->zusatz3,$row->zusatz4,$row->zusatz5,$row->zusatz6,$row->zusatz7,$row->zusatz8,$row->zusatz9,$row->zusatz10,$row->zusatz11,$row->zusatz12,$row->zusatz13,$row->zusatz14,$row->zusatz15,$row->zusatz16,$row->zusatz17,$row->zusatz18,$row->zusatz19,$row->zusatz20);
  if(isset($row->zusatz1hint)) {
    $zusfeld[] = array($row->zusatz1hint,$row->zusatz2hint,$row->zusatz3hint,$row->zusatz4hint,$row->zusatz5hint,$row->zusatz6hint,$row->zusatz7hint,$row->zusatz8hint,$row->zusatz9hint,$row->zusatz10hint,$row->zusatz11hint,$row->zusatz12hint,$row->zusatz13hint,$row->zusatz14hint,$row->zusatz15hint,$row->zusatz16hint,$row->zusatz17hint,$row->zusatz18hint,$row->zusatz19hint,$row->zusatz20hint);
    $zusfeld[] = array($row->zusatz1show,$row->zusatz2show,$row->zusatz3show,$row->zusatz4show,$row->zusatz5show,$row->zusatz6show,$row->zusatz7show,$row->zusatz8show,$row->zusatz9show,$row->zusatz10show,$row->zusatz11show,$row->zusatz12show,$row->zusatz13show,$row->zusatz14show,$row->zusatz15show,$row->zusatz16show,$row->zusatz17show,$row->zusatz18show,$row->zusatz19show,$row->zusatz20show);
  }
  return $zusfeld; 
}
  
// ++++++++++++++++++++++++++++++++++
// +++ Text von HTML befreien
// ++++++++++++++++++++++++++++++++++

  function sem_f018($text) {
    $text = preg_replace("'<script[^>]*>.*?</script>'si", '',$text);
    $text = preg_replace('/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is','\2 (\1)',$text);
    $text = preg_replace('/<!--.+?-->/','',$text);
    $text = preg_replace('/{.+?}/','',$text);
    $text = preg_replace('/&nbsp;/',' ',$text);
    $text = preg_replace('/&amp;/',' ',$text);
    $text = str_replace("\'","'",$text);
    $text = str_replace('\"','"',$text);
    $text = strip_tags($text);
    return $text;
  }

// ++++++++++++++++++++++++++++++++++
// +++ Pathway erweitern
// ++++++++++++++++++++++++++++++++++

function sem_f019($text, $link) {
  $mainframe = JFactory::getApplication();
  $pathway = $mainframe->getPathWay();
  $pathway->addItem($text,$link);
}

// ++++++++++++++++++++++++++++++++++
// +++ Berechne die gebuchten Plaetze
// ++++++++++++++++++++++++++++++++++

function sem_f020($row) {
  $database = &JFactory::getDBO();
  $database->setQuery( "SELECT * FROM #__sembookings WHERE semid='".$row->id."'" );
  $temps = $database->loadObjectList();
  $gebucht = 0;
  $zertifiziert = 0;
  $bezahlt = 0;
  foreach($temps as $el) {
    $gebucht = $gebucht + $el->nrbooked;
    $zertifiziert = $zertifiziert + $el->certificated;
    $bezahlt = $bezahlt + $el->paid;
  }
  $zurueck->booked = $gebucht;
  $zurueck->certificated = $zertifiziert;
  $zurueck->paid = $bezahlt;
  $zurueck->number = count($temps);
  return $zurueck;
}

// ++++++++++++++++++++++++++++++++++
// +++ ist Kurs noch buchbar
// ++++++++++++++++++++++++++++++++++

function sem_f021($art, $row, $usrid) {
  $database = &JFactory::getDBO();
  $config = &JComponentHelper::getParams('com_seminar');
  $database->setQuery( "SELECT * FROM #__sembookings WHERE semid='$row->id' ORDER BY id" );
  $temps = $database->loadObjectList();
  $gebucht = 0;
  foreach($temps as $el) {
    $gebucht = $gebucht + $el->nrbooked;
  }

  if($usrid<0) {
    $sid = $usrid * -1;
    $database->setQuery("SELECT * FROM #__sembookings WHERE id='$sid'");
    $userid = 0;
  } else {
    if($usrid==0) {
      $usrid = -1;
    }
    $database->setQuery("SELECT * FROM #__sembookings WHERE semid='$row->id' AND userid='$usrid'");
  }
  $temp = $database->loadObjectList();

  $freieplaetze = $row->maxpupil - $gebucht;
  if($freieplaetze < 0) {
    $freieplaetze = 0;
  }
  $buchbar = 3;
  $buchgraf = 2;
  $altbild = JTEXT::_('SEM_0031');
  $reglevel = sem_f042();
  $neudatum = sem_f046();
  if($neudatum>$row->booked) {
    $buchbar=1;
    $buchgraf = 0;
    $altbild = JTEXT::_('SEM_1010');
  } else if($row->cancelled==1 OR ($freieplaetze<1 AND $row->stopbooking==1) OR ($usrid==$row->publisher AND $config->get('sem_p002',0)==0)) {
    $buchbar=1;
    $buchgraf = 0;
    $altbild = JTEXT::_('SEM_0088');
  } else if($freieplaetze<1 AND ($row->stopbooking==0 OR $row->stopbooking==2)) {
    $buchgraf = 1;
    $altbild = JTEXT::_('SEM_0036');
 }
  if(count($temp)>0) {
    $buchbar = 2;
    $buchgraf = 0;
    $altbild = JTEXT::_('SEM_1007');
  }
  if($reglevel<1) {
    $buchbar = 0;
  }
  if($art==1) {
    $buchgraf = 2;
    $altbild = JTEXT::_('SEM_0030');
    $gebucht = sem_f020($row);
    if($gebucht->booked > $row->maxpupil) {
      if ($row->stopbooking==0 OR $row->stopbooking==2) {
        $summe = 0;
        for ($l=0, $m=count($temps); $l < $m; $l++) {
          $summe = $summe + $temps[$l]->nrbooked;
          if($temps[$l]->userid == $usrid) {
            break;
          }
        }
        if($summe > $row->maxpupil ) {
            $buchgraf = 1;
            $altbild = JTEXT::_('SEM_0025');
        }
      } else {
          $buchgraf = 0;
          $altbild = JTEXT::_('SEM_0029');
      }
    }
    if($row->cancelled==1) {
      $buchgraf = 0;
      $altbild = JTEXT::_('SEM_0088');
    }
  }
  if($art==2) {
    $buchgraf = 2;
    $altbild = JTEXT::_('SEM_0045');
    if( $neudatum > $row->end ) {
      $buchgraf = 0;
      $altbild = JTEXT::_('SEM_0046');
    } else if( $neudatum > $row->begin ) {
      $buchgraf = 1;
      $altbild = JTEXT::_('SEM_0047');
    }
  }
  return array($buchbar, $altbild, $temp, $buchgraf, $freieplaetze);
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Tabellenzelle ausgeben
// ++++++++++++++++++++++++++++++++++++++
// sem_f022(text,art,align,width,class,colspan)

function sem_f022() {
  $args = func_get_args();
  $html = "\n<t".$args[1];
  if(count($args)>4) {
  if($args[4]!="") {
    $html .= " class=\"".$args[4]."\"";
  }}
  if(count($args)>2) {
  if($args[2]!="") {
    $html .= " style=\"text-align:";
    switch($args[2]) {
      case "l":
        $html .= "left";
        break;
      case "r":
        $html .= "right";
        break;
      case "c":
        $html .= "center";
        break;
    }
    $html .= ";\"";
  }}
  if(count($args)>3) {
  if($args[3]!="") {
    $html .= " width=\"".$args[3]."\"";
  }}
  if(count($args)>5) {
  if($args[5]) {
    $html .= " colspan=\"".$args[5]."\"";
  }}
  $html .= ">".$args[0]."</t".$args[1].">";
  return $html;
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Tabellenkopf ausgeben
// ++++++++++++++++++++++++++++++++++++++

function sem_f023() {
  $args = func_get_args();
  if(is_numeric($args[0])) {
    $html = "\n<table cellpadding=\"".$args[0]."\" cellspacing=\"0\" border=\"0\"";
    if(count($args)==2) {
      $html .= " class=\"".$args[1]."\"";
    }
    $html .= " width=\"100%\">";
  } else {
    $html = "\n</table>";
  }
  return $html;
}

// +++++++++++++++++++++++++++++++++++++++
// +++ Ausgabe einer Tabellenzeile     +++
// +++++++++++++++++++++++++++++++++++++++

  function sem_f024($art,$var1,$var2,$werte,$klasse) {
    $zurueck = "<tr";
     if( $klasse <> "") {
       $zurueck .= " class=\"".$klasse."\"";
     }
    $zurueck .= ">";

    $n = count($werte);
    for ($l=0, $n; $l < $n; $l++) {
      $format1 = "";
      if(is_array($var1)) {
        switch( $var1[$l] ) {
          case "c2":
            $format1 .= " colspan=\"2\"";
            break;
          case "nw":
            $format1 .= " nowrap=\"nowrap\"";
            break;
          case "l":
            $format1 .= " style=\"text-align:left;\"";
            break;
          case "r":
            $format1 .= " style=\"text-align:right;\"";
            break;
          case "c":
            $format1 .= " style=\"text-align:center;\"";
            break;
        }
      }
      $format2 = "";
      if(is_array($var2)) {
        switch( $var2[$l] ) {
          case "c2":
            $format1 .= " colspan=\"2\"";
            break;
          case "nw":
            $format1 .= " nowrap=\"nowrap\"";
            break;
          case "l":
            $format1 .= " style=\"text-align:left;\"";
            break;
          case "r":
            $format1 .= " style=\"text-align:right;\"";
            break;
          case "c":
            $format1 .= " style=\"text-align:center;\"";
            break;
        }
      }
      $zurueck .= "<".$art.$format1.$format2.">".$werte[$l]."</".$art.">";
    }

    $zurueck .= "</tr>";
    return $zurueck;
  }

// ++++++++++++++++++++++++++++++++++++++
// +++ Fensterstatus loeschen
// ++++++++++++++++++++++++++++++++++++++

function sem_f025($status) {
  return "onmouseover=\"window.status='".$status."';return true;\" onmouseout=\"window.status='';return true;\"";
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Formularstart ausgeben
// ++++++++++++++++++++++++++++++++++++++

function sem_f026($art) {
  $htxt = "FrontForm";
  if($art==2 OR $art == 4) {
    $htxt = "adminForm";
  }
  $type = "";
  if($art>2) {
    $type = " enctype=\"multipart/form-data\"";
  }
  echo "<form action=\"\" method=\"post\" name=\"".$htxt."\" id=\"".$htxt."\"".$type.">";
}

// ++++++++++++++++++++++++++++++++++
// +++ Ausgabe Javascript
// ++++++++++++++++++++++++++++++++++

function sem_f027($art) {
  $config = &JComponentHelper::getParams('com_seminar');
  $my = &JFactory::getuser();
  $html = "\n<script type=\"text/javascript\">";
  if($art==4 OR $art==6 OR $art==8) {
    $html .= "\nwmtt = null;";
    $html .= "\ndocument.onmousemove = semTip";
    $html .= "\nfunction semTip(e) {";
    $html .= "\nif (wmtt != null) {";
    $html .= "\nx = (document.all) ? window.event.x + wmtt.offsetParent.scrollLeft : e.pageX;";
    $html .= "\ny = (document.all) ? window.event.y + wmtt.offsetParent.scrollTop  : e.pageY;";
    $html .= "\nwmtt.style.left = (x + 20) + 'px';";
    $html .= "\nwmtt.style.top   = (y + 20) + 'px';";
    $html .= "\n}}";
    $html .= "\nfunction showSemTip(id) {";
    $html .= "\nif (document.getElementById(\"image\").value!='') {";
    $html .= "\ndocument.getElementById(\"toolbild\").src='".sem_f007(1)."' + document.getElementById(\"image\").value;";
    $html .= "\n} else if (document.getElementById(\"caid\").value!='0') {";
    $html .= "\nimid = document.getElementById(\"caid\").value;";
    $html .= "\nif (isNaN(document.getElementById(\"im\" + imid))) {";
    $html .= "\ndocument.getElementById(\"toolbild\").src='".sem_f007(0)."' + document.getElementById(\"im\" + imid).value;";
    $html .= "\n} else {";
    $html .= "\nid = 2;";
    $html .= "\n}";
    $html .= "\n} else {";
    $html .= "\nid = 2;";
    $html .= "\n}";
    $html .= "\nwmtt = document.getElementById(id);";
    $html .= "\nwmtt.style.display = 'block'";
    $html .= "\n}";
    $html .= "\nfunction hideSemTip() {";
    $html .= "\nwmtt.style.display = 'none';";
    $html .= "\n}";
  }  
  if($art!=2.3) {
    if(round($art)==2) {
      $html .= "\nfunction chmail(s) {";
      $html .= "\n var a = false;";
      $html .= "\n var res = false;";
      $html .= "\n if(typeof(RegExp) == 'function') {";
      $html .= "\n  var b = new RegExp('abc');";
      $html .= "\n  if(b.test('abc') == true) a = true;";
      $html .= "\n }";
      $html .= "\n if(a == true) {";
      $html .= "\n  reg = new RegExp('^([a-zA-Z0-9\-\.\_]+)'+ '(\@)([a-zA-Z0-9\-\.]+)'+ '(\.)([a-zA-Z]{2,4})$');";
      $html .= "\n  res = (reg.test(s));";
      $html .= "\n } else {";
      $html .= "\n  res = (s.search('@') >= 1 && s.lastIndexOf('.') > s.search('@') && s.lastIndexOf('.') >= s.length-5);";
      $html .= "\n }";
      $html .= "\n return(res);";
      $html .= "\n}";
    }
  }
  if($art<5) {
    $html .= "\nfunction los(stask,scid,suid) {";
    $html .= "\n var form = document.FrontForm;";
    $html .= "\n form.task.value = stask;";
    $html .= "\n if(scid != '') form.cid.value = scid;";
    $html .= "\n if(suid != '') form.uid.value = suid;";
    $html .= "\n form.submit();";
    $html .= "\n}";
    $html .= "\nfunction auf(stask,scid,suid) {";
    $html .= "\n var form = document.FrontForm;";
  }
  if(round($art)>2 AND $art<5) {
    $html .= "\n if (stask == \"10\") {";
    $html .= "\n  if (form.title.value == \"\") {";
    $html .= "\n   alert(unescape( \"".JTEXT::_('SEM_A006')."\" ));";
    $html .= "\n  } else if (form.semnum.value == \"\") {";
    $html .= "\n   alert(unescape( \"".JTEXT::_('SEM_A004')."\" ));";
    $html .= "\n  } else if (form.caid.selectedIndex == 0) {";
    $html .= "\n   alert(unescape( \"".JTEXT::_('SEM_A001')."\" ));";
    $html .= "\n  } else if (form.shortdesc.value == \"\") {";
    $html .= "\n   alert(unescape( \"".JTEXT::_('SEM_A003')."\" ));";
    $html .= "\n  } else if (form.place.value == \"\") {";
    $html .= "\n   alert(unescape( \"".JTEXT::_('SEM_A002')."\" ));";
    $html .= "\n  } else {";
    $html .= "\n   if (form.vorlage.type == \"select-one\") {";
    $html .= "\n    form.id.value = \"\";";
    $html .= "\n   };";
    $html .= "\n   form.pattern.value = \"\";";
    $html .= "\n   los(stask,scid,suid);";
    $html .= "\n  };";
    $html .= "\n } else if (stask == \"11\") {";
    $html .= "\n  if (confirm(unescape(\"".JTEXT::_('SEM_A102')."\"))) {";
    $html .= "\n   los(stask,scid,suid);";
    $html .= "\n  }";
    $html .= "\n } else";
  }
  if($art<5) {
    if($art!=2.3) {
      $html .= "\n if (stask == \"6\" || stask == \"7\") {";
      if($config->get('sem_p028',1)>0) {
        $html .= "\n  if (confirm(unescape(\"".JTEXT::_('SEM_A103')."\"))) {";
      }
      $html .= "\n  los(stask, scid, suid);";
      if($config->get('sem_p028',1)>0) {
        $html .= "\n  }";
      }
      if(round($art)==2) {
        $html .= "\n } else if (stask == \"5\" || stask==\"26\" || stask==\"29\") {";
        $html .= "\n  var abbruch = false;";
        $html .= "\n  var meldung = unescape(\"".JTEXT::_('SEM_A101')."\");";
        $html .= "\n  for (var z=1; z<21; z++) {";
        $html .= "\n   ename = \"zusatz\" + z;";
        $html .= "\n   oname = \"opt\" + z;";
        $html .= "\n   if (document.FrontForm.elements[ename].type == \"text\" || document.FrontForm.elements[ename].type == \"textarea\") {";
        $html .= "\n    document.FrontForm.elements[ename].className=\"sem_inputbox\";";
        $html .= "\n    if (document.FrontForm.elements[ename].value == \"\" && document.getElementById(oname).value == 1) {";
        $html .= "\n     document.FrontForm.elements[ename].className=\"sem_alertbox\";";
        $html .= "\n     abbruch = true;";
        $html .= "\n    } else if (document.FrontForm.elements[ename].value != \"\") {";
        $html .= "\n     if (document.FrontForm.elements[ename].id.match(/email/)) {";
        $html .= "\n      if (chmail(document.FrontForm.elements[ename].value) == false) {";
        $html .= "\n       document.FrontForm.elements[ename].className=\"sem_alertbox\";";
        $html .= "\n       meldung = meldung.concat(unescape(\"\\n".JTEXT::_('SEM_A105')."\"));";
        $html .= "\n       abbruch = true;";
        $html .= "\n      }";
        $html .= "\n     }";
        $html .= "\n    }";
        $html .= "\n   }";
        $html .= "\n   if (document.FrontForm.elements[ename].type == \"select-one\") {";
        $html .= "\n    document.FrontForm.elements[ename].className=\"sem_inputbox\";";
        $html .= "\n    if (document.FrontForm.elements[ename].options.selectedIndex == \"0\" && document.getElementById(oname).value == 1) {";
        $html .= "\n    document.FrontForm.elements[ename].className=\"sem_alertbox\";";
        $html .= "\n     abbruch = true;";
        $html .= "\n    }";
        $html .= "\n   }";
        $html .= "\n  }";
        if($config->get('sem_p026',0)>0 AND ($my->id==0 OR $art==2.2)) {
          $html .= "\n  document.FrontForm.name.className=\"sem_inputbox\";";
          $html .= "\n  if (document.FrontForm.name.value == '') {";
          $html .= "\n   document.FrontForm.name.className=\"sem_alertbox\";";
          $html .= "\n   abbruch = true;";
          $html .= "\n  }";
          $html .= "\n  document.FrontForm.email.className=\"sem_inputbox\";";
          $html .= "\n  if (document.FrontForm.email.value == '') {";
          $html .= "\n   document.FrontForm.email.className=\"sem_alertbox\";";
          $html .= "\n   abbruch = true;";
          $html .= "\n  }";
          $html .= "\n  if (document.FrontForm.email.value != '' && chmail(document.FrontForm.email.value) == false) {";
          $html .= "\n   document.FrontForm.email.className=\"sem_alertbox\";";
          $html .= "\n   meldung = meldung.concat(unescape(\"\\n".JTEXT::_('SEM_A105')."\"));";
          $html .= "\n   abbruch = true;";
          $html .= "\n  }";
        }
        $html .= "\n  if (abbruch == true) {";
        $html .= "\n   alert(meldung);";
        if($config->get('sem_p020',"")!="") {
          $html .= "\n  } else if(document.FrontForm.veragb.checked == 0) {";
          $html .= "\n    document.FrontForm.veragb.className=\"sem_alertbox\";";
          $html .= "\n    alert(unescape( \"".JTEXT::_('SEM_A104')."\" ));";
          $html .= "\n  } else if(document.FrontForm.veragb.checked == 1) {";
          $html .= "\n    document.FrontForm.veragb.className=\"sem_inputbox\";";
        } else {
          $html .= "\n  } else {";
        }
        if($config->get('sem_p027',0)>0) {
          $html .= "\n   if (confirm(unescape(\"".JTEXT::_('SEM_A106')."\"))) {";
        }
        $html .= "\n   los(stask,scid,suid);";
        if($config->get('sem_p027',0)>0) {
          $html .= "\n   }";
        }
        $html .= "\n  }";
      }
      $html .= "\n } else {";
    }
    $html .= "\n  los(stask,scid,suid);";
    if($art!=2.3) {
      $html .= "\n }";
    }
    $html .= "\n}";
  }
  $html .= "\n</script>";
  return $html;  
}

// ++++++++++++++++++++++++++++++++++
// +++ Copyright ausgeben         +++
// ++++++++++++++++++++++++++++++++++

function sem_f028() {
  $html = "";
  if(sem_f053()==TRUE) {
    $html = "<center><table><tr><td class=\"sem_footer\"><img src=\"".sem_f006()."menulogo.png\" border='0' style=\"vertical-align:middle\"> <i><a href=\"http://seminar.vollmar.ws\" target=\"_new\">".JTEXT::_('SEM_0043')."</a> V".sem_f001()."</i> &#169; &#68;&#105;&#114;&#107; &#86;&#111;&#108;&#108;&#109;&#97;&#114; ".date("Y")."</td></tr></table></center>";
  }
  return $html;
}

// ++++++++++++++++++++++++++++++++++
// +++ Farbbeschreibung anzeigen  +++
// ++++++++++++++++++++++++++++++++++

function sem_f029($green,$yellow,$red) {
      $html = sem_f023(4)."<tr>";
      if($green!="") {
        $html .= sem_f022("<img src=\"".sem_f006()."2502.png\" border=\"0\" align=\"absmiddle\"> ".$green,'d','c','','sem_nav');
      }
      if($yellow!="") {
        $html .= sem_f022("<img src=\"".sem_f006()."2501.png\" border=\"0\" align=\"absmiddle\"> ".$yellow,'d','c','','sem_nav');
      }
      if($red!="") {
        $html .= sem_f022("<img src=\"".sem_f006()."2500.png\" border=\"0\" align=\"absmiddle\"> ".$red,'d','c','','sem_nav');
      }
      $html .= "</tr>".sem_f023('e');
      return $html;
}

// ++++++++++++++++++++++++++++++++++
// +++ CSS ausgeben               +++
// ++++++++++++++++++++++++++++++++++

function sem_f030() {
  $config = &JComponentHelper::getParams('com_seminar');
  return "<link rel=\"stylesheet\" href=\"".sem_f005()."css/seminar.".$config->get('sem_p045',0).".css\" type=\"text/css\" />";
}

// ++++++++++++++++++++++++++++++++++
// +++ HTML-Kopf ausgeben         +++
// ++++++++++++++++++++++++++++++++++

function sem_f031() {
  $lang = JFactory::getLanguage();
  $html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
  $html .= "\n<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"".$lang->getName()."\" lang=\"".$lang->getName()."\" >";
  $html .= "\n<head>";
  $html .= "\n<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" />";
  $html .= sem_f030();
  $html .= "\n</head>";
  return $html;
}


// ++++++++++++++++++++++++++++++++++
// +++ Kopf-Bereiche ausgeben     +++
// ++++++++++++++++++++++++++++++++++

function sem_f032($tab) {
  $config = &JComponentHelper::getParams('com_seminar');
  $confusers = &JComponentHelper::getParams('com_users');
  $reglevel = sem_f042();
  switch($tab) {
    case "2":
      $tabnum = array(0,1,0);
      break;
    case "3":
      $tabnum = array(0,0,1);
      break;
    default:
      $tabnum = array(1,0,0);
      break;
  }
  $html = "<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\" width=\"100%\"><tr>";
  if($reglevel>1) {
    $html .= "\n<td class=\"sem_tab".$tabnum[0]."\">";
    $html .= "\n<a class=\"sem_tab\" href=\"javascript:document.FrontForm.limitstart.value='0';auf(0,'','');\" title=\"".JTEXT::_('SEM_0083')."\" ".sem_f025(JTEXT::_('SEM_0083'))."><img src=\"".sem_f006()."2600.png\" border=\"0\" align=\"absmiddle\"> ".JTEXT::_('SEM_0083')."</a>";
    $html .= "</td>";
    $html .= "\n<td class=\"sem_tab".$tabnum[1]."\">";
    $html .= "\n<a class=\"sem_tab\" title=\"".JTEXT::_('SEM_1005')."\" href=\"javascript:document.FrontForm.limitstart.value='0';auf(1,'','');\" ".sem_f025(JTEXT::_('SEM_1005'))."><img src=\"".sem_f006()."2700.png\" border=\"0\" align=\"absmiddle\"> ".JTEXT::_('SEM_1005')."</a>";
    $html .= "\n</td>";
    if($reglevel>=$config->get('sem_p001',3)) {
      $html .= "\n<td class=\"sem_tab".$tabnum[2]."\">";
      $html .= "\n<a class=\"sem_tab\" title=\"".JTEXT::_('SEM_1031')."\" href=\"javascript:document.FrontForm.limitstart.value='0';auf(2,'','');\" ".sem_f025(JTEXT::_('SEM_1031'))."><img src=\"".sem_f006()."2800.png\" border=\"0\" align=\"absmiddle\"> ".JTEXT::_('SEM_1031')."</a>";
      $html .= "\n</td>";
    }
  } else if($config->get('sem_p051',1)>0) {
    $html .= "<td class=\"sem_notableft\">";
    $html .= "<input type=\"text\" name=\"semusername\" value=\"".JTEXT::_('USERNAME')."\" class=\"sem_inputbox\" style=\"background-image:url(".sem_f006()."0004.png);background-repeat:no-repeat;background-position:2px;padding-left:18px;width:100px;vertical-align:middle;\" onFocus=\"if(this.value=='".JTEXT::_('USERNAME')."') this.value='';\" onBlur=\"if(this.value=='') {this.value='".JTEXT::_('USERNAME')."';form.semlogin.disabled=true;}\" onKeyup=\"if(this.value!='') form.semlogin.disabled=false;\"> ";
    $html .= "<input type=\"password\" name=\"sempassword\" value=\"".JTEXT::_('PASSWORD')."\" class=\"sem_inputbox\" style=\"background-image:url(".sem_f006()."0005.png);background-repeat:no-repeat;background-position:2px;padding-left:18px;width:100px;vertical-align:middle;\" onFocus=\"if(this.value=='".JTEXT::_('PASSWORD')."') this.value='';\" onBlur=\"if(this.value=='') this.value='".JTEXT::_('PASSWORD')."';\"> ";
    $html .= "<button class=\"button\" type=\"submit\" style=\"cursor:pointer;vertical-align:middle;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;\" title=\"".JTEXT::_('LOGIN')."\" id=\"semlogin\" disabled><img src=\"".sem_f006()."0007.png\" style=\"vertical-align:middle;\"></button>";
    $html .= "&nbsp;&nbsp;&nbsp;";
    $html .= " <button class=\"button\" type=\"button\" style=\"cursor:pointer;vertical-align:middle;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;\" title=\"".JTEXT::_('SEM_1051')."\" onClick=\"location.href='".sem_f004()."index.php?option=com_user&amp;view=remind'\"><img src=\"".sem_f006()."0008.png\" style=\"vertical-align:middle;\"></button>";
    $html .= " <button class=\"button\" type=\"button\" style=\"cursor:pointer;vertical-align:middle;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;\" title=\"".JTEXT::_('SEM_1050')."\" onClick=\"location.href='".sem_f004()."index.php?option=com_user&amp;view=reset'\"><img src=\"".sem_f006()."0009.png\" style=\"vertical-align:middle;\"></button>";
    if($confusers->get('allowUserRegistration',0)>0) {
      $html .= " <button class=\"button\" type=\"button\" style=\"cursor:pointer;vertical-align:middle;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;\" title=\"".JTEXT::_('SEM_1052')."\" onClick=\"location.href='".sem_f004()."index.php?option=com_user&amp;view=register'\"><img src=\"".sem_f006()."0006.png\" style=\"vertical-align:middle;\"></button>";
    }
    $html .= "</td>";
  }
  $html .= "<td class=\"sem_notab\">&nbsp;";
  $knopfunten = "";
  if($reglevel>1 and $config->get('sem_p051',1)>0) {
      $html .= JHTML::_('link',"javascript:auf(32,'','')",JHTML::_('image',sem_f006().'3232.png',null,array('border'=>'0','align'=>'absmiddle')),array('title'=>JTEXT::_('SEM_1049')))."&nbsp;&nbsp;";
      $knopfunten .= "<button class=\"button\" style=\"cursor:pointer;\" type=\"button\" onclick=\"auf(32,'','');\">".JHTML::_('image',sem_f006().'3216.png',null,array('border'=>'0','align'=>'absmiddle'))."&nbsp;".JTEXT::_('SEM_1049')."</button>";
  }
  echo $html;
  return $knopfunten;
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Ende des Kopfbereichs ausgeben +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f033() {
  echo "</td></tr>".sem_f023('e').sem_f023(4)."<tr><td class=\"sem_anzeige\">";
}

// ++++++++++++++++++++++++++++++++++++++
// +++ E-Mail-Fenster ausgeben
// ++++++++++++++++++++++++++++++++++++++

function sem_f034($dir,$cid,$art) {
  $config = &JComponentHelper::getParams('com_seminar');
  $html = "";
  $href = sem_f004()."index2.php?s=".sem_f036()."&option=".JRequest::getCmd('option')."&cid=".$cid."&task=";
  $x = 500;
  $y = 350;
  $htxt = "<a class=\"modal\" rel=\"{handler: 'iframe', size: {x: ".$x.", y: ".$y."}}\" href=\"".$href;
  if($art==1 AND sem_f042()>1 AND $config->get('sem_p011',0)>0) {
    $html = $htxt."19\" title=\"".JTEXT::_('SEM_1028')."\"><img src=\"".$dir."1732.png\" border=\"0\" align=\"absmiddle\"></a>";
  } else if($art==2 AND sem_f042()>1 AND $config->get('sem_p011',0)>0) {
    $html = $htxt."19\"><button class=\"button\" type=\"button\"><img src=\"".$dir."1716.png\" border=\"0\" align=\"absmiddle\">&nbsp;".JTEXT::_('SEM_1028')."</button></a>";
  } else if($art==3 AND sem_f042()>2) {
    $html = $htxt."30\" title=\"".JTEXT::_('SEM_1028')."\"><img src=\"".$dir."1732.png\" border=\"0\" align=\"absmiddle\"></a>";
  } else if($art==4 AND sem_f042()>2) {
    $html = $htxt."30\"><button class=\"button\" type=\"button\"><img src=\"".$dir."1716.png\" border=\"0\" align=\"absmiddle\">&nbsp;".JTEXT::_('SEM_1028')."</button></a>";
  }
  return $html;
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Bewertungsfenster ausgeben
// ++++++++++++++++++++++++++++++++++++++

function sem_f035($dir,$cid,$imgid) {
  if(sem_f042()>1) {
    $image = "240".$imgid;
    $titel = JTEXT::_('SEM_1020');
    $href = JURI::ROOT()."index2.php?s=".sem_f036()."&option=".JRequest::getCmd('option')."&cid=".$cid."&task=20";
    $x = 500;
    $y = 280;
    return "<a title=\"".$titel."\" class=\"modal\" href=\"".$href."\" rel=\"{handler: 'iframe', size: {x: ".$x.", y: ".$y."}}\"><img id=\"graduate".$cid."\" src=\"".$dir.$image.".png\" border=\"0\" align=\"absmiddle\"></a>";
   }
}

// ++++++++++++++++++++++++++++++++++++++
// +++ zufaellige Zeichen ausgeben
// ++++++++++++++++++++++++++++++++++++++

function sem_f036() {
  $zufall = "";
  for ($i = 0; $i <= 200; $i++) {
    $gkl = rand(1,3);
    if($gkl == 1) {
      $zufall .= chr(rand(97,121));
    } else if( $gkl == 0 ) {
      $zufall .= chr(rand(65,90));
    } else {
      $zufall .= rand(0,9);
    }
  }
  return $zufall;
}
// ++++++++++++++++++++++++++++++++++++++
// +++ Druckfenster im Frontend ausgeben
// ++++++++++++++++++++++++++++++++++++++

function sem_f037($art,$cid,$uid,$knopf) {
  $config = &JComponentHelper::getParams('com_seminar');
//  if(sem_f042() > 1) {
    $dateid = trim(JRequest::getVar('dateid',1));
    $catid = trim(JRequest::getVar('catid',0));
    $search = trim(strtolower(JRequest::getVar('search','')));
    $limit = trim(JRequest::getVar('limit',$config->get('sem_p021',5)));
    $limitstart = trim(JRequest::getVar('limitstart',0));
    if($knopf=="") {
      $image = "1932";
    } else {
      $image = "1916";
    }
    $titel = JTEXT::_('SEM_0066');
    $href = JURI::ROOT()."index2.php?s=".sem_f036()."&option=".JRequest::getCmd('option')."&amp;dateid=".$dateid."&amp;catid=".$catid."&amp;search=".$search."&amp;limit=".$limit."&amp;limitstart=".$limitstart."&amp;cid=".$cid."&amp;uid=".$uid."&amp;OIO=";
    $x = 500;
    $y = 350;
    switch($art) {
      case 1:
// Zertifikat
        $image = "2900";
        $titel = JTEXT::_('SEM_0092');
        $href .= "764576O987985&amp;task=16";
        break;
      case 2:
// Kursuebersicht
        $href .= "65O9805443904&amp;task=15";
        break;
      case 3:
// gebuchte Kurse
        $href .= "6530387504345&amp;task=15";
        break;
      case 4:
// Kursangebot
        $href .= "653O875032490&amp;task=15";
        break;
      case 5:
// Teilnehmerliste1
        $href .= "3728763872762&amp;task=17";
        if($knopf=="") {
          $image = "2032";
        } else {
          $image = "2016";
        }
        break;
      case 6:
// Buchungsbestaetigung
        $href .= "1495735268456&amp;task=printbook";
        break;
      case 7:
// Teilnehmerliste2
        $href .= "4525487566184&task=18";
        break;
    }
    if( ($art>1 AND $config->get('sem_p005',0)>0) OR ($art==1 AND $config->get('sem_p006',0)>0 AND $config->get('sem_p003',0)>0)) {
      if($knopf=="") {
        return "<a title=\"".$titel."\" class=\"modal\" href=\"".$href."\" rel=\"{handler: 'iframe', size: {x: ".$x.", y: ".$y."}}\"><img src=\"".sem_f006().$image.".png\" border=\"0\" align=\"absmiddle\"></a>";
      } else {
        return "<a class=\"modal\" href=\"".$href."\" rel=\"{handler: 'iframe', size: {x: ".$x.", y: ".$y."}}\"><button class=\"button\" style=\"cursor:pointer;\" type=\"button\"><img src=\"".sem_f006().$image.".png\" border=\"0\" align=\"absmiddle\">&nbsp;".$titel."</button></a>";
      }
    } else if( $art==1 AND $config->get('sem_p003',0)>0 ) {
      return "\n<img src=\"".sem_f006()."2900.png\" border=\"0\" align=\"absmiddle\">";
//     } else {
//       return "&nbsp;";
    }
//  }
}
  
// ++++++++++++++++++++++++++++++++++++++
// +++ Druckfenster im Backend ausgeben
// ++++++++++++++++++++++++++++++++++++++

function sem_f038($art,$cid) {
  $katid = trim(JRequest::getVar('katid',0));
  $ordid = trim(JRequest::getVar('ordid',0));
  $ricid = trim(JRequest::getVar('ricid',0));
  $einid = trim(JRequest::getVar('einid',0));
  $search = trim(strtolower(JRequest::getVar('search','')));
  $limit = trim(JRequest::getVar('limit',5));
  $limitstart = trim(JRequest::getVar('limitstart',0));
  $uid = trim(JRequest::getVar('uid',0));

  $zufall = sem_f036();
  $href = "index2.php?s=".$zufall."&option=com_seminar&katid=".$katid."&ordid=".$ordid."&ricid=".$ricid."&einid=".$einid."&search=".$search."&limit=".$limit."&limitstart=".$limitstart."&uid=".$uid."&task=";
  $x = 550;
  $y = 300;
  $image = "1932";
  $title = JTEXT::_('SEM_0066');
  switch($art) {
    case 1:
      $href .= "36";
      break;
    case 2:
      $href .= "34&cid=".$cid;
      $image = "1932";
      break;
    case 3:
      $href .= "35&cid=".$cid;
      $image = "2900";
      $title = JTEXT::_('SEM_0092');
      break;
    case 4:
      $href .= "33&cid=".$cid;
      $image = "2032";
      break;
    case 5:
      $href = "index2.php?s=".$zufall."&option=com_seminar&task=32&cid=".$cid;
      $image = "1632";
      $title = JTEXT::_('SEM_0049');
      break;
  }
  if($art != 5) {
    $html = "<a title=\"".$title."\" class=\"modal\" href=\"".$href."\" rel=\"{handler: 'iframe', size: {x: ".$x.", y: ".$y."}}\">";
  } else {
    $html = "<a title=\"".$title."\" href=\"".$href."\">";
  }
  $html .= "<img src=\"".sem_f006().$image.".png\" border=\"0\" valign=\"absmiddle\" alt=\"".$title."\"></a>";
  return $html;
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Seitennavigation bereinigen    +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f039($total,$limit,$limitstart) {
  $pagenav = array();
  $navi = "";
  $pageone = 1;
  $seiten = 1;
  $kurse = "";
  if($limit > 0) {
    $pageone = $limitstart/$limit +1;
    $seiten = ceil($total/$limit);
    if($pageone > 1) {
      $navi .= "<a class=\"sem_tab\" href=\"javascript:document.FrontForm.limitstart.value='0';document.FrontForm.submit();\">".JTEXT::_('START')."</a>";
      $navi .= " - <a class=\"sem_tab\" href=\"javascript:document.FrontForm.limitstart.value='".($limitstart-$limit)."';document.FrontForm.submit();\">".JTEXT::_('PREV')."</a>";
    } else {
      $navi .= JTEXT::_('START');
      $navi .= " - ".JTEXT::_('PREV');
    }
    $start = 0;
    $ende = $seiten;
    $navi .= " -";
    if($seiten > 5) {
      if($pageone>3) {
        $navi .= " ...";
        if($seiten-2 >= $pageone) {
          $start = $pageone - 3;
          $ende = $pageone + 2;
        } else {
          $start = $seiten - 5;
          $ende = $seiten;          
        }
      } else {
        $ende = 5;
      }      
    }
    for($i=$start;$i<$ende;$i++) {
      if($i*$limit != $limitstart) {
        $navi .= " <a class=\"sem_tab\" href=\"javascript:document.FrontForm.limitstart.value='".($i*$limit)."';document.FrontForm.submit();\">".($i+1)."</a>";
      } else {
        $navi .= " ".($i+1);
        $kurs1 = (($i*$limit)+1);
        $kurs2 = (($i+1)*$limit);
        if($kurs2 > $total) {
          $kurs2 = $total;
        }
        if($kurs1 == $kurs2) {
          $kurse = $kurs2."/".$total;
        } else {
          $kurse = $kurs1."-".$kurs2."/".$total;
        }
      }
    }
    if($seiten > 5) {
      if($pageone+2 < $seiten) {
        $navi .= " ...";
      }
    }
    $navi .= " -";
    if($pageone < $seiten) {
      $navi .= " <a class=\"sem_tab\" href=\"javascript:document.FrontForm.limitstart.value='".($limitstart+$limit)."';document.FrontForm.submit();\">".JTEXT::_('NEXT')."</a>";
      $navi .= " - <a class=\"sem_tab\" href=\"javascript:document.FrontForm.limitstart.value='".($seiten*$limit)."';document.FrontForm.submit();\">".JTEXT::_('END')."</a>";
    } else {
      $navi .= " ".JTEXT::_('NEXT');
      $navi .= " - ".JTEXT::_('END');
    }
  }
  $seite = JTEXT::_('PAGE')."&nbsp;".$pageone."/".($seiten);
  return "\n".sem_f023(4)."<tr>".sem_f022($seite,'d','l','','sem_nav').sem_f022($navi,'d','c','','sem_nav').sem_f022($kurse,'d','r','','sem_nav')."</tr>".sem_f023('e');
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Limitbox fuer Seitennavigation +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f040($art,$limit) {
  $limits = array();
  $htxt = "FrontForm";
  if($art==2) {
    $htxt = "adminForm";
  }
  $limits[] = JHTML::_('select.option','3');
  for( $i=5; $i<=30; $i += 5) {
    $limits[] = JHTML::_('select.option',"$i");
  }
  $limits[] = JHTML::_('select.option','50');
  $limits[] = JHTML::_('select.option','100');
  $limits[] = JHTML::_('select.option','0', JText::_('all'));
  return JHTML::_('select.genericlist', $limits, 'limit','class="sem_inputbox" size="1" onchange="document.'.$htxt.'.limitstart.value=0;document.'.$htxt.'.submit()"', 'value', 'text', $limit);
}
  
// +++++++++++++++++++++++++++++++++++++++
// +++ Anzeige der Ueberschrift          +
// +++++++++++++++++++++++++++++++++++++++

function sem_f041($temp1,$temp2) {
  $html = "<table cellpadding=\"2\" cellspacing=\"0\" border=\"0\" width=\"100%\">";
  $html .= "\n<tr><td class=\"sem_cat_title\">".$temp1."</td></tr>";
  if($temp2!="") {
    $html .= "\n<tr><td class=\"sem_cat_desc\">".$temp2."</td></tr>";
  }
  $html .= "\n</table>";
  echo $html;
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Benutzerlevel festlegen        +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f042() {
  $my = &JFactory::getuser();
  $config = &JComponentHelper::getParams('com_seminar');

// Zugriffslevel festlegen
  $utype = strtolower($my->usertype);
  switch( $utype ) {
    case "registered":
      $reglevel = 2;
      break;
    case "author":
      $reglevel = 3;
      break;
    case "editor":
      $reglevel = 4;
      break;
    case "publisher":
      $reglevel = 5;
      break;
    case "manager":
      $reglevel = 6;
      break;
    case "administrator":
      $reglevel = 7;
      break;
    case "super administrator":
      $reglevel = 8;
      break;
    default:
      $reglevel = 0;
      if($config->get('sem_p026',0)==1) {
        $reglevel = 1;
      }
      break;
  }
  return $reglevel;
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Auf Benutzerlevel testen       +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f043($temp) {
  $reglevel = sem_f042();
  if($reglevel<$temp) {
    JError::raiseError( 403, JText::_("ALERTNOTAUTH") );
    exit;
  }
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Schuetze den HTML-Text         +++
// ++++++++++++++++++++++++++++++++++++++

// function semSchutz() {
//   return "<div style=\"position:fixed; top:0; left:0; width:100%; height:100%; z-Index:10000; \"><img src=\"".sem_f006()."blind.gif\" width=\"100%\" height=\"100%\" style=\"width:100%; height:100%;\"></div>";
// }

// ++++++++++++++++++++++++++++++++++++++
// +++ Waehrung formatieren           +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f044($betrag) {
  $config = &JComponentHelper::getParams('com_seminar');
  return number_format($betrag,$config->get('sem_p061',2),$config->get('sem_p063',JTEXT::_('SEM_0119')),$config->get('sem_p062',JTEXT::_('SEM_0120')));
}

// ++++++++++++++++++++++++++++++++++++++
// +++ FREIE FUNKTION                 +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f045() {
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Aktuelles Datum ausgeben       +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f046() {
  $config = &JComponentHelper::getParams('com_seminar');
  $app = JFactory::getApplication();
  $offset = $app->getCfg('offset');
  if($config->get('sem_p065',0)>0) {
    $jahr = date("Y");
    $sombeginn = mktime(2,0,0,3,31-date('w',mktime(2,0,0,3,31,$jahr)),$jahr);
    $somende = mktime(2,0,0,10,31-date('w',mktime(2,0,0,10,31,$jahr)),$jahr);
    $aktuell = time();
    if($aktuell>$sombeginn AND $aktuell<$somende) {
      $offset++;
    }
  }
  $date = JFactory::getDate();
  $date->setOffset($offset);
  return $date->toformat();
}

// ++++++++++++++++++++++++++++++++++++++
// +++ FREIE FUNKTION                 +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f047() {
}

// +++++++++++++++++++++++++++++
// +++ CSV-Datei senden      +++
// +++++++++++++++++++++++++++++

function sem_f048() {
  $database = &JFactory::getDBO();
  $config = &JComponentHelper::getParams('com_seminar');
  $cid = trim( JRequest::getVar('cid', '' ) );
  $kurs = new mosSeminar( $database );
  $kurs->load( $cid );
  $database->setQuery( "SELECT a.*, cc.*, a.id AS sid, a.name AS aname, a.email AS aemail FROM #__sembookings AS a LEFT JOIN #__users AS cc ON cc.id = a.userid WHERE a.semid = '$kurs->id' ORDER BY a.id");
  $rows = $database->loadObjectList();
  if ($database->getErrorNum()) {
    echo $database->stderr();
    return false;
  }
  $csvdata = "\"#\",\"".JTEXT::_('SEM_0097')."\",\"".JTEXT::_('SEM_0059')."\",\"".JTEXT::_('SEM_0052')."\",\"".JTEXT::_('SEM_0032')."\",\"".JTEXT::_('SEM_0034')."\",\"".JTEXT::_('SEM_0033')."\",\"".JTEXT::_('SEM_0069');
  if( $kurs->fees > 0) {
    $csvdata .= "\",\"".JTEXT::_('SEM_0065');
  }
  if($config->get('sem_p003',0)>0) {
    $csvdata .= "\",\"".JTEXT::_('SEM_0040');
  }
  if($config->get('sem_p004',0)>0) {
    $csvdata .= "\",\"".JTEXT::_('SEM_0055')."\",\"".JTEXT::_('SEM_0042');
  }
  $zusatz1 = sem_f017($kurs);
  foreach($zusatz1[0] AS $el) {
    if($el!="") {
      $el = explode("|",$el);
      $csvdata .= "\",\"".str_replace("\"","'",$el[0]);
    }
  }
  $csvdata .= "\"\r\n";

  $summe = 0;
  $i = 0;
  foreach($rows AS $row) {
    if($row->userid==0) {
      $row->name = $row->aname;
      $row->email = $row->aemail;
    }
    $i++;
    $summe = $summe + $row->nrbooked;
    $temp9 = JTEXT::_('SEM_0030');
    if( $summe > $kurs->maxpupil ) {
      if( $kurs->stopbooking < 1 ) {
        $temp9 = JTEXT::_('SEM_0025');
      } else {
        $temp9 = JTEXT::_('SEM_0029');
      }
    }
    $temp6 = JHTML::_('date',$row->bookingdate,$config->get('sem_p069',JTEXT::_('SEM_0169')),0);
    $temp7 = JHTML::_('date',$row->bookingdate,$config->get('sem_p070',JTEXT::_('SEM_0170')),0);
    $temp8 = $i;
    $csvdata .= "\"".$temp8."\",\"".sem_f002($row->sid)."\",\"".str_replace("\"","'",$row->name)."\",\"".$row->email."\",\"".$temp6."\",\"".$temp7."\",\"".$row->nrbooked."\",\"".$temp9;
    if( $kurs->fees > 0) {
      $temp7 = JTEXT::_('SEM_0006');
      if($row->paid == 1) {
        $temp7 = JTEXT::_('SEM_0005');
      }
      $csvdata .= "\",\"".$temp7;
    }
    if($config->get('sem_p003',0)>0) {
      $temp7 = JTEXT::_('SEM_0006');
      if($row->certificated == 1) {
        $temp7 = JTEXT::_('SEM_0005');
      }
      $csvdata .= "\",\"".$temp7;
    }
    if($config->get('sem_p004',0)>0) {
      $csvdata .= "\",\"".$row->grade."\",\"".str_replace("\"","'",$row->comment);
    }
    $zusatz2 = sem_f017($row);
    for ($l=0,$m=count($zusatz2[0]);$l<$m;$l++) {
      if($zusatz1[0][$l]!="") {
        $csvdata .= "\",\"".str_replace("\"","'",$zusatz2[0][$l]);
      }
    }
    $csvdata .= "\"\r\n";
  }
  $konvert = $config->get('sem_p015',JTEXT::_('SEM_0164'));
  $csvdata = iconv("UTF-8",$konvert,$csvdata);
  header("content-type: application/csv-tab-delimited-table; charset=".$konvert);
  header("content-length: ".strlen($csvdata));
  header("content-disposition: attachment; filename=\"$kurs->title.csv\"");
  header('Pragma: no-cache');
  echo $csvdata;
  exit;
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Email-Koerper ausgeben         +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f049($row,$buchung,$user) {
  $config = &JComponentHelper::getParams('com_seminar');
  $gebucht = sem_f020($row);
  $gebucht = $gebucht->booked;
  $freieplaetze = $row->maxpupil - $gebucht;
  if($freieplaetze < 0) {
    $freieplaetze = 0;
  }
  $body = "<p>\n<table cellpadding=\"2\" border=\"0\" width=\"100%\">";
  $body .= "\n<tr><td><b>".JTEXT::_('SEM_0059')."</b>: </td><td>".$user->name."</td></tr>";
  $body .= "\n<tr><td><b>".JTEXT::_('SEM_0052')."</b>: </td><td>".$user->email."</td></tr>";
  if(count($buchung)>0) {
    $body .= "\n<tr><td><b>".JTEXT::_('SEM_0097')."</b>: </td><td>".sem_f002($buchung->id)."</td></tr>";
    $body .= "\n<tr><td colspan=\"2\"><hr></td></tr>";
    $body .= "\n<tr><td colspan=\"2\"><b>".JTEXT::_('SEM_0026')."</b></td></tr>";
    $zusfeld = sem_f017($row);
    $zusbuch = sem_f017($buchung);
    for($i=0;$i<count($zusfeld[0]);$i++) {
      if($zusfeld[0][$i]!="") {
        $zusart = explode("|",$zusfeld[0][$i]);
        $body .= "\n<tr><td>".$zusart[0].": </td><td>".$zusbuch[0][$i]."</td></tr>";
      }
    }
    if($row->nrbooked>1) {
      $body .= "\n<tr><td>".JTEXT::_('SEM_0033').": </td><td>".$buchung->nrbooked."</td></tr>";
    }
  }
  $body .= "\n<tr><td colspan=\"2\"><hr></td></tr>";
  $body .= "\n<tr><td colspan=\"2\"><b>".$row->title."</b></td></tr>";
  $body .= "\n<tr><td colspan=\"2\">".$row->shortdesc."</td></tr>";
  if($row->semnum!="") {
    $body .= "\n<tr><td>".JTEXT::_('SEM_0003').": </td><td>".$row->semnum."</td></tr>";
  }
  if($row->showbegin>0) {
    $body .= "\n<tr><td>".JTEXT::_('SEM_0009').": </td><td>".JHTML::_('date',$row->begin,$config->get('sem_p067',JTEXT::_('SEM_0167')),0)."</td></tr>";
  }
  if($row->showend>0) {
    $body .= "\n<tr><td>".JTEXT::_('SEM_0010').": </td><td>".JHTML::_('date',$row->end,$config->get('sem_p067',JTEXT::_('SEM_0167')),0)."</td></tr>";
  }
  if($row->showbooked>0) {
    $body .= "\n<tr><td>".JTEXT::_('SEM_0011').": </td><td>".JHTML::_('date',$row->booked,$config->get('sem_p067',JTEXT::_('SEM_0167')),0)."</td></tr>";
  }
  if($row->teacher!="") {
    $body .= "\n<tr><td>".JTEXT::_('SEM_0019').": </td><td>".$row->teacher."</td></tr>";
  }
  if($row->target!="") {
    $body .= "\n<tr><td>".JTEXT::_('SEM_0012').": </td><td>".$row->target."</td></tr>";
  }
  $body .= "\n<tr><td>".JTEXT::_('SEM_0015').": </td><td>".$row->place."</td></tr>";
  if($config->get('sem_p014',0)>0) {
    $body .= "\n<tr><td>".JTEXT::_('SEM_0020').": </td><td>".$row->maxpupil."</td></tr>";
    $body .= "\n<tr><td>".JTEXT::_('SEM_0035').": </td><td>".$gebucht."</td></tr>";
    $body .= "\n<tr><td>".JTEXT::_('SEM_0053').": </td><td>".$freieplaetze."</td></tr>";
  }
  if($row->fees>0) {
    $body .= "\n<tr><td>".JTEXT::_('SEM_0022').": </td><td>".$config->get('sem_p017',JTEXT::_('SEM_0165'))." ".$row->fees;
    if($config->get('sem_p023',0)>0) {
      $body .= " ".JTEXT::_('SEM_0085');
    }
    $body .= "</td></tr>";
  }
   if($row->description!="") {
     $body .= "\n<tr><td colspan=\"2\">".sem_f066($row->description)."</td></tr>";
   }
  $body .= "</table><p>";
  $htxt = str_replace('SEM_HOMEPAGE',"<a href=\"".JURI::root()."\">".JURI::root()."</a>",JTEXT::_('SEM_0074'));
  $body .= $htxt."</body>";
  return $body;
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Bestaetigungs-Emails versenden +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f050($cid,$uid,$art) {
  jimport('joomla.mail.helper');
  $mainframe = JFactory::getApplication();
  $config = &JComponentHelper::getParams('com_seminar');
  if( $config->get('sem_p010',0)>0 OR $config->get('sem_p009',0)>0 ) {  
    $database = &JFactory::getDBO();
    $database->setQuery("SELECT * FROM #__seminar WHERE id='$cid'");
    $rows = $database->loadObjectList();
    $row = &$rows[0];
    $database->setQuery("SELECT * FROM #__sembookings WHERE id='$uid'");
    $rows = $database->loadObjectList();
    if($rows[0]->userid==0) {
      $user->name = $rows[0]->name;
      $user->email = $rows[0]->email;
    } else {
      $user = &JFactory::getuser($rows[0]->userid);
    }
    $publisher = &JFactory::getuser($row->publisher);
    $body1 = "<p><span style=\"font-size:10pt;\">".JTEXT::_('SEM_0076')."</span><p>";
    $body2 = $body1;
    $gebucht = sem_f020($row);
    $gebucht = $gebucht->booked;
    switch( $art ) {
      case 1:
        if($gebucht > $row->maxpupil) {
          if( $row->stopbooking = 0) {
            $body1 .= JTEXT::_('SEM_1030');
          } else {
            $body1 .= JTEXT::_('SEM_0086')." ".JTEXT::_('SEM_0084');
          }
        } else {
          $body1 .= JTEXT::_('SEM_0086');
        }
        $body2 .= JTEXT::_('SEM_0080');
        break;
      case 2:
        $body1 .= JTEXT::_('SEM_1023');
        $body2 .= JTEXT::_('SEM_1025');
        break;
      case 3:
        $body1 .= JTEXT::_('SEM_0072');
        $body2 .= JTEXT::_('SEM_0073');
        break;
      case 4:
        $body1 .= JTEXT::_('SEM_0079');
        $body2 .= JTEXT::_('SEM_0082');
        break;
      case 5:
        $body1 .= JTEXT::_('SEM_2007');
        $body2 .= JTEXT::_('SEM_2008');
        break;
      case 6:
        $body1 .= JTEXT::_('SEM_0071');
        $body2 .= JTEXT::_('SEM_0081');
        if($config->get('sem_p006',0)>0) {
          $body1 .= " ".JTEXT::_('SEM_0078');
        }
        break;
      case 7:
        $body1 .= JTEXT::_('SEM_0075');
        $body2 .= JTEXT::_('SEM_0077');
        break;
      case 8:
        if($gebucht > $row->maxpupil) {
          if( $row->stopbooking = 0) {
            $body1 .= JTEXT::_('SEM_1030');
          } else {
            $body1 .= JTEXT::_('SEM_1002')." ".JTEXT::_('SEM_0084');
          }
        } else {
          $body1 .= JTEXT::_('SEM_1002');
        }
        $body2 .= JTEXT::_('SEM_1026');
        break;
      case 9:
        $body1 .= JTEXT::_('SEM_0100');
        $body2 .= JTEXT::_('SEM_0101');
        break;
      case 10:
        $body1 .= JTEXT::_('SEM_0098');
        $body2 .= JTEXT::_('SEM_0099');
        break;
    }
    $abody = "\n<head>\n<style type=\"text/css\">\n<!--\nbody {\nfont-family: Verdana, Tahoma, Arial;\nfont-size:12pt;\n}\n-->\n</style></head><body>";
    $sender = $mainframe->getCfg('fromname');
    $from = $mainframe->getCfg('mailfrom');
    $htxt = "";
    if($row->semnum!="") {
      $htxt = " ".$row->semnum;
    }
    $subject = JTEXT::_('SEM_0048').$htxt.": ".$row->title;
    $subject = JMailHelper::cleanSubject($subject);
    if($config->get('sem_p010',0)>0 OR $art<11) {
      $replyname = $publisher->name;
      $replyto = $publisher->email;
      $email = $user->email;
      $body = $abody.$body1.sem_f049($row, $rows[0], $user);
      JUtility::sendMail($from, $sender, $email, $subject, $body, 1, null, null, null, $replyto, $replyname);
    }
    if($config->get('sem_p009',0)>0 AND $art<11) {
      $replyname = $user->name;
      $replyto = $user->email;
      $email = $publisher->email;
      $body = $abody.$body2.sem_f049($row, $rows[0], $user);
      JUtility::sendMail($from, $sender, $email, $subject, $body, 1, null, null, null, $replyto, $replyname);
    }
  }
}


// +++++++++++++++++++++++++++++++++++++++++++++++
// +++ Ausdruck des Zertifikats                +++
// +++++++++++++++++++++++++++++++++++++++++++++++

function sem_f051($cid) {
  $database = &JFactory::getDBO();
  $database->setQuery( "SELECT * FROM #__sembookings WHERE id='$cid'" );
  $rows = $database->loadObjectList();
  $booking = &$rows[0];
  $database->setQuery( "SELECT * FROM #__seminar WHERE id='$booking->semid'" );
  $rows = $database->loadObjectList();
  $row = &$rows[0];
  if($booking->userid==0) {
    $user->name = $booking->name;
    $user->email = $booking->email;
  } else {
    $user = &JFactory::getuser($booking->userid);
  }
  $html = "\n<body onload=\" parent.sbox-window.focus(); parent.sbox-window.print(); \">";
  $config = &JComponentHelper::getParams('com_seminar');
  if($config->get('sem_p008','')!="") {
    $html .= $config->get('sem_p008','');
  } else {
    $html .= JTEXT::_('SEM_0056');
  }
  $html .= "</body></html>";
  echo sem_f054($html,$row,$user);
  exit;
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Ausdruck der Benutzerliste     +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f052($art) {
  $database = &JFactory::getDBO();
  $config = &JComponentHelper::getParams('com_seminar');
  $neudatum = sem_f046();
  $cid = trim(JRequest::getVar('cid', '' ));
  $kurs = new mosSeminar( $database );
  $kurs->load($cid);
  $database->setQuery( "SELECT a.*, cc.*, a.id AS sid, a.name AS aname, a.email AS aemail FROM #__sembookings AS a LEFT JOIN #__users AS cc ON cc.id = a.userid WHERE a.semid = '$kurs->id' ORDER BY a.id");
  $rows = $database->loadObjectList();

  $html = "";
  if($art>2) {
    $html .= sem_f031();
    $art -= 2;
  }

  $html .= "\n<body onload=\" parent.sbox-window.focus(); parent.sbox-window.print(); \">";
  $html .= "\n<br /><center><span class=\"sem_list_title\">".JTEXT::_('SEM_0089')."</span></center><br />";
  $gebucht = sem_f020($kurs);
  $gebucht = $gebucht->booked;
  $freieplaetze = $kurs->maxpupil - $gebucht;
  if($freieplaetze < 0) {
    $freieplaetze = 0;
  }
  $html .= "\n".sem_f023(2);
  
// Kursnummer
  if($kurs->semnum!="") {
    $html .= "<tr>".sem_f022(JTEXT::_('SEM_0003').':','d','l','5%','sem_list_blank').sem_f022($kurs->semnum,'d','l','95%','sem_list_blank')."</tr>";
  }

// Titel
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0007').':','d','l','5%','sem_list_blank').sem_f022($kurs->title,'d','l','95%','sem_list_blank')."</tr>";

// Seminarleiter
  if($kurs->teacher!="") {
    $html .= "<tr>".sem_f022(JTEXT::_('SEM_0019').':','d','l','5%','sem_list_blank').sem_f022($kurs->teacher,'d','l','95%','sem_list_blank')."</tr>";
  }

// Beginn
  if($kurs->showbegin>0) {
    $htxt = JHTML::_('date',$kurs->begin,$config->get('sem_p066',JTEXT::_('SEM_0166')),0);
    if($kurs->cancelled>0) {
      $htxt = JTEXT::_('SEM_0103')." (<del>".$htxt."</del>)";
    } 
    $html .= "<tr>".sem_f022(JTEXT::_('SEM_0009').':','d','l','5%','sem_list_blank').sem_f022($htxt,'d','l','95%','sem_list_blank')."</tr>";
  }

// Ende
  if($kurs->showend>0) {
    $htxt = JHTML::_('date',$kurs->end,$config->get('sem_p066',JTEXT::_('SEM_0166')),0);
    if($kurs->cancelled>0) {
      $htxt = JTEXT::_('SEM_0103')." (<del>".$htxt."</del>)";
    }
    $html .= "<tr>".sem_f022(JTEXT::_('SEM_0010').':','d','l','5%','sem_list_blank').sem_f022($htxt,'d','l','95%','sem_list_blank')."</tr>";
  }
  
// Gebuehr  
  if($kurs->fees>0) {
    $htxt = $config->get('sem_p017',JTEXT::_('SEM_0165'))." ".$kurs->fees;
    if($config->get('sem_p023',0)>0) {
      $htxt .= " ".JTEXT::_('SEM_0085');
    }
    $html .= "<tr>".sem_f022(JTEXT::_('SEM_0022').':','d','l','5%','sem_list_blank').sem_f022($htxt,'d','l','95%','sem_list_blank')."</tr>";
  }
  
  $html .= "\n".sem_f023('e');
  if($art==1) {
    $html .= "\n<br />".sem_f023(2,'sem_list');
    $html .= "\n<tr>".sem_f022('#','h','c','10px','sem_list_head').sem_f022(JTEXT::_('SEM_0097'),'h','l','40px','sem_list_head').sem_f022(JTEXT::_('SEM_0059'),'h','l','','sem_list_head').sem_f022(JTEXT::_('SEM_0068'),'h','l','','sem_list_head')."</tr>";
    $i = 1;
    foreach($rows AS $row) {
      if($row->userid==0) {
        $row->name = $row->aname;
        $row->email = $row->aemail;
      }
      $html .= "\n<tr>".sem_f022($i.'.<br />&nbsp;','d','r','10px','sem_list_row').sem_f022(sem_f002($row->sid),'d','l','40px','sem_list_row').sem_f022($row->name,'d','l','','sem_list_row').sem_f022('&nbsp;','d','l','','sem_list_row')."</tr>";
      $i++;
      for ($j=1, $n=$row->nrbooked; $j < $n; $j++) {
        $html .= "\n<tr>".sem_f022($i.'<br />&nbsp;','d','r','10px','sem_list_row').sem_f022(sem_f002($row->sid),'d','l','40px','sem_list_row').sem_f022('&nbsp;','d','l','','sem_list_row').sem_f022('&nbsp;','d','l','','sem_list_row')."</tr>";
        $i++;
      }
    }
    $html .= "\n".sem_f023('e');
  } else {
    $i = 1;
    foreach($rows AS $row) {
      if($row->userid==0) {
        $row->name = $row->aname;
        $row->email = $row->aemail;
      }
      $htxt = JTEXT::_('SEM_0030');
      if( $i >= $kurs->maxpupil ) {
        if( $kurs->stopbooking < 1 ) {
          $htxt = JTEXT::_('SEM_0025');
        } else {
          $htxt = JTEXT::_('SEM_0029');
        }
      }
      if($kurs->cancelled>0) {
        $htxt = JTEXT::_('SEM_0103');
      }
      $html .= "\n<br />".sem_f023(2,'sem_list');
      $html .= "\n<tr>".sem_f022($i.'.','d','r','','sem_list_head').sem_f022(JTEXT::_('SEM_0059').":",'d','l','','sem_list_head').sem_f022($row->name,'d','l','','sem_list_head')."</tr>";
      $html .= "\n<tr>".sem_f022('&nbsp;','d','r','','sem_list_row').sem_f022("<b>".JTEXT::_('SEM_0052').":</b>",'d','l','','sem_list_row').sem_f022($row->email,'d','l','','sem_list_row')."</tr>";
      $html .= "\n<tr>".sem_f022('&nbsp;','d','r','','sem_list_row').sem_f022("<b>".JTEXT::_('SEM_0097').":</b>",'d','l','','sem_list_row').sem_f022(sem_f002($row->sid),'d','l','','sem_list_row')."</tr>";
      $html .= "\n<tr>".sem_f022('&nbsp;','d','r','','sem_list_row').sem_f022("<b>".JTEXT::_('SEM_0032').":</b>",'d','l','','sem_list_row').sem_f022(JHTML::_('date',$row->bookingdate,$config->get('sem_p068',JTEXT::_('SEM_0168')),0),'d','l','','sem_list_row')."</tr>";
      $html .= "\n<tr>".sem_f022('&nbsp;','d','r','','sem_list_row').sem_f022("<b>".JTEXT::_('SEM_0069').":</b>",'d','l','','sem_list_row').sem_f022($htxt,'d','l','','sem_list_row')."</tr>";
      if($kurs->nrbooked>1 AND $config->get('sem_p023','')>0) {
        $html .= "\n<tr>".sem_f022('&nbsp;','d','r','','sem_list_row').sem_f022("<b>".JTEXT::_('SEM_1044').":</b>",'d','l','','sem_list_row').sem_f022($row->nrbooked,'d','l','','sem_list_row')."</tr>";
      }
      if($kurs->fees>0) {
        $htxt = $config->get('sem_p017',JTEXT::_('SEM_0165'))." ".number_format((str_replace(",",".",$kurs->fees)*$row->nrbooked),2,",","");
        if($kurs->nrbooked>1) {
          $htxt .= " (".$config->get('sem_p017',JTEXT::_('SEM_0165'))." ".number_format(str_replace(",",".",$kurs->fees),2,",","")." ".JTEXT::_('SEM_0085').")";
        }
        $html .= "\n<tr>".sem_f022('&nbsp;','d','r','','sem_list_row').sem_f022("<b>".JTEXT::_('SEM_0022').":</b>",'d','l','','sem_list_row').sem_f022($htxt,'d','l','','sem_list_row')."</tr>";
        $htxt = JTEXT::_('SEM_0006');
        if($row->paid == 1) {
          $htxt = JTEXT::_('SEM_0005');
        }
        $html .= "\n<tr>".sem_f022('&nbsp;','d','r','','sem_list_row').sem_f022("<b>".JTEXT::_('SEM_0065').":</b>",'d','l','','sem_list_row').sem_f022($htxt,'d','l','','sem_list_row')."</tr>";
      }
      $zusfeld = sem_f017($kurs);
      $zuserg = sem_f017($row);
      for($z=0;$z<count($zusfeld[0]);$z++) {
        if($zusfeld[0][$z]!="") {
          $zusart = explode("|",$zusfeld[0][$z]);
          $html .= "\n<tr>".sem_f022('&nbsp;','d','r','','sem_list_row').sem_f022("<b>".$zusart[0]."</b>",'d','l','','sem_list_row').sem_f022($zuserg[0][$z],'d','l','','sem_list_row')."</tr>";
        }
      }
      $html .= "\n<tr>".sem_f022(sem_f003($row->sid),'d','c','','sem_list_row',3)."</tr></table>";
      $i++;
    }
  }
  $html .= "<br />".sem_f028();
  $html .= "</body></html>";
  echo $html;
  exit;
}

// ++++++++++++++++++++++++++++++++++++++++
// +++ Code fuer Copyright ueberpruefen +++
// ++++++++++++++++++++++++++++++++++++++++

function sem_f053() {
  $config = JComponentHelper::getParams('com_seminar');
  $showit = TRUE;
  $ccodes = $config->get('sem_p019','');
  if($ccodes!='') {
    $ccodes = explode(" ",$ccodes);
    foreach($ccodes AS $ccode) {
      $htxt = explode("/",JURI::BASE());
      $htx1 = $htxt[2];
      
      $htxt = strtoupper(sha1(md5($htx1)));
      $htxt = substr($htxt,0,4)."-".substr($htxt,4,4)."-".substr($htxt,8,4)."-".substr($htxt,12,4)."-".substr($htxt,16,4)."-".substr($htxt,20,4);
      if($htxt==$ccode) {
        $showit = FALSE;
        break;
      }
      $htx1 = "www.".$htx1;
      $htxt = strtoupper(sha1(md5($htx1)));
      $htxt = substr($htxt,0,4)."-".substr($htxt,4,4)."-".substr($htxt,8,4)."-".substr($htxt,12,4)."-".substr($htxt,16,4)."-".substr($htxt,20,4);
      if($htxt==$ccode) {
        $showit = FALSE;
        break;
      }
    }
  }
  return $showit;
}

// ++++++++++++++++++++++++++++++++++++++++
// +++ Konstanten in Text austauschen   +++
// ++++++++++++++++++++++++++++++++++++++++

function sem_f054($html,$row,$user) {
  $config = &JComponentHelper::getParams('com_seminar');
  $neudatum = sem_f046();

  $html = str_replace('SEM_IMAGEDIR',sem_f006(),$html);

  $html = str_replace('SEM_BEGIN_EXPR',JTEXT::_('SEM_0009'),$html);
  $html = str_replace('SEM_END_EXPR',JTEXT::_('SEM_0010'),$html);
  $html = str_replace('SEM_LOCATION_EXPR',JTEXT::_('SEM_0015'),$html);
  $html = str_replace('SEM_TUTOR_EXPR',JTEXT::_('SEM_0019'),$html);
  $html = str_replace('SEM_DATE_EXPR',JTEXT::_('SEM_0110'),$html);
  $html = str_replace('SEM_TIME_EXPR',JTEXT::_('SEM_0111'),$html);

  $html = str_replace('SEM_COURSE',$row->title,$html);
  $html = str_replace('SEM_TITLE',$row->title,$html);
  $html = str_replace('SEM_COURSENUMBER',$row->semnum,$html);
  $html = str_replace('SEM_NUMBER',$row->semnum,$html);
  $html = str_replace('SEM_ID',$row->id,$html);
  $html = str_replace('SEM_LOCATION',$row->place,$html);
  $html = str_replace('SEM_TEACHER',$row->teacher,$html);
  $html = str_replace('SEM_TUTOR',$row->teacher,$html);

  $html = str_replace('SEM_BEGIN',JHTML::_('date',$row->begin,$config->get('sem_p067',JTEXT::_('SEM_0167')),0),$html);
  $html = str_replace('SEM_BEGIN_OVERVIEW',JHTML::_('date',$row->begin,$config->get('sem_p066',JTEXT::_('SEM_0166')),0),$html);
  $html = str_replace('SEM_BEGIN_DETAIL',JHTML::_('date',$row->begin,$config->get('sem_p067',JTEXT::_('SEM_0167')),0),$html);
  $html = str_replace('SEM_BEGIN_LIST',JHTML::_('date',$row->begin,$config->get('sem_p068',JTEXT::_('SEM_0168')),0),$html);
  $html = str_replace('SEM_BEGIN_DATE',JHTML::_('date',$row->begin,$config->get('sem_p069',JTEXT::_('SEM_0169')),0),$html);
  $html = str_replace('SEM_BEGIN_TIME',JHTML::_('date',$row->begin,$config->get('sem_p070',JTEXT::_('SEM_0170')),0),$html);
  $html = str_replace('SEM_END',JHTML::_('date',$row->end,$config->get('sem_p067',JTEXT::_('SEM_0167')),0),$html);
  $html = str_replace('SEM_END_OVERVIEW',JHTML::_('date',$row->end,$config->get('sem_p066',JTEXT::_('SEM_0166')),0),$html);
  $html = str_replace('SEM_END_DETAIL',JHTML::_('date',$row->end,$config->get('sem_p067',JTEXT::_('SEM_0167')),0),$html);
  $html = str_replace('SEM_END_LIST',JHTML::_('date',$row->end,$config->get('sem_p068',JTEXT::_('SEM_0168')),0),$html);
  $html = str_replace('SEM_END_DATE',JHTML::_('date',$row->end,$config->get('sem_p069',JTEXT::_('SEM_0169')),0),$html);
  $html = str_replace('SEM_END_TIME',JHTML::_('date',$row->end,$config->get('sem_p070',JTEXT::_('SEM_0170')),0),$html);
  $html = str_replace('SEM_TODAY',JHTML::_('date',$neudatum,$config->get('sem_p069',JTEXT::_('SEM_0169')),0),$html);
  $html = str_replace('SEM_NOW',JHTML::_('date',$neudatum,$config->get('sem_p070',JTEXT::_('SEM_0170')),0),$html);
  $html = str_replace('SEM_NOW_OVERVIEW',JHTML::_('date',$neudatum,$config->get('sem_p066',JTEXT::_('SEM_0166')),0),$html);
  $html = str_replace('SEM_NOW_DETAIL',JHTML::_('date',$neudatum,$config->get('sem_p067',JTEXT::_('SEM_0167')),0),$html);
  $html = str_replace('SEM_NOW_LIST',JHTML::_('date',$neudatum,$config->get('sem_p068',JTEXT::_('SEM_0168')),0),$html);
  $html = str_replace('SEM_NOW_DATE',JHTML::_('date',$neudatum,$config->get('sem_p069',JTEXT::_('SEM_0169')),0),$html);
  $html = str_replace('SEM_NOW_TIME',JHTML::_('date',$neudatum,$config->get('sem_p070',JTEXT::_('SEM_0170')),0),$html);

  $html = str_replace('SEM_NAME',$user->name,$html);
  $html = str_replace('SEM_EMAIL',$user->email,$html);

  return $html;
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Tooltip erzeugen               +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f055($text) {
  $html = "";
  if($text!="") {
    $text = explode("|",$text);
    if(count($text)>1) {
      $hinttext = $text[0]."::".$text[1];
    } else {
      $hinttext = JTEXT::_('SEM_0112')."::".$text[0];
    }
    $html = " <span class=\"editlinktip hasTip\" title=\"".$hinttext."\" style=\"text-decoration: none;cursor: help;\"><img src=\"".sem_f006()."0012.png\" border=\"0\" style=\"vertical-align: absmiddle;\"/></span>";
  }
  return $html;
}

// +++++++++++++++++++++++++++++++++++++++++++++++
// +++ Ausdruck der Kurslisten                 +++
// +++++++++++++++++++++++++++++++++++++++++++++++

function sem_f056() {
  $config = &JComponentHelper::getParams('com_seminar');
  $args = func_get_args();
  $rows = $args[0];
  $status = $args[1];
  $html = "";
  if(count($args)>2) {
    $headertext = $args[2];
  } else {
    $headertext = JTEXT::_('SEM_0083');
    $html .= sem_f031();
  }
  $neudatum = sem_f046();
  $html .= "\n<body onload=\" parent.sbox-window.focus(); parent.sbox-window.print(); \">";
  $html .= "\n<br /><center><span class=\"sem_list_title\">".$headertext."</span><br /><span class=\"sem_list_date\">".JHTML::_('date',$neudatum,$config->get('sem_p068',JTEXT::_('SEM_0168')),0)."</span></center><br />";
  $k = 0;
  for ($i=0, $n=count($rows); $i < $n; $i++) {
    $row = $rows[$i];
    $gebucht = sem_f020($row);
    $gebucht = $gebucht->booked;
    $freieplaetze = $row->maxpupil - $gebucht;
    if($freieplaetze < 0) {
      $freieplaetze = 0;
    }
    $html .= sem_f023(4,"sem_list");
    $html .= "<tr>".sem_f022($row->title,'d','c','100%','sem_list_head',2)."</tr>";
    $html .= "<tr>".sem_f022($row->shortdesc,'d','l','100%','sem_list_row',2)."</tr>";
    if($row->semnum!="") {
      $html .= "<tr>".sem_f022(JTEXT::_('SEM_0003').":",'d','l','','sem_list_row').sem_f022($row->semnum,'d','l','90%','sem_list_row')."</tr>";
    }
    $htxt = $status[$i];
    if($row->nrbooked<1) {
      $htxt = JTEXT::_('SEM_0133');
    }
    $html .= "<tr>".sem_f022(JTEXT::_('SEM_0069').":",'d','l','','sem_list_row').sem_f022($htxt,'d','l','','sem_list_row')."</tr>";
    if($row->codepic!="") {
      $html .= "<tr>".sem_f022(JTEXT::_('SEM_0097').":",'d','l','','sem_list_row').sem_f022(sem_f002($row->codepic),'d','l','','sem_list_row')."</tr>";
    }
    if($row->showbegin>0) {
      $html .= "<tr>".sem_f022(JTEXT::_('SEM_0009').":",'d','l','','sem_list_row').sem_f022(JHTML::_('date',$row->begin,$config->get('sem_p068',JTEXT::_('SEM_0168')),0),'d','l','','sem_list_row')."</tr>";
    }
    if($row->showend>0) {
      $html .= "<tr>".sem_f022(JTEXT::_('SEM_0010').":",'d','l','','sem_list_row').sem_f022(JHTML::_('date',$row->end,$config->get('sem_p068',JTEXT::_('SEM_0168')),0),'d','l','','sem_list_row')."</tr>";
    }
    if($row->showbooked>0) {
      $html .= "<tr>".sem_f022(JTEXT::_('SEM_0011').":",'d','l','','sem_list_row').sem_f022(JHTML::_('date',$row->booked,$config->get('sem_p068',JTEXT::_('SEM_0168')),0),'d','l','','sem_list_row')."</tr>";
    }
    if($row->teacher!="") {
      $html .= "<tr>".sem_f022(JTEXT::_('SEM_0019').":",'d','l','','sem_list_row').sem_f022($row->teacher,'d','l','','sem_list_row')."</tr>";
    }
    if($row->target!="") {
      $html .= "<tr>".sem_f022(JTEXT::_('SEM_0012').":",'d','l','','sem_list_row').sem_f022($row->target,'d','l','','sem_list_row')."</tr>";
    }
    $html .= "<tr>".sem_f022(JTEXT::_('SEM_0015').":",'d','l','','sem_list_row').sem_f022($row->place,'d','l','','sem_list_row')."</tr>";
    if($row->nrbooked>0) {
      $html .= "<tr>".sem_f022(JTEXT::_('SEM_0020').":",'d','l','','sem_list_row').sem_f022($row->maxpupil,'d','l','','sem_list_row')."</tr>";
      $html .= "<tr>".sem_f022(JTEXT::_('SEM_0035').":",'d','l','','sem_list_row').sem_f022($gebucht,'d','l','','sem_list_row')."</tr>";
      $html .= "<tr>".sem_f022(JTEXT::_('SEM_0053').":",'d','l','','sem_list_row').sem_f022($freieplaetze,'d','l','','sem_list_row')."</tr>";
    }
    if($row->fees>0) {
      $html .= "<tr>".sem_f022(JTEXT::_('SEM_0022').":",'d','l','','sem_list_row').sem_f022($config->get('sem_p017',JTEXT::_('SEM_0165'))." ".$row->fees,'d','l','','sem_list_row')."</tr>";
    }
    if($row->description!="") {
      if(count($args)==2) {
        $row->description = str_replace("images/","../images/",$row->description);
      }
      $html .= "<tr>".sem_f022(sem_f066($row->description),'d','l','100%','sem_list_row',2)."</tr>";
    }
    if($row->codepic!="") {
      $html .= "<tr>".sem_f022(sem_f003($row->codepic),'d','c','100%','sem_list_row',2)."</tr>";
    }
    $html .= "\n".sem_f023('e')."<br />";
  }
  $html .= sem_f028();
  $html .= "</body></html>";
  echo $html;
  exit;
}

// +++++++++++++++++++++++++++++++++++++++++++++++
// +++ Templateliste erstellen                 +++
// +++++++++++++++++++++++++++++++++++++++++++++++

function sem_f057($vorlage,$art) {
  $html = "";
  $database = JFactory::getDBO();
  $config = JComponentHelper::getParams('com_seminar');
  $my = JFactory::getuser();
  $where = array();

// Nur veroeffentlichte Kurse anzeigen
  $where[] = "published = '1'";
  $where[] = "pattern != ''";
  $where[] = "publisher = '".$my->id."'";

// nur Kurse anzeigen, deren Kategorie fuer den Benutzer erlaubt ist
  $reglevel = sem_f042();
  $accesslvl = 1;
  if($reglevel>=6) {
    $accesslvl=3;
  } else if ($reglevel>=2) {
    $accesslvl=2;
  }
  $database->setQuery("SELECT id, access FROM #__categories WHERE section='".JRequest::getCmd('option')."'");
  $cats = $database->loadObjectList();
  $allowedcat = array();
  $allowedcat[] = 0;
  foreach($cats AS $cat) {
    if($cat->access<$accesslvl) {
      $allowedcat[] = $cat->id;
    }
  }
  if(count($allowedcat)>0) {
    $allowedcat = implode(',',$allowedcat);
    $where[] = "catid IN ($allowedcat)";
  }
  $database->setQuery("SELECT * FROM #__seminar"
    . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
    . "\nORDER BY pattern"
  );
  $rows = $database->loadObjectList();
  $patterns = array();
  $patterns[] = JHTML::_('select.option','',JTEXT::_('SEM_0126'));
  foreach($rows AS $row) {
    $patterns[] = JHTML::_('select.option',$row->id,$row->pattern);
  }
  $htxt = JTEXT::_('SEM_0122').": ";
  $disabled = "";
  if($vorlage==0) {
    $disabled = " disabled";
  }
  if($art==1) {
    if(count($patterns)>1) {
      $htxt .= JHTML::_('select.genericlist', $patterns, 'vorlage','class="sem_inputbox" size="1" onChange="form.cid.value=form.vorlage.value;form.task.value=9;form.submit();"', 'value', 'text', $vorlage);
      $htxt .= " <button class=\"button\" id=\"tmpldel\" style=\"cursor:pointer;\" type=\"button\" onclick=\"form.cid.value=form.vorlage.value;form.task.value=11;form.submit();\"".$disabled."><img src=\"".sem_f006()."1516.png\" border=\"0\" align=\"absmiddle\">&nbsp;".JTEXT::_('SEM_0124')."</button>";
    } else {
      $htxt .= "<input type=\"hidden\" name=\"vorlage\" value=\"0\">";
    }
    $htxt .= " <input type=\"text\" name=\"pattern\" id=\"pattern\" class=\"sem_inputbox\" value=\"\" onKeyup=\"if(this.value=='') {form.tmplsave.disabled=true;} else {form.tmplsave.disabled=false;}\">";
    $htxt .= " <button class=\"button\" id=\"tmplsave\" style=\"cursor:pointer;\" type=\"button\" onclick=\"form.task.value=10;form.submit();\" disabled><img src=\"".sem_f006()."1416.png\" border=\"0\" align=\"absmiddle\">&nbsp;".JTEXT::_('SEM_0125')."</button>";
    $html = "<tr>".sem_f022($htxt,'d','c','80%','sem_nav',2)."</tr>";
  } else if ($art==2) {
    if(count($patterns)>1) {
      $htxt .= JHTML::_('select.genericlist', $patterns, 'vorlage','class="sem_inputbox" size="1" onChange="form.id.value=form.vorlage.value;form.task.value=\'12\';form.submit();"', 'value', 'text', $vorlage);
      $html = "<tr>".sem_f022($htxt,'d','c','80%','sem_nav',2)."</tr>";
    }
  }
  return $html;
}


// ++++++++++++++++++++++++++++++++++++++
// +++ Benutzer anmelden              +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f058() {
  $mainframe = JFactory::getApplication();
  $username = JRequest::getVar('semusername',JTEXT::_('USERNAME'));
  $password = JRequest::getVar('sempassword',JTEXT::_('PASSWORD'));
  if($username!=JTEXT::_('USERNAME')) {
    $data['username'] = $username;
    $data['password'] = $password;
    $option['remember'] = true;
    $option['silent'] = true;
    $mainframe->login($data, $option);
  }
}

// ++++++++++++++++++++++++++++++++++++++
// +++ ICS-Datei senden               +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f059() {
  $database = &JFactory::getDBO();
  $config = &JComponentHelper::getParams('com_seminar');
  $cid = trim( JRequest::getVar('cid',0));
  $kurs = new mosSeminar($database);
  $kurs->load($cid);
  $user = &JFactory::getuser($kurs->publisher);
  $icsdata = "BEGIN:VCALENDAR\n";
  $icsdata .= "VERSION:2.0\n";
  $icsdata .= "PRODID:".sem_f004()."\n";
  $icsdata .= "METHOD:PUBLISH\n";
  $icsdata .= "BEGIN:VEVENT\n";
  $icsdata .= "UID:".sem_f002($kurs->id)."\n";
  $icsdata .= "ORGANIZER;CN=\"".$user->name."\":MAILTO:".$user->email."\n";
  $icsdata .= "SUMMARY:".$kurs->title."\n";
  $icsdata .= "LOCATION:".ereg_replace("(\r\n|\n|\r)",", ",$kurs->place)."\n";
  $icsdata .= "DESCRIPTION:".ereg_replace("(\r\n|\n|\r)"," ",$kurs->shortdesc)."\n";
  $icsdata .= "CLASS:PUBLIC\n";
  $icsdata .= "DTSTART:".strftime("%Y%m%dT%H%M%S",strtotime($kurs->begin))."\n";
  $icsdata .= "DTEND:".strftime("%Y%m%dT%H%M%S",strtotime($kurs->end))."\n";
  $icsdata .= "DTSTAMP:".strftime("%Y%m%dT%H%M%S",strtotime(sem_f046()))."\n";
  $icsdata .= "BEGIN:VALARM\n";
  $icsdata .= "TRIGGER:-PT1440M\n";
  $icsdata .= "ACTION:DISPLAY\n";
  $icsdata .= "DESCRIPTION:Reminder\n";
  $icsdata .= "END:VALARM\n";
  $icsdata .= "END:VEVENT\n";
  $icsdata .= "END:VCALENDAR";
  header("Content-Type: text/calendar; charset=utf-8");
  header("Content-Length: ".strlen($icsdata));
  header("Content-Disposition: attachment; filename=\"$kurs->title.ics\"");
  header('Pragma: no-cache');
  echo $icsdata;
  exit;
}

// ++++++++++++++++++++++++++++++++++
// +++ Aray mit Dateien erzeugen
// ++++++++++++++++++++++++++++++++++

function sem_f060($row) {
  $zusfeld = array();
  $zusfeld[] = array($row->file1,$row->file2,$row->file3,$row->file4,$row->file5);
  $zusfeld[] = array($row->file1desc,$row->file2desc,$row->file3desc,$row->file4desc,$row->file5desc);
  $zusfeld[] = array($row->file1down,$row->file2down,$row->file3down,$row->file4down,$row->file5down);
  return $zusfeld; 
}
  
// ++++++++++++++++++++++++++++++++++++++
// +++ Datei senden                   +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f061() {
  $database = &JFactory::getDBO();
  $my = &JFactory::getuser();
  $config = &JComponentHelper::getParams('com_seminar');
  $daten = trim( JRequest::getVar('a6d5dgdee4cu7eho8e7fc6ed4e76z',''));
  $cid = substr($daten,40);
  $dat = substr($daten,0,40);
  $kurs = new mosSeminar($database);
  $kurs->load($cid);
  $datfeld = sem_f060($kurs);
  for($i=0;$i<count($datfeld[0]);$i++) {
    if(sha1(md5($datfeld[0][$i]))==$dat AND ($datfeld[2][$i]==0 OR ($my->id>0 AND $datfeld[2][$i]>0))) {
      $datname = $datfeld[0][$i];
      $datcode = "file".($i+1)."code";
      $daten = base64_decode($kurs->$datcode);
      $datext = array_pop(explode(".",strtolower($datname)));
      header("Content-Type: application/$datext");
      header("Content-Length: ".strlen($daten));
      header("Content-Disposition: attachment; filename=\"$datname\"");
      header('Pragma: no-cache');
      echo $daten;
      exit;
    }
  }
  JError::raiseError( 403, JText::_("ALERTNOTAUTH") );

}

// ++++++++++++++++++++++++++++++++++++++
// +++ Spendenzeile ausgeben          +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f062() {
  $html = "<br /><center><table><tr><td align=\"right\"><form name=\"donate\" action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" target=\"_new\">";
  $html .= "<input type=\"hidden\" name=\"cmd\" value=\"_s-xclick\">";
  $html .= "<a href=\"javascript:document.donate.submit();\"><img src=\"".sem_f006()."donate.png\" style=\"border: 0px;\" alt=\"Spenden Sie mit PayPal\"></a>";
  $html .= "<input type=\"hidden\" name=\"encrypted\" value=\"-----BEGIN PKCS7-----MIIHRwYJKoZIhvcNAQcEoIIHODCCBzQCAQExggEwMIIBLAIBADCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwDQYJKoZIhvcNAQEBBQAEgYAsvaV5ZLJjH6ryBj4wU6qrptBRl1ev16uJ5PaTMGErvfD4bu0o0eyQbTiRySlv6gDM5kOtk5QOXkdviOcm32HSrQRJRY7f/4IFAt52m14YNPMAlAs2GZXA6r6XbGheZS0v5vnhDFVTdSQisT2zTBTppPc//gXUDWYv/sY3TOMhpjELMAkGBSsOAwIaBQAwgcQGCSqGSIb3DQEHATAUBggqhkiG9w0DBwQIeEnRizRHIJuAgaC9X83Jw776V3k73IYz4JjC077gMFThZ8En4REfejzNa+g8IyOXZIS+MP++S1TKs2DzxW0xMfDcZgAx6Mh/XSIkHsiNF6Z0L1gq5sNtmzV28Vs4e11c8YxcZ7ohZlklc/13+p3AEwfJNIy6VErDdjqHHDpFpTUKh3OpIa41+9W0y/HLaVk1G+z2rn3pBtBKTgAmTPu18myR1id3syppGFmzoIIDhzCCA4MwggLsoAMCAQICAQAwDQYJKoZIhvcNAQEFBQAwgY4xCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDQTEWMBQGA1UEBxMNTW91bnRhaW4gVmlldzEUMBIGA1UEChMLUGF5UGFsIEluYy4xEzARBgNVBAsUCmxpdmVfY2VydHMxETAPBgNVBAMUCGxpdmVfYXBpMRwwGgYJKoZIhvcNAQkBFg1yZUBwYXlwYWwuY29tMB4XDTA0MDIxMzEwMTMxNVoXDTM1MDIxMzEwMTMxNVowgY4xCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDQTEWMBQGA1UEBxMNTW91bnRhaW4gVmlldzEUMBIGA1UEChMLUGF5UGFsIEluYy4xEzARBgNVBAsUCmxpdmVfY2VydHMxETAPBgNVBAMUCGxpdmVfYXBpMRwwGgYJKoZIhvcNAQkBFg1yZUBwYXlwYWwuY29tMIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDBR07d/ETMS1ycjtkpkvjXZe9k+6CieLuLsPumsJ7QC1odNz3sJiCbs2wC0nLE0uLGaEtXynIgRqIddYCHx88pb5HTXv4SZeuv0Rqq4+axW9PLAAATU8w04qqjaSXgbGLP3NmohqM6bV9kZZwZLR/klDaQGo1u9uDb9lr4Yn+rBQIDAQABo4HuMIHrMB0GA1UdDgQWBBSWn3y7xm8XvVk/UtcKG+wQ1mSUazCBuwYDVR0jBIGzMIGwgBSWn3y7xm8XvVk/UtcKG+wQ1mSUa6GBlKSBkTCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb22CAQAwDAYDVR0TBAUwAwEB/zANBgkqhkiG9w0BAQUFAAOBgQCBXzpWmoBa5e9fo6ujionW1hUhPkOBakTr3YCDjbYfvJEiv/2P+IobhOGJr85+XHhN0v4gUkEDI8r2/rNk1m0GA8HKddvTjyGw/XqXa+LSTlDYkqI8OwR8GEYj4efEtcRpRYBxV8KxAW93YDWzFGvruKnnLbDAF6VR5w/cCMn5hzGCAZowggGWAgEBMIGUMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbQIBADAJBgUrDgMCGgUAoF0wGAYJKoZIhvcNAQkDMQsGCSqGSIb3DQEHATAcBgkqhkiG9w0BCQUxDxcNMDgwMjAzMTMxNjMzWjAjBgkqhkiG9w0BCQQxFgQUB2jKnq13gHr3VLu+Iuc9I8POdoswDQYJKoZIhvcNAQEBBQAEgYCNMwHvr6sic7YnBONpzPy7hTmBytoAfzP95woZ5R3jrb9uJ57nyZiB/xOqW62wdwzlSuUZGA39njVHTxTKHHXKh3kIsRWQVo/2ntykkfFgStpA5PUWTKkTo//w4iqpZ0T+Ed1j4o6exw9Yk0vSlqtUIc9H8klUruchfq1yx5zs5A==-----END PKCS7-----\">";
  $html .= "<img alt=\"\" border=\"0\" src=\"https://www.paypal.com/de_DE/i/scr/pixel.gif\" width=\"1\" height=\"1\"></form></td>";
  $html .= "<td>".JTEXT::_('SEM_2002')."</td></tr></table></center>";
  return $html;
}


// ++++++++++++++++++++++++++++++++++++++
// +++ Plugins in Texten aktivieren   +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f063($text) {
  $row = new JObject();
  $parameter = new JParameter('');
  JPluginHelper::importPlugin('content');
  $dispatcher = &JDispatcher::getInstance();
  $row->text = $text;
  $results = $dispatcher->trigger('onPrepareContent',array(&$row,&$parameter,0));
  return $row->text;
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Neue Seminarnummer erzeugen    +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f064($newyear) {
  $database = &JFactory::getDBO();
  $database->setQuery( "SELECT * FROM #__semnumber WHERE year = '$newyear'" );
  $temp = $database->loadObjectList();
  if( count($temp) == 0 ) {
    $neu = new mossemnumber( $database );
    if (!$neu->bind( $_POST )) {
      JError::raiseError( 500, $row->getError() );
      exit();
    }
    $neu->year = $newyear;
    $neu->number = "1";
    if (!$neu->store()) {
      JError::raiseError( 500, $row->getError() );
      exit();
    }
    $neu->checkin();
  } else {
    $database->setQuery( "UPDATE #__semnumber SET number = number+1 WHERE year = '$newyear'" );
    if (!$database->query()) {
      JError::raiseError( 500, $row->getError() );
      exit();
    }
  }
  $database->setQuery( "SELECT * FROM #__semnumber WHERE year = '$newyear'" );
  $zaehlers = $database->loadObjectList();
  $zaehler = &$zaehlers[0];
  return $zaehler->number . "/" . substr( $newyear, 2 );
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Ausgabe parsen                 +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f065($text,$status) {
  preg_match_all("`\[".$status."\](.*)\[/".$status."\]`U",$text,$ausgabe);
  for($i=0;$i<count($ausgabe[0]);$i++) {
    $text = str_replace($ausgabe[0][$i],$ausgabe[1][$i],$text);
  }
  preg_match_all("`\[sem_[^\]]+\](.*)\[/sem_[^\]]+\]`U",$text,$ausgabe);
  for($i=0;$i<count($ausgabe[0]);$i++) {
    $text = str_replace($ausgabe[0][$i],"",$text);
  }
  return $text;
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Ausgabe saeubern                +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f066($text) {
  preg_match_all("`\[sem_[^\]]+\](.*)\[/sem_[^\]]+\]`U",$text,$ausgabe);
  for($i=0;$i<count($ausgabe[0]);$i++) {
    $text = str_replace($ausgabe[0][$i],"",$text);
  }
  preg_match_all("`\{[^\}]+\}`U",$text,$ausgabe);
  for($i=0;$i<count($ausgabe[0]);$i++) {
    $text = str_replace($ausgabe[0][$i],"",$text);
  }
  return $text;
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Eingabe prüfen                 +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f067($text,$art='leer') {
  $htxt = false;
  switch($art) {
// texteingabe prüfen - alle eingaben auf leere eingaben prüfen
    case 'leer':
      $text=trim($text);
      if ($text!='') {
        $htxt = true;
      }
      break;
// auf nur zahlen prüfen
    case 'nummer':
      if (preg_match("#^[0-9]+$#",$text)) {
        $htxt = true;
      }
      break;
// auf telefonnummer prüfen mit min. 6 zahlen
    case 'telefon':
      if (preg_match("#^[ 0-9\/-+]{6,}+$#",$text)) {
        $htxt = true;
      }
      break;
// auf nur buchstaben prüfen
    case 'buchstabe':
      if (preg_match("/^[ a-za-zäöüß]+$/i",$text)) {
        $htxt = true;
      }
      break;
// auf nur ein wort prüfen
    case 'wort':
      if (preg_match("/^[a-za-zäöüß]+$/i",$text)) {
        $htxt = true;
      }
      break;
// url prüfen
    case 'url':
      $text=trim($text);
      if (preg_match("#^(http|https)+(://www.)+([a-z0-9-_.]{2,}\.[a-z]{2,4})$#i",$text)) {
        $htxt = true;
      }
      break;
// email-adresse prüfen
    case 'email':
      $text=trim($text);
      if ($text!='') {
        $_pat="^[_a-za-z0-9-]+(.[_a-za-z0-9-]+)*@([a-z0-9-]{3,})+.([a-za-z]{2,4})$";
        if (!preg_match("|$_pat|i",$text)) {
          $htxt = false;
        }
      } else {
        $htxt = false;
      }
      break;
// Zahl der Laenge art pruefen
    default:
      if (preg_match("/^[0-9]{$art}$/",$cvalue)) {
        $htxt = true;
      }
      break;
  }
  return $htxt;
}


// ++++++++++++++++++++++++++++++++++++++
// +++ DB fuer Buchungen              +++
// ++++++++++++++++++++++++++++++++++++++

class mosSembookings extends JTable {
  var $id=null;
  var $name=null;
  var $email=0;
  var $sid=null;
  var $semid=null;
  var $userid=null;
  var $bookingdate=null;
  var $updated=null;
  var $certificated=null;
  var $grade=null;
  var $comment=null;
  var $paid=null;
  var $nrbooked=null;
  var $zusatz1=null;
  var $zusatz2=null;
  var $zusatz3=null;
  var $zusatz4=null;
  var $zusatz5=null;
  var $zusatz6=null;
  var $zusatz7=null;
  var $zusatz8=null;
  var $zusatz9=null;
  var $zusatz10=null;
  var $zusatz11=null;
  var $zusatz12=null;
  var $zusatz13=null;
  var $zusatz14=null;
  var $zusatz15=null;
  var $zusatz16=null;
  var $zusatz17=null;
  var $zusatz18=null;
  var $zusatz19=null;
  var $zusatz20=null;
  function mosSembookings( &$db ) {
    parent::__construct( '#__sembookings', 'id', $db );
  }
}

// ++++++++++++++++++++++++++++++++++++++
// +++ DB fuer Veranstaltungen        +++
// ++++++++++++++++++++++++++++++++++++++

class mosSeminar extends JTable {
  var $id=null;
  var $sid=0;
  var $catid=1;
  var $semnum="";
  var $title="";
  var $target="";
  var $shortdesc="";
  var $description="";
  var $place="";
  var $teacher="";
  var $fees=0;
  var $maxpupil=12;
  var $bookedpupil=0;
  var $stopbooking=0;
  var $cancelled=0;
  var $begin="0000-00-00 00:00:00";
  var $end="0000-00-00 00:00:00";
  var $booked="0000-00-00 00:00:00";
  var $showbegin=1;
  var $showend=1;
  var $showbooked=1;
  var $checked_out=0;
  var $checked_out_time="0000-00-00 00:00:00";
  var $ordering=0;
  var $published=0;
  var $publishdate="0000-00-00 00:00:00";
  var $updated=null;
  var $publisher="";
  var $access=0;
  var $hits=0;
  var $grade=0;
  var $certificated=0;
  var $paid=0;
  var $gmaploc="";
  var $nrbooked=1;
  var $pattern="";
  var $zusatz1="";
  var $zusatz2="";
  var $zusatz3="";
  var $zusatz4="";
  var $zusatz5="";
  var $zusatz6="";
  var $zusatz7="";
  var $zusatz8="";
  var $zusatz9="";
  var $zusatz10="";
  var $zusatz11="";
  var $zusatz12="";
  var $zusatz13="";
  var $zusatz14="";
  var $zusatz15="";
  var $zusatz16="";
  var $zusatz17="";
  var $zusatz18="";
  var $zusatz19="";
  var $zusatz20="";
  var $zusatz1hint="";
  var $zusatz2hint="";
  var $zusatz3hint="";
  var $zusatz4hint="";
  var $zusatz5hint="";
  var $zusatz6hint="";
  var $zusatz7hint="";
  var $zusatz8hint="";
  var $zusatz9hint="";
  var $zusatz10hint="";
  var $zusatz11hint="";
  var $zusatz12hint="";
  var $zusatz13hint="";
  var $zusatz14hint="";
  var $zusatz15hint="";
  var $zusatz16hint="";
  var $zusatz17hint="";
  var $zusatz18hint="";
  var $zusatz19hint="";
  var $zusatz20hint="";
  var $zusatz1show=0;
  var $zusatz2show=0;
  var $zusatz3show=0;
  var $zusatz4show=0;
  var $zusatz5show=0;
  var $zusatz6show=0;
  var $zusatz7show=0;
  var $zusatz8show=0;
  var $zusatz9show=0;
  var $zusatz10show=0;
  var $zusatz11show=0;
  var $zusatz12show=0;
  var $zusatz13show=0;
  var $zusatz14show=0;
  var $zusatz15show=0;
  var $zusatz16show=0;
  var $zusatz17show=0;
  var $zusatz18show=0;
  var $zusatz19show=0;
  var $zusatz20show=0;
  var $image="";
  var $file1="";
  var $file2="";
  var $file3="";
  var $file4="";
  var $file5="";
  var $file1desc="";
  var $file2desc="";
  var $file3desc="";
  var $file4desc="";
  var $file5desc="";
  var $file1down=0;
  var $file2down=0;
  var $file3down=0;
  var $file4down=0;
  var $file5down=0;
  var $file1code="";
  var $file2code="";
  var $file3code="";
  var $file4code="";
  var $file5code="";
  function mosSeminar( &$db ) {
    parent::__construct( '#__seminar', 'id', $db );
  }
}

// ++++++++++++++++++++++++++++++++++++++
// +++ DB fuer Seminarzaehler         +++
// ++++++++++++++++++++++++++++++++++++++

class mosSemnumber extends JTable {
  var $id=null;
  var $number=null;
  var $year=null;
  function mosSemnumber( &$db ) {
    parent::__construct( '#__semnumber', 'id', $db );
  }
}


?>
