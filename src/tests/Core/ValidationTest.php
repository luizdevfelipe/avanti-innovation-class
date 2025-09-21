<?php

namespace App\Tests\Core;

use App\Tests\BaseTestCase;

class ValidationTest extends BaseTestCase
{
    public function test_can_validade_commun_fields(): void
    {
        $data = [
            'name' => 'Test Product',
            'price' => 100.00,
            'stock' => 50,
            'variations' => [
                ['name' => 'Variation 1', 'price' => '', 'stock' => 5],
                ['name' => 'Variation 2', 'price' => 20.00, 'stock' => 10],
            ]
        ];

        $rules = [
            'name' => ['required', 'string'],
            'price' => ['required', 'float'],
            'stock' => ['required', 'integer'],
        ];

        $validation = new \App\Core\Request();
        $errors = $validation->validate($data, $rules);
        foreach ($data['variations'] as $variation) {
            $errors = array_merge($errors, $validation->validate($variation, [
                'name' => ['required', 'string'],
                'price' => ['float:null'],
                'stock' => ['required', 'integer'],
            ]));
        }

        $this->assertEmpty($errors, 'Validation should pass without errors');
    }
}