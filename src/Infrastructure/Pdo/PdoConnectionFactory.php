<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Pdo;

use InvalidArgumentException;
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
     * @return WebsitePDO
     * @throws PdoCredentialException
     */
    public function createConnectionBySource(string $source): WebsitePDO
    {
        if (!$this->credentialsManager->hasCredentials($source)) {
            throw new InvalidArgumentException("No credentials available for data source {$source}");
        }

        return $this->createConnection($this->credentialsManager->getCredentials($source));
    }

    /**
     * @param PdoCredentials $credential
     *
     * @return WebsitePDO
     * @throws PDOException
     */
    private function createConnection(PdoCredentials $credential): WebsitePDO
    {
        try {
            return new WebsitePDO(
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
            WebsitePDO::ATTR_PERSISTENT => true,
            WebsitePDO::ATTR_ERRMODE => WebsitePDO::ERRMODE_EXCEPTION,
            WebsitePDO::ATTR_DEFAULT_FETCH_MODE => WebsitePDO::FETCH_ASSOC,
            WebsitePDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        ];

        if (!empty($credentials->getCaFile())) {
            $options[WebsitePDO::MYSQL_ATTR_SSL_CA] = $credentials->getCaFile();
        }

        return $options;
    }
}
