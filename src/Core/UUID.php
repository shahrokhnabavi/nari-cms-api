<?php
declare(strict_types = 1);

namespace SiteApi\Core;

use Exception;
use Ramsey\Uuid\Uuid as RamsyUUID;

class UUID implements IdentityInterface
{
    /** @var string */
    const PATTERN = "/^[0-9a-f]{8}\-[0-9a-f]{4}\-[0-9a-f]{4}\-[0-9a-f]{4}\-[0-9a-f]{12}$/";

    /** @var string */
    private $identifier;

    /**
     * @param string $identifier
     *
     * @throws Exception
     */
    public function __construct(string $identifier)
    {
        if (!$this->isValid($identifier)) {
            InvalidIdentityException::throw("Given string '{$identifier}' is not a valid UUID");
        }

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
     * @codeCoverageIgnore
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
        return new static($identifier);
    }

    /**
     * @return UUID
     * @throws Exception
     */
    public static function create(): self
    {
        return new static(RamsyUUID::uuid1()->toString());
    }

    /**
     * @param string $identifier
     *
     * @return bool
     */
    private function isValid(string $identifier): bool
    {
        return preg_match(static::PATTERN, $identifier) === 1;
    }
}
