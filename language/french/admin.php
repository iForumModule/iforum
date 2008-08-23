<?php
// $Id: admin.php,v 1.5 2005/05/15 12:25:54 phppp Exp $
//%%%%%%	File Name  index.php   	%%%%%
define ("_AM_NEWBB_FORUMCONF", "Configuration des forums");
define ("_AM_NEWBB_ADDAFORUM", "Ajouter un forum");
define ("_AM_NEWBB_SYNCFORUM", "Synchronisation");
define ("_AM_NEWBB_REORDERFORUM", "Organisation");
define ("_AM_NEWBB_FORUM_MANAGER", "Forums");
define ("_AM_NEWBB_PRUNE_TITLE", "Purges");
define ("_AM_NEWBB_CATADMIN", "Cat&eacute;gories");
define ("_AM_NEWBB_GENERALSET", "Param&egrave;tres du module");
define ("_AM_NEWBB_MODULEADMIN", "Administration du module:");
define ("_AM_NEWBB_HELP", "Aide");
define ("_AM_NEWBB_ABOUT","A Propos");
define ("_AM_NEWBB_BOARDSUMMARY", "Statistiques du syst&egrave;me de forum");
define ("_AM_NEWBB_PENDING_POSTS_FOR_AUTH", "Contributions en attente de validation");
define ("_AM_NEWBB_POSTID", "N° de contribution");
define ("_AM_NEWBB_POSTDATE", "Date de publication");
define ("_AM_NEWBB_POSTER", "Publier");
define ("_AM_NEWBB_TOPICS", "Sujets");
define ("_AM_NEWBB_SHORTSUMMARY", "Sommaire du syst&egrave;me de forums");
define ("_AM_NEWBB_TOTALPOSTS", "Nombre de contributions");
define ("_AM_NEWBB_TOTALTOPICS", "Nombre de sujets");
define ("_AM_NEWBB_TOTALVIEWS", "Nombre de lectures");
define ("_AM_NEWBB_BLOCKS", "Blocs");
define ("_AM_NEWBB_SUBJECT", "Sujet");
define ("_AM_NEWBB_APPROVE", "Approuver cette proposition");
define ("_AM_NEWBB_APPROVETEXT", "Contenu de cet enregistrement");
define("_AM_NEWBB_POSTAPPROVED","La proposition a &eacute;t&eacute; approuv&eacute;e");
define("_AM_NEWBB_POSTNOTAPPROVED","La proposition n'a pas &eacute;t&eacute; approuv&eacute;e");
define("_AM_NEWBB_POSTSAVED","La contribution a &eacute;t&eacute; sauvegard&eacute;e");
define("_AM_NEWBB_POSTNOTSAVED","La contribution n'a pas &eacute;t&eacute; sauvegard&eacute;e");

define("_AM_NEWBB_TOPICAPPROVED","Le sujet a &eacute;t&eacute; approuv&eacute;");
define("_AM_NEWBB_TOPICNOTAPPROVED","le sujet n'a pas &eacute;t&eacute; approuv&eacute;");
define("_AM_NEWBB_TOPICID","Sujet N°");
define("_AM_NEWBB_ORPHAN_TOPICS_FOR_AUTH","Autorisation des sujets non approuv&eacute;s");


define ('_AM_NEWBB_DEL_ONE', 'Effacer seulement ce message');
define ('_AM_NEWBB_POSTSDELETED', 'S&eacute;lection de la proposition &agrave; effacer.');
define ("_AM_NEWBB_NOAPPROVEPOST", "Il n'y a aucune contribution en attente d'approbation pour le moment.");
define ('_AM_NEWBB_SUBJECTC', 'Sujet:');
define ('_AM_NEWBB_MESSAGEICON', 'Ic&ocirc;ne du message:');
define ('_AM_NEWBB_MESSAGEC', 'Message:');
define ('_AM_NEWBB_CANCELPOST', 'Annuler votre contribution'); 
define('_AM_NEWBB_GOTOMOD','Aller au module');

