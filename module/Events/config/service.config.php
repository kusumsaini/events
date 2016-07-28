<?php

namespace Events;

use Events\Model\Event;
use Events\Model\EventsTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

return array (
        'factories' => array (
                'Events\Model\EventsTable' => function ($sm) {
                    $tableGateway = $sm->get ( 'EventsTableGateway' );
                    $table = new EventsTable ( $tableGateway );
                    return $table;
                },
                'EventsTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
                    $resultSetPrototype = new ResultSet ();
                    $resultSetPrototype->setArrayObjectPrototype ( new Event () );
                    return new TableGateway ( 'events', $dbAdapter, null, $resultSetPrototype );
                } 
        ) 
);