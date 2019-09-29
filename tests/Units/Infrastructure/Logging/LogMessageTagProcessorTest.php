<?php
declare(strict_types = 1);

namespace Tests\Units\Infrastructure\Logging;

use SiteApi\Infrastructure\Logging\LogMessageTagProcessor;
use PHPUnit\Framework\TestCase;

class LogMessageTagProcessorTest extends TestCase
{
    private $extra = [
        'extra' => [
            'message' => 'It is tested by unit test',
            'level' => 'warning',
        ],
    ];

    public function testShouldAddPropertiesToLogMessage()
    {
        $properties = [
            'extra' => [],
        ];

        $logMessage = new LogMessageTagProcessor();

        $this->assertEquals($properties, $logMessage());

        LogMessageTagProcessor::addTag('message', $this->extra['extra']['message']);
        $properties['source'] = 'php';
        $properties['extra']['message'] = $this->extra['extra']['message'];
        $this->assertEquals($properties, $logMessage(['source' => 'php']));

        $logMessage::addTag('level', $this->extra['extra']['level']);
        unset($properties['source']);
        $properties['extra']['level'] = $this->extra['extra']['level'];
        $this->assertEquals($properties, $logMessage());
    }

    public function testShouldAddTagsToExtraPropertyOfLogMessage()
    {
        LogMessageTagProcessor::addTag('message', $this->extra['extra']['message']);
        LogMessageTagProcessor::addTag('level', $this->extra['extra']['level']);

        $logMessage = new LogMessageTagProcessor();

        $this->assertEquals($this->extra, $logMessage());
    }
}
