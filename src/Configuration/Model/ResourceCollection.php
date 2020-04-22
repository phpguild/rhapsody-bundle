<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration\Model\Resource;

/**
 * Class ResourceCollection
 */
class ResourceCollection
{
    /** @var string|null $label */
    protected $theme;

    /** @var ResourceNormalizer[] $resources */
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
     * @return $this
     */
    public function setTheme(?string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * getResources
     *
     * @return ResourceNormalizer[]
     */
    public function getResources(): array
    {
        return $this->resources;
    }

    /**
     * setResources
     *
     * @param ResourceNormalizer[] $resources
     *
     * @return $this
     */
    public function setResources(array $resources): self
    {
        $this->resources = $resources;

        return $this;
    }
}
