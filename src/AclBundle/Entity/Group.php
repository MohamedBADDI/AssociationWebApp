<?php
/**
 * Created by PhpStorm.
 * User: baddi
 * Date: 4/24/2017
 * Time: 8:22 AM
 */
// src/AppBundle/Entity/Group.php

namespace AclBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ab_group")
 */
class Group extends BaseGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


}