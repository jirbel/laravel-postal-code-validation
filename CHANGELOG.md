# Changelog

## 4.0.0

- Removed support for PHP 7.2
- Removed the `postal_code_for` validation rule
- Removed the rule builder, rules are now built through the `PostalCodes` facade
- Changed `postal_code_with`, it will now ignore fields with errors
- Fixed `TypeError` when input value was not stringable (e.g. an array)
- Fixed `TypeError` when a referenced value was not stringable (e.g. an array)
