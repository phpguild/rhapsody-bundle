<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration\Model\Field;

/**
 * Class AbstractField
 */
abstract class AbstractField implements FieldInterface
{
    /** @var string|null $name */
    protected $name;

    /** @var string|null $type */
    protected $type;

    /** @var string|null $label */
    protected $label;

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
     * @return FieldInterface|self
     */
    public function setName(?string $name): FieldInterface
    {
        $this->name = $name;

        return $this;
    }

    /**
     * getType
     *
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * setType
     *
     * @param string|null $type
     *
     * @return FieldInterface|self
     */
    public function setType(?string $type): FieldInterface
    {
        $this->type = $type;

        return $this;
    }

    /**
     * getLabel
     *
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * setLabel
     *
     * @param string|null $label
     *
     * @return FieldInterface|self
     */
    public function setLabel(?string $label): FieldInterface
    {
        $this->label = $label;

        return $this;
    }
}
