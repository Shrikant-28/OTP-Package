<?php

namespace Shrikant\OTP\Storage;

/**
 * Interface OTPStoreInterface
 *
 * Defines the contract for storing and retrieving OTPs.
 */
interface OTPStoreInterface
{
    /**
     * Stores an OTP with a specific key and time-to-live.
     *
     * @param string $key Unique identifier for the OTP.
     * @param string $otp The OTP value to store.
     * @param int $ttl Time-to-live in seconds.
     *
     * @return void
     */
    public function set(string $key, string $otp, int $ttl): void;

    /**
     * Retrieves the OTP associated with a given key.
     *
     * @param string $key Unique identifier for the OTP.
     *
     * @return string|null The OTP if found, or null if not found or expired.
     */
    public function get(string $key): ?string;

    /**
     * Deletes the OTP associated with a given key.
     *
     * @param string $key Unique identifier for the OTP.
     *
     * @return void
     */
    public function delete(string $key): void;
}
