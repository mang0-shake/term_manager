<?php

namespace App\Console\Commands;

use App\Models\Term;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:show';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = Http::get('https://jsonplaceholder.typicode.com/todos/1');
        $this->info($data);
        return 0;
    }
}
