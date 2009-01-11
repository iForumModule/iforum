<?php //* Spanish Translation by JulioNC  *//
// $Id: modinfo.php,v 1.3 2005/10/19 17:20:33 phppp Exp $
// Thanks Tom (http://www.wf-projects.com), for correcting the Engligh language package

// Module Info
//$constpref = '_MI_' . strtoupper( basename( dirname(  dirname(  dirname( __FILE__ ) ) ) ) ) ;
$constpref = '_MI_IFORUM';

// The name of this module
define($constpref."_NAME","CBB");

// A brief description of this module
define($constpref."_DESC","Mdulo de foros para xoops");

// Names of blocks for this module (Not all module has blocks)
define($constpref."_BLOCK_TOPIC_POST","Temas recientemente contestados");//Recent Replied Topics
define($constpref."_BLOCK_TOPIC","Temas recientes");//Recent Topics
define($constpref."_BLOCK_POST","Mensajes recientes");//Recent Posts
define($constpref."_BLOCK_AUTHOR","Autor");
define($constpref."_BLOCK_TAG_CLOUD", "Tag Cloud");
define($constpref."_BLOCK_TAG_TOP", "Top Tags");
/*
define($constpref."_BNAME2","Temas ms vistos");
define($constpref."_BNAME3","Temas ms activos");
define($constpref."_BNAME4","Temas recientemente agregados a la seleccin");
define($constpref."_BNAME5","Temas recientemente pegados");
define($constpref."_BNAME6","Temas nuevos");
define($constpref."_BNAME7","Usuarios con ms temas");
define($constpref."_BNAME8","Usuarios con ms mensajes");
define($constpref."_BNAME9","Usuarios con ms temas seleccionados");
define($constpref."_BNAME10","Usuarios con ms temas pegados");
define($constpref."_BNAME11","Mensaje reciente con texto");
*/

// Names of admin menu items
define($constpref."_ADMENU_INDEX","Inicio");
define($constpref."_ADMENU_CATEGORY","Categoras");
define($constpref."_ADMENU_FORUM","Foros");
define($constpref."_ADMENU_PERMISSION","Permisos");
define($constpref."_ADMENU_BLOCK","Bloques");
define($constpref."_ADMENU_ORDER","Reordenar");
define($constpref."_ADMENU_SYNC","Sincronizar");
define($constpref."_ADMENU_PRUNE","Purgar");
define($constpref."_ADMENU_REPORT","Reportes");
define($constpref."_ADMENU_DIGEST","Digest");
define($constpref."_ADMENU_VOTE","Votos");



//config options

define("_MI_DO_DEBUG","Activar modo depuracin");
define("_MI_DO_DEBUG_DESC","Permite mostrar un mensaje de error para depurar fallos en los foros");

define("_MI_IMG_SET","Conjunto de imgenes");
define("_MI_IMG_SET_DESC","Seleccione el conjunto de imgenes que desea usar");

define("_MI_THEMESET", "Juego de Plantillas");//Theme set
define("_MI_THEMESET_DESC", "Module-wide, seleccionar '"._NONE."' el cual se utilizar como tema del sitio");// :?

define("_MI_DIR_ATTACHMENT","Directorio para archivos adjuntos");
define("_MI_DIR_ATTACHMENT_DESC","El path final debe ser 'ICMS_ROOT_PATH/nombre del directorio'. Sin barras diagonales '/' antes y despus. <br /> El path para las miniaturas deber ser 'nombre del directorio/thumbs', tambin sin '/' al principio y final.");
define("_MI_PATH_MAGICK","Path de ImageMagick");
define("_MI_PATH_MAGICK_DESC","Por lo general es '/usr/bin/X11'. Djelo en blanco si no tiene ImageMagicK instalado.");

define("_MI_SUBFORUM_DISPLAY","Modo de vista de los subforos");
define("_MI_SUBFORUM_DISPLAY_DESC","Ajusta el modo de vista para los subforos en la pgina ndice de los foros.");
define("_MI_SUBFORUM_EXPAND","Expandidos");
define("_MI_SUBFORUM_COLLAPSE","Contraidos");
define("_MI_SUBFORUM_HIDDEN","Ocultos");

define("_MI_POST_EXCERPT","Longitud del mensaje emergente");
define("_MI_POST_EXCERPT_DESC","Longitud del mensaje emergente al poner el puntero del ratn encima de un envo. 0 para desactivar el mensaje emergente.");

