<?php

namespace App\Services\Cep;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Contracts\Providers\Cep\CepServiceInterface;

class ViaCepService implements CepServiceInterface {

    private const string NAME = 'Viacep';
    private const string BASE_URL = 'https://viacep.com.br/ws/{cep}/json/';
    private const int TIMEOUT = 10;

    /**
     * @var string|null
     */
    private ?string $apiKey;

    public function __construct(string $apiKey = null) {
        $this->apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return self::NAME;
    }

    /**
     * @param string $cep
     * @return array|null
     */
    public function cep(string $cep): ?array {
        try {
            $cleanCep = preg_replace('/[^0-9]/', '', $cep);

            if (strlen($cleanCep) !== 8) {
                Log::warning('CEP inválido', ['cep' => $cep, 'provider' => self::NAME]);
                return null;
            }

            $url = str_replace('{cep}', $cleanCep, self::BASE_URL);

            $response = Http::timeout(self::TIMEOUT)->retry(2, 100)->get($url);

            if (!$response->successful()) {
                Log::error('Erro na requisição ViaCEP', [
                    'cep' => $cleanCep,
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);

                return null;
            }

            $data = $response->json();

            if (isset($data['erro']) && $data['erro'] === true) {
                Log::warning('CEP não encontrado no ViaCEP', ['cep' => $cleanCep]);
                return null;
            }

            return [
                'zip_code' => $data['cep'] ?? null,
                'street' => $data['logradouro'] ?? null,
                'district' => $data['bairro'] ?? null,
                'city' => $data['localidade'] ?? null,
                'state' => $data['uf'] ?? null,
                'provider' => self::NAME
            ];
        } catch (Exception) {
            return null;
        }
    }
}
