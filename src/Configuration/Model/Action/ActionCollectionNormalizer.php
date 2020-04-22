<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration\Model\Action;

/**
 * Class ActionCollectionNormalizer
 */
class ActionCollectionNormalizer
{
    /**
     * __get
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->{$name};
    }

    /**
     * __set
     *
     * @param string $name
     * @param        $value
     */
    public function __set(string $name, $value)
    {
        $this->{$name} = $value;
    }

    /**
     * __isset
     *
     * @param string $name
     *
     * @return bool
     */
    public function __isset(string $name)
    {
        return isset($this->{$name});
    }
}
