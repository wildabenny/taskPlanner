<?php


namespace AppBundle\EventListener;

use ADesigns\CalendarBundle\Event\CalendarEvent;
use ADesigns\CalendarBundle\Entity\EventEntity;
use Doctrine\ORM\EntityManager;


class CalendarEventListener
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function loadEvents(CalendarEvent $calendarEvent)
    {
        $startDate = $calendarEvent->getStartDatetime();
        $endDate = $calendarEvent->getEndDatetime();

        $taskEvents = $this->entityManager->getRepository('AppBundle:Task')
            ->createQueryBuilder('task_events')
            ->where('task_events.event_datetime BETWEEN :startDate and :finishDate')
            ->setParameter('startDate', $startDate->format('Y-m-d H:i:s'))
            ->setParameter('finishDate', $endDate->format('Y-m-d H:i:s'))
            ->getQuery()->getResult();

        foreach ($taskEvents as $taskEvent) {

            if ($taskEvent->getAllDayEvent() === false) {

                $eventEntity = new EventEntity($taskEvent->getTitle(), $taskEvent->getStartDateTime(), $taskEvent->getEndDateTime());
            }

            else {

                    $eventEntity = new EventEntity($taskEvent->getTitle(), $taskEvent->getStartDatetime(), null, true);
                }

                $calendarEvent->addEvent($eventEntity);

        }
    }
}