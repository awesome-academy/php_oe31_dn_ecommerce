<?php

namespace Tests\Unit\Http\Requests;

use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class RegisterRequestTest extends TestCase
{
    protected $request;

    protected function setUp()
    {
        parent::setUp();
        $this->request = new RegisterRequest();
    }

    public function test_no_data()
    {
        $data = [];
        $validator = Validator::make($data, $this->request->rules(), $this->request->messages());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('name', $validator->errors()->messages());
        $this->assertArrayHasKey('phone', $validator->errors()->messages());
        $this->assertArrayHasKey('email', $validator->errors()->messages());
        $this->assertArrayHasKey('password', $validator->errors()->messages());
        $this->assertArrayHasKey('address', $validator->errors()->messages());
        $this->assertArrayHasKey('city', $validator->errors()->messages());
    }

    public function test_phone_not_min()
    {
        $data = [
            'phone' => '093581345',
        ];
        $validator = Validator::make($data, $this->request->rules(), $this->request->messages());
        $this->assertArrayHasKey('phone', $validator->errors()->messages());
    }

    public function test_phone_more_than_max()
    {
        $data = [
            'phone' => '093581345282',
        ];
        $validator = Validator::make($data, $this->request->rules(), $this->request->messages());
        $this->assertArrayHasKey('phone', $validator->errors()->messages());
    }

    public function test_phone_not_regex()
    {
        $data = [
            'phone' => 'abcxyz',
        ];
        $validator = Validator::make($data, $this->request->rules(), $this->request->messages());
        $this->assertArrayHasKey('phone', $validator->errors()->messages());
    }

    public function test_email_not_valid()
    {
        $data = [
            'email' => 'nguyenvana.com',
        ];
        $validator = Validator::make($data, $this->request->rules(), $this->request->messages());
        $this->assertArrayHasKey('email', $validator->errors()->messages());
    }

    public function test_email_is_existed()
    {
        $user = factory(User::class)->create();
        $data = [
            'email' => $user->email,
        ];
        $validator = Validator::make($data, $this->request->rules(), $this->request->messages());
        $this->assertArrayHasKey('email', $validator->errors()->messages());
    }

    public function test_birthdate_not_valid()
    {
        $data = [
            'birthdate' => '2020-13-13',
        ];
        $validator = Validator::make($data, $this->request->rules(), $this->request->messages());
        $this->assertArrayHasKey('birthdate', $validator->errors()->messages());

        $data = [
            'birthdate' => '2020-13-32',
        ];
        $validator = Validator::make($data, $this->request->rules(), $this->request->messages());
        $this->assertArrayHasKey('birthdate', $validator->errors()->messages());

        $data = [
            'birthdate' => '2020-00-13',
        ];
        $validator = Validator::make($data, $this->request->rules(), $this->request->messages());
        $this->assertArrayHasKey('birthdate', $validator->errors()->messages());

        $data = [
            'birthdate' => '2020-05-00',
        ];
        $validator = Validator::make($data, $this->request->rules(), $this->request->messages());
        $this->assertArrayHasKey('birthdate', $validator->errors()->messages());
    }
}
