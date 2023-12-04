<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    protected $signature = 'create:admin';

    protected $description = 'This command creates an admin user asking by keyboard the username and the password.';


    public function handle(): void
    {
        $username = $this->ask('What username you want to use?');
        $password = $this->secret('And which password for it?');

    }
}
