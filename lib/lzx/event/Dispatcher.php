<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

//IKKI namespace Symfony\Component\EventDispatcher;

namespace lzx\event;

/**
 * The EventDispatcherInterface is the central point of Symfony's event listener system.
 *
 * Listeners are registered on the manager and events are dispatched through the
 * manager.
 *
 * @author  Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author  Jonathan Wage <jonwage@gmail.com>
 * @author  Roman Borschel <roman@code-factory.org>
 * @author  Bernhard Schussek <bschussek@gmail.com>
 * @author  Fabien Potencier <fabien@symfony.com>
 * @author  Jordi Boggiano <j.boggiano@seld.be>
 *
 * @api
 */
//IKKI class EventDispatcher implements EventDispatcherInterface
class Dispatcher implements DispatcherInterface
{

   private $listeners = [];
   private $sorted = [];

   /**
    * @see EventDispatcherInterface::dispatch
    *
    * @api
    */
   public function dispatch(Event $event)
   {
      if (array_key_exists($event->getName(), $this->listeners))
      {
         foreach ($this->listeners[$event->getName()] as $listener)
         {
            call_user_func($listener, $event);
            if ($event->isPropagationStopped())
            {
               break;
            }
         }
      }
   }

   /**
    * @see EventDispatcherInterface::getListeners
    */
   public function getListeners($eventName = null)
   {
      if (null !== $eventName)
      {
         if (!isset($this->sorted[$eventName]))
         {
            $this->sortListeners($eventName);
         }

         return $this->sorted[$eventName];
      }

      foreach (array_keys($this->listeners) as $eventName)
      {
         if (!isset($this->sorted[$eventName]))
         {
            $this->sortListeners($eventName);
         }
      }

      return $this->sorted;
   }

   /**
    * @see EventDispatcherInterface::hasListeners
    */
   public function hasListeners($eventName = null)
   {
      return (Boolean) count($this->getListeners($eventName));
   }

   /**
    * @see EventDispatcherInterface::addListener
    *
    * @api
    */
   public function addListener($eventName, $listener, $priority = 0)
   {
      $this->listeners[$eventName][$priority][] = $listener;
      unset($this->sorted[$eventName]);
   }

   /**
    * @see EventDispatcherInterface::removeListener
    */
   public function removeListener($eventName, $listener)
   {
      if (!isset($this->listeners[$eventName]))
      {
         return;
      }

      foreach ($this->listeners[$eventName] as $priority => $listeners)
      {
         if (false !== ($key = array_search($listener, $listeners)))
         {
            unset($this->listeners[$eventName][$priority][$key], $this->sorted[$eventName]);
         }
      }
   }

//IKKI     /**
//IKKI      * @see EventDispatcherInterface::addSubscriber
//IKKI      *
//IKKI      * @api
//IKKI      */
//IKKI     public function addSubscriber(EventSubscriberInterface $subscriber)
//IKKI     {
//IKKI         foreach ($subscriber->getSubscribedEvents() as $eventName => $params) {
//IKKI             if (is_string($params)) {
//IKKI                 $this->addListener($eventName, [$subscriber, $params));
//IKKI             } else {
//IKKI                 $this->addListener($eventName, [$subscriber, $params[0]), isset($params[1]) ? $params[1] : 0);
//IKKI             }
//IKKI         }
//IKKI     }
//IKKI
//IKKI     /**
//IKKI      * @see EventDispatcherInterface::removeSubscriber
//IKKI      */
//IKKI     public function removeSubscriber(EventSubscriberInterface $subscriber)
//IKKI     {
//IKKI         foreach ($subscriber->getSubscribedEvents() as $eventName => $params) {
//IKKI             $this->removeListener($eventName, [$subscriber, is_string($params) ? $params : $params[0]));
//IKKI         }
//IKKI     }


   /**
    * Sorts the internal list of listeners for the given event by priority.
    *
    * @param string $eventName The name of the event.
    */
   private function sortListeners($eventName)
   {
      $this->sorted[$eventName] = [];

      if (isset($this->listeners[$eventName]))
      {
         krsort($this->listeners[$eventName]);
         $this->sorted[$eventName] = call_user_func_array('array_merge', $this->listeners[$eventName]);
      }
   }

}