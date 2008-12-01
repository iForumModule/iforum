<?php
// $Id: modinfo.php,v 1.3 2005/10/19 17:20:33 phppp Exp $
// Thanks Tom (http://www.wf-projects.com), for correcting the Engligh language package

// Module Info

// The name of this module
define("_MI_NEWBB_NAME","Fórum");

// A brief description of this module
define("_MI_NEWBB_DESC","Módulo de Fórum para XOOPS");

// Names of blocks for this module (Not all module has blocks)
define("_MI_NEWBB_BLOCK_TOPIC_POST","Últimas respostas nos fóruns");
define("_MI_NEWBB_BLOCK_TOPIC","Tópicos recentes nos fóruns");
define("_MI_NEWBB_BLOCK_POST","Últimas mensagens nos fóruns");
define("_MI_NEWBB_BLOCK_AUTHOR","Autores dos fóruns");
/*
define("_MI_NEWBB_BNAME2", "Most Viewed Topics");
define("_MI_NEWBB_BNAME3", "Most Active Topics");
define("_MI_NEWBB_BNAME4", "Newest Digest");
define("_MI_NEWBB_BNAME5", "Newest Sticky Topics");
define("_MI_NEWBB_BNAME6", "Newest Posts");
define("_MI_NEWBB_BNAME7", "Authors with most topics");
define("_MI_NEWBB_BNAME8", "Authors with most posts");
define("_MI_NEWBB_BNAME9", "Authors with most digests");
define("_MI_NEWBB_BNAME10", "Authors with most sticky topics");
define("_MI_NEWBB_BNAME11", "Recent post with text");
*/

// Names of admin menu items
define("_MI_NEWBB_ADMENU_INDEX","Índice");
define("_MI_NEWBB_ADMENU_CATEGORY","Categorias");
define("_MI_NEWBB_ADMENU_FORUM","Fóruns");
define("_MI_NEWBB_ADMENU_PERMISSION","Permissões");
define("_MI_NEWBB_ADMENU_BLOCK","Blocos");
define("_MI_NEWBB_ADMENU_ORDER","Reordenar");
define("_MI_NEWBB_ADMENU_SYNC","Sincronizar");
define("_MI_NEWBB_ADMENU_PRUNE","Exclusões");
define("_MI_NEWBB_ADMENU_REPORT","Relatórios");
define("_MI_NEWBB_ADMENU_DIGEST","Informativo");
define("_MI_NEWBB_ADMENU_VOTE","Enquetes");



//config options

define("_MI_DO_DEBUG","Modo de testes");
define("_MI_DO_DEBUG_DESC","Exibir mensagens de erro");

define("_MI_IMG_SET","Conjunto de Imagens");
define("_MI_IMG_SET_DESC","Selecione o conjunto de imagens a ser usado");

define("_MI_THEMESET", "Selecionar tema");
define("_MI_THEMESET_DESC", "Selecione o tema para o módulo, caso selecione '"._NONE."' sera usado o padrão");

define("_MI_DIR_ATTACHMENT","Caminho físico para anexos");
define("_MI_DIR_ATTACHMENT_DESC","É necessário somente o caminho após o diretório raiz do site. Se os anexos devem ficar em www.seusite.com.br/uploads/iforum, informe somente '/uploads/iforum' (sem a '/'). As miniaturas ficarão em '/uploads/iforum/thumbs'.");
define("_MI_PATH_MAGICK","Caminho para ImageMagick");
define("_MI_PATH_MAGICK_DESC","Geralmente é '/usr/bin/X11/'. Deixe em branco se você não tem o ImageMagicK instalado ou para autodetecção.");

define("_MI_SUBFORUM_DISPLAY","Modo de exibição dos sub-fóruns na página inicial");
define("_MI_SUBFORUM_DISPLAY_DESC","");
define("_MI_SUBFORUM_EXPAND","Desagrupar");
define("_MI_SUBFORUM_COLLAPSE","Agrupar");
define("_MI_SUBFORUM_HIDDEN","Ocultar");

