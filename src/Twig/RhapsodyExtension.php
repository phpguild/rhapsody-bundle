<?php

namespace PhpGuild\RhapsodyBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class RhapsodyExtension
 */
class RhapsodyExtension extends AbstractExtension
{
    /**
     * @return array
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('merge_recursive', [ $this, 'mergeRecursive' ]),
            new TwigFilter('hydrate_object', [ $this, 'hydrateObject' ]),
        ];
    }

    /**
     * @param mixed $default
     * @param mixed $array
     * @return array
     */
    public function mergeRecursive(array $default, array $array): array
    {
        return array_merge_recursive($default, $array);
    }

    /**
     * @param mixed $object
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function hydrateObject($object, string $key, $value)
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessorBuilder()
            ->enableExceptionOnInvalidIndex()
            ->getPropertyAccessor();

        $propertyAccessor->setValue($object, $key, $value);

        return $object;
    }
}
