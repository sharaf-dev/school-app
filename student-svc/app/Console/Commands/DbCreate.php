<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PDO;
use PDOException;

class DbCreate extends Command
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
    protected $description = 'Create Database';

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
     * @return int
     */
    public function handle()
    {
        $database = config("database.connections.mysql.database");
        if ($database)
        {
            try
            {
                $charset = config("database.connections.mysql.charset",'utf8mb4');
                $collation = config("database.connections.mysql.collation",'utf8mb4_unicode_ci');
                $host = config("database.connections.mysql.host",'127.0.0.1');
                $port = config("database.connections.mysql.port",'3306');
                $username = config("database.connections.mysql.username",'root');
                $password = config("database.connections.mysql.password",'123');

                $pdo = $this->getPDOConnection($host, $port, $username, $password);
                $pdo->exec(sprintf(
                    'CREATE DATABASE IF NOT EXISTS %s CHARACTER SET %s COLLATE %s;',
                    $database,
                    $charset,
                    $collation
                ));
                $this->info(sprintf('Successfully created %s database', $database));
                return 0;
            }
            catch (PDOException $e)
            {
                $this->error(sprintf('Failed to create %s database, %s', $database, $e->getMessage()));
                return 1;
            }
        }
    }

    /**
     * Get PDO object
     *
     * @return PDO
     */
    private function getPDOConnection($host, $port, $username, $password)
    {
        return new PDO(sprintf('mysql:host=%s;port=%d;', $host, $port), $username, $password);
    }
}