define('_AM_NEWBB_PREFERENCES','Pr&eacute;f&eacute;rences du module');
define('_AM_NEWBB_POLLMODULE','Module Xoops de sondage');
define('_AM_NEWBB_POLL_OK','Pr&ecirc;t &agrave; &ecirc;tre utilis&eacute;');
define('_AM_NEWBB_GDLIB1','Librairie GD1');
define('_AM_NEWBB_GDLIB2','Librarie GD2:');
define('_AM_NEWBB_AUTODETECTED','Autod&eacute;tection : ');
define('_AM_NEWBB_AVAILABLE','Valide');
define('_AM_NEWBB_NOTAVAILABLE','<font color="red">Non Valide</font>');
define('_AM_NEWBB_NOTWRITABLE','<font color="red">Non ouvert en &eacute;criture</font>');
define('_AM_NEWBB_IMAGEMAGICK','Image MagicK');
define('_AM_NEWBB_IMAGEMAGICK_NOTSET','Non param&eacute;tr&eacute;');
define('_AM_NEWBB_ATTACHPATH','Chemin de stockage des pi&egrave;ces jointes');
define('_AM_NEWBB_THUMBPATH','Chemin des miniatures d\'images attach&eacute;es');
//define('_AM_NEWBB_RSSPATH','Chemin du filet RSS');
define('_AM_NEWBB_REPORT','Posts rapport&eacute;s');
define('_AM_NEWBB_REPORT_PENDING','Rapports en attente');
define('_AM_NEWBB_REPORT_PROCESSED','Rapports trait&eacute;s');

define('_AM_NEWBB_CREATETHEDIR','Le cr&eacute;er');
define('_AM_NEWBB_SETMPERM','Param&egrave;trer les permissions');
define('_AM_NEWBB_DIRCREATED','Le r&eacute;pertoire a &eacute;t&eacute; cr&eacute;&eacute;');
define('_AM_NEWBB_DIRNOTCREATED','Le r&eacute;pertoire ne peut pas être cr&eacute;&eacute;');
define('_AM_NEWBB_PERMSET','Les permissions ont &eacute;t&eacute; param&egrave;tr&eacute;es');
define('_AM_NEWBB_PERMNOTSET','Les permissions ne peuvent pas &circ;tre param&egrave;tr&eacute;es');

define('_AM_NEWBB_DIGEST',"Notification des sommaires");
define('_AM_NEWBB_DIGEST_PAST','<font color="red">devait &ecirc;tre communiqu&eacute; il y a %d minutes</font>');
define('_AM_NEWBB_DIGEST_NEXT',"Demande &agrave; etre envoy&eacute; &agrave; l'ext&eacute;rieur dans %d minutes");
define('_AM_NEWBB_DIGEST_ARCHIVE',"Archive des sommaires");
define('_AM_NEWBB_DIGEST_SENT','Sommaires op&eacute;r&eacute;s');
define('_AM_NEWBB_DIGEST_FAILED','Sommaires NON op&eacute;r&eacute;s');

