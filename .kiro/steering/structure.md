# Project Structure

## Root Directory
```
├── .editorconfig           # Editor configuration
├── .git/                   # Git repository
├── .github/                # GitHub workflows and templates
├── .gitignore             # Git ignore rules
├── .idea/                 # IDE configuration
├── .kiro/                 # Kiro AI assistant configuration
├── .phpunit.cache/        # PHPUnit cache directory
├── CHANGELOG.md           # Version history
├── LICENSE.md             # MIT license
├── README.md              # Project documentation
├── build/                 # Build artifacts and reports
├── composer.json          # Composer configuration
├── composer.lock          # Dependency lock file
├── phpunit.xml.dist       # PHPUnit configuration
├── src/                   # Source code
├── tests/                 # Test files
└── vendor/                # Composer dependencies
```

## Source Organization

### `/src` Directory
- Contains main application code
- Namespace: `ErikGaal\PhpstanPslSuggestions`
- Main class: `PhpstanPslSuggestionsClass.php`
- Uses PSR-4 autoloading

### `/tests` Directory  
- Contains PHPUnit test files
- Namespace: `ErikGaal\PhpstanPslSuggestions\Tests`
- Test classes extend `PHPUnit\Framework\TestCase`
- Uses PSR-4 autoloading for test classes

### `/build` Directory
- Generated build artifacts
- Coverage reports (HTML, text, clover)
- JUnit test reports

## Naming Conventions
- **Classes**: PascalCase with descriptive names
- **Namespaces**: Follow PSR-4 standard
- **Files**: Match class names exactly
- **Tests**: Suffix with `Test.php`

## Key Files
- `composer.json`: Package definition and scripts
- `phpunit.xml.dist`: Test configuration with coverage settings
- `.editorconfig`: Code formatting standards