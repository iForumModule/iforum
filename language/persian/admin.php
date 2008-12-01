<?php
// $Id: admin.php,v 1.3 2005/10/19 17:20:33 phppp Exp $
//%%%%%%	File Name  index.php   	%%%%%
//$constpref = '_AM_' . strtoupper( basename( dirname(  dirname(  dirname( __FILE__ ) ) ) ) ) ;
$constpref = '_AM_NEWBB';
define($constpref."_FORUMCONF","تنظیمات انجمن");
define($constpref."_ADDAFORUM","اضافه کردن یکانجمن");
define($constpref."_SYNCFORUM","همگام سازی انجمن");
define($constpref."_REORDERFORUM","مرتب سازی دوباره");
define($constpref."_FORUM_MANAGER","انجمن‌ها");
define($constpref."_PRUNE_TITLE","هرس کردن");
define($constpref."_CATADMIN","شاخه‌ها");
define($constpref."_GENERALSET", "تنظیمات ماژول" );
define($constpref."_MODULEADMIN","مدیریت ماژول:");
define($constpref."_HELP","کمک");
define($constpref."_ABOUT","درباره");
define($constpref."_BOARDSUMMARY","آمار Board");
define($constpref."_PENDING_POSTS_FOR_AUTH","تایید پست‌های معلق");
define($constpref."_POSTID","ID پست");
define($constpref."_POSTDATE","تاریخ پست");
define($constpref."_POSTER","فرستنده");
define($constpref."_TOPICS","تاپیک‌ها");
define($constpref."_SHORTSUMMARY","خلاصه‌ی Board");
define($constpref."_TOTALPOSTS","مجموع پست‌ها");
define($constpref."_TOTALTOPICS","مجموع تاپیک‌ها");
define($constpref."_TOTALVIEWS","مجموع دیده شده‌ها");
define($constpref."_BLOCKS","بلاک‌ها");
define($constpref."_SUBJECT","عنوان");
define($constpref."_APPROVE","تایید  پست");
define($constpref."_APPROVETEXT","محتوای این پست");
define($constpref."_POSTAPPROVED","این پست تایید شد");
define($constpref."_POSTNOTAPPROVED","پست تایید نشد");
define($constpref."_POSTSAVED","پست ذخیره شد");
define($constpref."_POSTNOTSAVED","پست ذخیره نشد");

define($constpref."_TOPICAPPROVED","تاپیک تایید شد");
define($constpref."_TOPICNOTAPPROVED","تاپیکتایید نشد");
define($constpref."_TOPICID","ID تاپیک");
define($constpref."_ORPHAN_TOPICS_FOR_AUTH","تایید نکردن تاپیک‌های ارسال شده");


define($constpref.'_DEL_ONE','فقط این پیام را پاککن');
define($constpref.'_POSTSDELETED','پیام انتخاب شده حذف شد');
define($constpref.'_NOAPPROVEPOST','در حال حاضر هیچ پست منتظر برای تایید موجود نیست.');
define($constpref.'_SUBJECTC','عنوان:');
define($constpref.'_MESSAGEICON','شکلکپیام:');
define($constpref.'_MESSAGEC','پیام:');
define($constpref.'_CANCELPOST','لغو کردن ارسال');
define($constpref.'_GOTOMOD','برو به ماژول');

define($constpref.'_PREFERENCES','تنظیمات ماژول');
define($constpref.'_POLLMODULE','ماژول Xoops poll');
define($constpref.'_POLL_OK','آماده برای استفاده');
define($constpref.'_GDLIB1','GD1 library:');
define($constpref.'_GDLIB2','GD2 library:');
define($constpref.'_AUTODETECTED','شناسایی خودکار: ');
define($constpref.'_AVAILABLE','آماده‌است');
define($constpref.'_NOTAVAILABLE','<font color="red">آماده نیست</font>');
define($constpref.'_NOTWRITABLE','<font color="red">قابل دسترسی نیست</font>');
define($constpref.'_IMAGEMAGICK','ImageMagicK');
define($constpref.'_IMAGEMAGICK_NOTSET','تنظیم‌نشده');
define($constpref.'_ATTACHPATH','مسیر برای قرار دادن ضمائم');
define($constpref.'_THUMBPATH','مسیر برای قرار دادن تصاویر تمبری');
//define($constpref.'_RSSPATH','مسیر برای RSS feed');
define($constpref.'_REPORT','پیام‌های گزارش داده شده');
define($constpref.'_REPORT_PENDING','گزارش‌های معلق');
define($constpref.'_REPORT_PROCESSED','گزارش‌های پردازش شده');