// admin_forum_manager.php
define ("_AM_NEWBB_NAME", "Nom");
define("_AM_NEWBB_CREATEFORUM","Cr&eacute;er un forum");
define("_AM_NEWBB_EDIT","Modifier");
define("_AM_NEWBB_CLEAR","Effacer");
define ("_AM_NEWBB_DELETE", "Effacer");
define ("_AM_NEWBB_ADD", "Ajouter");
define ("_AM_NEWBB_MOVE", "D&eacute;placer");
define ("_AM_NEWBB_ORDER", "Ordre");
define ("_AM_NEWBB_TWDAFAP", "Note: Ceci supprimera toutes les contributions du forum.<br> <br> AVERTISSEMENT: Etes vous certain de vouloir effacer ce forum ?");
define ("_AM_NEWBB_FORUMREMOVED", "le forum a &eacute;t&eacute; &eacute;ffac&eacute;.");
define ("_AM_NEWBB_CREATENEWFORUM", "Cr&eacute;er un nouveau forum");
define ("_AM_NEWBB_EDITTHISFORUM", "Editer le forum:");
define ("_AM_NEWBB_SET_FORUMORDER", "Param&egrave;tres de position du forum:");
define ("_AM_NEWBB_ALLOWPOLLS", "Autoriser les sondages:");
define ("_AM_NEWBB_ATTACHMENT_SIZE", "Taille maximum en kb:");
define ("_AM_NEWBB_ALLOWED_EXTENSIONS", "Autoriser les extensions :<span style='font-size: xx-small; font-weight: normal; display: block;'>'*' Indique pas de limitation.<br /> S&eacute;parez les extensions par '|'</span>");
define ("_AM_NEWBB_ALLOW_ATTACHMENTS", "Autoriser les pi&egrave;ces jointes:");
define ("_AM_NEWBB_ALLOWHTML", "Autoriser le HTML:");
define ("_AM_NEWBB_YES", "Oui");
define ("_AM_NEWBB_NO", "Non");
define ("_AM_NEWBB_ALLOWSIGNATURES", "Autoriser les signatures:");
define ("_AM_NEWBB_HOTTOPICTHRESHOLD", "Seuil des sujets dit Chauds:");
//define ("_AM_NEWBB_POSTPERPAGE", "Nombre de contributions par page: <span style='font-size: xx-small; font-weight: normal; display: block;'>(D&eacute;fini le nombre de contributions<br /> par sujet qui seront<br /> affich&eacute;es par page)</span>");
//define ("_AM_NEWBB_TOPICPERFORUM", "Nombre de sujets par forum: <span style='font-size: xx-small; font-weight: normal; display: block;'>(D&eacute;fini le nombre de sujets<br /> par forum qui seront<br /> affich&eacute;s sur la page d'un forum)</span>");
//define ("_AM_NEWBB_SHOWNAME", "Remplacer les noms d'utilisateurs par leurs noms r&eacute;els:");
//define ("_AM_NEWBB_SHOWICONSPANEL", "Afficher le panneau des ic&ocirc;nes :");
//define ("_AM_NEWBB_SHOWSMILIESPANEL", "Afficher le panneau des &eacute;moticones:");
define("_AM_NEWBB_MODERATOR_REMOVE","Enlever le mod&eacute;rateur courant");
define("_AM_NEWBB_MODERATOR_ADD","Ajouter des mod&eacute;rateurs");
define("_AM_NEWBB_ALLOW_SUBJECT_PREFIX", "Allouer un pr&eacute;fixe de sujet pour les articles");
define("_AM_NEWBB_ALLOW_SUBJECT_PREFIX_DESC", "Ceci alloue un pr&eacute;fixe, qui sera ajout&eacute; au sujet de l'article");


// admin_cat_manager.php

define ("_AM_NEWBB_SETCATEGORYORDER", "Param&egrave;tres de position de la cat&eacute;gorie :");
define("_AM_NEWBB_ACTIVE","Actif");
define("_AM_NEWBB_INACTIVE","Inactif");
define ("_AM_NEWBB_STATE", "Etat :");
define ("_AM_NEWBB_CATEGORYDESC", "Description de la cat&eacute;gorie:");
define ("_AM_NEWBB_SHOWDESC", "Afficher la description ?");
define("_AM_NEWBB_IMAGE","Image:");
define ("_AM_NEWBB_SPONSORIMAGE", "Image du sponsor:");
define ("_AM_NEWBB_SPONSORLINK", "Lien du sponsor:");
define ("_AM_NEWBB_DELCAT", "Effacer la cat&eacute;gorie");
define ("_AM_NEWBB_WAYSYWTDTTAL", "Note: Ceci ne supprimera pas les forums situ&eacute;s sous la cat&eacute;gorie, pour ce faire vous devez utiliser la section Editer un forum.<br /><br />AVERTISSEMENT: Etes vous certain de toujours d&eacute;sirer effacer cette cat&eacute;gorie?");



