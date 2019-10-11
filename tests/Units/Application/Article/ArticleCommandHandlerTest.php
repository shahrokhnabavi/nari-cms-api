<?php
declare(strict_types = 1);

namespace Tests\Units\Application\Article;

use PDO;
use PDOStatement;
use Prophecy\Argument;
use Prophecy\Prophecy\MethodProphecy;
use Prophecy\Prophecy\ObjectProphecy;
use SiteApi\Application\Article\AddArticleCommand;
use SiteApi\Application\Article\AddTagsToArticleCommand;
use SiteApi\Application\Article\ArticleCommandHandler;
use PHPUnit\Framework\TestCase;
use SiteApi\Domain\Article\ArticleAlreadyExistsException;
use SiteApi\Infrastructure\Pdo\PdoConnectionFactory;
use SiteApi\Infrastructure\Pdo\PdoCredentialException;

class ArticleCommandHandlerTest extends TestCase
{
    /**
     * @var ObjectProphecy|PDO
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
        $this->statement->fetchColumn()->willReturn(0);
        $this->statement->execute(Argument::any())->willReturn(null);

        $this->pdo = $this->prophesize(PDO::class);
        $this->pdo->prepare(Argument::cetera())->willReturn($this->statement->reveal());

        $this->pdoConnection = $this->prophesize(PdoConnectionFactory::class);
        $this->pdoConnection->createConnectionBySource('website')->willReturn($this->pdo->reveal());

        /** @var PdoConnectionFactory $pdoConnection */
        $pdoConnection = $this->pdoConnection->reveal();
        $this->handler = new ArticleCommandHandler($pdoConnection);
    }

    /**
     * @throws ArticleAlreadyExistsException
     */
    public function testShouldHandleTheAddArticleCommandToSeeArticleInDatabase()
    {
        $self = $this;

        $this->statement->execute(Argument::any())->will(function ($args, ObjectProphecy $mock, MethodProphecy $methodProphecy) use ($self) {
            $arguments = $args[0];
            $self->assertEquals('test article', $arguments[':title']);

            switch ($self->methodCalls($mock, $methodProphecy)) {
                case 0:
                    $self->assertCount(1, $arguments);
                    break;
                case 1:
                    $self->assertCount(4, $arguments);
                    $self->assertEquals('test article', $arguments[':title']);
                    $self->assertEquals('blog text', $arguments[':text']);
                    $self->assertEquals('shahrokh', $arguments[':author']);
                    break;
            };
        });

        $this->handler->handleAddArticleCommand(
            new AddArticleCommand('uuid', 'test article','blog text','shahrokh')
        );
    }

    /**
     * @throws ArticleAlreadyExistsException
     */
    public function testShouldThrowAnArticleAlreadyExitsException()
    {
        $this->statement->fetchColumn()->willReturn(1);

        $this->expectException(ArticleAlreadyExistsException::class);

        $this->handler->handleAddArticleCommand(
            new AddArticleCommand('uuid', 'test article','blog text','shahrokh')
        );
    }

    /**
     * @throws PdoCredentialException
     */
    public function testShouldHandleTheAddTagsToArticleCommandToSeeArticleInDatabase()
    {
        $self = $this;

        $this->pdo->beginTransaction()->willReturn(true);
        $this->pdo->commit()->willReturn(true);

        $this->statement->execute(Argument::any())->will(function ($args, ObjectProphecy $mock, MethodProphecy $methodProphecy) use ($self) {
            $arguments = $args[0];

            switch ($self->methodCalls($mock, $methodProphecy)) {
                case 0:
                    $self->assertEquals([
                        ':articleId' => 'uuid',
                        ':tagId' => 'tag-uuid-1'
                    ], $arguments);
                    break;
                case 1:
                    $self->assertEquals([
                        ':articleId' => 'uuid',
                        ':tagId' => 'tag-uuid-2'
                    ], $arguments);
                    break;
            };
        });

        $this->handler->handleAddTagsToArticleCommand(
            new AddTagsToArticleCommand('uuid', ['tag-uuid-1', 'tag-uuid-2'])
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
