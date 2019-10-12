<?php
declare(strict_types = 1);

namespace SiteApi\Domain\Tags;

use Exception;
use InvalidArgumentException;
use SiteApi\Core\UUID;

class Tag
{
    /** @var UUID */
    private $identifier;

    /** @var string */
    private $name;

    /**
     * @param mixed[] $data
     *
     * @throws Exception
     */
    public function __construct(array $data)
    {
        if (empty($data['identifier'])) {
            throw new InvalidArgumentException('Tag identifier should not be empty');
        }

        if (empty($data['name'])) {
            throw new InvalidArgumentException('Tag name should not be empty');
        }

        $identifier = $data['identifier'] instanceof UUID ?
            $data['identifier'] :
            UUID::fromString($data['identifier']);

        $this->identifier = $identifier;
        $this->name = $data['name'];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return UUID
     */
    public function getIdentifier(): UUID
    {
        return $this->identifier;
    }
}
