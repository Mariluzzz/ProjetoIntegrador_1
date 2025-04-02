<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

class CreateDatabase extends Command
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
    protected $description = 'Cria o banco de dados MysQL utilizado nesta aplicação';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $charset = env('DB_CHARSET');
        $collate = env('DB_COLLATION');
        $host = env('DB_HOST');

        if (empty($database)) {
            $this->error('O nome do banco de dados (DB_DATABASE) não foi definido no .env.');
            return;
        }

        if(empty($password)) {
            $this->error('Esse banco exige uma senha definida no .env.');
            return;
        }

        $query = "CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET $charset COLLATE $collate";

        try {
            DB::connection('mysql_root')->statement($query);
            $this->info("Banco de dados '$database' criado.");

            if ($username && $password) {
                DB::connection('mysql_root')->statement("CREATE USER IF NOT EXISTS '$username'@'$host' IDENTIFIED BY '$password'");
                DB::connection('mysql_root')->statement("GRANT ALL PRIVILEGES ON `$database`.* TO '$username'@'$host'");
                $this->info("Usuário '$username' configurado com a senha informada no .env.");
            }

            Config::set('database.connections.mysql.database', $database);
            DB::purge('mysql');
            DB::reconnect('mysql');

            $this->info('Executando criação das tabelas');
            Artisan::call('migrate');
            $this->info(Artisan::output());

        } catch (\Exception $e) {
            $this->error("Erro ao criar o banco ou configurar o usuário: {$e->getMessage()}");
        }
    }
}
