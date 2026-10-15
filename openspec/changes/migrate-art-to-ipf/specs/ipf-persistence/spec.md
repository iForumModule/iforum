## Purpose

Defines how iForum stores and retrieves forum data (categories, forums, topics, posts, moderation, ratings, read tracking, reports) through ImpressCMS's native persistence framework while keeping the existing database schema and forum behavior.

## ADDED Requirements

### Requirement: Existing schema is preserved
The module SHALL read and write the existing `bb_*` tables without requiring any schema change or data migration when upgrading from the Art-based version.

#### Scenario: Upgrade on existing data
- **WHEN** a site with a populated Art-based iForum installation loads the refactored module
- **THEN** all existing categories, forums, topics, posts, ratings, read marks, moderation entries and reports are visible and editable with no database update step

### Requirement: All forum entities persist through the CMS persistence framework
Categories, forums, topics, posts, post text, moderation entries, ratings, read markers and reports SHALL be created, loaded, updated and deleted through ImpressCMS IPF objects and handlers, and the module SHALL NOT depend on the Art framework.

#### Scenario: Create a post
- **WHEN** a user submits a new post
- **THEN** the post and its text are stored, the topic and forum counters and last-post data are updated, and the post is retrievable by id

#### Scenario: Art framework absent
- **WHEN** the module directory contains no Art framework files
- **THEN** every public and admin page still loads without a missing-class or missing-file error

### Requirement: Relational helper operations remain available
The module SHALL provide counts grouped by a related key, bulk updates and deletes through a related table, orphan cleanup, and counter synchronization with the same results as before the migration.

#### Scenario: Orphan cleanup
- **WHEN** an administrator runs forum maintenance after posts were removed directly from the database
- **THEN** dependent rows with no parent are removed and parent counters match actual row counts

#### Scenario: Bulk delete through a relation
- **WHEN** a forum is pruned or deleted
- **THEN** its topics, posts, post text and related read/rating rows are removed and no related rows remain

### Requirement: User-visible output is unchanged
Text fields (titles, post bodies, descriptions) SHALL render with the same sanitizing and formatting as before the migration.

#### Scenario: Post rendering
- **WHEN** a post containing BBCode, smilies and HTML-special characters is displayed
- **THEN** the rendered output equals the pre-migration output and contains no unescaped user markup