define("_MI_PATH_NETPBM","Ruta de Netpbm");
define("_MI_PATH_NETPBM_DESC","Usualmente es '/usr/bin'. Leave it BLANK if you do not have Netpbm installed or choice AUTO for autodetecting.");

define("_MI_IMAGELIB","Seleccione la librera de imgenes a usar");
define("_MI_IMAGELIB_DESC","Selecciona que librera de imgenes se usar para la creacin de miniaturas. Seleccione AUTO para autodetectarla.");

define("_MI_MAX_IMG_WIDTH","Anchura mxima de la imagen");
define("_MI_MAX_IMG_WIDTH_DESC", "Ajusta el <b>Ancho</b> mximo de la imagen antes de usar una miniatura. <br >Ponga 0 si no desea usar miniaturas.");

define("_MI_MAX_IMAGE_WIDTH","Anchura mxima de las miniaturas");
define("_MI_MAX_IMAGE_WIDTH_DESC", "Ajusta el ancho mximo permitido de las imgenes al crear una miniatura. <br >Si la imagen subida es ms ancha que el valor ajustado no se crear una miniatura para esta imagen.");

define("_MI_MAX_IMAGE_HEIGHT","Altura mxima de las miniaturas");
define("_MI_MAX_IMAGE_HEIGHT_DESC", "Ajusta el alto mximo permitido de las imgenes al crear una miniatura. <br >Si la imagen subida es ms alta que el valor ajustado no se crear una miniatura para esta imagen.");

define("_MI_SHOW_DIS","Mostrar advertencia legal");
define("_MI_DISCLAIMER","Advertencia legal");
define("_MI_DISCLAIMER_DESC","Escriba el texto de su advertencia legal o descargo de responsabilidades, solo se ver si ha sido activado en el campo anterior.");
define("_MI_DISCLAIMER_TEXT", "Los foros contienen una gran cantidad de temas y mensajes con una ingente cantidad de informacin til. <br /><br />A fin de mantener al mnimo la cantidad de mensajes y temas duplicados, le recomendamos que haga uso de la bsqueda del foro antes de hacer una consulta.");
define("_MI_NONE","No mostrar");
define("_MI_POST","Al enviar mensaje");
define("_MI_REPLY","Al responder mensaje");
define("_MI_OP_BOTH","En ambos casos");
define("_MI_WOL_ENABLE","Activar bloque Quin est en lnea?");
define("_MI_WOL_ENABLE_DESC","Si el bloque est activo podr verlo al final del ndice de foros y pginas de los foros.");
//define("_MI_WOL_ADMIN_COL","Color para resaltar a los administradores");
//define("_MI_WOL_ADMIN_COL_DESC","Es el color con el que se vern resaltados los nombres de los administradores en el bloque Quin est en lnea?");
//define("_MI_WOL_MOD_COL","Color para resaltar a los moderadores");
//define("_MI_WOL_MOD_COL_DESC","Es el color con el que se vern resaltados los nombres de los moderadores en el bloque Quin est en lnea?");
//define("_MI_LEVELS_ENABLE", "Activar bloque de niveles HP/MP/EXP");
//define("_MI_LEVELS_ENABLE_DESC", "<b>HP</b>  Determina su porcentaje de mensajes por da.<br><b>MP</b>  Determina su porcentaje de mensajes enviados desde su registro en la Web.<br><b>EXP</b> Determina su nivel de participacin, es incrementado cada vez que enva un mensaje, cuando alcance el 100%, ganar un nivel y la barra EXP volver a 0.");
define("_MI_NULL", "Deshabilitado");
define("_MI_TEXT", "Modo texto");
define("_MI_GRAPHIC", "Modo grfico");
define("_MI_USERLEVEL", "Modo de vista del bloque de niveles HP/MP/EXP");
define("_MI_USERLEVEL_DESC", "<strong>HP</strong>  Es determinado por el porcentaje de mensajes diarios.<br /><strong>MP</strong>  Es determinado  por el nmero de mensajes desde la fecha de registro.<br /><strong>EXP</strong> Es incrementado cada vez que un mensaje es enviado, cuando el 100% es alcanzado, se gana un nivel y el EXP empieza nuevamente desde 0.");
define("_MI_RSS_ENABLE","Activar RSS");
define("_MI_RSS_ENABLE_DESC","Activa el RSS, ajuste el nmero mximo de mensajes y longitud de la descripcin a continuacin.");
define("_MI_RSS_MAX_ITEMS", "N mximo de mensajes");
define("_MI_RSS_MAX_DESCRIPTION", "Longitud Max. de la descripcin");
define("_MI_RSS_UTF8", "Codificar el RSS con UTF-8");
define("_MI_RSS_UTF8_DESCRIPTION", "Si se selecciona, 'UTF-8' ser usado para codificar el RSS, de lo contrario, '"._CHARSET."' ser el utilizado.");
define("_MI_RSS_CACHETIME", "Refresco de cache del RSS");
define("_MI_RSS_CACHETIME_DESCRIPTION", "Tiempo de refresco de la cache del RSS, en minutos.");

