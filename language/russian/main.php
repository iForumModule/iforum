<?php
// $Id$ Russian translation. Charset: utf-8 (without BOM)
if(defined('MAIN_DEFINED')) return;
define('MAIN_DEFINED',true);

define('_MD_ERROR','Ошибка');
define('_MD_NOPOSTS','Нет сообщений');
define('_MD_GO','Выполнить');
define('_MD_SELFORUM','Выбор форума');

define('_MD_THIS_FILE_WAS_ATTACHED_TO_THIS_POST','Присоединенный файл:');
define('_MD_ALLOWED_EXTENSIONS','Допустимые расширения');
define('_MD_MAX_FILESIZE','Максимальный размер файла');
define('_MD_ATTACHMENT','Присоединить файл');
define('_MD_FILESIZE','Размер');
define('_MD_HITS','Обращения');
define('_MD_GROUPS','Группы:');
define('_MD_DEL_ONE','Удалить только это сообщение');
define('_MD_DEL_RELATED','Удалить все сообения в этой теме');
define('_MD_MARK_ALL_FORUMS','Отметить все форумы');
define('_MD_MARK_ALL_TOPICS','Отметить все темы');
define('_MD_MARK_UNREAD','как непрочитанные');
define('_MD_MARK_READ','как прочитанные');
define('_MD_ALL_FORUM_MARKED','Все форумы отмечены');
define('_MD_ALL_TOPIC_MARKED','Все темы отмечены');
define('_MD_BOARD_DISCLAIMER','Сообщение об отвественности');


//index.php
define('_MD_ADMINCP','Панель управления');
define('_MD_FORUM','Форум');
define('_MD_WELCOME','Добро пожаловать на форум %s.');
define('_MD_TOPICS','Темы');
define('_MD_POSTS','Сообщения');
define('_MD_LASTPOST','Последние');
define('_MD_MODERATOR','Модератор');
define('_MD_NEWPOSTS','новых сообщений');
define('_MD_NONEWPOSTS','Нет новых сообщений');
define('_MD_PRIVATEFORUM','Неактивный форум');
define('_MD_BY',' '); // Posted by
define('_MD_TOSTART','Чтобы начать просматривать сообщения, выберите форум, который Вы хотите посетить из списка ниже.');
define('_MD_TOTALTOPICSC','Всего тем: ');
define('_MD_TOTALPOSTSC','Всего сообщений: ');
define('_MD_TOTALUSER','Всего пользователей: ');
define('_MD_TIMENOW','Сейчас: %s');
define('_MD_LASTVISIT','Ваш последний визит: %s');
define('_MD_ADVSEARCH','Расширенный поиск');
define('_MD_POSTEDON','Отправлено: ');
define('_MD_SUBJECT','Тема');
define('_MD_INACTIVEFORUM_NEWPOSTS','Неактивный форум с новыми сообщениями');
define('_MD_INACTIVEFORUM_NONEWPOSTS','Неактивный форум без новых сообщений');
define('_MD_SUBFORUMS','Подфорумы');
define('_MD_MAINFORUMOPT', 'Основные опции');
define("_MD_PENDING_POSTS_FOR_AUTH","Сообщения, ожидающие одобрения:");



//page_header.php
define('_MD_MODERATEDBY','Модерируется');
define('_MD_SEARCH','Поиск');
//define('_MD_SEARCHRESULTS','Search Results');
define('_MD_FORUMINDEX','Индекс форума %s');
define('_MD_POSTNEW','Новая тема');
define('_MD_REGTOPOST','Регистрация для отправки');

//search.php
define('_MD_SEARCHALLFORUMS','Поиск по всем форумам');
define('_MD_FORUMC','Форум');
define('_MD_AUTHORC','Автор:');
define('_MD_SORTBY','Упорядочить по');
define('_MD_DATE','Дата');
define('_MD_TOPIC','Тема');
define('_MD_POST2','Сообщение');
define('_MD_USERNAME','Пользователь');
define('_MD_BODY','Тело');
define('_MD_SINCE','Диапазон');

