<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;

trait DatabaseTransactions
{
    public function setUp()
    {
        parent::setUp();
        DB::beginTransaction();

    }

    public function tearDown() {
        DB::rollBack();
    }
}
