<?php
// $Id: admin.php,v 1.3 2005/10/19 17:20:33 phppp Exp $
//%%%%%%	File Name  index.php   	%%%%%
define("_AM_NEWBB_FORUMCONF","Configuração do fórum");
define("_AM_NEWBB_ADDAFORUM","Criar um fórum");
define("_AM_NEWBB_SYNCFORUM","Sincronizar Fóruns");
define("_AM_NEWBB_REORDERFORUM","Reordenar");
define("_AM_NEWBB_FORUM_MANAGER","Fóruns");
define("_AM_NEWBB_PRUNE_TITLE","Exclusões");
define("_AM_NEWBB_CATADMIN","Categorias");
define("_AM_NEWBB_GENERALSET", "Configurações Gerais" );
define("_AM_NEWBB_MODULEADMIN","Aministração do Módulo:");
define("_AM_NEWBB_HELP","Ajuda");
define("_AM_NEWBB_ABOUT","Sobre");
define("_AM_NEWBB_BOARDSUMMARY","Estatísticas");
define("_AM_NEWBB_PENDING_POSTS_FOR_AUTH","Mensagens aguardando por aprovação");
define("_AM_NEWBB_POSTID","Id");
define("_AM_NEWBB_POSTDATE","Data");
define("_AM_NEWBB_POSTER","Enviado por");
define("_AM_NEWBB_TOPICS","Tópico");
define("_AM_NEWBB_SHORTSUMMARY","Resumo");
define("_AM_NEWBB_TOTALPOSTS","Mensagens");
define("_AM_NEWBB_TOTALTOPICS","Tópicos");
define("_AM_NEWBB_TOTALVIEWS","Leituras");
define("_AM_NEWBB_BLOCKS","Blocos");
define("_AM_NEWBB_SUBJECT","Assunto");
define("_AM_NEWBB_APPROVE","Aprovar");
define("_AM_NEWBB_APPROVETEXT","Contéudo desta mensagem");
define("_AM_NEWBB_POSTAPPROVED","Mensagem aprovada");
define("_AM_NEWBB_POSTNOTAPPROVED","Mensagem não foi aprovada");
define("_AM_NEWBB_POSTSAVED","Mensagem salva");
define("_AM_NEWBB_POSTNOTSAVED","Mensagem não foi salva");

define("_AM_NEWBB_TOPICAPPROVED","Tópico aprovado");
define("_AM_NEWBB_TOPICNOTAPPROVED","Tópico não foi aprovado");
define("_AM_NEWBB_TOPICID","Id");
define("_AM_NEWBB_ORPHAN_TOPICS_FOR_AUTH","Tópicos aguardando aprovação");


define('_AM_NEWBB_DEL_ONE','Excluir apenas esta mensagem');
define('_AM_NEWBB_POSTSDELETED','Mensagem selecionada foi excluída.');
define('_AM_NEWBB_NOAPPROVEPOST','Não há mensagens aguardando aprovação.');
define('_AM_NEWBB_SUBJECTC','Assunto:');
define('_AM_NEWBB_MESSAGEICON','Ícone da mensagem:');
define('_AM_NEWBB_MESSAGEC','Mensagem:');
define('_AM_NEWBB_CANCELPOST','Cancelar');
define('_AM_NEWBB_GOTOMOD','Ir para o Módulo');

