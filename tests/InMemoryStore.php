<?php

namespace Tests;

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
