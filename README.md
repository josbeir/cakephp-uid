# CakePHP UID Plugin

A CakePHP plugin providing a collection of UID field types for your applications.

## Features

- **UUIDv6** field type
- **UUIDv7** field type
- **ULID** field type

Easily add modern, sortable unique identifiers to your CakePHP models.

## Installation

Install via Composer:

```bash
composer require josbeir/cakephp-uid
```

Load the plugin in your `Application.php`:

```php
$this->addPlugin('Uid');
```

## Usage

Before using the UID field types in your schema, you need to map them using `TypeFactory::map` in your application bootstrap or plugin initialization:

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

Use the field types in your tables as you would with standard UUIDs.

### Example: Setting a UID Field Type in a Table

To use a UID field type in your table, set the column type in the `initialize` method:

```php
public function initialize(array $config): void
{
    parent::initialize($config);

    // Set the 'id' column to use the 'uuidv7' type
    $this->getSchema()->setColumnType('id', 'uuidv7');
}
```

## Supported Field Types

- `uuidv4`
- `uuidv6`
- `uuidv7`
- `ulid`

## Underlying Library

This plugin utilizes the [Symfony UID component](https://symfony.com/doc/current/components/uid.html) to generate, validate, and convert UIDs. Refer to the Symfony documentation for advanced usage and interoperability details.

## License

MIT

## Contributing

Pull requests are welcome. For major changes, please open an issue first.
