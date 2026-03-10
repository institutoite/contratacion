<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            'Disenador grafico',
            'Secretaria',
            'Limpieza',
            'Redes sociales',
            'Programador',
            'Profesor',
            'Promotor',
        ];

        foreach ($positions as $position) {
            Position::query()->updateOrCreate(
                ['name' => $position],
                ['is_active' => true]
            );
        }
    }
}