define("_MI_POST_EXCERPT","Trecho de mensagem na página do fórum");
define("_MI_POST_EXCERPT_DESC","Largura de parte da mensagem que será mostrada ao passar o mouse. 0 para desativar.");

define("_MI_PATH_NETPBM","Caminho para NetPBM");
define("_MI_PATH_NETPBM_DESC","Geralmente é '/usr/bin'. Deixe em branco se você não tem o NetPBM instalado ou para autodetecção.");

define("_MI_IMAGELIB","Selecione a biblioteca de imagem a ser usada");
define("_MI_IMAGELIB_DESC","Seleciona a biblioteca de funções de tratamento de imagens para criação de miniaturas ou para seleção automática.");

define("_MI_MAX_IMG_WIDTH","Largura máxima da imagem");
define("_MI_MAX_IMG_WIDTH_DESC", "Configure a <strong>largura</strong> máxima permitida para imagem, do contrário será usado uma miniatura.<br>Informe 0 se você não quer sejam criadas miniaturas das imagens.");

define("_MI_MAX_IMAGE_WIDTH","Largura máxima na criação de miniatura");
define("_MI_MAX_IMAGE_WIDTH_DESC", "Configure a <strong>largura</strong> máxima para criação de uma miniatura da imagem. <br >Se a imagem for menor não será criada miniatura.");

define("_MI_MAX_IMAGE_HEIGHT","Altura máxima na criação de miniatura");
define("_MI_MAX_IMAGE_HEIGHT_DESC", "Configure a <strong>altura</strong> máxima para criação de uma miniatura da imagem. <br >Se a imagem for menor não será criada miniatura.");

define("_MI_SHOW_DIS","Exibir Declaração de Isenção de Responsabilidade");
define("_MI_DISCLAIMER","Declaração de Isenção de Responsabilidade");
define("_MI_DISCLAIMER_DESC","Insira a Declaração que será mostrada conforme o que está acima selecionado.");
define("_MI_DISCLAIMER_TEXT", "Este fórum contém muitas informações úteis. <br /><br />Pedimos evitar a criação de tópicos com assuntos já abordados anteriormente, efetuando uma busca no fórum antes de criar de um novo tópico.");
define("_MI_NONE","Nenhum");
define("_MI_POST","Novos Tópicos");
define("_MI_REPLY","Respostas");
define("_MI_OP_BOTH","Ambos");
define("_MI_WOL_ENABLE","Ativar 'Usuários online'");
define("_MI_WOL_ENABLE_DESC","Ativa bloco 'Quem está online' mostrado abaixo na página inicial do Fórum");
//define("_MI_WOL_ADMIN_COL","Administrator Highlight Color");
//define("_MI_WOL_ADMIN_COL_DESC","Highlight Color of the Administrators shown in the Who's Online Block");
//define("_MI_WOL_MOD_COL","Moderator Highlight Color");
//define("_MI_WOL_MOD_COL_DESC","Highlight Color of the Moderators shown in the Who's Online Block");
//define("_MI_LEVELS_ENABLE", "Enable HP/MP/EXP Levels Mod");
//define("_MI_LEVELS_ENABLE_DESC", "<strong>HP</strong>  is determined by your average posts per day.<br /><strong>MP</strong>  is determined by your join date related to your post count.<br /><strong>EXP</strong> goes up each time you post, and when you get to 100%, you gain a level and the EXP drops to 0 again.");
define("_MI_NULL", "desabilitado");
define("_MI_TEXT", "texto");
define("_MI_GRAPHIC", "imagem");
define("_MI_USERLEVEL", "Exibição de níveis HP/MP/EXP");
define("_MI_USERLEVEL_DESC", "<strong>HP</strong> é a média de mensagens por dia.<br /><strong>MP</strong> é determinado pelo total de mensagens em relação à data de cadastramento.<br /><strong>EXP</strong> sobre a cada mensagem e quando chega a 100% aumenta o nível e volta a 0.");
define("_MI_RSS_ENABLE","Ativar RSS");
define("_MI_RSS_ENABLE_DESC","Ativa RSS com o número máximo de itens e tamanho da descrição conforme abaixo");
define("_MI_RSS_MAX_ITEMS", "Quantidade máxima de itens");
define("_MI_RSS_MAX_DESCRIPTION", "Tamanho máximo da descrição");
define("_MI_RSS_UTF8", "Codificação de RSS com UTF-8");
define("_MI_RSS_UTF8_DESCRIPTION", "'UTF-8' será usado, se não será usado '"._CHARSET."'.");
define("_MI_RSS_CACHETIME", "Tempo de cache do RSS");
define("_MI_RSS_CACHETIME_DESCRIPTION", "Intervalo de tempo para atualização do RSS, em minutos.");

