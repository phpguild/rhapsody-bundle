<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Configuration;

use PhpGuild\ResourceBundle\Configuration\AbstractConfigurationProcessor;
use PhpGuild\RhapsodyBundle\Configuration\Model\RhapsodyResourceCollection;

/**
 * Class RhapsodyConfigurationProcessor
 */
final class RhapsodyConfigurationProcessor extends AbstractConfigurationProcessor
{
    /** @var string $resourceCollectionClass */
    protected $resourceCollectionClass = RhapsodyResourceCollection::class;
}
