<?php
// $Id: blocks.php,v 1.5 2005/05/15 12:25:54 phppp Exp $
// Blocks
if(defined('_MB_NEWBB_DEFINED')) return;
else define('_MB_NEWBB_DEFINED',true);
//$constpref = '_MB_' . strtoupper( basename( dirname(  dirname(  dirname( __FILE__ ) ) ) ) ) ;
$constpref = '_MB_NEWBB';

define($constpref."_FORUM","Forums");
define($constpref."_TOPIC","Sujets");
define($constpref."_RPLS","R&eacute;ponses");
define($constpref."_VIEWS","Lus");
define($constpref."_LPOST","Derni&egrave;res contributions");
define($constpref."_VSTFRMS"," Visiter les forums");
define($constpref."_DISPLAY","Nombre de posts");
define($constpref."_DISPLAYMODE","Mode de visualisation : ");
define($constpref."_DISPLAYMODE_FULL","Complet");
define($constpref."_DISPLAYMODE_COMPACT","Compact");
define($constpref."_DISPLAYMODE_LITE","L&eacute;ger");
define($constpref."_FORUMLIST","Allouer la liste des forums");
//define($constpref."_FORUMLIST_DESC","N° des forums allou&eacute;s a &ecirc;tre montr&eacute; dans le bloc. S&eacute;parateur \",\"; 0 pour TOUS, \"-\" pour exclure.");
//define($constpref."_FORUMLIST_ID","N°");
//define($constpref."_FORUMLIST_NAME","Nom de forum");
define($constpref."_ALLTOPICS","Sujets");
define($constpref."_ALLPOSTS","Contributions");

define($constpref."_CRITERIA","Afficher le crit&egrave;re");
define($constpref."_CRITERIA_TOPIC","Sujets");
define($constpref."_CRITERIA_POST","Contributions");
define($constpref."_CRITERIA_TIME","Le plus r&eacute;cent");
define($constpref."_CRITERIA_TITLE","Titre du post");
define($constpref."_CRITERIA_TEXT","Contenu du post");
define($constpref."_CRITERIA_VIEWS","Les plus vus");
define($constpref."_CRITERIA_REPLIES","Le plus de r&eacute;ponses");
define($constpref."_CRITERIA_DIGEST","Les derniers sommaires");
define($constpref."_CRITERIA_STICKY","Les derniers agraphag&eacute;s");
define($constpref."_CRITERIA_DIGESTS","Les plus sommairis&eacute;s");
define($constpref."_CRITERIA_STICKYS","Sujets les plus agraphag&eacute;s");
define($constpref."_TIME","P&eacute;riode de temps");
define($constpref."_TIME_DESC","Positif pour les jours et n&eacute;gatif pour les heures");

define($constpref."_TITLE","Titre");
define($constpref."_AUTHOR","Auteur");
define($constpref."_COUNT","Compteur");
define($constpref."_INDEXNAV","Afficher le navigateur");

define($constpref."_TITLE_LENGTH","Titre/longueur du post");
?>