//viewforum.php
define('_MD_REPLIES','Ответы');
define('_MD_POSTER','Отпр.');
define('_MD_VIEWS','Просм.');
define('_MD_MORETHAN','Есть новые сообщения [ популярные ]');
define('_MD_MORETHAN2','Нет новых сообщений [ популярные ]');
define('_MD_TOPICSHASATT','Тема имеет присоединения');
define('_MD_TOPICHASPOLL','Тема имеет опрос');
define('_MD_TOPICLOCKED','Тема блокирована');
define('_MD_LEGEND','Легенда');
define('_MD_NEXTPAGE','След.');
define('_MD_SORTEDBY','Сортировать по');
define('_MD_TOPICTITLE','Заголовок темы');
define('_MD_NUMBERREPLIES','Количество откликов');
define('_MD_TOPICPOSTER','Инициатор темы');
define('_MD_TOPICTIME','Время публикации');
define('_MD_LASTPOSTTIME','Время последнего отправления');
define('_MD_ASCENDING','Возрастание');
define('_MD_DESCENDING','Убывание');
define('_MD_FROMLASTHOURS','За последние %s час.');
define('_MD_FROMLASTDAYS','За последние %s дн.');
define('_MD_THELASTYEAR','За последний год');
define('_MD_BEGINNING','С даты создания');
define('_MD_SEARCHTHISFORUM', 'Поиск в этом форуме');
define('_MD_TOPIC_SUBJECTC','Префикс темы:');


define('_MD_RATINGS','Оценки');
define("_MD_CAN_ACCESS", "Вы <strong>имеете</strong> доступ к форуму.<br />");
define("_MD_CANNOT_ACCESS", "Вы <strong>не имеете</strong> доступа к форуму.<br />");
define("_MD_CAN_POST", "Вы <strong>можете</strong> создавать новую тему.<br />");
define("_MD_CANNOT_POST", "Вы <strong>не можете</strong> создавать новую тему.<br />");
define("_MD_CAN_VIEW", "Вы <strong>можете</strong> просматривать тему.<br />");
define("_MD_CANNOT_VIEW", "Вы <strong>не можете</strong> просматривать тему.<br />");
define("_MD_CAN_REPLY", "Вы <strong>можете</strong> отвечать на сообщения.<br />");
define("_MD_CANNOT_REPLY", "Вы <strong>не можете</strong> отвечать на сообщения.<br />");
define("_MD_CAN_EDIT", "Вы <strong>можете</strong> редактировать Ваши сообщения.<br />");
define("_MD_CANNOT_EDIT", "Вы <strong>не можете</strong> редактировать Ваши сообщения.<br />");
define("_MD_CAN_DELETE", "Вы <strong>можете</strong> удалять Ваши сообщения.<br />");
define("_MD_CANNOT_DELETE", "Вы <strong>не можете</strong> удалять Ваши сообщения.<br />");
define("_MD_CAN_ADDPOLL", "Вы <strong>можете</strong> добавлять новый опрос.<br />");
define("_MD_CANNOT_ADDPOLL", "Вы <strong>не можете</strong> добавлять новые опросы.<br />");
define("_MD_CAN_VOTE", "Вы <strong>можете</strong> голосовать в опросах.<br />");
define("_MD_CANNOT_VOTE", "Вы <strong>не можете</strong> голосовать в опросах.<br />");
define("_MD_CAN_ATTACH", "Вы <strong>можете</strong> присоединять файлы к сообщениям.<br />");
define("_MD_CANNOT_ATTACH", "Вы <strong>не можете</strong> присоединять файлы к сообщениям.<br />");
define("_MD_CAN_NOAPPROVE", "Вы <strong>можете</strong> публиковать сообщения без одобрения.<br />");
define("_MD_CANNOT_NOAPPROVE", "Вы <strong>не можете</strong> публиковать сообщения без одобрения.<br />");
define("_MD_IMTOPICS","Важные темы");
define("_MD_NOTIMTOPICS","Темы форума");
define('_MD_FORUMOPTION', 'Опции форума');

define('_MD_VAUP','Просмотр всех сообщений без откликов');
define('_MD_VANP','Просмотр всех сообщений');


define('_MD_UNREPLIED','тем без откликов');
define('_MD_UNREAD','непрочитанных тем');
define('_MD_ALL','всех тем');
define('_MD_ALLPOSTS','всех сообщений');
define('_MD_VIEW','Просмотр');

