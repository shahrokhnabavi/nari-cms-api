<?php
declare(strict_types = 1);

namespace SiteApi\Core;

use Exception;

class UUID implements IdentityInterface
{
    /** @var string */
    const PATTERN = "/^[0-9a-f]{8}\-[0-9a-f]{4}\-[0-9a-f]{4}\-[0-9a-f]{4}\-[0-9a-f]{12}$/";

    /** @var string */
    private $identifier;

    public function __construct(string $identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @inheritdoc
     */
    public function __toString(): string
    {
        return $this->identifier;
    }

    /**
     * @inheritdoc
     */
    public function asBinary(): string
    {
        return hex2bin(str_replace('-', '', $this->identifier));
    }

    /**
     * @inheritdoc
     */
    public function equals(IdentityInterface $identity): bool
    {
        return $this->identifier == (string)$identity;
    }

    /**
     * @param string $identifier
     *
     * @return UUID
     * @throws Exception
     */
    public static function fromString(string $identifier): self
    {
        if (preg_match(static::PATTERN, $identifier) !== 1) {
            InvalidIdentityException::throw("Given string '{$identifier}' is not a valid UUID");
        }

        return new static($identifier);
    }
}
