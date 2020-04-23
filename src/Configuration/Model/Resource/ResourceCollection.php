<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration\Model\Resource;

/**
 * Class ResourceCollection
 */
class ResourceCollection implements ResourceCollectionInterface
{
    /** @var string|null $label */
    protected $theme;

    /** @var ResourceElement[] $resources */
    protected $resources = [];

    /**
     * getTheme
     *
     * @return string|null
     */
    public function getTheme(): ?string
    {
        return $this->theme;
    }

    /**
     * setTheme
     *
     * @param string|null $theme
     *
     * @return ResourceCollectionInterface|self
     */
    public function setTheme(?string $theme): ResourceCollectionInterface
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * getResources
     *
     * @return ResourceElementInterface[]
     */
    public function getResources(): array
    {
        return $this->resources;
    }

    /**
     * setResources
     *
     * @param ResourceElementInterface[] $resources
     *
     * @return ResourceCollectionInterface|self
     */
    public function setResources(array $resources): ResourceCollectionInterface
    {
        $this->resources = $resources;

        return $this;
    }
}
