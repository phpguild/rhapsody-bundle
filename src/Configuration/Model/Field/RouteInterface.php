<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration\Model\Field;

/**
 * Interface RouteInterface
 */
interface RouteInterface
{
    /**
     * getName
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * setName
     *
     * @param string|null $name
     *
     * @return RouteInterface|self
     */
    public function setName(?string $name): RouteInterface;

    /**
     * getPath
     *
     * @return string|null
     */
    public function getPath(): ?string;

    /**
     * setPath
     *
     * @param string|null $path
     *
     * @return RouteInterface|self
     */
    public function setPath(?string $path): RouteInterface;
}
