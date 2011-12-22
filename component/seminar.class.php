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

// ++++++++++++++++++++++++++++++++++++++
// +++ Versionsnummer ausgeben        +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f001() {
  return "1.3.91";
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
    return "<img src=\"http://chart.apis.google.com/chart?cht=qr&amp;chs=100x100&amp;choe=UTF-8&amp;chld=H|4&amp;chl=".urlencode(sem_f002($id))."\" /><br /><code><b>".sem_f002($id)."</b></code>";
  } else if($temp==2) {
    return "<img src=\"".sem_f005()."seminar.code.php?code=".sem_f002($id)."\" />";
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
    $html .= "<tr>".sem_f022(JTEXT::_('SEM_2024').':','d','r','20%','sem_edit').sem_f022(sem_f009($row->publisher,1).$reqfield,'d','l','80%','sem_edit')."</tr>";
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
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0003').$reqfield.':'.sem_f055(JTEXT::_('SEM_0116')),'d','r','20%','sem_edit');
  $html .= sem_f022("<input class=\"sem_inputbox\" type=\"text\" name=\"semnum\" size=\"10\" maxlength=\"100\" value=\"".$row->semnum."\" />",'d','l','80%','sem_edit')."</tr>";

// Abgesagt
  $htxt ="<input type=\"radio\" name=\"cancel\" id=\"cancel\" value=\"1\" class=\"sem_inputbox\"".$htx4." /><label for=\"cancel\">".JTEXT::_('SEM_0005')."</label> <input type=\"radio\" name=\"cancel\" id=\"cancel\" value=\"0\" class=\"sem_inputbox\"".$htx5."/><label for=\"cancel\">".JTEXT::_('SEM_0006')."</label>";
  $html .= "\n<tr>".sem_f022(JTEXT::_('SEM_0095').$reqfield.':'.sem_f055(JTEXT::_('SEM_0161')),'d','r','20%','sem_edit').sem_f022($htxt,'d','l','80%','sem_edit')."<input type=\"hidden\" name=\"cancelled\" value=\"".$row->cancelled."\"></tr>";

// Titel
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0007').$reqfield.':','d','r','20%','sem_edit').sem_f022("<input class=\"sem_inputbox\" type=\"text\" name=\"title\" size=\"50\" maxlength=\"250\" value=\"".$row->title."\" />",'d','l','80%','sem_edit')."</tr>";

// Kategorie
  $htxt = $catlist[0];
  if($config->get('sem_p032','')==1) {
    foreach($catlist[1] as $el) {
      $htxt .= "<input type=\"hidden\" id=\"im".$el->id."\" value=\"".$el->image."\">";
    }
  }
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0008').$reqfield.':'.sem_f055(JTEXT::_('SEM_0160')),'d','r','20%','sem_edit').sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";

  $radios = array();      
  $radios[] = JHTML::_('select.option',1,JTEXT::_('SEM_0005'));
  $radios[] = JHTML::_('select.option',0,JTEXT::_('SEM_0006'));

// Veranstaltungsbeginn
  $htxt = JHTML::_('calendar',$row->begin_date,'_begin_date','_begin_date','%Y-%m-%d',array('class'=>'inputbox','size'=>'12','maxlength'=>'10'));
  $htxt .= JHTML::_('select.integerlist', 0, 23, 1, '_begin_hour','class="sem_inputbox" size="1"', $row->begin_hour, "%02d" );
  $htxt .= JHTML::_('select.integerlist', 0, 55, 5, '_begin_minute','class="sem_inputbox" size="1"', $row->begin_minute, "%02d" );
  $htxt .= " - ".JTEXT::_('SEM_0121')." ".JHTML::_('select.radiolist',$radios,'showbegin','class="sem_inputbox"','value','text',$row->showbegin);
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0009').$reqfield.':'.sem_f055(JTEXT::_('SEM_0145')),'d','r','20%','sem_edit').sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";

// Veranstaltungsende
  $htxt = JHTML::_('calendar',$row->end_date,'_end_date','_end_date','%Y-%m-%d',array('class'=>'inputbox','size'=>'12','maxlength'=>'10'));
  $htxt .= JHTML::_('select.integerlist', 0, 23, 1, '_end_hour','class="sem_inputbox" size="1"', $row->end_hour, "%02d" );
  $htxt .= JHTML::_('select.integerlist', 0, 55, 5, '_end_minute','class="sem_inputbox" size="1"', $row->end_minute, "%02d" );
  $htxt .= " - ".JTEXT::_('SEM_0121')." ".JHTML::_('select.radiolist',$radios,'showend','class="sem_inputbox"','value','text',$row->showend);
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0010').$reqfield.':'.sem_f055(JTEXT::_('SEM_0145')),'d','r','20%','sem_edit').sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";

// Anmeldeschluss
  $htxt = JHTML::_('calendar',$row->booked_date,'_booked_date','_booked_date','%Y-%m-%d',array('class'=>'inputbox','size'=>'12','maxlength'=>'10'));
  $htxt .= JHTML::_('select.integerlist', 0, 23, 1, '_booked_hour','class="sem_inputbox" size="1"', $row->booked_hour, "%02d" );
  $htxt .= JHTML::_('select.integerlist', 0, 55, 5, '_booked_minute','class="sem_inputbox" size="1"', $row->booked_minute, "%02d" );
  $htxt .= " - ".JTEXT::_('SEM_0121')." ".JHTML::_('select.radiolist',$radios,'showbooked','class="sem_inputbox"','value','text',$row->showbooked);
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0011').$reqfield.':'.sem_f055(JTEXT::_('SEM_0145')),'d','r','20%','sem_edit').sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";

  if($config->get('sem_p064',2)==3) {
// Veröffentlichungsbeginn
    $htxt = JHTML::_('calendar',$row->pubbegin_date,'_pubbegin_date','_pubbegin_date','%Y-%m-%d',array('class'=>'inputbox','size'=>'12','maxlength'=>'10'));
    $htxt .= JHTML::_('select.integerlist', 0, 23, 1, '_pubbegin_hour','class="sem_inputbox" size="1"', $row->pubbegin_hour, "%02d" );
    $htxt .= JHTML::_('select.integerlist', 0, 55, 5, '_pubbegin_minute','class="sem_inputbox" size="1"', $row->pubbegin_minute, "%02d" );
    $html .= "<tr>".sem_f022(JTEXT::_('SEM_0193').$reqfield.':'.sem_f055(JTEXT::_('SEM_0145')),'d','r','20%','sem_edit').sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";

// Veröffentlichungsende
    $htxt = JHTML::_('calendar',$row->pubend_date,'_pubend_date','_pubend_date','%Y-%m-%d',array('class'=>'inputbox','size'=>'12','maxlength'=>'10'));
    $htxt .= JHTML::_('select.integerlist', 0, 23, 1, '_pubend_hour','class="sem_inputbox" size="1"', $row->pubend_hour, "%02d" );
    $htxt .= JHTML::_('select.integerlist', 0, 55, 5, '_pubend_minute','class="sem_inputbox" size="1"', $row->pubend_minute, "%02d" );
    $html .= "<tr>".sem_f022(JTEXT::_('SEM_0194').$reqfield.':'.sem_f055(JTEXT::_('SEM_0145')),'d','r','20%','sem_edit').sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";
  }

// Kurzbeschreibung
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0013').$reqfield.':'.sem_f055(JTEXT::_('SEM_0115')),'d','r','20%','sem_edit').sem_f022("<textarea class=\"sem_inputbox\" rows=\"3\" name=\"shortdesc\" style=\"width: ".$config->get('sem_p075','400px').";\">".$row->shortdesc."</textarea>",'d','l','80%','sem_edit')."</tr>";

// Veranstaltungsort
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0015').$reqfield.':','d','r','20%','sem_edit').sem_f022("<textarea class=\"sem_inputbox\" rows=\"3\" name=\"place\" style=\"width: ".$config->get('sem_p075','400px').";\">".$row->place."</textarea>",'d','l','80%','sem_edit')."</tr>";

// Veranstalter
  if($reglevel>5 AND $art!=3) {
    $html .= "<tr>".sem_f022(JTEXT::_('SEM_0094').$reqfield.':'.sem_f055(JTEXT::_('SEM_0159')),'d','r','20%','sem_edit').sem_f022(sem_f009($row->publisher),'d','l','80%','sem_edit')."</tr>";
  }

// Plaetze
  $htxt = "<input class=\"sem_inputbox\" type=\"text\" name=\"maxpupil\" size=\"3\" maxlength=\"5\" value=\"".$row->maxpupil."\" /> - ".JTEXT::_('SEM_0024').": ";
  $radios = array();
  $radios[] = JHTML::_('select.option',0,JTEXT::_('SEM_0025'));
  $radios[] = JHTML::_('select.option',1,JTEXT::_('SEM_0070'));
  $radios[] = JHTML::_('select.option',2,JTEXT::_('SEM_0139'));
  $htxt .= JHTML::_('select.genericlist',$radios,'stopbooking','class="sem_inputbox" ','value','text',$row->stopbooking);
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0020').$reqfield.':','d','r','20%','sem_edit').sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";

// max. Buchung
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0021').$reqfield.':'.sem_f055(JTEXT::_('SEM_0138')),'d','r','20%','sem_edit');
  if($config->get('sem_p023','')>0){
    $htxt = "<input class=\"sem_inputbox\" type=\"text\" name=\"nrbooked\" size=\"3\" maxlength=\"3\" value=\"".$row->nrbooked."\" />";
  } else {
    $radios = array();
    $radios[] = JHTML::_('select.option',0,"0");
    $radios[] = JHTML::_('select.option',1,"1");
    $htxt = JHTML::_('select.genericlist',$radios,'nrbooked','class="sem_inputbox" ','value','text',$row->nrbooked);
  }
  $html .= sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";
  $html .= "</table>";
  $html .= $pane->endPanel();

// ### Panel 2 ###

  $html .= $pane->startPanel(JTEXT::_('SEM_0128'),'panel2');
  $html .= "<table>";
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0114'),'d','l','100%','sem_edit',2)."</tr>";
     
// Beschreibung
  $name = "editor1";
  $htxt = $editor->display("description",$row->description,"500","300","50","5");
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0014').': '.sem_f074('evtags'),'d','r','20%','sem_edit').sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";

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
    $htxt = "<span style=\"position:absolute;display:none;border:3px solid #FF9900;background-color:#FFFFFF;\" id=\"1\"><img id=\"toolbild\" src=\"images/stories/".$row->image."\" /></span><span style=\"position:absolute;display:none;border:3px solid #FF9900;background-color:#FFFFFF;\" id=\"2\">".sem_f045("2601")."</span>";
    $htxt .= $imagelist."&nbsp;<img src=\"".sem_f006()."2116.png\" border=\"0\" onmouseover=\"showSemTip('1');\" onmouseout=\"hideSemTip();\" />";
    $html .= "<tr>".sem_f022(JTEXT::_('SEM_0093').':','d','r','20%','sem_edit').sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";
  }

// Google-Map
    $htxt = "<input class=\"sem_inputbox\" type=\"text\" name=\"gmaploc\" size=\"50\" maxlength=\"250\" value=\"".$row->gmaploc."\" /> ";
    $actform = "FrontForm";
    $gmaphref = JURI::BASE();
    if(strstr($gmaphref,"/administrator")) {
      $actform = "adminForm";
    }
    $htxt .= "<a href=\"\" title=\"".JTEXT::_('SEM_0017')."\" class=\"modal\" onclick=\"href='".sem_f004()."index2.php?option=".JRequest::getCmd('option')."&amp;task=35&amp;cid=".$row->id."&amp;zl=' + unescape(document.".$actform.".gmaploc.value) + '&amp;ot=' + nl2li(document.".$actform.".place.value)\" rel=\"{handler: 'iframe', size: {x: ".$config->get('sem_p097',500).", y: ".$config->get('sem_p098',350)."}}\">".JTEXT::_('SEM_0017')."</a>";
    $html .= "<tr>".sem_f022(JTEXT::_('SEM_0016').':','d','r','20%','sem_edit').sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";

// Leitung
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0019').':','d','r','20%','sem_edit').sem_f022("<input class=\"sem_inputbox\" type=\"text\" name=\"teacher\" size=\"50\" maxlength=\"250\" value=\"".$row->teacher."\" />",'d','l','80%','sem_edit')."</tr>";

// Zielgruppe
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0012').':','d','r','20%','sem_edit').sem_f022("<input class=\"sem_inputbox\" type=\"text\" name=\"target\" size=\"50\" maxlength=\"500\" value=\"".$row->target."\" />",'d','l','80%','sem_edit')."</tr>";

// vorgebuchte Plaetze
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0195').':'.sem_f055(JTEXT::_('SEM_0196')),'d','r','20%','sem_edit').sem_f022("<input class=\"sem_inputbox\" type=\"text\" name=\"prebooked\" size=\"3\" maxlength=\"3\" value=\"".$row->prebooked."\" />",'d','l','80%','sem_edit')."</tr>";

// Gebuehr
  $htxt = $config->get('sem_p017',JTEXT::_('SEM_0165'))."&nbsp;<input class=\"sem_inputbox\" type=\"text\" name=\"fees\" size=\"8\" maxlength=\"10\" value=\"".$row->fees."\" />";
  if($config->get('sem_p023',0)>0) {
    $htxt .= " ".JTEXT::_('SEM_0085');
  }
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0022').':','d','r','20%','sem_edit').sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";
  $html .= "</table>";
  $html .= $pane->endPanel();

// ### Panel 3 ###

  $html .= $pane->startPanel(JTEXT::_('SEM_0155'),'panel3');
  $html .= "<table>";
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0157')."<br />&nbsp;<br /><div style=\"overflow:auto; width:100%; height:100px; border:1px solid #D0D0D0;font-size: 11px;\">".JTEXT::_('SEM_0175')."<br />&nbsp;<br />".JTEXT::_('SEM_0162')."</div><br />",'d','l','100%','sem_edit',2)."</tr>";

// Teilnehmerfelder
  $reqfeld = sem_f068($row);
  for($i=0;$i<count($reqfeld[0]);$i++) {
    $html .= "<tr>".sem_f022(JTEXT::_('SEM_0023')." ".($i+1).":",'d','r','20%','sem_edit');
    $htxt = "<input class=\"sem_inputbox\" type=\"text\" name=\"request".($i+1)."\" size=\"50\" value=\"".$reqfeld[0][$i]."\" />";
    $html .= sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";
    $html .= "<tr>".sem_f022("&nbsp;",'d','r','20%','sem_edit');
    $htxt = JTEXT::_('SEM_0112').": <input class=\"sem_inputbox\" type=\"text\" name=\"request".($i+1)."hint\" size=\"50\" maxlength=\"120\" value=\"".$reqfeld[1][$i]."\" />";
    $html .= sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";
    $html .= "<tr>".sem_f022("&nbsp;",'d','r','20%','sem_edit');
    $radios = array();
    $radios[] = JHTML::_('select.option',1,JTEXT::_('SEM_0005'));
    $radios[] = JHTML::_('select.option',0,JTEXT::_('SEM_0006'));
    $htxt = str_replace("SEM_FNUM",$i+1,JTEXT::_('SEM_0171'));
    $htxt = $htxt." ".JHTML::_('select.radiolist', $radios,'request'.($i+1).'nl', 'class="sem_inputbox"','value','text',$reqfeld[2][$i]);
    $html .= sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";
  }
  $html .= "</table>";
  $html .= $pane->endPanel();

// ### Panel 4 ###

  $html .= $pane->startPanel(JTEXT::_('SEM_0129'),'panel4');
  $html .= "<table>";
  $html .= "<tr>".sem_f022(JTEXT::_('SEM_0156')."<br />&nbsp;<br /><div style=\"overflow:auto; width:100%; height:100px; border:1px solid #D0D0D0;font-size: 11px;\">".JTEXT::_('SEM_0175')."<p />&nbsp;<br />".JTEXT::_('SEM_0162')."</div><br />",'d','l','100%','sem_edit',2)."</tr>";

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
    $htxt = str_replace("SEM_FNUM",$i+1,JTEXT::_('SEM_0171'));
    $htxt = $htxt." ".JHTML::_('select.radiolist', $radios,'zusatz'.($i+1).'nl', 'class="sem_inputbox" ','value','text',$zusfeld[3][$i]);
    $html .= sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";
    $htxt = str_replace("SEM_FNUM",$i+1,JTEXT::_('SEM_0117'));
    $htxt = $htxt." ".JHTML::_('select.radiolist', $radios,'zusatz'.($i+1).'show', 'class="sem_inputbox" ','value','text',$zusfeld[2][$i]);
    $html .= "<tr>".sem_f022("&nbsp;",'d','r','20%','sem_edit');
    $html .= sem_f022($htxt,'d','l','80%','sem_edit')."</tr>";
  }
  $html .= "</table>";
  $html .= $pane->endPanel();

// ### Panel 5 ###
  if($config->get('sem_p056',200)>0) {
    $html .= $pane->startPanel(JTEXT::_('SEM_0131'),'panel5');
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
        $htxt = "<a style=\"font-weight: bold;\" href=\"".sem_f004()."index2.php?s=".sem_f036()."&amp;option=".JRequest::getCmd('option')."&amp;task=34&amp;a6d5dgdee4cu7eho8e7fc6ed4e76z=".sha1(md5($datfeld[0][$i])).$row->id."\">".$datfeld[0][$i]."</a> - <input class=\"sem_inputbox\" type=\"checkbox\" name=\"deldatei".($i+1)."\" value=\"1\" onClick=\"if(this.checked==true) {datei".($i+1).".disabled=true;} else {datei".($i+1).".disabled=false;}\"> ".JTEXT::_('SEM_0144'); 
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
    $html .= $pane->endPanel();
  }

  $html .= $pane->endPane();
  $html .= "\n</td></tr><tr>".sem_f022($reqfield." ".JTEXT::_('SEM_0118'),'d','r','100%','sem_nav',2);

// Benutzer informieren
  if($art!=3) {
    $html .= "</tr></td></tr>";
    $radios = array();
    $radios[] = JHTML::_('select.option',1,JTEXT::_('SEM_0005'));
    $radios[] = JHTML::_('select.option',0,JTEXT::_('SEM_0006'));
    $htx2 .= "<br />".JHTML::_('select.radiolist',$radios,'inform','class="sem_inputbox"','value','text',0);
    $htx2 .= "<br />".JTEXT::_('SEM_0108').": <textarea class=\"sem_inputbox\" name=\"infotext\" id=\"infotext\" rows=\"3\" style=\"width: ".$config->get('sem_p075','400px').";\">".$htx3."</textarea>";
    $html .= "\n<tr>".sem_f022($htx2,'d','c','100%','sem_nav',2);
  }

  return $html;
}
// ++++++++++++++++++++++++++++++++++++++
// +++ Veranstalterliste ausgeben     +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f009() {
  $config = &JComponentHelper::getParams('com_seminar');
  $publevel = $config->get('sem_p001',3);
  $database = &JFactory::getDBO();
  $publevel = $config->get('sem_p001',3);
  $args = func_get_args();
  $jeder = FALSE;
  if(count($args)>1) {
    $jeder = TRUE;
  }
  $where = array();
  if($publevel>2) {
    $where [] = "usertype<>'Registered'";
  } else if($publevel>3) {
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
  if($jeder==TRUE) {
    $dazu->value = 0;
    $dazu->text = JTEXT::_('SEM_0135');
    array_unshift($benutzer,$dazu);
  }
  return JHTML::_('select.genericlist', array_merge($benutzer), 'publisher', 'class="sem_inputbox" size="1"', 'value', 'text', $args[0]);
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
  if ($config->get('sem_p101',1)==1) {
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
      if( count($benutzer) ) {
        $benutzer = array_merge($benutzer);
        $blist = JHTML::_('select.genericlist', $benutzer, 'uid', 'class="sem_inputbox" size="1"', 'value', 'text', '');
      } else {
        $blist = "";
      }
    }
    return $blist;
  } else {
// Alternativ Benutzer per Eingabe anfordern
    $htx1  = "<input type=\"hidden\" name=\"uid\" value=\"0\" />";
    $htx1 .= "<input class=\"sem_inputbox\" type=\"text\" name=\"book4user\" size=\"10\" maxlength=\"100\" value=\"\" />";
    return $htx1;
  }
}

// ++++++++++++++++++++++++++++++++++++++++++++++++
// +++ Name und Beschreibung der Kategorie ausgeben
// ++++++++++++++++++++++++++++++++++++++++++++++++

function sem_f012($catid) {
  $database = &JFactory::getDBO();
  $database->setQuery( "Select * FROM #__categories WHERE section='com_seminar' AND id = '$catid'");
  $row = $database->loadObject();
  return array($row->title,$row->description);
}

// +++++++++++++++++++++++++++++++++++++++
// +++ Statusgrafik 2 erzeugen            
// +++++++++++++++++++++++++++++++++++++++

