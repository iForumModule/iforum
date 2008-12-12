<?php  //* Spanish Translation by JulioNC  *// 
// $Id: admin.php,v 1.3 2005/10/19 17:20:33 phppp Exp $
//%%%%%%	File Name  index.php   	%%%%%
//$constpref = '_AM_' . strtoupper( basename( dirname(  dirname(  dirname( __FILE__ ) ) ) ) ) ;
$constpref = '_AM_NEWBB';
define($constpref."_FORUMCONF","Configuración del foro");
define($constpref."_ADDAFORUM","Agregar foro");
define($constpref."_SYNCFORUM","Sincronizar foros/temas");
define($constpref."_REORDERFORUM","Ordenar foros");
define($constpref."_FORUM_MANAGER","Administrar foro");
define($constpref."_PRUNE_TITLE","Sistema de purgado de foros");
define($constpref."_CATADMIN","Administrar categoría");
define($constpref."_GENERALSET", "Configuración del módulo" );
define($constpref."_MODULEADMIN","Administrar módulo:");
define($constpref."_HELP","Ayuda");
define($constpref."_ABOUT","Créditos");
define($constpref."_BOARDSUMMARY","Estadísticas foro");
define($constpref."_PENDING_POSTS_FOR_AUTH","Mensaje pendiente de autorización");
define($constpref."_POSTID","ID Mensaje");
define($constpref."_POSTDATE","Fecha del mensaje");
define($constpref."_POSTER","Enviado por");
define($constpref."_TOPICS","Asunto");
define($constpref."_SHORTSUMMARY","Resumen foro");
define($constpref."_TOTALPOSTS","Total mensajes");
define($constpref."_TOTALTOPICS","Total temas");
define($constpref."_TOTALVIEWS","Total visitas");
define($constpref."_BLOCKS","Bloques");
define($constpref."_SUBJECT","Asunto");
define($constpref."_APPROVE","Aprobar mensaje");
define($constpref."_APPROVETEXT","Contenido de este mensaje");
define($constpref."_POSTAPPROVED","El mensaje ha sido aprobado");
define($constpref."_POSTNOTAPPROVED","El mensaje no ha sido aprobado");
define($constpref."_POSTSAVED","El mensaje ha sido guardado");
define($constpref."_POSTNOTSAVED","El mensaje no ha sido guardado");

define($constpref."_TOPICAPPROVED","El mensaje ha sido aprobado");
define($constpref."_TOPICNOTAPPROVED","El mensaje NO ha sido aprobado");
define($constpref."_TOPICID","ID del mensaje");
define($constpref."_ORPHAN_TOPICS_FOR_AUTH","Mensajes sin aprobación");


define($constpref.'_DEL_ONE','Eliminar solo este mensaje');
define($constpref.'_POSTSDELETED','El mensaje seleccionado ha sido eliminado.');
define($constpref.'_NOAPPROVEPOST','Actualmente no hay mensajes pendientes de aprobación.');
define($constpref.'_SUBJECTC','Asunto:');
define($constpref.'_MESSAGEICON','Icono del mensaje:');
define($constpref.'_MESSAGEC','Mensaje:');
define($constpref.'_CANCELPOST','Cancelar envío');
define($constpref.'_GOTOMOD','Ir al módulo');

define($constpref.'_PREFERENCES','Preferencias del módulo');
define($constpref.'_POLLMODULE','Modulo de encuestas de Xoops');
define($constpref.'_POLL_OK','Listo para ser usado');
define($constpref.'_GDLIB1','Librería GD1:');
define($constpref.'_GDLIB2','Librería GD2:');
define($constpref.'_AUTODETECTED','Autodetectada: ');
define($constpref.'_AVAILABLE','Disponible');
define($constpref.'_NOTAVAILABLE','<font color="red">No disponible</font>');
define($constpref.'_NOTWRITABLE','<font color="red">No escribible por el servidor</font>');
define($constpref.'_IMAGEMAGICK','ImageMagicK');
define($constpref.'_IMAGEMAGICK_NOTSET','No ajustado');
define($constpref.'_ATTACHPATH','Ruta para los archivos adjuntos');
define($constpref.'_THUMBPATH','Ruta para las miniaturas');
//define($constpref.'_RSSPATH','Ruta para el servicio RSS');
define($constpref.'_REPORT','Mensajes reportados');
define($constpref.'_REPORT_PENDING','Pendientes');
define($constpref.'_REPORT_PROCESSED','Procesados');

define($constpref.'_CREATETHEDIR','Crear');
define($constpref.'_SETMPERM','Ajustar los permisos.');
define($constpref.'_DIRCREATED','El directorio ha sido creado.');
define($constpref.'_DIRNOTCREATED','El directorio no ha podido ser creado.');
define($constpref.'_PERMSET','Los permisos han sido establecidos.');
define($constpref.'_PERMNOTSET','Los permisos NO han podido ser establecidos.');

