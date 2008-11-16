<?php
// $Id: main.php,v 1.3 2005/10/19 17:20:33 phppp Exp $
if(defined('MAIN_DEFINED')) return;
define('MAIN_DEFINED',true);

define('_MD_ERROR','Erro');
define('_MD_NOPOSTS','Nenhuma mensagem');
define('_MD_GO','Enviar');
define('_MD_SELFORUM','Selecione um fórum');

define('_MD_THIS_FILE_WAS_ATTACHED_TO_THIS_POST','Arquivo anexado:');
define('_MD_ALLOWED_EXTENSIONS','Extensões permitidas');
define('_MD_MAX_FILESIZE','Tamanho máximo de arquivo');
define('_MD_ATTACHMENT','Anexar arquivo');
define('_MD_FILESIZE','Tamanho');
define('_MD_HITS','Acessos');
define('_MD_GROUPS','Grupos:');
define('_MD_DEL_ONE','Excluir apenas esta mensagem');
define('_MD_DEL_RELATED','Excluir todas as mensagens deste tópico');
define('_MD_MARK_ALL_FORUMS','Marcar todos os fóruns como');
define('_MD_MARK_ALL_TOPICS','Marcar todos os tópicos como');
define('_MD_MARK_UNREAD','não lidos');
define('_MD_MARK_READ','lidos');
define('_MD_ALL_FORUM_MARKED','Todos os fóruns marcados como');
define('_MD_ALL_TOPIC_MARKED','Todos os tópicos marcados como');
define('_MD_BOARD_DISCLAIMER','Declaração de Isenção de Responsabilidade');


//index.php
define('_MD_ADMINCP','Administração');
define('_MD_FORUM','Fórum');
define('_MD_WELCOME','Bem-vindo ao Fórum %s .');
define('_MD_TOPICS','Tópicos');
define('_MD_POSTS','Mensagens');
define('_MD_LASTPOST','Última Mensagem');
define('_MD_MODERATOR','Moderador');
define('_MD_NEWPOSTS','Novas mensagens');
define('_MD_NONEWPOSTS','Sem novas mensagens');
define('_MD_PRIVATEFORUM','Fórum privativo');
define('_MD_BY','por'); // Posted by
define('_MD_TOSTART','Para acessar as mensagens, selecione abaixo o fórum que deseja visitar.');
define('_MD_TOTALTOPICSC','Tópicos: ');
define('_MD_TOTALPOSTSC','Mensagens: ');
define('_MD_TOTALUSER','Usuários: ');
define('_MD_TIMENOW','Data e hora atual: %s');
define('_MD_USER_LASTVISIT','Última visita: %s');
define('_MD_ADVSEARCH','Busca Avançada');
define('_MD_POSTEDON','Enviado em: ');
define('_MD_SUBJECT','Assunto');
define('_MD_INACTIVEFORUM_NEWPOSTS','Fórum inativo com novas mensagens');
define('_MD_INACTIVEFORUM_NONEWPOSTS','Fórum inativo sem novas mensagens');
define('_MD_SUBFORUMS','Subfóruns');
define('_MD_MAINFORUMOPT', 'Opções');
define("_MD_PENDING_POSTS_FOR_AUTH","Mensagens aguardando aprovação:");



//page_header.php
define('_MD_MODERATEDBY','Moderado por');
define('_MD_SEARCH','Procurar');
//define('_MD_SEARCHRESULTS','Search Results');
define('_MD_FORUMINDEX','Índice do Fórum %s');
define('_MD_POSTNEW','Novo tópico');
define('_MD_REGTOPOST','Registre-se para enviar mensagens');

//search.php
define('_MD_SEARCHALLFORUMS','Todos');
define('_MD_FORUMC','Fórum:');
define('_MD_AUTHORC','Autor:');
define('_MD_SORTBY','Ordenar por:');
define('_MD_DATE','Última <br>Mensagem');
define('_MD_TOPIC','Tópico');
define('_MD_POST2','Msg');
define('_MD_USERNAME','Usuário');
define('_MD_BODY','Mensagem');
define('_MD_SINCE','Desde');

