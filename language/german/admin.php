<?php
// $Id: admin.php,v 2.3 2005/11/01 12:25:54 phppp Exp $
//%%%%%%	File Name  index.php   	%%%%%
//$constpref = '_AM_' . strtoupper( basename( dirname(  dirname(  dirname( __FILE__ ) ) ) ) ) ;
$constpref = '_AM_NEWBB';
define($constpref."_FORUMCONF","Forumkonfiguration");
define($constpref."_ADDAFORUM","Forum hinzufügen");
define($constpref."_SYNCFORUM","Forum synchronisieren");
define($constpref."_REORDERFORUM","Neu ordnen");
define($constpref."_FORUM_MANAGER","Foren");
define($constpref."_PRUNE_TITLE","Aufräumen");
define($constpref."_CATADMIN","Kategorien");
define($constpref."_GENERALSET", "Moduleinstellungen" );
define($constpref."_MODULEADMIN","Moduladministration:");
define($constpref."_HELP","Hilfe");
define($constpref."_ABOUT","Über");
define($constpref."_BOARDSUMMARY","Forenstatistik");
define($constpref."_PENDING_POSTS_FOR_AUTH","Noch freizugebende Beiträge");
define($constpref."_POSTID","Beitrags-ID");
define($constpref."_POSTDATE","Beitragsdatum");
define($constpref."_POSTER","Autor");
define($constpref."_TOPICS","Themen");
define($constpref."_SHORTSUMMARY","Forenzusammenfassung");
define($constpref."_TOTALPOSTS","Beiträge gesamt");
define($constpref."_TOTALTOPICS","Themen gesamt");
define($constpref."_TOTALVIEWS","Aufrufe gesamt");
define($constpref."_BLOCKS","Blöcke");
define($constpref."_SUBJECT","Betreff");
define($constpref."_APPROVE","Beitrag freigeben");
define($constpref."_APPROVETEXT","Inhalt dieses Beitrags");
define($constpref."_POSTAPPROVED","Beitrag wurde freigegeben");
define($constpref."_POSTNOTAPPROVED","Beitrag wurde NICHT freigegeben");
define($constpref."_POSTSAVED","Beitrag wurde gespeichert");
define($constpref."_POSTNOTSAVED","Beitrag wurde NICHT gespeichert");

define($constpref."_TOPICAPPROVED","Thema wurde freigegeben");
define($constpref."_TOPICNOTAPPROVED","Thema wurde nicht freigegeben");
define($constpref."_TOPICID","Themen-ID");
define($constpref."_ORPHAN_TOPICS_FOR_AUTH","Freigabe von nicht freigegebenen Beiträgen");


define($constpref.'_DEL_ONE','Nur diesen Beitrag löschen');
define($constpref.'_POSTSDELETED','Ausgewählter Beitrag wurde gelöscht.');
define($constpref.'_NOAPPROVEPOST','Zur Zeit gibt es keine Beiträge, die auf Freigabe warten.');
define($constpref.'_SUBJECTC','Betreff:');
define($constpref.'_MESSAGEICON','Beitragssymbol:');
define($constpref.'_MESSAGEC','Beitrag:');
define($constpref.'_CANCELPOST','Beitrag abbrechen');
define($constpref.'_GOTOMOD','Gehe zum Modul');

define($constpref.'_PREFERENCES','Modulvoreinstellungen');
define($constpref.'_POLLMODULE','Umfragemodul');
define($constpref.'_POLL_OK','einsatzbereit');
define($constpref.'_GDLIB1','GD1-Library:');
define($constpref.'_GDLIB2','GD2-Library:');
define($constpref.'_AUTODETECTED','Automatisch ermittelt: ');
define($constpref.'_AVAILABLE','verfügbar');
define($constpref.'_NOTAVAILABLE','<font color="red">nicht verfügbar</font>');
define($constpref.'_NOTWRITABLE','<font color="red">nicht beschreibbar</font>');
define($constpref.'_IMAGEMAGICK','ImageMagick');
define($constpref.'_IMAGEMAGICK_NOTSET','nicht bereit');
define($constpref.'_ATTACHPATH','Pfad zum Speicherort der Dateianhänge');
define($constpref.'_THUMBPATH','Pfad für beigefügte Bildvorschauen');
//define($constpref.'_RSSPATH','Pfad für RSS-Dateien');
define($constpref.'_REPORT','Gemeldete Beiträge');
define($constpref.'_REPORT_PENDING','Meldung in Bearbeitung');
define($constpref.'_REPORT_PROCESSED','Bearbeitete Meldung');

