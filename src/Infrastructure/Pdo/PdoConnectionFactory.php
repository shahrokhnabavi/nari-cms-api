<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Pdo;

use InvalidArgumentException;
use PDO;
use PDOException;
use Throwable;

class PdoConnectionFactory
{
    /** @var string */
    const WEBSITE_DATABASE = 'web_db';

    /** @var PdoCredentialsManager */
    private $credentialsManager;

    /**
     * @param PdoCredentialsManager $credentialsManager
     */
    public function __construct(PdoCredentialsManager $credentialsManager)
    {
        $this->credentialsManager = $credentialsManager;
    }

    /**
     * @param string $source
     *
     * @return PDO
     * @throws PdoCredentialException
     */
    public function createConnectionBySource(string $source): PDO
    {
        if (!$this->credentialsManager->hasCredentials($source)) {
            throw new InvalidArgumentException("No credentials available for data source {$source}");
        }

        return $this->createConnection($this->credentialsManager->getCredentials($source));
    }

    /**
     * @param PdoCredentials $credential
     *
     * @return PDO
     * @throws PDOException
     */
    private function createConnection(PdoCredentials $credential): PDO
    {
        try {
            return new PDO(
                $credential->getDns(),
                $credential->getUsername(),
                $credential->getPassword(),
                $this->getConnectionOptions($credential)
            );
        } catch (Throwable $throwable) {
            throw new PDOException($throwable->getMessage());
        }
    }

    /**
     * @param PdoCredentials $credentials
     *
     * @return mixed[]
     */
    private function getConnectionOptions(PdoCredentials $credentials): array
    {
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        ];

        if (!empty($credentials->getCaFile())) {
            $options[PDO::MYSQL_ATTR_SSL_CA] = $credentials->getCaFile();
        }

        return $options;
    }
}