//viewforum.php
define('_MD_REPLIES','Respostas');
define('_MD_POSTER','Autor');
define('_MD_VIEWS','Leituras');
define('_MD_MORETHAN','Novas mensagens [Popular]');
define('_MD_MORETHAN2','Sem novas mensagens  [Popular]');
define('_MD_TOPICSHASATT','Tópico com anexo(s)');
define('_MD_TOPICHASPOLL','Tópico com votação');
define('_MD_TOPICLOCKED','Tópico bloqueado');
define('_MD_LEGEND','Legenda');
define('_MD_NEXTPAGE','Próxima página');
define('_MD_SORTEDBY','Ordenado por');
define('_MD_TOPICTITLE','Título do tópico');
define('_MD_NUMBERREPLIES','Respostas');
define('_MD_TOPICPOSTER','Autor do tópico');
define('_MD_TOPICTIME','Data<br>Hora');
define('_MD_LASTPOSTTIME','Data da última mensagem');
define('_MD_ASCENDING','Ordem ascendente');
define('_MD_DESCENDING','Ordem descendente');
define('_MD_FROMLASTHOURS','Das últimas %s horas');
define('_MD_FROMLASTDAYS','Dos últimos %s dias');
define('_MD_THELASTYEAR','Do ano passado');
define('_MD_BEGINNING','Desde o início');
define('_MD_SEARCHTHISFORUM', 'Procurar neste fórum');
define('_MD_TOPIC_SUBJECTC','Prefixo:');


define('_MD_RATINGS','Avaliações');
define("_MD_CAN_ACCESS", "Você <b>pode</b> acessar o fórum.<br />");
define("_MD_CANNOT_ACCESS", "Você <b>não pode</b> acessar o fórum.<br />");
define("_MD_CAN_POST", "Você <b>pode</b> iniciar um novo tópico.<br />");
define("_MD_CANNOT_POST", "Você <b>não pode</b> iniciar um novo tópico.<br />");
define("_MD_CAN_VIEW", "Você <b>pode</b> exibir os tópicos.<br />");
define("_MD_CANNOT_VIEW", "Você <b>não pode</b> exibir os tópicos.<br />");
define("_MD_CAN_REPLY", "Você <b>pode</b> responder.<br>");
define("_MD_CANNOT_REPLY", "Você <b>não pode</b> responder.<br>");
define("_MD_CAN_EDIT", "Você <b>pode</b> editar.<br>");
define("_MD_CANNOT_EDIT", "Você <b>não pode</b> editar.<br>");
define("_MD_CAN_DELETE", "Você <b>pode</b> excluir mensagens.<br>");
define("_MD_CANNOT_DELETE", "Você <b>não pode</b> excluir mensagens.<br>");
define("_MD_CAN_ADDPOLL", "Você <b>pode</b> incluir votações.<br>");
define("_MD_CANNOT_ADDPOLL", "Você <b>não pode</b> incluir votações.<br>");
define("_MD_CAN_VOTE", "Você <b>pode</b> votar.<br>");
define("_MD_CANNOT_VOTE", "Você <b>não pode</b> votar.<br>");
define("_MD_CAN_ATTACH", "Você <b>pode</b> anexar arquivos.<br>");
define("_MD_CANNOT_ATTACH", "Você <b>não pode</b> anexar arquivos.<br>");
define("_MD_CAN_NOAPPROVE", "Você <b>pode</b> enviar mensagens sem aprovação.<br>");
define("_MD_CANNOT_NOAPPROVE", "Você <b>não pode</b> enviar mensagens sem aprovação.<br>");
define("_MD_IMTOPICS","Tópicos importantes");
define("_MD_NOTIMTOPICS","Tópicos do fórum");
define('_MD_FORUMOPTION', 'Opções');

define('_MD_VAUP','Ver todas as mensagens não respondidas');
define('_MD_VANP','Ver todos as novas mensagens');


define('_MD_UNREPLIED','Tópicos sem resposta');
define('_MD_UNREAD','Tópicos não lidos');
define('_MD_ALL','Todos os tópicos');
define('_MD_ALLPOSTS','Todas as mensagens');
define('_MD_VIEW','Exibir');