define($constpref.'_CREATETHEDIR','Anlegen');
define($constpref.'_SETMPERM','Berechtigung setzen');
define($constpref.'_DIRCREATED','Das Verzeichnis wurde angelegt');
define($constpref.'_DIRNOTCREATED','Das Verzeichnis konnte nicht angelegt werden');
define($constpref.'_PERMSET','Die Berechtigung wurde gesetzt');
define($constpref.'_PERMNOTSET','Die Berechtigung konnte nicht gesetzt werden');

define($constpref.'_DIGEST','Digest-Benachrichtigungen');
define($constpref.'_DIGEST_PAST','<font color="red">Sollte vor %d Minuten abgeschickt worden sein.</font>');
define($constpref.'_DIGEST_NEXT','Soll in %d Minuten abgeschickt werden');
define($constpref.'_DIGEST_ARCHIVE','Digest-Archiv');
define($constpref.'_DIGEST_SENT','Digest verarbeitet.');
define($constpref.'_DIGEST_FAILED','Digest nicht verarbeitet.');

// admin_forum_manager.php
define($constpref."_NAME","Name");
define($constpref."_CREATEFORUM","Forum anlegen");
define($constpref."_EDIT","Bearbeiten");
define($constpref."_CLEAR","Leeren");
define($constpref."_DELETE","Löschen");
define($constpref."_ADD","Hinzufügen");
define($constpref."_MOVE","Verschieben");
define($constpref."_ORDER","Sortieren");
define($constpref."_TWDAFAP","Hinweis: Dieser Vorgang wird das Forum und alle enthaltenen Beiträge löschen.<br /><br />WARNUNG: Sicher, dass das Forum gelöscht werden soll?");
define($constpref."_FORUMREMOVED","Forum gelöscht.");
define($constpref."_CREATENEWFORUM","Ein neues Forum erstellen.");
define($constpref."_EDITTHISFORUM","Forum bearbeiten:");
define($constpref."_SET_FORUMORDER","Forumsposition angeben:");
define($constpref."_ALLOWPOLLS","Umfragen zulassen?");
define($constpref."_ATTACHMENT_SIZE" ,"Max. Größe in KB:");
define($constpref."_ALLOWED_EXTENSIONS", "Zugelassene Erweiterungen:<span style='font-size: xx-small; font-weight: normal; display: block;'>'*' bedeutet keine Einschränkungen.<br /> Erweiterungen werden durch '|' getrennt.</span>");
define($constpref."_ALLOW_ATTACHMENTS", "Anhänge zulassen?");
define($constpref."_ALLOWHTML","HTML zulassen?");
define($constpref."_YES","Ja");
define($constpref."_NO","Nein");
define($constpref."_ALLOWSIGNATURES","Signaturen zulassen?");
define($constpref."_HOTTOPICTHRESHOLD","Schwellenwert für 'Heisse Themen':");
//define($constpref."_POSTPERPAGE","Posts per Page:<span style='font-size: xx-small; font-weight: normal; display: block;'>(This is the number of posts<br /> per topic that will be<br /> displayed per page.)</span>");
//define($constpref."_TOPICPERFORUM","Topics per Forum:<span style='font-size: xx-small; font-weight: normal; display: block;'>(This is the number of topics<br /> per forum that will be<br /> displayed per page.)</span>");
//define($constpref."_SHOWNAME","Replace user's name with real name:");
//define($constpref."_SHOWICONSPANEL","Show icons panel:");
//define($constpref."_SHOWSMILIESPANEL","Show smilies panel:");
define($constpref."_MODERATOR_REMOVE","Derzeitige Moderatoren entfernen");
define($constpref."_MODERATOR_ADD","Moderator(en) hinzufügen");
define($constpref."_ALLOW_SUBJECT_PREFIX", "Themen-Präfixe zulassen?");
define($constpref."_ALLOW_SUBJECT_PREFIX_DESC", "Dies lässt Präfixe zu, die zur Themenbezeichnung hinzugefügt werden.");


