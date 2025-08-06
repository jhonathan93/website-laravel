<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Aws\S3\Exception\S3Exception;
use Illuminate\Support\Facades\Storage;

class TestMinioConnection extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minio:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int {
        $this->info('Iniciando teste de conexão com MinIO...');

        $testFileName = 'test-connection-' . time() . '.txt';
        $testContent = 'Este é um teste de conexão com MinIO. Horário: ' . now();

        try {
            $this->info('Tentando escrever arquivo de teste...');
            Storage::disk('minio')->put($testFileName, $testContent);
            $this->info('✔ Arquivo escrito com sucesso!');

            $this->info('Tentando ler arquivo...');
            $content = Storage::disk('minio')->get($testFileName);
            $this->info('✔ Conteúdo lido: ' . substr($content, 0, 50) . '...');

            $this->info('Gerando URL...');
            $url = Storage::disk('minio')->url($testFileName);
            $this->info("✔ URL gerada: $url");

            $exists = Storage::disk('minio')->exists($testFileName) ? 'SIM' : 'NÃO';
            $this->info("✔ Arquivo existe no storage: $exists");

            $this->info('Excluindo arquivo de teste...');
            Storage::disk('minio')->delete($testFileName);
            $this->info('✔ Arquivo excluído com sucesso!');

            $this->line("\n✅ <bg=green>Todos os testes passaram! Conexão com MinIO funcionando.</>");

        } catch (S3Exception $e) {
            $this->error("\n❌ Erro na conexão com MinIO:");
            $this->error('Mensagem: ' . $e->getMessage());
            $this->error('Código: ' . $e->getAwsErrorCode());

            $this->line("\n🔧 Verifique sua configuração:");
            $this->line('AWS_ENDPOINT: ' . config('filesystems.disks.minio.endpoint'));
            $this->line('AWS_BUCKET: ' . config('filesystems.disks.minio.bucket'));
            $this->line('AWS_USE_PATH_STYLE_ENDPOINT: ' . config('filesystems.disks.minio.use_path_style_endpoint') ? 'true' : 'false');

            return 1;
        } catch (Exception $e) {
            $this->error("\n❌ Erro inesperado: " . $e->getMessage());
            return 2;
        }

        return 0;
    }
}