define($constpref.'_CREATETHEDIR','بساز');
define($constpref.'_SETMPERM','گذاشتن دسترسی‌ها');
define($constpref.'_DIRCREATED','شاخه ساخته شد');
define($constpref.'_DIRNOTCREATED','شاخه شاخته نشد');
define($constpref.'_PERMSET','دسترسی تنظیم شد');
define($constpref.'_PERMNOTSET','دسترسی تنظیم نشد');

define($constpref.'_DIGEST','آگهای رسانی خلاصه‌ها');
define($constpref.'_DIGEST_PAST','<font color="red"> %d دقیقه پیش گذاشته شده است</font>');
define($constpref.'_DIGEST_NEXT',' %d دقیقه دیگر فرستاده می‌شود');
define($constpref.'_DIGEST_ARCHIVE','خلاصه در آرشیو قرار گرفت');
define($constpref.'_DIGEST_SENT','خلاصه در حال فرستاده شدن');
define($constpref.'_DIGEST_FAILED','خلاصه فرستاده نشد');

// admin_forum_manager.php
define($constpref."_NAME","نام");
define($constpref."_CREATEFORUM","ایجاد انجمن");
define($constpref."_EDIT","ویرایش");
define($constpref."_CLEAR","پاک کردن گزینه‌ها");
define($constpref."_DELETE","حذف");
define($constpref."_ADD","اضافه‌کردن");
define($constpref."_MOVE","انتقال");
define($constpref."_ORDER","ردیف‌کردن");
define($constpref."_TWDAFAP","این قسمت انجمن و تمام پیام‌های زده شده در آن را حذف خواهد کرد.<br><br>هشدار: آیا مطمئنید که این انجمن را می‌خواهید پاککنید؟");
define($constpref."_FORUMREMOVED","انجمن‌ پاکشد.");
define($constpref."_CREATENEWFORUM","ایجاد یکانجمن جدید");
define($constpref."_EDITTHISFORUM","ویرایش انجمن:");
define($constpref."_SET_FORUMORDER","تنظیم محل قرارگیری انجمن:");
define($constpref."_ALLOWPOLLS","اجازه‌دادن نظرسنجی‌ها:");
define($constpref."_ATTACHMENT_SIZE" ,"حداکثر سایز ممکن بر حسب KB:");
define($constpref."_ALLOWED_EXTENSIONS", "پسوند‌های مجاز:<span style='font-size: xx-small; font-weight: normal; display: block;'>'*' یعنی بدون محدودیت. برای جدا کردن از نشان '|' استفاده کنید.</span>");
define($constpref."_ALLOW_ATTACHMENTS", "اجازه دادن پیوست:");
define($constpref."_ALLOWHTML","اجازه دادن استفاده از HTML:");
define($constpref."_YES","بله");
define($constpref."_NO","خیر");
define($constpref."_ALLOWSIGNATURES","اجازه دادن استفاده از امضا:");
define($constpref."_HOTTOPICTHRESHOLD","تعداد عنوان‌های مهم:");
//define($constpref."_POSTPERPAGE","تعداد پست‌ها در صفحه<span style='font-size: xx-small; font-weight: normal; display: block;'>(این گزینه تعداد پستها را<br> در عنوان نشان می‌دهد که<br> در هر صفحه اتز عنوان وجود دارد)</span>");
//define($constpref."_TOPICPERFORUM","تعداد عنوان‌ها در انجمن<span style='font-size: xx-small; font-weight: normal; display: block;'>(این گزینه تعداد عنوان‌ها را در انجمن نشان می‌دهد<br> که در هر صفحه از انجمن<br> این تعداد عنوان وجود دارد)</span>");
//define($constpref."_SHOWNAME","جایگزینی نام کاربری با نام واقعی:");
//define($constpref."_SHOWICONSPANEL","نمایش پنل شکلک‌ها:");
//define($constpref."_SHOWSMILIESPANEL","نمایش پنل Smiley ها:");
define($constpref."_MODERATOR_REMOVE","حذف ناظر‌های کنونی");
define($constpref."_MODERATOR_ADD","اظافه کردن ناظر");
define($constpref."_ALLOW_SUBJECT_PREFIX", "اجازه استفاده از پیشوند برای عنوان‌ها در این انجمن");
define($constpref."_ALLOW_SUBJECT_PREFIX_DESC", "این به کاربران اجازه می‌دهد پیوندی مناسب با موضوع عنوان به عنوان‌های این انجمن اضافه کنند");


