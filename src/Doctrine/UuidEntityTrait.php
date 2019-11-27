<?php

namespace PhpGuild\RhapsodyBundle\Doctrine;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait UuidEntityTrait
 */
trait UuidEntityTrait
{
    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
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
