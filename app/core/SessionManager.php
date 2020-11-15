<?php

namespace App\core;

/**
 * Class SessionManager
 * @package App\core
 */
trait SessionManager
{
    /**
     * @var array
     */
    private array $session_vars = [];


    /**
     * SessionManager constructor.
     */
    public function __construct()
    {
        if (!(session_status() === PHP_SESSION_ACTIVE)) {
            session_start();
        }
        $this->session_vars = &$_SESSION;
    }



    /**
     * @param string $name
     * @param mixed $value
     */
    public function sessionSet(string $name, object $value): void
    {
        $this->session_vars[$name] = $value;
    }

    /**
     * @param string $name
     *
     * @return object|string
     */
    public function sessionGet(string $name)
    {
        if ($this->sessionIsset($name)) {
            return $this->session_vars[$name];
        }
        return "";
    }

    /**
     * @param string $name
     * @return bool
     */
    public function sessionIsset(string $name): bool
    {
        return isset($this->session_vars[$name]);
    }

    /**
     * @param string $name
     * @param mixed ...$vars
     */
    public function sessionUnset(string $name, ...$vars): void
    {
        unset($this->session_vars[$name]);
        foreach ($vars as $var) {
            unset($this->session_vars[$var]);
        }
    }
}
