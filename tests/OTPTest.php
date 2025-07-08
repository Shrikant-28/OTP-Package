<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Shrikant\OTP\OTP;
use Tests\InMemoryStore;
use Shrikant\OTP\Storage\OTPStoreInterface;

class OTPTest extends TestCase
{
    public function testOtpGenerationAndValidation()
    {
        $store = new InMemoryStore();
        $otpService = new OTP($store);

        $otp = $otpService->generate('user123', 6);
        $this->assertTrue($otpService->validate('user123', $otp));
        $this->assertFalse($otpService->validate('user123', $otp)); // OTP already used
    }

    public function testOtpExpires()
    {
        $store = new class implements OTPStoreInterface {
            public function set(string $key, string $otp, int $ttl): void {}
            public function get(string $key): ?string {
                return null; // simulate expired OTP
            }
            public function delete(string $key): void {}
        };

        $otpService = new OTP($store);
        $otp = $otpService->generate('user456', 6);
        $this->assertFalse($otpService->validate('user456', $otp));
    }
}
