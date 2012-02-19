<?php
	// $Id$
	//%%%%%% File Name  index.php    %%%%%
	//$constpref = '_AM_' . strtoupper( basename( dirname(  dirname(  dirname( __FILE__ ) ) ) ) ) ;
	$constpref = '_AM_IFORUM';
	define($constpref."_FORUMCONF", "Configuração do fórum");
	define($constpref."_ADDAFORUM", "Criar um fórum");
	define($constpref."_SYNCFORUM", "Sincronizar Fóruns");
	define($constpref."_REORDERFORUM", "Reordenar");
	define($constpref."_FORUM_MANAGER", "Fóruns");
	define($constpref."_PRUNE_TITLE", "Exclusões");
	define($constpref."_CATADMIN", "Categorias");
	define($constpref."_GENERALSET", "Configurações Gerais" );
	define($constpref."_MODULEADMIN", "Aministração do Módulo:");
	define($constpref."_HELP", "Ajuda");
	define($constpref."_ABOUT", "Sobre");
	define($constpref."_BOARDSUMMARY", "Estatísticas");
	define($constpref."_PENDING_POSTS_FOR_AUTH", "Mensagens aguardando por aprovação");
	define($constpref."_POSTID", "Id");
	define($constpref."_POSTDATE", "Data");
	define($constpref."_POSTER", "Enviado por");
	define($constpref."_TOPICS", "Tópico");
	define($constpref."_SHORTSUMMARY", "Resumo");
	define($constpref."_TOTALPOSTS", "Mensagens");
	define($constpref."_TOTALTOPICS", "Tópicos");
	define($constpref."_TOTALVIEWS", "Leituras");
	define($constpref."_BLOCKS", "Blocos");
	define($constpref."_SUBJECT", "Assunto");
	define($constpref."_APPROVE", "Aprovar");
	define($constpref."_APPROVETEXT", "Contéudo desta mensagem");
	define($constpref."_POSTAPPROVED", "Mensagem aprovada");
	define($constpref."_POSTNOTAPPROVED", "Mensagem não foi aprovada");
	define($constpref."_POSTSAVED", "Mensagem salva");
	define($constpref."_POSTNOTSAVED", "Mensagem não foi salva");
	 
	define($constpref."_TOPICAPPROVED", "Tópico aprovado");
	define($constpref."_TOPICNOTAPPROVED", "Tópico não foi aprovado");
	define($constpref."_TOPICID", "Id");
	define($constpref."_ORPHAN_TOPICS_FOR_AUTH", "Tópicos aguardando aprovação");
	 
	 
	define($constpref.'_DEL_ONE', 'Excluir apenas esta mensagem');
	define($constpref.'_POSTSDELETED', 'Mensagem selecionada foi excluída.');
	define($constpref.'_NOAPPROVEPOST', 'Não há mensagens aguardando aprovação.');
	define($constpref.'_SUBJECTC', 'Assunto:');
	define($constpref.'_MESSAGEICON', 'Ícone da mensagem:');
	define($constpref.'_MESSAGEC', 'Mensagem:');
	define($constpref.'_CANCELPOST', 'Cancelar');
	define($constpref.'_GOTOMOD', 'Ir para o Módulo');
	 
	define($constpref.'_PREFERENCES', 'Preferências');
	define($constpref.'_POLLMODULE', 'Módulo XoopsPoll (Enquetes)');
	define($constpref.'_POLL_OK', 'Disponível para uso');
	define($constpref.'_GDLIB1', 'Biblioteca GD1:');
	define($constpref.'_GDLIB2', 'Biblioteca GD2:');
	define($constpref.'_AUTODETECTED', 'Disponível: ');
	define($constpref.'_AVAILABLE', 'Disponível');
	define($constpref.'_NOTAVAILABLE', '<font color="red">Indisponível</font>');
	define($constpref.'_NOTWRITABLE', '<font color="red">Não tem permissão para gravação</font>');
	define($constpref.'_IMAGEMAGICK', 'ImageMagick:');
	define($constpref.'_IMAGEMAGICK_NOTSET', 'Não configurado');
	define($constpref.'_ATTACHPATH', 'Diretório para anexos');
	define($constpref.'_THUMBPATH', 'Diretório para miniaturas');
	//define($constpref.'_RSSPATH','Path for RSS feed');
	define($constpref.'_REPORT', 'Envio de Relatórios');
	define($constpref.'_REPORT_PENDING', 'Pendentes');
	define($constpref.'_REPORT_PROCESSED', 'Processados');
	 
	define($constpref.'_CREATETHEDIR', 'Criar Diretório');
	define($constpref.'_SETMPERM', 'Alterar permissão');
	define($constpref.'_DIRCREATED', 'O diretório foi criado');
	define($constpref.'_DIRNOTCREATED', 'Não é possível a criação do diretório');
	define($constpref.'_PERMSET', 'Permissão alterada alterada com sucesso');
	define($constpref.'_PERMNOTSET', 'Não é possível a alteração da permissão');
	 
	define($constpref.'_DIGEST', 'Notificação de Informativo');
	define($constpref.'_DIGEST_PAST', '<font color="red">Deveria ter sido enviado há %d minutos</font>');
	define($constpref.'_DIGEST_NEXT', 'Será enviado em %d minutos');
	define($constpref.'_DIGEST_ARCHIVE', 'Arquivo de informativos');
	define($constpref.'_DIGEST_SENT', 'Informativo processado');
	define($constpref.'_DIGEST_FAILED', 'Informativo não processado');
	 
	// admin_forum_manager.php
	define($constpref."_NAME", "Nome");
	define($constpref."_CREATEFORUM", "Criar fórum");
	define($constpref."_EDIT", "Editar");
	define($constpref."_CLEAR", "Limpar");
	define($constpref."_DELETE", "Excluir");
	define($constpref."_ADD", "Incluir");
	define($constpref."_MOVE", "Mover");
	define($constpref."_ORDER", "Reordenar");
	define($constpref."_TWDAFAP", "Nota: Será removido o Fórum e todas as suas mensagens.<br><br>ATENÇÃO: Você tem certeza que deseja a exclusão deste Fórum?");
	define($constpref."_FORUMREMOVED", "Fórum excluído.");
	define($constpref."_CREATENEWFORUM", "Incluir fórum");
	define($constpref."_EDITTHISFORUM", "Editar fórum:");
	define($constpref."_SET_FORUMORDER", "Ordem:");
	define($constpref."_ALLOWPOLLS", "Permitir votações:");
	define($constpref."_ATTACHMENT_SIZE" , "Tamanho máximo em Kbytes:");
	define($constpref."_ALLOWED_EXTENSIONS", "Extensões permitidas:<span style='font-size: xx-small; font-weight: normal; display: block;'>'*' indica ausência de restrições. Extensões separadas por |</span>");
	//define($constpref."_ALLOW_ATTACHMENTS", "Permitir anexos:");
	define($constpref."_ALLOWHTML", "Permitir HTML:");
	define($constpref."_YES", "Sim");
	define($constpref."_NO", "Não");
	define($constpref."_ALLOWSIGNATURES", "Permitir assinaturas:");
	define($constpref."_HOTTOPICTHRESHOLD", "N° de tópicos para ser considerado como popular:");
	//define($constpref."_POSTPERPAGE","Posts per Page:<span style='font-size: xx-small; font-weight: normal; display: block;'>(This is the number of posts<br /> per topic that will be<br /> displayed per page.)</span>");
	//define($constpref."_TOPICPERFORUM","Topics per Forum:<span style='font-size: xx-small; font-weight: normal; display: block;'>(This is the number of topics<br /> per forum that will be<br /> displayed per page.)</span>");
	//define($constpref."_SHOWNAME","Replace user's name with real name:");
	//define($constpref."_SHOWICONSPANEL","Show icons panel:");
	//define($constpref."_SHOWSMILIESPANEL","Show smilies panel:");
	define($constpref."_MODERATOR_REMOVE", "Excluir moderadores atuais");
	define($constpref."_MODERATOR_ADD", "Incluir moderadores");
	define($constpref."_ALLOW_SUBJECT_PREFIX", "Permitir Prefixo no assunto para os Tópicos");
	define($constpref."_ALLOW_SUBJECT_PREFIX_DESC", "Isso permite um prefixo, que serão adicionados nos assuntos dos Tópicos");
	 
	 
	// admin_cat_manager.php
	 
	define($constpref."_SETCATEGORYORDER", "Ordem:");
	define($constpref."_ACTIVE", "Ativo");
	define($constpref."_INACTIVE", "Inativo");
	define($constpref."_STATE", "Status:");
	define($constpref."_CATEGORYDESC", "Descrição:");
	define($constpref."_SHOWDESC", "Exibir descrição?");
	define($constpref."_IMAGE", "Imagem:");
	//define($constpref."_SPONSORIMAGE","Sponsor Image:");
	define($constpref."_SPONSORLINK", "Link do patrocinador:");
	define($constpref."_DELCAT", "Excluir categoria");
	define($constpref."_WAYSYWTDTTAL", "Nota: Isto NÃO irá excluir os fóruns desta categoria, para isso você deverá usar o Gerenciador de Fóruns.<br /><br />ATENÇÃO: Você tem certeza que quer excluir esta categoria?");
	 
	 
	 
	//%%%%%%        File Name  admin_forums.php           %%%%%
	define($constpref."_FORUMNAME", "Nome do fórum:");
	define($constpref."_FORUMDESCRIPTION", "Descrição do fórum:");
	define($constpref."_MODERATOR", "Moderador(es):");
	define($constpref."_REMOVE", "Excluir");
	define($constpref."_CATEGORY", "Nome da categoria:");
	define($constpref."_DATABASEERROR", "Erro no banco de dados ");
	define($constpref."_CATEGORYUPDATED", "Categoria atualizada.");
	define($constpref."_EDITCATEGORY", "Editando categoria:");
	define($constpref."_CATEGORYTITLE", "Título da categoria:");
	define($constpref."_CATEGORYCREATED", "Categoria criada com sucesso!");
	define($constpref."_CREATENEWCATEGORY", "Incluir nova categoria");
	define($constpref."_FORUMCREATED", "Inclusão realizada com sucesso.");
	define($constpref."_ACCESSLEVEL", "Nível de acesso:");
	define($constpref."_CATEGORY1", "Categoria");
	define($constpref."_FORUMUPDATE", "Atualização realizada com sucesso!");
	define($constpref."_FORUM_ERROR", "ERRO: Erro na configuração de fórum");
	define($constpref."_CLICKBELOWSYNC", "Clicar no botão abaixo irá sincronizar seus fóruns e as páginas de tópicos com os dados corretos do banco de dados. Use esta seção toda vez que verificar falhas nas listas de tópicos ou fóruns.");
	define($constpref."_SYNCHING", "Sincronizando o índice do fórum e tópicos (pode demorar alguns minutos)");
	define($constpref."_CATEGORYDELETED", "Categoria excluída.");
	define($constpref."_MOVE2CAT", "Mover para categoria:");
	define($constpref."_MAKE_SUBFORUM_OF", "Faça um subfórum de:");
	define($constpref."_MSG_FORUM_MOVED", "Fórum movido!");
	define($constpref."_MSG_ERR_FORUM_MOVED", "Erro ao mover fórum.");
	define($constpref."_SELECT", "< Selecione >");
	define($constpref."_MOVETHISFORUM", "Mover este fórum");
	define($constpref."_MERGE", "Mesclar");
	define($constpref."_MERGETHISFORUM", "Mesclar este fórum");
	define($constpref."_MERGETO_FORUM", "Mesclar este fórum com:");
	define($constpref."_MSG_FORUM_MERGED", "Fórum mesclado com sucesso!");
	define($constpref."_MSG_ERR_FORUM_MERGED", "Operação de mesclagem não realizada.");
	 
	//%%%%%%        File Name  admin_forum_reorder.php           %%%%%
	define($constpref."_REORDERID", "Id");
	define($constpref."_REORDERTITLE", "Título");
	define($constpref."_REORDERWEIGHT", "Posição");
	define($constpref."_SETFORUMORDER", "Reordenar");
	define($constpref."_BOARDREORDER", "As categorias e os fóruns foram reordenados com sucesso");
	 
	// admin_permission.php
	define($constpref."_PERMISSIONS_TO_THIS_FORUM", "Permissões de tópico para este fórum");
	define($constpref."_CAT_ACCESS", "Quem pode ver as categorias?");
	define($constpref."_CAN_ACCESS", "Quem pode ver os fóruns?");
	define($constpref."_CAN_VIEW", "Quem lerá os tópicos?");
	define($constpref."_CAN_POST", "Quem pode enviar novos tópicos?");
	define($constpref."_CAN_REPLY", "Quem pode responder tópicos?");
	define($constpref."_CAN_EDIT", "Quem pode editar tópicos?");
	define($constpref."_CAN_DELETE", "Quem pode excluir tópicos");
	define($constpref."_CAN_ADDPOLL", "Quem pode criar enquetes?");
	define($constpref."_CAN_VOTE", "Quem pode votar?");
	define($constpref."_CAN_ATTACH", "Quem pode enviar arquivos?");
	define($constpref."_CAN_NOAPPROVE", "Quem pode enviar sem aprovação?");
	define($constpref."_ACTION", "Ação");
	 
	define($constpref."_PERM_TEMPLATE", "Modelo de Permissão");
	define($constpref."_PERM_TEMPLATE_DESC", "Aplicar aos novos fóruns");
	define($constpref."_PERM_FORUMS", "Selecionar fóruns");
	define($constpref."_PERM_TEMPLATE_CREATED", "Modelo de permissão atualizada com sucesso.");
	define($constpref."_PERM_TEMPLATE_ERROR", "Não é possível atualizar modelo de permissão");
	define($constpref."_PERM_TEMPLATEAPP", "Aplicar modelo de permissão padrão");
	define($constpref."_PERM_TEMPLATE_APPLIED", "Modelo de permissão aplicado com sucesso!");
	define($constpref."_PERM_ACTION", "Gerenciamento de Permissões");
	define($constpref."_PERM_SETBYGROUP", "Configurar permissões diretamente para o grupo");
	 
	// admin_forum_prune.php
	 
	define($constpref."_PRUNE_RESULTS_TITLE", "Resultados da exclusão");
	define($constpref."_PRUNE_RESULTS_TOPICS", "Tópicos excluídos");
	define($constpref."_PRUNE_RESULTS_POSTS", "Mensagens excluídas");
	define($constpref."_PRUNE_RESULTS_FORUMS", "Fóruns excluídos");
	define($constpref."_PRUNE_STORE", "Ao invés da exclusão permanente, mover para o fórum:");
	define($constpref."_PRUNE_ARCHIVE", "Copiar as mensagens excluídas em arquivo?");
	define($constpref."_PRUNE_FORUMSELERROR", "Você deve selecionar o(s) fórum(s) para exclusão");
	 
	define($constpref."_PRUNE_DAYS", "Excluir tópicos sem respostas a mais de:");
	define($constpref."_PRUNE_FORUMS", "Executar exclusões nos fóruns:");
	define($constpref."_PRUNE_STICKY", "Preservar tópicos fixos?");
	define($constpref."_PRUNE_DIGEST", "Preservar informativo dos tópicos?");
	define($constpref."_PRUNE_LOCK", "Preservar tópicos bloqueados?");
	define($constpref."_PRUNE_HOT", "Preservar tópicos com mais de quantas repostas?");
	define($constpref."_PRUNE_SUBMIT", "Ok!");
	define($constpref."_PRUNE_RESET", "Limpar");
	define($constpref."_PRUNE_YES", "Sim");
	define($constpref."_PRUNE_NO", "Não");
	define($constpref."_PRUNE_WEEK", "1 semana");
	define($constpref."_PRUNE_2WEEKS", "2 semanas");
	define($constpref."_PRUNE_MONTH", "1 mês");
	define($constpref."_PRUNE_2MONTH", "2 meses");
	define($constpref."_PRUNE_4MONTH", "4 meses");
	define($constpref."_PRUNE_YEAR", "1 ano");
	define($constpref."_PRUNE_2YEARS", "2 anos");
	 
	// About.php constants
	define($constpref.'_AUTHOR_INFO', "Informações sobre o desenvolvedor");
	define($constpref.'_AUTHOR_NAME', "Nome");
	define($constpref.'_AUTHOR_WEBSITE', "Site");
	define($constpref.'_AUTHOR_EMAIL', "e-mail");
	define($constpref.'_AUTHOR_CREDITS', "Créditos");
	define($constpref.'_MODULE_INFO', "Informações do desenvolvimento do módulo");
	define($constpref.'_MODULE_STATUS', "Situação");
	define($constpref.'_MODULE_DEMO', "Site Demonstração do Módulo");
	define($constpref.'_MODULE_SUPPORT', "Site de Suporte Oficial");
	define($constpref.'_MODULE_BUG', "Relate um bug deste módulo");
	define($constpref.'_MODULE_FEATURE', "Sugerir uma nova característica para este módulo");
	define($constpref.'_MODULE_DISCLAIMER', "Declaração de Isenção de Responsabilidade");
	define($constpref.'_AUTHOR_WORD', "A palavra do desenvolvedor");
	define($constpref.'_BY', 'por');
	define($constpref.'_AUTHOR_WORD_EXTRA', "
		");
	 
	// admin_report.php
	define($constpref."_REPORTADMIN", "Relatórios");
	define($constpref."_PROCESSEDREPORT", "Exibir relatórios processados");
	define($constpref."_PROCESSREPORT", "Relatórios processados");
	define($constpref."_REPORTTITLE", "Título");
	define($constpref."_REPORTEXTRA", "Extra");
	define($constpref."_REPORTPOST", "Relatórios");
	define($constpref."_REPORTTEXT", "Texto");
	define($constpref."_REPORTMEMO", "Nota");
	 
	// admin_report.php
	define($constpref."_DIGESTADMIN", "Informativos");
	define($constpref."_DIGESTCONTENT", "Conteúdo do Informativo");
	 
	// admin_votedata.php
	define($constpref."_VOTE_RATINGINFOMATION", "Enquetes");
	define($constpref."_VOTE_TOTALVOTES", "Total de votos: ");
	define($constpref."_VOTE_REGUSERVOTES", "Votos de usuários: %s");
	define($constpref."_VOTE_ANONUSERVOTES", "Votos de visitantes: %s");
	define($constpref."_VOTE_USER", "Usuário");
	define($constpref."_VOTE_IP", "IP");
	define($constpref."_VOTE_USERAVG", "Nota média");
	define($constpref."_VOTE_TOTALRATE", "N° de avaliações");
	define($constpref."_VOTE_DATE", "Data");
	define($constpref."_VOTE_RATING", "Avaliação");
	define($constpref."_VOTE_NOREGVOTES", "Nenhum voto de usuários");
	define($constpref."_VOTE_NOUNREGVOTES", "Nenhum voto de visitantes");
	define($constpref."_VOTEDELETED", "Avaliações excluídas.");
	define($constpref."_VOTE_ID", "Id");
	define($constpref."_VOTE_FILETITLE", "Tópico");
	define($constpref."_VOTE_DISPLAYVOTES", "Informações de Enquetes");
	define($constpref."_VOTE_NOVOTES", "Não há votos a exibir");
	define($constpref."_VOTE_DELETE", "Não há votos a excluir");
	define($constpref."_VOTE_DELETEDSC", "<strong>Exclui</strong> a avaliação escolhida do banco de dados.");
	 
	// admin_type_manager.php
	//define($constpref."_TYPE_ADD", "Adicionar Prefixo");
	//define($constpref."_TYPE_TEMPLATE", "Modelo de Prefixo");
	//define($constpref."_TYPE_TEMPLATE_APPLY", "Aplicar Prefixo");
	//define($constpref."_TYPE_FORUM", "Prefixo/Categoria de Forum");
	//define($constpref."_TYPE_NAME", "Nome do Prefixo");
	//define($constpref."_TYPE_COLOR", "Cor");
	//define($constpref."_TYPE_DESCRIPTION", "Descrição");
	//define($constpref."_TYPE_ORDER", "Ordem");
	//define($constpref."_TYPE_LIST", "Lista de Prefixo");
	//define($constpref."_TODEL_TYPE", "Tem a certeza que deseja apagar os Prefixos: [%s]?");
	//define($constpref."_TYPE_ORDER_DESC", "Para ativar o prefixo no fórum, coloque um valor maior que 0(zero); Em outras palavras, deixando em 0(zero) o prefixo permanecerá inativo no fórum..");
	 
	 
	// admin_synchronization.php
	//define($constpref."_SYNC_TYPE_FORUM", "Dados do Forum");
	//define($constpref."_SYNC_TYPE_TOPIC", "Dados do Topicos");
	//define($constpref."_SYNC_TYPE_POST", "Dados da Mensagens");
	//define($constpref."_SYNC_TYPE_USER", "Dados do Usuários");
	//define($constpref."_SYNC_TYPE_STATS", "Stats Info");
	//define($constpref."_SYNC_TYPE_MISC", "Mesclar");
	 
	//define($constpref."_SYNC_ITEMS", "Itens para cada ciclo: ");
	 
	//define($constpref."_CAN_TYPE", "Pode ser usado o tipo de tópico");
	//define($constpref."_CAN_HTML", "Pode ser usado código HTML");
	//define($constpref."_CAN_SIGNATURE", "Pode ser usado assinatura");
	 
?>