// admin_cat_manager.php

define($constpref."_SETCATEGORYORDER","تنظیم محل شاخه:");
define($constpref."_ACTIVE","فعال");
define($constpref."_INACTIVE","غیرفعال");
define($constpref."_STATE","وضعیت:");
define($constpref."_CATEGORYDESC","توضیحات شاخه:");
define($constpref."_SHOWDESC","نمایش دادن توضیحات؟");
define($constpref."_IMAGE","تصویر:");
//define($constpref."_SPONSORIMAGE","تصویر پشتیبان:");
define($constpref."_SPONSORLINK","لینک پشتیبان:");
define($constpref."_DELCAT","حذف شاخه");
define($constpref."_WAYSYWTDTTAL","این قسمت انجمن‌های زیر شاخه را پاکنخواهد کرد.<br><br>WARNINGبرای پاککردن آن از ویرایش انجمن‌اقدام کنید. آیا مایلید شاخه‌را پاککنید؟");



//%%%%%%        File Name  admin_forums.php           %%%%%
define($constpref."_FORUMNAME","نام انجمن:");
define($constpref."_FORUMDESCRIPTION","توضیحات انجمن:");
define($constpref."_MODERATOR","ناظرین:");
define($constpref."_REMOVE","حذف");
define($constpref."_CATEGORY","شاخه:");
define($constpref."_DATABASEERROR","خطای پایگاه داده");
define($constpref."_CATEGORYUPDATED","شاخه به روز شد.");
define($constpref."_EDITCATEGORY","ویرایش شاخه:");
define($constpref."_CATEGORYTITLE","عنوان شاخه:");
define($constpref."_CATEGORYCREATED","شاخه ایجاد شد");
define($constpref."_CREATENEWCATEGORY","ایجاد یک شاخه‌ی جدید");
define($constpref."_FORUMCREATED","انجمن ایجاد شد");
define($constpref."_ACCESSLEVEL","سطح دسترسی کامل:");
define($constpref."_CATEGORY1","شاخه");
define($constpref."_FORUMUPDATE","تنظیمات انجمن به روز شد.");
define($constpref."_FORUM_ERROR","خطا: تنظیمات انجمن به روز نشد.");
define($constpref."_CLICKBELOWSYNC","کلیک کردن زیر باعث می‌شود تاپیک‌ها و صفحه‌های فروم شما با مقداردهی صحیحی از پایگاه داده تنظیم شوند. از این بخش هنگامی استفاده کنید که مطلع شده‌اید بی‌ نظمی در تعداد تاپیک‌ها و صفحهات وجود دارد. ");
define($constpref."_SYNCHING","همزمان کردن صفه اصلی انجمن و انجمن‌ها (این کار ممکن است مدتی طول بکشد)");
define($constpref."_CATEGORYDELETED","شاخه پاک شد.");
define($constpref."_MOVE2CAT","بردن به شاخه‌:");
define($constpref."_MAKE_SUBFORUM_OF","ایجاد زیرانجمن:");
define($constpref."_MSG_FORUM_MOVED","انجمن منتقل شد.");
define($constpref."_MSG_ERR_FORUM_MOVED","ناتوانی در بردن انجمن.");
define($constpref."_SELECT","< انتخاب >");
define($constpref."_MOVETHISFORUM","این انجمن را منتقل کن");
define($constpref."_MERGE","ادغام");
define($constpref."_MERGETHISFORUM","این انجمن را ادغام کن");
define($constpref."_MERGETO_FORUM","این انجمن را ادغام کن به:");
define($constpref."_MSG_FORUM_MERGED","انجمن ادغام شد!");
define($constpref."_MSG_ERR_FORUM_MERGED","خطا در ادغام انجمن!");

//%%%%%%        File Name  admin_forum_reorder.php           %%%%%
define($constpref."_REORDERID","ID");
define($constpref."_REORDERTITLE","عنوان");
define($constpref."_REORDERWEIGHT","محل");
define($constpref."_SETFORUMORDER","تغییر محل قرار گیری انجمن در شاخه");
define($constpref."_BOARDREORDER","مکان انجمن تغییر داده شد");

