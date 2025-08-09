<?php
declare(strict_types=1);

namespace CakeUid\Test\TestCase\Database\Type;

use Cake\Core\Exception\CakeException;
use Cake\Database\Driver;
use Cake\Database\TypeFactory;
use Cake\Database\TypeInterface;
use Cake\TestSuite\TestCase;
use PDO;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\Uid\Ulid;
use Symfony\Component\Uid\Uuid;

/**
 * Test for the Binary uuid type.
 */
class BinaryUidTypeTest extends TestCase
{
    /**
     * @var \Cake\Database\Driver
     */
    protected $driver;

    /**
     * Setup
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->driver = $this->getMockBuilder(Driver::class)->getMock();
    }

    /**
     * Data provider for UID types
     *
     * @return array
     */
    public static function dataProviderForUidTypes(): array
    {
        return [
            [TypeFactory::build('binaryuuidv4'), 'uuid'],
            [TypeFactory::build('binaryuuidv6'), 'uuid'],
            [TypeFactory::build('binaryuuidv7'), 'uuid'],
            [TypeFactory::build('binaryulid'), 'ulid'],
        ];
    }

    /**
     * Test toPHP
     *
     * @param \CakeUid\Database\Type\AbstractBinaryType $type The type instance to test.
     */
    #[DataProvider('dataProviderForUidTypes')]
    public function testToPHP(TypeInterface $type, string $uidType): void
    {
        $this->assertNull($type->toPHP(null, $this->driver));

        $binary = $type->convertStringToBinaryUid($type->newId());
        $result = $type->toPHP($binary, $this->driver);

        match ($uidType) {
            'uuid' => $this->assertTrue(Uuid::isValid($result)),
            'ulid' => $this->assertTrue(Ulid::isValid($result)),
        };

        $fh = fopen(__FILE__, 'r');
        $result = $type->toPHP($fh, $this->driver);
        $this->assertSame($fh, $result);
        $this->assertIsResource($result);
        fclose($fh);
    }

    /**
     * Test exceptions on invalid data.
     */
    #[DataProvider('dataProviderForUidTypes')]
    public function testToPHPFailure(TypeInterface $type, string $uidType): void
    {
        $this->expectException(CakeException::class);
        $this->expectExceptionMessage('Unable to convert array into binary uuid.');

        $type->toPHP([], $this->driver);
    }

    /**
     * Test converting to database format
     */
    #[DataProvider('dataProviderForUidTypes')]
    public function testToDatabase(TypeInterface $type, string $uidType): void
    {
        $fh = fopen(__FILE__, 'r');
        $result = $type->toDatabase($fh, $this->driver);
        $this->assertSame($fh, $result);

        $value = match ($uidType) {
            'uuid' => Uuid::v7()->toString(), // Should we make this more dynamic?
            'ulid' => Ulid::generate(),
        };

        $result = $type->toDatabase($value, $this->driver);
        match ($uidType) {
            'uuid' => $this->assertSame($value, Uuid::fromBinary($result)->toString()),
            'ulid' => $this->assertSame($value, Ulid::fromBinary($result)->toString()),
        };
    }

    /**
     * Test converting to database format fails
     */
    #[DataProvider('dataProviderForUidTypes')]
    public function testToDatabaseInvalid(TypeInterface $type, string $uidType): void
    {
        $value = 'mUMPWUxCpaCi685A9fEwJZ';
        $result = $type->toDatabase($value, $this->driver);
        $this->assertNull($result);
    }

    /**
     * Test that the PDO binding type is correct.
     */
    #[DataProvider('dataProviderForUidTypes')]
    public function testToStatement(TypeInterface $type, string $uidType): void
    {
        $this->assertSame(PDO::PARAM_LOB, $type->toStatement('', $this->driver));
    }
}
