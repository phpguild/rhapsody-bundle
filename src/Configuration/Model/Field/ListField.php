<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration\Model\Field;

/**
 * Class ListField
 */
class ListField extends AbstractField
{
    /** @var string|null $icon */
    private $icon;

    /**
     * getIcon
     *
     * @return string|null
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * setIcon
     *
     * @param string|null $icon
     *
     * @return $this
     */
    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }
}
