<?php
define('_NEWBB_CONV_CHARSET','ISO-8859-1');
define('_NEWBB_CONV_TITLE','CONERTISSEUR NEWBB 2.0 XOOPS');
define('_NEWBB_CONV_INSTRUCTIONS','Instructions');
define('_NEWBB_CONV_CONFIG','Configuration');
define('_NEWBB_CONV_GEN_SQL','Génération SQL');
define('_NEWBB_CONV_EXEC_SQL','Exécution SQL');

define('_NEWBB_CONV_PROCEED','En cours');

define('_NEWBB_CONV_XOOPS_INDEX','Index XOOPS');
define('_NEWBB_CONV_XOOPS_ADMIN','Console d\'administration XOOPS');
define('_NEWBB_CONV_NEWBB_INDEX','Index NewBB 2.0');

define('_NEWBB_CONV_CFG_TITLE','Configuration de convertion');
define('_NEWBB_CONV_CFG_FORUM_TYPE','Forum source');
define('_NEWBB_CONV_CFG_DB_HOST','Host de BDD source');
define('_NEWBB_CONV_CFG_DB_USER','Utilisateur de BDD source');
define('_NEWBB_CONV_CFG_DB_PASS','Mot de passe de BDD source');
define('_NEWBB_CONV_CFG_DB_NAME','Nom de BDD source');
define('_NEWBB_CONV_CFG_DB_PREFIX','Préfixe de BDD source');
define('_NEWBB_CONV_CFG_PM','Import des messages privés');
define('_NEWBB_CONV_CFG_PM_SYSTEM','Système de messages privés');
define('_NEWBB_CONV_CFG_PM_XOOPS','MP XOOPS');

define('_NEWBB_CONV_ERR_NO_CONVERTER','<center><font color=#ff0000><strong>Erreur fatale : Ne peut trouver le convertisseur.</strong></font></center>');
define('_NEWBB_CONV_ERR_NOT_EMPTY','<center><font color=#ff0000><strong>Erreur fatale : NewBB 2.0 n\'est pas vide.</strong></font></center>');
define('_NEWBB_CONV_ERR_NOT_INSTALLED','<center><font color=#ff0000><strong>Erreur fatale : NewBB 2.0 n\'est pas installé.</strong></font></center>');
define('_NEWBB_CONV_ERR_SQL_WRITE','<center><font color=#ff0000><strong>Erreur fatale : Ne peut écrire dans ce répertoire. Veuillez CHMOD à 777 le répertoire du convertisseur.</strong></font></center>');
define('_NEWBB_CONV_SQL_EXEC','<b>%s/%s SQL requêtes éxécutées avec succès</b>');
define('_NEWBB_CONV_INSTRUCTIONS_DESC','

<font size=+1><b>Instructions de convertion</b></font>
<br /><br />
<font size=-1>
Ce script de convertion tentera de récupérer les données des autres forum php/mysql pour un environnement XOOPS 2.x / Newbb 2.0.<br /><br />
Les forums actuellement supportés sont :</font><br /><br />
<center><strong>
<li>phpBB 2.0.X</li>
<li>Invision Board 1.3.1</li>
</strong></center><br /><br />
<font size=-1 color=#ff0000><strong>Avant de procéder à la convertion, le module NewBB 2.0 doit être installé et vide i.e. aucune catégories, aucun forum, aucun post... rien!</strong></font><br/>
<br /><br />
<b><u>How It Works:</u></b><br /><font size=-1>Ce convertisseur opère en trois étapes:<br /><br />
<strong>Step 1:</strong> Propage le type et la connexion des paramètres de la base de données du forum externe.<br />
<strong>Step 2:</strong> Génère un fichier  SQL des données du forum externe prèt à être converti dans un format XOOPS 2.x .<br />
<strong>Step 3:</strong> Exécute les requêtes SQL à partir du fichier généré, convertissant les données.<br />
</font><br /><br />
<b><u>User Accounts:</u></b><br /><font size=-1>Ce Script de convertion peut être couplé avec des utilisateurs existant dans un environnement XOOPS 2.x.
Tous les comptes du forum externe seront ajouté de manière incrémentale dans XOOPS 2.x remappant tous les sujets d\'utilisateur, posts, messages privés, etc. en utilisant le nouveau n° d\'utilisateur.
Si un compte est trouvé dans le forum externe avec le même nom que dans XOOPS 2.x, tous les sujets de forums, posts etc. seront mappé avec ce compte utilisateur.</font>
<br /><br /><center>
<font color=#ff0000 size=+1>RAPPELEZ VOUS DE FAIRE UNE SAUVEGARDE AVANT DE REALISER LA CONVERTION!!</font>
</center><br /><br />');

define('_NEWBB_CONV_ENDINFO','
<font size=+1><b>Post-Configuration de l\'Import</b></font>
<br /><br />
Vous devez aller dans le panneau de contrôle d\'administration XOOPS afin de réaliser les taches suivantes :
<li>1. ajout des modérateurs de forums</li>
<li>2. paramètres des permissions de forums</li>');

define('_NEWBB_CONV_IPBEND','<li>3. copiez tous les attachements de (ipb)\uploads vers (xoops)\uploads\attachments</li>');


//ipb
define('IPB_TITLE','Génération SQL pour IPB -> XOOPS 2.x / NewBB 2.0');
define('IPB_DBCONNECT','Connexion à la base IPB...    ');
define('IPB_ERR_DBSEL','Erreur fatale : ECHEC DE SELECTION DE BDD');
define('IPB_ERR_DBCONN','Erreur fatal : ECHEC DE CONNEXION A LA BDD');

define('IPB_USERS','Utilisateurs');
define('IPB_USER','Utilisateur');
define('IPB_CATS','Catégories');
define('IPB_FORUMS','Forums');
define('IPB_POLLS','Sondages');
define('IPB_PMS','Messages privés');
define('IPB_TOPICS','Sujets');
define('IPB_POSTS','Contributions');
define('IPB_NOTIFY','Notifications de sujets');
define('IPB_IMPORTING','Import %s');
define('IPB_IMPORTED','%d %s importé');

//phpbb
define('PHPBB_TITLE','Génération SQL pour phpBB2 -> XOOPS 2.x / NewBB 2.0');
define('PHPBB_DBCONNECT','Connexion à la base phpBB2...    ');
define('PHPBB_ERR_DBSEL','Erreur fatale : ECHEC DE SELECTION DE BDD');
define('PHPBB_ERR_DBCONN','Erreur fatale : ECHEC DE CONNEXION DE BDD');

define('PHPBB_USERS','Utilisateurs');
define('PHPBB_USER','Utilisateur');
define('PHPBB_CATS','Catégories');
define('PHPBB_FORUMS','Forums');
define('PHPBB_POLLS','Sondages');
define('PHPBB_POLL_OPTS','Options de sondage');
define('PHPBB_PMS','Messages privés');
define('PHPBB_TOPICS','Sujets');
define('PHPBB_POSTS','Contributions');
define('PHPBB_VOTES','Votes de sondage');
define('PHPBB_NOTIFY','Notifications de sujets');

define('PHPBB_IMPORTING','Import %s');
define('PHPBB_IMPORTED','%d %s importé');
?>