define('_AM_NEWBB_PREFERENCES','Preferências');
define('_AM_NEWBB_POLLMODULE','Módulo XoopsPoll (Enquetes)');
define('_AM_NEWBB_POLL_OK','Disponível para uso');
define('_AM_NEWBB_GDLIB1','Biblioteca GD1:');
define('_AM_NEWBB_GDLIB2','Biblioteca GD2:');
define('_AM_NEWBB_AUTODETECTED','Disponível: ');
define('_AM_NEWBB_AVAILABLE','Disponível');
define('_AM_NEWBB_NOTAVAILABLE','<font color="red">Indisponível</font>');
define('_AM_NEWBB_NOTWRITABLE','<font color="red">Não tem permissão para gravação</font>');
define('_AM_NEWBB_IMAGEMAGICK','ImageMagick:');
define('_AM_NEWBB_IMAGEMAGICK_NOTSET','Não configurado');
define('_AM_NEWBB_ATTACHPATH','Diretório para anexos');
define('_AM_NEWBB_THUMBPATH','Diretório para miniaturas');
//define('_AM_NEWBB_RSSPATH','Path for RSS feed');
define('_AM_NEWBB_REPORT','Envio de Relatórios');
define('_AM_NEWBB_REPORT_PENDING','Pendentes');
define('_AM_NEWBB_REPORT_PROCESSED','Processados');

define('_AM_NEWBB_CREATETHEDIR','Criar Diretório');
define('_AM_NEWBB_SETMPERM','Alterar permissão');
define('_AM_NEWBB_DIRCREATED','O diretório foi criado');
define('_AM_NEWBB_DIRNOTCREATED','Não é possível a criação do diretório');
define('_AM_NEWBB_PERMSET','Permissão alterada alterada com sucesso');
define('_AM_NEWBB_PERMNOTSET','Não é possível a alteração da permissão');

define('_AM_NEWBB_DIGEST','Notificação de Informativo');
define('_AM_NEWBB_DIGEST_PAST','<font color="red">Deveria ter sido enviado há %d minutos</font>');
define('_AM_NEWBB_DIGEST_NEXT','Será enviado em %d minutos');
define('_AM_NEWBB_DIGEST_ARCHIVE','Arquivo de informativos');
define('_AM_NEWBB_DIGEST_SENT','Informativo processado');
define('_AM_NEWBB_DIGEST_FAILED','Informativo não processado');

// admin_forum_manager.php
define("_AM_NEWBB_NAME","Nome");
define("_AM_NEWBB_CREATEFORUM","Criar fórum");
define("_AM_NEWBB_EDIT","Editar");
define("_AM_NEWBB_CLEAR","Limpar");
define("_AM_NEWBB_DELETE","Excluir");
define("_AM_NEWBB_ADD","Incluir");
define("_AM_NEWBB_MOVE","Mover");
define("_AM_NEWBB_ORDER","Reordenar");
define("_AM_NEWBB_TWDAFAP","Nota: Será removido o Fórum e todas as suas mensagens.<br><br>ATENÇÃO: Você tem certeza que deseja a exclusão deste Fórum?");
define("_AM_NEWBB_FORUMREMOVED","Fórum excluído.");
define("_AM_NEWBB_CREATENEWFORUM","Incluir fórum");
define("_AM_NEWBB_EDITTHISFORUM","Editar fórum:");
define("_AM_NEWBB_SET_FORUMORDER","Ordem:");
define("_AM_NEWBB_ALLOWPOLLS","Permitir votações:");
define("_AM_NEWBB_ATTACHMENT_SIZE" ,"Tamanho máximo em Kbytes:");
define("_AM_NEWBB_ALLOWED_EXTENSIONS", "Extensões permitidas:<span style='font-size: xx-small; font-weight: normal; display: block;'>'*' indica ausência de restrições. Extensões separadas por |</span>");
//define("_AM_NEWBB_ALLOW_ATTACHMENTS", "Permitir anexos:");
define("_AM_NEWBB_ALLOWHTML","Permitir HTML:");
define("_AM_NEWBB_YES","Sim");
define("_AM_NEWBB_NO","Não");
define("_AM_NEWBB_ALLOWSIGNATURES","Permitir assinaturas:");
define("_AM_NEWBB_HOTTOPICTHRESHOLD","N° de tópicos para ser considerado como popular:");
//define("_AM_NEWBB_POSTPERPAGE","Posts per Page:<span style='font-size: xx-small; font-weight: normal; display: block;'>(This is the number of posts<br /> per topic that will be<br /> displayed per page.)</span>");
//define("_AM_NEWBB_TOPICPERFORUM","Topics per Forum:<span style='font-size: xx-small; font-weight: normal; display: block;'>(This is the number of topics<br /> per forum that will be<br /> displayed per page.)</span>");
//define("_AM_NEWBB_SHOWNAME","Replace user's name with real name:");
//define("_AM_NEWBB_SHOWICONSPANEL","Show icons panel:");
//define("_AM_NEWBB_SHOWSMILIESPANEL","Show smilies panel:");
define("_AM_NEWBB_MODERATOR_REMOVE","Excluir moderadores atuais");
define("_AM_NEWBB_MODERATOR_ADD","Incluir moderadores");
define("_AM_NEWBB_ALLOW_SUBJECT_PREFIX", "Permitir Prefixo no assunto para os Tópicos");
define("_AM_NEWBB_ALLOW_SUBJECT_PREFIX_DESC", "Isso permite um prefixo, que serão adicionados nos assuntos dos Tópicos");


