<?php

namespace EventsTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class EvengtsControllerTest extends AbstractHttpControllerTestCase {
    protected $traceError = true;
    public function setUp() {
        $this->setApplicationConfig ( include '/var/www/events/config/application.config.php' );
        parent::setUp ();
    }
    public function testEventsActionCanBeAccessed() {
        $eventsTableMock = $this->getMockBuilder ( 'Events\Model\EventsTable' )->disableOriginalConstructor ()->getMock ();
        
        $eventsTableMock->expects ( $this->once () )->method ( 'fetchAll' )->will ( $this->returnValue ( array () ) );
        
        $serviceManager = $this->getApplicationServiceLocator ();
        $serviceManager->setAllowOverride ( true );
        $serviceManager->setService ( 'Events\Model\EventsTable', $eventsTableMock );
        
        $this->dispatch ( '/events' );
        $this->assertResponseStatusCode ( 200 );
        
        $this->assertModuleName ( 'Events' );
        $this->assertControllerName ( 'Events\Controller\Events' );
        $this->assertControllerClass ( 'EventsController' );
        $this->assertMatchedRouteName ( 'events' );
    }
    public function testAddActionRedirectsAfterValidPost()
    {
        $eventsTableMock = $this->getMockBuilder('Events\Model\EventsTable')
        ->disableOriginalConstructor()
        ->getMock();
    
        $eventsTableMock->expects($this->once())
        ->method('saveEvent')
        ->will($this->returnValue(null));
    
        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('Events\Model\EventsTable', $eventsTableMock);
    
        $postData = array(
                'title'  => 'Led Zeppelin III',
                'event_type' => 'Led Zeppelin',
                'id'     => '',
        );
        $this->dispatch('/events/events/add', 'POST', $postData);
        $this->assertResponseStatusCode(302);
    
        $this->assertRedirectTo('/events');
    }
}