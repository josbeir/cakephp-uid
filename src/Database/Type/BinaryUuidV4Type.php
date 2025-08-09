<?php
declare(strict_types=1);

namespace CakeUid\Database\Type;

use Symfony\Component\Uid\Uuid;

/**
 * Provides behavior for the UUID v4 type
 */
final class BinaryUuidV4Type extends AbstractBinaryType
{
    /**
     * @inheritDoc
     */
    public function convertBinaryUidToString(mixed $binary): string
    {
        return Uuid::fromBinary($binary)->toString();
    }

    /**
     * @inheritDoc
     */
    public function convertStringToBinaryUid(string $string): string
    {
        return Uuid::fromString($string)->toBinary();
    }

    /**
     * @inheritDoc
     */
    public function generateUid(): string
    {
        return Uuid::v4()->toString();
    }

    /**
     * @inheritDoc
     */
    public function isValid(string $uid): bool
    {
        return Uuid::isValid($uid);
    }
}
