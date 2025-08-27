<?php

namespace App\Helpers\Support;

class FormRenderer {
    public static function defaultClasses(): array {
        return [
            'text' => 'w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500',
            'email' => 'w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500',
            'password' => 'w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500',
            'date' => 'w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500',
            'select' => 'w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500',
        ];
    }

    public static function applyDefaults(array $schema): array {
        foreach ($schema as $field => &$config) {
            $type = $config['type'] ?? 'text';
            $config['class'] = $config['class'] ?? self::defaultClasses()[$type] ?? '';
        }
        return $schema;
    }
}