//viewtopic.php
define('_MD_AUTHOR','Autor');
define('_MD_LOCKTOPIC','Bloquear este tópico');
define('_MD_UNLOCKTOPIC','Desbloquear este tópico');
define('_MD_UNSTICKYTOPIC','Desfixar este tópico');
define('_MD_STICKYTOPIC','Fixar este tópico');
define('_MD_DIGESTTOPIC','Incluir no Informativo');
define('_MD_UNDIGESTTOPIC','Retirar do Informativo');
define('_MD_MERGETOPIC','Mesclar este tópico');
define('_MD_MOVETOPIC','Mover este tópico');
define('_MD_DELETETOPIC','Excluir este tópico');
define('_MD_TOP','Topo');
define('_MD_BOTTOM','Final');
define('_MD_PREVTOPIC','Tópico anterior');
define('_MD_NEXTTOPIC','Próximo tópico');
define('_MD_GROUP','Grupo:');
define('_MD_QUICKREPLY','Resposta rápida');
define('_MD_POSTREPLY','Responder');
define('_MD_PRINTTOPICS','Imprimir');
define('_MD_PRINT','Imprimir');
define('_MD_REPORT','Enviar ao Moderador');
define('_MD_PM','MP');
define('_MD_EMAIL','e-mail');
define('_MD_WWW','WWW');
define('_MD_AIM','AOL');
define('_MD_YIM','Yahoo!');
define('_MD_MSNM','MSN');
define('_MD_ICQ','ICQ');
define('_MD_PRINT_TOPIC_LINK', 'URL para esta discussão');
define('_MD_ADDTOLIST','Adicione à sua Lista de Contatos');
define('_MD_TOPICOPT', 'Opções');
define('_MD_VIEWMODE', 'Visualização');
define('_MD_NEWEST', 'Novos primeiro');
define('_MD_OLDEST', 'Antigos primeiro');

define('_MD_FORUMSEARCH','Procurar');

define('_MD_RATED','Avaliado:');
define('_MD_RATE','Avaliar tópico');
define('_MD_RATEDESC','Avalie este tópico');
define('_MD_RATING','Enviar');
define('_MD_RATE1','Péssimo');
define('_MD_RATE2','Ruim');
define('_MD_RATE3','Regular');
define('_MD_RATE4','Bom');
define('_MD_RATE5','Excelente');

define('_MD_TOPICOPTION','Opções');
define('_MD_KARMA_REQUIREMENT', 'Seu Karma atual é %s e o karma requerido é %s. <br /> Favor tentar mais tarde.');
define('_MD_REPLY_REQUIREMENT', 'Para exibir esta mensagem, você precisa enviar antes a sua resposta.');
define('_MD_TOPICOPTIONADMIN','Administração do tópico');
define('_MD_POLLOPTIONADMIN','Administração de votações');

define('_MD_EDITPOLL','Editar esta votação');
define('_MD_DELETEPOLL','Excluir esta votação');
define('_MD_RESTARTPOLL','Reativar esta votação');
define('_MD_ADDPOLL','Incluir uma votação');

define('_MD_QUICKREPLY_EMPTY','Digite uma resposta rápida aqui');

define('_MD_LEVEL','Nível :');
define('_MD_HP','HP :');
define('_MD_MP','MP :');
define('_MD_EXP','EXP :');

define('_MD_BROWSING','Navegando neste Tópico:');
define('_MD_POSTTONEWS','Enviar este tópico para Notícias');

define('_MD_EXCEEDTHREADVIEW','Quantidade de mensagens excede o limite para visão expandida<br />Alterando para modo agrupado');


//forumform.inc
define('_MD_PRIVATE','Este é um fórum <strong>privativo</b>.</b>Somente usuários com acesso especial podem acessá-lo.');
define('_MD_QUOTE','Citar');
define('_MD_VIEW_REQUIRE','Exibir requisitos');
define('_MD_REQUIRE_KARMA','Karma');
define('_MD_REQUIRE_REPLY','Resposta');
define('_MD_REQUIRE_NULL','Sem requisitos');

define("_MD_SELECT_FORMTYPE","Selecione o modelo de formulário");

