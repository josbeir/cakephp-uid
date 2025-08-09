<?php
declare(strict_types=1);

namespace CakeUid\Database\Type;

use Cake\Core\Exception\CakeException;
use Cake\Database\Driver;
use Cake\Database\Type\BaseType;
use PDO;

/**
 * Binary UID type converter.
 *
 * Use to convert binary uid data between PHP and the database types.
 */
abstract class AbstractBinaryType extends BaseType
{
    /**
     * Convert binary uid data into the database format.
     *
     * Binary data is not altered before being inserted into the database.
     * As PDO will handle reading file handles.
     *
     * @param mixed $value The value to convert.
     * @param \Cake\Database\Driver $driver The driver instance to convert with.
     * @return mixed
     */
    public function toDatabase(mixed $value, Driver $driver): mixed
    {
        if (!is_string($value)) {
            return $value;
        }

        if (!$this->isValid($value)) {
            return null;
        }

        return $this->convertStringToBinaryUid($value);
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
     * Convert binary uuid into resource handles
     *
     * @param mixed $value The value to convert.
     * @param \Cake\Database\Driver $driver The driver instance to convert with.
     * @return resource|string|null
     * @throws \Cake\Core\Exception\CakeException
     */
    public function toPHP(mixed $value, Driver $driver): mixed
    {
        if ($value === null) {
            return null;
        }
        if (is_string($value)) {
            return $this->convertBinaryUidToString($value);
        }
        if (is_resource($value)) {
            return $value;
        }

        throw new CakeException(sprintf('Unable to convert %s into binary uuid.', gettype($value)));
    }

    /**
     * @inheritDoc
     */
    public function toStatement(mixed $value, Driver $driver): int
    {
        return PDO::PARAM_LOB;
    }

    /**
     * Marshals flat data into PHP objects.
     *
     * Most useful for converting request data into PHP objects
     * that make sense for the rest of the ORM/Database layers.
     *
     * @param mixed $value The value to convert.
     * @return mixed Converted value.
     */
    public function marshal(mixed $value): mixed
    {
        return $value;
    }

    /**
     * Converts a binary UID to a string representation
     *
     * @param mixed $binary The value to convert.
     * @return string Converted value.
     */
    abstract public function convertBinaryUidToString(mixed $binary): string;

    /**
     * Converts a string UID to a binary representation.
     *
     * @param string $string The value to convert.
     * @return string Converted value.
     */
    abstract public function convertStringToBinaryUid(string $string): string;

    /**
     * Check if the given UID is valid.
     *
     * @param string $uid The UID to validate.
     * @return bool True if valid, false otherwise.
     */
    abstract public function isValid(string $uid): bool;
}
