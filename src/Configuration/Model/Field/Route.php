<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration\Model\Field;

/**
 * Class Route
 */
class Route implements RouteInterface
{
    /** @var string|null $name */
    private $name;

    /** @var string|null $path */
    private $path;

    /**
     * getName
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * setName
     *
     * @param string|null $name
     *
     * @return RouteInterface|self
     */
    public function setName(?string $name): RouteInterface
    {
        $this->name = $name;

        return $this;
    }

    /**
     * getPath
     *
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * setPath
     *
     * @param string|null $path
     *
     * @return RouteInterface|self
     */
    public function setPath(?string $path): RouteInterface
    {
        $this->path = $path;

        return $this;
    }
}
