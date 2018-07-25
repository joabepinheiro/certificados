<?php
namespace Application;

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Participante',
                        'action' => 'emitir',
                        'module' => 'Application'
                    )
                )
            ),
            'emitir' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/emitir',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Participante',
                        'action' => 'emitir',
                        'module' => 'Application'
                    )
                )
            ),
            
            'cadastrar-atividades-por-planilha' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/cadastrar-atividades-por-planilha/:evento[/]',
                    'constraints' => array(
                        'evento' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Atividade',
                        'action' => 'cadastrar-por-planilha'
                    )
                )
            ),
            'eventos_do_participante' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/eventos-do-participante/:cpf/:data_nascimento',
                    'constraints' => array(
                        'cpf' => null,
                        'data_nascimento' => null
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Public',
                        'action' => 'eventos-do-participante'
                    )
                )
            ),

            'enviar_certificado' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/enviar-certificado[/:id[/:csrf]]',
                    'constraints' => array(
                        'id' => null,
                        'csrf' => null
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Public',
                        'action' => 'enviar-certificado'
                    )
                )
            ),

            'baixar-certificado' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/baixar-certificado[/:participacao[/:csrf]]',
                    'constraints' => array(
                        'participacao' => null,
                        'csrf' => null
                    ),
                    'defaults' => array(
                        'controller' => 'Application\Controller\Public',
                        'action' => 'baixar-certificado'
                    )
                )
            ),
            'esqueci-senha' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/esqueci-senha',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Auth',
                        'action' => 'esqueciSenha',
                        'module' => 'Application'
                    )
                )
            ),
            'login' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/login',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Auth',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ),
                            'defaults' => array()
                        )
                    )
                )
            ),
            'modelo-certificado' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/modelo-do-certificado',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'ModeloCertificado',
                        'action' => 'index',
                        'module' => 'Application'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action[/:id]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => null
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Application\Controller',
                                'controller' => 'ModeloCertificado'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action/[page/:page]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+'
                            )
                        )
                    )
                
                )
            ),
            'configurar-modelo-certificado' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/configurar-modelo-do-certificado',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'ConfigurarModeloCertificado',
                        'action' => 'index',
                        'module' => 'Application'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action[/:evento[/:id]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => null
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Application\Controller',
                                'controller' => 'ConfigurarModeloCertificado'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action/[page/:page]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+'
                            )
                        )
                    )

                )
            ),
            'certificado' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/certificado',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Certificado',
                        'action' => 'index',
                        'module' => 'Application'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action[/:participacao]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => null
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Application\Controller',
                                'controller' => 'Certificado'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action/[page/:page]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+'
                            )
                        )
                    )
                
                )
            ),
            'atividade' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/atividade',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Atividade',
                        'action' => 'index',
                        'module' => 'Application'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action[/:evento[/:id]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => null
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Application\Controller',
                                'controller' => 'Atividade'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action/[page/:page]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+'
                            )
                        )
                    )
                
                )
            ),
            'tipo-atividade' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/tipo-atividade',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'TipoAtividade',
                        'action' => 'index',
                        'module' => 'Application'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action[/:id[/:evento]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => null
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Application\Controller',
                                'controller' => 'TipoAtividade'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action/[page/:page]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+'
                            )
                        )
                    )
                )
            ),
            'evento' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/evento',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Evento',
                        'action' => 'index',
                        'module' => 'Application'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action[/:id]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => null,
                                'item' => null
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Application\Controller',
                                'controller' => 'Evento'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action/[page/:page]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+'
                            )
                        )
                    )
                
                )
            ),
            'publico' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/publico',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Public',
                        'action' => 'index',
                        'module' => 'Application'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action[/:id]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => null,
                                'item' => null
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Application\Controller',
                                'controller' => 'Public'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action/[page/:page]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+'
                            )
                        )
                    )
                
                )
            ),
            'funcao' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/funcao',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Funcao',
                        'action' => 'index',
                        'module' => 'Application'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action[/:id]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => null
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Application\Controller',
                                'controller' => 'Funcao'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action/[page/:page]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+'
                            )
                        )
                    )
                
                )
            ),
            'participacao' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/participacao',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Participacao',
                        'action' => 'index',
                        'module' => 'Application'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action[/:evento[/:id]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => null,
                                'evento' => null
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Application\Controller',
                                'controller' => 'Participacao'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action/[page/:page]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+'
                            )
                        )
                    )
                
                )
            ),
            'usuario' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/usuario',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Usuario',
                        'action' => 'index',
                        'module' => 'Application'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action[/:id]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => null
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Application\Controller',
                                'controller' => 'Usuario'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action/[page/:page]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+'
                            )
                        )
                    )
                
                )
            ),
            'instituto' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/instituto',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Instituto',
                        'action' => 'index',
                        'module' => 'Application'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action[/:id]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => null
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Application\Controller',
                                'controller' => 'Instituto'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action/[page/:page]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+'
                            )
                        )
                    )
                
                )
            ),
            'administrador' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/administrador',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Administrador',
                        'action' => 'dashboard',
                        'module' => 'Application'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action[/:id]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => null
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Application\Controller',
                                'controller' => 'Administrador'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action/[page/:page]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+'
                            )
                        )
                    )
                
                )
            ),
            'coordenador' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/coordenador',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Coordenador',
                        'action' => 'dashboard',
                        'module' => 'Application'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action[/:id]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => null
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Application\Controller',
                                'controller' => 'Coordenador'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action/[page/:page]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+'
                            )
                        )
                    )
                
                )
            ),
            'participante' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/participante',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Participante',
                        'action' => 'index',
                        'module' => 'Application'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action[/:id/[:situacoes/[:turma_id]]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => null,
                                'situacoes' => null,
                                'turma_id' => null
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Application\Controller',
                                'controller' => 'Participante'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action/[page/:page]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+'
                            )
                        )
                    )
                
                )
            ),
            'turma' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/turma',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Turma',
                        'action' => 'index',
                        'module' => 'Application'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action[/:id/]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => null,
                                'situacoes' => null
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Application\Controller',
                                'controller' => 'Turma'
                            )
                        )
                    ),
                    'paginator' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:action/[page/:page]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page' => '\d+'
                            )
                        )
                    )
                
                )
            ),
            'logout' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/logout',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Auth',
                        'action' => 'logout',
                        'module' => 'Application'
                    )
                )
            ),
            'validar' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/validar',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Certificado',
                        'action' => 'validar',
                        'module' => 'Application'
                    )
                )
            ),
            'negado' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/acesso-negado',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Index',
                        'action' => 'negado',
                        'module' => 'Application'
                    )
                )
            )
        )
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory'
        ),
        'factories' => array(
            'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory'
        )
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo'
            )
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Administrador'  => Controller\AdministradorController::class,
            'Application\Controller\Coordenador'    => Controller\CoordenadorController::class,
            'Application\Controller\Atividade'      => Controller\AtividadeController::class,
            'Application\Controller\Evento'         => Controller\EventoController::class,
            'Application\Controller\Funcao'         => Controller\FuncaoController::class,
            'Application\Controller\Index'          => Controller\IndexController::class,
            'Application\Controller\Instituto'      => Controller\InstitutoController::class,
            'Application\Controller\Participacao'   => Controller\ParticipacaoController::class,
            'Application\Controller\Participante'   => Controller\ParticipanteController::class,
            'Application\Controller\Usuario'        => Controller\UsuarioController::class,
            'Application\Controller\Auth'           => Controller\AuthController::class,
            'Application\Controller\Public'             => Controller\PublicController::class,
            'Application\Controller\ModeloCertificado'  => Controller\ModeloCertificadoController::class,
            'Application\Controller\Certificado'        => Controller\CertificadoController::class,
            'Application\Controller\TipoAtividade'      => Controller\TipoAtividadeController::class,
            'Application\Controller\ConfigurarModeloCertificado'      => Controller\ConfigurarModeloCertificadoController::class

        )

    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'layout/documentacao' => __DIR__ . '/../view/layout/layout-documentacao.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
            'partial/sidebar' => __DIR__ . '/../view/partial/sidebar.phtml',
            'partial/administrador/sidebar' => __DIR__ . '/../view/partial/administrador/sidebar.phtml',
            'partial/participante/sidebar' => __DIR__ . '/../view/partial/participante/sidebar.phtml',
            'certificado/preview' => __DIR__ . '/../view/application/certificado/preview.phtml',
            'certificado/download' => __DIR__ . '/../view/application/certificado/download.phtml',
            'evento/table/detalhes' => __DIR__ . '/../view/partial/evento/table-detalhes.phtml',
            'evento/menu/superior' => __DIR__ . '/../view/partial/evento/menu-superior.phtml',
            'modelo/tabela_tags_certificado' => __DIR__ . '/../view/partial/modelo/tabela_tags_certificado.phtml'
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view'
        ),
        'strategies' => array(
            'ViewJsonStrategy'
        )
    ),
    'console' => array(
        'router' => array(
            'routes' => array()
        )
    ),
    'view_helper_config' => array(
        'flashmessenger' => array(
            'message_open_format' => '<div %s ><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>	<i class="icon fa fa-check"></i>',
            'message_separator_string' => '<p></p>',
            'message_close_string' => '</div>'
        )
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
                )
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    )

);
