# Product Overview

This is a PHPStan extension that provides rules to suggest azziez/psl (PHP Standard Library) replacements for native PHP features.

## Purpose
- Analyzes PHP code to identify opportunities where native PHP functions could be replaced with PSL equivalents
- Helps developers adopt more consistent and potentially safer PSL alternatives
- Integrates with PHPStan's static analysis workflow

## Key Features
- PHPStan extension that implements `RestrictedFunctionUsageExtension`
- Suggests PSL replacements for native PHP functions
- Packaged as a Composer package for easy distribution

## Target Users
PHP developers using PHPStan for static analysis who want to adopt the PSL library consistently across their codebase.