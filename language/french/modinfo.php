<?php
// $Id: modinfo.php,v 1.7 2005/06/03 01:36:14 phppp Exp $
// Thanks Tom (http://www.wf-projects.com), for correcting the Engligh language package

// Module Info

// The name of this module
define("_MI_NEWBB_NAME","Forum CBB");

// A brief description of this module
define("_MI_NEWBB_DESC","Module de forums pour la Communauté XOOPS");

// Names of blocks for this module (Not all module has blocks)
define("_MI_NEWBB_BNAME0","Sujets r&eacute;cemment r&eacute;pondus");
define("_MI_NEWBB_BNAME1","Sujets r&eacute;cents");
define("_MI_NEWBB_BNAME2","Sujets les plus vus");
define("_MI_NEWBB_BNAME3","Sujets les plus actifs");
define("_MI_NEWBB_BNAME4","Nouveaux gros titres");
define("_MI_NEWBB_BNAME5","Nouveaux sujets agraph&eacute;s");
define("_MI_NEWBB_BNAME6","Nouveaux posts");
define("_MI_NEWBB_BNAME7","Auteurs avec le plus de sujets");
define("_MI_NEWBB_BNAME8","Auteurs avec le plus de posts");
define("_MI_NEWBB_BNAME9","Auteurs avec le plus Sommairis&eacute;s");
define("_MI_NEWBB_BNAME10","Auteurs avec le plus de sujets attach&eacute;s");
define("_MI_NEWBB_BNAME11","Derni&egrave;re contribution avec du texte");

// Names of admin menu items
define("_MI_NEWBB_ADMENU1","Index");
define("_MI_NEWBB_ADMENU2","Cat&eacute;gories");
define("_MI_NEWBB_ADMENU3","Forums");
define("_MI_NEWBB_ADMENU4","Synchronisation");
define("_MI_NEWBB_ADMENU5","Organisation");
define("_MI_NEWBB_ADMENU6","Purge");
define("_MI_NEWBB_ADMENU7","Posts rapport&eacute;s");
define("_MI_NEWBB_ADMENU8","Blocs");
define("_MI_NEWBB_ADMENU9","Sommaires");
define("_MI_NEWBB_ADMENU10","Votes");



//config options

define("_MI_DO_DEBUG","Mode Debug");
define("_MI_DO_DEBUG_DESC","Montrer les messages d'erreur");

define("_MI_IMG_SET","Set d'images");
define("_MI_IMG_SET_DESC","S&eacute;lectionner le set d'images &agrave; utiliser");
define("_MI_DIR_ATTACHMENT","Chemin physique des fichiers attach&eacute;s");
define("_MI_DIR_ATTACHMENT_DESC","Le chemin physique doit être param&egrave;tr&eacute; &agrave; la racine de xoops et pas avant, par exemple vous pouvez avoir des attachements t&eacute;l&eacute;charg&eacute;s sur www.votresite.com/uploads/newbb le chemin ent&eacute;rin&eacute; devra &ecirc;tre alors '/upload/newbb' sans jamais inclure le '/' final. Le chemin des thumbmails deviendra '/uploads/newbb/thumbs'.");
define("_MI_PATH_MAGICK","Chemin pour ImageMagick");
define("_MI_PATH_MAGICK_DESC","Usuellement il s'agit de '/usr/bin/X11'. Laissez le vide si ImageMAgick n'est pas install&eacute;");

define("_MI_SUBFORUM_DISPLAY","Mode de visualisation des sous-forums sur la page index");
define("_MI_SUBFORUM_DISPLAY_DESC","");
define("_MI_SUBFORUM_EXPAND","Etendu");
define("_MI_SUBFORUM_COLLAPSE","Condens&eacute;");
define("_MI_SUBFORUM_HIDDEN","Cach&eacute;");

define("_MI_POST_EXCERPT","Publier un extrait sur la page d'index du forum");
define("_MI_POST_EXCERPT_DESC","Longueur de l'extrait de la contribution au survol de la souris. 0 pour aucun extrait.");

define("_MI_PATH_NETPBM","Chemin pour Netpbm");
define("_MI_PATH_NETPBM_DESC","Usuellement il s'agit de '/usr/bin'. Laissez en blanc si Netpbm n'est pas install&eacute; ou choisissez AUTO pour une autod&eacute;tection.");