define("_MI_MEDIA_ENABLE","Activar capacidad Multi Media");
define("_MI_MEDIA_ENABLE_DESC","Permite mostrar las imgenes adjuntas directamente en el mensaje.");
define("_MI_USERBAR_ENABLE","Activar barra de usuario");
define("_MI_USERBAR_ENABLE_DESC","Muestra la barra de usuario: Perfil, PM, ICQ, MSN, etc...<br>Al pasar el mouse sobre el nombre del usuario se abre automticamente un popup mostrando estos detalles.");

define("_MI_GROUPBAR_ENABLE","Activar barra de grupos");
define("_MI_GROUPBAR_ENABLE_DESC","Muestra los grupos a los cuales pertenece el usuario.");

define("_MI_RATING_ENABLE","Activar funcin de valoracin");
define("_MI_RATING_ENABLE_DESC","Permite votar por los mensajes.");

define("_MI_VIEWMODE","Modo de vista de los hilos");
define("_MI_VIEWMODE_DESC","Para sobreescribir los ajustes generales del modo de vista seleccione Vista Plana, seleccione Vista Arbol o Nada para no sobre escribirlos.");
define("_MI_COMPACT","Compacto");

define("_MI_MENUMODE","Modo por defecto del men");
define("_MI_MENUMODE_DESC","'SELECT' - Opciones de seleccin<br />'HOVER' - Funciona lento con IE<br />'CLICK' - Requiere JAVASCRIPT");

define("_MI_REPORTMOD_ENABLE","Activar reporte de mensajes al moderador");
define("_MI_REPORTMOD_ENABLE_DESC","Los usuarios pueden reportar un mensaje al moderador si lo consideran ofensivo, fuera de tono o simplemente fuera del tpico.");
define("_MI_SHOW_JUMPBOX", "Activar men de navegacin");
define("_MI_JUMPBOXDESC", "Permite si est activo, un men desplegable para navegar entre los diferentes foros.");

define("_MI_SHOW_PERMISSIONTABLE", "Mostrar panel de permisos");
define("_MI_SHOW_PERMISSIONTABLE_DESC", "Si es activado los usuarios vern un panel con un resumen de sus permisos en el foro.");

define("_MI_EMAIL_DIGEST", "Enviar por e-mail seleccin de mensajes");
define("_MI_EMAIL_DIGEST_DESC", "Ajusta el lapso de tiempo con el que se enviarn selecciones de los hilos ms activos a los usuarios.");
define($constpref."_EMAIL_NONE", "No enviar");
define($constpref."_EMAIL_DAILY", "Diariamente");
define($constpref."_EMAIL_WEEKLY", "Semanalmente");

define("_MI_SHOW_IP", "Mostrar IP del usuario");
define("_MI_SHOW_IP_DESC", "Permite mostrar la IP del usuario que envi el mensaje a los moderadores y administradores del sitio.");

define("_MI_ENABLE_KARMA", "Activar requisitos de Karma");
define("_MI_ENABLE_KARMA_DESC", "Permite al usuario seleccionar el requisito de Karma para que puedan ver sus mensajes.<br>El Karma es obtenido de acuerdo a la participacin en los foros, a ms participacin, ms Karma.");

define("_MI_KARMA_OPTIONS", "Opciones de Karma para los mensajes");
define("_MI_KARMA_OPTIONS_DESC", "Use ',' como delimitador entre varias opciones, en otras palabras, separados por comas.");

