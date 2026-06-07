<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pipe;

class PipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pipe::create([
            'name' => 'Jalur Babakan 1',
            'pipe_type' => 'primer',
            'status' => 'perencanaan',
            'year' => 2025,
            'length' => 1200,
            'geometry' => json_encode([
                "type" => "LineString",
                "coordinates" => [
                    [107.6012, -6.9145],
                    [107.6035, -6.9158],
                    [107.6060, -6.9170],
                    [107.6082, -6.9182]
                ]
            ])
        ]);

        Pipe::create([
            'name' => 'Jalur Babakan 2',
            'pipe_type' => 'sekunder',
            'status' => 'terpasang',
            'year' => 2024,
            'length' => 1800,
            'geometry' => json_encode([
                "type" => "LineString",
                "coordinates" => [
                    [107.5901, -6.9201],
                    [107.5928, -6.9215],
                    [107.5950, -6.9232],
                    [107.5973, -6.9250],
                    [107.5991, -6.9268]
                ]
            ])
        ]);

        Pipe::create([
            'name' => 'Jalur Babakan 4',
            'pipe_type' => 'primer',
            'status' => 'terpasang',
            'year' => 2025,
            'length' => 1500,
            'geometry' => json_encode([
                "type" => "LineString",
                "coordinates" => [
                    [107.6050, -6.9100],
                    [107.6070, -6.9115],
                    [107.6090, -6.9130]
                ]
            ])
        ]);
    }
}
