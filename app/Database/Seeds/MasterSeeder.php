<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MasterSeeder extends Seeder
{
    public function run()
    {
        $this->call('PermissionSeeder');
        $this->call('CategorySeeder');
        $this->call('MuscleSeeder');
        $this->call('CategoryPrgmSeeder');

        $this->call('UserSeeder');
        $this->call('ExerciceSeeder');

        $this->call('ExerciseMuscleSeeder');
        $this->call('ProgramSeeder');

        $this->call('WorkoutSeeder');
        $this->call('SeriesSeeder');
    }
}