//%%%%%%        Nom du dossier admin_forums.php           %%%%%
define ("_AM_NEWBB_FORUMNAME", "Nom du forum:");
define ("_AM_NEWBB_FORUMDESCRIPTION", "Description du forum:");
define ("_AM_NEWBB_MODERATOR", "Mod&eacute;rateur(s):");
define ("_AM_NEWBB_REMOVE", "Supprimer");
define ("_AM_NEWBB_CATEGORY", "Cat&eacute;gorie:");
define ("_AM_NEWBB_DATABASEERROR", "Erreur de la base de donn&eacute;es");
define ("_AM_NEWBB_CATEGORYUPDATED", "La cat&eacute;gorie a &eacute;t&eacute; mise &agrave; jour.");
define ("_AM_NEWBB_EDITCATEGORY", "Editer la cat&eacute;gorie:");
define ("_AM_NEWBB_CATEGORYTITLE", "Titre de la cat&eacute;gorie:");
define ("_AM_NEWBB_CATEGORYCREATED", "la cat&eacute;gorie a &eacute;t&eacute; cr&eacute;&eacute;e.");
define ("_AM_NEWBB_CREATENEWCATEGORY", "Cr&eacute;er une nouvelle cat&eacute;gorie");
define ("_AM_NEWBB_FORUMCREATED", "le forum a &eacute;t&eacute; cr&eacute;&eacute;.");
define ("_AM_NEWBB_ACCESSLEVEL", "Niveau d'acc&egrave;s:");
define ("_AM_NEWBB_CATEGORY1", "Cat&eacute;gorie");
define ("_AM_NEWBB_FORUMUPDATE", "les param&egrave;tres du forum ont &eacute;t&eacute; mis &agrave; jour");
define("_AM_NEWBB_FORUM_ERROR","ERREUR: Erreur de param&eacute;trage de forum");
define ("_AM_NEWBB_CLICKBELOWSYNC", "Cliquer sur le bouton de synchronisation autant de fois qu'il vous plaira en haut vos forums et pages de sujets afin de corriger les donn&eacute;es de la base de donn&eacute;es. Utilisez cette option &agrave; chaque fois  que vous observez des d&eacute;synchronisations entre les listes de sujets et leurs forums.");
define ("_AM_NEWBB_SYNCHING", "Synchroniser le forum et les sujets index&eacute;s (Cela peut prendre du temps)");
define ("_AM_NEWBB_CATEGORYDELETED", "la cat&eacute;gorie a &eacute;t&eacute; supprim&eacute;e.");
define ("_AM_NEWBB_MOVE2CAT", "D&eacute;placer la cat&eacute;gorie:");
define ("_AM_NEWBB_MAKE_SUBFORUM_OF", "Cr&eacute;er un sous-sorum de:");
define ("_AM_NEWBB_MSG_FORUM_MOVED", "le forum a &eacute;t&eacute; d&eacute;plac&eacute;!");
define ("_AM_NEWBB_MSG_ERR_FORUM_MOVED", "Echec de d&eacute;placement du forum.");
define ("_AM_NEWBB_SELECT"," < S&eacute;lectionner >");
define("_AM_NEWBB_MOVETHISFORUM","D&eacute;placer ce forum");
define("_AM_NEWBB_MERGE","Fusionner");
define("_AM_NEWBB_MERGETHISFORUM","Fusionner ce forum");
define("_AM_NEWBB_MERGETO_FORUM","Fusionner ce forum avec :");
define("_AM_NEWBB_MSG_FORUM_MERGED","Forums fusionn&eacute;s !");
define("_AM_NEWBB_MSG_ERR_FORUM_MERGED","Echec de la fusion des forums.");

//%%%%%%        Nom du dossier admin_forum_reorder.php           %%%%%
define ("_AM_NEWBB_REORDERID", "N°");
define ("_AM_NEWBB_REORDERTITLE", "Titre");
define("_AM_NEWBB_REORDERWEIGHT","Position");
define ("_AM_NEWBB_SETFORUMORDER", "Param&egrave;tres d'organisation des forums");
define("_AM_NEWBB_BOARDREORDER","Le forum a &eacute;t&eacute; r&eacute;-ordonn&eacute;");

