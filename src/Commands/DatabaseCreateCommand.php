<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Exception;
use PDO;
use PDOException;

class DatabaseCreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command creates a new database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $connection = config('database.default');

        $default = config("database.connections.$connection");
        $database = $default['database'];
        $host = $default['host'];
        $port = $default['port'];
        $username = $default['username'];
        $password = $default['password'];

        if (! $database) {
            $this->info('Skipping creation of database as env(DB_DATABASE) is empty');
            return;
        }

        try {
            $pdo = $this->getPDOConnection($connection, $host, $port, $username, $password);

            $this->pdoCreateDatabase($pdo, $connection, $database);

            $this->info(sprintf('Successfully created %s database', $database));
        } catch (PDOException $exception) {
            $this->error(sprintf('Failed to create %s database, %s', $database, $exception->getMessage()));
        }
    }

    /**
     * @param  string $connection
     * @param  string $host
     * @param  integer $port
     * @param  string $username
     * @param  string $password
     * @return PDO
     */
    private function getPDOConnection($connection, $host, $port, $username, $password)
    {
        switch ($connection) {
            case 'sqlsrv':
                return new PDO(sprintf('sqlsrv:Server=%s,%s;', $host, $port), $username, $password);
            case 'mysql':
                return new PDO(sprintf('mysql:host=%s;port=%d;', $host, $port), $username, $password);
        }

        throw new Exception('Unsupported database connection: '.$connection);
    }

    /**
     * @param  PDO
     * @param  string $connection
     * @param  string $database
     * @return
     */
    private function pdoCreateDatabase($pdo, $connection, $database)
    {
        switch ($connection) {
            case 'sqlsrv':
                return $pdo->exec(sprintf('CREATE DATABASE %s;', $database));
            case 'mysql':
                return $pdo->exec(sprintf(
                    'CREATE DATABASE %s CHARACTER SET %s COLLATE %s;',
                    $database,
                    'utf8mb4',
                    'utf8mb4_unicode_ci'
                ));
        }

        throw new Exception('Unsupported database connection: '.$connection);
    }
}
