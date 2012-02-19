<?php
	// $Id$
	//%%%%%% File Name  index.php    %%%%%
	//$constpref = '_AM_' . strtoupper( basename( dirname(  dirname(  dirname( __FILE__ ) ) ) ) ) ;
	$constpref = '_AM_IFORUM';
	define($constpref."_FORUMCONF", "Configuration des forums");
	define($constpref."_ADDAFORUM", "Ajouter un forum");
	define($constpref."_SYNCFORUM", "Synchronisation");
	define($constpref."_REORDERFORUM", "Organisation");
	define($constpref."_FORUM_MANAGER", "Forums");
	define($constpref."_PRUNE_TITLE", "Purges");
	define($constpref."_CATADMIN", "Cat&eacute;gories");
	define($constpref."_GENERALSET", "Param&egrave;tres du module");
	define($constpref."_MODULEADMIN", "Administration du module :");
	define($constpref."_HELP", "Aide");
	define($constpref."_ABOUT", "A Propos");
	define($constpref."_BOARDSUMMARY", "Statistiques du forum");
	define($constpref."_PENDING_POSTS_FOR_AUTH", "Contributions en attente de validation");
	define($constpref."_POSTID", "N° de contribution");
	define($constpref."_POSTDATE", "Date de publication");
	define($constpref."_POSTER", "Publier");
	define($constpref."_TOPICS", "Sujets");
	define($constpref."_SHORTSUMMARY", "Sommaire du forum");
	define($constpref."_TOTALPOSTS", "Nombre de contributions");
	define($constpref."_TOTALTOPICS", "Nombre de sujets");
	define($constpref."_TOTALVIEWS", "Nombre de lectures");
	define($constpref."_BLOCKS", "Blocs");
	define($constpref."_SUBJECT", "Sujet");
	define($constpref."_APPROVE", "Approuver cette proposition");
	define($constpref."_APPROVETEXT", "Contenu de cet enregistrement");
	define($constpref."_POSTAPPROVED", "La proposition a &eacute;t&eacute; approuv&eacute;e");
	define($constpref."_POSTNOTAPPROVED", "La proposition n'a pas &eacute;t&eacute; approuv&eacute;e");
	define($constpref."_POSTSAVED", "La contribution a &eacute;t&eacute; sauvegard&eacute;e");
	define($constpref."_POSTNOTSAVED", "La contribution n'a pas &eacute;t&eacute; sauvegard&eacute;e");
	 
	define($constpref."_TOPICAPPROVED", "Le sujet a &eacute;t&eacute; approuv&eacute;");
	define($constpref."_TOPICNOTAPPROVED", "le sujet n'a pas &eacute;t&eacute; approuv&eacute;");
	define($constpref."_TOPICID", "Sujet N°");
	define($constpref."_ORPHAN_TOPICS_FOR_AUTH", "Autorisation des sujets non approuv&eacute;s");
	 
	 
	define($constpref.'_DEL_ONE', 'Effacer seulement ce message');
	define($constpref.'_POSTSDELETED', 'S&eacute;lection de la proposition &agrave; effacer.');
	define($constpref."_NOAPPROVEPOST", "Il n'y a aucune contribution en attente d'approbation pour le moment.");
	define($constpref.'_SUBJECTC', 'Sujet :');
	define($constpref.'_MESSAGEICON', 'Ic&ocirc;ne du message :');
	define($constpref.'_MESSAGEC', 'Message :');
	define($constpref.'_CANCELPOST', 'Annuler votre contribution');
	define($constpref.'_GOTOMOD', 'Aller au module');
	 
	define($constpref.'_PREFERENCES', 'Pr&eacute;f&eacute;rences du module');
	define($constpref.'_POLLMODULE', 'Module Xoops de sondage ');
	define($constpref.'_POLL_OK', 'Pr&ecirc;t &agrave; &ecirc;tre utilis&eacute;');
	define($constpref.'_GDLIB1', 'Librairie GD1 :');
	define($constpref.'_GDLIB2', 'Librairie GD2 :');
	define($constpref.'_AUTODETECTED', 'Autod&eacute;tection : ');
	define($constpref.'_AVAILABLE', 'Valide');
	define($constpref.'_NOTAVAILABLE', '<font color="red">Non valide</font>');
	define($constpref.'_NOTWRITABLE', '<font color="red">Non ouvert en &eacute;criture</font>');
	define($constpref.'_IMAGEMAGICK', 'Image MagicK');
	define($constpref.'_IMAGEMAGICK_NOTSET', 'Non param&eacute;tr&eacute;');
	define($constpref.'_ATTACHPATH', 'Chemin de stockage des pi&egrave;ces jointes');
	define($constpref.'_THUMBPATH', 'Chemin des miniatures d\'images attach&eacute;es');
	//define($constpref.'_RSSPATH','Chemin du filet RSS');
	define($constpref.'_REPORT', 'Posts rapport&eacute;s');
	define($constpref.'_REPORT_PENDING', 'Rapports en attente');
	define($constpref.'_REPORT_PROCESSED', 'Rapports trait&eacute;s');
	 
	define($constpref.'_CREATETHEDIR', 'Le cr&eacute;er');
	define($constpref.'_SETMPERM', 'Param&egrave;trer les permissions');
	define($constpref.'_DIRCREATED', 'Le r&eacute;pertoire a &eacute;t&eacute; cr&eacute;&eacute;');
	define($constpref.'_DIRNOTCREATED', 'Le r&eacute;pertoire ne peut pas &ecirc;tre cr&eacute;&eacute;');
	define($constpref.'_PERMSET', 'Les permissions ont &eacute;t&eacute; param&egrave;tr&eacute;es');
	define($constpref.'_PERMNOTSET', 'Les permissions ne peuvent pas &circ;tre param&egrave;tr&eacute;es');
	 
	define($constpref.'_DIGEST', "Notification des sommaires");
	define($constpref.'_DIGEST_PAST', '<font color="red">devait &ecirc;tre communiqu&eacute; il y a %d minutes</font>');
	define($constpref.'_DIGEST_NEXT', "Demande &agrave; etre envoy&eacute; &agrave; l'ext&eacute;rieur dans %d minutes");
	define($constpref.'_DIGEST_ARCHIVE', "Archive des sommaires");
	define($constpref.'_DIGEST_SENT', 'Sommaires op&eacute;r&eacute;s');
	define($constpref.'_DIGEST_FAILED', 'Sommaires NON op&eacute;r&eacute;s');
	 
	// admin_forum_manager.php
	define($constpref."_NAME", "Nom");
	define($constpref."_CREATEFORUM", "Cr&eacute;er un forum");
	define($constpref."_EDIT", "Modifier");
	define($constpref."_CLEAR", "Effacer");
	define($constpref."_DELETE", "Effacer");
	define($constpref."_ADD", "Ajouter");
	define($constpref."_MOVE", "D&eacute;placer");
	define($constpref."_ORDER", "Ordre");
	define($constpref."_TWDAFAP", "Note : Ceci supprimera toutes les contributions du forum.<br> <br> AVERTISSEMENT : Etes vous certain de vouloir effacer ce forum ?");
	define($constpref."_FORUMREMOVED", "le forum a &eacute;t&eacute; &eacute;ffac&eacute;.");
	define($constpref."_CREATENEWFORUM", "Cr&eacute;er un nouveau forum");
	define($constpref."_EDITTHISFORUM", "Editer le forum :");
	define($constpref."_SET_FORUMORDER", "Param&egrave;tres de position du forum :");
	define($constpref."_ALLOWPOLLS", "Autoriser les sondages :");
	define($constpref."_ATTACHMENT_SIZE", "Taille maximum en kb :");
	define($constpref."_ALLOWED_EXTENSIONS", "Autoriser les extensions :<span style='font-size: xx-small; font-weight: normal; display: block;'>'*' Indique pas de limitation.<br /> S&eacute;parez les extensions par '|'</span>");
	define($constpref."_ALLOW_ATTACHMENTS", "Autoriser les pi&egrave;ces jointes :");
	define($constpref."_ALLOWHTML", "Autoriser le HTML :");
	define($constpref."_YES", "Oui");
	define($constpref."_NO", "Non");
	define($constpref."_ALLOWSIGNATURES", "Autoriser les signatures :");
	define($constpref."_HOTTOPICTHRESHOLD", "Seuil des sujets dit chauds :");
	//define($constpref."_POSTPERPAGE", "Nombre de contributions par page: <span style='font-size: xx-small; font-weight: normal; display: block;'>(D&eacute;fini le nombre de contributions<br /> par sujet qui seront<br /> affich&eacute;es par page)</span>");
	//define($constpref."_TOPICPERFORUM", "Nombre de sujets par forum: <span style='font-size: xx-small; font-weight: normal; display: block;'>(D&eacute;fini le nombre de sujets<br /> par forum qui seront<br /> affich&eacute;s sur la page d'un forum)</span>");
	//define($constpref."_SHOWNAME", "Remplacer les noms d'utilisateurs par leurs noms r&eacute;els:");
	//define($constpref."_SHOWICONSPANEL", "Afficher le panneau des ic&ocirc;nes :");
	//define($constpref."_SHOWSMILIESPANEL", "Afficher le panneau des emoticones:");
	define($constpref."_MODERATOR_REMOVE", "Enlever le mod&eacute;rateur courant");
	define($constpref."_MODERATOR_ADD", "Ajouter des mod&eacute;rateurs");
	define($constpref."_ALLOW_SUBJECT_PREFIX", "Allouer un pr&eacute;fixe de sujet pour les articles");
	define($constpref."_ALLOW_SUBJECT_PREFIX_DESC", "Ceci alloue un pr&eacute;fixe, qui sera ajout&eacute; au sujet de l'article");
	 
	 
	// admin_cat_manager.php
	 
	define($constpref."_SETCATEGORYORDER", "Param&egrave;tres de position de la cat&eacute;gorie :");
	define($constpref."_ACTIVE", "Actif");
	define($constpref."_INACTIVE", "Inactif");
	define($constpref."_STATE", "Etat :");
	define($constpref."_CATEGORYDESC", "Description de la cat&eacute;gorie :");
	define($constpref."_SHOWDESC", "Afficher la description ?");
	define($constpref."_IMAGE", "Image :");
	//define($constpref."_SPONSORIMAGE", "Image du sponsor:");
	define($constpref."_SPONSORLINK", "Lien du sponsor :");
	define($constpref."_DELCAT", "Effacer la cat&eacute;gorie");
	define($constpref."_WAYSYWTDTTAL", "Note : Ceci ne supprimera pas les forums situ&eacute;s sous la cat&eacute;gorie, pour ce faire vous devez utiliser la section Editer un forum.<br /><br />AVERTISSEMENT : Etes vous certain de vouloir effacer cette cat&eacute;gorie ?");
	 
	 
	 
	//%%%%%%        Nom du dossier admin_forums.php           %%%%%
	define($constpref."_FORUMNAME", "Nom du forum :");
	define($constpref."_FORUMDESCRIPTION", "Description du forum :");
	define($constpref."_MODERATOR", "Mod&eacute;rateur(s) :");
	define($constpref."_REMOVE", "Supprimer");
	define($constpref."_CATEGORY", "Cat&eacute;gorie :");
	define($constpref."_DATABASEERROR", "Erreur dans la base de donn&eacute;es");
	define($constpref."_CATEGORYUPDATED", "La cat&eacute;gorie a &eacute;t&eacute; mise &agrave; jour.");
	define($constpref."_EDITCATEGORY", "Editer la cat&eacute;gorie :");
	define($constpref."_CATEGORYTITLE", "Titre de la cat&eacute;gorie :");
	define($constpref."_CATEGORYCREATED", "la cat&eacute;gorie a &eacute;t&eacute; cr&eacute;&eacute;e.");
	define($constpref."_CREATENEWCATEGORY", "Cr&eacute;er une nouvelle cat&eacute;gorie");
	define($constpref."_FORUMCREATED", "le forum a &eacute;t&eacute; cr&eacute;&eacute;.");
	define($constpref."_ACCESSLEVEL", "Niveau d'acc&egrave;s :");
	define($constpref."_CATEGORY1", "Cat&eacute;gorie");
	define($constpref."_FORUMUPDATE", "les param&egrave;tres du forum ont &eacute;t&eacute; mis &agrave; jour");
	define($constpref."_FORUM_ERROR", "ERREUR : Erreur de param&eacute;trage de forum");
	define($constpref."_CLICKBELOWSYNC", "Cliquer sur le bouton de synchronisation autant de fois qu'il vous plaira en haut vos forums et pages de sujets afin de corriger les donn&eacute;es de la base de donn&eacute;es. Utilisez cette option &agrave; chaque fois  que vous observez des d&eacute;synchronisations entre les listes de sujets et leurs forums.");
	define($constpref."_SYNCHING", "Synchroniser le forum et les sujets index&eacute;s (Cela peut prendre du temps)");
	define($constpref."_CATEGORYDELETED", "la cat&eacute;gorie a &eacute;t&eacute; supprim&eacute;e.");
	define($constpref."_MOVE2CAT", "D&eacute;placer la cat&eacute;gorie :");
	define($constpref."_MAKE_SUBFORUM_OF", "Cr&eacute;er un sous-forum de :");
	define($constpref."_MSG_FORUM_MOVED", "le forum a &eacute;t&eacute; d&eacute;plac&eacute;!");
	define($constpref."_MSG_ERR_FORUM_MOVED", "Echec de d&eacute;placement du forum.");
	define($constpref."_SELECT", " < S&eacute;lectionner >");
	define($constpref."_MOVETHISFORUM", "D&eacute;placer ce forum");
	define($constpref."_MERGE", "Fusionner");
	define($constpref."_MERGETHISFORUM", "Fusionner ce forum");
	define($constpref."_MERGETO_FORUM", "Fusionner ce forum avec :");
	define($constpref."_MSG_FORUM_MERGED", "Forums fusionn&eacute;s !");
	define($constpref."_MSG_ERR_FORUM_MERGED", "Echec de la fusion des forums.");
	 
	//%%%%%%        Nom du dossier admin_forum_reorder.php           %%%%%
	define($constpref."_REORDERID", "N°");
	define($constpref."_REORDERTITLE", "Titre");
	define($constpref."_REORDERWEIGHT", "Position");
	define($constpref."_SETFORUMORDER", "Param&egrave;tres d'organisation des forums");
	define($constpref."_BOARDREORDER", "Le forum a &eacute;t&eacute; r&eacute;-ordonn&eacute;");
	 
	// admin_permission.php
	define($constpref."_PERMISSIONS_TO_THIS_FORUM", "Permissions pour ce forum");
	define($constpref."_CAT_ACCESS", "Acc&egrave;s aux cat&eacute;gories");
	define($constpref."_CAN_ACCESS", "Peut acc&eacute;der");
	define($constpref."_CAN_VIEW", "peut visualiser");
	define($constpref."_CAN_POST", "peut d&eacute;buter de nouveaux sujets");
	define($constpref."_CAN_REPLY", "peut r&eacute;pondre");
	define($constpref."_CAN_EDIT", "peut &eacute;diter");
	define($constpref."_CAN_DELETE", "peut effacer");
	define($constpref."_CAN_ADDPOLL", "peut ajouter un sondage");
	define($constpref."_CAN_VOTE", "peut voter");
	define($constpref."_CAN_ATTACH", "peut attacher");
	define($constpref."_CAN_NOAPPROVE", "peut poster sans approbation");
	define($constpref."_ACTION", "Action");
	 
	define($constpref."_PERM_TEMPLATE", "Mod&egrave;le de Permissions");
	define($constpref."_PERM_TEMPLATE_DESC", "Sera appliqu&eacute; aux nouveaux forums");
	define($constpref."_PERM_FORUMS", "S&eacute;lectionnez les forums");
	define($constpref."_PERM_TEMPLATE_CREATED", "Le mod&egrave;le de permissions a &eacute;t&eacute g&eacute;n&eacute;r&eacute;");
	define($constpref."_PERM_TEMPLATE_ERROR", "Une erreur s'est produite durant la cr&eacute;ation du mod&egrave;le de permission");
	define($constpref."_PERM_TEMPLATEAPP", "Appliquer les permissions par d&eacute;faut");
	define($constpref."_PERM_TEMPLATE_APPLIED", "Les permissions par d&eacute;faut ont &eacute;t&eacute; appliqu&eacute;es aux forums");
	define($constpref."_PERM_ACTION", "Outils de Gestion des Permissions");
	define($constpref."_PERM_SETBYGROUP", "D&eacute;duire les permissions des droits des groupes");
	 
	// admin_forum_prune.php
	 
	define($constpref."_PRUNE_RESULTS_TITLE", "R&eacute;sultats des purges");
	define($constpref."_PRUNE_RESULTS_TOPICS", "Sujets purg&eacute;s");
	define($constpref."_PRUNE_RESULTS_POSTS", "Contributions purg&eacute;es");
	define($constpref."_PRUNE_RESULTS_FORUMS", "Forums purg&eacute;s");
	define($constpref."_PRUNE_STORE", "Enregistrer les contributions de ces forums avant de les purger");
	define($constpref."_PRUNE_ARCHIVE", "R&eacute;aliser une copie d'archive des contributions");
	define($constpref."_PRUNE_FORUMSELERROR", "Vous avez oubli&eacute; de s&eacute;lectionner le ou les forums &agrave; purger");
	 
	define($constpref."_PRUNE_DAYS", "Supprimer les sujets sans r&eacute;ponse depuis :");
	define($constpref."_PRUNE_FORUMS", "Forums &agrave; purger");
	define($constpref."_PRUNE_STICKY", "Conserver les sujets &eacute;tiquet&eacute;s");
	define($constpref."_PRUNE_DIGEST", "Conserver les sujets en sommaire");
	define($constpref."_PRUNE_LOCK", "Conserver les sujets verrouill&eacute;s");
	define($constpref."_PRUNE_HOT", "Garder ces sujets qui ont plus que ce nombre de r&eacute;ponses");
	define($constpref."_PRUNE_SUBMIT", "Ok");
	define($constpref."_PRUNE_RESET", "R&eacute;initialiser");
	define($constpref."_PRUNE_YES", "Oui");
	define($constpref."_PRUNE_NO", "Non");
	define($constpref."_PRUNE_WEEK", "Une semaine");
	define($constpref."_PRUNE_2WEEKS", "Deux semaines");
	define($constpref."_PRUNE_MONTH", "Un mois");
	define($constpref."_PRUNE_2MONTH", "Deux mois");
	define($constpref."_PRUNE_4MONTH", "Quatre mois");
	define($constpref."_PRUNE_YEAR", "Un an");
	define($constpref."_PRUNE_2YEARS", "2 ans");
	 
	// About.php constants
	define($constpref.'_AUTHOR_INFO', "Informations au sujet de l'auteur");
	define($constpref.'_AUTHOR_NAME', "Auteur");
	define($constpref.'_AUTHOR_WEBSITE', "Site Web de l'auteur");
	define($constpref.'_AUTHOR_EMAIL', "Email de l'auteur");
	define($constpref.'_AUTHOR_CREDITS', "Cr&eacute;dits");
	define($constpref.'_MODULE_INFO', "Informations de d&eacute;veloppement du module");
	define($constpref.'_MODULE_STATUS', "Etats");
	define($constpref.'_MODULE_DEMO', "Site de d&eacute;monstration");
	define($constpref.'_MODULE_SUPPORT', "Site officiel de support");
	define($constpref.'_MODULE_BUG', "Rapporter un bug &agrave; propos de ce module");
	define($constpref.'_MODULE_FEATURE', "Sugg&eacute;rer une nouvelle fonction pour ce module");
	define($constpref.'_MODULE_DISCLAIMER', "Avertissement");
	define($constpref.'_AUTHOR_WORD', "Le monde de l'auteur");
	define($constpref.'_BY', 'Par');
	define($constpref.'_AUTHOR_WORD_EXTRA', " ");
	 
	 
	// admin_report.php
	define($constpref."_REPORTADMIN", "Posts rapport&eacute;s aux gestionnaires");
	define($constpref."_PROCESSEDREPORT", "Vues des rapports g&eacute;n&eacute;r&eacute;s");
	define($constpref."_PROCESSREPORT", "Rapports g&eacute;n&eacute;r&eacute;s");
	define($constpref."_REPORTTITLE", "Titre des rapports");
	define($constpref."_REPORTEXTRA", "Extra");
	define($constpref."_REPORTPOST", "Post rapport&eacute;");
	define($constpref."_REPORTTEXT", "Texte du rapport");
	define($constpref."_REPORTMEMO", "Memo g&eacute;n&eacute;r&eacute;");
	 
	// admin_report.php
	define($constpref."_DIGESTADMIN", "Gestion des sommaires");
	define($constpref."_DIGESTCONTENT", "Contenu des sommaires");
	 
	// admin_votedata.php
	define($constpref."_VOTE_RATINGINFOMATION", "Informations de vote");
	define($constpref."_VOTE_TOTALVOTES", "Nombre total de votes : ");
	define($constpref."_VOTE_REGUSERVOTES", "Votes d'utilisateurs enregistr&eacute;s : %s");
	define($constpref."_VOTE_ANONUSERVOTES", "Votes d'utilisateurs anonymes : %s");
	define($constpref."_VOTE_USER", "Utilisateur");
	define($constpref."_VOTE_IP", "Addresse IP");
	define($constpref."_VOTE_USERAVG", "Moyenne des cotations utilisateur");
	define($constpref."_VOTE_TOTALRATE", "Totaux des cotations");
	define($constpref."_VOTE_DATE", "Soumis");
	define($constpref."_VOTE_RATING", "cot&eacute;");
	define($constpref."_VOTE_NOREGVOTES", "Aucun vote d'utilisateur enregistr&eacute;");
	define($constpref."_VOTE_NOUNREGVOTES", "Aucun vote d'utilisateur non enregistr&eacute;");
	define($constpref."_VOTEDELETED", "Donn&eacute;es de vote effac&eacute;es.");
	define($constpref."_VOTE_ID", "N°");
	define($constpref."_VOTE_FILETITLE", "Titre du sujet");
	define($constpref."_VOTE_DISPLAYVOTES", "Informations de donn&eacute;es de vote");
	define($constpref."_VOTE_NOVOTES", "Aucun vote d'utilisateur &agrave; visualiser");
	define($constpref."_VOTE_DELETE", "Aucun vote d'utilisateur &agrave; visualiser");
	define($constpref."_VOTE_DELETEDSC", "<strong>Effacer</strong> les informations de vote s&eacute;lectionn&eacute;es de la base de donn&eacute;es.");
?>