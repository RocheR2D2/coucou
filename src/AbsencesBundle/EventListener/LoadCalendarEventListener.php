<?php
/**
 * Created by PhpStorm.
 * User: Haosh
 * Date: 15/03/2018
 * Time: 14:15
 */

namespace AbsencesBundle\EventListener;

use AbsencesBundle\Entity\Absence;
use Doctrine\ORM\EntityManagerInterface;

class LoadCalendarEventListener
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function loadEvent() {
        $events = $this->em->getRepository('AbsencesBundle:Absence')->findAll();
        return $events;
    }
}