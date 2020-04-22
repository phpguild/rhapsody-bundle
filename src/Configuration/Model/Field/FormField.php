<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration\Model\Field;

/**
 * Class FormField
 */
class FormField extends AbstractField
{
    /** @var int|null $length */
    private $length;

    /** @var boolean $nullable */
    private $nullable = true;

    /**
     * getLength
     *
     * @return int|null
     */
    public function getLength(): ?int
    {
        return $this->length;
    }

    /**
     * setLength
     *
     * @param int|null $length
     *
     * @return $this
     */
    public function setLength(?int $length): self
    {
        $this->length = $length;

        return $this;
    }

    /**
     * isNullable
     *
     * @return bool
     */
    public function isNullable(): bool
    {
        return $this->nullable;
    }

    /**
     * setNullable
     *
     * @param bool $nullable
     *
     * @return $this
     */
    public function setNullable(bool $nullable): self
    {
        $this->nullable = $nullable;

        return $this;
    }
}
