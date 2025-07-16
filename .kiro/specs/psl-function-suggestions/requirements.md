# Requirements Document

## Introduction

This feature will enhance the existing PHPStan extension to automatically identify native PHP functions that have equivalent azziez/psl (PHP Standard Library) alternatives and suggest developers use the PSL versions instead. The extension will analyze PHP code during static analysis and provide friendly warnings when native functions could be replaced with their PSL counterparts, helping teams adopt PSL consistently across their codebase.

## Requirements

### Requirement 1

**User Story:** As a PHP developer using PHPStan, I want to receive warnings when I use native PHP functions that have PSL equivalents, so that I can consistently adopt PSL throughout my codebase.

#### Acceptance Criteria

1. WHEN the extension encounters a native PHP function call that has a PSL equivalent THEN the system SHALL display a warning message suggesting the PSL alternative
2. WHEN the warning is displayed THEN the system SHALL include both the native function name and the recommended PSL function name
3. WHEN the warning is displayed THEN the system SHALL provide a friendly, helpful message explaining the suggestion

### Requirement 2

**User Story:** As a developer maintaining the PHPStan extension, I want a comprehensive mapping of native PHP functions to their PSL equivalents, so that the extension can accurately identify all possible replacements.

#### Acceptance Criteria

1. WHEN the system is initialized THEN it SHALL contain a complete index of native PHP functions that have PSL equivalents
2. WHEN a new PSL function equivalent is added to the azziez/psl library THEN the mapping SHALL be easily updatable
3. WHEN the mapping is accessed THEN it SHALL provide both the native function name and the corresponding PSL function name

### Requirement 3

**User Story:** As a PHP developer, I want the PSL suggestions to integrate seamlessly with my existing PHPStan workflow, so that I don't need to change my development process.

#### Acceptance Criteria

1. WHEN PHPStan analyzes my code THEN the PSL suggestions SHALL be included in the standard analysis output
2. WHEN the extension is installed THEN it SHALL work with existing PHPStan configurations without additional setup
3. WHEN the extension runs THEN it SHALL not significantly impact PHPStan's performance

### Requirement 4

**User Story:** As a team lead, I want clear and actionable warning messages, so that developers can easily understand what changes to make.

#### Acceptance Criteria

1. WHEN a warning is generated THEN the message SHALL clearly identify the specific native function being flagged
2. WHEN a warning is generated THEN the message SHALL provide the exact PSL function name to use as a replacement
3. WHEN a warning is generated THEN the message SHALL be formatted consistently with other PHPStan messages
4. WHEN a warning is generated THEN the message SHALL include context about why the PSL alternative is recommended

### Requirement 5

**User Story:** As a developer, I want the extension to handle edge cases gracefully, so that it doesn't produce false positives or miss valid suggestions.

#### Acceptance Criteria

1. WHEN the extension encounters a function call in a namespace THEN it SHALL correctly identify whether it's a native PHP function or a namespaced function
2. WHEN the extension encounters a function call with the same name as a native function but in a different context THEN it SHALL not produce false warnings
3. WHEN the extension encounters a native function that doesn't have a PSL equivalent THEN it SHALL not generate any warning