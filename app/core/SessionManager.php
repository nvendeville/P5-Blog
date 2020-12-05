<?php

declare(strict_types=1);

namespace App\core;

use App\model\UserModel;

class SessionManager
{
    private array $sessionVars = [];

    public function __construct()
    {
        $this->setSession();
    }

    private function setSession(): SessionManager
    {
        $this->sessionVars = &$_SESSION;

        return $this;
    }

    public function sessionSetUser(string $name, UserModel $value): void
    {
        $this->sessionVars[$name] = $value;
    }

    public function sessionGetUser(string $name): ?UserModel
    {
        if ($this->sessionIsset($name)) {
            return $this->sessionVars[$name];
        }

        return  null;
    }

    public function sessionSetString(string $name, string $value): void
    {
        $this->sessionVars[$name] = $value;
    }

    public function sessionGetString(string $name): string
    {
        if ($this->sessionIsset($name)) {
            return $this->sessionVars[$name];
        }

        return  "";
    }

    public function sessionSetArray(string $name, array $value): void
    {
        $this->sessionVars[$name] = $value;
    }

    public function sessionGetArray(string $name): array
    {
        if ($this->sessionIsset($name)) {
            return $this->sessionVars[$name];
        }

        return  [];
    }

    public function sessionIsset(string $name): bool
    {
        return isset($this->sessionVars[$name]);
    }

    public function sessionUnset(string $name, ...$vars): void
    {
        unset($this->sessionVars[$name]);
        foreach ($vars as $var) {
            unset($this->sessionVars[$var]);
        }
    }
}
