<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;

class DataRetrieveTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_home()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_get_stat_home()
    {
        $response = $this->get('/stats');

        $response->assertStatus(405);
    }

    public function test_submit_to_stat_home_without_fields() {
        $response = $this->post('/stats', []);

        $response->assertInvalid(['company_symbol', 'email', 'start_date', 'end_date']);
    }

    public function test_submit_to_stat_home_company_symbol_required() {
        $response = $this->post('/stats', [
            'company_symbol' => '',
            'email' => 'test@test.com',
            'start_date' => '2023-06-01',
            'end_date' => '2023-06-17',
        ]);

        $response->assertInvalid(['company_symbol']);
    }

    public function test_submit_to_stat_home_company_symbol_invalid() {
        $response = $this->post('/stats', [
            'company_symbol' => 'random_string',
            'email' => 'test@test.com',
            'start_date' => '2023-06-01',
            'end_date' => '2023-06-17',
        ]);

        $response->assertInvalid(['company_symbol']);
    }

    public function test_submit_to_stat_home_email_required() {
        $response = $this->post('/stats', [
            'company_symbol' => 'AMRN',
            'email' => '',
            'start_date' => '2023-06-01',
            'end_date' => '2023-06-17',
        ]);

        $response->assertInvalid(['email']);
    }

    public function test_submit_to_stat_home_email_invalid() {
        $response = $this->post('/stats', [
            'company_symbol' => 'AMRN',
            'email' => 'plain string',
            'start_date' => '2023-06-01',
            'end_date' => '2023-06-17',
        ]);

        $response->assertInvalid(['email']);
    }

    public function test_submit_to_stat_home_start_date_required() {
        $response = $this->post('/stats', [
            'company_symbol' => 'AMRN',
            'email' => 'test@test.com',
            'start_date' => '',
            'end_date' => '2023-06-17',
        ]);

        $response->assertInvalid(['start_date']);
    }

    public function test_submit_to_stat_home_start_date_invalid_format() {
        $response = $this->post('/stats', [
            'company_symbol' => 'AMRN',
            'email' => 'test@test.com',
            'start_date' => '17-06-2023',
            'end_date' => '2023-06-17',
        ]);

        $response->assertInvalid(['start_date']);
    }
    public function test_submit_to_stat_home_start_date_greater_than_now() {
        $response = $this->post('/stats', [
            'company_symbol' => 'AMRN',
            'email' => 'test@test.com',
            'start_date' => Carbon::now()->addDays(2)->toDateString(),
            'end_date' => '2023-06-17',
        ]);

        $response->assertInvalid(['start_date']);
    }
    public function test_submit_to_stat_home_start_date_before_end_date() {
        $response = $this->post('/stats', [
            'company_symbol' => 'AMRN',
            'email' => 'test@test.com',
            'start_date' => '2023-07-30',
            'end_date' => '2023-06-17',
        ]);

        $response->assertInvalid(['start_date']);
    }

    public function test_submit_to_stat_home_end_date_required() {
        $response = $this->post('/stats', [
            'company_symbol' => 'AMRN',
            'email' => 'test@test.com',
            'start_date' => '2023-06-17',
            'end_date' => '',
        ]);

        $response->assertInvalid(['end_date']);
    }

    public function test_submit_to_stat_home_end_date_invalid_format() {
        $response = $this->post('/stats', [
            'company_symbol' => 'AMRN',
            'email' => 'test@test.com',
            'start_date' => '2023-06-17',
            'end_date' => '17-06-2023',
        ]);

        $response->assertInvalid(['end_date']);
    }
    public function test_submit_to_stat_home_end_date_less_equal_than_now() {
        $response = $this->post('/stats', [
            'company_symbol' => 'AMRN',
            'email' => 'test@test.com',
            'start_date' => '2023-06-17',
            'end_date' => Carbon::now()->addDays(2)->toDateString(),
        ]);

        $response->assertInvalid(['end_date']);
    }
    public function test_submit_to_stat_home_end_date_equal_or_after_start_date() {
        $response = $this->post('/stats', [
            'company_symbol' => 'AMRN',
            'email' => 'test@test.com',
            'start_date' => '2023-07-30',
            'end_date' => '2023-06-17',
        ]);

        $response->assertInvalid(['end_date']);
    }

    public function test_submit_to_stat_home_success() {
        $response = $this->post('/stats', [
            'company_symbol' => 'AMRN',
            'email' => 'test@test.com',
            'start_date' => '2023-06-01',
            'end_date' => '2023-06-17',
        ]);

        $response->assertStatus(200);
    }
}