// admin_cat_manager.php

define($constpref."_SETCATEGORYORDER","Kategorieposition angeben:");
define($constpref."_ACTIVE","Aktiv");
define($constpref."_INACTIVE","Inaktiv");
define($constpref."_STATE","Status:");
define($constpref."_CATEGORYDESC","Kategoriebeschreibung:");
define($constpref."_SHOWDESC","Beschreibung anzeigen?");
define($constpref."_IMAGE","Image:");
//define($constpref."_SPONSORIMAGE","Sponsor Image:");
define($constpref."_SPONSORLINK","Sponsorlink:");
define($constpref."_DELCAT","Kategorie löschen");
define($constpref."_WAYSYWTDTTAL","Hinweis: Dieser Vorgang löscht NICHT die Themen in dieser Kategorie, dies geschieht im 'Forum bearbeiten'-Bereich.<br /><br />WARNUNG: Sicher, dass diese Kategorie gelöscht werden soll?");



//%%%%%%        File Name  admin_forums.php           %%%%%
define($constpref."_FORUMNAME","Forumname:");
define($constpref."_FORUMDESCRIPTION","Forumbeschreibung:");
define($constpref."_MODERATOR","Moderator(en):");
define($constpref."_REMOVE","Entfernen");
define($constpref."_CATEGORY","Kategorie:");
define($constpref."_DATABASEERROR","Datenbankfehler");
define($constpref."_CATEGORYUPDATED","Kategorie aktualisiert.");
define($constpref."_EDITCATEGORY","Kategorie bearbeiten:");
define($constpref."_CATEGORYTITLE","Kategorietitel:");
define($constpref."_CATEGORYCREATED","Kategorie hinzugefügt.");
define($constpref."_CREATENEWCATEGORY","Neue Kategorie hinzufügen");
define($constpref."_FORUMCREATED","Forum hinzugefügt.");
define($constpref."_ACCESSLEVEL","Allgemeiner Zugriffslevel:");
define($constpref."_CATEGORY1","Kategorie");
define($constpref."_FORUMUPDATE","Forumseinstellungen aktualisiert");
define($constpref."_FORUM_ERROR","FEHLER: Fehler in den Forumseinstellungen");
define($constpref."_CLICKBELOWSYNC","Ein Klick auf die untenstehende Schaltfläche synchronisiert Ihre Foren und Themenbereiche mit dem tatsächlichen Datenbankbestand. Diese Funktion immer dann benutzen, wenn Ungereimtheiten in der Darstellung der Themen- und Forenlisten feststellen.");
define($constpref."_SYNCHING","Forum-, Index- und Themenbereiche werden synchronisiert (Dies kann einen Augenblick dauern)");
define($constpref."_CATEGORYDELETED","Kategorie gelöscht.");
define($constpref."_MOVE2CAT","In folgende Kategorie verschieben:");
define($constpref."_MAKE_SUBFORUM_OF","Unterforum von:");
define($constpref."_MSG_FORUM_MOVED","Forum verschoben!");
define($constpref."_MSG_ERR_FORUM_MOVED","Verschieben des Forums fehlgeschlagen.");
define($constpref."_SELECT","< Auswählen >");
define($constpref."_MOVETHISFORUM","Dieses Forum verschieben.");
define($constpref."_MERGE","Zusammenfügen");
define($constpref."_MERGETHISFORUM","Dieses Forum zusammenfügen");
define($constpref."_MERGETO_FORUM","Dieses Forum zusammenfügen mit:");
define($constpref."_MSG_FORUM_MERGED","Forum zusammengefügt");
define($constpref."_MSG_ERR_FORUM_MERGED","Zusammenfügen des Forums fehlgeschlagen");