define("_MI_SINCE_OPTIONS", "Opciones del campo 'Desde' para las 'vistas' y las 'bsquedas'");
define("_MI_SINCE_OPTIONS_DESC", "Use un valor positivo para los das y uno negativo para las horas. Si usa opciones mltiples, seprelas por comas ','.");

define("_MI_SINCE_DEFAULT", "Valor por defecto para el campo 'Desde'");
define("_MI_SINCE_DEFAULT_DESC", "Ajusta el valor por defecto para este campo si no es especificado por los usuarios.");

define("_MI_MODERATOR_HTML", "Permitir etiquetas HTML en el asunto");
define("_MI_MODERATOR_HTML_DESC", "Esta opcin permite a los MODERADORES el uso de etiquetas HTML en el ASUNTO del mensaje.");

define("_MI_USER_ANONYMOUS", "Permitir a los usuarios hacer envos annimos");
define("_MI_USER_ANONYMOUS_DESC", "Le permite hacer envos annimos a los usuarios registrados o con permiso para enviar mensajes.");

define("_MI_ANONYMOUS_PRE", "Nombre para los usuarios annimos");
define("_MI_ANONYMOUS_PRE_DESC", "Indique el nombre que quiere darle a los usuarios annimos o no registrados.");

define("_MI_REQUIRE_REPLY", "Permitir requisito de participacin");
define("_MI_REQUIRE_REPLY_DESC", "Si es activado el usuario que enva un mensaje podr requerir para poder leerlo un mnimo de participacin en el foro, es decir, que los lectores del mensaje sean usuarios que ya han enviado respuestas en el foro.");

define("_MI_EDIT_TIMELIMIT", "Lmite de tiempo para editar un mensaje");
define("_MI_EDIT_TIMELIMIT_DESC", "Ajusta el lmite de tiempo que tiene el autor para editar sus mensajes. En minutos");

define("_MI_DELETE_TIMELIMIT", "Lmite de tiempo para eliminar un mensaje");
define("_MI_DELETE_TIMELIMIT_DESC", "Ajusta el lmite de tiempo que tiene el autor para eliminar sus mensajes. En minutos");

define("_MI_POST_TIMELIMIT", "Lmite de tiempo para envos consecutivos");
define("_MI_POST_TIMELIMIT_DESC", "Ajusta el lmite de tiempo que debe transcurrir entre dos envos consecutivos. En segundos, escriba 0 para configurarlo sin lmite de tiempo.");

define("_MI_RECORDEDIT_TIMELIMIT", "Lmite de tiempo para guardar la informacin de edicin");
define("_MI_RECORDEDIT_TIMELIMIT_DESC", "Ajusta el lmite de tiempo que debe transcurrir para que se guarde la informacin de que un mensaje ha sido editado. En segundos");

define("_MI_SUBJECT_PREFIX", "Agregar un prefijo al asunto del mensaje");
define("_MI_SUBJECT_PREFIX_DESC", "Permite agregar un prefijo al asunto del mensaje p.ej: [Solucionado]. Use comas ',' como delimitador entre los diversos prefijos. Deje solo NONE para no incluir ningn prefijo.");
define("_MI_SUBJECT_PREFIX_DEFAULT", '<font color="#00CC00">[solucionado]</font>,<font color="#00CC00">[arreglado]</font>,<font color="#FF0000">[peticin]</font>,<font color="#FF0000">[reportar error]</font>,<font color="#FF0000">[pendiente]</font>');

define("_MI_SUBJECT_PREFIX_LEVEL", "Grupos que pueden usar prefijos");
define("_MI_SUBJECT_PREFIX_LEVEL_DESC", "Seleccione los grupos autorizados a usar prefijos en los asuntos.");
define("_MI_SPL_DISABLE", 'Ninguno');
define("_MI_SPL_ANYONE", 'Todos');
define("_MI_SPL_MEMBER", 'Usuarios registrados');
define("_MI_SPL_MODERATOR", 'Moderadores');
define("_MI_SPL_ADMIN", 'Administradores');

define("_MI_SHOW_REALNAME", "Mostrar nombre real");
define("_MI_SHOW_REALNAME_DESC", "Reemplaza el nick del usuario por su nombre real.");

define("_MI_CACHE_ENABLE", "Activar cach");
define("_MI_CACHE_ENABLE_DESC", "Guarda algunos resultados intermedios de la sesin para minimizar las peticiones a la base de datos.");

