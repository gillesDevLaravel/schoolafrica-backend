<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CountUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'count:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Compter le nombre d'utilisateur par jour";

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
        $count = User::count();

        $message = "[" . now() . "] Nombre d'utilisateur : $count";

        Log::info($message);
        $this->info($message);

        return 0;
    }
}
