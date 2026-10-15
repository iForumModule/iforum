## Why

iForum's data layer sits on the XOOPS-era "Art" framework (`class/art/`, ~2.3k lines), which duplicates what ImpressCMS 2.0.3 ships natively as IPF (`icms_ipf_Object` / `icms_ipf_Handler`) and still calls removed `mysql_*` functions, making the module fatal on PHP 8. Moving to IPF removes a vendored framework to maintain and makes the module run on the platform it targets (ImpressCMS 2.0.3, PHP 8.2+).

## What Changes

- Replace `ArtObject` / `ArtObjectHandler` (and `_XoopsPersistable*`, Joint/Recon/Stats/Write/Render delegates) with IPF base classes for all entities: Category, Forum, Topic, Post, Text, Moderate, Rate, Read, Report.
- Move to IPF-style class naming (e.g. `mod_iforum_PostHandler`) and IPF handler retrieval instead of `iforum_getHandler` / `load_object()`.
- Re-implement Art-only handler features that IPF lacks (`getByLink`, `getCountsByLink`, `updateByLink`, `deleteByLink`, `cleanOrphan`, `synchronization`, grouped `getCounts`) as module-specific methods using plain SQL.
- Remove `mysql_*` usage (`admin_forum_prune.php`, `mysql_major_version()` checks in ~10 places) and fix other PHP 8.2 incompatibilities (`eval` in `mod_loadRenderer`, dynamic properties, implicit nullables, reference-return signatures).
- Delete `class/art/` and its includes from `header.php`, `admin/admin_header.php`, `icms_version.php`, `include/functions.ini.php`.
- **BREAKING**: requires ImpressCMS 2.0.3+ and PHP 8.2+; no XOOPS/older-ICMS compatibility. Class names change, so third-party code referencing `Post`, `IforumPostHandler`, etc. breaks.
- Database schema (`bb_*` tables) is unchanged; no data migration.

## Capabilities

### New Capabilities
- `ipf-persistence`: Forum entities (categories, forums, topics, posts, text, moderation, rating, read tracking, reports) are persisted via ImpressCMS IPF objects and handlers over the unchanged `bb_*` schema, including the relational helpers (link queries, orphan cleanup, synchronization, grouped counts).
- `runtime-requirements`: The module declares and works on ImpressCMS 2.0.3+ and PHP 8.2+ with no use of removed PHP/MySQL APIs.

### Modified Capabilities
<!-- None: no existing specs; user-visible forum behavior is intended to stay the same. -->

## Impact

- Code: all of `class/*.php`, `class/art/*` (removed), `include/functions.ini.php`, `header.php`, `admin/admin_header.php`, `icms_version.php`, plus every call site of Art handler methods in root pages, `admin/`, `blocks/`, `include/`.
- Dependencies: ImpressCMS IPF (core); drops the vendored Art framework.
- Risk: `getVar` output formatting differs between Art and IPF, so templates need regression checks; Art handler signatures (reference returns, `getAll`/`getObjects`) differ at call sites.
- Docs: README/CHANGELOG state the new minimum versions.