define("_MD_FORM_COMPACT","Compacto");
define("_MD_FORM_DHTML","DHTML");
define("_MD_FORM_SPAW","Spaw Editor");
define("_MD_FORM_HTMLAREA","HTMLArea");
define("_MD_FORM_FCK","FCK Editor");
define("_MD_FORM_KOIVI","Koivi Editor");
define("_MD_FORM_TINYMCE","TinyMCE Editor");

// ERROR messages
define('_MD_ERRORFORUM','ERRO: Fórum não selecionado!');
define('_MD_ERRORPOST','ERRO: Mensagem não selecionada!');
define('_MD_NORIGHTTOVIEW','Você não tem permissão para exibir este fórum.');
define('_MD_NORIGHTTOPOST','Você não tem permissão para publicar neste fórum.');
define('_MD_NORIGHTTOEDIT','Você não tem permissão para editar neste fórum.');
define('_MD_NORIGHTTOREPLY','Você não tem permissão para responder neste fórum.');
define('_MD_NORIGHTTOACCESS','Você não tem permissão para acessar este fórum.');
define('_MD_ERRORTOPIC','ERRO: Tópico não selecionado!');
define('_MD_ERRORCONNECT','ERRO: O fórum que você selecionou não existe. Por favor, tente novamente mais tarde.');
define('_MD_ERROREXIST','ERRO: Não é possível conectar ao banco de dados.');
define('_MD_ERROROCCURED','Ocorreu um erro');
define('_MD_COULDNOTQUERY','Não é possível consultar o banco de dados do fórum.');
define('_MD_FORUMNOEXIST','ERRO: O fórum ou tópico que você selecionou não existe. Por favor, tente novamente mais tarde.');
define('_MD_USERNOEXIST','Usuário não existe. Por favor, tente novamente mais tarde.');
define('_MD_COULDNOTREMOVE','Operação de exclusão não realizada!');
define('_MD_COULDNOTREMOVETXT','Exclusão dos textos das mensagens não realizada!');
define('_MD_TIMEISUP','Você alcançou o limite de tempo para editar sua mensagem.');
define('_MD_TIMEISUPDEL','Você alcançou o limite do tempo para excluir sua mensagem.');

//reply.php
define('_MD_ON','em'); //Posted on
define('_MD_USERWROTE','%s escreveu:'); // %s is username
define('_MD_RE','Re');

//post.php
define('_MD_EDITNOTALLOWED','Você não tem permissão para editar esta mensagem.');
define('_MD_EDITEDBY','Editado por');
define('_MD_ANONNOTALLOWED','Visitantes anônimos não têm autorização para enviar mensagens.<br>Por favor, registre-se.');
define('_MD_THANKSSUBMIT','Obrigado pela sua participação!');
define('_MD_REPLYPOSTED','Foi enviada uma resposta para o seu tópico.');
define('_MD_HELLO','Olá %s,');
define('_MD_URRECEIVING','Você está recebendo este e-mail porque uma tópico que você criou no fórum do site %s foi respondido.'); // %s is your site name
define('_MD_CLICKBELOW','Clique no link abaixo para exibir o tópico:');
define('_MD_WAITFORAPPROVAL','Obrigado. Sua mensagem será analisada antes da publicação.');
define('_MD_POSTING_LIMITED','Dê um tempo e volte em %d segundos');

//forumform.inc
define('_MD_NAMEMAIL','Nome/e-mail:');
define('_MD_LOGOUT','Sair');
define('_MD_REGISTER','Registro');
define('_MD_SUBJECTC','Assunto:');
define('_MD_MESSAGEICON','Ícone da mensagem:');
define('_MD_MESSAGEC','Mensagem:');
define('_MD_ALLOWEDHTML','HTML desativado:');
define('_MD_OPTIONS','Opções:');
define('_MD_POSTANONLY','Enviar anonimamente');
define('_MD_DOSMILEY','Ativar emoticons');
define('_MD_DOXCODE','Ativar códigos Xoops');
define('_MD_DOBR','Ativar quebra de linha (Não marcar em modo HTML)');
define('_MD_DOHTML','Ativar HTML');
define('_MD_NEWPOSTNOTIFY', 'Avise-me sobre novas mensagens neste tópico');
define('_MD_ATTACHSIG','Inserir assinatura');
define('_MD_POST','Escrever');
define('_MD_SUBMIT','Enviar');
define('_MD_CANCELPOST','Cancelar');
define('_MD_REMOVE','Excluir');
define('_MD_UPLOAD','Enviar');

