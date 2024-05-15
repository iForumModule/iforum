<?php
	// $Id$
	if (defined('MAIN_DEFINED')) return;
	define('MAIN_DEFINED', true);
	 
	define("_MD_ERROR", "Erreur");
	define("_MD_NOPOSTS", "Aucune contribution");
	define("_MD_GO", "Ok");
	define("_MD_SELFORUM", "S&eacute;lectionner un forum");
	 
	define("_MD_THIS_FILE_WAS_ATTACHED_TO_THIS_POST", "Fichier attach&eacute; :");
	define("_MD_ALLOWED_EXTENSIONS", "Extensions autoris&eacute;es");
	define('_MD_MAX_FILESIZE', 'Taille Maximum de fichier');
	define("_MD_ATTACHMENT", "Attacher un fichier");
	define("_MD_FILESIZE", "Taille");
	define("_MD_HITS", "Hits");
	define("_MD_GROUPS", "Groupes :");
	define("_MD_DEL_ONE", "Effacer seulement ce message");
	define("_MD_DEL_RELATED", "Effacer tous les messages de ce sujet");
	define('_MD_MARK_ALL_FORUMS', 'Marquer tous les forums');
	define('_MD_MARK_ALL_TOPICS', 'Marquer tous les sujets');
	define('_MD_MARK_UNREAD', 'Non lus');
	define('_MD_MARK_READ', 'Lus ');
	define('_MD_ALL_FORUM_MARKED', 'Tous les forums marqu&eacute;s');
	define('_MD_ALL_TOPIC_MARKED', 'tous les sujets marqu&eacute;s');
	define('_MD_BOARD_DISCLAIMER', "Tableau d'avertissement");
	 
	 
	//index.php
	define ("_MD_ADMINCP", "Console d'admin");
	define ("_MD_FORUM", "Forum(s)");
	define ("_MD_WELCOME", "Bienvenue sur les forums de %s.");
	define ("_MD_TOPICS", "Sujet(s)");
	define ("_MD_POSTS", "Post(s)");
	define ("_MD_LASTPOST", "Derni&egrave;re(s) contribution(s)");
	define ("_MD_MODERATOR", "Mod&eacute;rateur(s)");
	define ("_MD_NEWPOSTS", "Nouvelle(s) contribution(s)");
	define ("_MD_NONEWPOSTS", "Aucune nouvelle contribution");
	define ("_MD_PRIVATEFORUM", "Forum inactif;");
	define ("_MD_BY", "par"); //  Post&eacute; par
	define ("_MD_TOSTART", "Pour voir les messages, vous devez s&eacute;lectionner un forum parmi ceux ci-dessous.");
	define ("_MD_TOTALTOPICSC", "Total sujets : ");
	define ("_MD_TOTALPOSTSC", "Total contributions : ");
	define ("_MD_TOTALUSER", "Total utilisateurs : ");
	define ("_MD_TIMENOW", "Nous sommes le  : %s");
	define ("_MD_LASTVISIT", "Votre derni&egrave;re visite : %s");
	define ("_MD_ADVSEARCH", "Recherche avanc&eacute;e");
	define ("_MD_POSTEDON", "Contribution du : ");
	define ("_MD_SUBJECT", "Sujet");
	define ("_MD_INACTIVEFORUM_NEWPOSTS", "Forum inactif contenant de nouvelle(s) contribution(s)");
	define ("_MD_INACTIVEFORUM_NONEWPOSTS", "Forum inactif sans nouvelle contribution");
	define ("_MD_SUBFORUMS", "Sous-forums");
	define ('_MD_MAINFORUMOPT', 'Options de menu');
	define ("_MD_PENDING_POSTS_FOR_AUTH", "Contributions en attente d'approbation :");
	 
	 
	 
	//page_header.php
	define ("_MD_MODERATEDBY", "Mod&eacute;r&eacute; par");
	define ("_MD_SEARCH", "Recherche");
	//define ("_MD_SEARCHRESULTS", "R&eacute;sultats de la recherche");
	define ("_MD_FORUMINDEX", "Index des forums %s");
	define ("_MD_POSTNEW", "Ecrire un nouveau message");
	define ("_MD_REGTOPOST", "S'enregistrer pour contribuer");
	 
	//search.php
	define ("_MD_SEARCHALLFORUMS", "Recherche dans tous les forums");
	define ("_MD_FORUMC", "Forum");
	define ("_MD_AUTHORC", "Auteur :");
	define ("_MD_SORTBY", "Tri par");
	define ("_MD_DATE", "Date");
	define ("_MD_TOPIC", "Sujet ");
	define('_MD_POST2', 'Contribution');
	define ("_MD_USERNAME", "Nom d'utilisateur");
	define ("_MD_BODY", "Corps de texte");
	define('_MD_SINCE', 'Depuis');
	 
	//viewforum.php
	define ("_MD_REPLIES", "R&eacute;ponse(s)");
	define ("_MD_POSTER", "Auteur");
	define ("_MD_VIEWS", "Vues");
	define ("_MD_MORETHAN", "Nouveaux [Populaire(s)]");
	define ("_MD_MORETHAN2", "Aucun nouveau [Populaire]");
	define ('_MD_TOPICSHASATT', 'Le sujet a une pi&egrave;ce jointe');
	define ('_MD_TOPICHASPOLL', 'Le sujet a un sondage');
	define ('_MD_TOPICLOCKED', 'Le sujet est verrouill&eacute;');
	define ("_MD_LEGEND", "L&eacute;gende");
	define ("_MD_NEXTPAGE", "prochaine page");
	define ("_MD_SORTEDBY", "Trier par");
	define ("_MD_TOPICTITLE", "Titre de sujet");
	define ("_MD_NUMBERREPLIES", "Nombre de r&eacute;ponses");
	define ("_MD_TOPICPOSTER", "Participation(s) au sujet");
	define ('_MD_TOPICTIME', 'Heure de publication');
	define ("_MD_LASTPOSTTIME", "Heure de la derni&egrave;re contribution");
	define ("_MD_ASCENDING", "Ordre ascendant");
	define ("_MD_DESCENDING", "Ordre descendant");
	define ('_MD_FROMLASTHOURS', 'Des % derni&egrave;res heures');
	define ("_MD_FROMLASTDAYS", "Des %d derniers jours");
	define ("_MD_THELASTYEAR", "Des derni&egrave;res ann&eacute;es");
	define ("_MD_BEGINNING", "Du D&eacute;but");
	define ('_MD_SEARCHTHISFORUM', 'Rechercher ce forum');
	define ('_MD_TOPIC_SUBJECTC', "Pr&eacute;fixe d'article :");
	 
	 
	define ('_MD_RATINGS', "Cotations");
	define("_MD_CAN_ACCESS", "Vous <strong>pouvez</strong> acc&eacute;der &agrave; ce forum.<br />");
	define("_MD_CANNOT_ACCESS", "Vous <strong>ne pouvez pas</strong> acc&eacute;der &agrave; ce forum.<br />");
	define ("_MD_CAN_POST", "Vous <strong>pouvez</strong> d&eacute;buter de nouveaux sujets.<br />");
	define ("_MD_CANNOT_POST", "Vous <strong>ne pouvez pas</strong> d&eacute;buter de nouveaux sujets.<br />");
	define ("_MD_CAN_VIEW", "Vous <strong>pouvez</strong> voir les sujets.<br />");
	define ("_MD_CANNOT_VIEW", "Vous <strong>ne pouvez pas</strong> voir les sujets.<br />");
	define ("_MD_CAN_REPLY", "Vous <strong>pouvez</strong> r&eacute;pondre aux contributions.<br />");
	define ("_MD_CANNOT_REPLY", "Vous <strong>ne pouvez pas</strong> r&eacute;pondre aux contributions.<br />");
	define ("_MD_CAN_EDIT", "Vous <strong>pouvez</strong> &eacute;diter vos contributions.<br />");
	define ("_MD_CANNOT_EDIT", "Vous <strong>ne pouvez pas</strong> &eacute;diter vos contributions.<br />");
	define ("_MD_CAN_DELETE", "Vous <strong>pouvez</strong> effacer vos contributions.<br />");
	define ("_MD_CANNOT_DELETE", "Vous <strong>ne pouvez pas</strong> effacez vos contributions.<br />");
	define ("_MD_CAN_ADDPOLL", "Vous <strong>pouvez</strong> ajouter de nouveaux sondages.<br />");
	define ("_MD_CANNOT_ADDPOLL", "Vous <strong>ne pouvez pas</strong> ajouter de nouveaux sondages.<br />");
	define ("_MD_CAN_VOTE", "Vous <strong>pouvez</strong> voter en sondage.<br />");
	define ("_MD_CANNOT_VOTE", "Vous <strong>ne pouvez pas</strong> voter en sondage.<br />");
	define ("_MD_CAN_ATTACH", "Vous <strong>pouvez</strong> attacher des fichiers &agrave; vos contributions.<br />");
	define ("_MD_CANNOT_ATTACH", "Vous <strong>ne pouvez pas</strong> attacher des fichiers &agrave; vos contributions.<br />");
	define ("_MD_CAN_NOAPPROVE", "Vous <strong>pouvez</strong> poster sans approbation.<br />");
	define ("_MD_CANNOT_NOAPPROVE", "Vous <strong>ne pouvez pas</strong> poster sans approbation.<br />");
	define ("_MD_IMTOPICS", "Sujets importants");
	define ("_MD_NOTIMTOPICS", "Sujets des forums");
	define ('_MD_FORUMOPTION', 'Options des forums');
	 
	define('_MD_VAUP', 'Voir toutes les contributions sans r&eacute;ponse');
	define('_MD_VANP', 'Voir les nouvelles contributions');
	 
	 
	define('_MD_UNREPLIED', 'sujets sans r&eacute;ponse');
	define('_MD_UNREAD', 'sujets non lus');
	define('_MD_ALL', 'tous les sujets');
	define('_MD_ALLPOSTS', 'toutes les contributions');
	define('_MD_VIEW', 'Voir');
	 
	//viewtopic.php
	define ("_MD_AUTHOR", "Auteur");
	define ("_MD_LOCKTOPIC", "Verrouiller ce sujet");
	define ("_MD_UNLOCKTOPIC", "D&eacute;verrouiller ce sujet");
	define ("_MD_UNSTICKYTOPIC", "D&eacute;sagrafer ce sujet");
	define ("_MD_STICKYTOPIC", "Agrafer ce sujet");
	define('_MD_DIGESTTOPIC', 'Sommairiser ce sujet');
	define('_MD_UNDIGESTTOPIC', 'D&eacute;sommairiser ce sujet');
	define('_MD_MERGETOPIC', 'Fusionner ce sujet');
	define ("_MD_MOVETOPIC", "D&eacute;placer ce sujet");
	define ("_MD_DELETETOPIC", "Effacer ce sujet");
	define ("_MD_TOP", "Haut");
	define('_MD_BOTTOM', 'Bas');
	define ("_MD_PREVTOPIC", "Pr&eacute;c&eacute;dent");
	define ("_MD_NEXTTOPIC", "Suivant");
	define ("_MD_GROUP", "Groupe :");
	define ("_MD_QUICKREPLY", "R&eacute;ponse rapide");
	define ("_MD_POSTREPLY", "Enregistrer votre r&eacute;ponse");
	define ("_MD_PRINTTOPICS", "Imprimer le sujet");
	define ("_MD_PRINT", "Imprimer");
	define ("_MD_REPORT", "Rapport");
	define ("_MD_PM", "PM");
	define('_MD_EMAIL', 'Email');
	define ("_MD_WWW", "WWW");
	define ("_MD_AIM", "AIM");
	define ("_MD_YIM", "YIM");
	define ("_MD_MSNM", "MSNM");
	define ("_MD_ICQ", "ICQ");
	define ("_MD_PRINT_TOPIC_LINK", "URL de cette discussion");
	define ("_MD_ADDTOLIST", "Ajouter &agrave; votre liste de contact");
	define('_MD_TOPICOPT', 'Options du sujet');
	define('_MD_VIEWMODE', 'Affichage');
	define('_MD_NEWEST', 'les plus r&eacute;cents en premier');
	define('_MD_OLDEST', 'les plus anciens en premier');
	 
	define('_MD_FORUMSEARCH', 'Recherche');
	 
	define('_MD_RATED', 'Not&eacute; :');
	define('_MD_RATE', 'Cotations');
	define('_MD_RATEDESC', 'Donner une note');
	define('_MD_RATING', 'Voter');
	define('_MD_RATE1', 'Terrible');
	define('_MD_RATE2', 'Mauvais');
	define('_MD_RATE3', 'Passable');
	define('_MD_RATE4', 'Bon!!!');
	define('_MD_RATE5', 'Excellent');
	 
	define('_MD_TOPICOPTION', 'Options du sujet');
	define('_MD_KARMA_REQUIREMENT', 'Votre Karma personnel %s est inf&eacute;rieur au Karma requis %s. <br /> Veuillez essayer plus tard.');
	define('_MD_REPLY_REQUIREMENT', "Afin de visualiser cette contribution, vous devez d'abord r&eacute;pondre.");
	define('_MD_TOPICOPTIONADMIN', 'Options des sujets');
	define('_MD_POLLOPTIONADMIN', 'Options de sondage');
	 
	define('_MD_EDITPOLL', 'Editer ce sondage');
	define('_MD_DELETEPOLL', 'Effacer ce sondage');
	define('_MD_RESTARTPOLL', 'Relancer ce sondage');
	define('_MD_ADDPOLL', 'Ajouter un sondage');
	 
	define("_MD_QUICKREPLY_EMPTY", "Entrez votre r&eacute;ponse rapide ici");
	 
	define('_MD_LEVEL', 'Niveau :');
	define('_MD_HP', 'HP :');
	define('_MD_MP', 'MP :');
	define('_MD_EXP', 'EXP :');
	 
	define('_MD_BROWSING', 'Parcourir ce sujet :');
	define('_MD_POSTTONEWS', 'Envoyer cette contribution comme un article d\'actualit&eacute;');
	 
	define('_MD_EXCEEDTHREADVIEW', 'Le nombre des contributions d&eacute;passe les capacit&eacute;s du mode par sujet<br />Changez pour le mode &agrave; plat');
	 
	 
	//forumform.inc
	define ("_MD_PRIVATE", "Ceci est un forum <strong>priv&eacute;</strong>.<br />seuls les utilisateurs disposant des droits d'acc&egrave;s sp&eacute;ciaux peuvent proposer de nouveaux sujets et r&eacute;pondre");
	define ("_MD_QUOTE", "Citation");
	define ('_MD_VIEW_REQUIRE', 'Pr&eacute;requis de visualisation');
	define ('_MD_REQUIRE_KARMA', 'Karma');
	define ('_MD_REQUIRE_REPLY', 'R&eacute;pondre');
	define ('_MD_REQUIRE_NULL', 'Aucun pr&eacute;requis');
	 
	define ("_MD_SELECT_FORMTYPE", "S&eacute;lectionnez votre type de formulaire d&eacute;sir&eacute;");
	 
	define ("_MD_FORM_COMPACT", "Compact");
	define ("_MD_FORM_DHTML", "DHTML");
	define ("_MD_FORM_SPAW", "Editeur Spaw");
	define ("_MD_FORM_HTMLAREA", "HTMLArea");
	define ("_MD_FORM_KOIVI", "Editeur Koivi");
	define ("_MD_FORM_FCK", "Editeur FCK");
	define ("_MD_FORM_TINYMCE", "Editeur TinyMCE");
	 
	// Messages d'ERREURS
	define ("_MD_ERRORFORUM", "ERREUR : Aucun forum n'a &eacute;t&eacute; s&eacute;lectionn&eacute;!");
	define ("_MD_ERRORPOST", "ERREUR : Aucune contribution n'a &eacute;t&eacute; s&eacute;lectionn&eacute;e!");
	define ('_MD_NORIGHTTOVIEW', 'Vous ne disposez pas des privil&egrave;ges pour visualiser ce sujet.');
	define ('_MD_NORIGHTTOPOST', 'Vous ne disposez pas des privil&egrave;ges pour contribuer &agrave; ce forum.');
	define ('_MD_NORIGHTTOEDIT', 'Vous ne disposez pas des privil&egrave;ges pour &eacute;diter dans ce forum.');
	define ('_MD_NORIGHTTOREPLY', 'Vous ne disposez pas des privil&egrave;ges pour r&eacute;pondre dans ce forum.');
	define ('_MD_NORIGHTTOACCESS', 'Vous ne disposez pas des privil&egrave;ges pour acc&eacute;der &agrave; ce forum.');
	define ('_MD_ERRORTOPIC', 'ERREUR : Sujet non s&eacute;lectionn&eacute;!');
	define ('_MD_ERRORCONNECT', 'ERREUR : ne peut pas se connecter &agrave; la base de donn&eacute;es des forums.');
	define ('_MD_ERROREXIST', "ERREUR : Le forum que vous avez s&eacute;lectionn&eacute; n'existe pas. Veuillez revenir en arri&egrave;re et recommencer.");
	define ("_MD_ERROROCCURED", "Une erreur est apparue");
	define ("_MD_COULDNOTQUERY", "ne parvient pas &agrave; interroger la base de donn&eacute;es des forums.");
	define ("_MD_FORUMNOEXIST", "Erreur - Le forum/sujet que vous avez s&eacute;lectionn&eacute; n'existe pas. Veuillez revenir en arri&egrave;re et r&eacute;essayez.");
	define ("_MD_USERNOEXIST", "Cet utilisateur n'existe pas. Veuillez revenir en arri&egrave;re et rechercher encore.");
	define ("_MD_COULDNOTREMOVE", "Erreur - ne peut supprimer les contributions de la base de donn&eacute;es!");
	define ("_MD_COULDNOTREMOVETXT", "Erreur - ne peut supprimer les textes des contributions!");
	define ('_MD_TIMEISUP', "Vous avez d&eacute;pass&eacute; la limite du temps imparti &agrave; l'&eacute;dition de ce post.");
	define ('_MD_TIMEISUPDEL', "Vous avez d&eacute;pass&eacute; la limite du temps imparti &agrave; l'effacement de votre contribution.");
	 
	//reply.php
	define ("_MD_ON", "sur"); //D&eacute;pos&eacute; sur
	define ("_MD_USERWROTE", "%s a &eacute;crit :"); //%s est le pseudo de l'utilisateur
	define('_MD_RE', 'Re');
	 
	//post.php
	define ("_MD_EDITNOTALLOWED", "Vous n'&ecirc;tes pas autoris&eacute;s &agrave; &eacute;diter cette Contribution!");
	define ("_MD_EDITEDBY", "Edit&eacute; par");
	define ("_MD_ANONNOTALLOWED", "les utilisateurs anonymes ne sont pas autoris&eacute;s &agrave; participer.<br />Veuillez vous enregistrer.");
	define ("_MD_THANKSSUBMIT", "Merci pour votre contribution!");
	define ("_MD_REPLYPOSTED", "Une r&eacute;ponse &agrave; votre sujet vient d'&ecirc;tre post&eacute;e.");
	define ("_MD_HELLO", "Bonjour %s,");
	define ("_MD_URRECEIVING", "Vous recevez cet email parce qu'une r&eacute;ponse &agrave; votre contribution a &eacute;t&eacute; post&eacute;e sur les forums de %s.");//%s est votre nom de votre site
	define ("_MD_CLICKBELOW", "Cliquez sur le lien afin de visualiser la discussion :");
	define ('_MD_WAITFORAPPROVAL', "Veuillez patienter pour l'approbation.");
	define ('_MD_POSTING_LIMITED', 'Pourquoi ne pas faire une pause et revenir dans %d secondes');
	 
	//forumform.inc
	define ('_MD_NAMEMAIL', 'Nom/Email :');
	define ("_MD_LOGOUT", "Se d&eacute;connecter");
	define ("_MD_REGISTER", "S'enregistrer");
	define ("_MD_SUBJECTC", "Sujet :");
	define ("_MD_MESSAGEICON", "Ic&ocirc;ne du message :");
	define ("_MD_MESSAGEC", "Message :");
	define ("_MD_ALLOWEDHTML", "Autoriser le HTML :");
	define ("_MD_OPTIONS", "Options :");
	define ("_MD_POSTANONLY", "Poster anonymement");
	define ('_MD_DOSMILEY', 'Activer les &eacute;moticones');
	define ('_MD_DOXCODE', 'Activer les codes Xoops');
	define ('_MD_DOBR', 'Activation du line break (Sugg&eacute;rr&eacute; non activ&eacute; si le HTML est activ&eacute;)');
	define ('_MD_DOHTML', 'Activer les tags HTML');
	define ("_MD_NEWPOSTNOTIFY", "Notifiez-moi les nouvelles contributions sur ce sujet");
	define ("_MD_ATTACHSIG", "Attacher la signature");
	define ("_MD_POST", "Poster");
	define ("_MD_SUBMIT", "Valider");
	define ("_MD_CANCELPOST", "Abandonner");
	define ('_MD_REMOVE', 'Enlever');
	define ('_MD_UPLOAD', 'T&eacute;l&eacute;charger');
	 
	// forumuserpost.php
	define ("_MD_ADD", "Ajouter");
	define ("_MD_REPLY", "R&eacute;ponse");
	 
	// topicmanager.php
	define('_MD_VIEWTHETOPIC', 'Voir le sujet');
	define('_MD_RETURNTOTHEFORUM', 'Retourner au forum');
	define('_MD_RETURNFORUMINDEX', "Retourner &agrave; l'index des forums");
	define('_MD_ERROR_BACK', 'Erreur - veuillez aller en arri&egrave;re et recommencer.');
	define('_MD_GOTONEWFORUM', 'Voir le sujet mis &agrave; jour');
	 
	define('_MD_TOPICDELETE', 'Le sujet a &eacute;t&eacute; effac&eacute;');
	define('_MD_TOPICMERGE', 'Le sujet a &eacute;t&eacute; fusionn&eacute;.');
	define('_MD_TOPICMOVE', 'Le sujet a &eacute;t&eacute; d&eacute;plac&eacute;');
	define('_MD_TOPICLOCK', 'Le sujet est verrouill&eacute;');
	define('_MD_TOPICUNLOCK', 'Le sujet a &eacute;t&eacute; d&eacute;verrouill&eacute;');
	define('_MD_TOPICSTICKY', 'Le sujet est agraf&eacute;');
	define('_MD_TOPICUNSTICKY', 'Le sujet a &eacute;t&eacute; d&eacute;sagraf&eacute;');
	define('_MD_TOPICDIGEST', 'Le sujet est sommairis&eacute;');
	define('_MD_TOPICUNDIGEST', 'Le sujet a &eacute;t&eacute; d&eacute;sommairis&eacute;');
	 
	define('_MD_DELETE', 'Effacer');
	define('_MD_MOVE', 'D&eacute;placer');
	define('_MD_MERGE', 'Fusionner');
	define('_MD_LOCK', 'Verrouiller');
	define('_MD_UNLOCK', 'D&eacute;verrouiller');
	define('_MD_STICKY', 'Agrafer');
	define('_MD_UNSTICKY', 'D&eacute;sagrafer');
	define('_MD_DIGEST', 'Sommairiser');
	define('_MD_UNDIGEST', 'D&eacute;sommairiser');
	 
	define('_MD_DESC_DELETE', 'Une fois que vous aurez appuy&eacute; sur le bouton Effacer &agrave; la fin de ce formulaire, le sujet que vous avez s&eacute;lectionn&eacute; et toutes ses contributions relatives seront <b>d&eacute;finitivement</b> effac&eacute;s.');
	define('_MD_DESC_MOVE', 'Une fois que vous aurez appuy&eacute; sur le bouton Modifier &agrave; la fin de ce formulaire, le sujet que vous avez s&eacute;lectionn&eacute; et toutes ses contributions relatives seront d&eacute;plac&eacute;s vers le forum que vous aurez s&eacute;lectionn&eacute;.');
	define('_MD_DESC_MERGE', 'Une fois que vous aurez appuy&eacute; sur le bouton Fusionner &agrave; la fin de ce formulaire, le sujet que vous avez s&eacute;lectionn&eacute; et toutes ses contributions relatives seront fusionn&eacute;s dans le sujet que vous aurez s&eacute;lectionn&eacute;.<br /><strong>Le num&eacute;ro de sujet de destination ID doit &ecirc;tre plus petit que celui du sujet courrant</strong>.');
	define('_MD_DESC_LOCK', 'Une fois que vous aurez appuy&eacute; sur le bouton Verouiller &agrave; la fin de ce formulaire, le sujet que vous avez s&eacute;lectionn&eacute; sera verrouill&eacute;. Vous pourrez le d&eacute;verrouiller plus tard si vous le d&eacute;sirez.');
	define('_MD_DESC_UNLOCK', 'Une fois que vous aurez appuy&eacute; sur le bouton D&eacute;verrouiller &agrave; la fin de ce formulaire, le sujet que vous avez s&eacute;lectionn&eacute; sera d&eacute;verrouill&eacute;. Vous pourrez le re-verrouiller plus tard si vous le d&eacute;sirez.');
	define('_MD_DESC_STICKY', 'Une fois que vous aurez appuy&eacute; sur le bouton Agrafer &agrave; la fin de ce formulaire, le sujet que vous avez s&eacute;lectionn&eacute; sera mis en agrafe. Vous pourrez le d&eacute;sagrafer plus tard si vous le d&eacute;sirez.');
	define('_MD_DESC_UNSTICKY', 'Une fois que vous aurez appuy&eacute; sur le bouton D&eacute;sagrafer &agrave; la fin de ce formulaire, le sujet que vous sera d&eacute;-agraf&eacute;,. Vous pourrez le r&eacute;-agrafer plus tard si vous le d&eacute;sirez.');
	define('_MD_DESC_DIGEST', 'Une fois que vous aurez appuy&eacute; sur le bouton Sommairiser &agrave; la fin de ce formulaire, le sujet que vous avez s&eacute;lectionn&eacute; deviendra un sommaire. Vous pourrez le d&eacute;sommairiser plus tard si vous le d&eacute;sirez.');
	define('_MD_DESC_UNDIGEST', 'Une fois que vous aurez appuy&eacute; sur le bouton D&eacute;sommairiser &agrave; la fin de ce formulaire, le sujet que vous avez s&eacute;lectionn&eacute; sera d&eacute;sommairis&eacute;. Vous pourrez le remettre en sommaire une nouvelle fois plus tard si vous le d&eacute;sirez.');
	 
	define('_MD_MERGETOPICTO', 'Fusionner le sujet vers :');
	define('_MD_MOVETOPICTO', 'D&eacute;placer le sujet vers :');
	define('_MD_NOFORUMINDB', 'Pas de forum dans la base');
	 
	// delete.php
	define ("_MD_DELNOTALLOWED", "D&eacute;sol&eacute;, mais vous n'&ecirc;tes pas autoris&eacute; &agrave; effacer cette contribution.");
	define ("_MD_AREUSUREDEL", "Etes vous certain de d&eacute;sirer effacer cette contribution et toutes les contributions enfants ?");
	define ("_MD_POSTSDELETED", "La contribution S&eacute;lectionn&eacute;e et toutes ses contributions enfants ont &eacute;t&eacute; effac&eacute;es.");
	define ('_MD_POSTDELETED', 'Effacer la contribution s&eacute;lectionn&eacute;e.');
	 
	// les d&eacute;finitions ont boug&eacute; de global.
	define ("_MD_THREAD", "Contribution");
	define ("_MD_FROM", "De");
	define ("_MD_JOINED", "Inscrit");
	define ("_MD_ONLINE", "En ligne");
	define ('_MD_OFFLINE', 'Hors Ligne');
	define ('_MD_FLAT', 'A plat');
	 
	 
	// class.whoisonline.php
	define ("_MD_USERS_ONLINE", "Utilisateur(s) en ligne :");
	define ("_MD_ANONYMOUS_USERS", "Utilisateur(s) anonymes");
	define ("_MD_REGISTERED_USERS", "Utilisateur(s) enregistr&eacute;s : ");
	define ("_MD_BROWSING_FORUM", "Utilisateur(s) en consultation des forums");
	define ("_MD_TOTAL_ONLINE", "Total %d utilisateurs en ligne.");
	define ("_MD_ADMINISTRATOR", "Administrateur");
	 
	define('_MD_NO_SUCH_FILE', "Le fichier n'existe pas!");
	define('_MD_ERROR_UPATEATTACHMENT', "Une erreur s'est produite &agrave; la mise &agrave; jour de la pi&egrave;ce jointe");
	 
	// ratethread.php
	define("_MD_CANTVOTEOWN", "Vous ne pouvez pas voter pour le sujet que vous avez soumis.<br />Tous les votes sont enregistr&eacute;s et contr&ocirc;l&eacute;s.");
	define("_MD_VOTEONCE", "Merci de ne voter qu'une seule fois pour le m&ecirc;me sujet.");
	define("_MD_VOTEAPPRE", "Merci de votre vote.");
	define("_MD_THANKYOU", "Merci d'avoir pris le temps de voter ici sur %s"); // %s est le nom de votre site web
	define("_MD_VOTES", "Votes");
	define("_MD_NOVOTERATE", "Vous n'avez pas not&eacute; ce sujet");
	 
	 
	// polls.php
	define("_MD_POLL_DBUPDATED", "Base de donn&eacute;es mise &agrave; jour avec succ&egrave;s!");
	define("_MD_POLL_POLLCONF", "Configuration des sondages");
	define("_MD_POLL_POLLSLIST", "Liste des sondages");
	define("_MD_POLL_AUTHOR", "Auteur du sondage");
	define("_MD_POLL_DISPLAYBLOCK", "Afficher dans un bloc ?");
	define("_MD_POLL_POLLQUESTION", "Question du sondage");
	define("_MD_POLL_VOTERS", "Total de votants");
	define("_MD_POLL_VOTES", "Total de votes");
	define("_MD_POLL_EXPIRATION", "Expiration");
	define("_MD_POLL_EXPIRED", "Expir&eacute;");
	define("_MD_POLL_VIEWLOG", "Voir le log");
	define("_MD_POLL_CREATNEWPOLL", "Cr&eacute;er un nouveau sondage");
	define("_MD_POLL_POLLDESC", "Description de sondage");
	define("_MD_POLL_DISPLAYORDER", "Ordre de visualisation");
	define("_MD_POLL_ALLOWMULTI", "Autoriser les s&eacute;lections multiples ?");
	define("_MD_POLL_NOTIFY", "Notifier l'auteur du sondage lorsque celui ci est expir&eacute; ?");
	define("_MD_POLL_POLLOPTIONS", "Options");
	define("_MD_POLL_EDITPOLL", "Editer le sondage");
	define("_MD_POLL_FORMAT", "Format : aaaa-mm-dd hh:mm:ss");
	define("_MD_POLL_CURRENTTIME", "Nous sommes le %s");
	define("_MD_POLL_EXPIREDAT", "Expir&eacute; le %s");
	define("_MD_POLL_RESTART", "Relancer ce sondage");
	define("_MD_POLL_ADDMORE", "Ajouter plus d'options");
	define("_MD_POLL_RUSUREDEL", "Etes vous certain de vouloir effacer ce sondage et tous ses commentaires ?");
	define("_MD_POLL_RESTARTPOLL", "Relancer le sondage");
	define("_MD_POLL_RESET", "Mettre &agrave; Z&eacute;ro toutes les logs pour ce sondage ?");
	define("_MD_POLL_ADDPOLL", "Ajouter un sondage");
	define("_MD_POLLMODULE_ERROR", "Le module Xoopspoll n'est pas valide &agrave; l'utilisation");
	 
	//report.php
	define("_MD_REPORTED", "Merci de votre rapport au sujet de ce post/sujet! Un mod&eacute;rateur le prendra en compte dans un court delai.");
	define("_MD_REPORT_ERROR", "Une erreur est apparue &agrave; l'envoi du rapport.");
	define("_MD_REPORT_TEXT", "Message de rapport :");
	 
	define("_MD_PDF", "Cr&eacute;er un fichier PDF de la contribution");
	define("_MD_PDF_PAGE", "Page");
	 
	//print.php
	define("_MD_COMEFROM", "Cette contribution &eacute;tait de :");
	 
	//viewpost.php
	define("_MD_VIEWALLPOSTS", "Tous les Posts");
	define("_MD_VIEWTOPIC", "Sujet");
	define("_MD_VIEWFORUM", "Forum");
	 
	define("_MD_COMPACT", "Compact");
	 
	define("_MD_WELCOME_SUBJECT", "%s &agrave; rejoint le forum");
	define("_MD_WELCOME_MESSAGE", "Bonjour, %s est un petit nouveau.");
	 
	define("_MD_VIEWNEWPOSTS", "Voir les nouveaux posts");
	 
	define("_MD_INVALID_SUBMIT", "Soumission invalide. Vous avez peut &ecirc;tre d&eacute;pass&eacute; le temps de la session. Veuillez faire une sauvegarde de votre contribution et la ressoumettre.");
	 
	define("_MD_ACCOUNT", "Compte");
	define("_MD_NAME", "Nom");
	define("_MD_PASSWORD", "Mot de passe");
	define("_MD_LOGIN", "Authentification");
	 
	define("_MD_TRANSFER", "Transf&eacute;rer");
	define("_MD_TRANSFER_DESC", "Transf&eacute;rer la contribution vers d'autres applications");
	define("_MD_TRANSFER_DONE", "Cette action a &eacute;t&eacute; effectu&eacute;e avec succ&egrave;s : %s");
	 
	define("_MD_APPROVE", "Approuver");
	define("_MD_RESTORE", "Restaurer");
	define("_MD_SPLIT_ONE", "Eclater");
	define("_MD_SPLIT_TREE", "Eclater toutes les contributions enfin");
	define("_MD_SPLIT_ALL", "Eclater tout");
	 
	define("_MD_TYPE_ADMIN", "Admin");
	define("_MD_TYPE_VIEW", "Vue");
	define("_MD_TYPE_PENDING", "En attente");
	define("_MD_TYPE_DELETED", "Supprim&eacute;");
	define("_MD_TYPE_SUSPEND", "Suspension");
	 
	define("_MD_DBUPDATED", "Base de Donn&eacute;es mise &agrave; jour avec Succ&egrave;s!");
	 
	define("_MD_SUSPEND_SUBJECT", "L'utilisateur %s est suspendu depuis %d jours");
	define("_MD_SUSPEND_TEXT", "L'utilisateur %s est suspendu depuis %d jours en raison de :<br />[quote]%s[/quote]<br /><br />La suspension courre jusqu'au %s");
	define("_MD_SUSPEND_UID", "Num&eacute;ro ID Utilisateur");
	define("_MD_SUSPEND_IP", "Segments d'adresses IP (adresse en entier ou segments)");
	define("_MD_SUSPEND_DURATION", "Dur&eacute;e de la Suspension (en jours)");
	define("_MD_SUSPEND_DESC", "Raison de la Suspension");
	define("_MD_SUSPEND_LIST", "Liste des Suspensions");
	define("_MD_SUSPEND_START", "D&eacute;but");
	define("_MD_SUSPEND_EXPIRE", "Fin");
	define("_MD_SUSPEND_SCOPE", "Scope");
	define("_MD_SUSPEND_MANAGEMENT", "Gestion de la Mod&eacute;ration");
	define("_MD_SUSPEND_NOACCESS", "Votre num&eacute;ro d'utilisateur ou votre adresse IP ont &eacute;t&eacute; suspendus");
	 
	// !!IMPORTANT!! insert '\' to any char among reserved chars: "a", "A","B","c","d","D","F","g","G","h","H","i","I","j","l","L","m","M","n","O","r","s","S","t","T","U","w","W","Y","y","z","Z"
	// insert additional '\' to 't', 'r', 'n'
	define("_MD_TODAY", "\A\u\j\o\u\\r\d\'\h\u\i G:i:s");
	define("_MD_YESTERDAY", "\H\i\e\\r G:i:s");
	define("_MD_MONTHDAY", "d/m H:i:s");
	define("_MD_YEARMONTHDAY", "d/m/Y H:i");
	 
	// For user info
	// If you have customized userbar, define here.
	/*require_once(ICMS_ROOT_PATH."/modules/".basename(  dirname(  dirname(  dirname( __FILE__ ) ) ) )."/class/user.php");
	class User_language extends User
	{
	function User_language(&$user)
	{
	$this->User($user);
	}
	 
	function &getUserbar()
	{
	global $isadmin;
	if (empty(icms::$module->config['userbar_enabled'])) return null;
	$user =& $this->user;
	$userbar = array();
	$userbar[] = array("link"=>ICMS_URL . "/userinfo.php?uid=" . $user->getVar("uid"), "name" =>_PROFILE);
	if (is_object(icms::$user))
	$userbar[]= array("link"=>"javascript:void openWithSelfMain('" . ICMS_URL . "/pmlite.php?send2=1&amp;to_userid=" . $user->getVar("uid") . "', 'pmlite', 450, 380);", "name"=>_MD_PM);
	if ($user->getVar('user_viewemail') || $isadmin)
	$userbar[]= array("link"=>"javascript:void window.open('mailto:" . $user->getVar('email') . "', 'new');", "name"=>_MD_EMAIL);
	if ($user->getVar('url'))
	$userbar[]= array("link"=>"javascript:void window.open('" . $user->getVar('url') . "', 'new');", "name"=>_MD_WWW);
	if ($user->getVar('user_icq'))
	$userbar[]= array("link"=>"javascript:void window.open('http://wwp.icq.com/scripts/search.dll?to=" . $user->getVar('user_icq')."', 'new');", "name" => _MD_ICQ);
	if ($user->getVar('user_aim'))
	$userbar[]= array("link"=>"javascript:void window.open('aim:goim?screenname=" . $user->getVar('user_aim') . "&amp;message=Hi+" . $user->getVar('user_aim') . "+Are+you+there?" . "', 'new');", "name"=>_MD_AIM);
	if ($user->getVar('user_yim'))
	$userbar[]= array("link"=>"javascript:void window.open('http://edit.yahoo.com/config/send_webmesg?.target=" . $user->getVar('user_yim') . "&amp;.src=pg" . "', 'new');", "name"=> _MD_YIM);
	if ($user->getVar('user_msnm'))
	$userbar[]= array("link"=>"javascript:void window.open('http://members.msn.com?mem=" . $user->getVar('user_msnm') . "', 'new');", "name" => _MD_MSNM);
	return $userbar;
	}
	}*/
	define('_MD_UP', 'En haut');
	define('_MD_POSTTIME', 'Date');
	define('_MD_EXTRAS', 'extras');
	define('_MD_RIGHT', 'right');
	define('_MD_LEFT', 'left');

	//new since 1.00
	define('_MD_CHANGE_THE_FORUM', 'Change the forum');
?>