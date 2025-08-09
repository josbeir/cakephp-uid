<?php
declare(strict_types=1);

use Cake\Cache\Cache;
use Cake\Chronos\Chronos;
use Cake\Core\Configure;
use Cake\Database\TypeFactory;
use Cake\Datasource\ConnectionManager;
use Cake\TestSuite\Fixture\SchemaLoader;
use CakeUid\Database\Type\BinaryUlidType;
use CakeUid\Database\Type\BinaryUuidV4Type;
use CakeUid\Database\Type\BinaryUuidV6Type;
use CakeUid\Database\Type\BinaryUuidV7Type;
use CakeUid\Database\Type\UlidType;
use CakeUid\Database\Type\UuidV4Type;
use CakeUid\Database\Type\UuidV6Type;
use CakeUid\Database\Type\UuidV7Type;

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

define('PLUGIN_ROOT', dirname(__DIR__));
define('ROOT', PLUGIN_ROOT . DS . 'tests' . DS . 'test_app');
define('TMP', PLUGIN_ROOT . DS . 'tmp' . DS);
define('LOGS', TMP . 'logs' . DS);
define('CACHE', TMP . 'cache' . DS);
define('APP', ROOT . DS . 'src' . DS);
define('APP_DIR', 'src');
define('CAKE_CORE_INCLUDE_PATH', PLUGIN_ROOT . '/vendor/cakephp/cakephp');
define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
define('CAKE', CORE_PATH . APP_DIR . DS);
define('WWW_ROOT', PLUGIN_ROOT . DS . 'webroot' . DS);
define('TESTS', __DIR__ . DS);
define('CONFIG', TESTS . 'config' . DS);

require PLUGIN_ROOT . '/vendor/autoload.php';
require CORE_PATH . 'config/bootstrap.php';

Configure::write('App', [
    'namespace' => 'CakeUid\Test\App',
    'encoding' => 'UTF-8',
    'fullBaseUrl' => 'http://localhost',
]);

Configure::write('debug', true);

$cache = [
    'default' => [
        'engine' => 'File',
    ],
    '_cake_model_' => [
        'className' => 'File',
        'prefix' => 'crud_my_app_cake_model_',
        'path' => CACHE . 'models/',
        'serialize' => 'File',
        'duration' => '+10 seconds',
    ],
];
Cache::setConfig($cache);

Chronos::setTestNow(Chronos::now());
session_id('cli');

// Ensure default test connection is defined
if (!getenv('DB_URL')) {
    putenv('DB_URL=sqlite:///:memory:');
}

ConnectionManager::setConfig('test', [
    'url' => getenv('DB_URL'),
    'timezone' => 'UTC',
    'quoteIdentifiers' => true,
    'cacheMetadata' => true,
]);

TypeFactory::map('uuidv4', UuidV4Type::class);
TypeFactory::map('uuidv6', UuidV6Type::class);
TypeFactory::map('uuidv7', UuidV7Type::class);
TypeFactory::map('ulid', UlidType::class);
TypeFactory::map('binaryuuidv4', BinaryUuidV4Type::class);
TypeFactory::map('binaryuuidv6', BinaryUuidV6Type::class);
TypeFactory::map('binaryuuidv7', BinaryUuidV7Type::class);
TypeFactory::map('binaryulid', BinaryUlidType::class);

if (getenv('FIXTURE_SCHEMA_METADATA')) {
    $loader = new SchemaLoader();
    $loader->loadSqlFiles('./tests/schema.sql', 'test');
}
