CBB 1.0 Final

CBB, XOOPS中文用户论坛模块

CBB 是XOOPS中文用户共同合作的成果
-- D.J. (phppp, http://xoops.org.cn)

CBB XOOPS 中文论坛安装使用简要说明:
1 原有数据库备份
2 上传所有文件到 xoops/modules/newbb
3 在theme/style.css中加入下拉菜单的颜色设置(示例见附录)
3 如果是从newbb 1.0升级，运行 newbb/update/newbb1_to_newbb2.php [如果从newbb 2.*升级，不用运行升级程序]
4 从管理区作模块更新
5 从模块管理区设置相关参数和权限(!!!). 部分推荐参数:
-- 如果你担心IE浏览器下论坛浏览速度，请在后台将图形文件格式选用gif，并关闭pngforie的hack
-- 如果要使用HOVER下拉菜单，检查你的theme.html里是否已经包含了<{$xoops_module_header}>
-- 在线编辑器可以从后台设定，目前可用的: HtmlArea, SPAW, Koivi, FCKeditor, TinyMCE等。在线编辑器可从http://xoops.org.cn 下载，上传到 xoops/class目录下

与 NewBB 2.02 相比，更新：
1 当前CBB数据库与NewBB 2完全兼容，你可以随时在NewBB 2和CBB之间切换
2 修正NewBB 2.02若干bug
3 清理规整NewBB 2 模板

主要新增功能(大部分来自 XOOPS CHINA 中文用户的建议)
1 不同用户可自由选择不同下拉菜单: 目前共有 下拉选择框、点击展开、hover自动展开三种菜单
2 完善附件上传功能，实现多附件上传
3 完善rss，可以按类别、按版面生成分别生成RSS Feed
4 完善PDF功能，中文可用于UTF-8
5 改进时间显示，时间格式分今天、昨天、本年度、历史四类
6 增加显示区快：最新帖子，最新话题，最高点击话题，最多回复话题，最新精华，最新置顶，作者排行榜(主题数，帖子数，精华数目，置顶数目)
7 区块增加时间限制，可以显示过去24小时最新话题、本周热点、本月热点等
8 显示全部帖子
9 增加新用户报道功能，可以在用户首次登陆论坛时自动发布一个自我介绍的帖子
10 增加文本显示的参数，控制换行符插入

CBB
SITE: HTTP://XOOPS.ORG.CN
DEMO: HTTP://XOOPS.ORG.CN
SUPP: http://xoops.org.cn/modules/newbb/viewforum.php?forum=17

附录
theme/style.css中添加下拉菜单颜色
/* color -- dropdown menu for Forum */
#dropdown a{
	color:#FFFFFF;
	}

#dropdown .menubar, #dropdown .menu, #dropdown .item, #dropdown .separator{
	background-color: #99B5CC;
	color:#FFFFFF;
	}

#dropdown .separator{
	border: 1px inset #e0e0e0;
	}

#dropdown .menu a:hover{
	color: #333;
	}
/* color - end */
