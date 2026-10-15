## Context

See proposal.md. Art (`class/art/`) wraps `icms_core_Object` and adds a persistable object, a handler with Write/Render/Joint/Recon/Stats delegates, and `load_object()` loaders. Ten entity/handler pairs extend it. Handlers also contain substantial raw SQL (forum, topic, post) and many `mysql_major_version()` branches. ImpressCMS 2.0.3 provides `icms_ipf_Object` (`initVar`, `quickInitVar`, `setControl`) and `icms_ipf_Handler` (`getObjects`, `getList`, `getCount`, `insert`, `delete`, `addPermission`, event hooks), with the table prefix applied automatically.

## Goals / Non-Goals

**Goals:**
- Every entity extends IPF base classes; Art removed entirely.
- Call sites use IPF handler retrieval and method names.
- Same table schema, same rendered output, same permissions.

**Non-Goals:**
- No new forum features, template redesign, or schema changes.
- No back-compat shim for old class names.

## Decisions

1. **IPF-style naming, one class per file.** Entities become `mod_iforum_<Entity>` and handlers `mod_iforum_<Entity>Handler`, retrieved through `icms_getModuleHandler($name, 'iforum')`. Alternative: keep `Post` / `IforumPostHandler` (less churn, but ignores the IPF convention and the chosen direction). A one-off rename pass over call sites is accepted.
2. **No intermediate Art-like base class.** Entities extend `icms_ipf_Object` directly. Art-only operations (link queries, link updates/deletes, orphan cleanup, synchronization, grouped counts) are implemented per handler as SQL methods; where several handlers share one, a small trait holds it. Alternative: a shared abstract handler replicating Art, rejected because it recreates the framework being removed.
3. **Keep hand-written SQL for joins.** Forum, topic and post listing queries stay as SQL via `icms::$xoopsDB`; only create/get/insert/delete and simple lists use IPF handler methods.
4. **Text formatting via IPF data types.** Map Art's `getVar` formats onto IPF `initVar` data types and verify per field against the templates; keep any extra formatting in the entity's own accessor.
5. **Remove MySQL version branching.** Keep only the modern SQL path; delete `mysql_major_version()` and the dead pre-4.1 branches.
6. **Replace `eval`-based renderer loading** with a direct class lookup; replace `load_object()` with `require_once` through the handler loader.
7. **Constructors.** Signatures for the IPF handler and object constructors are confirmed against the 2.0.3 source during the first migrated entity, then reused for the rest.

## Spike findings (ImpressCMS 2.0.3 source)

- `icms_ipf_Object::__construct(&$handler)`; `icms_ipf_Handler::__construct(&$db, $itemname, $keyname, $identifierName, $summaryName, $modulename)`.
- The IPF handler derives the table as `prefix(<module>_<item>)` and the class as `mod_<module>_<Item>`. To keep `bb_*` tables, each handler overrides `$this->table` after `parent::__construct`.
- `icms_getModuleHandler($name, $dir, $basename)` looks for class `mod_<dir>_<Name>Handler`, then includes `class/<Name>Handler.php` or `class/<name>.php`, then falls back to the legacy class `Iforum<Name>Handler`. Because the legacy fallback no longer exists after the rename, `include/functions.ini.php` registers an autoloader for `mod_iforum_*` so the first `class_exists` succeeds. Call sites that already use `icms_getmodulehandler()` keep working unchanged.
- The module name is fixed to `iforum` in handler constructors, matching the `mod_iforum_*` class names.
- IPF handlers have no `getAll`, `getIds`, `getByLimit`, `getCounts`, or link helpers; `getList` and `deleteAll($criteria)` have different signatures from Art. `insert`/`delete` are signature-compatible when extended with `$checkObject`/`$debug`.
- Only `__construct`, `insert` and `delete` collide between iForum handlers and IPF; `getPermission` and the other iForum methods do not.
- `icms_ipf_Handler::insert` returns a bool and sets the new id on the object; the Category handler keeps returning the id.

## Risks / Trade-offs

- [`getVar` output differs from Art] → compare rendered output on sample posts before and after; keep output filters in accessors where needed.
- [Art signatures (reference returns, `getAll` argument order) differ at nearly every call site] → migrate entity by entity, grep every call, remove old names so missed sites fail loudly.
- [IPF insert/delete hooks behave differently for counters and permissions] → move counter updates into explicit post-insert/delete handling and verify with the spec scenarios.
- [No automated test suite in the repo] → PHP 8.2 lint plus a manual scenario checklist per phase; land phases separately.
- [Context7 IPF docs may be incomplete] → verify against the 2.0.3 source before committing to the pattern.

## Migration Plan

1. PHP 8.2 fixes (independent of IPF).
2. Migrate simple entities (Category, Rate, Text, Report, Read, Moderate), then Forum, Topic, Post.
3. Update call sites per entity as it migrates.
4. Delete `class/art/` and its includes; bump version metadata and docs.

No data migration; rollback is reverting the module files, since the schema is untouched.
