<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
    		'name' 		=> 'Carlos Leao',
    		'email' 	=> 'cacleaof@gmail.com',
            'cpf'       => '68631839434',
    		'password' 	=> bcrypt('123'),
    	]);
        Project::create([
            'projeto'      => 'Hospedagem ATI - Moodle',
            'proj_detalhe'      => 'Desenvolver e hospedar novo Moodle na ATI',
            'gerente'      => '1',
        ]);
        Project::create([
            'projeto'      => 'Testar o Gantt',
            'proj_detalhe'      => 'Testando o gantt e ajustando',
            'gerente'      => '1',
        ]);
        task::create([
            'text'      => 'Definir versão do Moodle',
            'detalhe'      => 'A versão deve ser estável',
            'proj_id'      => '1',
            'duration'  =>'0'
        ]);
    }
}