// forumuserpost.php
define('_MD_ADD','Incluir');
define('_MD_REPLY','Responder');

// topicmanager.php
define('_MD_VIEWTHETOPIC','Exibir tópico');
define('_MD_RETURNTOTHEFORUM','Voltar ao fórum');
define('_MD_RETURNFORUMINDEX','Voltar ao índice do fórum');
define('_MD_ERROR_BACK','Ocorreu um erro por favor volte e tente novamente.');
define('_MD_GOTONEWFORUM','Exibir tópico atualizado.');

define('_MD_TOPICDELETE','O tópico foi excluído.');
define('_MD_TOPICMERGE','Este tópico foi mesclado');
define('_MD_TOPICMOVE','O tópico foi movido.');
define('_MD_TOPICLOCK','O tópico foi bloqueado.');
define('_MD_TOPICUNLOCK','O tópico foi desbloqueado.');
define('_MD_TOPICSTICKY','O tópico foi afixado.');
define('_MD_TOPICUNSTICKY','O tópico não é mais fixo.');
define('_MD_TOPICDIGEST','Tópico incluído no Informativo');
define('_MD_TOPICUNDIGEST','O tópico foi excluído do Informativo.');

define('_MD_DELETE','Excluir');
define('_MD_MOVE','Mover');
define('_MD_MERGE','Mesclar');
define('_MD_LOCK','Bloquear');
define('_MD_UNLOCK','Desbloquear');
define('_MD_STICKY','Fixar');
define('_MD_UNSTICKY','Desfixar');
define('_MD_DIGEST','Incluir no Informativo');
define('_MD_UNDIGEST','Retirar do Informativo');

define('_MD_DESC_DELETE','Clicando em EXCLUIR no final desta página, o tópico selecionado e todas as mensagens vinculadas serão <strong>permanentemente</strong> excluídos.');
define('_MD_DESC_MOVE','Clicando em MOVER no final desta página, o tópico selecionado e todas as mensagens vinculadas serão movidas para o fórum selecionado.');
define('_MD_DESC_MERGE','Clicando em Mesclar no final desta página, o tópico selecionado e todas as mensagem vinculadas a ele serão combinadas com o tópico que você selecionou. <br/> O ID do tópico de destino tem que ser menor que o atual.</strong>. ');
define('_MD_DESC_LOCK','Clicando em BLOQUEAR no final desta página, o tópico selecionado será bloqueado. Se desejar, você poderá desbloqueá-lo posteriormente.');
define('_MD_DESC_UNLOCK','Clicando em DESBLOQUEAR no final desta página, o tópico selecionado será desbloqueado. Se desejar, você poderá bloqueá-lo posteriormente.');
define('_MD_DESC_STICKY','Clicando em FIXAR no final desta página, o tópico selecionado será fixado. Se desejar, você poderá desfixá-lo posteriormente.');
define('_MD_DESC_UNSTICKY','Clicando em DESFIXAR no final desta página, o tópico selecionado será desfixado. Se desejar, você poderá fixá-lo posteriormente.');
define('_MD_DESC_DIGEST','Clicando em INCLUIR NO RESUMO no final desta página, o tópico selecionado será incluído no resumo. Se desejar, você poderá retirá-lo posteriormente.');
define('_MD_DESC_UNDIGEST','Clicando em RETIRAR DO RESUMO no final desta página, o tópico selecionado será retirado do resumo. Se desejar, você poderá incluí-lo posteriormente.');

define('_MD_MERGETOPICTO','Mesclar tópico com:');
define('_MD_MOVETOPICTO','Mover o tópico para:');
define('_MD_NOFORUMINDB','Não há nenhum fórum no banco de dados');

