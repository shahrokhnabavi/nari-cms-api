<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\CommandBus;

use League\Container\Container;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Tactician\CommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\Locator\HandlerLocator;
use League\Tactician\Handler\MethodNameInflector\HandleClassNameInflector;
use Psr\Log\LoggerInterface;
use SiteApi\Application\CommandBus\CommandHandlerInterface;
use SiteApi\Infrastructure\Configuration\ConfigurationInterface;

/**
 * @codeCoverageIgnore
 */
final class CommandBusServiceProvider extends AbstractServiceProvider
{
    /** @var string[] */
    protected $provides = [
        CommandBus::class,
    ];

    /**
     * @return void
     */
    public function register(): void
    {
        /** @var Container $container */
        $container = $this->getContainer();

        $container->add(CommandBus::class, function () use ($container): CommandBus {
            $commandHandlerMiddleware = new CommandHandlerMiddleware(
                new ClassNameExtractor(),
                $this->generateLocator($container->get(ConfigurationInterface::class)),
                new HandleClassNameInflector()
            );

            return new CommandBus([
                new LoggingMiddleware($container->get(LoggerInterface::class)),
                $commandHandlerMiddleware,
            ]);
        });
    }

    /**
     * @param ConfigurationInterface $configuration
     *
     * @return HandlerLocator
     * @throws \Exception
     */
    private function generateLocator(ConfigurationInterface $configuration): HandlerLocator
    {
        $handlers = $configuration->get('commandHandlers');
        $handlerClassMap = [];

        /** @var CommandHandlerInterface $commandHandler */
        foreach ($handlers as $commandHandler) {
            if (!is_subclass_of($commandHandler, CommandHandlerInterface::class)) {
                throw new \Exception('why');
            }

            $commands = $commandHandler::handlesCommand();

            foreach ($commands as $command) {
                $handlerClassMap[$command] = $commandHandler;
            }
        }

        return new ContainerLocator($this->container, $handlerClassMap);
    }
}