define("_MI_IMAGELIB","S&eacute;lectionnez les librairies d'image &agrave; utiliser");
define("_MI_IMAGELIB_DESC","S&eacute;lectionnez la librairie d'image avec laquelle vous d&eacute;sirez cr&eacute;er les &eacute;tiquettes. Laissez &agrave; AUTO pour une autod&eacute;tection.");

define("_MI_MAX_IMG_WIDTH","Largeur maximale de l'image");
define("_MI_MAX_IMG_WIDTH_DESC", "Param&egrave;tre les valeur maximum pour la <strong>largeur</strong> d'une image devant &ecirc;tre utilis&eacute; dans les thumbnail. <br >Entrez 0 si vous ne d&eacute;sirez pas cr&eacute;er de thumbnails.");

define("_MI_MAX_IMAGE_WIDTH","Largeur maximale de l'image pour la cr&eacute;er une miniature");
define("_MI_MAX_IMAGE_WIDTH_DESC", "D&eacute;finit la largeur maximale de l'image envoy&eacute;e pour cr&eacute;er une miniature. <br >Une image de largeur plus &eacute;lev&eacute;e que la valeur d&eacute;finie n'aura pas de miniature.");

define("_MI_MAX_IMAGE_HEIGHT","Hauteur maximum de l'image pour cr&eacute;er une miniature");
define("_MI_MAX_IMAGE_HEIGHT_DESC", "D&eacute;finit la hauteur maximale de l'image envoy&eacute;e pour cr&eacute;er une miniature. <br >Une image de hauteur plus &eacute;lev&eacute;e que la valeur d&eacute;finie n'aura  pas de miniature.");

define("_MI_SHOW_DIS","Afficher la mise en garde");
define("_MI_DISCLAIMER","Mise en garde");
define("_MI_DISCLAIMER_DESC","Saisissez votre mise en garde qui sera affich&eacute;e avec l'option s&eacute;lectionn&eacute;e pr&eacute;cit&eacute;e.");
define("_MI_DISCLAIMER_TEXT", "Ces forums contiennent beaucoups de contribution avec de nombreuses informations. <br /><br />Afin de r&eacute;duire au maximum les sujets en doublon, nous aimerions que vous utilisiez la fonction de recherche de discussions avant de poster votre question ici.");
define("_MI_NONE","Aucun");
define("_MI_POST","Post");
define("_MI_REPLY","R&eacute;ponse");
define("_MI_OP_BOTH","Les deux");
define("_MI_WOL_ENABLE","Activer le bloc : Qui est en ligne");
define("_MI_WOL_ENABLE_DESC","Activer le bloc Qui est en ligne affich&eacute; en dessous de la page Index et de la page des forums");
define("_MI_WOL_ADMIN_COL","Couleur de surlignage des administrateurs");
define("_MI_WOL_ADMIN_COL_DESC","Couleur des administrateurs affich&eacute;e dans le bloc qui est en ligne");
define("_MI_WOL_MOD_COL","Surlignage couleur de surlignage des mod&eacute;rateurs");
define("_MI_WOL_MOD_COL_DESC","Couleur des mod&eacute;rateurs affich&eacute;e dans le bloc Qui est en ligne");
define("_MI_LEVELS_ENABLE", "Activer les modes de niveaux HP/MP/EXP");
define("_MI_LEVELS_ENABLE_DESC", "<strong>HP</strong>  est d&eacute;termin&eacute; par la moyenne des contributions par jour.<br /><strong>MP</strong>  est d&eacute;termin&eacute; par la date jointe en rapport avec le compte du post.<br /><strong>EXP</strong> Montre le temps du post, Et quand vous arrivez &agrave; 100%, vous gagnez un niveau EXP retombe &agrave; 0.");
define("_MI_NULL", "d&eacute;sactiv&eacute;");
define("_MI_TEXT", "texte");
define("_MI_GRAPHIC", "graphique");
define("_MI_USERLEVEL", "Mode niveaux HP/MP/EXP");
define("_MI_USERLEVEL_DESC", "<strong>HP</strong>  est d&eacute;termin&eacute; par votre moyenne de contribution par jour.<br /><strong>MP</strong>  est d&eacute;termin&eacute; par votre date de venu relatif &agrave; votre nombre de contribution.<br /><strong>EXP</strong> grimpa &agrave; chauqe fois que vous contribuez, &agrave; chaque fois que vous parvenez &agrave; 100%, vous gagnez un niveau et EXP redescent &agrave; 0 de nouveau.");
define("_MI_RSS_ENABLE","Activer l'alimentation RSS");
define("_MI_RSS_ENABLE_DESC","Activer l'alimentation RSS, avec en dessous le maximum d'articles et la longueur de la description");
define("_MI_RSS_MAX_ITEMS", "Articles Max.");
define("_MI_RSS_MAX_DESCRIPTION", "Longueur maximum de la description");
define("_MI_RSS_UTF8", "Encodage RSS avec UTF-8");
define("_MI_RSS_UTF8_DESCRIPTION", "'UTF-8' sera utilis&eacute; si activ&eacute; autrement'"._CHARSET."' sera utilis&eacute;.");
define("_MI_RSS_CACHETIME", "Temps de cache du filet RSS");
define("_MI_RSS_CACHETIME_DESCRIPTION", "Temps de cache pour la re-g&eacute;n&eacute;ration du filet RSS, en minutes.");