define("_MI_MEDIA_ENABLE","Ativar funções de mídia");
define("_MI_MEDIA_ENABLE_DESC","Exibe imagens anexadas na própria mensagem.");
define("_MI_USERBAR_ENABLE","Ativar barras de usuário");
define("_MI_USERBAR_ENABLE_DESC","Exibe barra de usuário expandida: Perfil, MP, ICQ, MSN, etc.");

define("_MI_GROUPBAR_ENABLE","Ativar informações de grupos");
define("_MI_GROUPBAR_ENABLE_DESC","Exibe grupos do usuário nas informações sobre a mensagem.");

define("_MI_RATING_ENABLE","Ativar função de avaliação");
define("_MI_RATING_ENABLE_DESC","Permite avaliar um tópico");

define("_MI_VIEWMODE","Modo de visualização dos tópicos");
define("_MI_VIEWMODE_DESC","Para ignorar o modo de exibição de Configurações Gerais para os tópicos.");
define("_MI_COMPACT","Compacto");

define("_MI_MENUMODE","Modo padrão de exibição do Menu");
define("_MI_MENUMODE_DESC","'SELECT' - Caixa de Seleção, 'HOVER' - Mais lento no IE, 'CLICK' - requer JavaScript ativado.");

define("_MI_REPORTMOD_ENABLE","Relatório de mensagens para o Moderador");
define("_MI_REPORTMOD_ENABLE_DESC","O usuário pode enviar uma mensagem ao moderador para que esse tome as medidas cabíveis");
define("_MI_SHOW_JUMPBOX", "Exibir Caixa de Seleção de Fóruns");
define("_MI_JUMPBOXDESC", "Se desativado, um menu drop-down permitirá aos usuários o acesso a outro fórum a partir de um fórum ou tópico");

define("_MI_SHOW_PERMISSIONTABLE", "Exibir permissões");
define("_MI_SHOW_PERMISSIONTABLE_DESC", "Acrescenta uma lista de permissões do usuário");

define("_MI_EMAIL_DIGEST", "Informativo as mensages por e-mail");
define("_MI_EMAIL_DIGEST_DESC", "Configure a periodicidade para envio de envio de resumos do fórum para os usuários");
define("_MI_NEWBB_EMAIL_NONE", "Nunca");
define("_MI_NEWBB_EMAIL_DAILY", "Diariamente");
define("_MI_NEWBB_EMAIL_WEEKLY", "Semanalmente");

define("_MI_SHOW_IP", "Exibir IP do usuário");
define("_MI_SHOW_IP_DESC", "Se desativado, o IP dos usuários será mostrado somente aos Moderadores");

define("_MI_ENABLE_KARMA", "Ativar verificação de Karma");
define("_MI_ENABLE_KARMA_DESC", "Permite que o usuário configure a pontuação de Karma requerida para ler a mensagem");

define("_MI_KARMA_OPTIONS", "Opções de pontuações de Karma por envios");
define("_MI_KARMA_OPTIONS_DESC", "Use ',' como delimitador para as opções. Deixe em branco para desabilitar esta opção");

define("_MI_SINCE_OPTIONS", "Opções para 'Desde' filtro de tópicos e procura");
define("_MI_SINCE_OPTIONS_DESC", "Positivo para dias e negativo para horas. Use ',' como delimitador.");

