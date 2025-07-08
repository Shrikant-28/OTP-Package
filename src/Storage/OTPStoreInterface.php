<?php 
namespace Shrikant\OTP\Storage;

interface OTPStoreInterface
{
    public function set(string $key, string $otp, int $ttl): void;
    public function get(string $key): ?string;
    public function delete(string $key): void;
}
