<?php

namespace Events\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Events\Model\Event; // <-- Add this import
use Events\Form\EventsForm;

class IndexController extends AbstractActionController {
    protected $eventsTable;
    public function indexAction() {
        return new ViewModel ( array (
                'events' => $this->getEventsTable ()->fetchAll () 
        ) );
    }
    public function addAction() {
        $form = new EventsForm ();
        $form->get ( 'submit' )->setValue ( 'Add' );
        
        $request = $this->getRequest ();
        if ($request->isPost ()) {
            $event = new Event ();
            $form->setInputFilter ( $event->getInputFilter () );
            $form->setData ( $request->getPost () );
            
            if ($form->isValid ()) {
                $event->exchangeArray ( $form->getData () );
                $this->getEventsTable ()->saveEvent ( $event );
                
                // Redirect to list of albums
                return $this->redirect ()->toRoute ( 'events' );
            }
        }
        return array (
                'form' => $form 
        );
    }
    public function editAction() {
        $id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
        if (! $id) {
            return $this->redirect ()->toRoute ( 'events', array (
                    'action' => 'add' 
            ) );
        }
        
        // Get the Album with the specified id. An exception is thrown
        // if it cannot be found, in which case go to the index page.
        try {
            $event = $this->getEventsTable ()->getEvent ( $id );
        } catch ( \Exception $ex ) {
            return $this->redirect ()->toRoute ( 'events', array (
                    'action' => 'index' 
            ) );
        }
        
        $form = new EventsForm ();
        $form->bind ( $event );
        $form->get ( 'submit' )->setAttribute ( 'value', 'Edit' );
        
        $request = $this->getRequest ();
        if ($request->isPost ()) {
            $form->setInputFilter ( $event->getInputFilter () );
            $form->setData ( $request->getPost () );
            
            if ($form->isValid ()) {
                $this->getEventsTable ()->saveEvent ( $event );
                
                // Redirect to list of albums
                return $this->redirect ()->toRoute ( 'events' );
            }
        }
        
        return array (
                'id' => $id,
                'form' => $form 
        );
    }
    public function deleteAction() {
        $id = ( int ) $this->params ()->fromRoute ( 'id', 0 );
        if (! $id) {
            return $this->redirect ()->toRoute ( 'events' );
        }
        
        $request = $this->getRequest ();
        if ($request->isPost ()) {
            $del = $request->getPost ( 'del', 'No' );
            
            if ($del == 'Yes') {
                $id = ( int ) $request->getPost ( 'id' );
                $this->getEventsTable ()->deleteEvent ( $id );
            }
            
            // Redirect to list of events
            return $this->redirect ()->toRoute ( 'events' );
        }        
        return array (
                'id' => $id,
                'event' => $this->getEventsTable ()->getEvent ( $id ) 
        );
    }
    public function getEventsTable() {
        if (! $this->eventsTable) {
            $sm = $this->getServiceLocator ();
            $this->eventsTable = $sm->get ( 'Events\Model\EventsTable' );
        }
        return $this->eventsTable;
    }
}