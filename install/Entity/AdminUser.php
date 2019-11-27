<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use PhpGuild\RhapsodyBundle\Entity\AdminUser as AdminUserBase;

/**
 * Class AdminUser
 * @ORM\Entity(repositoryClass="App\Repository\AdminUserRepository")
 */
class AdminUser extends AdminUserBase
{
}