define("_MI_MEDIA_ENABLE","Activer des fonctions m&eacute;dia");
define("_MI_MEDIA_ENABLE_DESC","Afficher les images attach&eacute;es directement dans le post.");
define("_MI_USERBAR_ENABLE","Activer la barre utilisateur");
define("_MI_USERBAR_ENABLE_DESC","Afficher la barre Utilisateur &eacute;tendu : Profil, PM, ICQ, MSN, etc...");

define("_MI_GROUPBAR_ENABLE","Activer la barre de Groupe");
define("_MI_GROUPBAR_ENABLE_DESC","Autorise &agrave; voir les groupes auquels appartient l'utilisateur dans le champs information des contributions.");

define("_MI_RATING_ENABLE","Activer la fonction de comptabilisation");
define("_MI_RATING_ENABLE_DESC","Activer la comptabilisation par sujet");

define("_MI_VIEWMODE","Mode de visualisation des discussions");
define("_MI_VIEWMODE_DESC","Pour outrepasser les param&egrave;tres g&eacute;n&eacute;raux des modes de visualisation choisissez parmi les choix : A Plat, par Discussion ou Aucun pour ne pas outrepasser");
define("_MI_COMPACT","Compacte");

define("_MI_MENUMODE","Mode de menu par d&eacute;faut");
define("_MI_MENUMODE_DESC","'SELECTION' - s&eacute;lectionnez les options, 'HOVER' - peut parasiter IE, 'CLICK' - requiert JAVASCRIPT");

define("_MI_REPORTMOD_ENABLE","Rapporter les contributions aux mod&eacute;rateurs");
define("_MI_REPORTMOD_ENABLE_DESC","Les utilisateurs peuvent rapporter les contributions aux mod&eacute;rateurs en vue d'une action"); 
define("_MI_SHOW_JUMPBOX", "Afficher la boite de saut");
define("_MI_JUMPBOXDESC", "Si actif, un menu d&eacute;roulant autorisera les utilisateurs &agrave; sauter d'un sujet ou d'un forum vers un autre forum");

define("_MI_SHOW_PERMISSIONTABLE", "Afficher la table des permissions");
define("_MI_SHOW_PERMISSIONTABLE_DESC", "Param&egrave;tr&eacute; &agrave; OUI affichera ses droits à l'utilisateur");

define("_MI_EMAIL_DIGEST", "Email des publications en sommaire");
define("_MI_EMAIL_DIGEST_DESC", "Param&eacute;trer la p&eacute;riode horaire pour envoyer les contributions en sommaire aux utilisateurs");
define("_MI_NEWBB_EMAIL_NONE", "Pas d'email");
define("_MI_NEWBB_EMAIL_DAILY", "Journalier");
define("_MI_NEWBB_EMAIL_WEEKLY", "Hebdomadaire");

define("_MI_SHOW_IP", "Afficher les adresses IP des Utilisateurs");
define("_MI_SHOW_IP_DESC", "Activ&eacute;e, cette option affiche les adresses IP des utilisateurs aux mod&eacute;rateurs");