define("_MI_QUICKREPLY_ENABLE", "Activar respuesta rpida");
define("_MI_QUICKREPLY_ENABLE_DESC", "Activar un formulario de respuesta rpida en el hilo mediante un botn.");

define("_MI_POSTSPERPAGE","Mensajes por pgina");
define("_MI_POSTSPERPAGE_DESC","Indica el nmero mximo de mensajes por pgina que sern mostrados.");

define("_MI_POSTSFORTHREAD","Nmero mximo de mensajes por tema para la vista en modo arbol");
define("_MI_POSTSFORTHREAD_DESC","El modo de vista plana ser usado si el nmero de mensajes excede el la cantidad ajustada");

define("_MI_TOPICSPERPAGE","Temas por pgina");
define("_MI_TOPICSPERPAGE_DESC","Indica el nmero mximo de temas por pgina que sern mostrados.");

define("_MI_IMG_TYPE","Formato de las imgenes");
define("_MI_IMG_TYPE_DESC","Selecciona formato de las imgenes que sern mostradas en los foros.<br />- png: Seleccione este formato si su servidor es veloz;<br />- gif: Seleccione este formato si su servidor es normal;<br />- auto: Mostrar el formato gif para IE y el formato png para otros navegadores.");

define("_MI_PNGFORIE_ENABLE","Activar hack del formato PNG");
define("_MI_PNGFORIE_ENABLE_DESC","Activndolo permitir los atributos de transparencia del formato PNG para el navegador IE.");

define("_MI_FORM_OPTIONS","Opciones del panel de envos");
define("_MI_FORM_OPTIONS_DESC","Opciones que los usuarios podrn elegir para el panel de envos cuando enven, editen o respondan mensajes.");
define("_MI_FORM_COMPACT","Compacto");
define("_MI_FORM_DHTML","DHTML");
define("_MI_FORM_SPAW","Editor Spaw");
define("_MI_FORM_HTMLAREA","Editor HtmlArea");
define("_MI_FORM_FCK","Editor FCK");
define("_MI_FORM_KOIVI","Editor Koivi");
define("_MI_FORM_TINYMCE","Editor TinyMCE");

define("_MI_MAGICK","ImageMagick");
define("_MI_NETPBM","Netpbm");
define("_MI_GD1","Librera GD1");
define("_MI_GD2","Librera GD2");
define("_MI_AUTO","AUTO");

define("_MI_WELCOMEFORUM","Foro de bienvenida a los usuarios");
define("_MI_WELCOMEFORUM_DESC","Un mensaje con el perfil del usuario ser publicado la primera vez que este acceda a los foros");

define("_MI_PERMCHECK_ONDISPLAY","Comprobar permisos");
define("_MI_PERMCHECK_ONDISPLAY_DESC","Compruebe los permisos para corregir la pgina");

define("_MI_USERMODERATE","Permitir la moderacin del usuario");
define("_MI_USERMODERATE_DESC","");


// RMV-NOTIFY
// Notification event descriptions and mail templates

define ('_MI_IFORUM_THREAD_NOTIFY', 'Hilo');
define ('_MI_IFORUM_THREAD_NOTIFYDSC', 'Opciones de Notificacin que se aplican al hilo actual.');

define ('_MI_IFORUM_FORUM_NOTIFY', 'Foro');
define ('_MI_IFORUM_FORUM_NOTIFYDSC', 'Opciones de Notificacin que se aplican al foro actual.');

define ('_MI_IFORUM_GLOBAL_NOTIFY', 'Global');
define ('_MI_IFORUM_GLOBAL_NOTIFYDSC', 'Opciones de Notificacin Globales del foro.');

define ('_MI_IFORUM_THREAD_NEWPOST_NOTIFY', 'Nuevo Envo');
define ('_MI_IFORUM_THREAD_NEWPOST_NOTIFYCAP', 'Notificarme de nuevos envios en el hilo actual.');
define ('_MI_IFORUM_THREAD_NEWPOST_NOTIFYDSC', 'Recibir notificacin cuando un nuevo mensaje es escrito en el hilo actual.');
define ('_MI_IFORUM_THREAD_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notificacin : Nuevo envo en el hilo');

