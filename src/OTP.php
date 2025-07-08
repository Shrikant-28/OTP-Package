<?php

namespace Shrikant\OTP;

use Shrikant\OTP\Storage\OTPStoreInterface;

/**
 * Class OTP
 *
 * Handles generation and validation of one-time passwords (OTPs).
 */
class OTP
{
    /**
     * @var OTPStoreInterface
     */
    protected OTPStoreInterface $store;

    /**
     * OTP constructor.
     *
     * @param OTPStoreInterface $store The storage implementation for OTPs.
     */
    public function __construct(OTPStoreInterface $store)
    {
        $this->store = $store;
    }

    /**
     * Generates a new OTP, stores it with a TTL, and returns it.
     *
     * @param string $key Unique identifier for the OTP (e.g., user email or phone).
     * @param int $length Length of the OTP (default: 6 digits).
     * @param int $ttl Time-to-live in seconds (default: 300 seconds).
     *
     * @return string The generated OTP.
     *
     * @throws \Exception If it was not possible to gather sufficient entropy.
     */
    public function generate(string $key, int $length = 6, int $ttl = 300): string
    {
        $otp = str_pad((string)random_int(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
        $this->store->set($key, $otp, $ttl);
        return $otp;
    }

    /**
     * Validates the given OTP against the stored one.
     *
     * If valid, the OTP is deleted from storage to prevent reuse.
     *
     * @param string $key Unique identifier for the OTP.
     * @param string $otp The OTP to validate.
     *
     * @return bool True if valid, false otherwise.
     */
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
