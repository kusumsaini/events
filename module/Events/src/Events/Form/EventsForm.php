<?php
namespace Events\Form;

use Zend\Form\Form;

class EventsForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('events');

        $this->add(array(
                'name' => 'id',
                'type' => 'Hidden',
        ));
        $this->add(array(
                'name' => 'title',
                'type' => 'Text',
                'options' => array(
                        'label' => 'Title',
                ),
        ));
        $this->add(array(
                'name' => 'event_type',
                'type' => 'Text',
                'options' => array(
                        'label' => 'Event Type',
                ),
        ));
        $this->add(array(
                'name' => 'submit',
                'type' => 'Submit',
                'attributes' => array(
                        'value' => 'Go',
                        'id' => 'submitbutton',
                ),
        ));
    }
}