// delete.php
define('_MD_DELNOTALLOWED','Você não tem permissão para excluir esta mensagem.');
define('_MD_AREUSUREDEL','Você tem certeza de que deseja excluir esta mensagem e todas as outras vinculadas a ela?');
define('_MD_POSTSDELETED','Mensagem selecionada e todas as vinculadas foram excluídas.');
define('_MD_POSTDELETED','Mensagem selecionada excluída.');

// definitions moved from global.
define('_MD_THREAD','Tópico');
define('_MD_FROM','De');
define('_MD_JOINED','Cadastrado em');
define('_MD_ONLINE','Online');
define('_MD_OFFLINE','Offline');
define('_MD_FLAT', 'Expandir');


// online.php
define('_MD_USERS_ONLINE', 'Usuários Online:');
define('_MD_ANONYMOUS_USERS', 'usuários anônimos');
define('_MD_REGISTERED_USERS', 'usuários cadastrados: ');
define('_MD_BROWSING_FORUM','usuários neste fórum');
define('_MD_TOTAL_ONLINE','Total de %d usuários online.');
define('_MD_ADMINISTRATOR','Administrador');

define('_MD_NO_SUCH_FILE','Arquivo não existe!');
define('_MD_ERROR_UPATEATTACHMENT','Ocorreu um erro ao anexar o arquivo');

// ratethread.php
define("_MD_CANTVOTEOWN", "Você não pode votar no tópico que você criou.<br />Todos os votos são revisados.");
define("_MD_VOTEONCE", "Por favor não vote no mesmo tópico mais de uma vez.");
define("_MD_VOTEAPPRE", "Obrigado pela colaboração!");
define("_MD_THANKYOU", "Obrigado por votar no %s"); // %s is your site name
define("_MD_VOTES","Votos");
define("_MD_NOVOTERATE","Você não avaliou este tópico");


// polls.php
define("_MD_POLL_DBUPDATED","O Banco de dados foi atualizado com sucesso!");
define("_MD_POLL_POLLCONF","Configuração das votações");
define("_MD_POLL_POLLSLIST", "Lista de votações");
define("_MD_POLL_AUTHOR", "Autor desta votação");
define("_MD_POLL_DISPLAYBLOCK", "Exibir no bloco?");
define("_MD_POLL_POLLQUESTION", "Pergunta da votação");
define("_MD_POLL_VOTERS", "Total de votantes");
define("_MD_POLL_VOTES", "Total de votos");
define("_MD_POLL_EXPIRATION", "Expira em");
define("_MD_POLL_EXPIRED", "Expirou");
define("_MD_POLL_VIEWLOG","Exibir log");
define("_MD_POLL_CREATNEWPOLL", "Incluir votação");
define("_MD_POLL_POLLDESC", "Descrição da votação");
define("_MD_POLL_DISPLAYORDER", "Ordem de exibição");
define("_MD_POLL_ALLOWMULTI", "Permitir seleção múltipla?");
define("_MD_POLL_NOTIFY", "Notificar o autor da votação quando expirar?");
define("_MD_POLL_POLLOPTIONS", "Opções");
define("_MD_POLL_EDITPOLL", "Editar votação");
define("_MD_POLL_FORMAT", "Formato: yyyy-mm-dd hh:mm:ss");
define("_MD_POLL_CURRENTTIME", "Data e Hora atual: %s");
define("_MD_POLL_EXPIREDAT", "Expirou em %s");
define("_MD_POLL_RESTART", "Reativar esta votação");
define("_MD_POLL_ADDMORE", "Incluir mais opções");
define("_MD_POLL_RUSUREDEL", "Você tem certeza que quer excluir esta votação e todo seu conteúdo?");
define("_MD_POLL_RESTARTPOLL", "Reativar votação");
define("_MD_POLL_RESET", "Apagar todos os registros para esta votação?");
define("_MD_POLL_ADDPOLL","Incluir votação");
define("_MD_POLLMODULE_ERROR","Módulo Enquetes não está disponível");

//report.php
define("_MD_REPORTED", "Obrigado por informar sobre esse tópico/mensagem! Um moderador examirá seu relatório em breve.");
define("_MD_REPORT_ERROR", "Ocorreu um erro ao enviar seu relatório.");
define("_MD_REPORT_TEXT", "Mensagem:");