// admin_permission.php
define($constpref."_PERMISSIONS_TO_THIS_FORUM","دسترسی تاپیکها برای این انجمن");
define($constpref."_CAT_ACCESS","می‌توانید به شاخه دسترسی داشته باشید");
define($constpref."_CAN_ACCESS","می‌توانید به انجمن دسترسی داشته باشید");
define($constpref."_CAN_VIEW","می‌توانید مطالب را بخوانید");
define($constpref."_CAN_POST","می‌توانید عنوان جدید باز کنید");
define($constpref."_CAN_REPLY","می‌توانید به عنوان‌ها پاسخ دهید");
define($constpref."_CAN_EDIT","می‌توانید پیام‌ها‌ی خودتان را ویرایش کنید");
define($constpref."_CAN_DELETE","می‌توانید پیام‌ها‌ی خودتان را حذف کنید");
define($constpref."_CAN_ADDPOLL","می‌توانید نظر سنجی اضافه کنید");
define($constpref."_CAN_VOTE","می‌توانید در نظر سنجی‌ها شرکت کنید");
define($constpref."_CAN_ATTACH","می‌توانید فایل‌ها را به پیام خود پیوست کنید");
define($constpref."_CAN_NOAPPROVE","می‌توانید پیام بدون نیاز به تایید بزنید");
define($constpref."_ACTION","عمل");

define($constpref."_PERM_TEMPLATE","الگوی دسترسی‌های پیشفرض");
define($constpref."_PERM_TEMPLATE_DESC","میتواند به یک انجمن اضافه شود");
define($constpref."_PERM_FORUMS","انتخاب انجمن‌ها");
define($constpref."_PERM_TEMPLATE_CREATED","الگوی دسترسی‌ها ساخته شد");
define($constpref."_PERM_TEMPLATE_ERROR","خطا در حین ساخته شدن الگوی دسترسی‌ها");
define($constpref."_PERM_TEMPLATEAPP","اعمال دسترسی‌های پیشفرض");
define($constpref."_PERM_TEMPLATE_APPLIED","دسترسی‌های پیشفرض در انجمن‌ها اعمال شد");
define($constpref."_PERM_ACTION","عمل‌های دسترسی‌ها");
define($constpref."_PERM_SETBYGROUP","اعمال دسترسی برای گروه‌ها به صورت مستقیم");

// admin_forum_prune.php

define ("_AM_NEWBB_PRUNE_RESULTS_TITLE","نتیجه‌ی هرس‌کردن");
define ("_AM_NEWBB_PRUNE_RESULTS_TOPICS","تاپیک‌‌های هرس شده");
define ("_AM_NEWBB_PRUNE_RESULTS_POSTS","پست‌های هرس شده");
define ("_AM_NEWBB_PRUNE_RESULTS_FORUMS","انجمن‌های هرس شده");
define ("_AM_NEWBB_PRUNE_STORE","به جای حذف کردن آن در این انجمن قرارشان بده:");
define ("_AM_NEWBB_PRUNE_ARCHIVE","یک کپی از پست‌ها در آرشیو نگه دار");
define ("_AM_NEWBB_PRUNE_FORUMSELERROR","شما فراموش کرده‌اید که انجمنی را برای هرس انتخاب کنید.");

define ("_AM_NEWBB_PRUNE_DAYS","پاک کردن تاپیک بدون پاسخ در :");
define ("_AM_NEWBB_PRUNE_FORUMS","انجمن‌هایی که هرس می‌شوند:");
define ("_AM_NEWBB_PRUNE_STICKY","تاپیک‌های مهم(Sticky) را حفظ کن.");
define ("_AM_NEWBB_PRUNE_DIGEST","تاپیک‌های خلاصه را حفظ کن");
define ("_AM_NEWBB_PRUNE_LOCK","تاپیک‌های قفل را حفظ کن");
define ("_AM_NEWBB_PRUNE_HOT","تاپیک‌هایی که بیشتر از این پاسخ‌ها را دارند نگه دار");
define ("_AM_NEWBB_PRUNE_SUBMIT","تایید");
define ("_AM_NEWBB_PRUNE_RESET","تنظیم دوباره");
define ("_AM_NEWBB_PRUNE_YES","بله");
define ("_AM_NEWBB_PRUNE_NO","نه");
define ("_AM_NEWBB_PRUNE_WEEK","یک هفته");
define ("_AM_NEWBB_PRUNE_2WEEKS","دو هفته");
define ("_AM_NEWBB_PRUNE_MONTH","یک ماه");
define ("_AM_NEWBB_PRUNE_2MONTH","دو ماه");
define ("_AM_NEWBB_PRUNE_4MONTH","چهار ماه");
define ("_AM_NEWBB_PRUNE_YEAR","یک سال");
define ("_AM_NEWBB_PRUNE_2YEARS","دو سال");