define("_MI_ENABLE_KARMA", "Activer les pr&eacute;requis de Karma");
define("_MI_ENABLE_KARMA_DESC", "Ceci permet aux utilisateurs de param&egrave;trer un pr&eacute;requis n&eacute;c&eacute;ssaire &agrave; la lecture de leurs contributions");

define("_MI_KARMA_OPTIONS", "Options de Karma pour la contribution");
define("_MI_KARMA_OPTIONS_DESC", "Utilisez ',' pour d&eacute;limiter les options multiples. Laisser blanc pour ne pas activer cette option");

define("_MI_SINCE_OPTIONS", "Dur&eacute;es associ&eacute;es à 'depuis' option pour le S&eacute;lecteur d'affichage 'visualisation des formulaire' et la fonction 'Recherche'");
define("_MI_SINCE_OPTIONS_DESC", "Valeur positive pour les jours et n&eacute;gative pour les heures. Utilisez ',' comme d&eacute;limitateur d'options multiples.");

define("_MI_SINCE_DEFAULT", "Valeur par d&eacute;faut du 'Depuis...' utilis&eacute; pour le S&eacute;lecteur d'affichage et la fonction Recherche ");
define("_MI_SINCE_DEFAULT_DESC", "Valeur par d&eacute;faut si non sp&eacute;cifi&eacute;e par les utilisateurs.");

define("_MI_MODERATOR_HTML", "Autoriser les tags HTML pour les mod&eacute;rateurs");
define("_MI_MODERATOR_HTML_DESC", "Cette option autorise les mod&eacute;rateurs &agrave; utiliser le HTML dans le sujet des contributions");

define("_MI_USER_ANONYMOUS", "Autoriser les utilisateurs &agrave; contribuer en anonyme");
define("_MI_USER_ANONYMOUS_DESC", "Cette option autorise les utilisateurs identifi&eacute;s &agrave; contribuer anonymement");

define("_MI_ANONYMOUS_PRE", "Pr&eacute;fixe pour les utilisateurs anonymes");
define("_MI_ANONYMOUS_PRE_DESC", "Ceci ajoute un préfixe au nom d'utilisateur anonyme");

define("_MI_REQUIRE_REPLY", "Autoriser le pr&eacute;requis de r&eacute;ponse afin de lire une contribution");
define("_MI_REQUIRE_REPLY_DESC", "Ceci autorise aux utilisateurs &agrave; demander une r&eacute;ponse aux lecteurs avant qu'il puissent lire leurs contributions");

define("_MI_EDIT_TIMELIMIT", "D&eacute;lai pour &eacute;diter une contribution");
define("_MI_EDIT_TIMELIMIT_DESC", "Param&egrave;tres de d&eacute;lai, pendant lequel la contribution est &eacute;ditable. En minutes");

define("_MI_DELETE_TIMELIMIT", "Limitation du temps &agrave; l'effacement d'une contribution");
define("_MI_DELETE_TIMELIMIT_DESC", "Param&egrave;trage d'une limitation de temps, pendant lequel la contribution peut &ecirc;tre effac&eacute;e. en Minutes");

define("_MI_POST_TIMELIMIT", "Limite de temps pour une contribution cons&eacute;cutive");
define("_MI_POST_TIMELIMIT_DESC", "Param&egrave;trer une limite de temps pour pouvoir poster cons&eacute;cutivement. En Seconde, 0 pour ne pas mettre de limite");

define("_MI_RECORDEDIT_TIMELIMIT", "Limite de temps pour enregistrer une info &eacute;dit&eacute;e");
define("_MI_RECORDEDIT_TIMELIMIT_DESC", "Param&agrave;tre un temps limit&eacute; pour enregistrer une info &eacute;dit&eacute;e. En Secondes");

define("_MI_SUBJECT_PREFIX", "Ajouter un pr&eacute;fixe pour l'article du sujet. Attention se param&egrave;tre aussi dans les options de chaque forum");
define("_MI_SUBJECT_PREFIX_DESC", "Param&egrave;tre un pr&eacute;fixe i.e. [résolu] au d&agrave;but du sujet. Utilisez ',' comme d&agrave;limiteur pour des options multiples, laissez à NONE pour ne pas utiliser de préfixe.");
define("_MI_SUBJECT_PREFIX_DEFAULT", '<font color="#00CC00">[r&eacute;solu]</font>,<font color="#00CC00">[fix&eacute;]</font>,<font color="#FF0000">[requ&ecirc;te]</font>,<font color="#FF0000">[rapport bug]</font>,<font color="#FF0000">[non r&eacute;solu]</font>');