define("_MI_SINCE_DEFAULT", "Valor padrão para 'Desde'");
define("_MI_SINCE_DEFAULT_DESC", "Valor usado quando não especificado pelos usuários.");

define("_MI_MODERATOR_HTML", "Ativar HTML para moderadores");
define("_MI_MODERATOR_HTML_DESC", "Permite que moderadores usem HTML no assunto da mensagem");

define("_MI_USER_ANONYMOUS", "Ativar envio de mensagens como anônimo");
define("_MI_USER_ANONYMOUS_DESC", "Permite que um usuário registrado envie mensagens como anônimo");

define("_MI_ANONYMOUS_PRE", "Ativar uso de Prefixo para anônimos");
define("_MI_ANONYMOUS_PRE_DESC", "Permite que usuários anônimos adicionem prefixo nos tópicos");

define("_MI_REQUIRE_REPLY", "Ativar requisito de resposta para ler um tópico");
define("_MI_REQUIRE_REPLY_DESC", "Permite que um usuário solicite resposta antes da leitura do tópico");

define("_MI_EDIT_TIMELIMIT", "Ativar limite de tempo para editar uma mensagem");
define("_MI_EDIT_TIMELIMIT_DESC", "Permite ajustar um tempo máximo, em minutos, para edição da mensagem.");

define("_MI_DELETE_TIMELIMIT", "Ativar limite de tempo para excluir uma mensagem");
define("_MI_DELETE_TIMELIMIT_DESC", "Permite ajustar um tempo máximo, em minutos, para exclusão da mensagem.");

define("_MI_POST_TIMELIMIT", "Ativar limite de tempo para mensagens consecutivas");
define("_MI_POST_TIMELIMIT_DESC", "Permite ajustar um tempo máximo, em segundos, para mensagnes consecutivas.");

define("_MI_RECORDEDIT_TIMELIMIT", "Ativar limite de tempo para informação de edição");
define("_MI_RECORDEDIT_TIMELIMIT_DESC", "Permite ajustar um tempo máximo, em segundos, para não incluir informação sobre edição da mensagem");

define("_MI_SUBJECT_PREFIX", "Incluir um Prefixo para o Assunto do Tópico");
define("_MI_SUBJECT_PREFIX_DESC", "Escolha um Prefixo se for necessário, conforme ex: [resolvido] no início do Assunto. Usar ',' como delimitador para multi-opções, só para não deixar NENHUM no Prefixo.");
define("_MI_SUBJECT_PREFIX_DEFAULT", '<font color="#00CC00">[Resolvido]</font>,<font color="#00CC00">[Corrigido]</font>,<font color="#FF0000">[Solicitação]</font>,<font color="#FF0000">[Relato de Erro]</font>,<font color="#FF0000">[Não resolvido]</font>');

define("_MI_SUBJECT_PREFIX_LEVEL", "Nível de grupos que podem usar Prefixo");
define("_MI_SUBJECT_PREFIX_LEVEL_DESC", "Escolha grupos autorizados a utilizar o prefixo.");
define("_MI_SPL_DISABLE", 'Desabilitar');
define("_MI_SPL_ANYONE", 'Qualquer um');
define("_MI_SPL_MEMBER", 'Usuários');
define("_MI_SPL_MODERATOR", 'Moderadores');
define("_MI_SPL_ADMIN", 'Administradores');

define("_MI_SHOW_REALNAME", "Mostrar nome Real");
define("_MI_SHOW_REALNAME_DESC", "Substitua o nome do usuário com o nome real do usuário.");

define("_MI_CACHE_ENABLE", "Ativar cache");
define("_MI_CACHE_ENABLE_DESC", "Grava dados temporários da sessão para agilizar pesquisas.");

define("_MI_QUICKREPLY_ENABLE", "Ativar resposta rápida");
define("_MI_QUICKREPLY_ENABLE_DESC", "Inclui formulário de resposta rápida no rodapé do tópico");

define("_MI_POSTSPERPAGE","Mensagens por página");
define("_MI_POSTSPERPAGE_DESC","Número máximo de mensagens a serem exibidas em cada página");

