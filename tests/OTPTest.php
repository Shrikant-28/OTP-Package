<?php 
use PHPUnit\Framework\TestCase;
use Shrikant\OTP\OTP;
use Shrikant\OTP\Storage\OTPStoreInterface;

class InMemoryStore implements OTPStoreInterface
{
    private array $data = [];

    public function set(string $key, string $otp, int $ttl): void
    {
        $this->data[$key] = ['otp' => $otp, 'expires' => time() + $ttl];
    }

    public function get(string $key): ?string
    {
        if (!isset($this->data[$key])) return null;
        if ($this->data[$key]['expires'] < time()) return null;
        return $this->data[$key]['otp'];
    }

    public function delete(string $key): void
    {
        unset($this->data[$key]);
    }
}

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
            private $otp;
            public function set(string $key, string $otp, int $ttl): void {
                $this->otp = null; // simulate immediate expiry
            }
            public function get(string $key): ?string {
                return $this->otp;
            }
            public function delete(string $key): void {}
        };

        $otpService = new OTP($store);
        $otp = $otpService->generate('user456', 6);
        $this->assertFalse($otpService->validate('user456', $otp));
    }
}
