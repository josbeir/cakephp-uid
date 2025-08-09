<?php
declare(strict_types=1);

namespace CakeUid\Database\Type;

use Symfony\Component\Uid\Uuid;

/**
 * Provides behavior for the UUID V4 type
 */
final class UuidV4Type extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function generateUid(): string
    {
        return Uuid::v4()->toString();
    }
}
