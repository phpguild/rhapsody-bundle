<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration\Model;

use PhpGuild\ResourceBundle\Model\Resource\ResourceCollection as BaseResourceCollection;

/**
 * Class RhapsodyResourceCollection
 */
class RhapsodyResourceCollection extends BaseResourceCollection
{
    /** @var string|null $label */
    protected $theme;

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
     * @return self
     */
    public function setTheme(?string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }
}
