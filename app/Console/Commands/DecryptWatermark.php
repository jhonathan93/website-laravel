<?php

namespace App\Console\Commands;

use Imagick;
use ImagickException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Encryption\DecryptException;

class DecryptWatermark extends Command {
    protected $signature = 'watermark:decrypt
                            {image : Path da imagem}
                            {--verify : Verifica a integridade do watermark}';

    protected $description = 'Descriptografa e exibe a marca d\'água digital de uma imagem';

    /**
     * @return int
     */
    public function handle(): int {
        $imagePath = $this->argument('image');

        try {
            if (!Storage::disk('local')->exists($imagePath)) {
                return 0;
            }

            $image = new Imagick(Storage::disk('local')->path($imagePath));
            $encryptedData = $image->getImageProperty('comment');

            if (!$encryptedData) {
                $this->error('Nenhum watermark digital encontrado na imagem');
                return 1;
            }

            $decrypted = json_decode(Crypt::decryptString($encryptedData), true);

            $this->info("\nDados do Watermark:");

            $this->table(['Campo', 'Valor'], [
                ['UUID', $decrypted['i']],
                ['Origem', $decrypted['s']],
                ['IP', $decrypted['p']],
                ['Data', $decrypted['d']],
                ['Hash', substr($decrypted['h'], 0, 10).'...']
            ]);

            if ($this->option('verify')) {
                $expectedHash = hash_hmac('sha256', $decrypted['i'], config('app.key'));

                if (hash_equals($expectedHash, $decrypted['h'])) {
                    $this->info('✅  Verificação de integridade: OK');
                } else {
                    $this->error('❌  Falha na verificação de integridade!');
                    $this->warn('Possível adulteração dos dados!');
                    return 2;
                }
            }

            return 0;
        } catch (ImagickException $e) {
            $this->error("Erro ao processar imagem: {$e->getMessage()}");
            return 3;
        } catch (DecryptException $e) {
            $this->error("Falha ao descriptografar: watermark corrompido ou chave inválida");
            return 4;
        }
    }
}