define("_MI_SUBJECT_PREFIX_LEVEL", "Niveau pour les groupes qui peuvent utiliser les pr&eacute;fixes");
define("_MI_SUBJECT_PREFIX_LEVEL_DESC", "Choisissez les groupes autoris&eacute;s &agrave; utiliser les pr&eacute;fixes.");
define("_MI_SPL_DISABLE", "D&agrave;sactiv&agrave;");
define("_MI_SPL_ANYONE", 'Tous');
define("_MI_SPL_MEMBER", 'Membres');
define("_MI_SPL_MODERATOR", 'Mod&eacute;rateurs');
define("_MI_SPL_ADMIN", 'Administrateurs');

define("_MI_SHOW_REALNAME", "Afficher le nom r&eacute;el");
define("_MI_SHOW_REALNAME_DESC", "Remplace les noms d'utilisateurs par leur nom r&eacute;el.");

define("_MI_CACHE_ENABLE", "Activer le cache");
define("_MI_CACHE_ENABLE_DESC", "Stocke quelques r&eacute;sultats interm&eacute;diaires de la session pour assister les requ&ecirc;tes");

define("_MI_QUICKREPLY_ENABLE", "Activer la r&eacute;ponse rapide");
define("_MI_QUICKREPLY_ENABLE_DESC", "Ceci activera le formulaire de r&eacute;ponse rapide");

define("_MI_POSTSPERPAGE","Contributions par page");
define("_MI_POSTSPERPAGE_DESC","Le nombre maximum de contributions qui seront vues par page");

define("_MI_POSTSFORTHREAD","Nombre de contributions maximum pour le mode de visualisation par sujet");
define("_MI_POSTSFORTHREAD_DESC","Le mode &agrave; plat devra &ecirc;tre utilis&eacute; si le nombre de contribution exc&egrave;de ce nombre");

define("_MI_TOPICSPERPAGE","Sujets par page");
define("_MI_TOPICSPERPAGE_DESC","Le nombre maximum de sujets qui seront vus par page");

define("_MI_IMG_TYPE","Type d'image");
define("_MI_IMG_TYPE_DESC","S&eacute;lectionnez le type d'image &agrave; utiliser");

define("_MI_PNGFORIE_ENABLE","Activer le hack Png");
define("_MI_PNGFORIE_ENABLE_DESC","Le hack alloue l'attribut de transparence Png avec IE");

define("_MI_FORM_OPTIONS","Options de formulaire");
define("_MI_FORM_OPTIONS_DESC","Options de formulaire que les utilisateurs peuvent choisir quand ils postent/&eacute;ditent/r&eacute;pondent.");
define("_MI_FORM_COMPACT","Compact");
define("_MI_FORM_DHTML","DHTML");
define("_MI_FORM_SPAW","Editeur Spaw");
define("_MI_FORM_HTMLAREA","Editeur HtmlArea");
define("_MI_FORM_FCK","Editeur FCK");
define("_MI_FORM_KOIVI","Editeur Koivi");
define("_MI_FORM_TINYMCE","Editeur TinyMCE");

define("_MI_MAGICK","Image Magick");
define("_MI_NETPBM","Netpbm");
define("_MI_GD1","Librarie GD1");
define("_MI_GD2","Librarie GD2");
define("_MI_AUTO","AUTO");

define("_MI_WELCOMEFORUM","Forum de bienvenue pour les nouveaux utilisateurs");
define("_MI_WELCOMEFORUM_DESC","Un profil de contribution sera publi&eacute; quand un utilisateur visitera le module de forum pour la premi&egrave;re fois");


// RMV-NOTIFY
// Notification event descriptions and mail templates

define ("_MI_NEWBB_THREAD_NOTIFY", "Discussion");
define ("_MI_NEWBB_THREAD_NOTIFYDSC", "Options de notification s'appliquant &agrave; la discussion actuelle.");

define ("_MI_NEWBB_FORUM_NOTIFY", "Forum");
define ("_MI_NEWBB_FORUM_NOTIFYDSC", "Options de la notification qui s'appliquent au forum courant.");