//viewtopic.php
define('_MD_AUTHOR','Автор');
define('_MD_LOCKTOPIC','Блокировать эту тему');
define('_MD_UNLOCKTOPIC','Разблокровать эту тему');
define('_MD_UNSTICKYTOPIC','Make this topic UnSticky');
define('_MD_STICKYTOPIC','Make this topic Sticky');
define('_MD_DIGESTTOPIC','Создать эту тему как дайджест');
define('_MD_UNDIGESTTOPIC','Создать эту тему без дайджеста');
define('_MD_MERGETOPIC','Объединить эту тему');
define('_MD_MOVETOPIC','Переместить эту тему');
define('_MD_DELETETOPIC','Удалить эту тему');
define('_MD_TOP','Вверх');
define('_MD_BOTTOM','Вниз');
define('_MD_PREVTOPIC','Пред. тема');
define('_MD_NEXTTOPIC','След. тема');
define('_MD_GROUP','Группы:');
define('_MD_QUICKREPLY','Быстрый ответ');
define('_MD_POSTREPLY','Ответ на сообщение');
define('_MD_PRINTTOPICS','Печать темы');
define('_MD_PRINT','Печать');
define('_MD_REPORT','Отчет');
define('_MD_PM','PM');
define('_MD_EMAIL','Email');
define('_MD_WWW','WWW');
define('_MD_AIM','AIM');
define('_MD_YIM','YIM');
define('_MD_MSNM','MSNM');
define('_MD_ICQ','ICQ');
define('_MD_PRINT_TOPIC_LINK', 'URL для этой дискуссии');
define('_MD_ADDTOLIST','Добавить в Ваш список контактов');
define('_MD_TOPICOPT', 'Опции темы');
define('_MD_VIEWMODE', 'Режим просмотра');
define('_MD_NEWEST', 'Новейшие сначала');
define('_MD_OLDEST', 'Позднейшие сначала');

define('_MD_FORUMSEARCH','Поиск форума');

define('_MD_RATED','Оценено:');
define('_MD_RATE','Оценка потока');
define('_MD_RATEDESC','Оценить этот поток');
define('_MD_RATING','Голосовать');
define('_MD_RATE1','Ужасно');
define('_MD_RATE2','Плохо');
define('_MD_RATE3','Средне');
define('_MD_RATE4','Хорошо');
define('_MD_RATE5','Отлично');

define('_MD_TOPICOPTION','Опции темы');
define('_MD_KARMA_REQUIREMENT', 'Ваша персональная карма %s не соответствует требующейся карме %s. <br /> Пожалуйста, повторите позже.');
define('_MD_REPLY_REQUIREMENT', 'Для просмотра этого сообщения, Вы должны войти в систему и откликнуться сначала.');
define('_MD_TOPICOPTIONADMIN','Опции администратора темы');
define('_MD_POLLOPTIONADMIN','Опции администратора опроса');

define('_MD_EDITPOLL','Редактировать этот опрос');
define('_MD_DELETEPOLL','Удалить этот опрос');
define('_MD_RESTARTPOLL','Перестартовать этот опрос');
define('_MD_ADDPOLL','Добавить опрос');

define('_MD_QUICKREPLY_EMPTY','Введите быстрый отклик здесь');

define('_MD_LEVEL','Уровень :');
define('_MD_HP','HP :');
define('_MD_MP','MP :');
define('_MD_EXP','EXP :');

define('_MD_BROWSING','Просмотр этого потока:');
define('_MD_POSTTONEWS','Отправить это сообщение в заметку новостей');

define('_MD_EXCEEDTHREADVIEW','Количество сообщений превысило порог для потокового режима.<br />Измените на плоский режим');


//forumform.inc
define('_MD_PRIVATE','Это <strong>приватный</strong> форум.<br />Только пользователи со специальными правами доступа могут создавать новые темы и отвечать на этом форуме');
define('_MD_QUOTE','Цитировать');
define('_MD_VIEW_REQUIRE','Требования к просмотру');
define('_MD_REQUIRE_KARMA','Карма');
define('_MD_REQUIRE_REPLY','Отклик');
define('_MD_REQUIRE_NULL','Нет требований');

define("_MD_SELECT_FORMTYPE","Выберите желаемый тип формы");

