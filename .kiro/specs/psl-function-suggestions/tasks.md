# Implementation Plan

-   [x] 1. Create core project structure and interfaces

    -   Set up the basic directory structure for the extension classes
    -   Create the main PslSuggestionsExtension class skeleton that implements RestrictedFunctionUsageExtension
    -   Create the FunctionMappingService class skeleton with basic constructor
    -   Set up basic test structure and PHPUnit configuration
    -   _Requirements: 3.2, 3.3_

-   [x] 2. Implement and test FunctionMappingService with comprehensive PSL mappings

    -   Create a comprehensive array of native PHP functions mapped to their PSL equivalents covering string, array, math, type, file, and encoding functions
    -   Implement getRestrictedFunctions() method to return array of native function names
    -   Write unit tests for getRestrictedFunctions() method
    -   Implement getPslEquivalent() method to lookup PSL function for a given native function
    -   Write unit tests for getPslEquivalent() method including edge cases
    -   Implement hasPslEquivalent() method to check if a native function has a PSL alternative
    -   Write unit tests for hasPslEquivalent() method
    -   _Requirements: 2.1, 2.2, 2.3_

-   [x] 3. Implement and test PslSuggestionsExtension core functionality

    -   Implement getRestrictedFunctions() method that delegates to FunctionMappingService
    -   Write unit tests for getRestrictedFunctions() delegation
    -   Implement getRestrictionError() method to analyze function calls and generate warnings
    -   Write unit tests for getRestrictionError() method with various function call scenarios
    -   Add private generateSuggestionMessage() method to create user-friendly warning messages
    -   Write unit tests for message generation including format consistency and content accuracy
    -   Handle function call context detection to avoid false positives for namespaced functions
    -   Write unit tests for edge cases including namespaced functions and user-defined functions
    -   _Requirements: 1.1, 1.2, 1.3, 4.1, 4.2, 4.3, 4.4, 5.1, 5.2, 5.3_

-   [x] 4. Create and test PHPStan extension configuration

    -   Create extension.neon configuration file to register the PslSuggestionsExtension with PHPStan
    -   Set up proper service definitions and dependency injection for the extension
    -   Write integration tests to verify the extension loads correctly in PHPStan
    -   Test that the extension integrates seamlessly with existing PHPStan workflows
    -   _Requirements: 3.1, 3.2_

-   [ ] 5. Create comprehensive integration tests and validation
    -   Create test fixtures with PHP code samples that use native functions with PSL equivalents
    -   Write PHPStan integration tests that verify warnings are generated correctly for real code
    -   Test performance impact to ensure minimal overhead during PHPStan analysis
    -   Validate that warning messages are consistent and helpful across all mapped functions
    -   Test the extension with various PHP code patterns to verify accuracy and avoid false positives
    -   _Requirements: 3.3, 5.1, 5.2, 5.3, 1.1, 1.2, 1.3, 4.1, 4.2, 4.3, 4.4_