//%%%%%%        File Name  admin_forum_reorder.php           %%%%%
define($constpref."_REORDERID","ID");
define($constpref."_REORDERTITLE","Titel");
define($constpref."_REORDERWEIGHT","Position");
define($constpref."_SETFORUMORDER","Forumssortierung bearbeiten");
define($constpref."_BOARDREORDER","Das Forum wurde nach Ihren Angaben umsortiert");

// admin_permission.php
define($constpref."_PERMISSIONS_TO_THIS_FORUM","Themenberechtigungen für dieses Forum");
define($constpref."_CAT_ACCESS","Kategorieberechtigung");
define($constpref."_CAN_ACCESS","Hat Zugriff auf die Kategorie");
define($constpref."_CAN_VIEW","Kann lesen");
define($constpref."_CAN_POST","Kann neue Themen starten");
define($constpref."_CAN_REPLY","Kann antworten");
define($constpref."_CAN_EDIT","Kann bearbeiten");
define($constpref."_CAN_DELETE","Kann löschen");
define($constpref."_CAN_ADDPOLL","Kann Umfrage starten");
define($constpref."_CAN_VOTE","Kann abstimmen");
define($constpref."_CAN_ATTACH","Kann Datei hinzufügen");
define($constpref."_CAN_NOAPPROVE","Kann ohne Freigabe schreiben");
define($constpref."_ACTION","Aktion");

define($constpref."_PERM_TEMPLATE","Standard Berechtigungsvorlage");
define($constpref."_PERM_TEMPLATE_DESC","Diese kann einem Forum zugewiesen werden");
define($constpref."_PERM_FORUMS","Foren auswählen");
define($constpref."_PERM_TEMPLATE_CREATED","Berechtigungsvorlage wurde angelegt");
define($constpref."_PERM_TEMPLATE_ERROR","Ein Fehler ist beim erstellen der Berechtigungsvorlage aufgetreten.");
define($constpref."_PERM_TEMPLATEAPP","Berechtigungsvorlage zuweisen");
define($constpref."_PERM_TEMPLATE_APPLIED","Standard Berechtigungsvorlage wurde zugewiesen.");
define($constpref."_PERM_ACTION","Berechtigungsaktionen");
define($constpref."_PERM_SETBYGROUP","Berechtigung je Gruppe festlegen");
define($constpref."_PERM_PERMISSIONS", "Berechtigungen");

// admin_forum_prune.php

define($constpref."_PRUNE_RESULTS_TITLE","Ergebnisse aufräumen");
define($constpref."_PRUNE_RESULTS_TOPICS","Aufgeräumte Themen");
define($constpref."_PRUNE_RESULTS_POSTS","Aufgeräumte Beiträge");
define($constpref."_PRUNE_RESULTS_FORUMS","Aufgeräumte Foren");
define($constpref."_PRUNE_STORE","In diesem Forum speichern anstatt die Beiträge zu löschen:");
define($constpref."_PRUNE_ARCHIVE","Kopien der Beiträge im Archiv sichern");
define($constpref."_PRUNE_FORUMSELERROR","Fehler, kein aufzuräumendes Forum angegeben.");

define($constpref."_PRUNE_DAYS","Entferne Themen ohne Beiträge seit:");
define($constpref."_PRUNE_FORUMS","Foren zum Aufräumen");
define($constpref."_PRUNE_STICKY","Sticky-Themen behalten");
define($constpref."_PRUNE_DIGEST","Zusammenfassungen behalten");
define($constpref."_PRUNE_LOCK","Geschlossene Themen behalten");
define($constpref."_PRUNE_HOT","Themen behalten die mehr als diese Anzahl Antworten haben:");
define($constpref."_PRUNE_SUBMIT","OK");
define($constpref."_PRUNE_RESET","Zurücksetzen");
define($constpref."_PRUNE_YES","Ja");
define($constpref."_PRUNE_NO","Nein");
define($constpref."_PRUNE_WEEK","Eine Woche");
define($constpref."_PRUNE_2WEEKS","Zwei Wochen");
define($constpref."_PRUNE_MONTH","Ein Monat");
define($constpref."_PRUNE_2MONTH","Zwei Monate");
define($constpref."_PRUNE_4MONTH","Vier Monate");
define($constpref."_PRUNE_YEAR","Ein Jahr");
define($constpref."_PRUNE_2YEARS","2 Jahre");

