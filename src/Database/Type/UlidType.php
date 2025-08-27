<?php
declare(strict_types=1);

namespace CakeUid\Database\Type;

use Symfony\Component\Uid\Ulid;

/**
 * Provides behavior for the UUID type
 */
class UlidType extends AbstractType
{
    /**
     * @inheritDoc
     */
    protected function generateUid(): string
    {
        return Ulid::generate();
    }
}
