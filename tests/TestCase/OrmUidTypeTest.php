<?php
declare(strict_types=1);

namespace CakeUid\Test\TestCase;

use Cake\Database\Connection;
use Cake\Database\Driver\Sqlite;
use Cake\ORM\Table;
use Cake\TestSuite\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

/**
 * UID generation and conversion through the ORM and a real database driver.
 */
class OrmUidTypeTest extends TestCase
{
    /**
     * @return list<array{string, int}>
     */
    public static function uidTypes(): array
    {
        return [
            ['uuidv4', 36],
            ['uuidv6', 36],
            ['uuidv7', 36],
            ['ulid', 26],
            ['binaryuuidv4', 16],
            ['binaryuuidv6', 16],
            ['binaryuuidv7', 16],
            ['binaryulid', 16],
        ];
    }

    #[DataProvider('uidTypes')]
    public function testGeneratedPrimaryKeyRoundTrips(string $typeName, int $storedLength): void
    {
        $connection = new Connection([
            'driver' => Sqlite::class,
            'database' => ':memory:',
            'username' => '',
            'password' => '',
        ]);
        $columnType = str_starts_with($typeName, 'binary') ? 'BLOB' : 'VARCHAR(36)';
        $connection->execute('CREATE TABLE uids (id ' . $columnType . ' PRIMARY KEY, label VARCHAR(255) NOT NULL)');

        $table = new Table(['table' => 'uids', 'connection' => $connection]);
        $table->getSchema()->setColumnType('id', $typeName);

        $entity = $table->newEntity(['label' => 'UID round trip']);
        $saved = $table->saveOrFail($entity);
        $this->assertIsString($saved->get('id'));
        $this->assertNotEmpty($saved->get('id'));

        $loaded = $table->get($saved->get('id'));
        $this->assertSame($saved->get('id'), $loaded->get('id'));
        $this->assertSame('UID round trip', $loaded->get('label'));

        $stored = $connection->execute('SELECT length(id) AS length FROM uids')->fetch('assoc');
        $this->assertSame($storedLength, $stored['length']);
        $connection->getDriver()->disconnect();
    }
}
