<?php
declare(strict_types=1);

namespace CakeUid\Database\Type;

use Symfony\Component\Uid\Ulid;

/**
 * Provides behavior for the UUID v6 type
 */
final class BinaryUlidType extends AbstractBinaryType
{
    /**
     * @inheritDoc
     */
    public function convertBinaryUidToString(mixed $binary): string
    {
        return Ulid::fromBinary($binary)->toString();
    }

    /**
     * @inheritDoc
     */
    public function convertStringToBinaryUid(string $string): string
    {
        return Ulid::fromString($string)->toBinary();
    }

    /**
     * @inheritDoc
     */
    public function generateUid(): string
    {
        return Ulid::generate();
    }

    /**
     * @inheritDoc
     */
    public function isValid(string $uid): bool
    {
        return Ulid::isValid($uid);
    }
}
