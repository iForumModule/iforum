## Purpose

States the platform versions iForum supports and the language and database API constraints that follow, so the module installs and runs on current ImpressCMS and PHP releases.

## ADDED Requirements

### Requirement: Supported platform versions
The module SHALL declare ImpressCMS 2.0.3 as its minimum version and SHALL run on PHP 8.2 and later, without compatibility code for XOOPS or earlier ImpressCMS.

#### Scenario: Install on supported stack
- **WHEN** the module is installed or updated on ImpressCMS 2.0.3 with PHP 8.2
- **THEN** installation succeeds and the forum index, a forum, a topic, posting and the admin pages load without PHP errors or deprecation notices from the module

#### Scenario: Unsupported ImpressCMS
- **WHEN** the module is installed on a release older than 2.0.3
- **THEN** the module's documentation and metadata state that it is unsupported

### Requirement: No removed PHP or MySQL APIs
The module SHALL NOT call removed PHP functions (including the `mysql_*` extension, `each`, `create_function`) and SHALL NOT use `eval` to resolve classes.

#### Scenario: Forum prune
- **WHEN** an administrator prunes a forum and the confirmation lists forum names
- **THEN** the names are read through the CMS database layer and the page completes without a fatal error

#### Scenario: Static check
- **WHEN** a lint and static-analysis pass runs over the module with PHP 8.2
- **THEN** it reports no syntax errors and no calls to removed functions

### Requirement: Database version checks removed
The module SHALL NOT branch on the MySQL server version for legacy servers (below 4.1/5.0).

#### Scenario: Counting queries
- **WHEN** forum, topic or post counts are computed
- **THEN** a single modern SQL path is used regardless of server version
