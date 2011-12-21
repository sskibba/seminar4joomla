<?php

//********************************************
//**** Seminar for joomla! - Search-Plugin ***
//****            Version 1.0.0            ***
//********************************************
//****     Copyright (c) Dirk Vollmar      ***
//****                2010                 ***
//****          joomla@vollmar.ws          ***
//****         All rights reserved         ***
//********************************************
//**     Released under GNU/GPL License      *
//**  http://www.gnu.org/licenses/gpl.html   *
//********************************************

defined( '_JEXEC' ) or die( 'Restricted access' );
$mainframe->registerEvent( 'onSearch','plgSearchSeminarTitles' );
$mainframe->registerEvent( 'onSearchAreas', 'plgSearchSeminarAreas' );

// Bereiche durchsuchen
function plgSearchSeminarAreas() {
  static $areas = array('seminar' => 'Seminar');
  return $areas;
}

// Seminarfelder durchsuchen
function plgSearchSeminarTitles($text,$phrase='',$ordering='',$areas=null) {
  if (is_array($areas)) {
    if (!array_intersect($areas,array_keys(plgSearchSeminarAreas()))) {
      return array();
    }
  }

// Kein Suchtext vorhanden
  $text = trim($text);
  if ($text == "") {
    return array();
  }

// Vorbereitungen
  $database = &JFactory::getDBO();
  $my = &JFactory::getuser();
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
  $neudatum = $date->toformat();
  $database->setQuery("SELECT id FROM #__menu WHERE link='index.php?option=com_seminar'");
  $tempitemid = $database->loadResult();
  $plugin = &JPluginHelper::getPlugin('search', 'seminar');
  $pluginParams = new JParameter($plugin->params);
  $slimit = $pluginParams->def('search_limit',50);
  $sname = $pluginParams->def('search_name','Seminar');

// Einschraenkungen festlegen
  $where = array();
  $utype = strtolower($my->usertype);
  switch( $utype ) {
    case "registered":
      $reglevel = 2;
      break;
    case "author":
      $reglevel = 2;
      break;
    case "editor":
      $reglevel = 2;
      break;
    case "publisher":
      $reglevel = 2;
      break;
    case "manager":
      $reglevel = 3;
      break;
    case "administrator":
      $reglevel = 3;
      break;
    case "super administrator":
      $reglevel = 3;
      break;
    default:
      $reglevel = 1;
      break;
  }
  $database->setQuery("SELECT id, access FROM #__categories WHERE section='com_seminar'");
  $cats = $database->loadObjectList();
  $allowedcat = array();
  foreach($cats AS $cat) {
    if($cat->access<$reglevel) {
      $allowedcat[] = $cat->id;
    }
  }
  if(count($allowedcat)>0) {
    $allowedcat = implode(',',$allowedcat);
    $where[] = "a.catid IN ($allowedcat)";
  }
  $where[] = "a.published = '1'";
  $where[] = "a.pattern = ''";
  switch ($config->get('sem_p064',2)) {
    case "0":
      $showend = "a.begin";
      break;
    case "1":
      $showend = "a.booked";
      break;
    default:
      $showend = "a.end";
      break;
  }
  $where[] = "$showend > '$neudatum'";

// Sortierung festlegen
  $order = '';
  switch($ordering) {
    case 'newest':
      $order = 'ORDER BY a.id DESC';
      break;
  case 'oldest':
      $order = 'ORDER BY a.id';
      break;
  case 'popular':
      $order = 'ORDER BY a.hits';
      break;
  case 'alpha':
      $order = 'ORDER BY title';
      break;
  case 'category':
      $order = 'ORDER BY category';
      break;
  }

  switch($phrase) {
    case 'exact':
      $text = preg_replace ('/\s/',' ',trim( $text ));
      $suche = "\nAND (a.semnum LIKE '%".$text."%' OR a.gmaploc LIKE '%".$text."%' OR a.target LIKE '%".$text."%' OR a.place LIKE '%".$text."%' OR a.teacher LIKE '%".$text."%' OR a.title LIKE '%".$text."%' OR a.shortdesc LIKE '%".$text."%' OR a.description LIKE '%".$text."%')";
      break;
    case 'all':
    case 'any':
    default:
      $text =  preg_replace ('/\s\s+/',' ',trim( $text ));
      $words = explode( ' ', $text );
      $suche = array();
      foreach ($words as $word) {
        $word = $database->Quote( '%'.$database->getEscaped( $word, true ).'%', false );
        $suche2 	= array();
        $suche2[] 	= "a.semnum LIKE $word";
        $suche2[] 	= "a.gmaploc LIKE $word";
        $suche2[] 	= "a.target LIKE $word";
        $suche2[] 	= "a.place LIKE $word";
        $suche2[] 	= "a.teacher LIKE $word";
        $suche2[] 	= "a.title LIKE $word";
        $suche2[] 	= "a.shortdesc LIKE $word";
        $suche2[] 	= "a.description LIKE $word";
        $suche3[] 	= implode(' OR ',$suche2 );
      }
      $suche = "\nAND (".implode(($phrase=='all' ? ') AND (' : ') OR ('),$suche3). ")";
      break;
   }

// Rueckgabe des Suchergebnisses
  $database->setQuery("SELECT a.title AS title,"
    ." a.begin AS begin,"
    ." a.publishdate AS created,"
    ." a.shortdesc AS text,"
    ." CONCAT( 'index.php?option=com_seminar&Itemid=".$tempitemid."&task=3&cid=',a.id) AS href,"
    ." '2' AS browsernav,"
    ." '".$sname."' AS section,"
    ." b.title AS category"
    ." FROM #__seminar AS a"
    ." LEFT JOIN #__categories AS b ON b.id = a.catid"
    . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
    . $suche
    . $order
    . " LIMIT 0, ".$slimit
  );
  $rows = $database->loadObjectList();
  for($i=0;$i<count($rows);$i++) {
    $date = JFactory::getDate($rows[$i]->begin);
    $rows[$i]->section=$rows[$i]->section." - ".$date->toFormat(JTEXT::_('DATE_FORMAT_LC2'));
    $rows[$i]->Itemid=$tempitemid;
  }
  return $rows;
}
?>