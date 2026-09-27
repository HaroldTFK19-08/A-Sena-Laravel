@include('Includes.Usuarios.Sidebar', [
    'portalTitle' => 'APRENDIZ',
    'portalSubtitle' => 'Portal formativo',
    'theme' => [
        'surface' => '#062E2D',
        'surface_end' => '#0A2D2D',
        'line' => 'rgba(122, 229, 181, .12)',
        'accent' => '#8AFD5D',
        'muted' => '#B9DCCB',
        'text' => '#C3E6D1',
        'status_label' => 'Avance',
        'status_text' => 'Proceso en curso',
        'status_percent' => 75,
    ],
    'sections' => [
        [
            'label' => 'Principal',
            'open' => true,
            'items' => [
                ['label' => 'Inicio', 'route' => 'aprendiz.home', 'icon' => 'M3 12.75 12 3l9 9.75M5 10.5V20h14v-9.5'],
            ],
        ],
        [
            'label' => 'Mi proceso',
            'open' => true,
            'items' => [
                ['label' => 'Mi ficha', 'route' => 'aprendiz.ficha', 'icon' => 'M4 20h16M5 20V8.5L12 4l7 4.5V20M9 20v-5h6v5M8 10h.01M12 10h.01M16 10h.01'],
                ['label' => 'Asignaciones', 'route' => 'aprendiz.asignaciones.index', 'active' => 'aprendiz.asignaciones.*', 'icon' => 'M9 12h6m-6 4h6M7 7h10a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2z'],
                ['label' => 'Resultados', 'route' => 'aprendiz.resultados.index', 'active' => 'aprendiz.resultados.*', 'icon' => 'M5 12.5 8 15.5 19 1.5m0 11-3 3-7-7'],
            ],
        ],
        [
            'label' => 'Perfil',
            'items' => [
                ['label' => 'Mi información', 'route' => 'aprendiz.perfil', 'icon' => 'M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0zm-8 9a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v1H8v-1z'],
                ['label' => 'Cronograma', 'route' => 'aprendiz.cronograma', 'icon' => 'M12 6v6l4 2m4-8a10 10 0 1 1-20 0 10 10 0 0 1 20 0z'],
            ],
        ],
    ],
])