// admin_cat_manager.php

define("_AM_NEWBB_SETCATEGORYORDER","Ordem:");
define("_AM_NEWBB_ACTIVE","Ativo");
define("_AM_NEWBB_INACTIVE","Inativo");
define("_AM_NEWBB_STATE","Status:");
define("_AM_NEWBB_CATEGORYDESC","Descrição:");
define("_AM_NEWBB_SHOWDESC","Exibir descrição?");
define("_AM_NEWBB_IMAGE","Imagem:");
//define("_AM_NEWBB_SPONSORIMAGE","Sponsor Image:");
define("_AM_NEWBB_SPONSORLINK","Link do patrocinador:");
define("_AM_NEWBB_DELCAT","Excluir categoria");
define("_AM_NEWBB_WAYSYWTDTTAL","Nota: Isto NÃO irá excluir os fóruns desta categoria, para isso você deverá usar o Gerenciador de Fóruns.<br /><br />ATENÇÃO: Você tem certeza que quer excluir esta categoria?");



//%%%%%%        File Name  admin_forums.php           %%%%%
define("_AM_NEWBB_FORUMNAME","Nome do fórum:");
define("_AM_NEWBB_FORUMDESCRIPTION","Descrição do fórum:");
define("_AM_NEWBB_MODERATOR","Moderador(es):");
define("_AM_NEWBB_REMOVE","Excluir");
define("_AM_NEWBB_CATEGORY","Nome da categoria:");
define("_AM_NEWBB_DATABASEERROR","Erro no banco de dados ");
define("_AM_NEWBB_CATEGORYUPDATED","Categoria atualizada.");
define("_AM_NEWBB_EDITCATEGORY","Editando categoria:");
define("_AM_NEWBB_CATEGORYTITLE","Título da categoria:");
define("_AM_NEWBB_CATEGORYCREATED","Categoria criada com sucesso!");
define("_AM_NEWBB_CREATENEWCATEGORY","Incluir nova categoria");
define("_AM_NEWBB_FORUMCREATED","Inclusão realizada com sucesso.");
define("_AM_NEWBB_ACCESSLEVEL","Nível de acesso:");
define("_AM_NEWBB_CATEGORY1","Categoria");
define("_AM_NEWBB_FORUMUPDATE","Atualização realizada com sucesso!");
define("_AM_NEWBB_FORUM_ERROR","ERRO: Erro na configuração de fórum");
define("_AM_NEWBB_CLICKBELOWSYNC","Clicar no botão abaixo irá sincronizar seus fóruns e as páginas de tópicos com os dados corretos do banco de dados. Use esta seção toda vez que verificar falhas nas listas de tópicos ou fóruns.");
define("_AM_NEWBB_SYNCHING","Sincronizando o índice do fórum e tópicos (pode demorar alguns minutos)");
define("_AM_NEWBB_CATEGORYDELETED","Categoria excluída.");
define("_AM_NEWBB_MOVE2CAT","Mover para categoria:");
define("_AM_NEWBB_MAKE_SUBFORUM_OF","Faça um subfórum de:");
define("_AM_NEWBB_MSG_FORUM_MOVED","Fórum movido!");
define("_AM_NEWBB_MSG_ERR_FORUM_MOVED","Erro ao mover fórum.");
define("_AM_NEWBB_SELECT","< Selecione >");
define("_AM_NEWBB_MOVETHISFORUM","Mover este fórum");
define("_AM_NEWBB_MERGE","Mesclar");
define("_AM_NEWBB_MERGETHISFORUM","Mesclar este fórum");
define("_AM_NEWBB_MERGETO_FORUM","Mesclar este fórum com:");
define("_AM_NEWBB_MSG_FORUM_MERGED","Fórum mesclado com sucesso!");
define("_AM_NEWBB_MSG_ERR_FORUM_MERGED","Operação de mesclagem não realizada.");

