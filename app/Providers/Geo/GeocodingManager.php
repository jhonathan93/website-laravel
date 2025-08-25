<?php

namespace App\Providers\Geo;

use Exception;
use RuntimeException;
use App\Models\Address;
use InvalidArgumentException;
use Illuminate\Support\Collection;
use App\Contracts\Providers\Geo\GeocodingServiceInterface;

class GeocodingManager {

    /**
     * @var Collection<GeocodingServiceInterface>
     */
    private Collection $providers;

    /**
     * @var string
     */
    private string $defaultProvider;

    /**
     * @param array $providers
     * @param string $defaultProvider
     */
    public function __construct(array $providers, string $defaultProvider) {
        $this->providers = collect($providers);
        $this->defaultProvider = $defaultProvider;
    }

    /**
     * @param Address $address
     * @param string|null $provider
     * @return array|null
     */
    public function geocode(Address $address, ?string $provider = null): ?array {
        $provider = $provider ?? $this->defaultProvider;

        /** @var GeocodingServiceInterface $geocoder */
        $geocoder = $this->providers->first(
            fn(GeocodingServiceInterface $p) => $p->getName() === $provider
        );

        if (!$geocoder) throw new InvalidArgumentException("Provedor de geocodificação '$provider' não encontrado");

        return $geocoder->geocode($address);
    }

    /**
     * @param Address $address
     * @param array $providerOrder
     * @return array
     */
    public function geocodeWithFallback(Address $address, array $providerOrder = []): array {
        $providerOrder = !empty($providerOrder) ? $providerOrder : ['google', 'mapbox'];

        foreach ($providerOrder as $provider) {
            try {
                $result = $this->geocode($address, $provider);

                if ($result) return $result;
            } catch (Exception) {
                continue;
            }
        }

        throw new RuntimeException("Todos os provedores falharam ao geocodificar o endereço: $address");
    }
}
