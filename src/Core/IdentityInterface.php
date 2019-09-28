<?php
declare(strict_types = 1);

namespace SiteApi\Core;

/**
 * @codeCoverageIgnore
 */
interface IdentityInterface
{
    /**
     * @return string
     */
    public function __toString(): string;

    /**
     * @return string
     */
    public function asBinary(): string;

    /**
     * @param IdentityInterface $identity
     *
     * @return bool
     */
    public function equals(IdentityInterface $identity): bool;
}
