# Art → IPF migration matrix

This module still mixes legacy Art-based persistence patterns with newer ImpressCMS conventions. The matrix below captures the intended migration target without changing runtime behavior in this PR.

| Legacy area | Current responsibility | IPF-oriented target | Notes for follow-up |
| --- | --- | --- | --- |
| `src/class/art/object.php` and related Art base classes | Shared object lifecycle, validation, and persistence helpers | Replace with IPF object and handler base classes | Start with low-risk handlers that already map cleanly to one table each |
| `src/class/forum.php`, `src/class/topic.php`, `src/class/post.php` | Module domain objects and handler logic | Move table mapping and CRUD concerns into dedicated IPF handlers | Keep public method names stable while adapters are introduced |
| `src/include/functions.ini.php` config loading | Module-wide config bootstrap | Route shared module/config access through the new bootstrap helper first | This reduces repeated dirname lookups before broader refactors |
| Direct `icms_getmodulehandler()` calls throughout `src/` | Per-file handler lookup | Centralize lookup behind helper functions | Lets later refactors swap implementations in one place |
| Install and update hooks in `src/include/module.php` | Schema/bootstrap orchestration | Move schema-aware logic behind dedicated service-style helpers | Leave hook entry points intact for compatibility |
| Template-facing utility functions in `src/include/functions.php` | Mixed rendering and data access helpers | Separate presentation helpers from persistence access | Tackle after handler loading is consolidated |

## Migration guardrails

- Preserve the current module entry points and install/update hooks until handler migrations are complete.
- Refactor one handler family at a time so existing forum, topic, and post behavior stays unchanged.
- Prefer adding adapters and compatibility layers before deleting Art-based code.
- Expand CI coverage alongside each phase so new IPF-oriented code is checked on all supported PHP versions.
