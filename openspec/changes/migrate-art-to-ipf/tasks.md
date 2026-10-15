## 1. PHP 8.2 baseline

- [x] 1.1 Replace `mysql_fetch_assoc` in `admin/admin_forum_prune.php` with the CMS DB layer (`fetchArray`)
- [x] 1.2 Remove all `mysql_major_version()` / `mysql_server_version()` branches (forum, forumhandler, post, topic, read, moderate, online, `include/plugin.tag.php`), keeping only the modern SQL path
- [x] 1.3 Replace `eval` in `mod_loadRenderer` and fix other 8.2 issues (dynamic properties, implicit nullable params, `static`/reference misuse)
- [x] 1.4 Run `php -l` over all files under `src/` and PHPStan/Psalm at a baseline level; record zero syntax errors
- [ ] 1.5 Set minimum ImpressCMS 2.0.3 / PHP 8.2 in `icms_version.php`, README and CHANGELOG

## 2. IPF pattern spike

- [x] 2.1 Read the ImpressCMS 2.0.3 source for `icms_ipf_Object` / `icms_ipf_Handler` constructors, `getObjects`, `insert`, `delete`, event hooks, and `icms_getModuleHandler`
- [x] 2.2 Migrate `Category` to `mod_iforum_Category` / `mod_iforum_CategoryHandler` as the reference pattern
- [x] 2.3 Update all `Category` call sites and verify category listing and admin CRUD

## 3. Simple entities

- [x] 3.1 Migrate Rate, Text and Report objects and handlers; update call sites
- [x] 3.2 Migrate Read, ReadForum and ReadTopic tracking; update call sites
- [x] 3.3 Migrate Moderate; update call sites and moderation admin pages
- [x] 3.4 Re-implement the Art relational helpers (link queries, link update/delete, orphan cleanup, synchronization, grouped counts) in the handlers that use them, shared via a trait where useful

## 4. Core entities

- [x] 4.1 Migrate Forum and its handler (including `forumhandler.php`), keeping existing SQL for listings; update call sites
- [x] 4.2 Migrate Topic and its handler; update call sites
- [x] 4.3 Migrate Post and its handler, including counter updates on insert/delete; update call sites
- [x] 4.4 Move user, online, digest, permission and transfer classes to IPF naming and loading

## 5. Remove Art

- [ ] 5.1 Remove Art includes from `header.php`, `admin/admin_header.php`, `icms_version.php`, `include/functions.ini.php`; drop `load_object()` and related helpers
- [ ] 5.2 Delete `class/art/`
- [ ] 5.3 `grep` for `ArtObject`, `_XoopsPersistable`, `load_object`, `iforum_getHandler` and old class names; confirm none remain

## 6. Verification

- [ ] 6.1 Compare rendered output of sample posts (BBCode, smilies, special characters) with pre-migration output
- [ ] 6.2 Walk through the spec scenarios on ImpressCMS 2.0.3 / PHP 8.2: install, index, forum, topic, post/reply/edit/delete, moderate, ratings, reports, digest, prune, admin pages
- [ ] 6.3 Confirm no schema changes against the `sql/` install file and that an existing database works without an update step
- [ ] 6.4 Update CHANGELOG with breaking-change notes

## 7. Legacy XOOPS remnants (found during verification)

- [x] 7.1 Replace `XoopsTree`, `XoopsLists`, `XoopsLocal`, `XoopsUser::getUnameFromID`, `xoops_getmodulehandler`, `xoops_trim`, `xoops_confirm`, `xoops_template_clear_module_cache`, `XoopsTpl`, `$GLOBALS["xoopsUser"]` and the removed editor compat classes with ImpressCMS 2.0.3 equivalents
- [ ] 7.2 Decide how to handle external-module dependencies still written against XOOPS APIs (`XoopsPoll*` from xoopspoll, `XoopsFormTag` from tag) and guard or replace them
- [ ] 7.3 Remove module-owned PHP notices seen in the developer dashboard (e.g. undefined `forum_pagenav` template var on the index)
- [x] 7.4 Use the real ICMS security token check on post submit (the legacy `XoopsSecurity` branch silently fell back to a constant token)
