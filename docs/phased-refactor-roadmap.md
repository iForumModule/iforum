# Phased refactor roadmap

This roadmap describes the intended migration path while keeping the module installable and behaviorally stable.

## Phase 1: Developer safety nets

- Add CI coverage for PHP linting, coding standards, and static analysis.
- Document the Art → IPF migration path and PHP 8 review expectations.
- Introduce a shared bootstrap helper for module lookup and handler loading without wiring it into runtime paths yet.

## Phase 2: Shared access consolidation

- Replace duplicated module dirname and handler lookup code in low-risk files with the shared helper.
- Keep existing public entry points, hook signatures, and handler names unchanged.
- Add narrowly scoped validation to each migrated slice before widening coverage.

## Phase 3: Persistence layer migration

- Migrate one handler family at a time from Art-based patterns to IPF-friendly structures.
- Add adapters where needed so existing call sites keep working during the transition.
- Separate persistence concerns from presentation helpers as handlers move over.

## Phase 4: Cleanup and expansion

- Broaden coding standards and static analysis coverage once migrated areas are stable.
- Retire duplicate compatibility wrappers only after all call sites move to the shared abstractions.
- Update developer documentation as each migration phase lands.
