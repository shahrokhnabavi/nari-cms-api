<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Pdo;

class PdoCredentials
{
    /** @var string */
    private $dns;

    /** @var string */
    private $username;

    /** @var string */
    private $password;

    /** @var string */
    private $caFile;

    /**
     * @param string $dns
     * @param string $username
     * @param string $password
     * @param string $caFile
     */
    public function __construct(string $dns, string $username, string $password, string $caFile)
    {
        $this->dns = $dns;
        $this->username = $username;
        $this->password = $password;
        $this->caFile = $caFile;
    }

    /**
     * @return string
     */
    public function getDns(): string
    {
        return $this->dns;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getCaFile(): string
    {
        return $this->caFile;
    }

    /**
     * @return array
     */
    public function __debugInfo(): array
    {
        return [
            'dns' => $this->dns,
            'username' => $this->username,
            'password' => '[redacted]',
            'caFile' => $this->caFile,
        ];
    }
}
