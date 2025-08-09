<?php
declare(strict_types=1);

namespace CakeUid\Database\Type;

use Cake\Database\Driver;
use Cake\Database\Type\StringType;

/**
 * Provides behavior for the Uid type
 */
abstract class AbstractType extends StringType
{
    /**
     * Casts given value from a PHP type to one acceptable by database
     *
     * @param mixed $value value to be converted to database equivalent
     * @param \Cake\Database\Driver $driver object from which database preferences and configuration will be extracted
     * @return string|null
     */
    public function toDatabase(mixed $value, Driver $driver): ?string
    {
        if ($value === null || $value === '' || $value === false) {
            return null;
        }

        return parent::toDatabase($value, $driver);
    }

    /**
     * Generate a new UUID
     *
     * @return string A new primary key value.
     */
    public function newId(): string
    {
        return $this->generateUid();
    }

    /**
     * Generate a new UID
     *
     * This method should be implemented by subclasses to generate the specific type of UID.
     *
     * @return string A new UID value.
     */
    abstract protected function generateUid(): string;

    /**
     * Marshals request data into a PHP string
     *
     * @param mixed $value The value to convert.
     * @return string|null Converted value.
     */
    public function marshal(mixed $value): ?string
    {
        if ($value === null || $value === '' || is_array($value)) {
            return null;
        }

        return (string)$value;
    }
}
