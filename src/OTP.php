<?php 
namespace Shrikant\OTP;

use Shrikant\OTP\Storage\OTPStoreInterface;

class OTP
{
    protected OTPStoreInterface $store;

    public function __construct(OTPStoreInterface $store)
    {
        $this->store = $store;
    }

    public function generate(string $key, int $length = 6, int $ttl = 300): string
    {
        $otp = str_pad((string)random_int(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
        $this->store->set($key, $otp, $ttl);
        return $otp;
    }

    public function validate(string $key, string $otp): bool
    {
        $validOtp = $this->store->get($key);
        if ($validOtp && $validOtp === $otp) {
            $this->store->delete($key);
            return true;
        }
        return false;
    }
}