// About.php constants
define($constpref.'_AUTHOR_INFO', "Autoreninformation");
define($constpref.'_AUTHOR_NAME', "Autor");
define($constpref.'_AUTHOR_WEBSITE', "Webseite des Autors");
define($constpref.'_AUTHOR_EMAIL', "E-Mail des Autors");
define($constpref.'_AUTHOR_CREDITS', "Credits");
define($constpref.'_MODULE_INFO', "Modulentwicklungsinformation");
define($constpref.'_MODULE_STATUS', "Status");
define($constpref.'_MODULE_DEMO', "Demo Website");
define($constpref.'_MODULE_SUPPORT', "Offizielle Supportwebsite");
define($constpref.'_MODULE_BUG', "Einen Modulfehler melden");
define($constpref.'_MODULE_FEATURE', "Einen Vorschlag für zukünftige Erweiterung des Moduls machen");
define($constpref.'_MODULE_DISCLAIMER', "Disclaimer");
define($constpref.'_AUTHOR_WORD', "Bemerkungen des Entwicklers");
define($constpref.'_BY','Von');
define($constpref.'_AUTHOR_WORD_EXTRA', "
");

// admin_report.php
define($constpref."_REPORTADMIN","Gemeldete Beiträge");
define($constpref."_PROCESSEDREPORT","Bearbeitete Meldungen zeigen");
define($constpref."_PROCESSREPORT","Meldungen bearbeiten");
define($constpref."_REPORTTITLE","Meldungstitel");
define($constpref."_REPORTEXTRA","Extra");
define($constpref."_REPORTPOST","Gemeldeter Beitrag");
define($constpref."_REPORTTEXT","Meldungstext");
define($constpref."_REPORTMEMO","Memo bearbeiten");

// admin_report.php
define($constpref."_DIGESTADMIN","Digest Manager");
define($constpref."_DIGESTCONTENT","Digest Inhalte");

// admin_votedata.php
define($constpref."_VOTE_RATINGINFOMATION", "Abstimmungsinformationen");
define($constpref."_VOTE_TOTALVOTES", "Gesamtzahl Abstimmungen: ");
define($constpref."_VOTE_REGUSERVOTES", "Abstimmungen registrierter User: %s");
define($constpref."_VOTE_ANONUSERVOTES", "Abstimmungen nicht registrierter User: %s");
define($constpref."_VOTE_USER", "Benutzer");
define($constpref."_VOTE_IP", "IP-Adresse");
define($constpref."_VOTE_USERAVG", "Durchschnittliche Bewertung");
define($constpref."_VOTE_TOTALRATE", "Gesamtzahl Bewertungen");
define($constpref."_VOTE_DATE", "Eingereicht");
define($constpref."_VOTE_RATING", "Bewertung");
define($constpref."_VOTE_NOREGVOTES", "Keine Abstimmung durch registrierte User möglich.");
define($constpref."_VOTE_NOUNREGVOTES", "Keine Abstimmung durch nicht registrierte User möglich.");
define($constpref."_VOTEDELETED", "Abstimmungsdaten gelöscht.");
define($constpref."_VOTE_ID", "ID");
define($constpref."_VOTE_FILETITLE", "Thementitel");
define($constpref."_VOTE_DISPLAYVOTES", "Abstimmungsinformationen");
define($constpref."_VOTE_NOVOTES", "Keine Abstimmungen vorhanden");
define($constpref."_VOTE_DELETE", "Abstimmungsdaten löschen?");
define($constpref."_VOTE_DELETEDSC", "<b>Löscht</b> die ausgewählten Abstimmungsdaten aus der Datenbank.");
?>