define("_MD_FORM_COMPACT","Compact");
define("_MD_FORM_DHTML","DHTML");
define("_MD_FORM_SPAW","Spaw Editor");
define("_MD_FORM_HTMLAREA","HTMLArea");
define("_MD_FORM_FCK","FCK Editor");
define("_MD_FORM_KOIVI","Koivi Editor");
define("_MD_FORM_TINYMCE","TinyMCE Editor");

// ERROR messages
define('_MD_ERRORFORUM','Ошибка: Форум не выбран!');
define('_MD_ERRORPOST','Ошибка: Сообщение не выбрано!');
define('_MD_NORIGHTTOVIEW','Вы не имеете прав для просмотра этой темы.');
define('_MD_NORIGHTTOPOST','Вы не имеете прав для отправки сообщений на этот форум.');
define('_MD_NORIGHTTOEDIT','Вы не имеете прав для редактирования сообщений на этом форуме.');
define('_MD_NORIGHTTOREPLY','Вы не имеете прав для создания ответов на этом форуме.');
define('_MD_NORIGHTTOACCESS','Вы не имеете прав доступа на этот форум.');
define('_MD_ERRORTOPIC','Ошибка: Тема не выбрана!');
define('_MD_ERRORCONNECT','Ошибка: Невозможно соединиться с базой данных форумов.');
define('_MD_ERROREXIST','Ошибка: Форум, который Вы выбрали не существует. Пожалуйста, вернитесь и повторите снова.');
define('_MD_ERROROCCURED','Произошла ошибка');
define('_MD_COULDNOTQUERY','Невозможно выполнить запрос в базу данных форума.');
define('_MD_FORUMNOEXIST','Ошибка - Форум/тема, которую Вы выбрали не существует. Пожалуйста, вернитесь и повторите.');
define('_MD_USERNOEXIST','Этот пользователь не существует.  Пожалуйста, вернитесь и повторите поиск.');
define('_MD_COULDNOTREMOVE','Ошибка - Невозможно удалить сообщение из базы данных!');
define('_MD_COULDNOTREMOVETXT','Ошибка - Невозможно удалить текст сообщения!');
define('_MD_TIMEISUP','У Вас имеется временное ограничение для редактирования сообщения.');
define('_MD_TIMEISUPDEL','У Вас имеется временное ограничение для удаления сообщения.');

//reply.php
define('_MD_ON',''); //Posted on
define('_MD_USERWROTE','%s написал:'); // %s is username
define('_MD_RE','Отв');

//post.php
define('_MD_EDITNOTALLOWED','У Вас недостаточно прав для редактирования этого сообщения!');
define('_MD_EDITEDBY','Отредактировано');
define('_MD_ANONNOTALLOWED','Незарегистрированные пользователи не могут отправлять сообщения.<br />Пожалуйста, зарегистрируйтесь.');
define('_MD_THANKSSUBMIT','Спасибо за Ваше сообщение!');
define('_MD_REPLYPOSTED','В Вашей теме получен отклик.');
define('_MD_HELLO','Привет, %s,');
define('_MD_URRECEIVING','Вы получили этот email, потому, что на собщение,отправленное Вами на форуме %s пришел отклик.'); // %s is Выr site name
define('_MD_CLICKBELOW','Для просмотра потока кликните на ссылку ниже:');
define('_MD_WAITFORAPPROVAL','Спасибо. Ваше сообщение перед публикацией пройдет процедуру одобрения.');
define('_MD_POSTING_LIMITED','Why not take a break и вернитесь через %d сек');

//forumform.inc
define('_MD_NAMEMAIL','Имя/Email:');
define('_MD_LOGOUT','Выйти');
define('_MD_REGISTER','Регистрация');
define('_MD_SUBJECTC','Тема:');
define('_MD_MESSAGEICON','Иконка сообщения:');
define('_MD_MESSAGEC','Сообщение:');
define('_MD_ALLOWEDHTML','Разрешить HTML:');
define('_MD_OPTIONS','Опции:');
define('_MD_POSTANONLY','Отправить анонимно');
define('_MD_DOSMILEY','Разрешить смайлы');
define('_MD_DOXCODE','Разрешить iCMS коды');
define('_MD_DOBR','Разрешить разрыв строк (Советуем отключить, если включены HTML тэги)');
define('_MD_DOHTML','Разрешить HTML тэги');
define('_MD_NEWPOSTNOTIFY', 'Извещать меня о новых сообщениях в этом потоке');
define('_MD_ATTACHSIG','Присоединить сигнатуру');
define('_MD_POST','Post');
define('_MD_SUBMIT','Выполнить');
define('_MD_CANCELPOST','Отменить');
define('_MD_REMOVE','Переместить');
define('_MD_UPLOAD','Обновить');