define($constpref.'_DIGEST','Notificación de selecciones');
define($constpref.'_DIGEST_PAST','<font color="red">Ha sido enviada hace %d minutos.</font>');
define($constpref.'_DIGEST_NEXT','Será enviada en %d minutos.');
define($constpref.'_DIGEST_ARCHIVE','Historial de selecciones');
define($constpref.'_DIGEST_SENT','Selección procesada');
define($constpref.'_DIGEST_FAILED','Selección NO procesada');

// admin_forum_manager.php
define($constpref."_NAME","Nombre");
define($constpref."_CREATEFORUM","Crear foro");
define($constpref."_EDIT","Editar");
define($constpref."_CLEAR","Limpiar");
define($constpref."_DELETE","Eliminar");
define($constpref."_ADD","Agregar");
define($constpref."_MOVE","Mover");
define($constpref."_ORDER","Ordenar");
define($constpref."_TWDAFAP","Nota: Esta acción eliminará el foro con todos los mensajes que existan dentro del mismo.<br><br>ADVERTENCIA: ¿Está seguro de querer eliminar este foro?");
define($constpref."_FORUMREMOVED","El foro y todos sus mensajes ha sido eliminado.");
define($constpref."_CREATENEWFORUM","Crear un nuevo foro");
define($constpref."_EDITTHISFORUM","Editar un foro:");
define($constpref."_SET_FORUMORDER","Ajustar orden del foro:");
define($constpref."_ALLOWPOLLS","Permitir encuestas:");
define($constpref."_ATTACHMENT_SIZE" ,"Tamaño max. en kb:");
define($constpref."_ALLOWED_EXTENSIONS", "Permitir extensiones:<span style='font-size: xx-small; font-weight: normal; display: block;'>Extensiones separadas por |</span>");
//define($constpref."_ALLOW_ATTACHMENTS", "Permitir archivos adjuntos:");
define($constpref."_ALLOWHTML","Permitir HTML:");
define($constpref."_YES","Si");
define($constpref."_NO","No");
define($constpref."_ALLOWSIGNATURES","Permitir firmas:");
define($constpref."_HOTTOPICTHRESHOLD","Cuantos mensajes calientes mostrar (Hot Topic Threshold):");
//define($constpref."_POSTPERPAGE","Mensajes por página:<span style='font-size: xx-small; font-weight: normal; display: block;'>(Este es el número de mensajes<br> por tema que serán<br> mostrados en cada página)</span>");
//define($constpref."_TOPICPERFORUM","Temas por foro:<span style='font-size: xx-small; font-weight: normal; display: block;'>(Este es el número de temas<br> ppor foro que serán<br> mostrados en cada página)</span>");
//define($constpref."_SHOWNAME","Reemplazar nombre se usuario con el nombre real:");
//define($constpref."_SHOWICONSPANEL","Mostrar panel de iconos:");
//define($constpref."_SHOWSMILIESPANEL","Mostar panel de caritas:");
define($constpref."_MODERATOR_REMOVE","Quitar moderadores actuales");
define($constpref."_MODERATOR_ADD","Agregar moderadores");
define($constpref."_ALLOW_SUBJECT_PREFIX", "Permitir un prefijo en el asunto");
define($constpref."_ALLOW_SUBJECT_PREFIX_DESC", "Permite incluir un prefijo en el asunto del mensaje, para por ejemplo indicar que el problema ha sido resuelto.");


// admin_cat_manager.php

define($constpref."_SETCATEGORYORDER","Ordenar categoría:");
define($constpref."_ACTIVE","Activa");
define($constpref."_INACTIVE","Inactiva");
define($constpref."_STATE","Estado:");
define($constpref."_CATEGORYDESC","Descripción de la categoría:");
define($constpref."_SHOWDESC","Mostrar descripción:");
define($constpref."_IMAGE","Imágen:");
//define($constpref."_SPONSORIMAGE","Imagen patrocinador:");
define($constpref."_SPONSORLINK","Enlace patrocinador:");
define($constpref."_DELCAT","Eliminar categoría");
define($constpref."_WAYSYWTDTTAL","Nota: Esta acción NO eliminará los foros que dependan de esta categría, para eliminarlos deberá hacerlo por la vía editar foros.<br><br>ADVERTENCIA: ¿Está seguro de querer eliminar esta categoría?");



