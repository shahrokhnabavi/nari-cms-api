<?php
declare(strict_types = 1);

namespace Tests\Units\Infrastructure\Pdo;

use SiteApi\Infrastructure\Pdo\PdoCredentials;
use PHPUnit\Framework\TestCase;

class PdoCredentialsTest extends TestCase
{
    const DUMP_PDO_CREDENTIALS = "object(SiteApi\Infrastructure\Pdo\PdoCredentials)#340 (4) {
  ['dns']=>\n  string(34) 'mysql:host=localhost;dbname=web_db'\n  ['username']=>\n  string(8) 'username'
  ['password']=>\n  string(10) '[redacted]'\n  ['caFile']=>\n  string(7) 'ca File'\n}\n";

    public function testShouldSeeAnArrayOfCredentialsWhenWeCallDebugInfo()
    {
        $pdoCredentials = new PdoCredentials(
            'mysql:host=localhost;dbname=web_db',
            'username',
            'password',
            'ca File'
        );

        $this->assertEquals([
            'dns' => 'mysql:host=localhost;dbname=web_db',
            'username' => 'username',
            'password' => '[redacted]',
            'caFile' => 'ca File'
        ], $pdoCredentials->__debugInfo());
    }
}