define("_MD_PDF","Criar PDF com esta mensagem");
define("_MD_PDF_PAGE","Página");

//print.php
define("_MD_COMEFROM","Fonte:");

//viewpost.php
define("_MD_VIEWALLPOSTS","Todas as mensagens");
define("_MD_VIEWTOPIC","Tópico");
define("_MD_VIEWFORUM","Fórum");

define("_MD_COMPACT","Compacto");

define("_MD_MENU_SELECT","Menu Caixa de Seleção");
define("_MD_MENU_HOVER","Menu sensível ao mouse");
define("_MD_MENU_CLICK","Menu desativado por clique");

define("_MD_WELCOME_SUBJECT","%s acessou o fórum");
define("_MD_WELCOME_MESSAGE","Olá, %s é novo no fórum.");

define("_MD_VIEWNEWPOSTS","Exibir novas mensagens");

define("_MD_INVALID_SUBMIT","Envio inválido. Você deve ter excedido o tempo da sessão. Reenvie ou faça uma cópia da sua mensagem, entre novamente no site e tente novamente.");

define("_MD_ACCOUNT","Conta");
define("_MD_NAME","Nome");
define("_MD_PASSWORD","Senha");
define("_MD_LOGIN","Entrar");

define("_MD_TRANSFER","Transferir");
define("_MD_TRANSFER_DESC","Transferir mensagem para outros aplicativos");
define("_MD_TRANSFER_DONE","A ação foi realizada com sucesso: %s");

define("_MD_APPROVE","Aprovar");
define("_MD_RESTORE","Restaurar");
define("_MD_SPLIT_ONE","Dividir");
define("_MD_SPLIT_TREE","Separar para as crianças");
define("_MD_SPLIT_ALL","Dividir tudo");

define("_MD_TYPE_ADMIN","Admin");
define("_MD_TYPE_VIEW","Visualizar");
define("_MD_TYPE_PENDING","Pendente");
define("_MD_TYPE_DELETED","Apagados");
define("_MD_TYPE_SUSPEND","Suspenso");

define("_MD_DBUPDATED", "Banco de dados atualizado com sucesso!");

define("_MD_SUSPEND_SUBJECT", "Usuário %s foi suspenso por %d dias");
define("_MD_SUSPEND_TEXT", "Usuário %s foi suspenso por %d dias devido a:<br />[quote]%s[/quote]<br /><br /> A suspensão é válidá até %s");
define("_MD_SUSPEND_UID", "ID do usuário");
define("_MD_SUSPEND_IP", "Partes do IP [completo ou partes]");
define("_MD_SUSPEND_DURATION", "Duração da suspensão [Dias]");
define("_MD_SUSPEND_DESC", "Motivo da suspensão");
define("_MD_SUSPEND_LIST", "Lista dos suspensos");
define("_MD_SUSPEND_START", "Começar");
define("_MD_SUSPEND_EXPIRE", "Final");
define("_MD_SUSPEND_SCOPE", "Espaço");
define("_MD_SUSPEND_MANAGEMENT", "Gerência da atividade de Moderação");
define("_MD_SUSPEND_NOACCESS", "Seu ID ou IP foi suspenso");

// !!IMPORTANT!! insert '\' before any char among reserved chars: "a", "A","B","c","d","D","F","g","G","h","H","i","I","j","l","L","m","M","n","O","r","s","S","t","T","U","w","W","Y","y","z","Z"	
// insert double '\' before 't', 'r', 'n'
define("_MD_TODAY", "\H\o\j\e G:i:s");
define("_MD_YESTERDAY", "\O\\n\\t\e\m G:i:s");
define("_MD_MONTHDAY", "n/j G:i:s");
define("_MD_YEARMONTHDAY", "Y/n/j G:i");

// For user info
// If you have customized userbar, define here.
require_once(XOOPS_ROOT_PATH."/modules/".basename(  dirname(  dirname(  dirname( __FILE__ ) ) ) )."/class/user.php");
class User_language extends User
{
    function User_language(&$user)
    {
	    $this->User($user);
    }

