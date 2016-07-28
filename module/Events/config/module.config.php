<?php

namespace Events;

return array(
		'controllers' => array(
				'invokables' => array(
						'Events\Controller\Events' => 'Events\Controller\EventsController'
				),
		),
		'view_manager' => array(
				'template_path_stack' => array(
						__DIR__ . '/../view',
				),
		),
		'router' => array(
				'routes' => array(
						// The following is a route to simplify getting started creating
						// new controllers and actions without needing to create a new
						// module. Simply drop new controllers in, and you can access them
						// using the path /application/:controller/:action
						'events' => array(
								'type'    => 'Literal',
								'options' => array(
										'route'    => '/events',
										'defaults' => array(
												'__NAMESPACE__' => 'Events\Controller',
												'controller'    => 'Events',
												'action'        => 'index',
										),
								),
								'may_terminate' => true,
								'child_routes' => array(
										'default' => array(
												'type'    => 'Segment',
												'options' => array(
														'route'    => '/[:controller[/:action][/:id]]',
														'constraints' => array(
																'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
																'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
														),
														'defaults' => array(
														        
														),
												),
										),
								),
						),
				),
		),
);