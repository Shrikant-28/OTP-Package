Here's a full setup for your **framework-agnostic OTP PHP package**, including Git repo structure and a suggested `README.md`.

---

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

[![PHP Version](https://img.shields.io/badge/php-%3E%3D7.4-blue.svg)](https://www.php.net/)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

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
composer require yourname/otp
````

---

## 🛠️ Usage

```php
use YourVendor\OTP\OTP;
use YourVendor\OTP\Storage\OTPStoreInterface;

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

Pull requests and issues are welcome!

````

---

## 📄 .gitignore

```gitignore
/vendor
/.idea
/.vscode
composer.lock
````

---

## 🧪 phpunit.xml (Optional)

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit bootstrap="vendor/autoload.php"
         colors="true"
         verbose="true">
    <testsuites>
        <testsuite name="OTP Test Suite">
            <directory>./tests</directory>
        </testsuite>
    </testsuites>
</phpunit>
```

---

## ✅ Git Repo Setup

Now in your terminal:

```bash
git init
git add .
git commit -m "Initial commit: framework-agnostic OTP package"
gh repo create yourname/otp --public --source=. --push
```

*(Replace `yourname` with your GitHub username. You need [GitHub CLI](https://cli.github.com/) for `gh` to work.)*

---

Would you like me to generate a ZIP file of the full repo you can import directly, or scaffold a Laravel wrapper next (`otp-laravel`)?
