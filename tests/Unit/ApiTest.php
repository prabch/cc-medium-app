<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\MediumService;

class ApiTest extends TestCase
{

    private $token = '2531c56f583902b888f662c15fac3ba5f3d158b740775d31dc67a9a06adfb85e6';
    private $user_id = '16ba1a5ef89904ef78ed704ec3649336352d76cb428a5dd7814c243c203d90082';

    /**
     * Test API call via MediumService / Get profile data
     *
     * @return bool
     */
    public function test_profile()
    {
        $medium = new MediumService($this->token);
        $this->assertContains('status', array_keys($medium->get_profile()));
    }

    /**
     * Test API call via MediumService / Get publications
     *
     * @return bool
     */
    public function test_publications()
    {
        $medium = new MediumService($this->token, $this->user_id);
        $this->assertContains('status', array_keys($medium->get_publications()));
    }
}
