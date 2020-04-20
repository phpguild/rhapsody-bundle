<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Twig;

use PhpGuild\RhapsodyBundle\Provider\RouterProvider;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Twig\TwigFunction;

/**
 * Class RhapsodyExtension
 */
class RhapsodyExtension extends AbstractExtension
{
    /** @var RouterProvider $routerProvider */
    private $routerProvider;

    /** @var UrlGeneratorInterface $generator */
    private $generator;

    /**
     * RhapsodyExtension constructor.
     *
     * @param RouterProvider $routerProvider
     * @param UrlGeneratorInterface $generator
     */
    public function __construct(RouterProvider $routerProvider, UrlGeneratorInterface $generator)
    {
        $this->routerProvider = $routerProvider;
        $this->generator = $generator;
    }

    /**
     * getFilters
     *
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
     * getFunctions
     *
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('rhapsody_path', [ $this, 'rhapsodyPath' ]),
            new TwigFunction('rhapsody_url', [ $this, 'rhapsodyUrl' ]),
        ];
    }

    /**
     * mergeRecursive
     *
     * @param array $default
     * @param array $array
     * @return array
     */
    public function mergeRecursive(array $default, array $array): array
    {
        return array_merge_recursive($default, $array);
    }

    /**
     * hydrateObject
     *
     * @param $object
     * @param string $key
     * @param $value
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

    /**
     * rhapsodyPath
     *
     * @param $name
     * @param array $parameters
     * @param bool $relative
     * @return string
     */
    public function rhapsodyPath($name, $parameters = [], $relative = false): string
    {
        return $this->generator->generate(
            $this->routerProvider->getRoute($name),
            $parameters,
            $relative ? UrlGeneratorInterface::RELATIVE_PATH : UrlGeneratorInterface::ABSOLUTE_PATH
        );
    }

    /**
     * rhapsodyUrl
     *
     * @param $name
     * @param array $parameters
     * @param bool $schemeRelative
     * @return string
     */
    public function rhapsodyUrl($name, $parameters = [], $schemeRelative = false): string
    {
        return $this->generator->generate(
            $this->routerProvider->getRoute($name),
            $parameters,
            $schemeRelative ? UrlGeneratorInterface::NETWORK_PATH : UrlGeneratorInterface::ABSOLUTE_URL
        );
    }
}
