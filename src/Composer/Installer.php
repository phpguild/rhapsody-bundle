<?php

namespace PhpGuild\RhapsodyBundle\Composer;

use Composer\Script\Event;

/**
 * Class Installer
 */
class Installer
{
    /**
     * postPackageInstall
     *
     * @param Event $event
     */
    public static function postPackageInstall(Event $event):void
    {
        $installedPackage = $event->getComposer()->getPackage();
        dump($installedPackage);exit;
        // any tasks to run after the package is installed?
    }
}
