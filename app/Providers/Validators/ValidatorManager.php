<?php

namespace App\Providers\Validators;

use InvalidArgumentException;
use Illuminate\Support\Collection;
use App\Contracts\Providers\Validator\ValidatorServiceInterface;

class ValidatorManager {

    /**
     * @var Collection<ValidatorServiceInterface>
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
     * @param string $value
     * @param string|null $provider
     * @return array|null
     */
    public function validate(string $value, ?string $provider = null): ?array {
        $provider = $provider ?? $this->defaultProvider;

        /** @var ValidatorServiceInterface $validatorService */
        $validatorService = $this->providers->first(
            fn(ValidatorServiceInterface $p) => $p->getName() === $provider
        );

        if (!$validatorService) throw new InvalidArgumentException("Provedor de validação '$provider' não encontrado");

        return $validatorService->validate($value);
    }
}
