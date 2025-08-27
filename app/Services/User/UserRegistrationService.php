<?php

namespace App\Services\User;

use Throwable;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\QueryException;
use App\Exceptions\RegistrationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserRegistrationService {

    /**
     * @param array $data
     * @return User
     * @throws RegistrationException
     */
    public static function register(array $data): User {
        try {
            return DB::transaction(function () use ($data) {
                $user = User::create([
                    'uuid'          => (string) Str::uuid(),
                    'name'          => $data['name'],
                    'email'         => $data['email'],
                    'date_of_birth' => $data['date_of_birth'] ?? null,
                    'cpf'           => $data['cpf'],
                    'password'      => Hash::make($data['password']),
                ]);

                $user->addresses()->create([
                    'uuid'       => (string) Str::uuid(),
                    'zip_code'   => $data['zip_code'],
                    'street'     => $data['street'],
                    'number'     => $data['number'],
                    'complement' => $data['complement'] ?? null,
                    'district'   => $data['district'],
                    'city'       => $data['city'],
                    'state'      => $data['state'],
                    'country'    => $data['country'],
                    'is_primary' => true
                ]);

                //event(new Registered($user));

                return $user;
            });
        } catch (QueryException $e) {
            Log::error('Erro no registro do usuário (Database): ' . $e->getMessage(), [
                'data' => Arr::except($data, ['password', 'password_confirmation'])
            ]);

            throw new RegistrationException('Erro ao processar o registro. Tente novamente.', 500, $e);
        } catch (ModelNotFoundException $e) {
            Log::error('Model não encontrado no registro: ' . $e->getMessage());

            throw new RegistrationException('Erro na configuração do sistema.', 500, $e);
        } catch (Throwable $e) {
            Log::error('Erro inesperado no registro: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            throw new RegistrationException('Erro inesperado no sistema. Tente novamente.', 500, $e);
        }
    }
}
