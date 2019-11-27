<?php

namespace PhpGuild\RhapsodyBundle\Doctrine;

/**
 * Trait UuidTrait
 */
trait UuidTrait
{
    /** @var string */
    protected $id;

    /**
     * setId
     *
     * @param string $id
     *
     * @return $this
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * getId
     *
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }
}
