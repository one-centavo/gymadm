<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_access_registration_initial_page(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertViewIs('auth.register.get-email');
    }

    public function test_cannot_access_otp_verification_without_email_in_session(): void
    {
        $response = $this->get('/verify-otp');

        $response->assertRedirect('/register');
    }

    public function test_cannot_access_registration_form_without_verified_otp(): void
    {
        $response = $this->get('/register-form');

        $response->assertRedirect('/verify-otp');
    }

    public function test_email_submission_redirects_to_otp_verification(): void
    {
        $email = 'test@example.com';

        $response = $this->post('/register', [
            'email' => $email,
        ]);

        $response->assertRedirect('/verify-otp');
        $response->assertSessionHas('email', $email);
    }

    public function test_can_access_otp_form_after_email_submission(): void
    {
        $response = $this->withSession(['email' => 'test@example.com'])
            ->get('/verify-otp');

        $response->assertStatus(200);
        $response->assertViewIs('auth.register.get-otp');
    }

    public function test_can_access_registration_form_after_otp_verification(): void
    {
        $response = $this->withSession([
            'email' => 'test@example.com',
            'verified_otp' => true
        ])->get('/register-form');

        $response->assertStatus(200);
        $response->assertViewIs('auth.register.get-data');
    }

    public function test_email_is_preserved_in_session_through_otp_flow(): void
    {
        $email = 'persistent@example.com';

        $response = $this->withSession([
            'email' => $email,
            'verified_otp' => true
        ])->get('/register-form');

        $response->assertSessionHas('email', $email);
    }

    public function test_email_and_otp_are_cleared_after_successful_registration(): void
    {
        $email = 'test@example.com';

        $postResponse = $this->withSession([
            'email' => $email,
            'verified_otp' => true
        ])->postJson('/register-form', [
            'first_name' => 'Gustavo',
            'last_name' => 'Doe',
            'document_type' => 'CC',
            'document_number' => '12345678',
            'phone_number' => '3101234567',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $postResponse->assertStatus(201);

        $response = $this->get('/register-form');

        $response->assertRedirect('/verify-otp');
        $response->assertSessionMissing('email');
        $response->assertSessionMissing('verified_otp');
    }
}
