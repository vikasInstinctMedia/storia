<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class CreateRecordsCommand extends Command
{
    protected $signature = 'records:create';

    protected $description = 'Command to Create factory records';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $products = Product::factory()->count(3)->create();

        $this->info('created');
    }
}