define("_MI_POSTSFORTHREAD","Mensagens por tópico");
define("_MI_POSTSFORTHREAD_DESC","Será usado modo agrupado se for excedido este número");

define("_MI_TOPICSPERPAGE","Tópicos por página");
define("_MI_TOPICSPERPAGE_DESC","Número máximo de tópicos a serem exibidos em cada página");

define("_MI_IMG_TYPE","Formato de imagens");
define("_MI_IMG_TYPE_DESC","Selecione o tipo de imagens para botões do fórum.<br />- png: para servidores rápidos;<br />- gif: para velocidade normal;<br />- auto: GIF para Internet Explorer e and PNG para outros browsers");

define("_MI_PNGFORIE_ENABLE","Ativar hack de PNG");
define("_MI_PNGFORIE_ENABLE_DESC","Permitir transparência em PNG para Internet Explorer");

define("_MI_FORM_OPTIONS","Opções de formulário");
define("_MI_FORM_OPTIONS_DESC","Tipos de formulários que os usuários poderão usar para escrever, editar ou responder.");
define("_MI_FORM_COMPACT","Compacto");
define("_MI_FORM_DHTML","DHTML");
define("_MI_FORM_SPAW","Spaw Editor");
define("_MI_FORM_HTMLAREA","HtmlArea Editor");
define("_MI_FORM_FCK","FCK Editor");
define("_MI_FORM_KOIVI","Koivi Editor");
define("_MI_FORM_TINYMCE","TinyMCE Editor");

define("_MI_MAGICK","ImageMagick");
define("_MI_NETPBM","NetPBM");
define("_MI_GD1","Biblioteca GD1");
define("_MI_GD2","Biblioteca GD2");
define("_MI_AUTO","AUTO");

define("_MI_WELCOMEFORUM","Fórum para apresentação de novo usuário");
define("_MI_WELCOMEFORUM_DESC","Um perfil será publicado quando um novo acessar o fórum pela primeira vez.");

define("_MI_PERMCHECK_ONDISPLAY","Verificar permissão");
define("_MI_PERMCHECK_ONDISPLAY_DESC","Verificar permissão para editar na página");

define("_MI_USERMODERATE","Permitir ao usuário moderar");
define("_MI_USERMODERATE_DESC","");


// RMV-NOTIFY
// Notification event descriptions and mail templates

define ('_MI_NEWBB_THREAD_NOTIFY', 'Tópico');
define ('_MI_NEWBB_THREAD_NOTIFYDSC', 'Opções de aviso aplicáveis neste tópico.');

define ('_MI_NEWBB_FORUM_NOTIFY', 'Fórum');
define ('_MI_NEWBB_FORUM_NOTIFYDSC', 'Opções de aviso aplicáveis neste fórum.');

define ('_MI_NEWBB_GLOBAL_NOTIFY', 'Geral');
define ('_MI_NEWBB_GLOBAL_NOTIFYDSC', 'Opções gerais de aviso do Fórum.');

define ('_MI_NEWBB_THREAD_NEWPOST_NOTIFY', 'Nova Mensagem');
define ('_MI_NEWBB_THREAD_NEWPOST_NOTIFYCAP', 'Avise-me sobre novas mensagens neste tópico.');
define ('_MI_NEWBB_THREAD_NEWPOST_NOTIFYDSC', 'Receba avisos de novas mensagens no tópico atual.');
define ('_MI_NEWBB_THREAD_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} aviso: Nova mensagem no tópico');

define ('_MI_NEWBB_FORUM_NEWTHREAD_NOTIFY', 'Novo Tópico');
define ('_MI_NEWBB_FORUM_NEWTHREAD_NOTIFYCAP', 'Avise-me sobre novos tópicos deste fórum.');
define ('_MI_NEWBB_FORUM_NEWTHREAD_NOTIFYDSC', 'Receba aviso quando um novo tópico for iniciado no fórum atual.');
define ('_MI_NEWBB_FORUM_NEWTHREAD_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} aviso: Novo tópico no fórum');

