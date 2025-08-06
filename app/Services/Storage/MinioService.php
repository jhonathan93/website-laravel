<?php

namespace App\Services\Storage;

use Illuminate\Support\Facades\Storage;

class MinioService {

    /**
     * @var string
     */
    protected string $disk;

    /**
     * @param string $disk
     */
    public function __construct(string $disk = 'minio') {
        $this->disk = $disk;
    }

    /**
     * @param string $path
     * @param $file
     * @return bool
     */
    public function upload(string $path, $file): bool {
        return Storage::disk($this->disk)->put($path, $file);
    }

    /**
     * @param string $path
     * @return string
     */
    public function getUrl(string $path): string {
        return Storage::disk($this->disk)->url($path);
    }

    /**
     * @param string $path
     * @return bool
     */
    public function delete(string $path): bool {
        return Storage::disk($this->disk)->delete($path);
    }

    /**
     * @return array
     */
    public function getConfig(): array {
        return [
            'endpoint' => config("filesystems.disks.{$this->disk}.endpoint"),
            'bucket' => config("filesystems.disks.{$this->disk}.bucket"),
            'use_path_style_endpoint' => config("filesystems.disks.{$this->disk}.use_path_style_endpoint"),
        ];
    }
}
