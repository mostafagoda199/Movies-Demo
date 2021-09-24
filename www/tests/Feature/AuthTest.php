<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public const REGISTER_ENDPOINT = '/api/register';

    public const LOGIN_ENDPOINT = '/api/login';

    /**
     * validate email is require
     */
    public function testAttributeNameIsRequiredInRegister()
    {
        $fakeUser = User::factory()->raw(['name' => null]);
        $response = $this->json(self::POST_METHOD, self::REGISTER_ENDPOINT, $fakeUser);
        $response->assertStatus(self::FAIL_VALIDATION_STATUS);
        $response->assertJsonValidationErrors(['name']);
    }

    /**
     * validate user name max size in register
     */
    public function testAttributeNameSizeLessThan255bInRegister()
    {
        $fakeUser = User::factory()->raw(['name' => $this->faker->sentences]);
        $response = $this->json(self::POST_METHOD, self::REGISTER_ENDPOINT, $fakeUser);
        $response->assertStatus(self::FAIL_VALIDATION_STATUS);
        $response->assertJsonValidationErrors(['name']);
    }

    /**
     * validate email is require
     */
    public function testAttributeEmailIsRequiredInRegister()
    {
        $fakeUser = User::factory()->raw(['email' => null]);
        $response = $this->json(self::POST_METHOD, self::REGISTER_ENDPOINT, $fakeUser);
        $response->assertStatus(self::FAIL_VALIDATION_STATUS);
        $response->assertJsonValidationErrors(['email']);
    }

    /**
     * validate email
     */
    public function testAttributeEmailIsEmailInRegister()
    {
        $fakeUser = User::factory()->raw(['email' => $this->faker?->name]);
        $response = $this->json(self::POST_METHOD, self::REGISTER_ENDPOINT, $fakeUser);
        $response->assertStatus(self::FAIL_VALIDATION_STATUS);
        $response->assertJsonValidationErrors(['email']);
    }

    /**
     * validate email is unique in users
     */
    public function testAttributeEmailIsUniqueInRegister()
    {
        $userInDatabase = User::factory()->create();
        $fakeUser = User::factory()->raw(['email' => $userInDatabase?->email]);
        $response = $this->json(self::POST_METHOD, self::REGISTER_ENDPOINT, $fakeUser);
        $response->assertStatus(self::FAIL_VALIDATION_STATUS);
        $response->assertJsonValidationErrors(['email']);
    }

    /**
     * validate email is unique in users
     */
    public function testAttributeEmailSizeInRegister()
    {
        $createdUser = User::factory()->create();
        $fakeUser = User::factory()->raw(['email' => $createdUser?->email]);
        $response = $this->json(self::POST_METHOD, self::REGISTER_ENDPOINT, $fakeUser);
        $response->assertStatus(self::FAIL_VALIDATION_STATUS);
        $response->assertJsonValidationErrors(['email']);
    }

    /**
     * test user can register
     */
    public function testRegister()
    {
        $fakeUser = User::factory()->raw();
        $response = $this->json(self::POST_METHOD, self::REGISTER_ENDPOINT, $fakeUser);
        $response->assertCreated();
        $this->assertDatabaseHas('users',[
            'name'=>$fakeUser['name'],
            'email'=>$fakeUser['email']
        ]);
        $response->assertJsonStructure([
            'message',
            'data'
        ]);
    }

    /**
     * Unauthorized User login
     */
    public function testCanUserLoginWithFailedCredentials()
    {
        $fakeUser = User::factory()->raw();
        unset($fakeUser['name']);
        $response = $this->json(self::POST_METHOD, self::LOGIN_ENDPOINT, $fakeUser);
        $response->assertStatus(self::FAIL_VALIDATION_STATUS);
    }

    /**
     * login
     */
    public function testUserCanLogin()
    {
        $createdUser = User::factory()->create();
        $fakeCredentials = [
            'email'=>$createdUser?->email,
            'password'=> 'password',
        ];
        $response = $this->json('post', self::LOGIN_ENDPOINT, $fakeCredentials);
        $response->assertOk();
        $response->assertJsonStructure([
            'message',
            'data'
        ]);
    }
}