define ('_MI_NEWBB_GLOBAL_NEWFORUM_NOTIFY', 'Novo Fórum');
define ('_MI_NEWBB_GLOBAL_NEWFORUM_NOTIFYCAP', 'Avise-me quando novos fóruns forem criados.');
define ('_MI_NEWBB_GLOBAL_NEWFORUM_NOTIFYDSC', 'Receba aviso quando for criado um novo fórum.');
define ('_MI_NEWBB_GLOBAL_NEWFORUM_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} aviso: Novo fórum');

define ('_MI_NEWBB_GLOBAL_NEWPOST_NOTIFY', 'Nova Mensagem');
define ('_MI_NEWBB_GLOBAL_NEWPOST_NOTIFYCAP', 'Avise-me quando houver nova mensagem.');
define ('_MI_NEWBB_GLOBAL_NEWPOST_NOTIFYDSC', 'Receba aviso quando uma nova mensagem for enviada.');
define ('_MI_NEWBB_GLOBAL_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} aviso: Nova mensagem');

define ('_MI_NEWBB_FORUM_NEWPOST_NOTIFY', 'Nova Mensagem');
define ('_MI_NEWBB_FORUM_NEWPOST_NOTIFYCAP', 'Avise-me sobre novas mensagens neste fórum.');
define ('_MI_NEWBB_FORUM_NEWPOST_NOTIFYDSC', 'Receba aviso quando uma nova mensagem for enviada para este fórum');
define ('_MI_NEWBB_FORUM_NEWPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} aviso: Nova mensagem no fórum');

define ('_MI_NEWBB_GLOBAL_NEWFULLPOST_NOTIFY', 'Nova Mensagem (texto completo)');
define ('_MI_NEWBB_GLOBAL_NEWFULLPOST_NOTIFYCAP', 'Avise-me quando houver nova mensagem (incluir texto completo).');
define ('_MI_NEWBB_GLOBAL_NEWFULLPOST_NOTIFYDSC', 'Receba aviso com o texto completo quando uma nova mensagem for enviada.');
define ('_MI_NEWBB_GLOBAL_NEWFULLPOST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} aviso: Nova mensagem (texto completo)');

define ('_MI_NEWBB_GLOBAL_DIGEST_NOTIFY', 'Informativo');
define ('_MI_NEWBB_GLOBAL_DIGEST_NOTIFYCAP', 'Informativo com resumo do fórum.');
define ('_MI_NEWBB_GLOBAL_DIGEST_NOTIFYDSC', 'Receba resumos do fórum.');
define ('_MI_NEWBB_GLOBAL_DIGEST_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notificação: resumo do fórum');

// FOR installation
define("_MI_NEWBB_INSTALL_CAT_TITLE", "Categoria de teste");
define("_MI_NEWBB_INSTALL_CAT_DESC", "Categoria para teste");
define("_MI_NEWBB_INSTALL_FORUM_NAME", "Fórum de teste");
define("_MI_NEWBB_INSTALL_FORUM_DESC", "Fórum para teste");
define("_MI_NEWBB_INSTALL_POST_SUBJECT", "Parabéns! O fórum está funcionando.");
define("_MI_NEWBB_INSTALL_POST_TEXT", "
	Bem-vindo para o ".(htmlspecialchars($GLOBALS["xoopsConfig"]['sitename'], ENT_QUOTES))." forum.
	Sinta-se livre para fazer o seu registro ou entrar com o seu login para iniciar ou responder tópicos.
	
	Se você tiver alguma pergunta sobre como usar o CBB, por favor, faça uma visita no site de suporte: [url=http://community.impresscms.org/modules/newbb/viewforum.php?forum=9](Site sobre o módulo CBB)[/url].
	");

//define("_MI_NEWBB_BLOCK_TAG_CLOUD", "Tag Cloud"); //<---------------------
//define("_MI_NEWBB_BLOCK_TAG_TOP", "Top Tags");   //<---------------------
//define("_MI_NEWBB_ADMENU_TYPE", "Tipo de tópico");

?>