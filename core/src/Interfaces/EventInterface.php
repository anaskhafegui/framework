<?php 

namespace Core\Interfaces;

interface EventInterface
{
    /**
     * Register event to container
     *
     * @param string $eventName
     * @return void
     */
    public function register($eventName);

    /**
     * Subscribe to event
     *
     * @param string $eventName
     * @param string $listener
     * @return void
     */
    public function subscribe($eventName, $listener);

    /**
     * Dispatch event and update listeners with params
     *
     * @param string $eventName
     * @param mixed $params
     * @return void
     */
    public function dispatch($eventName, $params);


    /**
     * Check if this event valid to be dispatched
     *
     * @param string $eventName
     * @return boolean
     */
    public function isValidEvent($eventName): bool;
}