<?php
	// $Id$
	if (defined('MAIN_DEFINED')) return;
	define('MAIN_DEFINED', true);
	 
	define('_MD_ERROR', 'Fout');
	define('_MD_NOPOSTS', 'Geen boodschappen');
	define('_MD_GO', 'Verder');
	define('_MD_SELFORUM', 'Kies een forum');
	 
	define('_MD_THIS_FILE_WAS_ATTACHED_TO_THIS_POST', 'Bijgevoegd bestand:');
	define('_MD_ALLOWED_EXTENSIONS', 'Toegelaten bestandsextensies');
	define('_MD_MAX_FILESIZE', 'Maximum bestandsgrootte');
	define('_MD_ATTACHMENT', 'Bestand bijvoegen');
	define('_MD_FILESIZE', 'Grootte');
	define('_MD_HITS', 'Hits');
	define('_MD_GROUPS', 'Groepen:');
	define('_MD_DEL_ONE', 'Enkel deze boodschap verwijderen');
	define('_MD_DEL_RELATED', 'Alle boodschappen in dit onderwerp verwijderen');
	define('_MD_MARK_ALL_FORUMS', 'Markeer alle forums');
	define('_MD_MARK_ALL_TOPICS', 'Markeer alle onderwerpen');
	define('_MD_MARK_UNREAD', 'ongelezen');
	define('_MD_MARK_READ', 'gelezen');
	define('_MD_ALL_FORUM_MARKED', 'Alle forums gemarkeerd');
	define('_MD_ALL_TOPIC_MARKED', 'Alle onderwerpen gemarkeerd');
	define('_MD_BOARD_DISCLAIMER', 'Forum disclaimer');
	 
	 
	//index.php
	define('_MD_ADMINCP', 'Beheersinterface');
	define('_MD_FORUM', 'forum');
	define('_MD_WELCOME', 'Welcome in het %s Forum.');
	define('_MD_TOPICS', 'Onderwerpen');
	define('_MD_POSTS', 'Boodschappen');
	define('_MD_LASTPOST', 'Laatste boodschap');
	define('_MD_MODERATOR', 'Moderator');
	define('_MD_NEWPOSTS', 'Nieuwe boodschappen');
	define('_MD_NONEWPOSTS', 'Geen nieuwe boodschappen');
	define('_MD_PRIVATEFORUM', 'Inactief forum');
	define('_MD_BY', 'door'); // Posted by
	define('_MD_TOSTART', 'Selecteer het forum dat u wenst te bezoeken uit de onderstaande lijst om boodschappen te bekijken.');
	define('_MD_TOTALTOPICSC', 'Aantal onderwerpen:');
	define('_MD_TOTALPOSTSC', 'Aantal boodschappen:');
	define('_MD_TOTALUSER', 'Aantal gebruikers:');
	define('_MD_TIMENOW', 'Het is nu %s');
	define('_MD_LASTVISIT', 'U laatste bezoek was op %s');
	define('_MD_ADVSEARCH', 'Geavanceerd zoeken');
	define('_MD_POSTEDON', 'Geplaatst op:');
	define('_MD_SUBJECT', 'Onderwerp');
	define('_MD_INACTIVEFORUM_NEWPOSTS', 'non-actief forum met nieuwe boodschappen');
	define('_MD_INACTIVEFORUM_NONEWPOSTS', 'non-actief forum zonder nieuwe boodschappen');
	define('_MD_SUBFORUMS', 'Subforums');
	define('_MD_MAINFORUMOPT', 'Algemene opties');
	define("_MD_PENDING_POSTS_FOR_AUTH", "Goed te keuren boodschappen:");
	 
	 
	 
	//page_header.php
	define('_MD_MODERATEDBY', 'Gemodereerd door');
	define('_MD_SEARCH', 'Zoeken');
	//define('_MD_SEARCHRESULTS','Zoekresultaten');
	define('_MD_FORUMINDEX', '%s Forum Index');
	define('_MD_POSTNEW', 'Nieuw onderwerp');
	define('_MD_REGTOPOST', 'Registreer om te posten');
	 
	//search.php
	define('_MD_SEARCHALLFORUMS', 'Doorzoek alle forums');
	define('_MD_FORUMC', 'Forum');
	define('_MD_AUTHORC', 'Auteur:');
	define('_MD_SORTBY', 'Sorteer volgens');
	define('_MD_DATE', 'Datum');
	define('_MD_TOPIC', 'Onderwerp');
	define('_MD_POST2', 'Boodschap');
	define('_MD_USERNAME', 'Gebruikersnaam');
	define('_MD_BODY', 'Body');
	define('_MD_SINCE', 'Sinds');
	 
	//viewforum.php
	define('_MD_REPLIES', 'Antwoorden');
	define('_MD_POSTER', 'Plaatser');
	define('_MD_VIEWS', 'x bekeken');
	define('_MD_MORETHAN', 'Nieuwe boodschappen [ populair ]');
	define('_MD_MORETHAN2', 'Geen nieuwe boodschappen [ Populair ]');
	define('_MD_TOPICSHASATT', 'Onderwerp heeft bijlagen');
	define('_MD_TOPICHASPOLL', 'onderwerp heeft een poll');
	define('_MD_TOPICLOCKED', 'onderwerp is vergrendeld');
	define('_MD_LEGEND', 'Legende');
	define('_MD_NEXTPAGE', 'Volgende pagina');
	define('_MD_SORTEDBY', 'gesorteerd volgens');
	define('_MD_TOPICTITLE', 'onderwerp titel');
	define('_MD_NUMBERREPLIES', 'Aantal antwoorden');
	define('_MD_TOPICPOSTER', 'onderwerp plaatser');
	define('_MD_TOPICTIME', 'publicatie tijdstip');
	define('_MD_LASTPOSTTIME', 'Laatste boodschap tijdstip');
	define('_MD_ASCENDING', 'Oplopend');
	define('_MD_DESCENDING', 'Aflopend');
	define('_MD_FROMLASTHOURS', 'In de laatste %s uren');
	define('_MD_FROMLASTDAYS', 'In de laatste %s dagen');
	define('_MD_THELASTYEAR', 'In het laatste jaar');
	define('_MD_BEGINNING', 'Sinds het begin');
	define('_MD_SEARCHTHISFORUM', 'Zoek in dit forum');
	define('_MD_TOPIC_SUBJECTC', 'onderwerp prefix:');
	 
	 
	define('_MD_RATINGS', 'Beoordelingen');
	define("_MD_CAN_ACCESS", "U <strong>heeft</strong> toegang tot het forum <br />");
	define("_MD_CANNOT_ACCESS", "U <strong>heeft geen</strong> toegang tot het forum.<br />");
	define("_MD_CAN_POST", "U <strong>kan</strong> een nieuw onderwerp starten.<br />");
	define("_MD_CANNOT_POST", "U <strong>kan geen</strong> nieuw onderwerp starten.<br />");
	define("_MD_CAN_VIEW", "U <strong>can</strong> een onderwerp bekijken.<br />");
	define("_MD_CANNOT_VIEW", "U<strong>kan geen </strong> onderwerp bekijken.<br />");
	define("_MD_CAN_REPLY", "U<strong>kan</strong> boodschappen beantwoorden.<br />");
	define("_MD_CANNOT_REPLY", "U <strong>kan geen </strong> boodschappen beantwoorden.<br />");
	define("_MD_CAN_EDIT", "U<strong>kan</strong> uw eigen boodschappen bewerken.<br />");
	define("_MD_CANNOT_EDIT", "U <strong>kan niet </strong>uw eigen boodschappen bewerken.<br />");
	define("_MD_CAN_DELETE", "U<strong>kan</strong> uw eigen boodschappen verwijderen.<br />");
	define("_MD_CANNOT_DELETE", "U <strong>kan niet </strong>uw eigen boodschappen verwijderen.<br />");
	define("_MD_CAN_ADDPOLL", "U <strong>kan</strong> een poll toevoegen.<br />");
	define("_MD_CANNOT_ADDPOLL", "U <strong>kan geen</strong> poll toevoegen.<br />");
	define("_MD_CAN_VOTE", "U <strong>kan</strong> stemmen in polls.<br />");
	define("_MD_CANNOT_VOTE", "U <strong>kan niet</strong> stemmen in polls.<br />");
	define("_MD_CAN_ATTACH", "U<strong>kan</strong> bestanden toevoegen aan boodschappen.<br />");
	define("_MD_CANNOT_ATTACH", "U <strong>kan geen </strong> bestanden toevoegen aan boodschappen.<br />");
	define("_MD_CAN_NOAPPROVE", "U <strong>kan</strong> boodschappen plaatsen zonder goedkeuring.<br />");
	define("_MD_CANNOT_NOAPPROVE", "U <strong>kan geen </strong> boodschappen plaatsen zonder goedkeuring.<br />");
	define("_MD_IMTOPICS", "Belangrijke onderwerpen");
	define("_MD_NOTIMTOPICS", "forum onderwerpen");
	define('_MD_FORUMOPTION', 'Forum opties');
	 
	define('_MD_VAUP', 'Bekijk alle onbeantwoordde boodschappen');
	define('_MD_VANP', 'Bekijk alle nieuwe boodschappen');
	 
	 
	define('_MD_UNREPLIED', 'Onbeantwoordde onderwerpen ');
	define('_MD_UNREAD', 'Ongelezen onderwerpen');
	define('_MD_ALL', 'Alle onderwerpen');
	define('_MD_ALLPOSTS', 'alle boodschappen');
	define('_MD_VIEW', 'Bekijken');
	 
	//viewtopic.php
	define('_MD_AUTHOR', 'Auteur');
	define('_MD_LOCKTOPIC', 'Dit onderwerp vergrendelen');
	define('_MD_UNLOCKTOPIC', 'Dit onderwerp ontgrendelen');
	define('_MD_UNSTICKYTOPIC', 'Maak dit onderwerp niet meer Sticky');
	define('_MD_STICKYTOPIC', 'Maak dit onderwerp Sticky');
	define('_MD_DIGESTTOPIC', 'Maak dit onderwerp als Digest');
	define('_MD_UNDIGESTTOPIC', 'Maak dit onderwerp als Undigest');
	define('_MD_MERGETOPIC', 'onderwerp samenvoegen');
	define('_MD_MOVETOPIC', 'onderwerp verplaatsen');
	define('_MD_DELETETOPIC', 'onderwerp verwijderen');
	define('_MD_TOP', 'Boven');
	define('_MD_BOTTOM', 'Onder');
	define('_MD_PREVTOPIC', 'Vorig onderwerp');
	define('_MD_NEXTTOPIC', 'Volgend onderwerp');
	define('_MD_GROUP', 'Groep:');
	define('_MD_QUICKREPLY', 'Snel antwoord');
	define('_MD_POSTREPLY', 'Antwoord plaatsen');
	define('_MD_PRINTTOPICS', 'onderwerp afdrukken');
	define('_MD_PRINT', 'afdrukken');
	define('_MD_REPORT', 'Rapport');
	define('_MD_PM', 'DM');
	define('_MD_EMAIL', 'Email');
	define('_MD_WWW', 'WWW');
	define('_MD_AIM', 'AIM');
	define('_MD_YIM', 'YIM');
	define('_MD_MSNM', 'MSNM');
	define('_MD_ICQ', 'ICQ');
	define('_MD_PRINT_TOPIC_LINK', 'URL voor deze discussie');
	define('_MD_ADDTOLIST', 'Voeg toe aan uw contactenlijst');
	define('_MD_TOPICOPT', 'onderwerp opties');
	define('_MD_VIEWMODE', 'Bekijk modus');
	define('_MD_NEWEST', 'Nieuwste eerst');
	define('_MD_OLDEST', 'Oudste eerst');
	 
	define('_MD_FORUMSEARCH', 'Zoek in dit forum');
	 
	define('_MD_RATED', 'Beoordeeld:');
	define('_MD_RATE', 'Beoordeel discussie');
	define('_MD_RATEDESC', 'Beoordeel deze discussie');
	define('_MD_RATING', 'Stem nu');
	define('_MD_RATE1', 'Afgrijselijk');
	define('_MD_RATE2', 'Slecht');
	define('_MD_RATE3', 'Gemiddeld');
	define('_MD_RATE4', 'Goed');
	define('_MD_RATE5', 'Uitstekend');
	 
	define('_MD_TOPICOPTION', 'onderwerp opties');
	define('_MD_KARMA_REQUIREMENT', 'Uw persoonlijke karma %s is lager dan het vereiste karma %s. <br /> Probeer later opnieuw.');
	define('_MD_REPLY_REQUIREMENT', 'Om deze boodschap te zien, moet u ingelogd zijn en geantwoord hebben');
	define('_MD_TOPICOPTIONADMIN', 'onderwerp beheersopties');
	define('_MD_POLLOPTIONADMIN', 'Poll beheersopties');
	 
	define('_MD_EDITPOLL', 'Deze poll bewerken');
	define('_MD_DELETEPOLL', 'Deze poll verwijderen');
	define('_MD_RESTARTPOLL', 'Deze poll herstarten');
	define('_MD_ADDPOLL', 'Poll toevoegen');
	 
	define('_MD_QUICKREPLY_EMPTY', 'Plaats hier uw snel antwoord');
	 
	define('_MD_LEVEL', 'Niveau : ');
	define('_MD_HP', 'HP : ');
	define('_MD_MP', 'MP : ');
	define('_MD_EXP', 'EXP :');
	 
	define('_MD_BROWSING', 'Bekijken deze discussie:');
	define('_MD_POSTTONEWS', 'Plaats deze boodschap als nieuwsitem');
	 
	define('_MD_EXCEEDTHREADVIEW', 'Het aantal boodschappen overstijgt het maximum voor discussie modus<br />overschakelen naar platte modus');
	 
	 
	//forumform.inc
	define('_MD_PRIVATE', 'Dit is een <strong>Privé </strong> forum.<br />Enkel gebruikers met speciale toegang kunnen nieuwe onderwerpen en antwoorden plaatsen in dit forum.');
	define('_MD_QUOTE', 'Citaat');
	define('_MD_VIEW_REQUIRE', 'Bekijk vereisten');
	define('_MD_REQUIRE_KARMA', 'Karma');
	define('_MD_REQUIRE_REPLY', 'Beantwoorden');
	define('_MD_REQUIRE_NULL', 'Geen vereiste');
	 
	define("_MD_SELECT_FORMTYPE", "Kies uw gewenste formulier type");
	 
	define("_MD_FORM_COMPACT", "Compact");
	define("_MD_FORM_DHTML", "DHTML");
	define("_MD_FORM_SPAW", "Spaw Editor");
	define("_MD_FORM_HTMLAREA", "HTMLArea");
	define("_MD_FORM_FCK", "FCK Editor");
	define("_MD_FORM_KOIVI", "Koivi Editor");
	define("_MD_FORM_TINYMCE", "TinyMCE Editor");
	 
	// ERROR messages
	define('_MD_ERRORFORUM', 'FOUT: geen forum geselecteerd');
	define('_MD_ERRORPOST', 'FOUT: geen boodschap geselecteerd');
	define('_MD_NORIGHTTOVIEW', 'U beschikt niet over de nodige rechten om dit onderwerp te bekijken');
	define('_MD_NORIGHTTOPOST', 'U beschikt niet over de nodige rechten om boodschappen te plaatsen in dit forum.');
	define('_MD_NORIGHTTOEDIT', 'U beschikt niet over de nodige rechten om boodschappen te bewerken in dit forum');
	define('_MD_NORIGHTTOREPLY', 'U beschikt niet over de nodige rechten om boodschappen te beantwoorden in dit forum.');
	define('_MD_NORIGHTTOACCESS', 'U beschikt niet over de nodige rechten om toegang te krijgen tot dit forum.');
	define('_MD_ERRORTOPIC', 'FOUT: geen onderwerp geselecteerd');
	define('_MD_ERRORCONNECT', 'FOUT: Kon niet verbinden met de forum databank');
	define('_MD_ERROREXIST', 'FOUT: Het forum dat u selecteerde bestaat niet. Gelieve terug te gaan en opnieuw te proberen');
	define('_MD_ERROROCCURED', 'Er heeft zich een probleem voorgedaan. Gelieve opnieuw te proberen');
	define('_MD_COULDNOTQUERY', 'FOUT : kon de forum databank niet ondervragen.');
	define('_MD_FORUMNOEXIST', 'FOUT : Het forum/onderwerp dat u heb gekozen bestaat niet. Gelieve terug te gaan en opnieuw te proberen');
	define('_MD_USERNOEXIST', 'Deze gebruiker bestaat niet. Gelieve terug te gaan en opnieuw te proberen.');
	define('_MD_COULDNOTREMOVE', 'FOUT : kon geen boodschappen verwijderen uit de databank');
	define('_MD_COULDNOTREMOVETXT', 'FOUT : kon boodschap tekst niet verwijderen!');
	define('_MD_TIMEISUP', 'U hebt de maximum tijd bereikt om uw boodschap te kunnen bewerken');
	define('_MD_TIMEISUPDEL', 'U hebt de maximumtijd bereikt om uw boodschap te kunnen verwijderen');
	 
	//reply.php
	define('_MD_ON', 'op'); //Posted on
	define('_MD_USERWROTE', '%s schreef:'); // %s is username
	define('_MD_RE', 'Antw');
	 
	//post.php
	define('_MD_EDITNOTALLOWED', 'U hebt niet de rechten om deze boodschap te bewerken!');
	define('_MD_EDITEDBY', 'Bewerkt door');
	define('_MD_ANONNOTALLOWED', 'Anonieme gebruikers mogen niet posten. <br />Gelieve u te registreren');
	define('_MD_THANKSSUBMIT', 'Bedankt voor uw bijdrage!');
	define('_MD_REPLYPOSTED', 'Er is een antwoord op uw boodschap geplaatst.');
	define('_MD_HELLO', 'Hallo %s,');
	define('_MD_URRECEIVING', 'U ontvangt deze email omdat een boodschap die u geplaatst had op de %s forums werd beantwoord.'); // %s is your site name
	define('_MD_CLICKBELOW', 'Klik op de link hieronder om de discussie te bekijken:');
	define('_MD_WAITFORAPPROVAL', 'Dank u. Uw post zal worden bekeken voor publicatie');
	define('_MD_POSTING_LIMITED', 'Waarom neem je niet even pauze, kom maar terug over %d seconden');
	 
	//forumform.inc
	define('_MD_NAMEMAIL', 'Naam/email:');
	define('_MD_LOGOUT', 'Uitloggen');
	define('_MD_REGISTER', 'Aanmelden');
	define('_MD_SUBJECTC', 'Onderwerp:');
	define('_MD_MESSAGEICON', 'Boodschap icoon:');
	define('_MD_MESSAGEC', 'Boodschap');
	define('_MD_ALLOWEDHTML', 'HTML Toegestaan:');
	define('_MD_OPTIONS', 'Opties:');
	define('_MD_POSTANONLY', 'Anoniem plaatsen');
	define('_MD_DOSMILEY', 'Smileys activeren');
	define('_MD_DOXCODE', 'BB code activeren');
	define('_MD_DOBR', 'Lijn afbreken activeren (zet dit af in HTML modus)');
	define('_MD_DOHTML', 'HTML tags activeren');
	define('_MD_NEWPOSTNOTIFY', 'Verwittig me bij nieuwe boodschappen in deze discussie');
	define('_MD_ATTACHSIG', 'Handtekening bijvoegen');
	define('_MD_POST', 'Boodschap');
	define('_MD_SUBMIT', 'Verzenden');
	define('_MD_CANCELPOST', 'Boodschap annuleren');
	define('_MD_REMOVE', 'Verwijderen');
	define('_MD_UPLOAD', 'Opladen');
	 
	// forumuserpost.php
	define('_MD_ADD', 'Toevoegen');
	define('_MD_REPLY', 'Beantwoorden');
	define('_MD_EXTRAS', 'Extra\'s');
	 
	// topicmanager.php
	define('_MD_VIEWTHETOPIC', 'Bekijk het onderwerp');
	define('_MD_RETURNTOTHEFORUM', 'Terug naar het forum');
	define('_MD_RETURNFORUMINDEX', 'Terug naar het forum overzicht');
	define('_MD_ERROR_BACK', 'Fout - Gelieve terug te gaan en opnieuw te proberen.');
	define('_MD_GOTONEWFORUM', 'Bekijk het aangepaste onderwerp');
	 
	define('_MD_TOPICDELETE', 'Het onderwerp werd verwijderd');
	define('_MD_TOPICMERGE', 'Het onderwerp werd samengevoegd');
	define('_MD_TOPICMOVE', 'Het onderwerp werd verplaatst');
	define('_MD_TOPICLOCK', 'Het onderwerp werd vergrendeld');
	define('_MD_TOPICUNLOCK', 'Het onderwerp werd ontgrendeld');
	define('_MD_TOPICSTICKY', 'Het onderwerp werd \'sticky\' gemaakt');
	define('_MD_TOPICUNSTICKY', 'Het onderwerp is niet langer \'sticky\'');
	define('_MD_TOPICDIGEST', 'Het onderwerp werd in het overzicht geplaatst');
	define('_MD_TOPICUNDIGEST', 'Het onderwerp is niet langer in het overzicht');
	 
	define('_MD_DELETE', 'Verwijderen');
	define('_MD_MOVE', 'Verplaatsen');
	define('_MD_MERGE', 'Samenvoegen');
	define('_MD_LOCK', 'Vergrendelen');
	define('_MD_UNLOCK', 'Ontgrendelen');
	define('_MD_STICKY', 'Sticky');
	define('_MD_UNSTICKY', 'niet meer sticky');
	define('_MD_DIGEST', 'Samenvatting');
	define('_MD_UNDIGEST', 'niet meer samenvatting');
	 
	define('_MD_DESC_DELETE', 'Bij het klikken op de knop onderaan dit formulier zal het geselecteerde onderwerp, samen met alle daaraan verbonden boodschappen, <strong>definitief</strong> worden verwijderd.');
	define('_MD_DESC_MOVE', 'Bij het klikken op de knop onderaan dit formulier zal het geselecteerde onderwerp, samen met alle daaraan verbonden boodschappen, worden verplaatst naar het forum dat u hebt geselecteerd');
	define('_MD_DESC_MERGE', 'Bij het klikken op de \'samenvoeg\' knop onderaan dit formulier zal het geselecteerde onderwerp, samen met alle daaraan verbonden boodschappen, worden samengevoegd met het onderwerp dat u hebt geselecteerd<br /><strong>Het topic ID van de bestemming moet kleiner zijn dat het huidige Topic ID</strong>.');
	define('_MD_DESC_LOCK', 'Bij het klikken op de knop onderaan dit formulier zal het geselecteerde onderwerp, samen met alle daaraan verbonden boodschappen, worden vergrendeld. Het kan later opnieuw ontgrendeld worden wanneer gewenst.');
	define('_MD_DESC_UNLOCK', 'Bij het klikken op de knop onderaan dit formulier zal het geselecteerde onderwerp, samen met alle daaraan verbonden boodschappen, worden ontgrendeld. Het kan later opnieuw vergrendeld worden wanneer gewenst.');
	define('_MD_DESC_STICKY', 'Bij het klikken op de knop onderaan dit formulier zal het geselecteerde onderwerp, samen met alle daaraan verbonden boodschappen, sticky worden gemaakt. Het kan later opnieuw niet Sticky worden wanneer gewenst.');
	define('_MD_DESC_UNSTICKY', 'Bij het klikken op de knop onderaan dit formulier zal het geselecteerde onderwerp, samen met alle daaraan verbonden boodschappen, niet meer sticky zijn. Het kan later opnieuw Sticky worden wanneer gewenst.');
	define('_MD_DESC_DIGEST', 'Bij het klikken op de \'samenvatting\' knop onderaan dit formulier zal het geselecteerde onderwerp, samen met alle daaraan verbonden boodschappen, in de samenvatting worden toegevoegd. Het kan later opnieuw uit de samenvatting worden verwijderd wanneer gewenst.');
	define('_MD_DESC_UNDIGEST', 'Bij het klikken op de \'samenvatting\' knop onderaan dit formulier zal het geselecteerde onderwerp, samen met alle daaraan verbonden boodschappen, uit de samenvatting worden verwijderd. Het kan later opnieuw aan de samenvatting worden toegevoegd wanneer gewenst.');
	 
	define('_MD_MERGETOPICTO', 'Onderwerp samenvoegen met:');
	define('_MD_MOVETOPICTO', 'Onderwerp verplaatsen naar:');
	define('_MD_NOFORUMINDB', 'Geen forums in de databank');
	 
	// delete.php
	define('_MD_DELNOTALLOWED', 'Sorry, u hebt de rechten niet om deze boodschap te verwijderen');
	define('_MD_AREUSUREDEL', 'Bent u zeker dat u deze boodschap en al zijn kinderen wil verwijderen?');
	define('_MD_POSTSDELETED', 'Geselecteerde boodschap en alle onderliggende boodschappen verwijderd');
	define('_MD_POSTDELETED', 'Geselecteerde boodschap verwijderd');
	 
	// definitions moved from global.
	define('_MD_THREAD', 'Discussie');
	define('_MD_FROM', 'Van');
	define('_MD_JOINED', 'Lid sinds');
	define('_MD_ONLINE', 'Online');
	define('_MD_OFFLINE', 'Offline');
	define('_MD_FLAT', 'Vlak');
	 
	 
	// online.php
	define('_MD_USERS_ONLINE', 'Gebruikers online:');
	define('_MD_ANONYMOUS_USERS', 'Anonieme gebruikers');
	define('_MD_REGISTERED_USERS', 'Geregistreerde gebruikers');
	define('_MD_BROWSING_FORUM', 'Gebruikers op dit moment in dit forum');
	define('_MD_TOTAL_ONLINE', '%dgebruikers totaal online');
	define('_MD_ADMINISTRATOR', 'Beheerder');
	 
	define('_MD_NO_SUCH_FILE', 'Bestand bestaat niet!');
	define('_MD_ERROR_UPATEATTACHMENT', 'Fout bij het bijwerken van de bijlage');
	 
	// ratethread.php
	define("_MD_CANTVOTEOWN", "U kan niet stemmen op dit onderwerp <br />Alle stemmen worden gelogd en geverifiëerd");
	define("_MD_VOTEONCE", "Gelieve niet meerdere malen op hetzelfde onderwerp te stemmen");
	define("_MD_VOTEAPPRE", "Bedankt voor uw stem.");
	define("_MD_THANKYOU", "Dank u om de tijd te nemen om hier te stemmen: %s"); // %s is your site name
	define("_MD_VOTES", "Stemmen");
	define("_MD_NOVOTERATE", "U hebt niet op dit onderwerp gestemd");
	 
	 
	// polls.php
	define("_MD_POLL_DBUPDATED", "Databank met succes geupdate");
	define("_MD_POLL_POLLCONF", "Configuratie bevragingen");
	define("_MD_POLL_POLLSLIST", "Lijst bevragingen");
	define("_MD_POLL_AUTHOR", "Auteur van deze bevraging");
	define("_MD_POLL_DISPLAYBLOCK", "Tonen in blok?");
	define("_MD_POLL_POLLQUESTION", "Vraag");
	define("_MD_POLL_VOTERS", "Aantal stemmers");
	define("_MD_POLL_VOTES", "aantal stemmen");
	define("_MD_POLL_EXPIRATION", "Verloopdatum");
	define("_MD_POLL_EXPIRED", "Verlopen");
	define("_MD_POLL_VIEWLOG", "Bekijk log");
	define("_MD_POLL_CREATNEWPOLL", "Maak nieuwe bevraging");
	define("_MD_POLL_POLLDESC", "Bevraging beschrijving");
	define("_MD_POLL_DISPLAYORDER", "Weergave volgorde");
	define("_MD_POLL_ALLOWMULTI", "Meerdere selecties toestaan?");
	define("_MD_POLL_NOTIFY", "Verwittig de bevraging auteur wanneer verlopen?");
	define("_MD_POLL_POLLOPTIONS", "Opties");
	define("_MD_POLL_EDITPOLL", "Bevraging bewerken");
	define("_MD_POLL_FORMAT", "Formaat: dd-mm-yyyy HH:mm:ss");
	define("_MD_POLL_CURRENTTIME", "De tijd is %s");
	define("_MD_POLL_EXPIREDAT", "Verlopen op %s");
	define("_MD_POLL_RESTART", "Deze bevraging herstarten");
	define("_MD_POLL_ADDMORE", "Meer opties toevoegen");
	define("_MD_POLL_RUSUREDEL", "Wil je deze bevraging en al zijn commentaren echt verwijderen?");
	define("_MD_POLL_RESTARTPOLL", "Bevraging herstarten");
	define("_MD_POLL_RESET", "Alle logs resetten voor deze bevraging?");
	define("_MD_POLL_ADDPOLL", "Poll toevoegen");
	define("_MD_POLLMODULE_ERROR", "De 'poll' module is niet beschikbaar");
	 
	//report.php
	define("_MD_REPORTED", "Bedankt om deze boodschap/discussie te melden! Een moderator zal dit binnenkort bekijken.");
	define("_MD_REPORT_ERROR", "Fout tijdens het versturen van het rapport");
	define("_MD_REPORT_TEXT", "Boodschap melden");
	 
	define("_MD_PDF", "PDF maken van boodschap");
	define("_MD_PDF_PAGE", "Pagina %s");
	 
	//print.php
	define("_MD_COMEFROM", "Deze boodschap kwam van :");
	 
	//viewpost.php
	define("_MD_VIEWALLPOSTS", "Alle boodschappen");
	define("_MD_VIEWTOPIC", "Onderwerp");
	define("_MD_VIEWFORUM", "Forum");
	 
	define("_MD_COMPACT", "Compact");
	 
	define("_MD_WELCOME_SUBJECT", "%s is erbij gekomen op het forum");
	define("_MD_WELCOME_MESSAGE", "Hallo, %s is erbij gekomen. Laat ons beginnen ...");
	 
	define("_MD_VIEWNEWPOSTS", "Bekijk nieuwe boodschappen");
	 
	define("_MD_INVALID_SUBMIT", "Ongeldige invoer. U kan de sessietijd overschreden hebben. Gelieve opnieuw op te sturen of een kopie te maken van uw boodschap, opnieuw in te loggen en opnieuw te versturen wanneer nodig.");
	 
	define("_MD_ACCOUNT", "Account");
	define("_MD_NAME", "Naam");
	define("_MD_PASSWORD", "Paswoord");
	define("_MD_LOGIN", "Login");
	 
	define("_MD_TRANSFER", "Doorverwijzen");
	define("_MD_TRANSFER_DESC", "Deel de boodschap met andere applicaties");
	define("_MD_TRANSFER_DONE", "De actie was succesvol : %s");
	 
	define("_MD_APPROVE", "Goedkeuren");
	define("_MD_RESTORE", "Terugplaatsen");
	define("_MD_SPLIT_ONE", "Opsplitsen");
	define("_MD_SPLIT_TREE", "Alle kinderen opsplitsen");
	define("_MD_SPLIT_ALL", "Alles opsplitsen");
	 
	define("_MD_TYPE_ADMIN", "Beheerder");
	define("_MD_TYPE_VIEW", "Bekijken");
	define("_MD_TYPE_PENDING", "In wacht");
	define("_MD_TYPE_DELETED", "Verwijderd");
	define("_MD_TYPE_SUSPEND", "Blokkeren");
	 
	define("_MD_DBUPDATED", "Databank met succes geupdate");
	 
	define("_MD_SUSPEND_SUBJECT", "De gebruiker %s is geblokkeerd voor %d dagen");
	define("_MD_SUSPEND_TEXT", "Gebruiker %s is geschorst voor %d dagen wegens <br />[quote]%s[/quote]<br /><br />De schorsing is geldig tot %s");
	define("_MD_SUSPEND_UID", "Gebruikers ID");
	define("_MD_SUSPEND_IP", "IP segmenten (volledig of segmenten)");
	define("_MD_SUSPEND_DURATION", "Blokkeringsduur (dagen)");
	define("_MD_SUSPEND_DESC", "Reden van de blokkering");
	define("_MD_SUSPEND_LIST", "Blokkering lijst");
	define("_MD_SUSPEND_START", "Start");
	define("_MD_SUSPEND_EXPIRE", "Einde");
	define("_MD_SUSPEND_SCOPE", "Omvang");
	define("_MD_SUSPEND_MANAGEMENT", "Moderatie beheer");
	define("_MD_SUSPEND_NOACCESS", "Uw ID of IP adres werd tijdelijk geblokkeerd");
	 
	// !!IMPORTANT!! insert '\' before any char among reserved chars: "a", "A","B","c","d","D","F","g","G","h","H","i","I","j","l","L","m","M","n","O","r","s","S","t","T","U","w","W","Y","y","z","Z"
	// insert double '\' before 't', 'r', 'n'
	define("_MD_TODAY", "\T\o\d\a\y G:i:s");
	define("_MD_YESTERDAY", "\Y\e\s\\t\e\\r\d\a\y G:i:s");
	define("_MD_MONTHDAY", "n/j G:i:s");
	define("_MD_YEARMONTHDAY", "Y/n/j G:i");
	 
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
	define('_PDF_SUBJECT', 'Onderwerp');
	define('_PDF_TOPIC', 'Onderwerp');
	define('_PDF_DATE', 'Datum');
	define('_MD_UP', 'Boven');
	define('_MD_POSTTIME', 'Datum');
	define('_MD_RIGHT', 'Rechts');
	define('_MD_LEFT', 'Links');

	//new since 1.00
	define('_MD_CHANGE_THE_FORUM', 'Forum wijzigen');
	define('_MD_USERSTAT', 'Gebruikersstatistieken forum');
	define('_MD_LEVEL_MOD_LEVEL', 'Activiteitsniveau : dit niveau wordt bepaald door het aantal van uw eigen boodschappen.');
	define("_MD_LEVEL_MOD_EXP", "Ervaring : Dit geeft aan hoe ver u nog verwijderd bent van het volgende ervaringsniveau. Van zodra de waarde 100% bereikt, zal de volgende boodschap u naar het volgende niveau brengen.");
	define("_MD_LEVEL_MOD_HP", "Activiteit: Deze grafiek gaat op en neer op basis van uw activiteit binnen de gemeenschap. Vereenvoudigd wordt de activiteit van elke gebruiker bekeken in verhouding met een aantal boodschappen per dag");
	define("_MD_LEVEL_MOD_MP", "Antwoord-wacht-tijd: deze grafiek toont vanaf uw eerste aanmelding hoe snel u antwoord op boodschappen. Een hoge waarde geeft aan dat u zelden of heel, heel traag antwoord op boodschappen [stout, stout]");
?>