function sem_f013($max,$frei,$art) {
  if($max==0) {$max = 1;}
  $hoehefrei = round($frei*56/$max);
  $hoehebelegt = 56-$hoehefrei;
  $html = "<div style=\"position:relative;top:0px;left:0px;width:18px;height:58px\"><img src=\"".sem_f006()."2100.png\" width=\"18px\" height=\"1\" /><br />";
  if($hoehefrei>0) {
    $html .= "<img src=\"".sem_f006()."212".$art.".png\" width=\"18px\" height=\"".$hoehefrei."\" /><br />";
  }
  if($hoehebelegt>0) {
    $html .= "<img src=\"".sem_f006()."211".$art.".png\" width=\"18px\" height=\"".$hoehebelegt."\" /><br />";
  }
  $html .= "<img src=\"".sem_f006()."2100.png\" width=\"18px\" height=\"1\" />";
  $html .= "<div style=\"font-size:8px;position:absolute;top:-2px;right:2px;\">".$max."</div>";
  $html .= "<div style=\"font-size:8px;position:absolute;top:44px;right:2px;\">0</div></div>";
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

// ++++++++++++++++++++++++++++++++++++
// +++ Array mit Zusatzfeldern erzeugen
// ++++++++++++++++++++++++++++++++++++

function sem_f017($row) {
  $zusfeld = array();
  if(isset($row->zusatz1)) {
    $zusfeld[] = array($row->zusatz1,$row->zusatz2,$row->zusatz3,$row->zusatz4,$row->zusatz5,$row->zusatz6,$row->zusatz7,$row->zusatz8,$row->zusatz9,$row->zusatz10,$row->zusatz11,$row->zusatz12,$row->zusatz13,$row->zusatz14,$row->zusatz15,$row->zusatz16,$row->zusatz17,$row->zusatz18,$row->zusatz19,$row->zusatz20);
    if(isset($row->zusatz1hint)) {
      $zusfeld[] = array($row->zusatz1hint,$row->zusatz2hint,$row->zusatz3hint,$row->zusatz4hint,$row->zusatz5hint,$row->zusatz6hint,$row->zusatz7hint,$row->zusatz8hint,$row->zusatz9hint,$row->zusatz10hint,$row->zusatz11hint,$row->zusatz12hint,$row->zusatz13hint,$row->zusatz14hint,$row->zusatz15hint,$row->zusatz16hint,$row->zusatz17hint,$row->zusatz18hint,$row->zusatz19hint,$row->zusatz20hint);
      $zusfeld[] = array($row->zusatz1nl,$row->zusatz2nl,$row->zusatz3nl,$row->zusatz4nl,$row->zusatz5nl,$row->zusatz6nl,$row->zusatz7nl,$row->zusatz8nl,$row->zusatz9nl,$row->zusatz10nl,$row->zusatz11nl,$row->zusatz12nl,$row->zusatz13nl,$row->zusatz14nl,$row->zusatz15nl,$row->zusatz16nl,$row->zusatz17nl,$row->zusatz18nl,$row->zusatz19nl,$row->zusatz20nl);
      $zusfeld[] = array($row->zusatz1show,$row->zusatz2show,$row->zusatz3show,$row->zusatz4show,$row->zusatz5show,$row->zusatz6show,$row->zusatz7show,$row->zusatz8show,$row->zusatz9show,$row->zusatz10show,$row->zusatz11show,$row->zusatz12show,$row->zusatz13show,$row->zusatz14show,$row->zusatz15show,$row->zusatz16show,$row->zusatz17show,$row->zusatz18show,$row->zusatz19show,$row->zusatz20show);
    }
  } else {
    $zusfeld[] = array("","","","","","","","","","","","","","","","","","","","");
    $zusfeld[] = array("","","","","","","","","","","","","","","","","","","","");
    $zusfeld[] = array("1","1","1","1","1","1","1","1","1","1","1","1","1","1","1","1","1","1","1","1");
    $zusfeld[] = array("0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0");
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
    $text = str_replace("´","'",$text);
    $text = str_replace('\"','"',$text);
    $text = strip_tags(trim($text));
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

function sem_f020() {
  $database = &JFactory::getDBO();
  $args = func_get_args();
  $row = $args[0];
  $userid = 0;
  if(count($args)>1) {
    $userid = $args[1];
  }
  if($userid == 0) {
    $userid = -1;
  }
  $database->setQuery( "SELECT * FROM #__sembookings WHERE semid='".$row->id."' ORDER BY id" );
  $temps = $database->loadObjectList();
  $gebucht = $row->prebooked;
  $zertifiziert = 0;
  $bezahlt = 0;
  $platznummer = 0;
  $zaehleplatz = true;
  foreach($temps as $el) {
    $gebucht = $gebucht + $el->nrbooked;
    $zertifiziert = $zertifiziert + $el->certificated;
    $bezahlt = $bezahlt + $el->paid;
    if($zaehleplatz == true) {
      $platznummer = $platznummer + $el->nrbooked;
      if($el->userid == $userid) {
        $zaehleplatz = false;
      }
    }
  }
  $zurueck->booked = $gebucht;
  $zurueck->certificated = $zertifiziert;
  $zurueck->paid = $bezahlt;
  $zurueck->number = count($temps);
  $zurueck->free = $row->maxpupil - $gebucht;
  if($zurueck->free<0) {
    $zurueck->free = 0;
  }
  $zurueck->waitinglistspace = $platznummer;
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
  return "<form action=\"\" method=\"post\" name=\"".$htxt."\" id=\"".$htxt."\"".$type.">";
}

// ++++++++++++++++++++++++++++++++++
// +++ Ausgabe Javascript
// ++++++++++++++++++++++++++++++++++

function sem_f027($art) {
  $config = &JComponentHelper::getParams('com_seminar');
  $my = &JFactory::getuser();
  $html = "\n<script type=\"text/javascript\">";
  $html .= "\nfunction nl2li(text){";
  $html .= "\ntext = escape(text);";
  $html .= "\nif(text.indexOf('%0D%0A') > -1){";
  $html .= "\nre_nlchar = /%0D%0A/g;";
  $html .= "\n}else if(text.indexOf('%0A') > -1){";
  $html .= "\nre_nlchar = /%0A/g;";
  $html .= "\n}else if(text.indexOf('%0D') > -1){";
  $html .= "\nre_nlchar = /%0D/g;";
  $html .= "\n}";
  $html .= "\nreturn unescape( text.replace(re_nlchar,'|') );";
  $html .= "\n}";
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
// Zahl formatieren
      $html .= "\nfunction formatnumber(zahl) {";
      $html .= "\n  k = ".$config->get('sem_p061',2).";";
      $html .= "\n  var neu = '';";
      $html .= "\n  var dec_point = '".$config->get('sem_p063',JTEXT::_('SEM_0119'))."';";
      $html .= "\n  var thousands_sep = '".$config->get('sem_p062',JTEXT::_('SEM_0120'))."';";
      $html .= "\n  var f = Math.pow(10, k);";
      $html .= "\n  zahl = '' + parseInt(zahl * f + (.5 * (zahl > 0 ? 1 : -1)) ) / f ;";
      $html .= "\n  var idx = zahl.indexOf('.');";
      $html .= "\n  zahl += (idx == -1 ? '.' : '' ) + f.toString().substring(1);";
      $html .= "\n  var sign = zahl < 0;";
      $html .= "\n  if(sign) zahl = zahl.substring(1);";
      $html .= "\n  idx = zahl.indexOf('.');";
      $html .= "\n  if( idx == -1) idx = zahl.length;";
      $html .= "\n  else neu = dec_point + zahl.substr(idx + 1, k);";
      $html .= "\n  while(idx > 0) {";
      $html .= "\n   if(idx - 3 > 0) {";
      $html .= "\n    neu = thousands_sep + zahl.substring( idx - 3, idx) + neu;";
      $html .= "\n   } else {";
      $html .= "\n    neu = zahl.substring(0, idx) + neu;";
      $html .= "\n   }";
      $html .= "\n  idx -= 3;";
      $html .= "\n  }";
      $html .= "\n return (sign ? '-' : '') + neu;";
      $html .= "\n}";
// Gesamtwert neu berechnen
      $html .= "\nfunction calcamount() {";
      $html .= "\n var booked = parseInt(document.FrontForm.nrbooked.value);";
      $html .= "\n var sfbooked = parseInt(document.FrontForm.sem_selfbooked.value);";
      $html .= "\n if (document.getElementById('sem_amount')) {";
      $html .= "\n  var fee = parseFloat(document.FrontForm.sem_fee.value);";
      $html .= "\n  amount = fee * booked;";
      $html .= "\n  document.getElementById('sem_amount').innerHTML = formatnumber(amount);";
      $html .= "\n }";
      $html .= "\n if (document.getElementById('sem_freespaces')) {";
      $html .= "\n  var spfree = parseInt(document.FrontForm.sem_spacesfree.value);";
      $html .= "\n  free = spfree + sfbooked - booked;";
      $html .= "\n  if(free<0) free = 0;";
      $html .= "\n  document.getElementById('sem_freespaces').innerHTML = free;";
      $html .= "\n }";
      $html .= "\n if (document.getElementById('sem_bookedspaces')) {";
      $html .= "\n  var spbooked = parseInt(document.FrontForm.sem_spacesbooked.value);";
      $html .= "\n  allbooked = spbooked - sfbooked + booked;";
      $html .= "\n  if(allbooked<0) allbooked = 0;";
      $html .= "\n  document.getElementById('sem_bookedspaces').innerHTML = allbooked;";
      $html .= "\n }";
      $html .= "\n}";
// E-Mail pruefen
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
// Teilnehmer zaehlen
      if($art==2.02 OR $art==2.04 OR $art==2.06 OR $art==2.07) {
        $html .= "\nvar intCounter = 0;";
        $html .= "\nfunction recordCount(recordCounter,i) {";
        $html .= "\n var x = 0;";
        $html .= "\n if (recordCounter != 'internal') {";
        $html .= "\n  x=eval(document.getElementById(recordCounter).value);";
        $html .= "\n } else {";
        $html .= "\n  if (!recordCount.counter) recordCount.counter=0;";
        $html .= "\n  x = recordCount.counter;";
        $html .= "\n }";
        $html .= "\n if (!i) return x;";
        $html .= "\n if (recordCounter != 'internal') {";
        $html .= "\n  document.getElementById(recordCounter).value = x + i;";
        $html .= "\n } else {";
        $html .= "\n  recordCount.counter = x + i;";
        $html .= "\n }";
        $html .= "\n}";
// Teilnehmer hinzufuegen
        $html .= "\nfunction addRecord(templateName,insertPosition,recordCounter,recordCounterMax) {";
        $html .= "\n if (!document.getElementById(templateName)) {";
        $html .= "\n  return;";
        $html .= "\n }";
        $html .= "\n if (!recordCounter) {";
        $html .= "\n  var recordCounter='internal';";
        $html .= "\n } else if (!recordCounterMax) {";
        $html .= "\n  var recordCounterMax = document.getElementById(recordCounter).getAttribute('maxlength');";
        $html .= "\n }";
        $html .= "\n if (!recordCounterMax) {";
        $html .= "\n  var recordCounterMax = 999;";
        $html .= "\n }";
        $html .= "\n var activeRecs = recordCount(recordCounter);";
        $html .= "\n if (activeRecs == recordCounterMax) {";
        $html .= "\n  alert(unescape(\"".JTEXT::_('SEM_0172')."\"));";
        $html .= "\n  return;";
        $html .= "\n }";
        $html .= "\n if (intCounter < activeRecs) {";
        $html .= "\n  intCounter = activeRecs;";
        $html .= "\n }";
        $html .= "\n intCounter++;";
        $html .= "\n var newRecord = document.getElementById(templateName).cloneNode(true);";
        $html .= "\n newRecord.id = '';";
        $html .= "\n newRecord.style.display = 'block';";
        $html .= "\n var newFields = newRecord.childNodes;";
        $html .= "\n for (var i=0; i < newFields.length; i++) {";
        $html .= "\n  var theName = newFields[i].name;";
        $html .= "\n  if (theName) {";
        $html .= "\n   newFields[i].name = theName + intCounter;";
        $html .= "\n  }";
        $html .= "\n }";
        $html .= "\n var insertHere = document.getElementById(insertPosition);";
        $html .= "\n insertHere.parentNode.insertBefore(newRecord,insertHere);";
        $html .= "\n recordCount(recordCounter,+1);";
        $html .= "\n calcamount();";
        $html .= "\n}";
// Teilnehmer loeschen
        $html .= "\nfunction delRecord(RecordParentNode,recordCounter,recordCounterMin) {";
        $html .= "\n if (!recordCounter) {";
        $html .= "\n  var recordCounter='internal';";
        $html .= "\n }";
        $html .= "\n if (!recordCounterMin) {";
        $html .= "\n  var recordCounterMin = 0;";
        $html .= "\n }";
        $html .= "\n if (recordCount(recordCounter) == recordCounterMin) {";
        $html .= "\n  alert(unescape(\"".JTEXT::_('SEM_0173')."\"));";
        $html .= "\n  return;";
        $html .= "\n }";
        $html .= "\n RecordParentNode.parentNode.removeChild(RecordParentNode);";
        $html .= "\n recordCount(recordCounter,-1);";
        $html .= "\n calcamount();";
        $html .= "\n}";
// Vorgabewert pruefen
        $html .= "\nfunction checkPreset(element,preset) {";
        $html .= "\n if (element.value == '' || element.value == preset) {";
        $html .= "\n  element.value = preset;";
        $html .= "\n  element.className='sem_inputbox_request_preset';";
        $html .= "\n }";
        $html .= "\n}";
// Vorgabewert loeschen
        $html .= "\nfunction rmvPreset(element,preset) {";
        $html .= "\n if (element.value == preset) {";
        $html .= "\n  element.value = '';";
        $html .= "\n  element.className='sem_inputbox_request';";
        $html .= "\n }";
        $html .= "\n}";
      }
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
//PayPal absenden
    if(sem_f067($config->get('sem_p109',''),"voll") OR sem_f067($config->get('sem_p110',''),"voll")) {
      $html .= "\nfunction pp() {";
      $html .= "\n document.PayPalForm.submit();";
      $html .= "\n}";
    }
    $html .= "\nfunction auf(stask,scid,suid) {";
    $html .= "\n var form = document.FrontForm;";
  }
  if(round($art)>2 AND $art<5) {
    $html .= "\n if (stask == \"10\") {";
    $html .= "\n  if (form.vorlage.type == \"select-one\") {";
    $html .= "\n   form.id.value = \"\";";
    $html .= "\n  };";
    $html .= "\n  form.pattern.value = \"\";";
    $html .= "\n  los(stask,scid,suid);";
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
        $html .= "\n } else if (stask == \"5\" || stask==\"26\" || stask==\"29\" || stask==\"36\" ) {";
        $html .= "\n  var abbruch = false;";
        $html .= "\n  var meldung = unescape(\"".JTEXT::_('SEM_A101')."\");";
// nrbooked + intCounter
        if($art==2.02 OR $art==2.04 OR $art==2.06 OR $art==2.07) {
          $html .= "\n  for (var zz=1; zz<intCounter+1+recordCount('RequestedRecords'); zz++) {";
          $html .= "\n   ename = \"request1\" + zz;";
          $html .= "\n   if (!document.FrontForm.elements[ename]) continue;";
          $html .= "\n   for (var z=1; z<11; z++) {";
          $html .= "\n    ename = \"request\" + z; ename = ename + zz;";
          $html .= "\n    if (!document.FrontForm.elements[ename]) break;";
          $html .= "\n    oname = \"reqopt\" + z; oname = oname + zz;";
          $html .= "\n    rname = \"reqpre\" + z; rname = rname + zz;";
          $html .= "\n    if ( document.FrontForm.elements[rname] != null && document.FrontForm.elements[rname].value == document.FrontForm.elements[ename].value) {";
          $html .= "\n     document.FrontForm.elements[ename].value = '';";
          $html .= "\n    }";
          $html .= "\n    if (document.FrontForm.elements[ename].type == \"text\" || document.FrontForm.elements[ename].type == \"textarea\") {";
          $html .= "\n     document.FrontForm.elements[ename].className=\"sem_inputbox\";";
          $html .= "\n     if (document.FrontForm.elements[ename].value == \"\" && document.FrontForm.elements[oname].value == \"1\") {";
          $html .= "\n      document.FrontForm.elements[ename].className=\"sem_alertbox\";";
          $html .= "\n      abbruch = true;";
          $html .= "\n     } else if (document.FrontForm.elements[ename].value != \"\") {";
          $html .= "\n      if (document.FrontForm.elements[ename].id.match(/email/)) {";
          $html .= "\n       if (chmail(document.FrontForm.elements[ename].value) == false) {";
          $html .= "\n        document.FrontForm.elements[ename].className=\"sem_alertbox\";";
          $html .= "\n        meldung = meldung.concat(unescape(\"\\n".JTEXT::_('SEM_A105')."\"));";
          $html .= "\n        abbruch = true;";
          $html .= "\n       }";
          $html .= "\n      }";
          $html .= "\n     }";
          $html .= "\n    } else if (document.FrontForm.elements[ename].type == \"select-one\") {";
          $html .= "\n     document.FrontForm.elements[ename].className=\"sem_inputbox\";";
          $html .= "\n     if (document.FrontForm.elements[ename].options.selectedIndex == \"0\" && document.FrontForm.elements[oname].value == 1) {";
          $html .= "\n      document.FrontForm.elements[ename].className=\"sem_alertbox\";";
          $html .= "\n      abbruch = true;";
          $html .= "\n     }";
          $html .= "\n    }";
          $html .= "\n    if ( document.FrontForm.elements[rname] != null && document.FrontForm.elements[ename].value == '') {";
          $html .= "\n     document.FrontForm.elements[ename].value = document.FrontForm.elements[rname].value;";
          $html .= "\n    }";
          $html .= "\n   }";
          $html .= "\n  }";
        }
        if($art==2.01 OR $art==2.04 OR $art==2.05 OR $art==2.07) {
          $html .= "\n  for (var z=1; z<21; z++) {";
          $html .= "\n   ename = \"zusatz\" + z;";
          $html .= "\n   oname = \"zusopt\" + z;";
          $html .= "\n   if (!document.FrontForm.elements[ename]) continue;";
          $html .= "\n   if (!document.FrontForm.elements[oname]) continue;";
          $html .= "\n   if (document.FrontForm.elements[ename].type == \"text\" || document.FrontForm.elements[ename].type == \"textarea\") {";
          $html .= "\n    document.FrontForm.elements[ename].className=\"sem_inputbox\";";
          $html .= "\n    if (document.FrontForm.elements[ename].value == \"\" && document.FrontForm.elements[oname].value == 1) {";
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
          $html .= "\n    if (document.FrontForm.elements[ename].type == \"select-one\") {";
          $html .= "\n     document.FrontForm.elements[ename].className=\"sem_inputbox\";";
          $html .= "\n     if (document.FrontForm.elements[ename].options.selectedIndex == \"0\" && document.FrontForm.elements[oname].value == 1) {";
          $html .= "\n      document.FrontForm.elements[ename].className=\"sem_alertbox\";";
          $html .= "\n      abbruch = true;";
          $html .= "\n     }";
          $html .= "\n    }";
          $html .= "\n   }";
          $html .= "\n  }";
        }
        if($config->get('sem_p026',0)>0 AND ($my->id==0 OR $art==2.03 OR $art==2.05 OR $art==2.06 OR $art==2.07)) {
          $html .= "\n  if (document.FrontForm.elements['name'] && document.FrontForm.elements['email']) {;";
          $html .= "\n   document.FrontForm.name.className=\"sem_inputbox\";";
          $html .= "\n   if (document.FrontForm.name.value == '') {";
          $html .= "\n    document.FrontForm.name.className=\"sem_alertbox\";";
          $html .= "\n    abbruch = true;";
          $html .= "\n   }";
          $html .= "\n   document.FrontForm.email.className=\"sem_inputbox\";";
          $html .= "\n   if (document.FrontForm.email.value == '') {";
          $html .= "\n    document.FrontForm.email.className=\"sem_alertbox\";";
          $html .= "\n    abbruch = true;";
          $html .= "\n   }";
          $html .= "\n   if (document.FrontForm.email.value != '' && chmail(document.FrontForm.email.value) == false) {";
          $html .= "\n    document.FrontForm.email.className=\"sem_alertbox\";";
          $html .= "\n    meldung = meldung.concat(unescape(\"\\n".JTEXT::_('SEM_A105')."\"));";
          $html .= "\n    abbruch = true;";
          $html .= "\n   }";
          $html .= "\n  }";
        }
        $html .= "\n  if (abbruch == true) {";
        $html .= "\n   alert(meldung);";
        if($config->get('sem_p020',"")!="") {
          $html .= "\n  } else if(document.FrontForm.elements['veragb']) {";
          $html .= "\n   if(document.FrontForm.veragb.checked == false) {";
          $html .= "\n    document.FrontForm.veragb.className=\"sem_alertbox\";";
          $html .= "\n    alert(unescape( \"".JTEXT::_('SEM_A104')."\" ));";
          $html .= "\n    return;";
          $html .= "\n   } else {";
          $html .= "\n    document.FrontForm.veragb.className=\"sem_inputbox\";";
          $html .= "\n   }";
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
        $html .= "\n   }";
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
    $html = "<center><table><tr><td class=\"sem_footer\">".sem_f045("menulogo")." <i><a href=\"http://seminar.vollmar.ws\" target=\"_new\">".JTEXT::_('SEM_0043')."</a> V".sem_f001()."</i> &#169; &#68;&#105;&#114;&#107; &#86;&#111;&#108;&#108;&#109;&#97;&#114; ".date("Y")."</td></tr></table></center>";
  }
  return $html;
}

// ++++++++++++++++++++++++++++++++++
// +++ Farbbeschreibung anzeigen  +++
// ++++++++++++++++++++++++++++++++++

function sem_f029($green,$yellow,$red) {
  $html = sem_f023(0)."<tr>";
  if($green!="") {
    $html .= sem_f022(sem_f045("2502")." ".$green,'d','c','','');
  }
  if($yellow!="") {
    $html .= sem_f022(sem_f045("2501")." ".$yellow,'d','c','','');
  }
  if($red!="") {
    $html .= sem_f022(sem_f045("2500")." ".$red,'d','c','','');
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
  $config = &JComponentHelper::getParams('com_seminar');
  $lang = JFactory::getLanguage();
  $html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
  $html .= "\n<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"".$lang->getName()."\" lang=\"".$lang->getName()."\" >";
  $html .= "\n<head>";
  $html .= "\n<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" />";
  $html .= "<link rel=\"stylesheet\" href=\"".sem_f005()."css/seminar.".$config->get('sem_p045',0).".css\" type=\"text/css\" />";
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
   
  $html = "<div style=\"width: ".$config->get('sem_p074','100%').";margin: 0px;\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr>";
  if($reglevel>1) {
    $html .= "\n<td class=\"sem_tab".$tabnum[0]."\">";
    $html .= JHTML::_('link',"javascript:document.FrontForm.limitstart.value='0';auf(0,'','')",sem_f045("2600",JTEXT::_('SEM_0083'))." ".JTEXT::_('SEM_0083'),array('title'=>JTEXT::_('SEM_0083'),'class'=>'sem_tab'));
    $html .= "</td>";
    $html .= "\n<td class=\"sem_tab".$tabnum[1]."\">";
    $html .= JHTML::_('link',"javascript:document.FrontForm.limitstart.value='0';auf(1,'','')",sem_f045("2700",JTEXT::_('SEM_1005'))." ".JTEXT::_('SEM_1005'),array('title'=>JTEXT::_('SEM_1005'),'class'=>'sem_tab'));
    $html .= "\n</td>";
    if($reglevel>=$config->get('sem_p001',3)) {
      $html .= "\n<td class=\"sem_tab".$tabnum[2]."\">";
      $html .= JHTML::_('link',"javascript:document.FrontForm.limitstart.value='0';auf(2,'','')",sem_f045("2800",JTEXT::_('SEM_1031'))." ".JTEXT::_('SEM_1031'),array('title'=>JTEXT::_('SEM_1031'),'class'=>'sem_tab'));
      $html .= "\n</td>";
    }
  } else {
    if($config->get('sem_p026',0)==0 AND $config->get('sem_p092',1)==1) {
      sem_f080(0,JTEXT::_('SEM_1054'));
    }
    if($config->get('sem_p051',1)>0) {
      $html .= "<td class=\"sem_notableft\">";
      $html .= "<form name=\"sem_loginform\" method=\"post\" action=\"\"><input type=\"text\" name=\"semusername\" value=\"".JTEXT::_('USERNAME')."\" class=\"sem_inputbox\" style=\"background-image:url(".sem_f006()."0004.png);background-repeat:no-repeat;background-position:2px;padding-left:18px;width:100px;vertical-align:middle;\" onFocus=\"if(this.value=='".JTEXT::_('USERNAME')."') this.value='';\" onBlur=\"if(this.value=='') {this.value='".JTEXT::_('USERNAME')."';form.semlogin.disabled=true;}\" onKeyup=\"if(this.value!='') form.semlogin.disabled=false;\"> ";
      $html .= "<input type=\"password\" name=\"sempassword\" value=\"".JTEXT::_('PASSWORD')."\" class=\"sem_inputbox\" style=\"background-image:url(".sem_f006()."0005.png);background-repeat:no-repeat;background-position:2px;padding-left:18px;width:100px;vertical-align:middle;\" onFocus=\"if(this.value=='".JTEXT::_('PASSWORD')."') this.value='';\" onBlur=\"if(this.value=='') this.value='".JTEXT::_('PASSWORD')."';\"> ";
      $html .= "<button class=\"button\" type=\"submit\" style=\"cursor:pointer;vertical-align:middle;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;\" title=\"".JTEXT::_('LOGIN')."\" id=\"semlogin\" disabled>".sem_f045("0007")."</button>";
      $html .= "&nbsp;&nbsp;&nbsp;";
      if($config->get('sem_p104',1)>0) {
        $html .= " <button class=\"button\" type=\"button\" style=\"cursor:pointer;vertical-align:middle;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;\" title=\"".JTEXT::_('SEM_1051')."\" onClick=\"location.href='".sem_f004()."index.php?option=com_user&amp;view=remind'\">".sem_f045("0008")."</button>";
      }
      if($config->get('sem_p105',1)>0) {
        $html .= " <button class=\"button\" type=\"button\" style=\"cursor:pointer;vertical-align:middle;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;\" title=\"".JTEXT::_('SEM_1050')."\" onClick=\"location.href='".sem_f004()."index.php?option=com_user&amp;view=reset'\">".sem_f045("0009")."</button>";
      }
      if($confusers->get('allowUserRegistration',0)>0 AND $config->get('sem_p106',1)>0) {
        $html .= " <button class=\"button\" type=\"button\" style=\"cursor:pointer;vertical-align:middle;padding-left:0pt;padding-right:0pt;padding-top:0pt;padding-bottom:0pt;\" title=\"".JTEXT::_('SEM_1052')."\" onClick=\"location.href='".sem_f004()."index.php?option=com_user&amp;view=register'\">".sem_f045("0006")."</button>";
      }
      $html .= "</form></td>";
    }
  }
  $html .= "<td class=\"sem_notab\">&nbsp;";
  $knopfunten = "";
  if($reglevel>1 and $config->get('sem_p051',1)>0) {
    $html .= sem_f071("javascript:auf(32,'','');","3232","1049")."&nbsp;";
    $knopfunten .= sem_f072("auf(32,'','')","3216","1049");
  }
  echo $html;
  return $knopfunten;
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Kopf- und Fussbereiche ersetzen
// ++++++++++++++++++++++++++++++++++++++

function sem_f033($html,$art,$search,$limit,$limitstart,$total,$n,$dateid,$catid) {
  $config = &JComponentHelper::getParams('com_seminar');
  $html = preg_replace("/\r|\n/s", "", $html);
  
  switch($art) {
    case 1:
      $headtitle = JTEXT::_('SEM_1005');
      $headdesc = JTEXT::_('SEM_1006');
      $dots = array(JTEXT::_('SEM_0030'),JTEXT::_('SEM_0025'),JTEXT::_('SEM_0029'));
      break;
    case 2:
      $headtitle = JTEXT::_('SEM_1031');
      $headdesc = JTEXT::_('SEM_1032');
      $dots = array(JTEXT::_('SEM_0045'),JTEXT::_('SEM_0047'),JTEXT::_('SEM_0046'));
      break;
    default:
      if($catid==0) {
        $headtitle = JTEXT::_('SEM_0027');
        $headdesc = JTEXT::_('SEM_1001');
      } else {
        $headline = sem_f012($catid);
        $headtitle = $headline[0];
        $headdesc = $headline[1];
      }
      $dots = array(JTEXT::_('SEM_0031'),JTEXT::_('SEM_0036'),JTEXT::_('SEM_0088'));
      break;
  }

// Beschreibungsfeld
  $html = str_replace('SEM_TAB_DESCRIPTION',$headdesc,$html);

// Ausgabe parsen
  $parser = array();
  if($headtitle!="") {
    $parser[] = "sem_tabtitle";
  } else {
    $parser[] = "sem_!tabtitle";
  }
  if($headdesc!="") {
    $parser[] = "sem_tabdescription";
  } else {
    $parser[] = "sem_!tabdescription";
  }
  if($n<$total) {
    $parser[] = "sem_tabnavigation";
  } else {
    $parser[] = "sem_!tabnavigation";
  }
  if($n>0) {
    $parser[] = "sem_tabevents";
  } else {
    $parser[] = "sem_!tabevents";
  }
  $html = sem_f065($html,$parser);

// Grafikpfad ersetzen
  $html = str_replace('SEM_IMAGEDIR1',sem_f006(),$html);
  $html = str_replace('SEM_IMAGEDIR2',sem_f007(1),$html);

// Werte ersetzen
  $html = str_replace('SEM_TAB_TITLE',$headtitle,$html);
  $html = str_replace('SEM_TAB_NUMBER',JTEXT::_('SEM_0050').":&nbsp;".sem_f040(1,$limit),$html);
  $html = str_replace('SEM_TAB_SEARCH',JTEXT::_('SEM_0067').": <input class=\"sem_inputbox\" type=\"text\" name=\"search\" height=\"16\" size=\"15\" value=\"".$search."\" onChange=\"document.FrontForm.submit();\"/>",$html);
  $html = str_replace('SEM_TAB_CATEGORIES',JTEXT::_('SEM_0008').": ".sem_f073($catid),$html);
  $html = str_replace('SEM_TAB_TYPES',JTEXT::_('SEM_1039').": ".sem_f041($dateid),$html);
  $html = str_replace('SEM_TAB_RESET',"<button class=\"button\" style=\"cursor:pointer;\" type=\"button\" onclick=\"document.FrontForm.dateid.value=1;document.FrontForm.catid.value=0;document.FrontForm.search.value='';document.FrontForm.limit.value=".$config->get('sem_p021','').";document.FrontForm.submit();\">".JTEXT::_('SEM_1036')."</button>",$html);
  $html = str_replace('SEM_TAB_NAVIGATION',sem_f039($total, $limit, $limitstart),$html);
  $html = str_replace('SEM_TAB_LEGEND',sem_f029($dots[0],$dots[1],$dots[2]),$html);
  
  return $html;
}

// ++++++++++++++++++++++++++++++++++++++
// +++ E-Mail-Fenster ausgeben
// ++++++++++++++++++++++++++++++++++++++

function sem_f034($dir,$cid,$art) {
  $config = &JComponentHelper::getParams('com_seminar');
  $html = "";
  $href = sem_f004()."index2.php?s=".sem_f036()."&option=".JRequest::getCmd('option')."&cid=".$cid."&task=";
  $htxt = "<a class=\"modal\" rel=\"{handler: 'iframe', size: {x: ".$config->get('sem_p097',500).", y: ".$config->get('sem_p098',350)."}}\" href=\"".$href;
  if($art==1 AND sem_f042()>1 AND $config->get('sem_p011',0)>0) {
    $html = $htxt."19\" title=\"".JTEXT::_('SEM_1028')."\">".sem_f045("1732",JTEXT::_('SEM_1028'))."</a>";
  } else if($art==2 AND sem_f042()>1 AND $config->get('sem_p011',0)>0) {
    $html = $htxt."19\"><button class=\"button\" type=\"button\">".sem_f045("1716",JTEXT::_('SEM_1028'))."&nbsp;".JTEXT::_('SEM_1028')."</button></a>";
  } else if($art==3 AND sem_f042()>2) {
    $html = $htxt."30\" title=\"".JTEXT::_('SEM_1028')."\">".sem_f045("1732",JTEXT::_('SEM_1028'))."</a>";
  } else if($art==4 AND sem_f042()>2) {
    $html = $htxt."30\"><button class=\"button\" type=\"button\">".sem_f045("1716",JTEXT::_('SEM_1028'))."&nbsp;".JTEXT::_('SEM_1028')."</button></a>";
  }
  return $html;
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Bewertungsfenster ausgeben
// ++++++++++++++++++++++++++++++++++++++

function sem_f035($dir,$cid,$imgid) {
  $config = &JComponentHelper::getParams('com_seminar');
  if(sem_f042()>1) {
    $image = "240".$imgid;
    $titel = JTEXT::_('SEM_1020');
    $href = JURI::ROOT()."index2.php?s=".sem_f036()."&option=".JRequest::getCmd('option')."&cid=".$cid."&task=20";
    $x = 500;
    $y = 280;
    return "<a title=\"".JTEXT::_('SEM_1020')."\" class=\"modal\" href=\"".JURI::ROOT()."index2.php?s=".sem_f036()."&option=".JRequest::getCmd('option')."&cid=".$cid."&task=20"."\" rel=\"{handler: 'iframe', size: {x: ".$config->get('sem_p097',500).", y: ".$config->get('sem_p098',350)."}}\"><img id=\"graduate".$cid."\" src=\"".$dir."240".$imgid.".png\" border=\"0\" align=\"absmiddle\"></a>";
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
    if( ($art>1 AND $config->get('sem_p005',0)>0) OR ($art==1 AND $config->get('sem_p006',0)>0 AND $config->get('sem_p007',0)>0)) {
      if($knopf=="") {
        return "<a title=\"".$titel."\" class=\"modal\" href=\"".$href."\" rel=\"{handler: 'iframe', size: {x: ".$config->get('sem_p097',500).", y: ".$config->get('sem_p098',350)."}}\">".sem_f045($image)."</a>";
      } else {
        return "<a class=\"modal\" href=\"".$href."\" rel=\"{handler: 'iframe', size: {x: ".$config->get('sem_p097',500).", y: ".$config->get('sem_p098',350)."}}\"><button class=\"button\" style=\"cursor:pointer;\" type=\"button\">".sem_f045($image)."&nbsp;".$titel."</button></a>";
      }
    } else if( $art==1 AND $config->get('sem_p006',0)>0 ) {
      return "\n".sem_f045("2900");
    }
//  }
}
  
// ++++++++++++++++++++++++++++++++++++++
// +++ Druckfenster im Backend ausgeben
// ++++++++++++++++++++++++++++++++++++++

function sem_f038($art,$cid) {
  $config = &JComponentHelper::getParams('com_seminar');
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
    $html = "<a title=\"".$title."\" class=\"modal\" href=\"".$href."\" rel=\"{handler: 'iframe', size: {x: ".$config->get('sem_p097',500).", y: ".$config->get('sem_p098',350)."}}\">";
  } else {
    $html = "<a title=\"".$title."\" href=\"".$href."\">";
  }
  $html .= sem_f045($image,$title)."</a>";
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
  return "\n".sem_f023(0)."<tr>".sem_f022($seite,'d','l','','').sem_f022($navi,'d','c','','').sem_f022($kurse,'d','r','','')."</tr>".sem_f023('e');
}

// ++++++++++++++++++++++++++++++++++++++++++++++++++++
// +++  Auswahlliste Limitbox fuer Seitennavigation +++
// ++++++++++++++++++++++++++++++++++++++++++++++++++++

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
  
// ++++++++++++++++++++++++++++++++++++++++++++++
// +++ Auswahlliste Art der angezeigten Kurse +++
// ++++++++++++++++++++++++++++++++++++++++++++++

function sem_f041($dateid) {
  $allekurse = array();
  $allekurse[] = JHTML::_('select.option', '0', JTEXT::_('SEM_0028') );
  $allekurse[] = JHTML::_('select.option', '1', JTEXT::_('SEM_0039') );
  $allekurse[] = JHTML::_('select.option', '2', JTEXT::_('SEM_0037') );
  return JHTML::_('select.genericlist',$allekurse,"dateid","class=\"sem_inputbox\" size=\"1\" onchange=\"document.FrontForm.limitstart.value=0;document.FrontForm.submit();\"","value","text",$dateid);
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
  $dezstellen = $config->get('sem_p061',2);
  $dezseparator = $config->get('sem_p063',JTEXT::_('SEM_0119'));
  $tauseparator = $config->get('sem_p062',JTEXT::_('SEM_0120'));
  return number_format($betrag,$dezstellen,$dezseparator,$tauseparator);
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Bild ausgeben                  +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f045() {
  $args = func_get_args();
  $apos = strpos($args[0],"http");
  $bpos = strpos($args[0],"/");
  $cpos = strpos($args[0],".");
  if((is_int($apos) AND ($apos==0)) OR (is_int($bpos) AND ($bpos==0)) OR (is_int($cpos) AND ($cpos==0))) {
    $image = $args[0];
  } else {
    $image = sem_f006().$args[0].".png";
  }
  $text = "";
  if(count($args)>1) {
    $text = $args[1];
  }
  $param = array('border'=>'0','align'=>'absmiddle',title=>$text);
  if(count($args)>2) {
    $param = $args[2];
  }
  return JHTML::_('image',$image,$text,$param);
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
// +++ aktuelle Layoutangaben laden   +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f047() {
  $database = &JFactory::getDBO();
  $database->setQuery( "SELECT * FROM #__semlayouts WHERE chosen= '1'");
  return $database->loadObject();
}

// ++++++++++++++++++++++++++++++++++
// +++ CSV-Datei Buchungen senden +++
// ++++++++++++++++++++++++++++++++++

function sem_f048() {
  $database = &JFactory::getDBO();
  $config = &JComponentHelper::getParams('com_seminar');
  $cid = trim(JRequest::getVar('cid',''));
  $separator = $config->get('sem_p103',';');
  $csvdaten = array();
  $kurs = new mosSeminar($database);
  $kurs->load( $cid );
  $database->setQuery( "SELECT a.*, cc.*, a.id AS sid, a.name AS aname, a.email AS aemail, cc.name AS uname, cc.email AS uemail 
                        FROM #__sembookings AS a LEFT JOIN #__users AS cc ON cc.id = a.userid 
                        WHERE a.semid = '$kurs->id' ORDER BY a.id");
  $rows = $database->loadObjectList();
  if ($database->getErrorNum()) {
    echo $database->stderr();
    return false;
  }

// Spaltenkoepfe ausgeben
  $daten = array();
  $daten[] = "\"#\"";
  $daten[] = "\"".JTEXT::_('SEM_0097')."\"";
  $daten[] = "\"".JTEXT::_('SEM_0190')."\"";
  $daten[] = "\"".JTEXT::_('SEM_0052')."\"";
  $daten[] = "\"".JTEXT::_('SEM_0032')."\"";
  $daten[] = "\"".JTEXT::_('SEM_0034')."\"";
  $daten[] = "\"".JTEXT::_('SEM_0033')."\"";
  $daten[] = "\"".JTEXT::_('SEM_0069')."\"";
  if($kurs->fees>0) {
    $daten[] = "\"".JTEXT::_('SEM_0065')."\"";
  }
  if($config->get('sem_p003',0)>0) {
    $daten[] = "\"".JTEXT::_('SEM_0040')."\"";
  }
  if($config->get('sem_p004',0)>0) {
    $daten[] = "\"".JTEXT::_('SEM_0055')."\"";
    $daten[] = "\"".JTEXT::_('SEM_0042')."\"";
  }
  $zusatz = sem_f017($kurs);
  foreach($zusatz[0] AS $el) {
    if($el!="") {
      $el = explode("|",$el);
      $daten[] = "\"".str_replace("\"","'",$el[0])."\"";
    }
  }
  $request = sem_f068($kurs);
  foreach($request[0] AS $el) {
    if($el!="") {
      $el = explode("|",$el);
      $daten[] = "\"".str_replace("\"","'",$el[0])."\"";
    }
  }
  $csvdata = implode($separator,$daten)."\r\n";

// Zellenwerte ausgeben
  $summe = 0;
  $i = 0;
  foreach($rows AS $row) {
    if($row->userid==0) {
      $tempname = $row->aname;
      $tempemail = $row->aemail;
    } else {
      $tempname = $row->name;
      $tempemail = $row->email;
    }
    if (empty($tempname)) {
      $tempname = $row->uname;
    }
    if (empty($tempemail)) {
      $tempemail = $row->uemail;
    }
    if (empty($tempname)) {
      $tempname = $row->aname;
    }
    if (empty($tempemail)) {
      $tempemail = $row->aemail;
    }
    $summe = $summe + $row->nrbooked;
    $temp = JTEXT::_('SEM_0030');
    if( $summe > $kurs->maxpupil ) {
      if( $kurs->stopbooking < 1 ) {
        $temp = JTEXT::_('SEM_0025');
      } else {
        $temp = JTEXT::_('SEM_0029');
      }
    }
    $daten = array();
    $daten[] = "\"".sem_f002($row->sid)."\"";
    $daten[] = "\"".str_replace("\"","'",$tempname)."\"";
    $daten[] = "\"".$tempemail."\"";
    $daten[] = "\"".JHTML::_('date',$row->bookingdate,$config->get('sem_p069',JTEXT::_('SEM_0169')),0)."\"";
    $daten[] = "\"".JHTML::_('date',$row->bookingdate,$config->get('sem_p070',JTEXT::_('SEM_0170')),0)."\"";
    $daten[] = "\"".$row->nrbooked."\"";
    $daten[] = "\"".$temp."\"";
    if( $kurs->fees > 0) {
      $temp = JTEXT::_('SEM_0006');
      if($row->paid == 1) {
        $temp = JTEXT::_('SEM_0005');
      }
      $daten[] = "\"".$temp."\"";
    }
    if($config->get('sem_p003',0)>0) {
      $temp = JTEXT::_('SEM_0006');
      if($row->certificated == 1) {
        $temp = JTEXT::_('SEM_0005');
      }
      $daten[] = "\"".$temp."\"";
    }
    if($config->get('sem_p004',0)>0) {
      $daten[] = "\"".$row->grade."\"";
      $daten[] = "\"".str_replace("\"","'",$row->comment)."\"";
    }
    $zusatzwerte = sem_f017($row);
    for ($l=0,$m=count($zusatzwerte[0]);$l<$m;$l++) {
      if($zusatz[0][$l]!="") {
        $daten[] = "\"".str_replace("\"","'",$zusatzwerte[0][$l])."\"";
      }
    }
    $database->setQuery("SELECT * FROM #__semattendees WHERE sembid='$row->sid'");
    $attendees = $database->loadObjectList();
    if(count($attendees)>0) {
      foreach($attendees AS $attendee) {
        $atdaten = array();
        $zusatzwerte = sem_f068($attendee);
        for ($l=0,$m=count($zusatzwerte[0]);$l<$m;$l++) {
          if($request[0][$l]!="") {
            $atdaten[] = "\"".str_replace("\"","'",$zusatzwerte[0][$l])."\"";
          }
        }
        $i++;
        $csvdata .= "\"".$i."\"".$separator.implode($separator,$daten).$separator.implode($separator,$atdaten)."\r\n";
      }
    } else {
      $i++;
      $csvdata .= "\"".$i."\"".$separator.implode($separator,$daten)."\r\n";
    }
  }
  $konvert = $config->get('sem_p015',JTEXT::_('SEM_0164'));
  $csvdata = iconv("UTF-8",$konvert."//TRANSLIT",$csvdata);
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
  $database = &JFactory::getDBO();
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
    if($row->nrbooked>1) {
      $body .= "\n<tr><td>".JTEXT::_('SEM_0033').": </td><td>".$buchung->nrbooked."</td></tr>";
    }
    // do we use request fields per attendee?
    $requestfields = sem_f068($row);
    // do we use request fields per attendee?
    if($requestfields[0][0]!="") {
      $database->setQuery("SELECT request1,request2,request3,request4,request5,request6,request7,request8,request9,request10,request11,request12,request13,request14,request15,request16,request17,request18,request19,request20 from #__semattendees WHERE sembid=".$buchung->id." ORDER BY ordering");
      $requests = $database->loadObjectList();
      for ($j=0; $j < $buchung->nrbooked; $j++) {
        $requested=array($requests[$j]->request1,$requests[$j]->request2,$requests[$j]->request3,$requests[$j]->request4,$requests[$j]->request5,$requests[$j]->request6,$requests[$j]->request7,$requests[$j]->request8,$requests[$j]->request9,$requests[$j]->request10,$requests[$j]->request11,$requests[$j]->request12,$requests[$j]->request13,$requests[$j]->request14,$requests[$j]->request15,$requests[$j]->request16,$requests[$j]->request17,$requests[$j]->request18,$requests[$j]->request19,$requests[$j]->request20);
        $body .= "\n<tr><td>".JTEXT::_('SEM_0082')." ".($j+1).": </td><td>";
        for ($i=0; $i < 20; $i++) {
          if (!empty($requested[$i])) {
            $reqart = explode("|",$requestfields[0][$i]);
            if (!empty($reqart[0])) {
              $body .= $reqart[0];
            }
            $body .= $requested[$i];
            if ($requestfields[2][$i] == '1') {
              $body .= "<br />";
            } else {
              $body .= "&nbsp;";
            }
          }
        }
        $body .= "</td></tr>";
      }
    }    
    // zusatzfelder
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

function sem_f050($seminarid,$benutzerid,$art) {
  jimport('joomla.mail.helper');
  $mainframe = JFactory::getApplication();
  $config = &JComponentHelper::getParams('com_seminar');
  if( $config->get('sem_p010',0)>0 OR $config->get('sem_p009',0)>0 ) {  
    $database = &JFactory::getDBO();
    $database->setQuery("SELECT * FROM #__seminar WHERE id='$seminarid'");
    $rows = $database->loadObjectList();
    $row = &$rows[0];
    $database->setQuery("SELECT * FROM #__sembookings WHERE id='$benutzerid'");
    $rows = $database->loadObjectList();
    if(isset($rows[0]->userid) and $rows[0]->userid==0) {
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
//      Buchung durch Benutzer
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
//      Buchung durch Benutzer storniert
        $body1 .= JTEXT::_('SEM_1023');
        $body2 .= JTEXT::_('SEM_1025');
        break;
      case 3:
//      Buchung durch Veranstalter storniert
        $body1 .= JTEXT::_('SEM_0072');
        $body2 .= JTEXT::_('SEM_0073');
        break;
      case 6:
//      Veranstaltung zertifiziert
        $body1 .= JTEXT::_('SEM_0071');
        $body2 .= JTEXT::_('SEM_0081');
        if($config->get('sem_p006',0)>0) {
          $body1 .= " ".JTEXT::_('SEM_0078');
        }
        break;
      case 7:
//      Zertifikat antzogen
        $body1 .= JTEXT::_('SEM_0075');
        $body2 .= JTEXT::_('SEM_0077');
        break;
      case 8:
//      Buchung durch Veranstalter
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
      case 11:
//      Buchung bezahlt
        $body1 .= JTEXT::_('SEM_0177');
        $body2 .= JTEXT::_('SEM_0178');
        break;
      case 12:
//      Bezahlung storniert
        $body1 .= JTEXT::_('SEM_0179');
        $body2 .= JTEXT::_('SEM_0180');
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
    
    $bcc = $config->get('sem_p102','');
    if($config->get('sem_p010',0)>0 OR $art<11) {
      $replyname = $publisher->name;
      $replyto = $publisher->email;
      $email = $user->email;
      $body = $abody.$body1.sem_f049($row, $rows[0], $user);
      JUtility::sendMail($from, $sender, $email, $subject, $body, 1, $bcc, $bcc, null, $replyto, $replyname);
    }
    if($config->get('sem_p009',0)>0 AND $art<11) {
      $replyname = $user->name;
      $replyto = $user->email;
      $email = $publisher->email;
      $body = $abody.$body2.sem_f049($row, $rows[0], $user);
      JUtility::sendMail($from, $sender, $email, $subject, $body, 1, $bcc, $bcc, null, $replyto, $replyname);
    }
  }
}


// +++++++++++++++++++++++++++++++++++++++++++++++
// +++ Ausdruck des Zertifikats                +++
// +++++++++++++++++++++++++++++++++++++++++++++++

function sem_f051($cid) {
  $database = &JFactory::getDBO();
  $database->setQuery( "SELECT * FROM #__sembookings WHERE uniqid='$cid'" );
  $buchungswerte = $database->loadObject();
  $database->setQuery( "SELECT * FROM #__seminar WHERE id='$buchungswerte->semid'" );
  $row = $database->loadObject();
  $html = "\n<body onload=\" parent.sbox-window.focus(); parent.sbox-window.print(); \">";
  $layout = sem_f047();
  $html .= $layout->certificate."</body></html>";
  echo sem_f054($html,$row,3,$buchungswerte);
  exit;
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Ausdruck der Bucherliste       +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f052($art) {
  $database = &JFactory::getDBO();
  $config = &JComponentHelper::getParams('com_seminar');
  $neudatum = sem_f046();
  $cid = trim(JRequest::getVar('cid', '' ));
  $kurs = new mosSeminar($database);
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
// sem_f054(text,row,art,userid)
// art 0 = Kurs aus Uebersicht Veranstaltungen
// art 1 = Kurs aus Uebersicht Meine Buchungen
// art 2 = Kurs aus Uebersicht Meine Angebote
// art 3 = Detailansicht aus Uebersicht Veranstaltungen (Selbstbucher)
// art 4 = Detailansicht aus Uebersicht Meine Buchungen (Selbstbucher)
// art 5 = Detailansicht Kurs gebucht aus Uebersicht Veranstaltungen (Selbstbucher)
// art 6 = Detailansicht aus Uebersicht Meine Angebote (Fremdbucher)

function sem_f054() {
  $args = func_get_args();
  $database = &JFactory::getDBO();
  $config = &JComponentHelper::getParams('com_seminar');

// uebergebene Parameter ermitteln
  $html = $args[0];
  $html = preg_replace("/\n/s", "<!>", $html);
  $reqfield = " <span class=\"sem_reqfield\">*</span>";
  $row = $args[1];
  $art = 0;
  if(count($args)>2) {
    $art = $args[2];
  }

// Benutzer und Buchungswerte ermitteln
  $userid = 0;
  if(count($args)>3) {
    $userid = $args[3];
    if($userid=="") {
      $userid = 0;
    }
  }
  $ueberschrift = array();
  if(count($args)>4) {
    $ueberschrift = $args[4];
  }
  $buchungsid = 0;
  if(!is_numeric($userid)) {
    if($userid->userid>0) {
      $user = &JFactory::getuser($userid->userid);
      $buchungswerte = $userid;
    } else {
      $user->name = $userid->name;
      $user->email = $userid->email;
      $user->id = 0;
      $database->setQuery("SELECT * FROM #__sembookings WHERE id='$userid->id'");
      $buchungswerte = $database->loadObject();
    }
  } else {
    if($userid>0) {
      $user = &JFactory::getuser($userid);
    } else {
      $user = &JFactory::getuser();
      $userid = $user->id;
      if($userid==0) {
        $userid = -1;
      }
    }
    $database->setQuery("SELECT * FROM #__sembookings WHERE semid='$row->id' AND userid='$userid'");
    $buchungswerte = $database->loadObject();
  }

// Veranstalter ermitteln
  $organizer = &JFactory::getuser($row->publisher);

// Aktuelles Datum ermitteln
  $neudatum = sem_f046();

// Kategorienamen ermitteln
  $category = sem_f012($row->catid);

// gebuchte Plaetze und Buchungen ermitteln
  $buchung = sem_f020($row,$userid);

// Eingabefelder abschalten
  $tempdis = " disabled";
  $buchbar = sem_f079($row,$user->id,$buchung->free,$buchungswerte->id,$config);
  if(
    (
      ($buchbar 
        OR ($art==4 
          AND $config->get('sem_p022',"")==1 
          AND $buchungswerte->paid==0 
          AND strtotime("$row->booked")-time()>=($config->get('sem_p018',0)*24*60*60)
        )
      )
      AND $art!=5
    )
    OR $art==6
    ) {
    $tempdis = "";
  }

// Werte fuer die verschiedenen Darstellungen ermitteln
  $zusimage = "";
  $zusbild = 0;
  $linksbild = "2601";
  $statusbild = 2;
  switch($art) {
    case 1: case 4: case 5: case 7:
//    Veranstaltung aus dem Reiter "Meine Buchungen"
      $funktion = array(JTEXT::_('SEM_0014'),4);
      $zusimage = "2606";
      $statustext = JTEXT::_('SEM_0030');
      if($buchung->booked > $row->maxpupil) {
        if ($row->stopbooking==1) {
          $statusbild = 0;
          $statustext = JTEXT::_('SEM_0029');
        } elseif($buchung->waitinglistspace > $row->maxpupil) {
          $statusbild = 1;
          $statustext = JTEXT::_('SEM_0025');
        }
      }
      if($row->cancelled==1) {
        $statusbild = 0;
        $statustext = JTEXT::_('SEM_0088');
      }
      $feedbacklink = "<a title=\"".JTEXT::_('SEM_1020')."\" class=\"modal\" href=\"".JURI::ROOT()."index2.php?s=".sem_f036()."&amp;option=".JRequest::getCmd('option')."&amp;cid=".$row->id."&amp;task=20"."\" rel=\"{handler: 'iframe', size: {x: ".$config->get('sem_p097',500).", y: ".$config->get('sem_p098',350)."}}\"><img id=\"graduate".$row->id."\" src=\"".sem_f006()."240".$buchungswerte->grade.".png\" border=\"0\" align=\"absmiddle\"></a>";
      break;
    case 2:
//    Veranstaltung aus dem Reiter "Meine Angebote"
      $funktion = array(JTEXT::_('SEM_0051'),9);
      if($row->publisher==$user->id) {
        $zusimage = "2607";
      }
      $statustext = JTEXT::_('SEM_0045');
      if( $neudatum > $row->end ) {
        $statusbild = 0;
        $statustext = JTEXT::_('SEM_0046');
      } else if( $neudatum > $row->begin ) {
        $statusbild = 1;
        $statustext = JTEXT::_('SEM_0047');
      }
      $feedbacklink = sem_f045("240".$row->grade,JTEXT::_('SEM_0055'));
      break;
    case 3: case 6: default:
//    Veranstaltung aus dem Reiter "Veranstaltungen"
      if($user->id == $row->publisher) {
        $zusimage = "2607";
      }
      if($buchungswerte->id > 0) {
        $zusimage = "2606";
      }
      $funktion = array(JTEXT::_('SEM_0014'),3);
      $statustext = JTEXT::_('SEM_0031');
      if($neudatum>$row->booked) {
        $statusbild = 0;
        $statustext = JTEXT::_('SEM_1010');
      } else if($row->cancelled==1 OR ($buchung->free<1 AND $row->stopbooking==1) OR ($user->id==$row->publisher AND $config->get('sem_p002',0)==0)) {
        $statusbild = 0;
        $statustext = JTEXT::_('SEM_0088');
      } else if($buchung->free<1 AND ($row->stopbooking!=1)) {
        $statusbild = 1;
        $statustext = JTEXT::_('SEM_0036');
      }
      if($buchungswerte->id>0) {
        $statusbild = 0;
        $statustext = JTEXT::_('SEM_1007');
      }
      $feedbacklink = sem_f045("240".$row->grade,JTEXT::_('SEM_0055'));
      break;
  }
  if($user->id==0) {
    $zusimage = "";
  }
  if($row->cancelled==1) {
    $zusimage = "2200";
  }
  if($row->catimage!="") {
    $linksbild = sem_f007(0).$row->catimage;
  }
  if($row->image!="" AND $config->get('sem_p032','')==1) {
    $linksbild = sem_f007(1).$row->image;
  }

// Dateien vorbereiten
  $datfeld = sem_f060($row);
  $dateien = array();
  for($i=0;$i<count($datfeld[0]);$i++) {
    if($datfeld[0][$i]!="" AND ($datfeld[2][$i]==0 OR ($user->id>0 AND $datfeld[2][$i]==1) OR ($buchungswerte->id>0 AND $datfeld[2][$i]==2) OR ($buchungswerte->paid==1 AND $datfeld[2][$i]==3))) {
      $temp = "<span style=\"background-image:url(".sem_f006()."0002.png);background-repeat:no-repeat;background-position:2px;padding-left:18px;vertical-align:middle;\" ><a href=\"".sem_f004()."index2.php?s=".sem_f036()."&amp;option=".JRequest::getCmd('option')."&amp;task=34&amp;a6d5dgdee4cu7eho8e7fc6ed4e76z=".sha1(md5($datfeld[0][$i])).$row->id."\">".$datfeld[0][$i]."</a>";
      if($datfeld[1][$i]!="") {
        $temp .= "<br />".$datfeld[1][$i]."</span>";
      }
      $dateien[] = $temp;
    }
  }
  $files = "";
  if(count($dateien)>0) {
    $files = implode("<br />",$dateien);
  }

// AGB vorbereiten
  $agbs = "";
  $agbtext = "";
  $agburl = "";
  $tempagb = trim($config->get('sem_p020',""));
  if($tempagb!="") {
    $agbtext = $tempagb;
    $temp1 = "<input class=\"sem_inputbox\" type=\"checkbox\" name=\"veragb\" value=\"1\"";
    if($buchungswerte->id>0) {
      $temp1 .= " checked=\"checked\"";
    }
    $temp1 .= $tempdis.">".$reqfield;
    $pos = strpos($tempagb,"http");
    if($pos===false OR $pos>0) {
      $agburl = JURI::ROOT()."index2.php?s=".sem_f036()."&option=".JRequest::getCmd('option')."&task=27";
    } else {
      $agburl = $tempagb;
      $agbtext = str_replace("SEM_TANDC_URL",$agburl,JTEXT::_('SEM_0201'));
    }
    $temp2 = "<a href=\"".$agburl."\" class=\"modal\" rel=\"{handler: 'iframe', size: {x: ".$config->get('sem_p097',500).", y: ".$config->get('sem_p098',350)."}}\">".JTEXT::_('SEM_1043')."</a>";
    $temp2 = str_replace("SEM_TANDC_LINK",$temp2,JTEXT::_('SEM_1042'));
    $agbs .= $temp1." ".$temp2;
  }

// Zusatzfelder vorbereiten
  $zusfelder = "";
  $zusfelderval = "";
  $zusfeldnotag = "";
  $zusfeldist = sem_f017($row);
  $zfleer = 1;
  foreach($zusfeldist[0] AS $el) {
    if($el!="") {
      $zfleer = 0;
      break;
    }
  }
  // registrierte Benutzer bei Zubuchung durch Veranstalter
  $reqtemp = $reqfield;
  $textname = JTEXT::_('SEM_0174');
  $textemail = JTEXT::_('SEM_0158');
  $divzu = "<br />";
  if($art==6) {
    $textname = JTEXT::_('SEM_0191');
    $textemail = JTEXT::_('SEM_0192');
    $reguserexpr = JTEXT::_('SEM_0152');
    if($user->id==0) {
      if($buchungswerte->id==0) {
        $nametemp = sem_f011($row);
      }
    } else {
      $nametemp = $user->name;
    }
    if($nametemp!="") {
      $textoder = "";
      $textunreg = "";
      if($config->get('sem_p026',0)>0 AND $buchungswerte->id==0) {
        $textoder = JTEXT::_('SEM_0186')."<div class=\"sem_attendeediv\" id=\"\" style=\"display: block;\">";
        $textunreg = JTEXT::_('SEM_0086').": <br />";
        $reqtemp = "";
        $divzu = "</div>";
      }
      $reguserexpr .= $reqtemp.":<br />";
      $zusfelder .= $textoder.$reguserexpr.$nametemp."<br />".$textunreg;
    }
  }
  // Name und Email bei unangemeldeten Usern
  if($config->get('sem_p026',0)>0 AND $user->id==0 AND $row->cancelled==0) {
    $zusfelder .= $textname.$reqtemp.": <input type=\"text\" class=\"sem_inputbox\" id=\"name\" name=\"name\" value=\"".$buchungswerte->name."\" size=\"40\"".$tempdis."><br />";
    $zusfelder .= $textemail.$reqtemp.": <input type=\"text\" class=\"sem_inputbox\" id=\"email\" name=\"email\" value=\"".$buchungswerte->email."\" size=\"40\"".$tempdis.">".$divzu;
    $zusfelderval .= $textname.": ".$buchungswerte->name."<br />";
    $zusfeldnotag .= $textname.": ".$buchungswerte->name."<br />";
    $zusfelderval .= $textemail.": ".$buchungswerte->email."<br />";
    $zusfeldnotag .= $textemail.": ".$buchungswerte->email."<br />";
  }
  // restliche Zusatzfelder
  if($zfleer==0) {
    $zusfelderad = "";
    $zusfeldervalad = "";
    $zuswerte = array($buchungswerte->zusatz1,$buchungswerte->zusatz2,$buchungswerte->zusatz3,$buchungswerte->zusatz4,$buchungswerte->zusatz5,$buchungswerte->zusatz6,$buchungswerte->zusatz7,$buchungswerte->zusatz8,$buchungswerte->zusatz9,$buchungswerte->zusatz10,$buchungswerte->zusatz11,$buchungswerte->zusatz12,$buchungswerte->zusatz13,$buchungswerte->zusatz14,$buchungswerte->zusatz15,$buchungswerte->zusatz16,$buchungswerte->zusatz17,$buchungswerte->zusatz18,$buchungswerte->zusatz19,$buchungswerte->zusatz20);
    for($i=0;$i<count($zusfeldist[0]);$i++) {
      if($zusfeldist[0][$i]!="") {
        $zuszwang = "";
        $zwang = 0;
        $zusart = explode("|",$zusfeldist[0][$i]);
        if($buchungswerte->id==0) {
          $zuswerte[$i] = $zusart[2];
        }
        if($zusart[1]==1) {
          $zuszwang .= $reqfield;
          $zwang = 1;
        }
        if(strtolower($zusart[3])=="hidden") {
          $zusfelderad .= sem_f076($zusart,$zuswerte[$i],"zusatz",($i+1),$row->id,$tempdis,$zwang);
        } else {
          $zusfelderad .= " ".$zusart[0].$zuszwang.sem_f055($zusfeldist[1][$i])." ".sem_f076($zusart,$zuswerte[$i],"zusatz",($i+1),$row->id,$tempdis,$zwang);
          $zusfeldervalad .= $zusart[0]." ".$zuswerte[$i];
        }
        $zusfeldnotag .= $zusart[0]." ".$zuswerte[$i]."<br />";
        if($zusfeldist[2][$i]==1) {
          $zusfelderad .= "<br />";
          $zusfeldervalad .= "<br />";
        }
      }
    }
    if($zusfelderad !="" AND $zusfelder!="") {
      $zusfelder .= "<div class=\"sem_attendeediv\" id=\"\" style=\"display: block;\">".$zusfelderad."</div>";
      $zusfelderval .= "<div class=\"sem_attendeediv\" id=\"\" style=\"display: block;\">".$zusfeldervalad."</div>";
    } else {
      $zusfelder = $zusfelderad;
      $zusfelderval = $zusfeldervalad;
    }
  }
  
// Requestfelder vorbereiten
  $reqfelder = "";
  $reqfelderval = "";
  $reqfeldnotag .= "";
  $reqfeldist = sem_f068($row);
  $zrleer = 1;
  foreach($reqfeldist[0] AS $el) {
    if($el!="") {
      $zrleer = 0;
      break;
    }
  }
  if($row->nrbooked <= 1 OR $config->get('sem_p023','')<1) {
    $platzauswahl = "";
  } else {
    if($art==3 OR ($art==6 AND $user->id==0)) {
      $tempplaetze = $buchung->free;
      $tempplatz = $buchungswerte->nrbooked;
    } else {
      $tempplatz = $buchungswerte->nrbooked;
      $tempplaetze = $buchung->free + $tempplatz;
    }
    if($tempplaetze>$row->nrbooked OR ($row->stopbooking==0 AND $art==3) OR ($art==6 AND $user->id==0)) {
      $tempplaetze = $row->nrbooked;
    }
    if ($zrleer==1) {
      $limits = array();
      for( $i=1; $i<=$tempplaetze; $i++) {
        $limits[] = JHTML::_('select.option',$i);
      }
      $platzauswahl = JHTML::_('select.genericlist', $limits, 'nrbooked','class="sem_inputbox" size="1" id="RequestedRecords" onChange="calcamount();"'.$tempdis, 'value', 'text', $tempplatz);
    } else {
      $tempplatz = $buchungswerte->nrbooked;
      if($tempplatz<1) {
        $tempplatz = 1;
      }
      if($tempdis=="") {
        $platzauswahl = "<input class=\"sem_inputbox\" id=\"RequestedRecords\" name=\"nrbooked\" onFocus=\"blur();\" type=\"text\" maxlength=\"".$tempplaetze."\" value=\"".$tempplatz."\" size=\"1\" style=\"text-align:right;\"".$tempdis." />";
        $platzauswahl .= "<input class=\"button\" style=\"cursor:pointer;\" type=\"button\" id=\"addRequest\" onClick=\"addRecord('templateRequestRecord','insertRequestRecord','RequestedRecords');\" value=\" &#43; \"".$tempdis."/> (max. ".$tempplaetze.")";
      } else {
        $platzauswahl = "<input class=\"sem_inputbox\" type=\"text\" value=\"".$buchungswerte->nrbooked."\" size=\"1\" style=\"text-align:right;\"".$tempdis." name=\"nrbooked\" />";
      }
    }
  }
  if($platzauswahl!="") {
    $reqfelder .= $platzauswahl;
    $reqfelderval .= $buchungswerte->nrbooked;
  }
  if($zrleer==0) {
    if($buchungswerte->id>0) {
      $database->setQuery("SELECT request1,request2,request3,request4,request5,request6,request7,request8,request9,request10,request11,request12,request13,request14,request15,request16,request17,request18,request19,request20 from #__semattendees WHERE sembid=".$buchungswerte->id." ORDER BY ordering");
      $requests = $database->loadObjectList();
      for ($i=0; $i < $buchungswerte->nrbooked; $i++) {
        $reqfelder .= "\n<div class=\"sem_attendeediv\" id=\"\" style=\"display: block;\">\n<span class=\"sem_attendeehead\">".JTEXT::_('SEM_0082')." ".($i+1)."</span>";
        $reqfelderval .= "\n<div class=\"sem_attendeediv\" id=\"\" style=\"display: block;\">\n<span class=\"sem_attendeehead\">".JTEXT::_('SEM_0082')." ".($i+1)."</span>";
        if($i>0) {
          $reqfelder .= " <input class=\"button\" style=\"cursor:pointer;\" type=\"button\" value=\" &ndash; \" onclick=\"delRecord(this.parentNode,'RequestedRecords',1);\" $tempdis />";
          $reqfeldnotag .= "<br />\n";
        }
        $requested = array($requests[$i]->request1,$requests[$i]->request2,$requests[$i]->request3,$requests[$i]->request4,$requests[$i]->request5,$requests[$i]->request6,$requests[$i]->request7,$requests[$i]->request8,$requests[$i]->request9,$requests[$i]->request10,$requests[$i]->request11,$requests[$i]->request12,$requests[$i]->request13,$requests[$i]->request14,$requests[$i]->request15,$requests[$i]->request16,$requests[$i]->request17,$requests[$i]->request18,$requests[$i]->request19,$requests[$i]->request20);
        $reqfeldbeide = sem_f069($reqfeldist,$requested,$i+1,$tempdis,$row->id);
        $reqfelder .= "<br />\n".$reqfeldbeide[0]."</div>\n";
        $reqfelderval .= "<br />\n".$reqfeldbeide[1]."</div>\n";
        $reqfeldnotag .= $reqfeldbeide[2];
      }
    } else {
    // Leere Requestfelder ausgeben
      $reqfelder .= "\n<div class=\"sem_attendeediv\" id=\"\" style=\"display: block;\">\n<span class=\"sem_attendeehead\">".JTEXT::_('SEM_0082')."</span>";
      $reqfeldbeide = sem_f069($reqfeldist,$reqfeldist[3],1,$tempdis,$row->id);
      $reqfelder .= "<br />\n".$reqfeldbeide[0]."</div>\n";
    }
    // Neues Teilnehmertemplate erzeugen
    $reqfelder .= "\n<span id=\"insertRequestRecord\"></span>\n";
    $reqfelder .= "<div class=\"sem_attendeediv\" id=\"templateRequestRecord\" style=\"display: none\">\n";
    $reqfelder .= "\n<span class=\"sem_attendeehead\">".JTEXT::_('SEM_0082')."</span> <input class=\"button\" style=\"cursor:pointer;\" type=\"button\" value=\" &ndash; \" onclick=\"delRecord(this.parentNode,'RequestedRecords',1);\" $tempdis />";
    $reqfeldbeide = sem_f069($reqfeldist,$reqfeldist[3],"",$tempdis,$row->id);
    $reqfelder .= "<br />\n".$reqfeldbeide[0]."</div>\n";
  }

// Zuerst Beschreibungsfelder ersetzen
  $html = str_replace('SEM_SHORTDESCRIPTION_NOTAGS',sem_f018($row->shortdesc),$html);
  $html = str_replace('SEM_DESCRIPTION_NOTAGS',sem_f018($row->description),$html);
  $html = str_replace('SEM_SHORTDESCRIPTION',$row->shortdesc,$html);
  $html = str_replace('SEM_DESCRIPTION',$row->description,$html);

// Ausgabe parsen
  $parser = array();
  if($zusfelder!="") {
    $parser[] = "sem_bookerinput";
  } else {
    $parser[] = "sem_!bookerinput";
  }
  if($reqfelder!="") {
    $parser[] = "sem_attendeeinput";
  } else {
    $parser[] = "sem_!attendeeinput";
  }
  if($agbs!="") {
    $parser[] = "sem_tandc";
  } else {
    $parser[] = "sem_!tandc";
  }
  if($zusfelder!="" OR $reqfelder!="" OR $agbs!="") {
    $parser[] = "sem_requiredfields";
  } else {
    $parser[] = "sem_!requiredfields";
  }
  if($buchungswerte->certificated==1) {
    $parser[] = "sem_certificated";
  } else {
    $parser[] = "sem_!certificated";
  }
  if($buchungswerte->paid==1) {
    $parser[] = "sem_paid";
  } else {
    $parser[] = "sem_!paid";
  }
  if($buchungswerte->id>0) {
    $parser[] = "sem_booked";
  } else {
    $parser[] = "sem_!booked";
  }
  if($user->id>0) {
    $parser[] = "sem_logedin";
  } else {
    $parser[] = "sem_!logedin";
  }
  if($neudatum>=$row->begin AND $neudatum<$row->end) {
    $parser[] = "sem_running";
  } else {
    $parser[] = "sem_!running";
  }
  if($neudatum>=$row->begin) {
    $parser[] = "sem_started";
  } else {
    $parser[] = "sem_!started";
  }
  if($neudatum>=$row->end) {
    $parser[] = "sem_ended";
  } else {
    $parser[] = "sem_!ended";
  }
  if($neudatum>=$row->booked) {
    $parser[] = "sem_closed";
  } else {
    $parser[] = "sem_!closed";
  }
  if($row->cancelled==1) {
    $parser[] = "sem_canceled";
  } else {
    $parser[] = "sem_!canceled";
  }
  if($row->nrbooked>0) {
    $parser[] = "sem_bookableonline";
  } else {
    $parser[] = "sem_!bookableonline";
  }
  if($buchung->free==0) {
    $parser[] = "sem_soldout";
  } else {
    $parser[] = "sem_!soldout";
  }
  if($buchung->booked>0) {
    $parser[] = "sem_spacesbooked";
  } else {
    $parser[] = "sem_!spacesbooked";
  }
  if($row->nrbooked>1) {
    $parser[] = "sem_severalbookable";
  } else {
    $parser[] = "sem_!severalbookable";
  }
  if($row->target!="") {
    $parser[] = "sem_targetgroup";
  } else {
    $parser[] = "sem_!targetgroup";
  }
  if($row->teacher!="") {
    $parser[] = "sem_tutor";
  } else {
    $parser[] = "sem_!tutor";
  }
  if($row->description!="") {
    $parser[] = "sem_description";
  } else {
    $parser[] = "sem_!description";
  }
  if($row->showbegin>0) {
    $parser[] = "sem_displaybegin";
  } else {
    $parser[] = "sem_!displaybegin";
  }
  if($row->showend>0) {
    $parser[] = "sem_displayend";
  } else {
    $parser[] = "sem_!displayend";
  }
  if($row->showbooked>0) {
    $parser[] = "sem_displayclosing";
  } else {
    $parser[] = "sem_!displayclosing";
  }
  if($row->fees>0) {
    $parser[] = "sem_fee";
  } else {
    $parser[] = "sem_!fee";
  }
  if($files!="") {
    $parser[] = "sem_files";
  } else {
    $parser[] = "sem_!files";
  }
  $html = sem_f065($html,$parser);

// Grafikpfad ersetzen
  $html = str_replace('SEM_IMAGEDIR1',sem_f006(),$html);
  $html = str_replace('SEM_IMAGEDIR2',sem_f007(1),$html);

// Zusatzfelder
  $html = str_replace('SEM_BOOKERINPUT_EXPR',JTEXT::_('SEM_0176'),$html);
  $html = str_replace('SEM_BOOKERINPUT_VALUES',$zusfelderval,$html);
  $html = str_replace('SEM_BOOKERINPUT_NOTAGS',$zusfeldnotag,$html);
  $html = str_replace('SEM_BOOKERINPUT',$zusfelder,$html);

// Zusatzfelder
  $htxt = JTEXT::_('SEM_1034');
  if($buchungswerte->id>0) {
    $htxt = JTEXT::_('SEM_1044');
  }
  $html = str_replace('SEM_ATTENDEEINPUT_EXPR',$htxt,$html);
  $html = str_replace('SEM_ATTENDEEINPUT_VALUES',$reqfelderval,$html);
  $html = str_replace('SEM_ATTENDEEINPUT_NOTAGS',$reqfeldnotag,$html);
  $html = str_replace('SEM_ATTENDEEINPUT',$reqfelder,$html);

// Pflichtfelder 
  $html = str_replace('SEM_REQUIREDFIELDS_EXPR',"<span class=\"sem_reqfield\">*</span> ".JTEXT::_('SEM_0118'),$html);

// Veranstaltungsbild
  if($zusimage!="") {
    $zusimage = "<div style=\"position:absolute;top:4px;left:4px;\">".sem_f045($zusimage)."</div>";
  }
  $html = str_replace('SEM_IMAGESTATUS1LINK',"<div style=\"position:relative;top:0px;left:0px;\"><a title=\"".$funktion[0]."\" href=\"javascript:auf('".$funktion[1]."','".$row->id."','');\">".sem_f045($linksbild).$zusimage."</a></div>",$html);
  $html = str_replace('SEM_IMAGESTATUS1',"<div style=\"position:relative;top:0px;left:0px;\">".sem_f045($linksbild).$zusimage."</div>",$html);
  $html = str_replace('SEM_IMAGESTATUS2LINK',"<div style=\"position:relative;top:0px;left:0px;\"><a title=\"".$funktion[0]."\" href=\"javascript:auf('".$funktion[1]."','".$row->id."','');\">".sem_f045($linksbild)."<div style=\"position:absolute;top:6px;left:6px;\">".sem_f045("250".$statusbild)."</div></a></div>",$html);
  $html = str_replace('SEM_IMAGESTATUS2',"<div style=\"position:relative;top:0px;left:0px;\">".sem_f045($linksbild)."<div style=\"position:absolute;top:6px;left:6px;\">".sem_f045("250".$statusbild)."</div></div>",$html);
  $html = str_replace('SEM_IMAGELINK',"<a title=\"".$funktion[0]."\" href=\"javascript:auf('".$funktion[1]."','".$row->id."','');\">".sem_f045($linksbild)."</a>",$html);
  $html = str_replace('SEM_IMAGE',sem_f045($linksbild),$html);

// Statusbild
  $html = str_replace('SEM_STATUSIMAGE1',sem_f045("230".$statusbild,$statustext),$html);
  $html = str_replace('SEM_STATUSIMAGE2',sem_f013($row->maxpupil,$buchung->free,$statusbild),$html);

// Feedbacklink
  $html = str_replace('SEM_FEEDBACK',$feedbacklink,$html);

// AGBs
  $html = str_replace('SEM_TANDC_URL',$agburl,$html);
  $html = str_replace('SEM_TANDC_EMAIL',$agbtext,$html);
  $html = str_replace('SEM_TANDC',$agbs,$html);

// Google-Maps-Icon
  $gmapicon = "";
  if($row->gmaploc!="") {
    $gmapicon = "<a title=\"".JTEXT::_('SEM_1016')."\" class=\"modal\" href=\"".sem_f004()."index2.php?option=".JRequest::getCmd('option')."&amp;task=35&amp;cid=".$row->id."\" rel=\"{handler: 'iframe', size: {x: ".$config->get('sem_p097',500).", y: ".$config->get('sem_p098',350)."}}\">".sem_f045("1312")."</a>";
  }
  $html = str_replace('SEM_GMAPICON',$gmapicon,$html);

// Ausdruecke der Veranstaltung ersetzen
  $html = str_replace('SEM_CATEGORY_EXPR',JTEXT::_('SEM_0008'),$html);
  $html = str_replace('SEM_TITLE_EXPR',JTEXT::_('SEM_0007'),$html);
  $html = str_replace('SEM_NUMBER_EXPR',JTEXT::_('SEM_0003'),$html);
  $html = str_replace('SEM_ID_EXPR',JTEXT::_('SEM_0057'),$html);
  $html = str_replace('SEM_LOCATION_EXPR',JTEXT::_('SEM_0015'),$html);
  $html = str_replace('SEM_TUTOR_EXPR',JTEXT::_('SEM_0019'),$html);
  $html = str_replace('SEM_TARGETGROUP_EXPR',JTEXT::_('SEM_0012'),$html);
  $html = str_replace('SEM_ORGANISER_EXPR',JTEXT::_('SEM_0094'),$html);
  $html = str_replace('SEM_ORGANIZER_EXPR',JTEXT::_('SEM_0094'),$html);
  $html = str_replace('SEM_SHORTDESCRIPTION_EXPR',JTEXT::_('SEM_0013'),$html);
  $html = str_replace('SEM_DESCRIPTION_EXPR',JTEXT::_('SEM_0014'),$html);
  $html = str_replace('SEM_BOOKEDSPACES_EXPR',JTEXT::_('SEM_0033'),$html);
  $html = str_replace('SEM_FREESPACES_EXPR',JTEXT::_('SEM_0053'),$html);
  $html = str_replace('SEM_MAXSPACES_EXPR',JTEXT::_('SEM_0020'),$html);
  $html = str_replace('SEM_BOOKINGS_EXPR',JTEXT::_('SEM_0035'),$html);
  $html = str_replace('SEM_PAID_EXPR',JTEXT::_('SEM_0065'),$html);
  $html = str_replace('SEM_HITS_EXPR',JTEXT::_('SEM_0058'),$html);
  $html = str_replace('SEM_CURRENCY_EXPR',JTEXT::_('SEM_0XXX'),$html);
  $html = str_replace('SEM_FEE_EXPR',JTEXT::_('SEM_0022'),$html);
  $html = str_replace('SEM_STATUS_EXPR',JTEXT::_('SEM_0069'),$html);
  $html = str_replace('SEM_FILES_EXPR',JTEXT::_('SEM_0131'),$html);
  $html = str_replace('SEM_CAPTCHA_EXPR',JTEXT::_('SEM_1057'),$html);
  $html = str_replace('SEM_NOTBOOKABLEONLINE_EXPR',JTEXT::_('SEM_0133'),$html);
  $html = str_replace('SEM_CANCELED_EXPR',JTEXT::_('SEM_0103'),$html);
  $html = str_replace('SEM_PERPERSON_EXPR',JTEXT::_('SEM_0085'),$html);
  $html = str_replace('SEM_ATTENDEESBOOKED_EXPR',JTEXT::_('SEM_0080'),$html);

  $html = str_replace('SEM_BOOKINGSUCCESSREASON',$ueberschrift[1],$html);
  $html = str_replace('SEM_BOOKINGSUCCESS',$ueberschrift[0],$html);

// Angaben der Veranstaltung ersetzen
  $html = str_replace('SEM_CATEGORY',$category[0],$html);
  $html = str_replace('SEM_TITLELINK',"<a class=\"sem_title\" title=\"".$funktion[0]."\" href=\"javascript:auf('".$funktion[1]."','".$row->id."','');\">".$row->title."</a>",$html);
  $html = str_replace('SEM_TITLE',$row->title,$html);
  $html = str_replace('SEM_NUMBER',$row->semnum,$html);
  $html = str_replace('SEM_ID',$row->id,$html);
  $html = str_replace('SEM_LOCATION',nl2br($row->place),$html);
  $html = str_replace('SEM_TUTOR',$row->teacher,$html);
  $html = str_replace('SEM_TARGETGROUP',$row->target,$html);
  $html = str_replace('SEM_ORGANISER',$organizer->name,$html);
  $html = str_replace('SEM_ORGANIZER',$organizer->name,$html);
  $temp = $buchung->booked + 1;
  if($temp<0) $temp = 0;
  $html = str_replace('SEM_BOOKEDSPACES_DIV',"<div id=\"sem_bookedspaces\" name=\"sem_bookedspaces\" style=\"display: inline;\">".$temp."</div>&nbsp;".JTEXT::_('SEM_1066'),$html);
  $html = str_replace('SEM_BOOKEDSPACES',$buchung->booked,$html);
  $temp = $buchung->free - 1;
  if($temp<0) $temp = 0;
  $html = str_replace('SEM_FREESPACES_DIV',"<div id=\"sem_freespaces\" name=\"sem_freespaces\" style=\"display: inline;\">".$temp."</div>&nbsp;".JTEXT::_('SEM_1066'),$html);
  $html = str_replace('SEM_FREESPACES',$buchung->free,$html);
  $html = str_replace('SEM_MAXSPACES',$row->maxpupil,$html);
  $html = str_replace('SEM_BOOKINGS',$buchung->number,$html);
  $html = str_replace('SEM_PAID',$buchung->paid,$html);
  $html = str_replace('SEM_HITS',$row->hits,$html);
  $gebplaetze = 1;
  if($buchungswerte->nrbooked>0) {
    $gebplaetze = $buchungswerte->nrbooked;
  }
  $gebtax = "";
  if($config->get('sem_p108',0)>0) {
    $gebtax = " ".JTEXT::_('SEM_1058');
  }
  if($config->get('sem_p107',0)>0 AND ($config->get('sem_p109','')!="" OR $config->get('sem_p110','')!="")) {
    $gebtax .= " ".JTEXT::_('SEM_1059');
  }
  if($gebtax!="") {
    $gebtax = "&nbsp;(".trim($gebtax).")";
  }
  $html = str_replace('SEM_FEE',sem_f044($row->fees),$html);
  $html = str_replace('SEM_FEE_INKLADD',sem_f044($row->fees).$gebtax,$html);
  $html = str_replace('SEM_AMOUNT_DIV_INKLADD',"<div id=\"sem_amount\" name=\"sem_amount\" style=\"display: inline;\">".sem_f044($row->fees * $gebplaetze)."</div>".$gebtax,$html);
  $html = str_replace('SEM_AMOUNT_INKLADD',sem_f044($row->fees * $gebplaetze).$gebtax,$html);
  $html = str_replace('SEM_AMOUNT_DIV',"<div id=\"sem_amount\" name=\"sem_amount\" style=\"display: inline;\">".sem_f044($row->fees * $gebplaetze)."</div>",$html);
  $html = str_replace('SEM_AMOUNT',sem_f044($row->fees * $gebplaetze),$html);
  $html = str_replace('SEM_PAYPALFEE',sem_f044($config->get('sem_p107',0)),$html);
  $html = str_replace('SEM_TAX',$config->get('sem_p108',0),$html);
  $html = str_replace('SEM_CURRENCY',$config->get('sem_p017',JTEXT::_('SEM_0165')),$html);
  $html = str_replace('SEM_STATUS',$statustext,$html);
  $html = str_replace('SEM_ATTENDEESBOOKED',$buchungswerte->nrbooked,$html);

// Captcha
  $captcha = "<div class=\"sem_captcha\">";
  $captcha .= sem_f045(sem_f005()."captcha/captcha.php",JTEXT::_('SEM_1035'),"style=\"vertical-align:middle;cursor:pointer;\" onClick=\"this.src='".sem_f005()."captcha/captcha.php?'+Math.random();\"");
  $captcha .= "<br />".JTEXT::_('SEM_1055')." ".$reqfield;
  $captcha .= "<br /><input type=\"text\" id=\"sem_captcha\" name=\"sem_captcha\" class=\"sem_captcha_input\" value=\"\" ".$tempdis."/>";
  $captcha .= "</div> ";
  $html = str_replace('SEM_CAPTCHA',$captcha,$html);

// Dateien herunterladen
  $html = str_replace('SEM_FILES',$files,$html);

// Datumsausdruecke ersetzen
  $html = str_replace('SEM_BEGIN_EXPR',JTEXT::_('SEM_0009'),$html);
  $html = str_replace('SEM_END_EXPR',JTEXT::_('SEM_0010'),$html);
  $html = str_replace('SEM_CLOSING_EXPR',JTEXT::_('SEM_0011'),$html);
  $html = str_replace('SEM_DATE_EXPR',JTEXT::_('SEM_0110'),$html);
  $html = str_replace('SEM_TIME_EXPR',JTEXT::_('SEM_0111'),$html);

// Veranstaltung wurde abgesagt
  if($row->cancelled==1) {
    $del1 = "<del>";
    $del2 = "</del>";
  } else {
    $del1 = "";
    $del2 = "";
  }

// Zertfikatsdruck
  $temp1 = "";
  $temp2 = "";
  $temp3 = "";
  if($buchungswerte->certificated == 1) {
    $temp3 = "<a title=\"".JTEXT::_('SEM_0092')."\" class=\"modal\" href=\"".sem_f004()."index2.php?option=com_seminar&amp;tesk=".base64_encode("16||".$buchungswerte->uniqid)."\" rel=\"{handler: 'iframe', size: {x: ".$config->get('sem_p097',500).", y: ".$config->get('sem_p098',350)."}}\">".$buchung->certificated."</a>";
    $temp2 = "<a title=\"".JTEXT::_('SEM_0092')."\" class=\"modal\" href=\"".sem_f004()."index2.php?option=com_seminar&amp;tesk=".base64_encode("16||".$buchungswerte->uniqid)."\" rel=\"{handler: 'iframe', size: {x: ".$config->get('sem_p097',500).", y: ".$config->get('sem_p098',350)."}}\">".sem_f045("2900",JTEXT::_('SEM_0092'))."</a>";
    $temp1 = sem_f045("2900",JTEXT::_('SEM_0092'));
  }
  $html = str_replace('SEM_CERTIFICATED_EXPR',JTEXT::_('SEM_0040'),$html);
  $html = str_replace('SEM_CERTIFICATED_IMAGE_PRINT',$temp2,$html);
  $html = str_replace('SEM_CERTIFICATED_IMAGE',$temp1,$html);
  $html = str_replace('SEM_CERTIFICATED_PRINT',$temp3,$html);
  $html = str_replace('SEM_CERTIFICATED',$buchung->certificated,$html);

// Knopf fuer Teilnehmerliste anzeigen
  $html = str_replace('SEM_BUTTON_ATTENDEES',"<button class=\"button\" style=\"cursor:pointer;\" type=\"button\" onclick=\"auf(24,'".$row->id."','$art');\" title=\"".JTEXT::_('SEM_0035')."\">".$buchung->booked."</button>",$html);

// Datumsangaben ersetzen
  $html = str_replace('SEM_BEGIN_OVERVIEW',$del1.JHTML::_('date',$row->begin,$config->get('sem_p066',JTEXT::_('SEM_0166')),0).$del2,$html);
  $html = str_replace('SEM_BEGIN_DETAIL',$del1.JHTML::_('date',$row->begin,$config->get('sem_p067',JTEXT::_('SEM_0167')),0).$del2,$html);
  $html = str_replace('SEM_BEGIN_LIST',$del1.JHTML::_('date',$row->begin,$config->get('sem_p068',JTEXT::_('SEM_0168')),0).$del2,$html);
  $html = str_replace('SEM_BEGIN_DATE',$del1.JHTML::_('date',$row->begin,$config->get('sem_p069',JTEXT::_('SEM_0169')),0).$del2,$html);
  $html = str_replace('SEM_BEGIN_TIME',$del1.JHTML::_('date',$row->begin,$config->get('sem_p070',JTEXT::_('SEM_0170')),0).$del2,$html);
  $html = str_replace('SEM_BEGIN',$del1.JHTML::_('date',$row->begin,$config->get('sem_p067',JTEXT::_('SEM_0167')).$del2,0),$html);
  $html = str_replace('SEM_END_OVERVIEW',$del1.JHTML::_('date',$row->end,$config->get('sem_p066',JTEXT::_('SEM_0166')).$del2,0),$html);
  $html = str_replace('SEM_END_DETAIL',$del1.JHTML::_('date',$row->end,$config->get('sem_p067',JTEXT::_('SEM_0167')).$del2,0),$html);
  $html = str_replace('SEM_END_LIST',$del1.JHTML::_('date',$row->end,$config->get('sem_p068',JTEXT::_('SEM_0168')).$del2,0),$html);
  $html = str_replace('SEM_END_DATE',$del1.JHTML::_('date',$row->end,$config->get('sem_p069',JTEXT::_('SEM_0169')).$del2,0),$html);
  $html = str_replace('SEM_END_TIME',$del1.JHTML::_('date',$row->end,$config->get('sem_p070',JTEXT::_('SEM_0170')).$del2,0),$html);
  $html = str_replace('SEM_END',$del1.JHTML::_('date',$row->end,$config->get('sem_p067',JTEXT::_('SEM_0167')),0).$del2,$html);
  $html = str_replace('SEM_CLOSING_OVERVIEW',$del1.JHTML::_('date',$row->booked,$config->get('sem_p066',JTEXT::_('SEM_0166')),0).$del2,$html);
  $html = str_replace('SEM_CLOSING_DETAIL',$del1.JHTML::_('date',$row->booked,$config->get('sem_p067',JTEXT::_('SEM_0167')),0).$del2,$html);
  $html = str_replace('SEM_CLOSING_LIST',$del1.JHTML::_('date',$row->booked,$config->get('sem_p068',JTEXT::_('SEM_0168')),0).$del2,$html);
  $html = str_replace('SEM_CLOSING_DATE',$del1.JHTML::_('date',$row->booked,$config->get('sem_p069',JTEXT::_('SEM_0169')),0).$del2,$html);
  $html = str_replace('SEM_CLOSING_TIME',$del1.JHTML::_('date',$row->booked,$config->get('sem_p070',JTEXT::_('SEM_0170')),0).$del2,$html);
  $html = str_replace('SEM_CLOSING',$del1.JHTML::_('date',$row->booked,$config->get('sem_p067',JTEXT::_('SEM_0167')),0).$del2,$html);
  $html = str_replace('SEM_NOW_OVERVIEW',JHTML::_('date',$neudatum,$config->get('sem_p066',JTEXT::_('SEM_0166')),0),$html);
  $html = str_replace('SEM_NOW_DETAIL',JHTML::_('date',$neudatum,$config->get('sem_p067',JTEXT::_('SEM_0167')),0),$html);
  $html = str_replace('SEM_NOW_LIST',JHTML::_('date',$neudatum,$config->get('sem_p068',JTEXT::_('SEM_0168')),0),$html);
  $html = str_replace('SEM_NOW_DATE',JHTML::_('date',$neudatum,$config->get('sem_p069',JTEXT::_('SEM_0169')),0),$html);
  $html = str_replace('SEM_NOW_TIME',JHTML::_('date',$neudatum,$config->get('sem_p070',JTEXT::_('SEM_0170')),0),$html);
  $html = str_replace('SEM_NOW',JHTML::_('date',$neudatum,$config->get('sem_p070',JTEXT::_('SEM_0170')),0),$html);
  $html = str_replace('SEM_TODAY',JHTML::_('date',$neudatum,$config->get('sem_p069',JTEXT::_('SEM_0169')),0),$html);

// Benutzerausdruecke ersetzen
  $html = str_replace('SEM_NAME_EXPR',JTEXT::_('SEM_0059'),$html);
  $html = str_replace('SEM_EMAIL_EXPR',JTEXT::_('SEM_0052'),$html);
  $html = str_replace('SEM_BOOKINGDATE_EXPR',JTEXT::_('SEM_0032'),$html);
  $html = str_replace('SEM_BOOKINGTIME_EXPR',JTEXT::_('SEM_0034'),$html);

// Benutzerangaben ersetzen
  $html = str_replace('SEM_NAME',$user->name,$html);
  $html = str_replace('SEM_EMAIL',$user->email,$html);
  $html = str_replace('SEM_BOOKINGDATE_OVERVIEW',JHTML::_('date',$buchungswerte->bookingdate,$config->get('sem_p066',JTEXT::_('SEM_0166')),0),$html);
  $html = str_replace('SEM_BOOKINGDATE_DETAIL',JHTML::_('date',$buchungswerte->bookingdate,$config->get('sem_p067',JTEXT::_('SEM_0167')),0),$html);
  $html = str_replace('SEM_BOOKINGDATE_LIST',JHTML::_('date',$buchungswerte->bookingdate,$config->get('sem_p068',JTEXT::_('SEM_0168')),0),$html);
  $html = str_replace('SEM_BOOKINGDATE',JHTML::_('date',$buchungswerte->bookingdate,$config->get('sem_p069',JTEXT::_('SEM_0169')),0),$html);
  $html = str_replace('SEM_BOOKINGTIME',JHTML::_('date',$buchungswerte->bookingdate,$config->get('sem_p070',JTEXT::_('SEM_0170')),0),$html);

// Link zur Homepage
  $html = str_replace('SEM_HOMEPAGELINK',JHTML::_('link',JURI::root(),JURI::root()),$html);
  $html = str_replace('SEM_HOMEPAGE',JURI::root(),$html);

// Barcodes und Buchungs-ID ausgeben
  $barcode = "";
  $qrcode = "";
  $buchungsid = "";
  if($buchungswerte->id>0) {
    $buchungsid = sem_f002($buchungswerte->id);
    $qrcode = "<img src=\"http://chart.apis.google.com/chart?cht=qr&amp;chs=100x100&amp;choe=UTF-8&amp;chld=H|4&amp;chl=".urlencode($buchungsid)."\" /><br /><code><b>".$buchungsid."</b></code>";
    $barcode = "<img src=\"".sem_f005()."seminar.code.php?code=".$buchungsid."\" />";
  }
  $html = str_replace('SEM_BOOKINGID_EXPR',JTEXT::_('SEM_0097'),$html);
  $html = str_replace('SEM_BOOKINGID',$buchungsid,$html);
  $html = str_replace('SEM_BOOKINGQRCODE',$qrcode,$html);
  $html = str_replace('SEM_BOOKINGBARCODE',$barcode,$html);

// CSS_Klasse Gebuehr ersetzen
  $klasse = "sem_fees";
  if($buchungswerte->id>0) {
    if($buchungswerte->paid == 1) {
      $klasse = "sem_fees_paid";
    } else {
      $klasse = "sem_fees_notpaid";
    }
  }
  $html = str_replace('SEM_CSS_FEE',$klasse,$html);

  return str_replace('<!>',"\n",$html);
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
    $html = " <span class=\"editlinktip hasTip\" title=\"".$hinttext."\" style=\"text-decoration: none;cursor: help;\">".sem_f045("0012")."</span>";
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
  $where[] = "(publisher = '".$my->id."' OR publisher = '0')";

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
      $htxt .= " <button class=\"button\" id=\"tmpldel\" style=\"cursor:pointer;\" type=\"button\" onclick=\"form.cid.value=form.vorlage.value;form.task.value=11;form.submit();\"".$disabled.">".sem_f045("1516",JTEXT::_('SEM_0124'))."&nbsp;".JTEXT::_('SEM_0124')."</button>";
    } else {
      $htxt .= "<input type=\"hidden\" name=\"vorlage\" value=\"0\">";
    }
    $htxt .= " <input type=\"text\" name=\"pattern\" id=\"pattern\" class=\"sem_inputbox\" value=\"\" onKeyup=\"if(this.value=='') {form.tmplsave.disabled=true;} else {form.tmplsave.disabled=false;}\">";
    $htxt .= " <button class=\"button\" id=\"tmplsave\" style=\"cursor:pointer;\" type=\"button\" onclick=\"form.task.value=10;form.submit();\" disabled>".sem_f045("1416",JTEXT::_('SEM_0125'))."&nbsp;".JTEXT::_('SEM_0125')."</button>";
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
  if($kurs->title!="") {
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
  JError::raiseError(403, JText::_("ALERTNOTAUTH"));
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
  $html .= "<a href=\"javascript:document.donate.submit();\">".sem_f045("donate")."</a>";
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

function sem_f065($text,$parser) {
  $parserout = array();
  foreach($parser as $status) {
    if(strpos($status,"sem_!")===false) {
      $parserout[] = str_replace("sem_","sem_!",$status);
    } else {
      $parserout[] = str_replace("sem_!","sem_",$status);
    }
    preg_match_all("`\[".$status."\](.*)\[/".$status."\]`U",$text,$ausgabe);
    for($i=0;$i<count($ausgabe[0]);$i++) {
      $text = str_replace($ausgabe[0][$i],$ausgabe[1][$i],$text);
    }
  }
  foreach($parserout as $status) {
    preg_match_all("`\[".$status."\](.*)\[/".$status."\]`U",$text,$ausgabe);
    for($i=0;$i<count($ausgabe[0]);$i++) {
      $text = str_replace($ausgabe[0][$i],"",$text);
    }
  }
  return $text;
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Ausgabe saeubern                +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f066($text) {
  preg_match_all("`\{[^\}]+\}`U",$text,$ausgabe);
  for($i=0;$i<count($ausgabe[0]);$i++) {
    $text = str_replace($ausgabe[0][$i],"",$text);
  }
  return $text;
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Eingabe pruefen                 +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f067() {
  $args = func_get_args();
  $config = &JComponentHelper::getParams('com_seminar');
  $text = $args[0];
  $art = $args[1];
  $htxt = false;
  switch($art) {
// texteingabe pruefen - alle eingaben auf leere eingaben pruefen
    case 'leer':
      $text = trim(preg_replace("/\n/s", "", $text));
      if ($text=="") {
        $htxt = true;
      }
      break;
// texteingabe pruefen - alle eingaben auf nicht leere eingaben pruefen
    case 'voll':
      $text = trim(preg_replace("/\n/s", "", $text));
      if ($text!="") {
        $htxt = true;
      }
      break;
// auf nur zahlen pruefen
    case 'nummer':
      if (preg_match("#^[0-9]+$#",$text)) {
        $htxt = true;
      }
      break;
// auf telefonnummer pruefen mit min. 6 zahlen
    case 'telefon':
      if (preg_match("#^[ 0-9\/-+]{6,}+$#",$text)) {
        $htxt = true;
      }
      break;
// auf nur buchstaben pruefen
    case 'buchstabe':
      if (preg_match("/^[ a-za-zÃ¤ÃœÃŸÃ»]+$/i",$text)) {
        $htxt = true;
      }
      break;
// auf nur ein wort pruefen
    case 'wort':
      if (preg_match("/^[a-za-zÃ¤ÃœÃŸÃ»]+$/i",$text)) {
        $htxt = true;
      }
      break;
// url pruefen
    case 'url':
      $text=trim($text);
      if (preg_match("#^(http|https)+(://www.)+([a-z0-9-_.]{2,}\.[a-z]{2,4})$#i",$text)) {
        $htxt = true;
      }
      break;
// email-adresse pruefen
    case 'email':
      $text=trim($text);
      if ($text!='') {
        if (preg_match('/^\w[-._\w]*@(\w[-._\w]*\.[a-zA-Z]{2,}.*)$/',$text,$matches)) {
          if(checkdnsrr($matches[1], "MX")) {
          } else {
            $htxt = false;
          } 
        } else {
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

// +++++++++++++++++++++++++++++++++++++++++++++++
// +++ Array mit Teilnehmer Zusatzfeldern erzeugen
// +++++++++++++++++++++++++++++++++++++++++++++++

function sem_f068($row) {
  $reqfield = array();
  if (isset($row->request1)) {
    $reqfield[] = array($row->request1,$row->request2,$row->request3,$row->request4,$row->request5,$row->request6,$row->request7,$row->request8,$row->request9,$row->request10,$row->request11,$row->request12,$row->request13,$row->request14,$row->request15,$row->request16,$row->request17,$row->request18,$row->request19,$row->request20);
    if (isset($row->request1hint)) {
      $reqfield[] = array($row->request1hint,$row->request2hint,$row->request3hint,$row->request4hint,$row->request5hint,$row->request6hint,$row->request7hint,$row->request8hint,$row->request9hint,$row->request10hint,$row->request11hint,$row->request12hint,$row->request13hint,$row->request14hint,$row->request15hint,$row->request16hint,$row->request17hint,$row->request18hint,$row->request19hint,$row->request20hint);
    }
    if (isset($row->request1nl)) {
      $reqfield[] = array($row->request1nl,$row->request2nl,$row->request3nl,$row->request4nl,$row->request5nl,$row->request6nl,$row->request7nl,$row->request8nl,$row->request9nl,$row->request10nl,$row->request11nl,$row->request12nl,$row->request13nl,$row->request14nl,$row->request15nl,$row->request16nl,$row->request17nl,$row->request18nl,$row->request19nl,$row->request20nl);
    }
    $reqfield[] = array("","","","","","","","","","","","","","","","","","","","");
  } else {
    $reqfield[] = array("","","","","","","","","","","","","","","","","","","","");
    $reqfield[] = array("","","","","","","","","","","","","","","","","","","","");
    $reqfield[] = array("1","1","1","1","1","1","1","1","1","1","1","1","1","1","1","1","1","1","1","1");
    $reqfield[] = array("","","","","","","","","","","","","","","","","","","","");
  }
  return $reqfield; 
}

// +++++++++++++++++++++++++++++++++++++++++++++
// +++ Teilnehmer Zusatz Felder erzeugen     +++
// +++++++++++++++++++++++++++++++++++++++++++++

function sem_f069($requestfields,$requested,$count,$tempdis,$semid) {
  $html = "<input type=\"hidden\" name=\"reqid".$count."\" value=\"1\">";
  $htmlval = "";
  $valnotag = "";
  for($i=0;$i<count($requestfields[0]);$i++) {
    if($requestfields[0][$i]!="") {
      $reqart = explode("|",$requestfields[0][$i]);
      if (!empty($requested[$i])) {
        $reqvalue=$requested[$i];
      } else {
        $reqvalue=$reqart[2];
      }
      $reqzwang = "";
      $zwang = 0;
      if($reqart[1]==1) {
        $reqzwang .= " <span class=\"sem_reqfield\">*</span>";
        $zwang = 1;
      }
      if(strtolower($reqart[3])=="hidden") {
        $html .= sem_f076($reqart,$reqvalue,"request",($i+1).$count,$semid,$tempdis,$zwang);
      } else {
        $html .= " ".$reqart[0].$reqzwang.sem_f055($requestfields[1][$i])." ".sem_f076($reqart,$reqvalue,"request",($i+1).$count,$semid,$tempdis,$zwang);
        $htmlval .= " ".$reqart[0]." ".sem_f083($reqvalue);
      }
      $valnotag .= $reqart[0]." ".$reqvalue."<br />";
      if($requestfields[2][$i]==1) {
        $html .= "<br />";
        $htmlval .= "<br />";
      }
    }
  }
  return array($html,$htmlval,$valnotag);
}

// +++++++++++++++++++++++++++++++++++
// +++ CSV-Datei Teilnehmer senden +++
// +++++++++++++++++++++++++++++++++++

function sem_f070() {
  $database = &JFactory::getDBO();
  $config = &JComponentHelper::getParams('com_seminar');
  $cid = trim( JRequest::getVar('cid', '' ) );
  $kurs = new mosSeminar( $database );
  $kurs->load( $cid );
  // Korrektur Funktion, falls Joomla user gelöscht worden sind
  $database->setQuery( "UPDATE #__sembookings AS a LEFT JOIN #__users AS u ON a.userid=u.id SET a.userid=0 WHERE u.id IS NULL");
  $database->Query();
  $database->setQuery( "SELECT a.*, b.*, b.id AS sid, b.name AS aname, b.email AS aemail, u.username AS uname, u.email AS uemail 
                        FROM #__semattendees AS a LEFT JOIN #__sembookings AS b ON a.sembid=b.id LEFT JOIN #__users AS u ON b.userid=u.id
                        WHERE a.semid = '$kurs->id' ORDER BY a.sembid,a.ordering");
  $rows = $database->loadObjectList();
  if ($database->getErrorNum()) {
    echo $database->stderr();
    return false;
  }
  $csvdata = "\"#\",\"".JTEXT::_('SEM_0097')."\",\"";
  $request1 = sem_f068($kurs);
  $requests=0;
  foreach($request1[0] AS $el) {
    if($el=="") break;
    $requests++;
    $el = explode("|",$el);
    if (empty($el[0]) and isset($el[3]) and $el[3] == "text" and isset($el[2]) and !empty($el[2])) {
      $csvdata .= str_replace("\"","'",$el[2]);
    } else {
      $csvdata .= str_replace("\"","'",$el[0]);
    }
    $csvdata .= "\",\"";
  }
  $csvdata .= JTEXT::_('SEM_0176')."\",\"".JTEXT::_('SEM_0052')."\",\"".JTEXT::_('SEM_0032')."\",\"".JTEXT::_('SEM_0034')."\",\"".JTEXT::_('SEM_0069');
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

  $sembid = $summe = 0;
  $i = 0;
  foreach($rows AS $row) {
    if($row->userid==0) {
      $tempname = $row->aname;
      $tempmail = $row->aemail;
    } else {
      $tempname = $row->uname;
      $tempmail = $row->uemail;
    }
    $i++;
    if ($sembid != $row->sembid) {
      $summe = $summe + $row->nrbooked;
      $temp9 = JTEXT::_('SEM_0030');
      if( $summe > $kurs->maxpupil ) {
        if( $kurs->stopbooking < 1 ) {
          $temp9 = JTEXT::_('SEM_0025');
        } else {
          $temp9 = JTEXT::_('SEM_0029');
        }
      }
      $sembid = $row->sembid;
    }
    $temp6 = JHTML::_('date',$row->bookingdate,$config->get('sem_p069',JTEXT::_('SEM_0169')),0);
    $temp7 = JHTML::_('date',$row->bookingdate,$config->get('sem_p070',JTEXT::_('SEM_0170')),0);
    $temp8 = $i;
    $csvdata .= "\"".$temp8."\",\"".sem_f002($row->sid)."~".$row->ordering."\",\"";
    $request = sem_f068($row);
    for ($l=0;$l<$requests;$l++) {
      $csvdata .= str_replace("\"","'",$request[0][$l])."\",\"";
    } 
    $csvdata .= str_replace("\"","'",$tempname)."\",\"".$tempmail."\",\"".$temp6."\",\"".$temp7."\",\"".$temp9;
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
        $csvdata .= "\",\"".str_replace("´","'",str_replace("\"","'",$zusatz2[0][$l]));
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

// +++++++++++++++++++++++++++++++++++
// +++ Linkgrafik ausgeben         +++
// +++++++++++++++++++++++++++++++++++

function sem_f071() {
  $args = func_get_args();
  $text = "";
  if(isset($args[2]) AND $args[2]!="") {
    $text = JTEXT::_("SEM_".$args[2]);
  }
  $grafik = $text;
  if(isset($args[1]) AND $args[1]!="") {
    $grafik = sem_f045($args[1],$text);
  }
  $zusatz = "title=\"".$text."\"";
  $zusatz .= " border=\"0\"";
  if(isset($args[3]) AND $args[3]!="") {
    $zusatz .= " ".$args[3];
  }
  return JHTML::_('link',$args[0],$grafik,$zusatz);
}

// +++++++++++++++++++++++++++++++++++
// +++ Linkknopf ausgeben          +++
// +++++++++++++++++++++++++++++++++++

function sem_f072() {
  $args = func_get_args();
  $style = "";
  if(isset($args[3]) AND $args[3]!="") {
    $style = " ".$args[3];
  }
  $text = "";
  if(isset($args[2]) AND $args[2]!="") {
    $text = JTEXT::_("SEM_".$args[2]);
  }
  $grafik = "";
  if(isset($args[1]) AND $args[1]!="") {
    $grafik = sem_f045($args[1],$text);
  }
  return " <button class=\"button\" style=\"cursor:pointer;".$style."\" type=\"button\" onclick=\"".$args[0].";\">".$grafik."&nbsp;".$text."</button>";
}

// ++++++++++++++++++++++++++++++++++++++++++
// +++ Kategorienliste für die Navigation +++
// ++++++++++++++++++++++++++++++++++++++++++

function sem_f073($catid) {
  $database = JFactory::getDBO();
  $catlist = "";
  $reglevel = sem_f042();
  $accesslvl = 1;
  if($reglevel>=6) {
    $accesslvl=3;
  } elseif ($reglevel>=2) {
    $accesslvl=2;
  }
  $categories[] = JHTML::_('select.option', '0', JTEXT::_('SEM_0027') );
  $database->setQuery( "SELECT id AS value, title AS text FROM #__categories WHERE section='".JRequest::getCmd('option')."' AND access<".$accesslvl." ORDER BY ordering" );
  $categs = array_merge($categories, $database->loadObjectList());
  return JHTML::_('select.genericlist',$categs,"catid","class=\"sem_inputbox\" size=\"1\" onchange=\"document.FrontForm.limitstart.value=0;document.FrontForm.submit();\"","value","text",$catid);
}

// ++++++++++++++++++++++++++++++++++++++++++
// +++ Hilfeknopf ausgeben                +++
// ++++++++++++++++++++++++++++++++++++++++++

function sem_f074($link) {
  $config = &JComponentHelper::getParams('com_seminar');
  $lang = JFactory::getLanguage();
  $sprache = strtolower(substr($lang->getName(),0,2));
  $args = func_get_args();
  if(count($args)==1) {  
    return "<a href=\"\" title=\"".JTEXT::_('SEM_0200')."\" class=\"modal\" onclick=\"href='http://seminar.vollmar.ws/help/".$link.".php?v=".sem_f001()."&l=".$sprache."'\" rel=\"{handler: 'iframe', size: {x: ".$config->get('sem_p097',500).", y: ".$config->get('sem_p098',350)."}}\">".sem_f045('0013',JTEXT::_('HELP'))."</a>";
  } else {
    $mainframe = JFactory::getApplication();
    $htxt = explode("/",JURI::BASE());
    $url = $htxt[2];
    $from = $mainframe->getCfg('mailfrom');
    $link = base64_encode($sprache."|".$url."|".$from."|");
    return "<a href=\"javascript:void(window.open('http://seminar.vollmar.ws/help/semcode.php?".$link."','','toolbar=no,width=800,height=480,directories=no,status=no,scrollbars=yes,resize=no,menubar=no'))\" title=\"".JTEXT::_('SEM_2054')."\">".sem_f045('0002',JTEXT::_('SEM_2054'))."</a>";
  }
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Emails versenden +++
// ++++++++++++++++++++++++++++++++++++++
// sem_f075(Seminar,Art,Text,bucherangaben)

function sem_f075() {
  function mail_booked($emailtext,$database,$event,$body,$from,$sender,$subject,$type,$cc,$bcc,$attachment,$replyto,$replyname) {
    if(sem_f067($body,'voll')) {
      $body = str_replace("SEM_EMAILTEXT",$emailtext,$body);
      $database->setQuery("SELECT * FROM #__sembookings WHERE semid='".$event->id."' AND userid=0");
      $users = $database->loadObjectList();
      foreach($users as $user) {
        $bodyneu = sem_f054($body,$event,1,$user);
        JUtility::sendMail($from, $sender, $user->email, $subject, $bodyneu, $type, $cc, $bcc, $attachment, $replyto, $replyname);
      }
      $database->setQuery("SELECT a.* FROM #__users AS a LEFT JOIN #__sembookings AS b ON a.id=b.userid WHERE b.semid='$event->id'");
      $users = $database->loadObjectList();
      foreach($users as $user) {
        $bodyneu = sem_f054($body,$event,1,$user->id);
        JUtility::sendMail($from, $sender, $user->email, $subject, $bodyneu, $type, $cc, $bcc, $attachment, $replyto, $replyname);
      }
    }
  }
  $config = &JComponentHelper::getParams('com_seminar');
  $user = &JFactory::getuser();
  if($config->get('sem_p010',0)>0) {  
    $database = &JFactory::getDBO();
    $mainframe = JFactory::getApplication();
    jimport('joomla.mail.helper');

// uebergebene Parameter ermitteln
    $args = func_get_args();
    $event = $args[0];
    $art = $args[1];
    $emailtext = "";
    if(count($args)>2) {
      $emailtext = $args[2];
    }

//  Seminarwerte einlesen
    if(is_numeric($event)) {
      $temp = $event;
      $event = new mosSeminar($database);
      $event->load($temp);
    }

//  Standardwerte ermitteln
    $from = $mainframe->getCfg('mailfrom');
    $sender = $mainframe->getCfg('fromname');
    $publisher = &JFactory::getuser($event->publisher);
    $replyname = $publisher->name;
    $replyto = $publisher->email;
    $subject = "";
    if($event->semnum!="") {
      $subject = " ".$event->semnum;
    }
    $subject = JTEXT::_('SEM_0048').$subject.": ".$event->title;
    $subject = JMailHelper::cleanSubject($subject);
    $cc = null;
    $bcc = null;
    if($config->get('sem_p102','')!="") {
      $bcc = explode(" ",$config->get('sem_p102',''));
    }
    if($config->get('sem_p009',0)>0) {
      $bcc[] = $publisher->email;
    }
    $attachment = null;

// Email-Layouts einlesen
    $emails = sem_f082();
    
// Je nach Art verschiedene E-Mails vorbereiten
    switch($art) {
      case "1":
//      Email an alle registrierten Benutzer, dass eine neue Veranstaltung eingegeben wurde
        $body = $emails->new;
        if(sem_f067($body,'voll')) {
          $body = str_replace("SEM_EMAILTEXT",$emailtext,$body);
          $type =  $emails->new_type;
          $kategorie = sem_f012($event->catid);
          $where = array();
          $where[] = "usertype='Super Administrator'";
          $where[] = "usertype='Administrator'";
          $where[] = "usertype='Manager'";
          if($kategorie->access<2) {
            $where[] = "usertype='Publisher'";
            $where[] = "usertype='Editor'";
            $where[] = "usertype='Author'";
          }
          if($kategorie->access<1) {
            $where[] = "usertype='Registered'";
          }
          $database->setQuery("SELECT email FROM #__users"
          . (count($where) ? "\nWHERE " . implode(' OR ',$where) : "")
          . "\nAND block='0'"
          );
          $email = $database->loadResultArray(0);
          $bcc = array_unique(array_merge($bcc,$email));
          $body = sem_f054($body,$event,0,$user->id);
          JUtility::sendMail($from, $sender, null, $subject, $body, $type, $cc, $bcc, $attachment, $replyto, $replyname);
        }
        break;
      case "2":
//      Email an alle gebuchten Benutzer, dass eine Veranstaltung geändert wurde
        $body = $emails->changed;
        $type = $emails->changed_type;
        mail_booked($emailtext,$database,$event,$body,$from,$sender,$subject,$type,$cc,$bcc,$attachment,$replyto,$replyname);
        break;
      case "3":
//      Email an alle gebuchten Benutzer, dass eine Veranstaltung aus dem Programm genommen wurde
        $neudatum = sem_f046();
        $emailtext = JTEXT::_('SEM_0079');
        if($neudatum < $event->end) {
          $body = $emails->unpublished_recent;
          $type = $emails->unpublished_recent_type;
        } else {
          $body = $emails->unpublished_over;
          $type = $emails->unpublished_over_type;
        }
        if($event->published==1) {
          mail_booked($emailtext,$database,$event,$body,$from,$sender,$subject,$type,$cc,$bcc,$attachment,$replyto,$replyname);
        }
        break;
      case "4":
//      Email an alle gebuchten Benutzer, dass eine Veranstaltung wieder ins Programm aufgenommen wurde
        $neudatum = sem_f046();
        $emailtext = JTEXT::_('SEM_2007');
        if($neudatum < $event->end) {
          $body = $emails->republished_recent;
          $type = $emails->republished_recent_type;
        } else {
          $body = $emails->republished_over;
          $type = $emails->republished_over_type;
        }
        mail_booked($emailtext,$database,$event,$body,$from,$sender,$subject,$type,$cc,$bcc,$attachment,$replyto,$replyname);
        break;
      case "5":
//      Veranstaltung wurde von Teilnehmer gebucht
        $emailtext = JTEXT::_('SEM_1056');
        $body = $emails->booked;
        $body = str_replace("SEM_EMAILTEXT",$emailtext,$body);
        $type = $emails->booked_type;
//         echo $body."\n";
        if(count($args)>3) {
          $user = $args[3];
          $body = sem_f054($body,$event,0,$user);
        } else {
          $body = sem_f054($body,$event,0,$user->id);
        }
//         echo $body."\n";
        if($type==0) {
          $body = preg_replace("/\<br(\s*)?\/?\>/i", "\n",$body);
          $body = strip_tags($body);
        }
//         echo $body."\n";
//         exit;
        JUtility::sendMail($from, $sender, $user->email, $subject, $body, $type, $cc, $bcc, $attachment, $replyto, $replyname);
        break;
    }
  }
}

// ++++++++++++++++++++++++++++++++++++++++++
// +++ Eingabefelder ausgeben             +++
// ++++++++++++++++++++++++++++++++++++++++++

function sem_f076() {
  $database = &JFactory::getDBO();
  $args = func_get_args();
  $feld = $args[0];
  $vorgabe = $args[1];
  $feldid = $args[3];
  $semid = $args[4];
  $feldname = $args[2].$feldid;
  $optfeld = substr($args[2],0,3);
  $disabled = "";
  if(count($args)>5) {
    $disabled = $args[5];
  }
  $class = "sem_inputbox";
  if(count($args)>6) {
    $zwang = $args[6];
  }
  if(count($args)>7) {
    $class = $args[7];
  }
  $vorgabe = sem_f083($vorgabe);
  if(count($feld)>3) {
    $optionen = array();
    switch(strtolower($feld[3])) {
      case "select":
        $optionen[] = JHTML::_('select.option', '', '- '.JTEXT::_('SEM_1046').' -');
        for($z=4;$z<count($feld);$z++) {
          $optionen[] = JHTML::_('select.option', $feld[$z], $feld[$z]);
        }
        $htxt = JHTML::_('select.genericlist', $optionen, $feldname, 'class="'.$class.'" size="1"'.$disabled, 'value', 'text', $vorgabe);
        break;
      case "radio":
        for($z=4;$z<count($feld);$z++) {
          $optionen[] = JHTML::_('select.option', $feld[$z], $feld[$z]);
        }
        $htxt = JHTML::_('select.radiolist', $optionen, $feldname, 'class="'.$class.'"'.$disabled, 'value', 'text', $vorgabe);
        break;
      case "textarea":
        $breite = 30;
        if(count($feld)>4) {
          if(is_numeric($feld[4])) {
            $breite = $feld[4];
          }
        }
        $hoehe = 3;
        if(count($feld)>5) {
          if(is_numeric($feld[5])) {
            $hoehe = $feld[5];
          }
        }
        $htxt = "<textarea class=\"".$class."\" id=\"".$feldname."\" name=\"".$feldname."\" cols=\"".$breite."\" rows=\"".$hoehe."\"".$disabled.">".$vorgabe."</textarea>";
        break;
      case "hidden":
        $htxt = "<input type=\"hidden\" id=\"".$feldname."\" name=\"".$feldname."\" value=\"".$vorgabe."\">";
        break;
      case "email":
      default:
        $breite = 50;
        if(count($feld)>4) {
          if(is_numeric($feld[4])) {
            $breite = $feld[4];
          }
        }
        $laenge = "";
        if(count($feld)>5) {
          if(is_numeric($feld[5])) {
            $laenge=" maxlength=\"".$feld[5]."\"";
          }
        }
        $htxt = "<input type=\"text\" class=\"".$class."\" id=\"".$feldname."\" name=\"".$feldname."\" value=\"".$vorgabe."\" size=\"".$breite."\"".$laenge.$disabled.">";
        break;
    }
  } else {
    $htxt = "<input type=\"text\" class=\"sem_inputbox\" id=\"".$feldname."\" name=\"".$feldname."\" value=\"".$vorgabe."\" size=\"50\"".$disabled.">";
  }
  $htxt .= "<input type=\"hidden\" id=\"".$optfeld."opt".$feldid."\" name=\"".$optfeld."opt".$feldid."\" value=\"".$zwang."\">";
  return $htxt;
}

// +++++++++++++++++++++++++++++++++++++++++++++++
// +++ Kursdaten vor dem Speichern aufbereiten +++
// +++++++++++++++++++++++++++++++++++++++++++++++

function sem_f077($id) {
  $database = &JFactory::getDBO();
  $config = &JComponentHelper::getParams('com_seminar');
  $vorlage = JRequest::getInt('vorlage',0);
  $neudatum = sem_f046();
  $post = JRequest::get('post');
  $post['description'] = JRequest::getVar('description', '', 'post', 'string', JREQUEST_ALLOWHTML);
  $post['shortdesc'] = JRequest::getVar('shortdesc', '', 'post', 'string', JREQUEST_ALLOWHTML);
  $post['cancelled'] = JRequest::getInt('cancel',0);
  $post['catid'] = JRequest::getInt('caid',0);

  if($id>0) {
    $kurs = new mosSeminar($database);
    $kurs->load($id);
  }
  if($vorlage>0) {
    $kurs = new mosSeminar($database);
    $kurs->load($vorlage);
  }
  $row = new mosSeminar($database);
  $row->load($id);
  if (!$row->bind($post)) {
    JError::raise(E_ERROR,500,$database->stderr());
    return false;
  }

// Zeit formatieren
  $_begin_date = JRequest::getVar('_begin_date','0000-00-00');
  $_begin_hour= JRequest::getVar('_begin_hour','00');
  $_begin_minute = JRequest::getVar('_begin_minute','00');
  $_end_date = JRequest::getVar('_end_date','0000-00-00');
  $_end_hour= JRequest::getVar('_end_hour','00');
  $_end_minute = JRequest::getVar('_end_minute','00');
  $_pubbegin_date = JRequest::getVar('_pubbegin_date','0000-00-00');
  $_pubbegin_hour= JRequest::getVar('_pubbegin_hour','00');
  $_pubbegin_minute = JRequest::getVar('_pubbegin_minute','00');
  $_pubend_date = JRequest::getVar('_pubend_date','0000-00-00');
  $_pubend_hour= JRequest::getVar('_pubend_hour','00');
  $_pubend_minute = JRequest::getVar('_pubend_minute','00');
  $_booked_date = JRequest::getVar('_booked_date','0000-00-00');
  $_booked_hour= JRequest::getVar('_booked_hour','00');
  $_booked_minute = JRequest::getVar('_booked_minute','00');

// Zuweisung der Startzeit
  if (intval($_begin_date)) {
    $dt = "$_begin_date $_begin_hour:$_begin_minute:00";
  } else {
    $dt = date("Y-m-d 14:00:00");
  }
  $row->begin = strftime("%Y-%m-%d %H:%M:%S",strtotime($dt));

// Zuweisung der Endzeit
  if (intval($_end_date)) {
    $dt = "$_end_date $_end_hour:$_end_minute:00";
  } else {
    $dt = date("Y-m-d 17:00:00");
  }
  $row->end = strftime("%Y-%m-%d %H:%M:%S",strtotime($dt));

// Zuweisung des Anmeldeschlusses
  if (intval($_booked_date)) {
    $dt = "$_booked_date $_booked_hour:$_booked_minute:00";
  } else {
    $dt = date("Y-m-d 12:00:00");
  }
  $row->booked = strftime("%Y-%m-%d %H:%M:%S",strtotime($dt));

// Zuweisung der aktuellen Zeit
  if($id==0) {
    $row->publishdate = $neudatum;
  } else {
    $row->publishdate = $kurs->publishdate;
  }
  $row->updated = $neudatum;

// Veroeffentlichungszeitraum festlegen
  if($config->get('sem_p064',2)!=3) {
    $row->pubbegin = $neudatum;
    switch($config->get('sem_p064',2)) {
      case 0:
        $row->pubend = $row->begin;
        break;
      case 1:
        $row->pubend = $row->booked;
        break;
      case 2:
        $row->pubend = $row->end;
        break;
    }
  } else {
  // Zuweisung des Veroeffentlichungsbeginns
    if (intval($_pubbegin_date)) {
      $dt = "$_pubbegin_date $_pubbegin_hour:$_pubbegin_minute:00";
    } else {
      $dt = $neudatum;
    }
    $row->pubbegin = strftime("%Y-%m-%d %H:%M:%S",strtotime($dt));

// Zuweisung des Veroeffentlichungsendes
    if (intval($_pubend_date)) {
      $dt = "$_pubend_date $_pubend_hour:$_pubend_minute:00";
    } else {
      $dt = date("Y-m-d 17:00:00");
    }
    $row->pubend = strftime("%Y-%m-%d %H:%M:%S",strtotime($dt));
  }

// Zugriffe korrigieren
  if($id>0) {
    $row->hits = $kurs->hits;
  }

// Gebuehr korrigieren
   $row->fees = str_replace(",",".",sem_f018($row->fees));

// Dateien bearbeiten
  if($id>0 OR $vorlage>0) {
    if(JRequest::getInt('deldatei1',0)!=1) {
      $row->file1 = $kurs->file1;
      $row->file1code = $kurs->file1code;
    } else {
      $row->file1 = "";
      $row->file1desc = "";
      $row->file1code = "";
      $row->file1down = 0;
    }
    if(JRequest::getInt('deldatei2',0)!=1) {
      $row->file2 = $kurs->file2;
      $row->file2code = $kurs->file2code;
    } else {
      $row->file2 = "";
      $row->file2desc = "";
      $row->file2code = "";
      $row->file2down = 0;
    }
    if(JRequest::getInt('deldatei3',0)!=1) {
      $row->file3 = $kurs->file3;
      $row->file3code = $kurs->file3code;
    } else {
      $row->file3 = "";
      $row->file3desc = "";
      $row->file3code = "";
      $row->file3down = 0;
    }
    if(JRequest::getInt('deldatei4',0)!=1) {
      $row->file4 = $kurs->file4;
      $row->file4code = $kurs->file4code;
    } else {
      $row->file4 = "";
      $row->file4desc = "";
      $row->file4code = "";
      $row->file4down = 0;
    }
    if(JRequest::getInt('deldatei5',0)!=1) {
      $row->file5 = $kurs->file5;
      $row->file5code = $kurs->file5code;
    } else {
      $row->file5 = "";
      $row->file5desc = "";
      $row->file5code = "";
      $row->file5down = 0;
    }
  }
  $fileext = explode(' ',strtolower($config->get('sem_p057','txt zip pdf')));
  $filesize = $config->get('sem_p056',200)*1024; 
  $fehler = array();
  if(is_file($_FILES['datei1']['tmp_name']) AND $_FILES['datei1']['size']>0) {
    $allesok = TRUE;
    if($_FILES['datei1']['size']>$filesize) {
      $allesok = FALSE;
      $fehler[] = str_replace("SEM_FILE",$_FILES['datei1']['name'],JTEXT::_('SEM_0141'));
    }
    $datei1ext = array_pop(explode( ".",strtolower($_FILES['datei1']['name'])));
    if(!in_array($datei1ext,$fileext)) {
      $allesok = FALSE;
      $fehler[] = str_replace("SEM_FILE",$_FILES['datei1']['name'],JTEXT::_('SEM_0142'));
    }
    if($allesok==TRUE) {
      $row->file1 = $_FILES['datei1']['name'];
      $row->file1code = base64_encode(file_get_contents($_FILES['datei1']['tmp_name']));
    }
  }
  if(is_file($_FILES['datei2']['tmp_name']) AND $_FILES['datei2']['size']>0) {
    $allesok = TRUE;
    if($_FILES['datei2']['size']>$filesize) {
      $allesok = FALSE;
      $fehler[] = str_replace("SEM_FILE",$_FILES['datei2']['name'],JTEXT::_('SEM_0141'));
    }
    $datei2ext = array_pop(explode( ".",strtolower($_FILES['datei2']['name'])));
    if(!in_array($datei2ext,$fileext)) {
      $allesok = FALSE;
      $fehler[] = str_replace("SEM_FILE",$_FILES['datei2']['name'],JTEXT::_('SEM_0142'));
    }
    if($allesok==TRUE) {
      $row->file2 = $_FILES['datei2']['name'];
      $row->file2code = base64_encode(file_get_contents($_FILES['datei2']['tmp_name']));
    }
  }
  if(is_file($_FILES['datei3']['tmp_name']) AND $_FILES['datei3']['size']>0) {
    $allesok = TRUE;
    if($_FILES['datei3']['size']>$filesize) {
      $allesok = FALSE;
      $fehler[] = str_replace("SEM_FILE",$_FILES['datei3']['name'],JTEXT::_('SEM_0141'));
    }
    $datei3ext = array_pop(explode( ".",strtolower($_FILES['datei3']['name'])));
    if(!in_array($datei3ext,$fileext)) {
      $allesok = FALSE;
      $fehler[] = str_replace("SEM_FILE",$_FILES['datei3']['name'],JTEXT::_('SEM_0142'));
    }
    if($allesok==TRUE) {
      $row->file3 = $_FILES['datei3']['name'];
      $row->file3code = base64_encode(file_get_contents($_FILES['datei3']['tmp_name']));
    }
  }
  if(is_file($_FILES['datei4']['tmp_name']) AND $_FILES['datei4']['size']>0) {
    $allesok = TRUE;
    if($_FILES['datei4']['size']>$filesize) {
      $allesok = FALSE;
      $fehler[] = str_replace("SEM_FILE",$_FILES['datei4']['name'],JTEXT::_('SEM_0141'));
    }
    $datei4ext = array_pop(explode( ".",strtolower($_FILES['datei4']['name'])));
    if(!in_array($datei4ext,$fileext)) {
      $allesok = FALSE;
      $fehler[] = str_replace("SEM_FILE",$_FILES['datei4']['name'],JTEXT::_('SEM_0142'));
    }
    if($allesok==TRUE) {
      $row->file4 = $_FILES['datei4']['name'];
      $row->file4code = base64_encode(file_get_contents($_FILES['datei4']['tmp_name']));
    }
  }
  if(is_file($_FILES['datei5']['tmp_name']) AND $_FILES['datei5']['size']>0) {
    $allesok = TRUE;
    if($_FILES['datei5']['size']>$filesize) {
      $allesok = FALSE;
      $fehler[] = str_replace("SEM_FILE",$_FILES['datei5']['name'],JTEXT::_('SEM_0141'));
    }
    $datei5ext = array_pop(explode( ".",strtolower($_FILES['datei5']['name'])));
    if(!in_array($datei5ext,$fileext)) {
      $allesok = FALSE;
      $fehler[] = str_replace("SEM_FILE",$_FILES['datei5']['name'],JTEXT::_('SEM_0142'));
    }
    if($allesok==TRUE) {
      $row->file5 = $_FILES['datei5']['name'];
      $row->file5code = base64_encode(file_get_contents($_FILES['datei5']['tmp_name']));
    }
  }
  return array($row,$fehler);
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Eingaben ueberpruefen          +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f078($row) {
  $database = &JFactory::getDBO();
  $fehler = array();

// Seminarnummer vorhanden und nicht doppelt
  if(sem_f067($row->semnum,'leer')) {
    $fehler[] = JTEXT::_('SEM_0150');
  } else {
    $database->setQuery("SELECT id FROM #__seminar WHERE semnum='$row->semnum' AND id!='$row->id'");
    $rows = $database->loadObjectList();
    if(count($rows)>0) {
      $fehler[] = JTEXT::_('SEM_0151');
    }
  }

// Titel vorhanden
  if(sem_f067($row->title,'leer')) {
    $fehler[] = JTEXT::_('SEM_0099');
  }

// Kategorie vorhanden
  if($row->catid==0) {
    $fehler[] = JTEXT::_('SEM_0101');
  }

// Kurzbeschreibung vorhanden
  if(sem_f067($row->shortdesc,'leer')) {
    $fehler[] = JTEXT::_('SEM_0182');
  }

// Veranstaltungsort vorhanden
  if(sem_f067($row->place,'leer')) {
    $fehler[] = JTEXT::_('SEM_0183');
  }

// Ende liegt vor Beginn
  if($row->begin>$row->end) {
    $fehler[] = JTEXT::_('SEM_0184');
  }

// Anmeldeschluss liegt nach Ende
  if($row->booked>$row->end) {
    $fehler[] = JTEXT::_('SEM_0185');
  }

// Wert der buchbaren Plaetze ist keine Zahl
  if(!sem_f067($row->maxpupil,'nummer')) {
    $fehler[] = JTEXT::_('SEM_0187');
  }

// Wert der max. buchbaren Plaetze je Teilnehmer ist keine Zahl
  if(!sem_f067($row->nrbooked,'nummer')) {
    $fehler[] = JTEXT::_('SEM_0188');
  }
  return $fehler;
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Ist Kurs buchbar               +++
// ++++++++++++++++++++++++++++++++++++++
// sem_f079(row,userid,frei,buchungsid,config)

function sem_f079() {
  $args = func_get_args();
  $row = $args[0];
  $userid = $args[1];
  $frei = $args[2];
  $buchungsid = $args[3];
  $config = $args[4];
  $reglevel = sem_f042();
  $neudatum = sem_f046();
  if(
    $neudatum>$row->booked
    OR $row->cancelled==1 
    OR ($frei<1 AND $row->stopbooking==1) 
    OR ($userid==$row->publisher AND $config->get('sem_p002',0)==0)
    OR $buchungsid>0
    OR $reglevel<1
    ) {
    return FALSE;
  } else {
    return TRUE;
  } 
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Oberes Hinweisfenster ausgeben +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f080() {
  $args = func_get_args();
  $art = $args[0];
  $hinweise = $args[1];
  $html = "<table class=\"sem_infobox\"><tr>";
  switch($art) {
    case 0:
      $image = sem_f045("0012");
      $class = "sem_info";
      break;
    case 1:
      $image = sem_f045("0014");
      $class = "sem_error";
      break;
  }
  if(is_array($hinweise)) {
    $ausgabe = implode("<br />",$hinweise);
  } else {
    $ausgabe = $hinweise;
  }
  $html .= "<td style=\"width: 12px;padding-top: 4px;vertical-align: top;\">".$image."</td>";
  $html .= "<td class=\"".$class."\">".$ausgabe."</td>";
  $html .= "</tr></table>";
  echo $html;
}

// ++++++++++++++++++++++++++++++++++++++
// +++ aktuelle Emailangaben laden   +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f082() {
  $database = &JFactory::getDBO();
  $database->setQuery( "SELECT * FROM #__sememails WHERE chosen= '1'");
  return $database->loadObject();
}

// ++++++++++++++++++++++++++++++++++++++
// +++ Pruefen auf Communities       +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f083($vorgabe) {
  $database = JFactory::getDBO();
  $user = &JFactory::getuser();
  // Pruefen auf Community Builder Enhanced Wert
  if(substr($vorgabe,0,4)=="CBE:" AND JComponentHelper::isEnabled("com_cbe", true) == true) {
    $cbfeld = substr($vorgabe,4);
    $database->setQuery("SELECT $cbfeld FROM #__cbe WHERE user_id='$user->id'");
    if($database->query()) {
      $vorgabe = $database->loadResult();
    }
  }
  // Pruefen auf Community Builder Wert
  if(substr($vorgabe,0,3)=="CB:" AND JComponentHelper::isEnabled("com_comprofiler", true) == true) {
    $cbfeld = substr($vorgabe,3);
    $database->setQuery("SELECT $cbfeld FROM #__comprofiler WHERE user_id='$user->id'");
    if($database->query()) {
      $vorgabe = $database->loadResult();
    }
  }
  // Pruefen auf JomSocial
  if(substr($vorgabe,0,3)=="JS:" AND JComponentHelper::isEnabled("com_community", true) == true) {
    $cbfeld = substr($vorgabe,3);
    $database->setQuery("SELECT id FROM #__community_fields WHERE fieldcode='$cbfeld'");
    if($database->query()) {
      $fieldid = $database->loadResult();
      $database->setQuery("SELECT value FROM #__community_fields_values WHERE field_id='$fieldid' && user_id='$user->id'");
      if($database->query()) {
        $vorgabe = $database->loadResult();
      }
    }
  }
  return $vorgabe;
}

// ++++++++++++++++++++++++++++++++++++++
// +++ PayPal Formular ausgeben       +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f084($id) {
  $database = &JFactory::getDBO();
  $config = &JComponentHelper::getParams('com_seminar');
  $lang = JFactory::getLanguage();
  $sprache = strtoupper(substr($lang->getName(),0,2));
// ItemID ermitteln
  $database->setQuery("SELECT id FROM #__menu WHERE link='index.php?option=com_seminar'");
  $tempitemid = $database->loadResult();
  $database->setQuery("SELECT * FROM #__sembookings WHERE id='".$id."'");
  $neu = $database->loadObject();
  $database->setQuery("SELECT * FROM #__seminar WHERE id='".$neu->semid."'");
  $row = $database->loadObject();
  $html = "";
  $baseurl = JURI::BASE()."index.php?option=com_seminar&Itemid=".$tempitemid;
  $ppurl = "https://www.paypal.com/cgi-bin/webscr";
  $ppemail = $config->get('sem_p109','');
  if($config->get('sem_p110','')!="") {
    $ppurl = "https://www.sandbox.paypal.com/cgi-bin/webscr";
    $ppemail = $config->get('sem_p110','');
  }
  $html .= "\n<form method=\"post\" name=\"PayPalForm\" id=\"PayPalForm\" action=\"".$ppurl."\">";
  $html .= "\n<input type=\"hidden\" name=\"rm\" value=\"2\"/>";
  $html .= "\n<input type=\"hidden\" name=\"cmd\" value=\"_xclick\"/>";
  $html .= "\n<input type=\"hidden\" name=\"charset\" value=\"utf-8\"/>";
  $html .= "\n<input type=\"hidden\" name=\"business\" value=\"".$ppemail."\"/>";
  $html .= "\n<input type=\"hidden\" name=\"email\" value=\"".$neu->email."\"/>";
  $html .= "\n<input type=\"hidden\" name=\"currency_code\" value=\"".$config->get("sem_p111","EUR")."\"/>";
  $html .= "\n<input type=\"hidden\" name=\"no_shipping\" value=\"".$config->get("sem_p113",2)."\"/>";
  $html .= "\n<input type=\"hidden\" name=\"lc\" value=\"".$sprache."\"/>";
  if($config->get("sem_p112","")!="") {
    $html .= "\n<input type=\"hidden\" name=\"image_url\" value=\"".$config->get("sem_p112","")."\"/>";
  }
  if($config->get("sem_p107",0)>0) {
    $html .= "\n<input type=\"hidden\" name=\"handling\" value=\"".$config->get("sem_p107",0)."\"/>";
  }
  $html .= "\n<input type=\"hidden\" name=\"return\" value=\"".$baseurl."&tesk=".base64_encode("pp1|".$art."|".$neu->uniqid)."\"/>";
  $html .= "\n<input type=\"hidden\" name=\"cancel_return\" value=\"".$baseurl."&tesk=".base64_encode("pp3|".$art."|".$neu->uniqid)."\"/>";
  $html .= "\n<input type=\"hidden\" name=\"notify_url\" value=\"".$baseurl."&tesk=".base64_encode("pp2|".$art."|".$neu->uniqid)."\"/>";
  $html .= "\n<input type=\"hidden\" name=\"item_name\" value=\"".JTEXT::_('SEM_0048').": ".$row->title."\"/>";
  $html .= "\n<input type=\"hidden\" name=\"amount\" value=\"".$row->fees."\"/>";
  $html .= "\n<input type=\"hidden\" name=\"quantity\" value=\"".$neu->nrbooked."\"/>";
  $html .= "\n</form> ";
  return $html;
}

// ++++++++++++++++++++++++++++++++++++++
// +++ PayPal Link erzeugen           +++
// ++++++++++++++++++++++++++++++++++++++

function sem_f085($id) {
  $database = &JFactory::getDBO();
  $config = &JComponentHelper::getParams('com_seminar');
  $lang = JFactory::getLanguage();
  $sprache = strtoupper(substr($lang->getName(),0,2));
// ItemID ermitteln
  $database->setQuery("SELECT id FROM #__menu WHERE link='index.php?option=com_seminar'");
  $tempitemid = $database->loadResult();
  $database->setQuery("SELECT * FROM #__sembookings WHERE id='".$id."'");
  $neu = $database->loadObject();
  $database->setQuery("SELECT * FROM #__seminar WHERE id='".$neu->semid."'");
  $row = $database->loadObject();
  $baseurl = JURI::BASE()."index.php?option=com_seminar%26Itemid=".$tempitemid;
  $ppurl = "https://www.paypal.com/cgi-bin/webscr";
  $ppemail = $config->get('sem_p109','');
  if($config->get('sem_p110','')!="") {
    $ppurl = "https://www.sandbox.paypal.com/cgi-bin/webscr";
    $ppemail = $config->get('sem_p110','');
  }
  $ppurl .= "?cmd=_xclick&charset=utf-8&rm=2&business=".$ppemail."&currency_code=".$config->get("sem_p111","EUR");
  $ppurl .= "&no_shipping=".$config->get("sem_p113",2)."&lc=".$sprache."&email=".$neu->email;
  if($config->get("sem_p112","")!="") {
    $ppurl .= "&image_url=".$config->get("sem_p112","");
  }
  if($config->get("sem_p107",0)>0) {
    $ppurl .= "&handling=".$config->get("sem_p107",0);
  }
  $ppurl .= "&return=".$baseurl."%26tesk=".base64_encode("pp1|".$art."|".$neu->uniqid);
  $ppurl .= "&cancel_return=".$baseurl."%26tesk=".base64_encode("pp3|".$art."|".$neu->uniqid);
  $ppurl .= "&notify_url=".$baseurl."%26tesk=".base64_encode("pp2|".$art."|".$neu->uniqid);
  $ppurl .= "&item_name=".JTEXT::_('SEM_0048').": ".$row->title;
  $ppurl .= "&amount=".$row->fees;
  $ppurl .= "&quantity=".$neu->nrbooked;
  return $ppurl;
}

// ++++++++++++++++++++++++++++++++++++++
// +++ DB fuer Buchungen              +++
// ++++++++++++++++++++++++++++++++++++++

class mosSembookings extends JTable {
  var $id=null;
  var $uniqid=null;
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
  var $paiddate=null;
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
  var $prebooked=0;
  var $bookedpupil=0;
  var $stopbooking=0;
  var $cancelled=0;
  var $begin="0000-00-00 00:00:00";
  var $end="0000-00-00 00:00:00";
  var $booked="0000-00-00 00:00:00";
  var $pubbegin="0000-00-00 00:00:00";
  var $pubend="0000-00-00 00:00:00";
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
  var $zusatz1nl=0;
  var $zusatz2nl=0;
  var $zusatz3nl=0;
  var $zusatz4nl=0;
  var $zusatz5nl=0;
  var $zusatz6nl=0;
  var $zusatz7nl=0;
  var $zusatz8nl=0;
  var $zusatz9nl=0;
  var $zusatz10nl=0;
  var $zusatz11nl=0;
  var $zusatz12nl=0;
  var $zusatz13nl=0;
  var $zusatz14nl=0;
  var $zusatz15nl=0;
  var $zusatz16nl=0;
  var $zusatz17nl=0;
  var $zusatz18nl=0;
  var $zusatz19nl=0;
  var $zusatz20nl=0;
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
  var $request1="";
  var $request2="";
  var $request3="";
  var $request4="";
  var $request5="";
  var $request6="";
  var $request7="";
  var $request8="";
  var $request9="";
  var $request10="";
  var $request11="";
  var $request12="";
  var $request13="";
  var $request14="";
  var $request15="";
  var $request16="";
  var $request17="";
  var $request18="";
  var $request19="";
  var $request20="";
  var $request1hint="";
  var $request2hint="";
  var $request3hint="";
  var $request4hint="";
  var $request5hint="";
  var $request6hint="";
  var $request7hint="";
  var $request8hint="";
  var $request9hint="";
  var $request10hint="";
  var $request11hint="";
  var $request12hint="";
  var $request13hint="";
  var $request14hint="";
  var $request15hint="";
  var $request16hint="";
  var $request17hint="";
  var $request18hint="";
  var $request19hint="";
  var $request20hint="";
  var $request1show=0;
  var $request2show=0;
  var $request3show=0;
  var $request4show=0;
  var $request5show=0;
  var $request6show=0;
  var $request7show=0;
  var $request8show=0;
  var $request9show=0;
  var $request10show=0;
  var $request11show=0;
  var $request12show=0;
  var $request13show=0;
  var $request14show=0;
  var $request15show=0;
  var $request16show=0;
  var $request17show=0;
  var $request18show=0;
  var $request19show=0;
  var $request20show=0;
  var $request1nl="1";
  var $request2nl="1";
  var $request3nl="1";
  var $request4nl="1";
  var $request5nl="1";
  var $request6nl="1";
  var $request7nl="1";
  var $request8nl="1";
  var $request9nl="1";
  var $request10nl="1";
  var $request11nl="1";
  var $request12nl="1";
  var $request13nl="1";
  var $request14nl="1";
  var $request15nl="1";
  var $request16nl="1";
  var $request17nl="1";
  var $request18nl="1";
  var $request19nl="1";
  var $request20nl="1";
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

// ++++++++++++++++++++++++++++++++++++++
// +++ DB fuer Seminarteilnehmer         +++
// ++++++++++++++++++++++++++++++++++++++

class mosSemattendees extends JTable {
  var $id=null;
  var $semid=null;
  var $sembid=null;
  var $ordering=null;
  var $fees=null;
  var $publishdate="0000-00-00 00:00:00";
  var $request1="";
  var $request2="";
  var $request3="";
  var $request4="";
  var $request5="";
  var $request6="";
  var $request7="";
  var $request8="";
  var $request9="";
  var $request10="";
  var $request11="";
  var $request12="";
  var $request13="";
  var $request14="";
  var $request15="";
  var $request16="";
  var $request17="";
  var $request18="";
  var $request19="";
  var $request20="";
  function mosSemattendees( &$db ) {
    parent::__construct( '#__semattendees', 'id', $db );
  }
}


?>
