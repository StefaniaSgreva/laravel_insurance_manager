<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Policy;

class InsuranceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crea 20 clienti
        Client::factory(20)->create()->each(function ($client) {
            // Ogni cliente ha da 1 a 5 polizze
            $policyCount = rand(1, 5);

            // Di queste, la maggior parte sono attive
            Policy::factory()
                ->count($policyCount)
                ->active() // stato attivo
                ->create(['client_id' => $client->id]);

            // Qualche polizza scaduta (20% di probabilità)
            if (rand(1, 100) <= 20) {
                Policy::factory()
                    ->expired()
                    ->create(['client_id' => $client->id]);
            }
        });

        // Per avere dati più ricchi, crea altri 5 clienti con polizze miste
        Client::factory(5)->create()->each(function ($client) {
            Policy::factory(3)->create(['client_id' => $client->id]);
        });

        $this->command->info('✅ Clienti creati: ' . Client::count());
        $this->command->info('✅ Polizze create: ' . Policy::count());
    }
}
