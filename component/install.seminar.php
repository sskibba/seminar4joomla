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
    $database->setQuery("ALTER TABLE #__seminar MODIFY title varchar(255)");
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
    $database->setQuery("ALTER table #__seminar DROP INDEX semnum");
    $database->query();
    @unlink(JPATH_ADMINISTRATOR."/components/com_seminar/toolbar.seminar.php");
    @unlink(JPATH_ADMINISTRATOR."/components/com_seminar/toolbar.seminar.html.php");
    @unlink(JPATH_SITE."/components/com_seminar/seminar.0.css");
    @unlink(JPATH_SITE."/components/com_seminar/seminar.1.css");
    $update = " - Upgrade";
  }
  $imagedir = "../components/com_seminar/images/";
  $lang = JFactory::getLanguage();
  $sprache = strtolower(substr($lang->getName(),0,2));
  $html = "<img src=\"".$imagedir."menulogo.png\" valign=\"middle\"><font size=\"+1\" color=\"#0B55C4\"> Seminar".$update."</font>";
  $html .= "<div align=\"center\"><table border=\"0\" width=\"90%\"><tbody>";
  $html .= "<tr><td width=\"18%\"><b>Autor:</b></td><td width=\"80%\">Dirk Vollmar</td></tr>";
  $html .= "<tr><td width=\"18%\"><b>Internet:</b></td><td width=\"80%\"><a target=\"_blank\" href=\"http://seminar.vollmar.ws\">http://seminar.vollmar.ws</a></td></tr>";
  $html .= "<tr><td width=\"18%\"><b>Version:</b></td><td width=\"80%\">1.3.0</td></tr>";
  switch($sprache) {
    case "de":
      $html .= "<tr><td colspan=\"2\">";
      $html .= "Mit <i>Seminar f&uuml;r Joomla!</i> haben Sie sich f&uuml;r ein leistungsstarkes Buchungssystem f&uuml;r Ihre joomla!-Seite entschieden. "; 
      $html .= "Egal, ob Sie Fortbildungen anbieten, Ihr Verein Ausfl&uuml;ge veranstaltet oder Sie zu einer Party einladen m&ouml;chten: Mit <i>Seminar für joomla!</i> ist die Verwaltung der Veranstaltungen kein Problem. <p>";
      if($upgrade=="") {
        $html .= "<font color=\"#FF0000\">Bevor Sie die ersten Kurse eingeben, sollten Sie &uuml;ber die Parameter die gew&uuml;nschten Funktionen freischalten (Versand von Best&auml;tigungs-E-Mails, Bewertungssystem, Zertifizierungssystem, etc.).</font><p>";
      } else {
        $html .= "<font color=\"#FF0000\">Da viele neue Parameter hinzugekommen sind, überprüfen Sie bitte als erstes die Einstellungen von Seminar..</font><p>";
      }
      $html .= "Wenn Sie Google-Maps nutzen wollen, m&uuml;ssen Sie unter <a href=\"http://code.google.com/apis/maps/signup.html\" target=\"_new\">http://code.google.com/apis/maps/signup.html</a> einen Schl&uuml;ssel f&uuml;r Ihre Webseite erzeugen und ihn bei den Parametern der Seminar-Komponente eingeben.<p>";
      $html .= "<i>Seminar f&uuml;r joomla!</i> wurde unter der <a href=\"http://www.gnu.org/licenses/gpl.html\" target=\"_new\">GNU General Public License</a> ver&ouml;ffentlicht.<p>";
      $html .= "<b>Neu in Version 1.3.0</b><p>";
      $html .= "<ul>";
      $html .= "<li>Die grundlegenden Datumsformate werden durch die Sprachdateien festgelegt. Darüberhinaus können Sie aber durch Angaben in den Einstellungen überschrieben werden.";
      $html .= "<li>Joomfish wird direkt unterstützt.";
      $html .= "<li>In der Beschreibung können nun Tags steuern, wer bestimmte Textteile angezeigt bekommt. So wird bei der Angabe von [sem_registered] TEXT [/sem_registered] TEXT nur den registrierten Benutzern angezeigt.";
      $html .= "<li>Die Eingabelder können vorbelegt werden. Dazu musste aber das Steuerformat geändert werden. Es hat nun das Format Bezeichner|Pflichtfeld|Vorgabewert|Feldtyp|Parameter|Parameter|... Alte Veranstaltungen müssen leider angepasst werden.";
      $html .= "<li>In den Einstellungen kann festgelegt werden, ab wann die aktuellen Kurse nicht mehr angezeigt werden sollen (Beginn, Ende oder Anmeldeschluss der Veranstaltung). Diese Einstellung wird auch im Modul berücksichtigt.";
      $html .= "<li>Die Sommerzeit wird automatisch berücksichtigt (optional). Damit muss die Zeitzone während der Sommerzeit nicht extra auf +2 gestellt werden. Auch das Modul greift auf diese Einstellung zurück.";
      $html .= "<li>Die im Textfeld 'Beschreibung' verwendeten Markierungen für die Plugins vom Typ 'Inhalt' werden in HTML-Code umgesetzt.";
      $html .= "<li>Die Begrenzung der Zusatzfelder auf 120 Zeichen wurde aufgehoben.";
      $html .= "<li>Das Zahlenformat für die Währung kann festgelegt werden (Dezimalstellen, Tausender-Trennzeichen, Dezimal-Trennzeichen).";
      $html .= "<li>Bei kostenpflichtigen Veranstaltungen wird der Preis stärker hervorgehoben dargestellt als bisher.";
      $html .= "<li>Wird die Infozeile in der Übersicht ausgeblendet, so werden auch die freien Plätze in der Detailansicht nicht mehr angezeigt.";
      $html .= "<li>Beim nachträglichen Ändern einer Veranstaltung wurden die Zugriffe auf 0 zurückgesetzt. Der Fehler ist behoben.";
      $html .= "<li>Veranstaltungsbuchungen können von den Benutzern nur so lange geändert werden, bis die Buchung als bezahlt markiert wurde. danach sind Änderungen nur noch durch den Veranstalter möglich.";
      $html .= "<li>Werden bei einer Veranstaltung die maximal buchbaren Plätze auf 0 gesetzt, ist diese nicht mehr online buchbar und dient als Veranstaltungsankündigung.";
      $html .= "<li>Die Einstellungen im Backend sind nun direkt aufrufbar und nicht mehr über ein Fenster.";
      $html .= "<li>Für die Teilnehmerübersichten der Benutzer kann zwischen Realnamen und Benutzernamen gewählt werden.";
      $html .= "<li>Der Eingabebereich der Veranstaltungen wurde aufgeteilt (Grundangaben, Zusatzangaben, Eingabefelder, Dateien), um die inzwischen sehr umfangreichen Eingabemöglichkeiten strukturierter darzustellen.";
      $html .= "<li>An jede Veranstaltung können bis zu 5 Dateien angehängt werden. Dabei ist einzeln einstellbar, wer diese Dateien herunterladen darf (jeder, registrierte Benutzer, Benutzer die die Veranstaltung gebucht haben, Benutzer die die Veranstaltung bezahlt haben). Über die Parameter kann die max. Größe und die erlaubten Dateitypen festgelegt werden.";
      $html .= "<li>Die Veranstaltungsleitung kann nun auch HTML-Code enthalten, um z.B. einen Link auf ein Benutzerprofil zu ermöglichen.";
      $html .= "<li>Für jeden Bereich (Veranstaltungen, Meine Buchungen, Meine Angebote) können in den Einstellungen die Module der oberen Auswahlzeile (Anzahl, Suche, Kategorien, ...) festgelegt werden. Auch das Ausblenden der Auswahlzeile ist möglich.";
      $html .= "<li>In der Detailansicht kann eine Kalender-Datei im ICAL-Format heruntergeladen werden. Damit kann der Benutzer die Veranstaltungen in seinen Kalender (z.B. Outlook) eintragen lassen (Einstellung in den Parametern).";
      $html .= "<li>Das Anmelden und Abmelden an die joomla!-Webseite kann nun direkt in Seminar erfolgen (Einstellung in den Parametern).";
      $html .= "<li>Es ist möglich, Vorlagen für Veranstaltungen anzulegen und zu verwalten.";
      $html .= "<li>In den Einstellungen kann festgelegt werden, ab welchem Level ein Benutzer im Frontend Veranstaltungen eingeben darf.";
      $html .= "<li>Der CSV-Download klappte nicht richtig, wenn im Datensatz eine Eurozeichen (€) angezeigt wurde. Das lag an der Umsetzung von UTF-8 in ISO-8559-1. Daher wird nun als Standard-Codierung für die CSV-Datei ISO-8559-15 verwendet, falls in den Einstellungen keine andere Kodierung angegeben wurde.";
      $html .= "<li>Beim ersten Aufruf des Ausdrucks der Veranstaltungsübersicht wurden immer fünf statt der in den Einstellungen vorgegebenen Anzahl der Veranstaltungen ausgedruckt.";
      $html .= "<li>Beim Zurücksetzen der Übersicht wurde die Anzahl der angezeigten Veranstaltungen immer auf fünf gesetzt. Nun wird die in den Einstellungen angegebene Anzahl verwendet.";
      $html .= "<li>Beim Beginn, beim Ende und beim Anmeldeschluss einer Veranstaltung kann angegeben werden, ob die eingegebene Zeit angezeigt werden soll. So lassen sich Missverständnisse z.B. bei Veranstaltungen mit offenem Ende vermeiden.";
      $html .= "<li>In der Benachrichtigungs-E-Mails wird die Buchungs-ID angezeigt.";
      $html .= "<li>Die Anzahl der der eingebbaren Zeichen des Veranstaltungstitels wurde auf 255 erhöht.";
      $html .= "<li>Bei jedem Eingabefeld kann angegeben werden, ob es in den Teilnehmerübersichten angezeigt werden soll.";
      $html .= "<li>Einige zwingende Angaben wurden zu optionalen Angaben geändert (Leitung, Zielgruppe).";
      $html .= "<li>Für jedes Eingabefeld kann ein Erläuterungstext angegeben werden.";
      $html .= "<li>Die Zahl der optionalen Eingabefelder wurde auf 20 erhöht.";
      $html .= "<li>Die Veranstaltungen können auch in einem RSS-Feed veröffentlicht werden.";
      $html .= "<li>Die Veranstaltungsnummer kann frei vergegeben werden.";
      $html .= "<li>Auf der Veranstaltungsübersicht werden alle Veranstaltungen angezeigt, die noch nicht beendet wurden, falls der Anmeldeschluss nach dem Veranstaltungsbeginn liegt. Dadurch ist es möglich, auch noch Plätze bei bereits laufenden Veranstaltungen zu buchen.";
      $html .= "<li>Das Grundlayout wurde überarbeitet. Es werden die grundlegenden Elemente des Templates übernommen (Schriftart, Verweisfarben, etc.). Natürlich ist es nach wie vor über die CSS-Datei auf eigene Bedürfnisse anpassbar.";
      $html .= "<li>Für Webseiten mit dunklem Template wurde ein dunkles Layout ergänzt, das in den Backendparametern statt des hellen Layouts gewählt werden kann.";
      $html .= "</ul>";
      $html .= "</td>";
      break;
    default:
      $html .= "<tr><td colspan=\"2\">";
      $html .= "Please fill in the parameters first.<p>";
      $html .= "If you want to use Google-Maps , you have to create an API-key <a href=\"http://code.google.com/apis/maps/signup.html\" target=\"_new\">http://code.google.com/apis/maps/signup.html</a> and fill in the key into the parameters.<p>";
      $html .= "<i>Seminar for joomla!</i> has been released under the <a href=\"http://www.gnu.org/licenses/gpl.html\" target=\"_new\">GNU general public license</a>.<p>";
      $html .= "English translation by Mark Berry, <a href=\"http://www.mcbsys.com\">MCB Systems</a>.<p>";
      $html .= "</td>";
      break;
  }
  $html .= "</tr></tbody></table></div>";
  echo $html;
}

?>
