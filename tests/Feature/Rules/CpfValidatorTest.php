<?php

namespace Tests\Feature\Rules;

use Tests\TestCase;
use App\Rules\CpfValidator;
use Illuminate\Support\Facades\Validator;

class CpfValidatorTest extends TestCase {

    public function test_valida_cpf_valido_com_objeto() {
        $validator = Validator::make(
            ['cpf' => '52998224725'],
            ['cpf' => [new CpfValidator()]]
        );

        $this->assertTrue($validator->passes());
    }

    public function test_reprova_cpf_invalido_com_objeto() {
        $validator = Validator::make(
            ['cpf' => '12345678900'],
            ['cpf' => [new CpfValidator()]]
        );

        $this->assertTrue($validator->fails());
    }

    public function test_valida_cpf_valido_com_regra_global() {
        $validator = Validator::make(
            ['cpf' => '52998224725'],
            ['cpf' => ['cpf']]
        );

        $this->assertTrue($validator->passes());
    }

    public function test_reprova_cpf_invalido_com_regra_global() {
        $validator = Validator::make(
            ['cpf' => '11111111111'],
            ['cpf' => ['cpf']]
        );

        $this->assertTrue($validator->fails());
    }
}
