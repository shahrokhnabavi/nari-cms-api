<?php
declare(strict_types = 1);

namespace SiteApi\Domain;

abstract class AggregateRoot
{
    /** @var string */
    private $id;

    /**
     * @param string $id
     */
    final public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}
