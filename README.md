[![CI](https://github.com/josbeir/cakephp-uid/actions/workflows/ci.yml/badge.svg?branch=main)](https://github.com/josbeir/cakephp-uid/actions/workflows/ci.yml)
[![codecov](https://codecov.io/gh/josbeir/cakephp-uid/graph/badge.svg?token=CCX9UIFF28)](https://codecov.io/gh/josbeir/cakephp-uid)
[![PHPStan](https://img.shields.io/badge/PHPStan-level%208-brightgreen.svg?style=flat)](https://phpstan.org/)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%208.2-8892BF.svg)](https://php.net/)
[![Packagist Downloads](https://img.shields.io/packagist/dt/josbeir/cakephp-uid)](https://packagist.org/packages/josbeir/cakephp-uid)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE.md)

# CakePHP UID Plugin

A CakePHP plugin providing a collection of UID field types for your applications.

You can follow ongoing discussion about native UID support on the official CakePHP issue tracker [here](https://github.com/cakephp/cakephp/issues/18807). This plugin provides a solution until more convenient support is available in CakePHP core.

## Features

- **UUIDv4** field type
- **UUIDv6** field type
- **UUIDv7** field type
- **ULID** field type

Easily add modern, sortable unique identifiers to your CakePHP models.

## Installation

Install via Composer:

```bash
composer require josbeir/cakephp-uid
```

## Usage

Before using the UID field types in your schema, you need to map them using `TypeFactory::map` in your application bootstrap or plugin initialization:

If you want to use these types instead of CakePHP's [native ones](https://book.cakephp.org/5/en/orm/database-basics.html#data-types), you need to override the original types as shown below. CakePHP will handle the rest based on your database field settings.

- For UUID: use column type `UUID` (when supported by your db) or `BINARY(16)` or `CHAR(36)`:
- FOR ULID: use column type `BINARY(16)` or `CHAR(26)`:
- Remember that a UUID/BINARY is prefererd for performance reasons.

```php
TypeFactory::map('binaryuuid', BinaryUuidV7Type::class); // Uses UUID V7
TypeFactory::map('binaryuuid', BinaryUlidType::class); // Uses ULID
```

Other possibilities:
```php
TypeFactory::map('uuidv4', UuidV4Type::class);
TypeFactory::map('uuidv6', UuidV6Type::class);
TypeFactory::map('uuidv7', UuidV7Type::class);
TypeFactory::map('ulid', UlidType::class);
TypeFactory::map('binaryuuidv4', BinaryUuidV4Type::class);
TypeFactory::map('binaryuuidv6', BinaryUuidV6Type::class);
TypeFactory::map('binaryuuidv7', BinaryUuidV7Type::class);
TypeFactory::map('binaryulid', BinaryUlidType::class);
```

## Underlying Library

This plugin utilizes the [Symfony UID component](https://symfony.com/doc/current/components/uid.html) to generate, validate, and convert UIDs. Refer to the Symfony documentation for advanced usage and interoperability details.

## License

[MIT](LICENSE.md)

## Contributing

Pull requests are welcome. For major changes, please open an issue first.
