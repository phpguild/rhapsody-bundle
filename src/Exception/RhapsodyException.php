<?php

declare(strict_types=1);

namespace PhpGuild\RhapsodyBundle\Exception;

/**
 * Class RhapsodyException
 */
class RhapsodyException extends \Exception
{
    /** @var string */
    protected const SUPPORT_URL = 'https://github.com/phpguild/rhapsody-bundle/wiki/Exceptions';

    /**
     * RhapsodyException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param \Throwable|null $previous
     */
    public function __construct($message = '', $code = 0, \Throwable $previous = null)
    {
        parent::__construct(
            sprintf($message . "\n" . static::SUPPORT_URL . '#err%1$s', $code),
            $code,
            $previous
        );
    }
}
