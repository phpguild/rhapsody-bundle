<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration\Model\Resource;

/**
 * Interface ResourceCollectionInterface
 */
interface ResourceCollectionInterface
{
    /**
     * getTheme
     *
     * @return string|null
     */
    public function getTheme(): ?string;

    /**
     * setTheme
     *
     * @param string|null $theme
     *
     * @return ResourceCollectionInterface|self
     */
    public function setTheme(?string $theme): ResourceCollectionInterface;

    /**
     * getResources
     *
     * @return ResourceElementInterface[]
     */
    public function getResources(): array;

    /**
     * setResources
     *
     * @param ResourceElementInterface[] $resources
     *
     * @return ResourceCollectionInterface|self
     */
    public function setResources(array $resources): ResourceCollectionInterface;
}
