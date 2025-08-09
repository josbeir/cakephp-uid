<?php
declare(strict_types=1);

namespace CakeUid\Test\TestCase\Database\Type;

use Cake\Database\Driver;
use Cake\Database\TypeFactory;
use Cake\Database\TypeInterface;
use Cake\TestSuite\TestCase;
use PDO;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\Uid\Ulid;
use Symfony\Component\Uid\Uuid;

/**
 * Test for the Uuid type.
 */
class UidTypeTest extends TestCase
{
    /**
     * @var \CakeUid\Database\Type\UuidV7Type
     */
    protected $type;

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
            [TypeFactory::build('uuidv6'), 'uuid'],
            [TypeFactory::build('uuidv4'), 'uuid'],
            [TypeFactory::build('uuidv7'), 'uuid'],
            [TypeFactory::build('ulid'), 'ulid'],
        ];
    }

    /**
     * Test toPHP
     */
    #[DataProvider('dataProviderForUidTypes')]
    public function testToPHP(TypeInterface $type, string $uidType): void
    {
        $this->assertNull($type->toPHP(null, $this->driver));

        $result = $type->toPHP('some data', $this->driver);
        $this->assertSame('some data', $result);

        $result = $type->toPHP(2, $this->driver);
        $this->assertSame('2', $result);
    }

    /**
     * Test converting to database format
     */
    #[DataProvider('dataProviderForUidTypes')]
    public function testToDatabase(TypeInterface $type, string $uidType): void
    {
        $result = $type->toDatabase('some data', $this->driver);
        $this->assertSame('some data', $result);

        $result = $type->toDatabase(2, $this->driver);
        $this->assertSame('2', $result);

        $result = $type->toDatabase(null, $this->driver);
        $this->assertNull($result);

        $result = $type->toDatabase('', $this->driver);
        $this->assertNull($result);

        $result = $type->toDatabase(false, $this->driver);
        $this->assertNull($result);
    }

    /**
     * Test that the PDO binding type is correct.
     */
    #[DataProvider('dataProviderForUidTypes')]
    public function testToStatement(TypeInterface $type, string $uidType): void
    {
        $this->assertSame(PDO::PARAM_STR, $type->toStatement('', $this->driver));
    }

    /**
     * Test generating new ids
     */
    #[DataProvider('dataProviderForUidTypes')]
    public function testNewId(TypeInterface $type, string $uidType): void
    {
        $one = $type->newId();
        $two = $type->newId();

        $this->assertNotEquals($one, $two, 'Should be different values');

        match ($uidType) {
            'uuid' => $this->assertTrue(Uuid::isValid($one), 'UUID should be valid'),
            'ulid' => $this->assertTrue(Ulid::isValid($one), 'ULID should be valid'),
        };
    }

    /**
     * Tests that marshalling an empty string results in null
     */
    #[DataProvider('dataProviderForUidTypes')]
    public function testMarshal(TypeInterface $type, string $uidType): void
    {
        $this->assertNull($type->marshal(''));
        $this->assertSame('2', $type->marshal(2));
        $this->assertSame('word', $type->marshal('word'));
        $this->assertNull($type->marshal([1, 2]));
    }
}
