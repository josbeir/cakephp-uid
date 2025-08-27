<?php
declare(strict_types=1);

namespace CakeUid\Database\Type;

use Symfony\Component\Uid\Uuid;

/**
 * Provides behavior for the UUID v7 type
 */
final class BinaryUuidV7Type extends AbstractBinaryType
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
        return Uuid::v7()->toString();
    }

    /**
     * @inheritDoc
     */
    public function isValid(string $uid): bool
    {
        return Uuid::isValid($uid);
    }
}