// About.php constants
define($constpref.'_AUTHOR_INFO', "اطلاعات نویسنده:");
define($constpref.'_AUTHOR_NAME', "نویسنده:");
define($constpref.'_AUTHOR_WEBSITE', "وب‌ سایت‌ نویسنده:");
define($constpref.'_AUTHOR_EMAIL', "پست الکترونیکی نویسنده:");
define($constpref.'_AUTHOR_CREDITS', "اعتبارات");
define($constpref.'_MODULE_INFO', "اطلاعات سازندگان ماژول");
define($constpref.'_MODULE_STATUS', "وضعیت");
define($constpref.'_MODULE_DEMO', "سایت نمایشی");
define($constpref.'_MODULE_SUPPORT', "سایت پشتیبان رسمی");
define($constpref.'_MODULE_BUG', "گزارش دادن یک باگ برای این ماژول");
define($constpref.'_MODULE_FEATURE', "امکانات جدیدی برای این ماژول پیشنهاد کنید.");
define($constpref.'_MODULE_DISCLAIMER', "توضیحات");
define($constpref.'_AUTHOR_WORD', "سخن موسس");
define($constpref.'_BY','توسط');
define($constpref.'_AUTHOR_WORD_EXTRA', "
");

// admin_report.php
define($constpref."_REPORTADMIN","مدیریت پیام‌های گزارش شده");
define($constpref."_PROCESSEDREPORT","دیدن پاسخ ارسال شده توسط ناظر به گزارش فرستاده شده");
define($constpref."_PROCESSREPORT","گزارش‌های ارسال شده");
define($constpref."_REPORTTITLE","عنوان گزارش");
define($constpref."_REPORTEXTRA","بخش اضافی");
define($constpref."_REPORTPOST","پیام گزارش شده");
define($constpref."_REPORTTEXT","متن گزارش ارسال شده");
define($constpref."_REPORTMEMO","Process memo");

// admin_report.php
define($constpref."_DIGESTADMIN","مدیریت خلاصه‌ها");
define($constpref."_DIGESTCONTENT","متن خلاصه‌ها");

// admin_votedata.php
define($constpref."_VOTE_RATINGINFOMATION", "اطلاعات ارزش گذاری");
define($constpref."_VOTE_TOTALVOTES", "همه‌ی رای ها: ");
define($constpref."_VOTE_REGUSERVOTES", "رای‌های کاربران عضو: %s");
define($constpref."_VOTE_ANONUSERVOTES", "رای‌های کاربران مهمان: %s");
define($constpref."_VOTE_USER", "کاربر");
define($constpref."_VOTE_IP", "آدرس IP");
define($constpref."_VOTE_USERAVG", "متوسط ارزش گذاری کاربران");
define($constpref."_VOTE_TOTALRATE", "همه‌ی ارزش گذاری‌ها");
define($constpref."_VOTE_DATE", "ارسال شده‌ها");
define($constpref."_VOTE_RATING", "ارزش");
define($constpref."_VOTE_NOREGVOTES", "هیچ کاربر عضوی رای نداده است");
define($constpref."_VOTE_NOUNREGVOTES", "هیچ کاربر مهمانی رای نداده است");
define($constpref."_VOTEDELETED", "اطلاعات ارزش گذاری حذف شد.");
define($constpref."_VOTE_ID", "ID");
define($constpref."_VOTE_FILETITLE", "نام تاپیک");
define($constpref."_VOTE_DISPLAYVOTES", "اطلاعات ارزش گذاری");
define($constpref."_VOTE_NOVOTES", "هیچ رایی برای نشان دادن نیست");
define($constpref."_VOTE_DELETE", "هیچ رایی برای نشان دادن نیست");
define($constpref."_VOTE_DELETEDSC", "رای‌های انتخاب شده از پایگاه داده <b>حذف شدند</b>");
define($constpref."_PERM_PERMISSIONS", "دسترسی‌ها");
?>