// forumuserpost.php
define('_MD_ADD','Добавить');
define('_MD_REPLY','Ответить');

// topicmanager.php
define('_MD_VIEWTHETOPIC','Просмотр тем');
define('_MD_RETURNTOTHEFORUM','Вернуться в форум');
define('_MD_RETURNFORUMINDEX','Вернуться в индекс форума');
define('_MD_ERROR_BACK','Ошибка - Пожалуйста, вернитесь и повторите снова.');
define('_MD_GOTONEWFORUM','Просмотр обновленных тем');

define('_MD_TOPICDELETE','Тема удалена.');
define('_MD_TOPICMERGE','Тема объединена.');
define('_MD_TOPICMOVE','Тема перемещена.');
define('_MD_TOPICLOCK','Тема заблокирована.');
define('_MD_TOPICUNLOCK','Тема разблокирована.');
define('_MD_TOPICSTICKY','The topic has been Stickyed.');
define('_MD_TOPICUNSTICKY','The topic has been unStickyed.');
define('_MD_TOPICDIGEST','Для темы создан дайджест.');
define('_MD_TOPICUNDIGEST','Для темы отменен дайджест.');

define('_MD_DELETE','Удалить');
define('_MD_MOVE','Переместить');
define('_MD_MERGE','Объединить');
define('_MD_LOCK','Блокировать');
define('_MD_UNLOCK','Разблокировать');
define('_MD_STICKY','Sticky');
define('_MD_UNSTICKY','unSticky');
define('_MD_DIGEST','Дайджест');
define('_MD_UNDIGEST','Отм.дайджест');

define('_MD_DESC_DELETE','Если Вы нажмете кнопку Удалить внизу этой формы, то тема, которую Вы выбрали и все связанные с ней сообщения будут <strong>безвозвратно</strong> удалены.');
define('_MD_DESC_MOVE','Если Вы нажмете кнопку Переместить внизу этой формы, то тема, которую Вы выбрали и все связанные с ней сообщения будут перемещены в выбранный форум.');
define('_MD_DESC_MERGE','Если Вы нажмете кнопку Объединить внизу этой формы, the topic Вы have selected, and its related posts, will be merged to the topic Вы have selected.<br /><strong>The destination topic ID must be smaller than current one</strong>.');
define('_MD_DESC_LOCK','Если Вы нажмете кнопку Заблокировать внизу этой формы, the topic Вы have selected will be locked. Вы may unlock it at a later time if Вы like.');
define('_MD_DESC_UNLOCK','Если Вы нажмете кнопку Разблокировать внизу этой формы, the topic Вы have selected will be unlocked. Вы may lock it again at a later time if Вы like.');
define('_MD_DESC_STICKY','Once Вы press the Sticky button at the bottom of this form the topic Вы have selected will be Stickyed. Вы may unSticky it again at a later time if Вы like.');
define('_MD_DESC_UNSTICKY','Once Вы press the unSticky button at the bottom of this form the topic Вы have selected will be unStickyed. Вы may Sticky it again at a later time if Вы like.');
define('_MD_DESC_DIGEST','Если Вы нажмете кнопку Дайджест внизу этой формы, the topic Вы have selected will be Digested. Вы may unDigest it again at a later time if Вы like.');
define('_MD_DESC_UNDIGEST','Once Вы press the unDigest button at the bottom of this form the topic Вы have selected will be unDigested. Вы may Digest it again at a later time if Вы like.');

define('_MD_MERGETOPICTO','Объединить тему в:');
define('_MD_MOVETOPICTO','Переместить тему в:');
define('_MD_NOFORUMINDB','Нет форумов в базе данных');

// delete.php
define('_MD_DELNOTALLOWED','Sorry, but Вы\'re not allowed to delete this post.');
define('_MD_AREUSUREDEL','Are Вы sure Вы want to delete this post and all its child posts?');
define('_MD_POSTSDELETED','Selected post and all its child posts deleted.');
define('_MD_POSTDELETED','Selected post deleted.');

