<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Pdo;

class PdoCredentialsManager
{
    /** @var PdoCredentials[] */
    private $pdoCredentials;

    /**
     * @param string $source
     *
     * @return PdoCredentials
     * @throws PdoCredentialException
     */
    public function getCredentials(string $source): PdoCredentials
    {
        if (!isset($this->pdoCredentials[$source])) {
            throw PdoCredentialException::causedBy("The key '{$source}' doesn't exist in the credential store.");
        }

        return $this->pdoCredentials[$source];
    }

    /**
     * @param string $source
     * @param PdoCredentials $pdoCredentials
     *
     * @return PdoCredentialsManager
     * @throws PdoCredentialException
     */
    public function addCredentials(string $source, PdoCredentials $pdoCredentials): self
    {
        if (isset($this->pdoCredentials[$source])) {
            throw PdoCredentialException::causedBy("The key '{$source}' already exists in the credential store.");
        }

        $this->pdoCredentials[$source] = $pdoCredentials;

        return $this;
    }

    /**
     * @param string $source
     *
     * @return bool
     */
    public function hasCredentials(string $source): bool
    {
        return isset($this->pdoCredentials[$source]);
    }
}
