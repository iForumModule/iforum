# PHP 8 compatibility checklist

Use this checklist when touching legacy iForum code while PHP 8.2 through PHP 8.5 remain supported in CI.

## Baseline checks

- Keep `parallel-lint` green across the full `src/` tree.
- Keep coding standards and static analysis green for the shared bootstrap helper and any newly added developer-facing files.
- Avoid introducing dynamic properties, removed functions, or deprecated string/array access patterns.

## Review checklist for changes

- Confirm `include_once` and `require_once` paths still resolve correctly when dirname helpers are touched.
- Check for implicit `null` to scalar conversions and loose comparisons that become noisier on newer PHP versions.
- Prefer explicit return values over relying on legacy truthy/falsy behavior.
- Avoid adding new references to removed PHP extensions or incompatible third-party tooling.
- Keep legacy global state access (`icms::$module`, config arrays, handler factories) wrapped behind helper functions where possible.

## Before merging refactors

- Re-run the PHP quality workflow on PHP 8.2, 8.3, 8.4, and 8.5.
- Verify install/update hooks still load through `src/icms_version.php` and `src/include/module.php`.
- Confirm helper-only refactors do not alter templates, routes, or persisted data.
