<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => 'Plataforma de Controle',

    'title_prefix' => '',

    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => '<b>CONTROLE </b>NET/SES-PE',

    'logo_mini' => '<b>P</b>SES',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'red',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => 'top-nav',

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => 'admin',

    'logout_url' => 'logout',

    'logout_method' => null,

    'login_url' => 'login',

    'register_url' => 'register',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */

    'menu' => [
        //'MENU'
        [
            'text'        => 'Cadastro CES/PE',
            'url'         => '/admin/ces/cadastro',
            'can'         => 'ces',
        ],
 	[
            'text'        => 'Testar Google', 
            'url'         => '/google',
            'can'         => 'pri',
        ],

        [
            'text'        => 'Lista Usuários por Geres',
            'url'         => '/admin/pri/usuario/geres',
            'can'         => 'pri',
        ],

        [
            'text'        => 'Lista de todos Usuários',
            'url'         => '/admin/pri/usuario',
            'can'         => 'pri',
        ],
        
        [ //Importar Smart
            'text'        => 'PRI',
            'url'         => '/admin/pri/usuario',
            'icon'        => 'fas fa-camera',
            'can'         => 'administrador',
            'submenu'  =>  [
            [
                'text'        => 'Criar Salas',
                'url'         => '/admin/pri/sala',
                'icon'        => 'fas fa-hospital-o'
            ],
            [
                'text'        => 'Exportar-Registros PRI',
                'url'         => '/admin/exp_prireg',
                'icon'        => 'far fa-file'
            ],
            [
                'text'        => 'Exportar-PRI',
                'url'         => '/admin/export_pri',
                'icon'        => 'far fa-file'
            ],
            

        ] //Submenu Importar
    ],
        
        [
            'text'        => 'Editar Usuários',
            'url'         => '/admin/lista',
            'icon'        => 'far fa-address-book',
            'can'         => 'administrador',
        ],
        [
            'text'        => 'Editar Perfil',
            'url'         => '/admin/perfil',
            'icon'        => 'far fa-address-book',
            'can'         => 'administrador',
        ],
        [
            'text'        => 'Matriz Projetos',
            'url'         => '/admin/p_proj',
            'icon'        => 'credit-card-alt',   
            ['can'         => 'administrador'] || ['can' => 'coordenador'],
        ],
        [
            'text'        => 'Matriz Tarefas',
            'url'         => '/admin/m_task',
            'icon'        => 'credit-card-alt', 
            ['can'         => 'administrador'] || ['can' => 'coordenador'],             
        ],
        [
            'text'        => 'Status-Diario',
            'url'         => '/admin/status_diario',
            'icon'        => 'history',
            ['can'         => 'administrador'] || ['can' => 'coordenador'], 
        ],
        [
            'text'        => 'Status-Tarefas',
            'url'         => '/admin/status_task',
            'icon'        => 'history',
            ['can'         => 'administrador'] || ['can' => 'coordenador'], 
        ],
                             //Submenu Plataforma
         //Plataforma
	[
         'text'        => 'Projetos',
         'url'         => '/admin/task',
         'icon'        => 'fas fa-camera',
         ['can'         => 'administrador'] || ['can' => 'coordenador'],
            'submenu'  =>  [
            [
                'text'        => 'Diário',
                'url'         => '/admin/diario',
                'icon'        => 'credit-card-alt',              
            ],
	            [
                    'text'        => 'Projetos & Tarefas',
                    'url'         => '/admin/task',
                    'icon'        => 'credit-card-alt',
                ],
                [
                    'text'        => 'Copiar Projeto',
                    'url'         => '/admin/proj/cpproj',
                    'icon'        => 'credit-card-alt',
                ],
                [
                    'text'        => 'Status-Projetos',
                    'url'         => '/admin/status_proj',
                    'icon'        => 'dashboard'
                ],
                [
                    'text'        => 'Status-Diario',
                    'url'         => '/admin/status_diario',
                    'icon'        => 'history'
                ],
                [
                    'text'        => 'Status-Tarefas',
                    'url'         => '/admin/status_task',
                    'icon'        => 'history'
                ],
                [
                    'text'        => 'Agenda',
                    'url'         => '/admin/proj/agenda',
                ],
                [
                    'text'        => 'Gantt Google',
                    'url'         => 'admin/proj/ganttchart',
                    'icon'        => 'fa fa-fw fa-sign-in',
                ],
                [
                    'text'        => 'Gantt Mano',
                    'url'         => 'admin/proj/ganttmano',
                    'icon'        => 'fa fa-fw fa-sign-in',
                ],
                            ] //Submenu Projetos
        ], //Projetos
            [
            'text'        => 'Projetos Admin',
            'url'         => '/admin/task',
            'icon'        => 'fas fa-camera',
            'can'         => 'administrador',

            'submenu'  =>  [
                [
                    'text'        => 'Dependencias das Tarefas',
                    'url'         => '/admin/dep_task',
                    'icon'        => 'history'
                ],
                [
                    'text'        => 'Gantt',
                    'url'         => '/admin/gantt',
                    'icon'        => 'history'
                ],
                [
                    'text'        => 'Status-Tarefas',
                    'url'         => '/admin/status_task',
                    'icon'        => 'history'
                ],
                [
                    'text'        => 'Exportar-Projetos',
                    'url'         => '/admin/export_proj',
                    'icon'        => 'far fa-file'
                ],
                [
                    'text'        => 'Exportar-Tarefas',
                    'url'         => '/admin/export_task',
                    'icon'        => 'history'
                ],
                [
                    'text'        => 'Exportar-Dependencias',
                    'url'         => '/admin/export_dep',
                    'icon'        => 'history'
                ],
                [
                    'text'        => 'Trocar Senha',
                    'url'         => '/admin/trocar/senha',
                    'icon'        => 'key',
                    'can'         => 'administrador',
                ],
                            ] //Submenu Projetos
        ], //Projetos
        [
                'text'        => 'Importar',
                'url'         => '',
                'icon'        => 'fas fa-camera',
                'can'         => 'administrador',
                'submenu'  =>  [
                [
                    'text'        => 'Anexar arquivo Tarefas',
                    'url'         => '/admin/tarefas',
                    'icon'        => 'far fa-save'
                ],
                [
                    'text'        => 'Importar-Tarefas',
                    'url'         => '/admin/gettask',
                    'icon'        => 'history'
                ],
                [
                    'text'        => 'Anexar arquivo Projetos',
                    'url'         => '/admin/projetos',
                    'icon'        => 'far fa-save'
                ],
                [
                    'text'        => 'Importar-projetos',
                    'url'         => '/admin/getproj',
                    'icon'        => 'history'
                ],
                                    ] //Submenu Importar
        ], //Importar
        [ //Importar Smart
            'text'        => 'Importar Smart',
            'url'         => '',
            'icon'        => 'fas fa-camera',
            'can'         => 'administrador',
            'submenu'  =>  [
            [
                'text'        => 'Importar Estabelecimento',
                'url'         => '/admin/smart/import/estabelecimentos',
                'icon'        => 'fas fa-hospital-o'
            ],
            [
                'text'        => 'Importar Profissionais',
                'url'         => '/admin/smart/import/profissionais',
                'icon'        => 'fas fa-user'
            ],
            [
                'text'        => 'Importar Objeto',
                'url'         => '/admin/smart/import/objetos',
                'icon'        => 'fas fa-book'
            ],
            [
                'text'        => 'Importar Atividade',
                'url'         => '/admin/smart/import/atividade',
                'icon'        => 'fas fa-file-pdf-o'
            ],
            [
                'text'        => 'Importar Curso',
                'url'         => '/admin/smart/import/curso',
                'icon'        => 'fas fa-television'
            ],
            [
                'text'        => 'Importar Teleducacao Atividde',
                'url'         => '/admin/smart/import/teleducacao',
                'icon'        => 'fas fa-window-maximize'
            ],

        ] //Submenu Importar
    ],

            [ //Importar Smart
                'text'        => 'Importar Moodle Smart',
                'url'         => '',
                'icon'        => 'fas fa-camera',
                'can'         => 'administrador',
                'submenu'  =>  [
                [
                    'text'        => 'Importar Estabelecimento',
                    'url'         => '/admin/smart/import/moodle',
                    'icon'        => 'fas fa-hospital-o'
                ],
                

            ] //Submenu Importar
        ],

	 [
            'text'        => 'Smart - Enviar',
            'url'         => '',
            'icon'        => 'fas fa-camera',
            'can'         => 'administrador',
            
            'submenu'  =>  [
                [
                    'text'        => 'Enviar Profissional',
                    'url'         => '/admin/smart/profissional',
                    'icon'        => 'fas fa-paper-plane'
                ],
                [
                    'text'        => 'Enviar Estabelecimento',
                    'url'         => '/admin/smart/estabelecimento',
                    'icon'        => 'fas fa-paper-plane'
                ],
                [
                    'text'        => 'Enviar Teleeducacao',
                    'url'         => '/admin/smart/atividade',
                    'icon'        => 'fas fa-paper-plane'
                ],
                [
                    'text'        => 'Enviar Curso',
                    'url'         => '/admin/smart/curso',
                    'icon'        => 'fas fa-paper-plane'
                ],
                [
                    'text'        => 'Enviar ObjetoAprendizagem',
                    'url'         => '/admin/smart/objeto',
                    'icon'        => 'fas fa-paper-plane'
                ],
                [
                    'text'        => 'Enviar Teleconsultoria',
                    'url'         => '/admin/smart/teleconsultoria',
                    'icon'        => 'fas fa-paper-plane'
                ],
                [
                    'text'        => 'Enviar Telediagnostico',
                    'url'         => '/admin/smart/telediagnostico',
                    'icon'        => 'fas fa-paper-plane'

                ]
            ] //Submenu Smart
        ], //Smart   
        [
            'text'        => 'Smart - Editar',
            'url'         => '',
            'icon'        => 'fas fa-camera',
            'can'         => 'administrador',
            
            'submenu'  =>  [
                [
                    'text'        => 'Profissional',
                    'url'         => '/admin/smart/e-profissional',
                    'icon'        => 'far fa-save'
                ],
                [
                    'text'        => 'Estabelecimento',
                    'url'         => '/admin/smart/e-estabelecimento',
                    'icon'        => 'far fa-save'
                ],
                [
                    'text'        => 'Teleeducacao',
                    'url'         => '/admin/smart/eatividade',
                    'icon'        => 'far fa-save'
                ],
                [
                    'text'        => 'Curso',
                    'url'         => '/admin/smart/e-curso',
                    'icon'        => 'far fa-save'
                ],
                [
                    'text'        => 'ObjetoAprendizagem',
                    'url'         => '/admin/smart/e-objeto',
                    'icon'        => 'far fa-save'
                ],
                [
                    'text'        => 'Teleconsultoria',
                    'url'         => '/admin/smart/e-teleconsultoria',
                    'icon'        => 'far fa-save'
                ],
                [
                    'text'        => 'Telediagnostico',
                    'url'         => '/admin/smart/e-telediagnostico',
                    'icon'        => 'far fa-save'
                ]
            ] //Submenu Smart

            
        ], //Smart   
        [
        'text'        => 'Administração',
            'url'         => '',
            'icon'        => 'envelope',
            'can'         => 'administrador',
            'submenu'  =>  [
            [
            'text'        => 'Exportar Consultorias',
            'url'         => '',
            'icon'        => 'envelope',
            'can'         => 'administrador',
            'submenu'  =>  [
                [
                    'text'        => 'Exportar Dados',
                    'url'         => 'admin/export_excel',
                    'icon'        => 'credit-card-alt'
                ],
                [
                    'text'        => 'Copiar Arquivo',
                    'url'         => 'admin/getindex',
                    'icon'        => 'history'
                ],
            ] //Submenu Exportar Consultorias
            ], //Exportar Consultorias
            [
            'text'        => 'Exportar Usuários',
            'url'         => '',
            'icon'        => 'envelope',
            'can'         => 'administrador',
            'submenu'  =>  [
                [
                    'text'        => 'Exportar Dados ',
                    'url'         => 'admin/export_users',
                    'icon'        => 'credit-card-alt'
                ],
                [
                    'text'        => 'Copiar Arquivo',
                    'url'         => 'admin/getindex',
                    'icon'        => 'history'
                ],
                            ] //Submenu Exportar Usuários
            ],  //Exportar Usuarios
            [
           'text' => 'Importar Cadastros',
           'icon' => 'dashboard',
           'can'         => 'administrador',
           'submenu'  =>  [
                [
                    'text'        => 'Selecionar Arquivos',
                    'url'         => '/admin/usuarios',
                    'icon'        => 'credit-card-alt'
                ],
                [
                    'text'        => 'Importar Arquivo',
                    'url'         => 'admin/getindex',
                    'icon'        => 'history'
                ],
                            ] //Submenu Importar Cadastros
            ], // Importar Cadastros 
                            ] //Submenu Administração
            ], //Administração
        ], // Menu 
        
        
    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Choose which JavaScript plugins should be included. At this moment,
    | only DataTables is supported as a plugin. Set the value to true
    | to include the JavaScript file from a CDN via a script tag.
    |
    */

    'plugins' => [
        'datatables' => true,
        'select2'    => true,
        'chartjs'    => true,
    ],
];