define ('_MI_IFORUM_FORUM_NEWTHREAD_NOTIFY', 'Nuevo Hilo');
define ('_MI_IFORUM_FORUM_NEWTHREAD_NOTIFYCAP', 'Notificarme cuando un nuevo hilo es empezado en este foro.');
define ('_MI_IFORUM_FORUM_NEWTHREAD_NOTIFYDSC', 'Recibir notificacin cuando un nuevo hilo es comenzado el el foro actual.');
define ('_MI_IFORUM_FORUM_NEWTHREAD_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notificacin : Nuevo hilo en el foro.');

define ('_MI_IFORUM_GLOBAL_NEWFORUM_NOTIFY', 'Nuevo Foro');
define ('_MI_IFORUM_GLOBAL_NEWFORUM_NOTIFYCAP', 'Notificarme cuando un nuevo foro es creado.');
define ('_MI_IFORUM_GLOBAL_NEWFORUM_NOTIFYDSC', 'Recibir notificacin cuando un nuevo foro es creado.');
define ('_MI_IFORUM_GLOBAL_NEWFORUM_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notificacin : Nuevo Foro');

define ('_MI_IFORUM_GLOBAL_NEWPOST_NOTIFY', 'Nuevo envo');
define ('_MI_IFORUM_GLOBAL_NEWPOST_NOTIFYCAP', 'Notificarme de cualquier nuevo envo.');
define ('_MI_IFORUM_GLOBAL_NEWPOST_NOTIFYDSC', 'Recibir notificacin cuando cualquier nuevo mensaje es enviado.');
define ('_MI_IFORUM_GLOBAL_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notificacin : Nuevo envo');

define ('_MI_IFORUM_FORUM_NEWPOST_NOTIFY', 'Nuevo envo');
define ('_MI_IFORUM_FORUM_NEWPOST_NOTIFYCAP', 'Notificarme de cualquier nuevo envo en el foro actual.');
define ('_MI_IFORUM_FORUM_NEWPOST_NOTIFYDSC', 'Recibir notificacin cuando cualquier nuevo mensaje es enviado en el foro actual.');
define ('_MI_IFORUM_FORUM_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notificacin : Nuevo envo en foro');

define ('_MI_IFORUM_GLOBAL_NEWFULLPOST_NOTIFY', 'Nuevo envo (Texto completo)');
define ('_MI_IFORUM_GLOBAL_NEWFULLPOST_NOTIFYCAP', 'Notificarme de cualquier nuevo envo (incluir el texto del mensaje).');
define ('_MI_IFORUM_GLOBAL_NEWFULLPOST_NOTIFYDSC', 'Recibir notificacin con texto completo cuando cualquier nuevo mensaje es enviado.');
define ('_MI_IFORUM_GLOBAL_NEWFULLPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notificacin : Nuevo envo (texto completo)');

define ('_MI_IFORUM_GLOBAL_DIGEST_NOTIFY', 'Seleccin');
define ('_MI_IFORUM_GLOBAL_DIGEST_NOTIFYCAP', 'Notificarme de cualquier nueva seleccin.');
define ('_MI_IFORUM_GLOBAL_DIGEST_NOTIFYDSC', 'Recibir notificacin de seleccin.');
define ('_MI_IFORUM_GLOBAL_DIGEST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notificacin : Nueva seleccin');

// FOR installation
define($constpref."_INSTALL_CAT_TITLE", "Categora Test");
define($constpref."_INSTALL_CAT_DESC", "Categora para test.");
define($constpref."_INSTALL_FORUM_NAME", "Foro test");
define($constpref."_INSTALL_FORUM_DESC", "Foro para test.");
define($constpref."_INSTALL_POST_SUBJECT", "Felicitaciones! El foro est trabajando.");
define($constpref."_INSTALL_POST_TEXT", "
	Bienvenido al foro de  ".(htmlspecialchars($GLOBALS["xoopsConfig"]['sitename'], ENT_QUOTES))."
	Sintase libre de iniciar sesin y comenzar sus temas en el foro.
	
	Si tiene cualquier pregunta referente al uso de CBB, por favor, visite su sitio de soporte local, o la pgina del [url=http://community.impresscms.org/modules/newbb/viewforum.php?forum=9]Mdulo CBB[/url]
	");
define("_MI_CAPTCHA_ENABLE", "Enable Captcha");
define("_MI_CAPTCHA_ENABLE_DESC", "Enable or disable Captcha for users, while posting");
?>