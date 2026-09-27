@include('Includes.Usuarios.Sidebar', [
    'portalTitle' => 'INSTRUCTOR',
    'portalSubtitle' => 'Portal docente',
    'theme' => [
        'surface' => '#111B3D',
        'surface_end' => '#101C3E',
        'line' => 'rgba(127, 167, 255, .12)',
        'accent' => '#8FB4FF',
        'muted' => '#CADAFD',
        'text' => '#D5E0FF',
        'status_label' => 'Estado',
        'status_text' => 'Docencia activa',
        'status_percent' => 80,
    ],
    'sections' => [
        [
            'label' => 'Principal',
            'open' => true,
            'items' => [
                ['label' => 'Inicio', 'route' => 'instructor.home', 'icon' => 'M3 12.75 12 3l9 9.75M5 10.5V20h14v-9.5'],
            ],
        ],
        [
            'label' => 'Gestión',
            'open' => true,
            'items' => [
                ['label' => 'Aprendices', 'route' => 'instructor.aprendices', 'icon' => 'M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0zm-8 9a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v1H8v-1z'],
                ['label' => 'Asignaciones', 'route' => 'instructor.asignaciones.index', 'active' => 'instructor.asignaciones.*', 'icon' => 'M9 12h6m-6 4h6M7 7h10a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2z'],
                ['label' => 'Fichas', 'route' => 'instructor.fichas', 'active' => 'instructor.fichas*', 'icon' => 'M4 20h16M5 20V8.5L12 4l7 4.5V20M9 20v-5h6v5M8 10h.01M12 10h.01M16 10h.01'],
                ['label' => 'Resultados', 'route' => 'instructor.resultados.index', 'active' => 'instructor.resultados.*', 'icon' => 'M4 19V5m0 14h16M8 16v-5m4 5V8m4 8v-9'],
            ],
        ],
        [
            'label' => 'Docencia',
            'items' => [
                ['label' => 'Actividades', 'route' => 'instructor.actividades', 'icon' => 'M9 12h6m-6 4h6M7 7h10a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2z'],
                ['label' => 'Agenda', 'route' => 'instructor.agenda', 'icon' => 'M12 6v6l4 2m4-8a10 10 0 1 1-20 0 10 10 0 0 1 20 0z'],
            ],
        ],
    ],
])
