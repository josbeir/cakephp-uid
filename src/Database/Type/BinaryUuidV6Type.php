<?php
declare(strict_types=1);

namespace CakeUid\Database\Type;

use Symfony\Component\Uid\Uuid;

/**
 * Provides behavior for the UUID v6 type
 */
final class BinaryUuidV6Type extends AbstractBinaryType
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
    protected function generateUid(): string
    {
        return Uuid::v6()->toString();
    }

    /**
     * @inheritDoc
     */
    public function isValid(string $uid): bool
    {
        return Uuid::isValid($uid);
    }
}
