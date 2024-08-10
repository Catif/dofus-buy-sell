<?php

namespace Catif\Dofus\Class;

use PDO;
use PDOException;

class Database
{
  public static ?PDO $db_connection = null;
  const DEFAULT_CHUNK_SIZE = [
    'create' => 300,
    'delete' => 300,
  ];

  public static function setConnection($config)
  {
    try {
      $dsn_explode = [
        'mysql:host=' . $config['host'],
        'dbname=' . $config['dbname'],
        'port=' . $config['port']
      ];
      $dsn = implode(';', $dsn_explode);

      self::$db_connection = new PDO($dsn, $config['username'], $config['password'], [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
      ]);
    } catch (PDOException $e) {
      error('Connection failed: ' . $e->getMessage());
      die();
    }
  }

  public static function connectByEnv()
  {
    $config = [
      'host' => config('database.host'),
      'dbname' => config('database.dbname'),
      'username' => config('database.username'),
      'password' => config('database.password'),
      'port' => config('database.port'),
    ];

    self::setConnection($config);
  }

  public static function getInstance()
  {
    if (self::$db_connection === null) {
      error('Database connection not set');
      die();
    }

    return self::$db_connection;
  }

  public function insert(string $table, array $data, int $chunk_size = self::DEFAULT_CHUNK_SIZE['create'])
  {
    try {
      $is_chunked = isset($data[0]) ? is_array($data[0]) : false;

      $data = $is_chunked ? $data : [$data];

      $columns = implode(', ', array_keys($data[0]));

      // formating \' to avoid errors
      foreach (array_chunk($data, $chunk_size) as $chunk) {
        $escaped_values = array_map(
          fn($value) => array_map(fn($v) => str_replace("'", "\'", $v), $value),
          $chunk
        );

        $values = implode(', ', array_map(
          fn($value) => '(' . implode(', ', array_map(fn($v) => "'$v'", $value)) . ')',
          $escaped_values
        ));

        $sql = "INSERT INTO $table ($columns) VALUES $values";

        self::$db_connection->exec($sql);
      }
    } catch (PDOException $e) {
      error('Insert failed: ' . $e->getMessage());
      die();
    }
  }

  public function find(string $table, int $id): ?object
  {
    $sql = "SELECT * FROM $table WHERE id = $id";

    $stmt = self::$db_connection->query($sql);

    return $stmt->fetch();
  }
}
