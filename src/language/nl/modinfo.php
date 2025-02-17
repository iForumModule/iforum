<?php
	// $Id$
	// Thanks Tom (http://www.wf-projects.com), for correcting the Engligh language package

	// Module Info

	// The name of this module
	define("_MI_IFORUM_NAME", "iForum");

	// A brief description of this module
	define("_MI_IFORUM_DESC", "Community Bulletin Board");

	// Names of blocks for this module (Not all module has blocks)
	define("_MI_IFORUM_BLOCK_TOPIC_POST", "Recent Replied Topics");
	define("_MI_IFORUM_BLOCK_TOPIC", "Recent Topics");
	define("_MI_IFORUM_BLOCK_POST", "Recent Posts");
	define("_MI_IFORUM_BLOCK_AUTHOR", "Authors");
	define("_MI_IFORUM_BLOCK_TAG_CLOUD", "Tag Cloud");
	define("_MI_IFORUM_BLOCK_TAG_TOP", "Top Tags");
	/*
	define("_MI_IFORUM_BNAME2","Most Viewed Topics");
	define("_MI_IFORUM_BNAME3","Most Active Topics");
	define("_MI_IFORUM_BNAME4","Newest Digest");
	define("_MI_IFORUM_BNAME5","Newest Sticky Topics");
	define("_MI_IFORUM_BNAME6","Newest Posts");
	define("_MI_IFORUM_BNAME7","Authors with most topics");
	define("_MI_IFORUM_BNAME8","Authors with most posts");
	define("_MI_IFORUM_BNAME9","Authors with most digests");
	define("_MI_IFORUM_BNAME10","Authors with most sticky topics");
	define("_MI_IFORUM_BNAME11","Recent post with text");
	*/

	// Names of admin menu items
	define("_MI_IFORUM_ADMENU_INDEX", "Index");
	define("_MI_IFORUM_ADMENU_CATEGORY", "Categories");
	define("_MI_IFORUM_ADMENU_FORUM", "Forums");
	define("_MI_IFORUM_ADMENU_PERMISSION", "Permissions");
	define("_MI_IFORUM_ADMENU_BLOCK", "Blocks");
	define("_MI_IFORUM_ADMENU_ORDER", "Order");
	define("_MI_IFORUM_ADMENU_SYNC", "Sync forums");
	define("_MI_IFORUM_ADMENU_PRUNE", "Prune");
	define("_MI_IFORUM_ADMENU_REPORT", "Reports");
	define("_MI_IFORUM_ADMENU_DIGEST", "Digest");
	define("_MI_IFORUM_ADMENU_VOTE", "Votes");



	//config options

	define("_MI_DO_DEBUG", "Debug modus");
	define("_MI_DO_DEBUG_DESC", "Foutboodschap tonen");

	define("_MI_IMG_SET", "Afbeelding set");
	define("_MI_IMG_SET_DESC", "Selecteer welk afbeelding set om te gebruiken");

	define("_MI_THEMESET", "Thema set");
	define("_MI_THEMESET_DESC", "Module-wide, select '"._NONE."' will use site-wide theme");

	define("_MI_DIR_ATTACHMENT", "Fysieke locatie voor bijlagen");
	define("_MI_DIR_ATTACHMENT_DESC", "Het fysieke pad moet gezet worden startend van de ImpressCMS hoofdfolder.
Bijvoorbeeld de bijlagen worden geplaatst in www.yoururl.com/uploads/iforum, dan is het fysieke pad '/uploads/iforum'
Het thumbnails pad wordt dan '/uploads/iforum/thumbs'
Gebruik nooit een slash '/' als afsluiter.");
	define("_MI_PATH_MAGICK", "Locatie van ImageMagick");
	define("_MI_PATH_MAGICK_DESC", "Normaal gezien is dit '/usr/bin/X11'. Laat dit leef als je geen ImageMagick hebt, of als ImpressCMS dit zelf moet detecteren.");

	define("_MI_SUBFORUM_DISPLAY", "De manier waarop subforums op de startpagina worden weergegeven");
	define("_MI_SUBFORUM_DISPLAY_DESC", "");
	define("_MI_SUBFORUM_EXPAND", "Uitgeklapt");
	define("_MI_SUBFORUM_COLLAPSE", "Ingeklapt");
	define("_MI_SUBFORUM_HIDDEN", "Verborgen");

	define("_MI_POST_EXCERPT", "Boodschap uitreksel op de forum pagina");
	define("_MI_POST_EXCERPT_DESC", "Lengte van het uittreksel wanneer de muis erover hangt. 0 voor geen uittreksel");

	define("_MI_PATH_NETPBM", "Locatie van Netpbm");
	define("_MI_PATH_NETPBM_DESC", "Normaal gezien is dit '/usr/bin'. Laat dit leeg als je geen Netbmp hebt, of als ImpressCMS dit zelf moet detecteren.");

	define("_MI_IMAGELIB", "Kies welke afbeeldingsbibliotheek te gebruiken");
	define("_MI_IMAGELIB_DESC", "Kies welke afbeeldingsbibliotheek zal gebruikt worden om thumbnails te genereren. Laat dit op AUTO voor een automatische keuze");

	define("_MI_MAX_IMG_WIDTH", "Maximale breedte van de afbeelding");
	define("_MI_MAX_IMG_WIDTH_DESC", "Zet de maximaal toegelaten breedte van een opgeladen afbeelding, anders wordt de thumbnail gebruikt. <br>Gebruik 0 wanneer er geen thumbnails moeten worden aangemaakt");

	define("_MI_MAX_IMAGE_WIDTH", "Maximale breedte van een afbeelding om een thumbnail te genereren");
	define("_MI_MAX_IMAGE_WIDTH_DESC", "Zet de maximaal toegelaten breedte van een opgeladen afbeelding om een thumbnail te genereren<br>Voor afbeeldingen die breder zijn dan deze waarde zal geen thumbnail worden aangemaakt.");

	define("_MI_MAX_IMAGE_HEIGHT", "Maximale hoogte van een afbeelding om een thumbnail te genereren");
	define("_MI_MAX_IMAGE_HEIGHT_DESC", "Zet de maximaal toegelaten hoogte van een opgeladen afbeelding om een thumbnail te genereren<br>Voor afbeeldingen die hoger zijn dan deze waarde zal geen thumbnail worden aangemaakt.");

	define("_MI_SHOW_DIS", "Toon disclaimer");
	define("_MI_DISCLAIMER", "Disclaimer");
	define("_MI_DISCLAIMER_DESC", "Plaats hier de disclaimer tekst die zal getoond worden voor de hierboven geselecteerde optie.");
	define("_MI_DISCLAIMER_TEXT", "Het forum bevat heel wat boodschappen met interessante informatie <br/>Om het aantal dubbele posts tot een minimum te beperken willen we vragen om eerst te zoeken naar een antwoord vooraleer je vraag hier te stellen.");
	define("_MI_NONE", "Geen");
	define("_MI_POST", "Post");
	define("_MI_REPLY", "Antwoord");
	define("_MI_OP_BOTH", "Beide");
	define("_MI_WOL_ENABLE", "Activeer 'Wie is online'");
	define("_MI_WOL_ENABLE_DESC", "Activeer het blok dat aangeeft wie online is. Dit block wordt geplaatst onder de index en forum pagina's");
	//define("_MI_WOL_ADMIN_COL","Beheerder highlight kleur");
	//define("_MI_WOL_ADMIN_COL_DESC","De highlight kleur van de beheerders wordt getoond in het 'wie is online' blok");
	//define("_MI_WOL_MOD_COL","Moderator highlight kleur");
	//define("_MI_WOL_MOD_COL_DESC","De highlight kleur van de moderators wordt getoond in het 'wie is online' blok");
	//define("_MI_LEVELS_ENABLE", "Activeren HP/MP/EXP niveaus aanpassing");
	//define("_MI_LEVELS_ENABLE_DESC", "<strong>HP</strong>  wordt bepaald door jouw gemiddeld aantal posts per dag.<br /><strong>MP</strong>  wordt bepaald door jouw aansluit datum in relatie met jouw aantal posts.<br /><strong>EXP</strong> stijgt elke keer je iets plaatst, wanneer je 100% behaald ga je een niveau hoger en valt de EXP terug op 0.");
	define("_MI_NULL", "Deactiveren");
	define("_MI_TEXT", "tekst");
	define("_MI_GRAPHIC", "afbeelding");
	define("_MI_USERLEVEL", "HP/MP/EXP Niveau modus");
	define("_MI_USERLEVEL_DESC", "<strong>HP</strong>  is bepaald door jouw gemiddeld aantal posts per dag.<br /><strong>MP</strong> wordt bepaald door jouw eerste aanmelddatum in relatie tot jouw aantal posts..<br /><strong>EXP</strong> gaat omhoog voor elke boodschap, wanneer hij 100% bereikt verhoog je een niveau en valt de EXP terug op 0.");
	define("_MI_RSS_ENABLE", "RSS Feed activeren");
	define("_MI_RSS_ENABLE_DESC", "De RSS Feed activeren, bewerkt de opties voor maximum aantal elementen en de lengte van de beschrijvingen");
	define("_MI_RSS_MAX_ITEMS", "Maximum aantal RSS Elementen");
	define("_MI_RSS_MAX_DESCRIPTION", "Maximum lengte RSS beschrijvingen");
	define("_MI_RSS_UTF8", "Forceer de codering van RSS feeds met UTF-8");
	define("_MI_RSS_UTF8_DESCRIPTION", "'utf-8' will be used if enabled. Otherwise, the current encoding (" . _CHARSET . ") will be used.");
	define("_MI_RSS_CACHETIME", "cache tijd van de RSS Feed");
	define("_MI_RSS_CACHETIME_DESCRIPTION", "Cache tijd vooraleer er een nieuwe RSS feed wordt aangemaakt, in minuten");

	define("_MI_MEDIA_ENABLE", "Media functionaliteiten activeren");
	define("_MI_MEDIA_ENABLE_DESC", "Toon bijgevoegde afbeeldingen direct in de bijdrage");
	define("_MI_USERBAR_ENABLE", "Gebruikers-bar activeren");
	define("_MI_USERBAR_ENABLE_DESC", "Toon de uitgebreide gebruikersbar : profiel, PM, ICQ, MSN, etc...");

	define("_MI_GROUPBAR_ENABLE", "Groepsbar activeren");
	define("_MI_GROUPBAR_ENABLE_DESC", "Toont de groepen van de gebruiker in het bijdrage info veld");

	define("_MI_RATING_ENABLE", "Stem functionaliteit activeren");
	define("_MI_RATING_ENABLE_DESC", "Laat toe om een bijdrage een score te geven");

	define("_MI_VIEWMODE", "Manier om threads te visualiseren");
	define("_MI_VIEWMODE_DESC", "Om de algemene instellingen van een viewmodus binnen en discussie te overschrijven, kies 'GEEN' om deze functionaliteit uit te schakelen");
	define("_MI_COMPACT", "Compact");

	define("_MI_REPORTMOD_ENABLE", "Een post rapporteren");
	define("_MI_REPORTMOD_ENABLE_DESC", "Gebruikers kunnen posts melden aan de moderator(en), voor om het even welke reden. Dit laat de moderatoren toe om indien gewenst actie te ondernemen");
	define("_MI_SHOW_JUMPBOX", "Toon de jumpbox");
	define("_MI_JUMPBOXDESC", "Wanneer geactiveerd toont dit en drop-down menu dat gebruikers toelaat naar enander forum te springen vanuit een forum of onderwerp");

	define("_MI_SHOW_PERMISSIONTABLE", "Toon gebruikersrechten tabel");
	define("_MI_SHOW_PERMISSIONTABLE_DESC", "Ja kiezen zal de gebruiker zijn rechten tonen");

	define("_MI_EMAIL_DIGEST", "post samenvatting emailen");
	define("_MI_EMAIL_DIGEST_DESC", "Bepaal de periode om post samenvattingen te versturen naar de gebruikers");
	define("_MI_IFORUM_EMAIL_NONE", "No email");
	define("_MI_IFORUM_EMAIL_DAILY", "Daily");
	define("_MI_IFORUM_EMAIL_WEEKLY", "Weekly");

	define("_MI_SHOW_IP", "Toon IP adres van de gebruiker");
	define("_MI_SHOW_IP_DESC", "Dit toont het IP adres van de gebruiker aan moderatoren");

	define("_MI_ENABLE_KARMA", "Karma vereiste toestaan");
	define("_MI_ENABLE_KARMA_DESC", "Dit laat de gebruiker toe om een karma vereiste te bepalen voor andere gebruikers die zijn/haar posts willen lezen");

	define("_MI_KARMA_OPTIONS", "Karma opties voor de post");
	define("_MI_KARMA_OPTIONS_DESC", "Gebruik ';' om meerdere opties te onderscheiden");

	define("_MI_SINCE_OPTIONS", "'Sinds' opties voor 'viewform' en 'zoeken'");
	define("_MI_SINCE_OPTIONS_DESC", "Positieve waarden voor dagen, en negatieve waarden voor uren. Gebruik ',' om verschillende opties te onderscheiden");

	define("_MI_SINCE_DEFAULT", "'Sinds' standaardwaarde");
	define("_MI_SINCE_DEFAULT_DESC", "Standaardwaarde als er niets door de gebruikers is gedefiniërd. 0 - sinds het begin");

	define("_MI_MODERATOR_HTML", "Laat HTML tags to voor moderators");
	define("_MI_MODERATOR_HTML_DESC", "Deze optie laat enkel moderatoren toe om HTML te plaatsen in het onderwerp van een post");

	define("_MI_USER_ANONYMOUS", "Laat geregistreerde gebruikers toe om anoniem iets te plaatsen");
	define("_MI_USER_ANONYMOUS_DESC", "Dit laat een ingelogde gebruiker toe om anoniem iets te plaatsen");

	define("_MI_ANONYMOUS_PRE", "Prefix voor een anonieme gebruiker");
	define("_MI_ANONYMOUS_PRE_DESC", "Dit zal een prefix toevoegen voor een anonieme gebruikersnaam tijdens het plaatsen van een post");

	define("_MI_REQUIRE_REPLY", "Laat toe dat een antwoord verplicht is alvorens een post te kunnen lezen");
	define("_MI_REQUIRE_REPLY_DESC", "Dit laat toe dat lezers moeten antwoorden op de post van de originele plaatser vooraleer ze het origineel kunnen lezen");

	define("_MI_EDIT_TIMELIMIT", "Tijdslimiet om en post te kunnen aanpassen");
	define("_MI_EDIT_TIMELIMIT_DESC", "Plaats een tijdslimiet op gebruikers die hun post willen aanpassen. In minuten 0 voor geen enkel limiet");

	define("_MI_DELETE_TIMELIMIT", "Tijdslimiet om een post te kunnen verwijderen");
	define("_MI_DELETE_TIMELIMIT_DESC", "Plaats een tijdslimiet op gebruikers die hun post willen verwijderen. In minuten 0 voor geen enkel limiet");

	define("_MI_POST_TIMELIMIT", "Tijdslimites voor opeenvolgende posts");
	define("_MI_POST_TIMELIMIT_DESC", "Plaats een minimum tijdslimiet tussen het plaatsen van 2 posts. 0 voor geen limiet");

	define("_MI_RECORDEDIT_TIMELIMIT", "Tijdslimiet om edit informatie bij te houden");
	define("_MI_RECORDEDIT_TIMELIMIT_DESC", "Bepaal een tijdslimiet waarbinnen informatie over bewerkingen niet wordt bijgehouden. 0 voor geen limiet");

	define("_MI_SUBJECT_PREFIX", "Voeg een prefix toe aan het onderwerp");
	define("_MI_SUBJECT_PREFIX_DESC", "Voeg een prefix (bijv. [opgelost]) toe aan het begin van een onderwerp. Gebruik ',' om meerdere opties te definiëren, en laat 'NONE' staan voor geen prefix");
	define("_MI_SUBJECT_PREFIX_DEFAULT", '<span style="color: #00CC00; ">[opgelost]</span>,<span style="color: #00CC00; ">[gefixt]</span>,<span style="color: #FF0000; ">[vraag]</span>,<span style="color: #FF0000; ">[bug report]</span>,<span style="color: #FF0000; ">[niet opgelost]</span>');

	define("_MI_SUBJECT_PREFIX_LEVEL", "Minimum niveau voor groepen die de Prefix kunnen gebruiken");
	define("_MI_SUBJECT_PREFIX_LEVEL_DESC", "Kies de gebruikersgroepen die prefixes mogen gebruiken");
	define("_MI_SPL_DISABLE", 'Deactiveren');
	define("_MI_SPL_ANYONE", 'Om het even wie');
	define("_MI_SPL_MEMBER", 'Leden');
	define("_MI_SPL_MODERATOR", 'Moderatoren');
	define("_MI_SPL_ADMIN", 'Beheerders');

	define("_MI_SHOW_REALNAME", "Toon echte naam");
	define("_MI_SHOW_REALNAME_DESC", "Vervang gebruikersnaam door echte naam");

	define("_MI_CACHE_ENABLE", "Activeer caching");
	define("_MI_CACHE_ENABLE_DESC", "Sla bepaalde tussenresultaten op in de sessie om databank aanvragen te besparen");

	define("_MI_QUICKREPLY_ENABLE", "Activeer Snel antwoord");
	define("_MI_QUICKREPLY_ENABLE_DESC", "Dit zal het Snel antwoord formulier beschikbaar maken");

	define("_MI_POSTSPERPAGE", "Posts per pagina");
	define("_MI_POSTSPERPAGE_DESC", "Het maximaal aantal posts dat op en pagina zal worden getoond");

	define("_MI_POSTSFORTHREAD", "Maximum aantal posts in discussie view modus");
	define("_MI_POSTSFORTHREAD_DESC", "Vlakke modus zal gebruikt worden als het aantal posts dit aantal overschrijdt");

	define("_MI_TOPICSPERPAGE", "Onderwerpen per pagina");
	define("_MI_TOPICSPERPAGE_DESC", "Het maximaal aantal onderwerpen dat op en pagina zal worden getoond");

	define("_MI_IMG_TYPE", "Afbeelding type");
	define("_MI_IMG_TYPE_DESC", "Kies het afbeelding type van de knoppen in het forum.<br />- png: voor een snelle server;<br />- gif: voor normale snelheid;<br />- auto: gif voor Internet Explorer en png voor alle anderen");

	define("_MI_PNGFORIE_ENABLE", "Activeer 'PNG hack'");
	define("_MI_PNGFORIE_ENABLE_DESC", "Deze hack laat PNG transparantie toe binnen Internet Explorer");

	define("_MI_FORM_OPTIONS", "Formulier opties");
	define("_MI_FORM_OPTIONS_DESC", "Formulier opties die een gebruiker kan kiezen wanneer hij post/bewerkt/antwoord");
	define("_MI_FORM_COMPACT", "Compact");
	define("_MI_FORM_DHTML", "DHTML");
	define("_MI_FORM_SPAW", "Spaw Editor");
	define("_MI_FORM_HTMLAREA", "HtmlArea Editor");
	define("_MI_FORM_FCK", "FCK Editor");
	define("_MI_FORM_KOIVI", "Koivi Editor");
	define("_MI_FORM_TINYMCE", "TinyMCE Editor");

	define("_MI_MAGICK", "ImageMagick");
	define("_MI_NETPBM", "Netpbm");
	define("_MI_GD1", "GD1 functiebibliotheek");
	define("_MI_GD2", "GD2 functiebibliotheek");
	define("_MI_AUTO", "AUTO");

	define("_MI_WELCOMEFORUM", "Forum om nieuwe gebruikers te verwelkomen");
	define("_MI_WELCOMEFORUM_DESC", "Een profielpost zal worden geplaatst wanneer een gebruiker het forum voor de eerste keer bezoekt");

	define("_MI_PERMCHECK_ONDISPLAY", "Rechten nagaan");
	define("_MI_PERMCHECK_ONDISPLAY_DESC", "Controler de rechten om te bewerken op de getoonde pagina");

	define("_MI_USERMODERATE", "Laat gebruiker moderatie toe");
	define("_MI_USERMODERATE_DESC", "");


	// RMV-NOTIFY
	// Notification event descriptions and mail templates

	define ('_MI_IFORUM_THREAD_NOTIFY', 'Thread');
	define ('_MI_IFORUM_THREAD_NOTIFYDSC', 'Notification options that apply to the current thread.');

	define ('_MI_IFORUM_FORUM_NOTIFY', 'Forum');
	define ('_MI_IFORUM_FORUM_NOTIFYDSC', 'Notification options that apply to the current forum.');

	define ('_MI_IFORUM_GLOBAL_NOTIFY', 'Global');
	define ('_MI_IFORUM_GLOBAL_NOTIFYDSC', 'Global forum notification options.');

	define ('_MI_IFORUM_THREAD_NEWPOST_NOTIFY', 'New Post');
	define ('_MI_IFORUM_THREAD_NEWPOST_NOTIFYCAP', 'Notify me of new posts in the current thread.');
	define ('_MI_IFORUM_THREAD_NEWPOST_NOTIFYDSC', 'Receive notification when a new message is posted in the current thread.');
	define ('_MI_IFORUM_THREAD_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New post in thread');

	define ('_MI_IFORUM_FORUM_NEWTHREAD_NOTIFY', 'New Thread');
	define ('_MI_IFORUM_FORUM_NEWTHREAD_NOTIFYCAP', 'Notify me of new topics in the current forum.');
	define ('_MI_IFORUM_FORUM_NEWTHREAD_NOTIFYDSC', 'Receive notification when a new thread is started in the current forum.');
	define ('_MI_IFORUM_FORUM_NEWTHREAD_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New thread in forum');

	define ('_MI_IFORUM_GLOBAL_NEWFORUM_NOTIFY', 'New Forum');
	define ('_MI_IFORUM_GLOBAL_NEWFORUM_NOTIFYCAP', 'Notify me when a new forum is created.');
	define ('_MI_IFORUM_GLOBAL_NEWFORUM_NOTIFYDSC', 'Receive notification when a new forum is created.');
	define ('_MI_IFORUM_GLOBAL_NEWFORUM_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New forum');

	define ('_MI_IFORUM_GLOBAL_NEWPOST_NOTIFY', 'New Post');
	define ('_MI_IFORUM_GLOBAL_NEWPOST_NOTIFYCAP', 'Notify me of any new posts.');
	define ('_MI_IFORUM_GLOBAL_NEWPOST_NOTIFYDSC', 'Receive notification when any new message is posted.');
	define ('_MI_IFORUM_GLOBAL_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New post');

	define ('_MI_IFORUM_FORUM_NEWPOST_NOTIFY', 'New Post');
	define ('_MI_IFORUM_FORUM_NEWPOST_NOTIFYCAP', 'Notify me of any new posts in the current forum.');
	define ('_MI_IFORUM_FORUM_NEWPOST_NOTIFYDSC', 'Receive notification when any new message is posted in the current forum.');
	define ('_MI_IFORUM_FORUM_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New post in forum');

	define ('_MI_IFORUM_GLOBAL_NEWFULLPOST_NOTIFY', 'New Post (Full Text)');
	define ('_MI_IFORUM_GLOBAL_NEWFULLPOST_NOTIFYCAP', 'Notify me of any new posts (include full text in message).');
	define ('_MI_IFORUM_GLOBAL_NEWFULLPOST_NOTIFYDSC', 'Receive full text notification when any new message is posted.');
	define ('_MI_IFORUM_GLOBAL_NEWFULLPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : New post (full text)');

	define ('_MI_IFORUM_GLOBAL_DIGEST_NOTIFY', 'Digest');
	define ('_MI_IFORUM_GLOBAL_DIGEST_NOTIFYCAP', 'Notify me of post digest.');
	define ('_MI_IFORUM_GLOBAL_DIGEST_NOTIFYDSC', 'Receive digest notification.');
	define ('_MI_IFORUM_GLOBAL_DIGEST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : post digest');

	// FOR installation
	define("_MI_IFORUM_INSTALL_CAT_TITLE", "Category Test");
	define("_MI_IFORUM_INSTALL_CAT_DESC", "Category for test.");
	define("_MI_IFORUM_INSTALL_FORUM_NAME", "Forum Test");
	define("_MI_IFORUM_INSTALL_FORUM_DESC", "Forum for test.");
	define("_MI_IFORUM_INSTALL_POST_SUBJECT", "Congratulations! The forum is working.");
	define("_MI_IFORUM_INSTALL_POST_TEXT", "
		Welcome to ".(htmlspecialchars(icms::$config->getConfig('sitename'), ENT_QUOTES))." forum.
		Feel free to register and login to start your topics.

		If you have any question concerning iForum usage, plz visit your local support site or [url=http://community.impresscms.org/modules/newbb/viewforum.php?forum=9]CBB Module Site[/url].
		");
	define("_MI_CAPTCHA_ENABLE", "Activeer CAPTCHA");
	define("_MI_CAPTCHA_ENABLE_DESC", "activeer CAPTCHA voor gebruikers tijdens het plaatsen van een post");
?>
