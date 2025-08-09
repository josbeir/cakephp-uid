<?php
declare(strict_types=1);

namespace CakeUid\Database\Type;

use Symfony\Component\Uid\Uuid;

/**
 * Provides behavior for the UUID V6 type
 */
final class UuidV6Type extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function generateUid(): string
    {
        return Uuid::v6()->toString();
    }
}