    function &getUserbar()
    {
	    global $xoopsModuleConfig, $xoopsUser, $isadmin;
    	if (empty($xoopsModuleConfig['userbar_enabled'])) return null;
    	$user =& $this->user;
    	$userbar = array();
        $userbar[] = array("link"=>XOOPS_URL . "/userinfo.php?uid=" . $user->getVar("uid"), "name" =>_PROFILE);
		if (is_object($xoopsUser))
        $userbar[]= array("link"=>"javascript:void openWithSelfMain('" . XOOPS_URL . "/pmlite.php?send2=1&amp;to_userid=" . $user->getVar("uid") . "', 'pmlite', 450, 380);", "name"=>_MD_PM);
        if($user->getVar('user_viewemail') || $isadmin)
        $userbar[]= array("link"=>"javascript:void window.open('mailto:" . $user->getVar('email') . "', 'new');", "name"=>_MD_EMAIL);
        if($user->getVar('url'))
        $userbar[]= array("link"=>"javascript:void window.open('" . $user->getVar('url') . "', 'new');", "name"=>_MD_WWW);
        if($user->getVar('user_icq'))
        $userbar[]= array("link"=>"javascript:void window.open('http://wwp.icq.com/scripts/search.dll?to=" . $user->getVar('user_icq')."', 'new');", "name" => _MD_ICQ);
        if($user->getVar('user_aim'))
        $userbar[]= array("link"=>"javascript:void window.open('aim:goim?screenname=" . $user->getVar('user_aim') . "&amp;message=Hi+" . $user->getVar('user_aim') . "+Are+you+there?" . "', 'new');", "name"=>_MD_AIM);
        if($user->getVar('user_yim'))
        $userbar[]= array("link"=>"javascript:void window.open('http://edit.yahoo.com/config/send_webmesg?.target=" . $user->getVar('user_yim') . "&.src=pg" . "', 'new');", "name"=> _MD_YIM);
        if($user->getVar('user_msnm'))
        $userbar[]= array("link"=>"javascript:void window.open('http://members.msn.com?mem=" . $user->getVar('user_msnm') . "', 'new');", "name" => _MD_MSNM);
		return $userbar;
    }
}
define('_PDF_SUBJECT','Assunto'); 
define('_PDF_TOPIC','Tópico'); 
define('_PDF_DATE','Data'); 
define('_MD_UP','Topo');
define('_MD_POSTTIME','Data');

//define("_MD_DIGESTS", "Resumo"); //Mantido até saber se não iremos aproveitar...GibaPhp
//define('_MD_USER_LASTPOST', 'Último mensagem: %s');
//define('_MD_USER_NOLASTPOST', 'Você não tem mensagem ainda');
//define('_MD_USER_TOPICS', 'Seus Tópicos: ');
//define('_MD_USER_POSTS', 'Mensagens: ');
//define('_MD_USER_DIGESTS', 'Resumo: ');

//define('_MD_VIEW_NEWPOSTS', 'Visualizar Novos Posts');


//define('_MD_TODAYTOPICSC','Tópicos Hoje: ');
//define('_MD_TODAYPOSTSC','Mensagens Hoje: ');
//define('_MD_TOTALDIGESTSC','Resumo Total: ');

//define("_MD_CAN_TYPE", "Você <strong>pode </strong>ver os tópicos.<br />");
//define("_MD_CANNOT_TYPE", "Você <strong>não pode</strong> ver os tópicos.<br />");
//define("_MD_CAN_HTML", "Você <strong>pode</strong> usar código HTML.<br />");
//define("_MD_CANNOT_HTML", "Você <strong>não pode</strong> usar código HTML.<br />");
//define("_MD_CAN_UPLOAD", "Você <strong>pode</strong> upar(subir) de arquivos.<br />");
//define("_MD_CANNOT_UPLOAD", "Você <strong>não pode</strong> upar(subir) de arquivos.<br />");
//define("_MD_CAN_SIGNATURE", "Você <strong>pode</strong> usar assinatura.<br />");
//define("_MD_CANNOT_SIGNATURE", "Você <strong>não pode</strong> usar assinatura.<br />");

//define("_MD_NEWBB_TYPE", "Tipo de Tópico");
//define("_MD_NEWBB_TAG", "Tag");
?>