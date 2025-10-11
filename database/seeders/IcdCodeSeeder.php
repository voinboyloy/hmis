<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class IcdCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csv = Reader::createFromPath(storage_path('app/codes.csv'), 'r');

        DB::transaction(function () use ($csv) {
            $codes = [];
            foreach ($csv as $record) {
                if (!in_array($record[0], $codes)) {
                    DB::table('icd_codes')->insert([
                        'code' => $record[0],
                        'description' => $record[1],
                    ]);
                    $codes[] = $record[0];
                }
            }
        });
    }
}

