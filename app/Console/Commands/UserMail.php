<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserWelcome;
use App\User;

class UserMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:mail
    {id : Representa el Id del usuario}
    {--flag= : Condicional}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envio email a un usuario';

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
        $user = User::find($this->argument('id'));

        if($user){
            $option = $this->option('flag');
            echo $option . "\n";

            Mail::to($user->email)->send(new UserWelcome($user));
            echo "Mail enviado \n";
        }else{
            echo "El usuario no existe \n";
        }
    }
}
