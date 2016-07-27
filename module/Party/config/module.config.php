<?php

namespace Party;

return array(
		'controllers' => array(
				'invokables' => array(
						'Party\Controller\Index' => 'Party\Controller\IndexController'
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
						'party' => array(
								'type'    => 'Literal',
								'options' => array(
										'route'    => '/party',
										'defaults' => array(
												'__NAMESPACE__' => 'Party\Controller',
												'controller'    => 'Index',
												'action'        => 'index',
										),
								),
								'may_terminate' => true,
								'child_routes' => array(
										'default' => array(
												'type'    => 'Segment',
												'options' => array(
														'route'    => '/[:controller[/:action]]',
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