//%%%%%%        File Name  admin_forum_reorder.php           %%%%%
define("_AM_NEWBB_REORDERID","Id");
define("_AM_NEWBB_REORDERTITLE","Título");
define("_AM_NEWBB_REORDERWEIGHT","Posição");
define("_AM_NEWBB_SETFORUMORDER","Reordenar");
define("_AM_NEWBB_BOARDREORDER","As categorias e os fóruns foram reordenados com sucesso");

// admin_permission.php
define("_AM_NEWBB_PERMISSIONS_TO_THIS_FORUM","Permissões de tópico para este fórum");
define("_AM_NEWBB_CAT_ACCESS","Quem pode ver as categorias?");
define("_AM_NEWBB_CAN_ACCESS","Quem pode ver os fóruns?");
define("_AM_NEWBB_CAN_VIEW","Quem lerá os tópicos?");
define("_AM_NEWBB_CAN_POST","Quem pode enviar novos tópicos?");
define("_AM_NEWBB_CAN_REPLY","Quem pode responder tópicos?");
define("_AM_NEWBB_CAN_EDIT","Quem pode editar tópicos?");
define("_AM_NEWBB_CAN_DELETE","Quem pode excluir tópicos");
define("_AM_NEWBB_CAN_ADDPOLL","Quem pode criar enquetes?");
define("_AM_NEWBB_CAN_VOTE","Quem pode votar?");
define("_AM_NEWBB_CAN_ATTACH","Quem pode enviar arquivos?");
define("_AM_NEWBB_CAN_NOAPPROVE","Quem pode enviar sem aprovação?");
define("_AM_NEWBB_ACTION","Ação");

define("_AM_NEWBB_PERM_TEMPLATE","Modelo de Permissão");
define("_AM_NEWBB_PERM_TEMPLATE_DESC","Aplicar aos novos fóruns");
define("_AM_NEWBB_PERM_FORUMS","Selecionar fóruns");
define("_AM_NEWBB_PERM_TEMPLATE_CREATED","Modelo de permissão atualizada com sucesso.");
define("_AM_NEWBB_PERM_TEMPLATE_ERROR","Não é possível atualizar modelo de permissão");
define("_AM_NEWBB_PERM_TEMPLATEAPP","Aplicar modelo de permissão padrão");
define("_AM_NEWBB_PERM_TEMPLATE_APPLIED","Modelo de permissão aplicado com sucesso!");
define("_AM_NEWBB_PERM_ACTION","Gerenciamento de Permissões");
define("_AM_NEWBB_PERM_SETBYGROUP","Configurar permissões diretamente para o grupo");

// admin_forum_prune.php

