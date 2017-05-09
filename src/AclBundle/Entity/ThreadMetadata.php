<?php
/**
 * Created by PhpStorm.
 * User: baddi
 * Date: 5/8/2017
 * Time: 4:28 PM
 */

namespace AclBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\MessageBundle\Entity\ThreadMetadata as BaseThreadMetadata;

/**
 * @ORM\Entity
 */
class ThreadMetadata extends BaseThreadMetadata
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(
     *   targetEntity="AclBundle\Entity\Thread",
     *   inversedBy="metadata"
     * )
     * @var \FOS\MessageBundle\Model\ThreadInterface
     */
    protected $thread;

    /**
     * @ORM\ManyToOne(targetEntity="AclBundle\Entity\User")
     * @var \FOS\MessageBundle\Model\ParticipantInterface
     */
    protected $participant;
}