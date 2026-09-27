@include('Includes.Usuarios.Sidebar', [
    'portalTitle' => 'ADMIN',
    'portalSubtitle' => 'Portal institucional',
    'theme' => [
        'surface' => '#08283B',
        'surface_end' => '#041A2A',
        'line' => 'rgba(255, 255, 255, .08)',
        'accent' => '#8AFD5D',
        'muted' => '#94A3B8',
        'text' => '#CBD5E1',
        'status_label' => 'Estado del sistema',
        'status_text' => 'Sistema operativo',
        'status_percent' => 100,
    ],
    'sections' => [
        [
            'label' => 'Principal',
            'open' => true,
            'items' => [
                ['label' => 'Inicio', 'route' => 'admin.home', 'icon' => 'M3 12.75 12 3l9 9.75M5 10.5V20h14v-9.5'],
            ],
        ],
        [
            'label' => 'Gestión',
            'open' => true,
            'items' => [
                ['label' => 'Centros', 'route' => 'centros.index', 'icon' => 'M4 20h16M5 20V8.5L12 4l7 4.5V20M9 20v-5h6v5M8 10h.01M12 10h.01M16 10h.01'],
                ['label' => 'Áreas', 'route' => 'areas.index', 'icon' => 'M4 19h16M6 16V8m6 8V5m6 11v-4'],
                ['label' => 'Ambientes', 'route' => 'ambientes.index', 'icon' => 'M4 19V7l8-4 8 4v12M4 19h16M8 11h2m4 0h2M8 15h2m4 0h2'],
                ['label' => 'Equipos', 'route' => 'equipos.index', 'icon' => 'M5 7h14M5 12h14M5 17h14M8 7v.01M8 12v.01M8 17v.01'],
                ['label' => 'Asignaciones', 'route' => 'admin.asignaciones.index', 'icon' => 'M9 12h6m-6 4h6M7 7h10a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2z'],
                ['label' => 'Programas', 'route' => 'programas.index', 'icon' => 'M4 6.5A2.5 2.5 0 0 1 6.5 4h11A2.5 2.5 0 0 1 20 6.5v11a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 4 17.5v-11zM8 8h8M8 12h8M8 16h5'],

                ['label' => 'Competencias', 'route' => 'competencias.index', 'active' => 'competencias.*', 'icon' => 'M9 12l2 2 4-4m5 2a8 8 0 1 1-16 0 8 8 0 0 1 16 0z'],

                ['label' => 'Fichas', 'route' => 'fichas.index', 'icon' => 'M4 20h16M5 20V8.5L12 4l7 4.5V20M9 20v-5h6v5M8 10h.01M12 10h.01M16 10h.01'],
                ['label' => 'Noticias', 'route' => 'noticias.index', 'active' => 'noticias.*', 'icon' => 'M4 5.5A2.5 2.5 0 0 1 6.5 3h11A2.5 2.5 0 0 1 20 5.5v13a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 4 18.5v-13zM8 8h8M8 12h6M8 16h4'],
                ['label' => 'Ofertas', 'route' => 'ofertas.index', 'active' => 'ofertas.*', 'icon' => 'M4 5.5A2.5 2.5 0 0 1 6.5 3h11A2.5 2.5 0 0 1 20 5.5v13a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 4 18.5v-13zM8 8h8M8 12h5M8 16h3'],
                ['label' => 'Inscripciones', 'route' => 'inscripciones.index', 'active' => 'inscripciones.*', 'icon' => 'M7 7h10v10H7zM9 10h6M9 14h4'],
                ['label' => 'Resultados', 'route' => 'resultados.index', 'active' => 'resultados.*', 'icon' => 'M9 12l2 2 4-4m5 2a8 8 0 1 1-16 0 8 8 0 0 1 16 0z'],
            ],
        ],
        [
            'label' => 'Administración',
            'open' => true,
            'items' => [
                ['label' => 'Usuarios', 'route' => 'admin.usuarios', 'active' => 'usuarios.*', 'icon' => 'M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0zm-8 9a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v1H8v-1z'],
            ],
        ],
    ],
])