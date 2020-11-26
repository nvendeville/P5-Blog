<?php

namespace App\core;

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

    public function sessionSet(string $name, $value): void
    {
        $this->sessionVars[$name] = $value;
    }

    public function sessionGet(string $name)
    {
        if ($this->sessionIsset($name)) {
            return $this->sessionVars[$name];
        }
        return  "";
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
