<?php
declare(strict_types = 1);

namespace Tests\Units\Application\Article;

use Exception;
use PDOStatement;
use Prophecy\Argument;
use Prophecy\Prophecy\MethodProphecy;
use Prophecy\Prophecy\ObjectProphecy;
use SiteApi\Application\Article\AddArticleCommand;
use SiteApi\Application\Article\AddTagsToArticleCommand;
use SiteApi\Application\Article\ArticleCommandHandler;
use PHPUnit\Framework\TestCase;
use SiteApi\Core\UUID;
use SiteApi\Domain\Article\ArticleAlreadyExistsException;
use SiteApi\Domain\Tags\Tag;
use SiteApi\Infrastructure\Article\PdoArticleRepository;
use SiteApi\Infrastructure\Pdo\PdoConnectionFactory;
use SiteApi\Infrastructure\Pdo\PdoCredentialException;
use SiteApi\Infrastructure\Pdo\WebsitePDO;

class ArticleCommandHandlerTest extends TestCase
{
    /** @var mixed[] */
    private $article = [
        'identifier' => '',
        'title' => 'big bang',
        'text' => 'this is my text',
        'author' => 'shahrokh'
    ];

    /**
     * @var ObjectProphecy|WebsitePDO
     */
    private $pdo;

    /**
     * @var ObjectProphecy|PDOStatement
     */
    private $statement;

    /**
     * @var ObjectProphecy|PdoConnectionFactory
     */
    private $pdoConnection;

    /**
     * @var ArticleCommandHandler
     */
    private $handler;

    /**
     * @throws PdoCredentialException
     */
    protected function setUp(): void
    {
        $this->statement = $this->prophesize(PDOStatement::class);
        $this->statement->fetch()->willReturn([]);
        $this->statement->execute(Argument::any())->willReturn(null);

        $this->pdo = $this->prophesize(WebsitePDO::class);
        $this->pdo->prepare(Argument::cetera())->willReturn($this->statement->reveal());
        $this->pdo->beginTransaction()->willReturn(true);
        $this->pdo->inTransaction()->willReturn(false);
        $this->pdo->commit()->willReturn(true);

        $this->pdoConnection = $this->prophesize(PdoConnectionFactory::class);
        $this->pdoConnection->createConnectionBySource('website')->willReturn($this->pdo->reveal());

        /** @var PdoConnectionFactory $pdoConnection */
        $pdoConnection = $this->pdoConnection->reveal();


        $articleRepo = new PdoArticleRepository($pdoConnection);

        $this->handler = new ArticleCommandHandler(
            $articleRepo
        );
    }

    /**
     * @throws Exception
     */
    public function testShouldHandleTheAddArticleCommandToSeeArticleInDatabase()
    {
        $self = $this;

        $this->statement->execute(Argument::any())->will(function ($args, ObjectProphecy $mock, MethodProphecy $methodProphecy) use ($self) {
            $arguments = $args[0];
            $self->assertEquals($self->article['title'], $arguments[':title']);

            switch ($self->methodCalls($mock, $methodProphecy)) {
                case 0:
                    $self->assertCount(1, $arguments);
                    break;
                case 1:
                    $self->assertCount(4, $arguments);
                    $self->assertEquals($self->article['text'], $arguments[':text']);
                    $self->assertEquals($self->article['author'], $arguments[':author']);
                    break;
            };
        });
        $uuid = UUID::create();

        $this->handler->handleAddArticleCommand(
            new AddArticleCommand($uuid, $this->article['title'], $this->article['text'], $this->article['author'], [])
        );
    }

    /**
     * @throws Exception
     */
    public function testShouldThrowAnArticleAlreadyExitsException()
    {
        $uuid = UUID::create();
        $this->article['identifier'] = $uuid;
        $this->statement->fetch()->willReturn($this->article);

        $this->expectException(ArticleAlreadyExistsException::class);

        $this->handler->handleAddArticleCommand(
            new AddArticleCommand($uuid, $this->article['title'], $this->article['text'], $this->article['author'], [])
        );
    }

    /**
     * @throws Exception
     */
    public function testShouldThrowAnExceptionIfThereIsADatabaseError()
    {
        $uuid = UUID::create();
        $this->pdo->commit()->willThrow(new Exception('Database error'));
        $this->pdo->inTransaction()->willReturn(true);
        $this->pdo->rollBack()->willReturn(true);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Database error');

        $this->handler->handleAddArticleCommand(
            new AddArticleCommand($uuid, $this->article['title'], $this->article['text'], $this->article['author'], [])
        );
    }

    /**
     * @throws Exception
     */
    public function testShouldHandleTheAddTagsToArticleCommandToSeeArticleInDatabase()
    {
        $self = $this;
        $uuids = [
            UUID::create(),
            UUID::create(),
            UUID::create()
        ];

        $this->statement->fetch()->willReturn([
            'identifier' => (string)$uuids[1],
            'name' => 'php'
        ], []);
        $this->statement->execute(Argument::any())->will(function ($args, ObjectProphecy $mock, MethodProphecy $methodProphecy) use ($self, $uuids) {
            $arguments = $args[0];
            switch ($self->methodCalls($mock, $methodProphecy)) {
                case 0:
                    return true;
                case 1:
                    $self->assertEquals([
                        ':articleId' => (string)$uuids[0],
                        ':tagId' => (string)$uuids[1]
                    ], $arguments);
                    break;
                case 2:
                    return false;
                case 3:
                    return true;
                case 4:
                    $self->assertEquals([
                        ':articleId' => (string)$uuids[0],
                        ':tagId' => (string)$uuids[2]
                    ], $arguments);
                    break;
            };
        });

        $this->handler->handleAddTagsToArticleCommand(
            new AddTagsToArticleCommand($uuids[0], [
                new Tag(['identifier' => $uuids[1], 'name' => 'php']),
                new Tag(['identifier' => $uuids[2], 'name' => 'java']),
            ])
        );
    }

    public function testShouldSeeTwoCommandsIsHandledByThisHandler()
    {
        $commands = ArticleCommandHandler::handlesCommand();

        $this->assertCount(2, $commands);
        $this->assertEquals(AddArticleCommand::class, $commands[0]);
        $this->assertEquals(AddTagsToArticleCommand::class, $commands[1]);
    }

    /**
     * @param ObjectProphecy $mock
     * @param MethodProphecy $methodProphecy
     *
     * @return int
     */
    private function methodCalls(ObjectProphecy $mock, MethodProphecy $methodProphecy): int
    {
        $methodCalls = $mock->findProphecyMethodCalls(
            $methodProphecy->getMethodName(),
            $methodProphecy->getArgumentsWildcard()
        );

        return count($methodCalls);
    }
}
