<?php
	// $Id$
	// Blocks
	if (defined('_MB_IFORUM_DEFINED')) return;
	else define('_MB_IFORUM_DEFINED', true);
	//$constpref = '_MB_' . strtoupper( basename( dirname(  dirname(  dirname( __FILE__ ) ) ) ) ) ;
	$constpref = '_MB_IFORUM';
	 
	define($constpref."_FORUM", "Forum");
	define($constpref."_TOPIC", "Thema");
	define($constpref."_RPLS", "Antworten");
	define($constpref."_VIEWS", "Gelesen");
	define($constpref."_LPOST", "Letzter Beitrag");
	define($constpref."_VSTFRMS", " Zum Forum");
	define($constpref."_DISPLAY", "Anzahl Beiträge: ");
	define($constpref."_DISPLAYMODE", "Anzeige-Modus: ");
	define($constpref."_DISPLAYMODE_FULL", "Voll");
	define($constpref."_DISPLAYMODE_COMPACT", "Kompakt");
	define($constpref."_DISPLAYMODE_LITE", "Einfach");
	define($constpref."_FORUMLIST", "Erlaubte Foren: ");
	//define($constpref."_FORUMLIST_DESC","Foren die im Block angezeigt werden sollen.");
	//define($constpref."_FORUMLIST_ID","ID");
	//define($constpref."_FORUMLIST_NAME","Forumname");
	define($constpref."_ALLTOPICS", "Themen");
	define($constpref."_ALLPOSTS", "Beiträge");
	 
	define($constpref."_CRITERIA", "Anzeigeoptionen");
	define($constpref."_CRITERIA_TOPIC", "Themen");
	define($constpref."_CRITERIA_POST", "Beiträge");
	define($constpref."_CRITERIA_TIME", "Meist geändert");
	define($constpref."_CRITERIA_TITLE", "Beitragstitel");
	define($constpref."_CRITERIA_TEXT", "Beitragstext");
	define($constpref."_CRITERIA_VIEWS", "Meist gelesen");
	define($constpref."_CRITERIA_REPLIES", "Meisten Antworten");
	define($constpref."_CRITERIA_DIGEST", "Neuste Zusammenfassung");
	define($constpref."_CRITERIA_STICKY", "Neueste gepinnte");
	define($constpref."_CRITERIA_DIGESTS", "Meisten digests");
	define($constpref."_CRITERIA_STICKYS", "Meist gepinnte Themen");
	define($constpref."_TIME", "Zeitraum");
	define($constpref."_TIME_DESC", "Positiv für Tage und negativ für Stunden");
	 
	define($constpref."_TITLE", "Titel");
	define($constpref."_AUTHOR", "Autor");
	define($constpref."_COUNT", "Anzahl");
	define($constpref."_INDEXNAV", "Anzeige Navigator");
	 
	define($constpref."_TITLE_LENGTH", "Titel- o. Beitragslänge");
?>