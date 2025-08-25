<?php

namespace App\Console\Commands;

use Exception;
use App\Models\Address;
use Illuminate\Console\Command;
use App\Services\Cep\CepService;

class TestCepProvider extends Command {
    /**
     * @var string
     */
    protected $signature = 'cep:test {--p|provider= : Viacep (opcional)}';

    /**
     * @var string
     */
    protected $description = '';

    public function handle(CepService $cepService): void {
        $provider = ucfirst($this->option('provider'));

        /** @var Address $address */
        $address = Address::find(1);

        $this->info("Testando: $address->zip_code");

        if ($provider) {
            $result = $cepService->cep($address->zip_code, $provider);

            if ($result) {
                $this->showResult($result);
            } else {
                $this->error("Falha com $provider");
            }
        } else {
            try {
                $this->showResult($cepService->cepWithFallback($address->zip_code));
            } catch (Exception $e) {
                $this->error("Todos os provedores falharam {$e->getMessage()}");
            }
        }
    }

    /**
     * @param array $result
     */
    protected function showResult(array $result): void {
        $this->line("Cep: <comment>{$result['zip_code']}</comment>");
        $this->line("Rua: <info>{$result['street']}</info>");
        $this->line("bairro: <info>{$result['district']}</info>");
        $this->line("Cidade: <info>{$result['city']}</info>");
        $this->line("Estado: <info>{$result['state']}</info>");
        $this->line("Provedor: <info>{$result['provider']}</info>");
    }
}