// definitions moved from global.
define('_MD_THREAD','Поток');
define('_MD_FROM','От');
define('_MD_JOINED','Присоединился');
define('_MD_ONLINE','На связи');
define('_MD_OFFLINE','Отключен');
define('_MD_FLAT', 'Плоский');


// online.php
define('_MD_USERS_ONLINE', 'На связи:');
define('_MD_ANONYMOUS_USERS', 'гостей');
define('_MD_REGISTERED_USERS', 'участников: ');
define('_MD_BROWSING_FORUM','пользователей просматривают форум');
define('_MD_TOTAL_ONLINE','Всего на связи %d пользователей.');
define('_MD_ADMINISTRATOR','Администратор');

define('_MD_NO_SUCH_FILE','Файл не существует!');
define('_MD_ERROR_UPATEATTACHMENT','Ошибка во время обновления вложения');

// ratethread.php
define("_MD_CANTVOTEOWN", "Вы не можете голосовать за тему, которую Вы создали.<br />Все голоса регистрируются и просматриваются.");
define("_MD_VOTEONCE", "Пожалуйста, не голосуйте за тему более одного раза.");
define("_MD_VOTEAPPRE", "Ваш голос оценен.");
define("_MD_THANKВы", "Спасибо Вам за время, уделенное для голосования на сайте %s"); // %s is Выr site name
define("_MD_VOTES","Голосование");
define("_MD_NOVOTERATE","Вы не оценили эту тему");


// polls.php
define("_MD_POLL_DBUPDATED","База данных обновлена!");
define("_MD_POLL_POLLCONF","Установки опросов");
define("_MD_POLL_POLLSLIST", "Список опросов");
define("_MD_POLL_AUTHOR", "Автор опроса");
define("_MD_POLL_DISPLAYBLOCK", "Показать в блоке?");
define("_MD_POLL_POLLQUESTION", "Вопрос для опроса");
define("_MD_POLL_VOTERS", "Всего голосовавших");
define("_MD_POLL_VOTES", "Всего голосов");
define("_MD_POLL_EXPIRATION", "Expiration");
define("_MD_POLL_EXPIRED", "Expired");
define("_MD_POLL_VIEWLOG","Просмотр журнала");
define("_MD_POLL_CREATNEWPOLL", "Создать новый опрос");
define("_MD_POLL_POLLDESC", "Описание опроса");
define("_MD_POLL_DISPLAYORDER", "Порядок отображения");
define("_MD_POLL_ALLOWMULTI", "Разрешить множественный выбор?");
define("_MD_POLL_NOTIFY", "Известить автора опроса, когда наступит время окончания?");
define("_MD_POLL_POLLOPTIONS", "Опции");
define("_MD_POLL_EDITPOLL", "Редактировать опрос");
define("_MD_POLL_FORMAT", "Формат: yyyy-mm-dd hh:mm:ss");
define("_MD_POLL_CURRENTTIME", "Текущее время %s");
define("_MD_POLL_EXPIREDAT", "Время окончания %s");
define("_MD_POLL_RESTART", "Перестартовать опрос");
define("_MD_POLL_ADDMORE", "Добавить опции");
define("_MD_POLL_RUSUREDEL", "Вы уверены, что желаете удалить этот опрос и комментарии к нему?");
define("_MD_POLL_RESTARTPOLL", "Перестартовать опрос");
define("_MD_POLL_RESET", "Сбросить все журналы для этого опроса?");
define("_MD_POLL_ADDPOLL","Добавить опрос");
define("_MD_POLLMODULE_ERROR","модуль xoopspoll недоступен");

//report.php
define("_MD_REPORTED", "Thank Вы for reporting this post/thread! A moderator will look into Выr report shortly.");
define("_MD_REPORT_ERROR", "Error occured while sending the report.");
define("_MD_REPORT_TEXT", "Report message:");

define("_MD_PDF","Создать PDF");
define("_MD_PDF_PAGE","Страница %s");

//print.php
define("_MD_COMEFROM","Сообщение от:");

//viewpost.php
define("_MD_VIEWALLPOSTS","Все сообщения");
define("_MD_VIEWTOPIC","Тема");
define("_MD_VIEWFORUM","Форум");

define("_MD_COMPACT","Compact");

