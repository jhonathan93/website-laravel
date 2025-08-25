<?php

namespace App\Console\Commands;

use Exception;
use App\Models\Address;
use Illuminate\Console\Command;
use App\Providers\Geo\GeocodingManager;

class TestGeocodingProviders extends Command {

    /**
     * @var string
     */
    protected $signature = 'geocode:test {--p|provider= : google ou mapbox (opcional)}';

    /**
     * @var string
     */
    protected $description = 'Testa o serviço de geocodificação com um endereço';

    /**
     * @param GeocodingManager $geocoding
     * @return void
     */
    public function handle(GeocodingManager $geocoding): void {
        $provider = ucfirst($this->option('provider'));

        $address = Address::find(1);

        $this->info("Testando: $address->full_address");

        if ($provider) {
            $result = $geocoding->geocode($address, $provider);

            if ($result) {
                $this->showResult($result);
            } else {
                $this->error("Falha com $provider");
            }
        } else {
            try {
                $this->showResult($geocoding->geocodeWithFallback($address));
            } catch (Exception $e) {
                $this->error("Todos os provedores falharam {$e->getMessage()}");
            }
        }
    }

    /**
     * @param array $result
     */
    protected function showResult(array $result): void {
        $this->line("Provedor: <comment>{$result['provider']}</comment>");
        $this->line("Latitude: <info>{$result['latitude']}</info>");
        $this->line("Longitude: <info>{$result['longitude']}</info>");
    }
}
