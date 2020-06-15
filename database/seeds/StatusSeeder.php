<?php

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            [
                'status' => 'View',
            ],
            [
                'status' => 'In Progress',
            ],
            [
                'status' => 'Done',
            ]
        ];

        DB::table('status')->insert($status);


    }
}
