<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Halaman utama mengarahkan pengunjung ke halaman lain.
     */
    public function test_the_application_redirects_from_homepage(): void
    {
        $response = $this->get('/');

        $response->assertRedirect();
    }
}
