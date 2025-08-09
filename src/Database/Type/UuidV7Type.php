<?php
declare(strict_types=1);

namespace CakeUid\Database\Type;

use Symfony\Component\Uid\Uuid;

/**
 * Provides behavior for the UUID v7 type
 */
final class UuidV7Type extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function generateUid(): string
    {
        return Uuid::v7()->toString();
    }
}
