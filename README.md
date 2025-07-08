## 📂 Git Repo: `otp`

### Directory Tree

```
otp/
├── src/
│   ├── OTP.php
│   └── Storage/
│       └── OTPStoreInterface.php
├── tests/
│   └── OTPTest.php
├── composer.json
├── README.md
├── .gitignore
└── phpunit.xml
```

---

## 📘 README.md

````markdown
# OTP

**Framework-Agnostic One Time Password (OTP) Generator and Validator for PHP**

---

## 🚀 Features

- ✅ Generate numeric OTPs (default 6 digits)
- ✅ Validate OTPs
- ✅ TTL (expiration time) support
- ✅ Framework-agnostic (works with Laravel, Symfony, Slim, etc.)
- ✅ Pluggable storage (memory, session, database)

---

## 📦 Installation

```bash
composer require shrikant/otp
````

---

## 🛠️ Usage

```php
use Shrikant\OTP\OTP;
use Shrikant\OTP\Storage\OTPStoreInterface;

class SessionStore implements OTPStoreInterface {
    public function set(string $key, string $otp, int $ttl): void {
        $_SESSION[$key] = ['otp' => $otp, 'expires' => time() + $ttl];
    }

    public function get(string $key): ?string {
        return ($_SESSION[$key]['expires'] ?? 0) > time()
            ? $_SESSION[$key]['otp']
            : null;
    }

    public function delete(string $key): void {
        unset($_SESSION[$key]);
    }
}

session_start();
$otpService = new OTP(new SessionStore());

$otp = $otpService->generate('user:email', 6, 300); // Generate 6-digit OTP valid for 5 minutes

// Later...
if ($otpService->validate('user:email', $_POST['otp'])) {
    echo "Valid!";
} else {
    echo "Invalid!";
}
```

---

## ✅ Testing

```bash
composer install
./vendor/bin/phpunit
```

---

## 🔌 Extending

Implement `OTPStoreInterface` to use Redis, Database, Cache, etc.

```php
interface OTPStoreInterface {
    public function set(string $key, string $otp, int $ttl): void;
    public function get(string $key): ?string;
    public function delete(string $key): void;
}
```

---

## 📄 License

MIT License. Do what you want.

---

## ❤️ Contributing

Pull requests and issues are welcome!!!