define("_MD_MENU_SELECT","Selection");
define("_MD_MENU_HOVER","Hover");
define("_MD_MENU_CLICK","Click");

define("_MD_WELCOME_SUBJECT","%s has joined the forum");
define("_MD_WELCOME_MESSAGE","Hi, %s has joined Вы. Let's start ...");

define("_MD_VIEWNEWPOSTS","Просмотреть новые сообщения");

define("_MD_INVALID_SUBMIT","Invalid submission. Вы could have exceeded session time. Please re-submit or make a backup of Выr post and login to resubmit if necessary.");

define("_MD_ACCOUNT","Учетная запись");
define("_MD_NAME","Имя");
define("_MD_PASSWORD","Пароль");
define("_MD_LOGIN","Логин");

define("_MD_TRANSFER","Перемещение");
define("_MD_TRANSFER_DESC","Перемещение сообщения в другие приложения");
define("_MD_TRANSFER_DONE","Действие выполнено: %s");

define("_MD_APPROVE","Одобрить");
define("_MD_RESTORE","Восстановить");
define("_MD_SPLIT_ONE","Разделить");
define("_MD_SPLIT_TREE","Разделить все подчиненные");
define("_MD_SPLIT_ALL","Разделить все");

define("_MD_TYPE_ADMIN","Администрирование");
define("_MD_TYPE_VIEW","Просотр");
define("_MD_TYPE_PENDING","В ожидании");
define("_MD_TYPE_DELETED","Удалено");
define("_MD_TYPE_SUSPEND","Приостановлено");

define("_MD_DBUPDATED", "База данных обновлена!");

define("_MD_SUSPEND_SUBJECT", "Действия пользователя %s приостановлены на %d дней");
define("_MD_SUSPEND_TEXT", "Действия пользователя %s приостановлены на %d days due to:<br />[quote]%s[/quote]<br /><br />The suspension is valid till %s");
define("_MD_SUSPEND_UID", "ID пользователя");
define("_MD_SUSPEND_IP", "IP сегменты (полностью или сегменты)");
define("_MD_SUSPEND_DURATION", "Длительность приостановки (дней)");
define("_MD_SUSPEND_DESC", "Причина приостановки");
define("_MD_SUSPEND_LIST", "Список приостановленных");
define("_MD_SUSPEND_START", "Начало");
define("_MD_SUSPEND_EXPIRE", "Конец");
define("_MD_SUSPEND_SCOPE", "Границы");
define("_MD_SUSPEND_MANAGEMENT", "Управление модерацией");
define("_MD_SUSPEND_NOACCESS", "Ваш ID или IP заморожен (действия приостановлены)");

// !!IMPORTANT!! insert '\' before any char among reserved chars: "a", "A","B","c","d","D","F","g","G","h","H","i","I","j","l","L","m","M","n","O","r","s","S","t","T","U","w","W","Y","y","z","Z"	
// insert double '\' before 't', 'r', 'n'
define("_MD_TODAY", "Сегодня G:i:s");
define("_MD_YESTERDAY", "Вчера G:i:s");
define("_MD_MONTHDAY", "n/j G:i:s");
define("_MD_YEARMONTHDAY", "Y/n/j G:i");

// For user info
// If Вы have customized userbar, define here.
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
        $userbar[]= array("link"=>"javascript:void window.open('aim:goim?screenname=" . $user->getVar('user_aim') . "&amp;message=Hi+" . $user->getVar('user_aim') . "+Are+Вы+there?" . "', 'new');", "name"=>_MD_AIM);
        if($user->getVar('user_yim'))
        $userbar[]= array("link"=>"javascript:void window.open('http://edit.yahoo.com/config/send_webmesg?.target=" . $user->getVar('user_yim') . "&.src=pg" . "', 'new');", "name"=> _MD_YIM);
        if($user->getVar('user_msnm'))
        $userbar[]= array("link"=>"javascript:void window.open('http://members.msn.com?mem=" . $user->getVar('user_msnm') . "', 'new');", "name" => _MD_MSNM);
		return $userbar;
    }
}
define('_PDF_SUBJECT','Тема'); 
define('_PDF_TOPIC','Тема форума'); 
define('_PDF_DATE','Дата'); 
define('_MD_UP','Топ');
define('_MD_POSTTIME','Дата');
?>