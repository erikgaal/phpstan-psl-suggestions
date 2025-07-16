# Technology Stack

## Core Technologies
- **PHP**: ^8.4 (minimum version)
- **PHPStan**: ^2.1.13 (static analysis framework)
- **Package Type**: phpstan-extension

## Development Dependencies
- **PHPUnit**: ^10.3.2 (testing framework)
- **Laravel Pint**: ^1.0 (code formatting)
- **Spatie Ray**: ^1.28 (debugging tool)

## Build System
- **Composer**: Package management and autoloading
- **PSR-4**: Autoloading standard

## Common Commands

### Testing
```bash
composer test                # Run PHPUnit tests
composer test-coverage       # Run tests with coverage report
```

### Code Quality
```bash
composer format             # Format code using Laravel Pint
```

### Installation
```bash
composer require erikgaal/phpstan-psl-suggestions
```

## Code Standards
- Uses Laravel Pint for code formatting
- EditorConfig settings: 4 spaces, UTF-8, LF line endings
- YAML files use 2-space indentation
- Markdown files preserve trailing whitespace

## Architecture
- Implements PHPStan's `RestrictedFunctionUsageExtension` interface
- Uses readonly classes for immutability
- Follows PSR-4 autoloading conventions