define ("_MI_NEWBB_GLOBAL_NOTIFY", "Globale");
define ("_MI_NEWBB_GLOBAL_NOTIFYDSC", "Options de notification globale des forums.");

define ("_MI_NEWBB_THREAD_NEWPOST_NOTIFY", "Nouvel envoi");
define ("_MI_NEWBB_THREAD_NEWPOST_NOTIFYCAP", "Notifiez-moi des nouveaux envois dans la discussion actuelle.");
define ("_MI_NEWBB_THREAD_NEWPOST_NOTIFYDSC", "Recevoir une notification lorsqu'un nouveau message est post&eacute; dans la discussion actuelle.");
define ("_MI_NEWBB_THREAD_NEWPOST_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} notification automatique : Nouvel envoi dans la discussion");

define ("_MI_NEWBB_FORUM_NEWTHREAD_NOTIFY", "Nouvelle discussion");
define ("_MI_NEWBB_FORUM_NEWTHREAD_NOTIFYCAP", "Notifiez-moi des nouveaux sujets dans le forum actuel.");
define ("_MI_NEWBB_FORUM_NEWTHREAD_NOTIFYDSC", "Recevoir une notification lorsqu'un nouveau sujet d&eacute;bute dans le forum actuel.");
define ("_MI_NEWBB_FORUM_NEWTHREAD_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} notification automatique : Nouvelle discussion dans le forum");

define ("_MI_NEWBB_GLOBAL_NEWFORUM_NOTIFY", "Nouveau forum");
define ("_MI_NEWBB_GLOBAL_NEWFORUM_NOTIFYCAP", "Notifiez-moi lorsqu'un nouveau forum est cr&eacute;&eacute;.");
define ("_MI_NEWBB_GLOBAL_NEWFORUM_NOTIFYDSC", "Recevoir une notification lorsqu'un nouveau forum est cr&eacute;&eacute;.");
define ("_MI_NEWBB_GLOBAL_NEWFORUM_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} notification automatique : Nouveau forum");

define ("_MI_NEWBB_GLOBAL_NEWPOST_NOTIFY", "Nouvel envoi");
define ("_MI_NEWBB_GLOBAL_NEWPOST_NOTIFYCAP", "Notifiez-moi de chaque nouvel envoi.");
define ("_MI_NEWBB_GLOBAL_NEWPOST_NOTIFYDSC", "Recevoir une notification quand un nouveau message est post&eacute;.");
define ("_MI_NEWBB_GLOBAL_NEWPOST_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} notification automatique : Nouvel envoi");

define ("_MI_NEWBB_FORUM_NEWPOST_NOTIFY", "Nouvel envoi");
define ("_MI_NEWBB_FORUM_NEWPOST_NOTIFYCAP", "Notifiez-moi de chaque nouvel envoi dans le forum actuel.");
define ("_MI_NEWBB_FORUM_NEWPOST_NOTIFYDSC", "Recevoir une notification quand un nouveau message est post&eacute; dans le forum actuel.");
define ("_MI_NEWBB_FORUM_NEWPOST_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : Nouvel envoi dans le forum");

define ("_MI_NEWBB_GLOBAL_NEWFULLPOST_NOTIFY", "Nouvel envoi (Texte Complet)");
define ("_MI_NEWBB_GLOBAL_NEWFULLPOST_NOTIFYCAP", "Notifiez-moi de chaque nouvel envoi (incluant le texte complet du message).");
define ("_MI_NEWBB_GLOBAL_NEWFULLPOST_NOTIFYDSC", "Recevoir une notification du texte complet quand un nouveau message est post&eacute;.");
define ("_MI_NEWBB_GLOBAL_NEWFULLPOST_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} notification automatique : Nouvel envoi (texte complet)");

define ('_MI_NEWBB_GLOBAL_DIGEST_NOTIFY', 'Sommaire');
define ('_MI_NEWBB_GLOBAL_DIGEST_NOTIFYCAP', 'Notifier le post de contribution en Sommaire.');
define ('_MI_NEWBB_GLOBAL_DIGEST_NOTIFYDSC', 'Recevoir la notification de contribution en Sommaire.');
define ('_MI_NEWBB_GLOBAL_DIGEST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} autonotification : Contributions en Sommaire');

?>