define ("_AM_NEWBB_PRUNE_RESULTS_TITLE","Resultados da exclusão");
define ("_AM_NEWBB_PRUNE_RESULTS_TOPICS","Tópicos excluídos");
define ("_AM_NEWBB_PRUNE_RESULTS_POSTS","Mensagens excluídas");
define ("_AM_NEWBB_PRUNE_RESULTS_FORUMS","Fóruns excluídos");
define ("_AM_NEWBB_PRUNE_STORE","Ao invés da exclusão permanente, mover para o fórum:");
define ("_AM_NEWBB_PRUNE_ARCHIVE","Copiar as mensagens excluídas em arquivo?");
define ("_AM_NEWBB_PRUNE_FORUMSELERROR","Você deve selecionar o(s) fórum(s) para exclusão");

define ("_AM_NEWBB_PRUNE_DAYS","Excluir tópicos sem respostas a mais de:");
define ("_AM_NEWBB_PRUNE_FORUMS","Executar exclusões nos fóruns:");
define ("_AM_NEWBB_PRUNE_STICKY","Preservar tópicos fixos?");
define ("_AM_NEWBB_PRUNE_DIGEST","Preservar informativo dos tópicos?");
define ("_AM_NEWBB_PRUNE_LOCK","Preservar tópicos bloqueados?");
define ("_AM_NEWBB_PRUNE_HOT","Preservar tópicos com mais de quantas repostas?");
define ("_AM_NEWBB_PRUNE_SUBMIT","Ok!");
define ("_AM_NEWBB_PRUNE_RESET","Limpar");
define ("_AM_NEWBB_PRUNE_YES","Sim");
define ("_AM_NEWBB_PRUNE_NO","Não");
define ("_AM_NEWBB_PRUNE_WEEK","1 semana");
define ("_AM_NEWBB_PRUNE_2WEEKS","2 semanas");
define ("_AM_NEWBB_PRUNE_MONTH","1 mês");
define ("_AM_NEWBB_PRUNE_2MONTH","2 meses");
define ("_AM_NEWBB_PRUNE_4MONTH","4 meses");
define ("_AM_NEWBB_PRUNE_YEAR","1 ano");
define ("_AM_NEWBB_PRUNE_2YEARS","2 anos");

