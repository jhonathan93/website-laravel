<?php

namespace App\Services\Cep;

use Exception;
use RuntimeException;
use InvalidArgumentException;
use Illuminate\Support\Collection;
use App\Contracts\Providers\Cep\CepProvider;

class CepService {

    /**
     * @var Collection<CepProvider>
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
     * @param string $codeCep
     * @param string|null $provider
     * @return array|null
     */
    public function cep(string $codeCep, ?string $provider = null): ?array {
        $provider = $provider ?? $this->defaultProvider;

        /** @var CepProvider $CepProvider */
        $CepProvider = $this->providers->first(
            fn(CepProvider $p) => $p->getName() === $provider
        );

        if (!$CepProvider) throw new InvalidArgumentException("Provedor de endereço '$provider' não encontrado");

        return $CepProvider->cep($codeCep);
    }

    /**
     * @param string $codeCep
     * @param array $providerOrder
     * @return array
     */
    public function cepWithFallback(string $codeCep, array $providerOrder = []): array {
        $providerOrder = !empty($providerOrder) ? $providerOrder : ['Viacep'];

        foreach ($providerOrder as $provider) {
            try {
                $result = $this->cep($codeCep, $provider);

                if ($result) return $result;
            } catch (Exception) {
                continue;
            }
        }

        throw new RuntimeException("Todos os provedores falharam para o cep: $codeCep");
    }
}
