<?php
declare(strict_types = 1);

namespace SiteApi\Application\Article;

use SiteApi\Application\CommandBus\Command;
use SiteApi\Core\UUID;

class RemoveArticleCommand extends Command
{
    /** @var UUID */
    private $identifier;

    /**
     * @param UUID $identifier
     */
    public function __construct(UUID $identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @return UUID
     */
    public function getIdentifier(): UUID
    {
        return $this->identifier;
    }
}