// forum_access.php
define("_AM_NEWBB_PERMISSIONS_TO_THIS_FORUM","Permissions pour ce forum");
define ("_AM_NEWBB_CAN_VIEW", "peut visualiser");
define ("_AM_NEWBB_CAN_POST", "peut d&eacute;buter de nouveaux sujets");
define ("_AM_NEWBB_CAN_REPLY", "peut r&eacute;pondre");
define ("_AM_NEWBB_CAN_EDIT", "peut &eacute;diter");
define ("_AM_NEWBB_CAN_DELETE", "peut effacer");
define ("_AM_NEWBB_CAN_ADDPOLL", "peut ajouter un sondage");
define ("_AM_NEWBB_CAN_VOTE", "peut voter");
define ("_AM_NEWBB_CAN_ATTACH", "peut attacher");
define("_AM_NEWBB_CAN_NOAPPROVE","peut poster sans approbation");
define ("_AM_NEWBB_ACTION", "Action");

// admin_forum_prune.php

define ("_AM_NEWBB_PRUNE_RESULTS_TITLE", "R&eacute;sultats des purges");
define ("_AM_NEWBB_PRUNE_RESULTS_TOPICS", "Sujets purg&eacute;s");
define ("_AM_NEWBB_PRUNE_RESULTS_POSTS", "Contributions purg&eacute;es");
define ("_AM_NEWBB_PRUNE_RESULTS_FORUMS", "Forums purg&eacute;s");
define ("_AM_NEWBB_PRUNE_STORE", "Enregistrer les contributions de ces forums avant de les purger");
define ("_AM_NEWBB_PRUNE_ARCHIVE", "R&eacute;aliser une copie d'archive des contributions");
define ("_AM_NEWBB_PRUNE_FORUMSELERROR", "Vous avez oubli&eacute; de s&eacute;lectionner le ou les forums &agrave; purger");

define ("_AM_NEWBB_PRUNE_DAYS", "Supprimer les sujets sans r&eacute;ponse depuis:");
define ("_AM_NEWBB_PRUNE_FORUMS", "Forums &agrave; purger");
define ("_AM_NEWBB_PRUNE_STICKY", "Conserver les sujets &eacute;tiquet&eacute;s");
define ("_AM_NEWBB_PRUNE_DIGEST", "Conserver les sujets en sommaire");
define ("_AM_NEWBB_PRUNE_LOCK", "Conserver les sujets verrouill&eacute;s");
define ("_AM_NEWBB_PRUNE_HOT","Garder ces sujets qui ont plus que ce nombre de r&eacute;ponses");
define ("_AM_NEWBB_PRUNE_SUBMIT", "Ok");
define ("_AM_NEWBB_PRUNE_RESET", "R&eacute;initialiser");
define ("_AM_NEWBB_PRUNE_YES", "Oui");
define ("_AM_NEWBB_PRUNE_NO", "Non");
define ("_AM_NEWBB_PRUNE_WEEK", "Une semaine");
define ("_AM_NEWBB_PRUNE_2WEEKS", "Deux semaines");
define ("_AM_NEWBB_PRUNE_MONTH", "Un mois");
define ("_AM_NEWBB_PRUNE_2MONTH", "Deux mois");
define ("_AM_NEWBB_PRUNE_4MONTH", "Quatre mois");
define ("_AM_NEWBB_PRUNE_YEAR", "Un an");
define ("_AM_NEWBB_PRUNE_2YEARS", "2 ans");