//%%%%%%        File Name  admin_forums.php           %%%%%
define($constpref."_FORUMNAME","Nombre del foro:");
define($constpref."_FORUMDESCRIPTION","Descripción del foro:");
define($constpref."_MODERATOR","Moderadores:");
define($constpref."_REMOVE","Eliminar");
define($constpref."_CATEGORY","Categoría:");
define($constpref."_DATABASEERROR","Error de base de datos");
define($constpref."_CATEGORYUPDATED","Categoría actualizada.");
define($constpref."_EDITCATEGORY","Editar categoría:");
define($constpref."_CATEGORYTITLE","Título de la categoría:");
define($constpref."_CATEGORYCREATED","Categoría creada.");
define($constpref."_CREATENEWCATEGORY","Crear una nueva categoría");
define($constpref."_FORUMCREATED","Foro creado.");
define($constpref."_ACCESSLEVEL","Nivel de acceso global:");
define($constpref."_CATEGORY1","Categoría");
define($constpref."_FORUMUPDATE","Configuración del foro actualizada");
define($constpref."_FORUM_ERROR","ERROR: Error en la configuración del foro.");
define($constpref."_CLICKBELOWSYNC","Al hacer clic en el siguiente botón sincronizará los foros y temas con los datos correctos desde la base de datos.<br /> Úselo si considera que existe una discrepancia en el orden de foros y temas.");
define($constpref."_SYNCHING","Sincronizando foros y temas (Esta operación puede tardar, sea paciente)");
define($constpref."_CATEGORYDELETED","Categoría eliminada.");
define($constpref."_MOVE2CAT","Mover a la categoría:");
define($constpref."_MAKE_SUBFORUM_OF","Crear un subforo de:");
define($constpref."_MSG_FORUM_MOVED","Foro movido.");
define($constpref."_MSG_ERR_FORUM_MOVED","Error al mover foro.");
define($constpref."_SELECT","< Seleccione >");
define($constpref."_MOVETHISFORUM","Mover este foro");
define($constpref."_MERGE","Combinar");
define($constpref."_MERGETHISFORUM","Combinar este foro");
define($constpref."_MERGETO_FORUM","Combinar este foro con:");
define($constpref."_MSG_FORUM_MERGED","El foro ha sido combinado.");
define($constpref."_MSG_ERR_FORUM_MERGED","Error al combinar foro.");

//%%%%%%        File Name  admin_forum_reorder.php           %%%%%
define($constpref."_REORDERID","ID");
define($constpref."_REORDERTITLE","Título");
define($constpref."_REORDERWEIGHT","Posición");
define($constpref."_SETFORUMORDER","Ajustar orden del foro");
define($constpref."_BOARDREORDER","El foro ha sido reordenado");

// admin_permission.php
define($constpref."_PERMISSIONS_TO_THIS_FORUM","Permisos de los temas de este foro");
define($constpref."_CAT_ACCESS","Acceso a Categoría");
define($constpref."_CAN_ACCESS","Pueden acceder");
define($constpref."_CAN_VIEW","Pueden ver");
define($constpref."_CAN_POST","Pueden enviar");
define($constpref."_CAN_REPLY","Pueden responder");
define($constpref."_CAN_EDIT","Pueden editar");
define($constpref."_CAN_DELETE","Pueden eliminar");
define($constpref."_CAN_ADDPOLL","Pueden agregar encuesta");
define($constpref."_CAN_VOTE","Pueden votar");
define($constpref."_CAN_ATTACH","Pueden adjuntar archivos");
define($constpref."_CAN_NOAPPROVE","Pueden enviar sin aprobación");
define($constpref."_ACTION","Acción");

define($constpref."_PERM_TEMPLATE","Plantilla de Permisos por defecto");
define($constpref."_PERM_TEMPLATE_DESC","Podrá ser aplicado a un foro ");
define($constpref."_PERM_FORUMS","Seleccionar foros");
define($constpref."_PERM_TEMPLATE_CREATED","Se ha creado la plantilla de permisos");
define($constpref."_PERM_TEMPLATE_ERROR","Errores ocurridos durante la creación de la plantilla de permisos ");
define($constpref."_PERM_TEMPLATEAPP","Aplicar permisos de");
define($constpref."_PERM_TEMPLATE_APPLIED","Los permisos por defecto se han aplicado a los foros");
define($constpref."_PERM_ACTION","Acciones de los Permisos");
define($constpref."_PERM_SETBYGROUP","Fijar permisos directamente al grupo");

// admin_forum_prune.php

define($constpref."_PRUNE_RESULTS_TITLE","Purgar resultados");
define($constpref."_PRUNE_RESULTS_TOPICS","Temas purgados");
define($constpref."_PRUNE_RESULTS_POSTS","Mensajes purgados");
define($constpref."_PRUNE_RESULTS_FORUMS","Foros purgados");
define($constpref."_PRUNE_STORE","Guardar mensajes en este foro en vez de eliminarlos");
define($constpref."_PRUNE_ARCHIVE","Hacer una copia de los mensajes en un archivo");
define($constpref."_PRUNE_FORUMSELERROR","Ha olvidado seleccionar los foros que desea purgar");

