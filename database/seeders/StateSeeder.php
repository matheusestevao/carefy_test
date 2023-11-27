<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StateSeeder extends Seeder
{
    protected $states = [
        [
            'number' => 12, 
            'name' => 'Acre', 
            'abbreviation' => 'AC'
        ],
        [
            'number' => 27, 
            'name' => 'Alagoas', 
            'abbreviation' => 'AL'
        ],
        [
            'number' => 16, 
            'name' => 'Amapá', 
            'abbreviation' => 'AP'
        ],
        [
            'number' => 13, 
            'name' => 'Amazonas', 
            'abbreviation' => 'AM'
        ],
        [
            'number' => 29, 
            'name' => 'Bahia', 
            'abbreviation' => 'BA'
        ],
        [
            'number' => 23, 
            'name' => 'Ceará', 
            'abbreviation' => 'CE'
        ],
        [
            'number' => 53, 
            'name' => 'Distrito Federal', 
            'abbreviation' => 'DF'
        ],
        [
            'number' => 32, 
            'name' => 'Espírito Santo', 
            'abbreviation' => 'ES'
        ],
        [
            'number' => 52, 
            'name' => 'Goiás', 
            'abbreviation' => 'GO'
        ],
        [
            'number' => 21, 
            'name' => 'Maranhão', 
            'abbreviation' => 'MA'
        ],
        [
            'number' => 51, 
            'name' => 'Mato Grosso', 
            'abbreviation' => 'MT'
        ],
        [
            'number' => 50, 
            'name' => 'Mato Grosso do Sul', 
            'abbreviation' => 'MS'
        ],
        [
            'number' => 31, 
            'name' => 'Minas Gerais', 
            'abbreviation' => 'MG'
        ],
        [
            'number' => 15, 
            'name' => 'Pará', 
            'abbreviation' => 'PA'
        ],
        [
            'number' => 25, 
            'name' => 'Paraíba', 
            'abbreviation' => 'PB'
        ],
        [
            'number' => 41, 
            'name' => 'Paraná', 
            'abbreviation' => 'PR'
        ],
        [
            'number' => 26, 
            'name' => 'Pernambuco', 
            'abbreviation' => 'PE'
        ],
        [
            'number' => 22, 
            'name' => 'Piauí', 
            'abbreviation' => 'PI'
        ],
        [
            'number' => 33, 
            'name' => 'Rio de Janeiro', 
            'abbreviation' => 'RJ'
        ],
        [
            'number' => 24, 
            'name' => 'Rio Grande do Norte', 
            'abbreviation' => 'RN'
        ],
        [
            'number' => 43, 
            'name' => 'Rio Grande do Sul', 
            'abbreviation' => 'RS'
        ],
        [
            'number' => 11, 
            'name' => 'Rondônia', 
            'abbreviation' => 'RO'
        ],
        [
            'number' => 14, 
            'name' => 'Roraima', 
            'abbreviation' => 'RR'
        ],
        [
            'number' => 42, 
            'name' => 'Santa Catarina', 
            'abbreviation' => 'SC'
        ],
        [
            'number' => 35, 
            'name' => 'São Paulo', 
            'abbreviation' => 'SP'
        ],
        [
            'number' => 28, 
            'name' => 'Sergipe', 
            'abbreviation' => 'SE'
        ],
        [
            'number' => 17, 
            'name' => 'Tocantins', 
            'abbreviation' => 'TO'
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach($this->states as $state) {
            State::updateOrCreate([
                'number' => $state['number']
            ],
            [
                'name' => $state['name'],
                'abbreviation' => $state['abbreviation']
            ]);
        }
    }
}