// About.php constants
define('_AM_NEWBB_AUTHOR_INFO', "Informações sobre o desenvolvedor");
define('_AM_NEWBB_AUTHOR_NAME', "Nome");
define('_AM_NEWBB_AUTHOR_WEBSITE', "Site");
define('_AM_NEWBB_AUTHOR_EMAIL', "e-mail");
define('_AM_NEWBB_AUTHOR_CREDITS', "Créditos");
define('_AM_NEWBB_MODULE_INFO', "Informações do desenvolvimento do módulo");
define('_AM_NEWBB_MODULE_STATUS', "Situação");
define('_AM_NEWBB_MODULE_DEMO', "Site Demonstração do Módulo");
define('_AM_NEWBB_MODULE_SUPPORT', "Site de Suporte Oficial");
define('_AM_NEWBB_MODULE_BUG', "Relate um bug deste módulo");
define('_AM_NEWBB_MODULE_FEATURE', "Sugerir uma nova característica para este módulo");
define('_AM_NEWBB_MODULE_DISCLAIMER', "Declaração de Isenção de Responsabilidade");
define('_AM_NEWBB_AUTHOR_WORD', "A palavra do desenvolvedor");
define('_AM_NEWBB_BY','por');
define('_AM_NEWBB_AUTHOR_WORD_EXTRA', "
");

// admin_report.php
define("_AM_NEWBB_REPORTADMIN","Relatórios");
define("_AM_NEWBB_PROCESSEDREPORT","Exibir relatórios processados");
define("_AM_NEWBB_PROCESSREPORT","Relatórios processados");
define("_AM_NEWBB_REPORTTITLE","Título");
define("_AM_NEWBB_REPORTEXTRA","Extra");
define("_AM_NEWBB_REPORTPOST","Relatórios");
define("_AM_NEWBB_REPORTTEXT","Texto");
define("_AM_NEWBB_REPORTMEMO","Nota");

// admin_report.php
define("_AM_NEWBB_DIGESTADMIN","Informativos");
define("_AM_NEWBB_DIGESTCONTENT","Conteúdo do Informativo");

// admin_votedata.php
define("_AM_NEWBB_VOTE_RATINGINFOMATION", "Enquetes");
define("_AM_NEWBB_VOTE_TOTALVOTES", "Total de votos: ");
define("_AM_NEWBB_VOTE_REGUSERVOTES", "Votos de usuários: %s");
define("_AM_NEWBB_VOTE_ANONUSERVOTES", "Votos de visitantes: %s");
define("_AM_NEWBB_VOTE_USER", "Usuário");
define("_AM_NEWBB_VOTE_IP", "IP");
define("_AM_NEWBB_VOTE_USERAVG", "Nota média");
define("_AM_NEWBB_VOTE_TOTALRATE", "N° de avaliações");
define("_AM_NEWBB_VOTE_DATE", "Data");
define("_AM_NEWBB_VOTE_RATING", "Avaliação");
define("_AM_NEWBB_VOTE_NOREGVOTES", "Nenhum voto de usuários");
define("_AM_NEWBB_VOTE_NOUNREGVOTES", "Nenhum voto de visitantes");
define("_AM_NEWBB_VOTEDELETED", "Avaliações excluídas.");
define("_AM_NEWBB_VOTE_ID", "Id");
define("_AM_NEWBB_VOTE_FILETITLE", "Tópico");
define("_AM_NEWBB_VOTE_DISPLAYVOTES", "Informações de Enquetes");
define("_AM_NEWBB_VOTE_NOVOTES", "Não há votos a exibir");
define("_AM_NEWBB_VOTE_DELETE", "Não há votos a excluir");
define("_AM_NEWBB_VOTE_DELETEDSC", "<strong>Exclui</strong> a avaliação escolhida do banco de dados.");

// admin_type_manager.php
//define("_AM_NEWBB_TYPE_ADD", "Adicionar Prefixo");
//define("_AM_NEWBB_TYPE_TEMPLATE", "Modelo de Prefixo");
//define("_AM_NEWBB_TYPE_TEMPLATE_APPLY", "Aplicar Prefixo");
//define("_AM_NEWBB_TYPE_FORUM", "Prefixo/Categoria de Forum");
//define("_AM_NEWBB_TYPE_NAME", "Nome do Prefixo");
//define("_AM_NEWBB_TYPE_COLOR", "Cor");
//define("_AM_NEWBB_TYPE_DESCRIPTION", "Descrição");
//define("_AM_NEWBB_TYPE_ORDER", "Ordem");
//define("_AM_NEWBB_TYPE_LIST", "Lista de Prefixo");
//define("_AM_NEWBB_TODEL_TYPE", "Tem a certeza que deseja apagar os Prefixos: [%s]?");
//define("_AM_NEWBB_TYPE_ORDER_DESC", "Para ativar o prefixo no fórum, coloque um valor maior que 0(zero); Em outras palavras, deixando em 0(zero) o prefixo permanecerá inativo no fórum..");


// admin_synchronization.php
//define("_AM_NEWBB_SYNC_TYPE_FORUM", "Dados do Forum");
//define("_AM_NEWBB_SYNC_TYPE_TOPIC", "Dados do Topicos");
//define("_AM_NEWBB_SYNC_TYPE_POST", "Dados da Mensagens");
//define("_AM_NEWBB_SYNC_TYPE_USER", "Dados do Usuários");
//define("_AM_NEWBB_SYNC_TYPE_STATS", "Stats Info");
//define("_AM_NEWBB_SYNC_TYPE_MISC", "Mesclar");

//define("_AM_NEWBB_SYNC_ITEMS", "Itens para cada ciclo: ");

//define("_AM_NEWBB_CAN_TYPE", "Pode ser usado o tipo de tópico");
//define("_AM_NEWBB_CAN_HTML", "Pode ser usado código HTML");
//define("_AM_NEWBB_CAN_SIGNATURE", "Pode ser usado assinatura");

?>