// About.php constants
define('_AM_NEWBB_AUTHOR_INFO', "Informations au sujet de l'auteur");
define('_AM_NEWBB_AUTHOR_NAME', "Auteur");
define('_AM_NEWBB_AUTHOR_WEBSITE', "Site Web de l'auteur");
define('_AM_NEWBB_AUTHOR_EMAIL', "Email de l'auteur");
define('_AM_NEWBB_AUTHOR_CREDITS', "Cr&eacute;dits");
define('_AM_NEWBB_MODULE_INFO', "Informations de d&eacute;veloppement du module");
define('_AM_NEWBB_MODULE_STATUS', "Etats");
define('_AM_NEWBB_MODULE_DEMO', "Site de d&eacute;monstration");
define('_AM_NEWBB_MODULE_SUPPORT', "Site officiel de support");
define('_AM_NEWBB_MODULE_BUG', "Rapporter un bug &agrave; propos de ce module");
define('_AM_NEWBB_MODULE_FEATURE', "Sugg&eacute;rer une nouvelle fonction pour ce module");
define('_AM_NEWBB_MODULE_DISCLAIMER', "Avertissement");
define('_AM_NEWBB_AUTHOR_WORD', "Le monde de l'auteur");
define('_AM_NEWBB_BY','Par');
define('_AM_NEWBB_AUTHOR_WORD_EXTRA', "
");

// admin_report.php
define("_AM_NEWBB_REPORTADMIN","Posts rapport&eacute;s aux gestionnaires");
define("_AM_NEWBB_PROCESSEDREPORT","Vues des rapports g&eacute;n&eacute;r&eacute;s");
define("_AM_NEWBB_PROCESSREPORT","Rapports g&eacute;n&eacute;r&eacute;s");
define("_AM_NEWBB_REPORTTITLE","Titre des rapports");
define("_AM_NEWBB_REPORTEXTRA","Extra");
define("_AM_NEWBB_REPORTPOST","Post rapport&eacute;");
define("_AM_NEWBB_REPORTTEXT","Texte du rapport");
define("_AM_NEWBB_REPORTMEMO","M&eacute;mo g&eacute;n&eacute;r&eacute;");

// admin_report.php
define("_AM_NEWBB_DIGESTADMIN","Gestion des sommaires");
define("_AM_NEWBB_DIGESTCONTENT","Contenu des sommaires");

// admin_votedata.php
define("_AM_NEWBB_VOTE_RATINGINFOMATION", "Informations de vote");
define("_AM_NEWBB_VOTE_TOTALVOTES", "Totaux des votes: ");
define("_AM_NEWBB_VOTE_REGUSERVOTES", "Votes d'utilisateurs enregistr&eacute;s: %s");
define("_AM_NEWBB_VOTE_ANONUSERVOTES", "Votes d'utilisateurs anonymes: %s");
define("_AM_NEWBB_VOTE_USER", "Utilisateur");
define("_AM_NEWBB_VOTE_IP", "Addresse IP");
define("_AM_NEWBB_VOTE_USERAVG", "Moyenne des cotations utilisateur");
define("_AM_NEWBB_VOTE_TOTALRATE", "Totaux des cotations");
define("_AM_NEWBB_VOTE_DATE", "Soumis");
define("_AM_NEWBB_VOTE_RATING", "cot&eacute;");
define("_AM_NEWBB_VOTE_NOREGVOTES", "Aucun vote d'utilisateur enregistr&eacute;");
define("_AM_NEWBB_VOTE_NOUNREGVOTES", "Aucun vote d'utilisateur non enregistr&eacute;");
define("_AM_NEWBB_VOTEDELETED", "Donn&eacute;es de vote effac&eacute;es.");
define("_AM_NEWBB_VOTE_ID", "N°");
define("_AM_NEWBB_VOTE_FILETITLE", "Titre du sujet");
define("_AM_NEWBB_VOTE_DISPLAYVOTES", "Informations de donn&eacute;es de vote");
define("_AM_NEWBB_VOTE_NOVOTES", "Aucun vote d'utilisateur &agrave; visualiser");
define("_AM_NEWBB_VOTE_DELETE", "Aucun vote d'utilisateur &agrave; visualiser");
define("_AM_NEWBB_VOTE_DELETEDSC", "<strong>Effacer</strong> les informations de vote s&eacute;lectionn&eacute;es de la base de donn&eacute;es.");
?>