define($constpref."_PRUNE_DAYS","Remover mensajes sin respuesta en:");
define($constpref."_PRUNE_FORUMS","Foros que serán purgados");
define($constpref."_PRUNE_STICKY","Conservar los temas pegados");
define($constpref."_PRUNE_DIGEST","Conservar temas de la selección");
define($constpref."_PRUNE_LOCK","Conservar los temas bloqueados");
define($constpref."_PRUNE_HOT","Conservar temas con más de estas respuestas");
define($constpref."_PRUNE_SUBMIT","Aceptar");
define($constpref."_PRUNE_RESET","Reanudar");
define($constpref."_PRUNE_YES","Si");
define($constpref."_PRUNE_NO","No");
define($constpref."_PRUNE_WEEK","1 semana");
define($constpref."_PRUNE_2WEEKS","2 semanas");
define($constpref."_PRUNE_MONTH","1 mes");
define($constpref."_PRUNE_2MONTH","2 meses");
define($constpref."_PRUNE_4MONTH","4 meses");
define($constpref."_PRUNE_YEAR","1 año");
define($constpref."_PRUNE_2YEARS","2 años");

// About.php constants
define($constpref.'_AUTHOR_INFO', "Información del autor");
define($constpref.'_AUTHOR_NAME', "Autor");
define($constpref.'_AUTHOR_WEBSITE', "Sitio Web del autor");
define($constpref.'_AUTHOR_EMAIL', "Email del autor");
define($constpref.'_AUTHOR_CREDITS', "Créditos");
define($constpref.'_MODULE_INFO', "Información sobre el desarrollo del módulo");
define($constpref.'_MODULE_STATUS', "Estado del módulo");
define($constpref.'_MODULE_DEMO', "Sitio de demostración");
define($constpref.'_MODULE_SUPPORT', "Sitio oficial de soporte");
define($constpref.'_MODULE_BUG', "Reportar un bug en este módulo");
define($constpref.'_MODULE_FEATURE', "Sugerir una nueva característica para este módulo");
define($constpref.'_MODULE_DISCLAIMER', "Aviso legal y descargo de responsabilidades");
define($constpref.'_AUTHOR_WORD', "Saludos y agradecimientos");
define($constpref.'_BY','Por');
define($constpref.'_AUTHOR_WORD_EXTRA', "
");

// admin_report.php
define($constpref."_REPORTADMIN","Gestor de reportes");
define($constpref."_PROCESSEDREPORT","Ver reportes procesados");
define($constpref."_PROCESSREPORT","Reportes procesados");
define($constpref."_REPORTTITLE","Título del reporte");
define($constpref."_REPORTEXTRA","Extra");
define($constpref."_REPORTPOST","Mensaje reportado");
define($constpref."_REPORTTEXT","Texto reportado");
define($constpref."_REPORTMEMO","Memoria de reportes");

// admin_report.php
define($constpref."_DIGESTADMIN","Gestor de selecciones");
define($constpref."_DIGESTCONTENT","Contenido de las selecciones");

// admin_votedata.php
define($constpref."_VOTE_RATINGINFOMATION", "Información de votos");
define($constpref."_VOTE_TOTALVOTES", "Votos en total: ");
define($constpref."_VOTE_REGUSERVOTES", "Votos de usuarios registrados: %s");
define($constpref."_VOTE_ANONUSERVOTES", "Votos de usuarios anónimos: %s");
define($constpref."_VOTE_USER", "Usuario");
define($constpref."_VOTE_IP", "Dirección IP");
define($constpref."_VOTE_USERAVG", "Porcentaje de votaciones");
define($constpref."_VOTE_TOTALRATE", "Total valoraciones");
define($constpref."_VOTE_DATE", "Fecha");
define($constpref."_VOTE_RATING", "Valoración");
define($constpref."_VOTE_NOREGVOTES", "Sin votos de usuarios registrados");
define($constpref."_VOTE_NOUNREGVOTES", "Sin votos de usuarios anónimos");
define($constpref."_VOTEDELETED", "Información de votación eliminada.");
define($constpref."_VOTE_ID", "ID");
define($constpref."_VOTE_FILETITLE", "Título del hilo");
define($constpref."_VOTE_DISPLAYVOTES", "Información de las votaciones");
define($constpref."_VOTE_NOVOTES", "Sin votos que mostrar");
define($constpref."_VOTE_DELETE", "Sin votos que mostrar");
define($constpref."_VOTE_DELETEDSC", "<b>Elimina</b> de la base de datos la información sobre las votaciones seleccionadas.");
?>