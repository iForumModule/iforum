<?php
	// $Id$
	// Blocks
	if (defined('_MB_IFORUM_DEFINED')) return;
	else define('_MB_IFORUM_DEFINED', true);
	//$constpref = '_MB_' . strtoupper( basename( dirname(  dirname(  dirname( __FILE__ ) ) ) ) ) ;
	$constpref = '_MB_IFORUM';
	 
	define($constpref."_FORUM", "Fórum");
	define($constpref."_TOPIC", "Tópico");
	define($constpref."_RPLS", "Respostas");
	define($constpref."_VIEWS", "Leituras");
	define($constpref."_LPOST", "Última mensagem");
	define($constpref."_VSTFRMS", "Fóruns");
	define($constpref."_DISPLAY", "Exibir %s mensagens: ");
	define($constpref."_DISPLAYMODE", "Modo de exibição: ");
	define($constpref."_DISPLAYMODE_FULL", "Completo");
	define($constpref."_DISPLAYMODE_COMPACT", "Compacto");
	define($constpref."_DISPLAYMODE_LITE", "Simples");
	define($constpref."_FORUMLIST", "Filtro de exibição:");
	//define($constpref."_FORUMLIST_DESC","Forums allowed to display in the block");
	//define($constpref."_FORUMLIST_ID","ID");
	//define($constpref."_FORUMLIST_NAME","Forum name");
	define($constpref."_ALLTOPICS", "Tópicos");
	define($constpref."_ALLPOSTS", "Mensagens");
	 
	define($constpref."_CRITERIA", "Critério de exibição: ");
	define($constpref."_CRITERIA_TOPIC", "Tópicos");
	define($constpref."_CRITERIA_POST", "Respostas");
	define($constpref."_CRITERIA_TIME", "Mais recentes");
	define($constpref."_CRITERIA_TITLE", "Titulo da mensagem");
	define($constpref."_CRITERIA_TEXT", "Texto da mensagem");
	define($constpref."_CRITERIA_VIEWS", "Mais lidas");
	define($constpref."_CRITERIA_REPLIES", "Mais respostas");
	define($constpref."_CRITERIA_DIGEST", "Mais recentes no informativo");
	define($constpref."_CRITERIA_STICKY", "Mais recentes fixadas");
	define($constpref."_CRITERIA_DIGESTS", "Mais recentes no informativo");
	//
	define($constpref."_CRITERIA_STICKYS", "Mais fixadas");
	//
	define($constpref."_TIME", "Período de tempo: ");
	define($constpref."_TIME_DESC", "Positivo para dias e negativo para horas");
	 
	define($constpref."_TITLE", "Título");
	define($constpref."_AUTHOR", "Autor");
	define($constpref."_COUNT", "Quantidade");
	define($constpref."_INDEXNAV", "Exibir caixa de seleção? ");
	 
	define($constpref."_TITLE_LENGTH", "Largura do título");
?>