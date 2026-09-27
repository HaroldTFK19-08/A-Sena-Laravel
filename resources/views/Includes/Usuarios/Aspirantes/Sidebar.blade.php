@include('Includes.Usuarios.Sidebar', [
    'portalTitle' => 'ASPIRANTE',
    'portalSubtitle' => 'Portal de admisión',
    'theme' => [
        'surface' => '#301C25',
        'surface_end' => '#2E1A1E',
        'line' => 'rgba(247, 160, 165, .12)',
        'accent' => '#FFB0A5',
        'muted' => '#F8D7D3',
        'text' => '#F5DDDA',
        'status_label' => 'Estado',
        'status_text' => 'Proceso activo',
        'status_percent' => 66,
    ],
    'sections' => [
        [
            'label' => 'Principal',
            'open' => true,
            'items' => [
                ['label' => 'Inicio', 'route' => 'aspirante.home', 'icon' => 'M3 12.75 12 3l9 9.75M5 10.5V20h14v-9.5'],
            ],
        ],
        [
            'label' => 'Mi proceso',
            'open' => true,
            'items' => [
                ['label' => 'Ofertas', 'route' => 'aspirante.ofertas.index', 'active' => 'aspirante.ofertas.*', 'icon' => 'M4 5.5A2.5 2.5 0 0 1 6.5 3h11A2.5 2.5 0 0 1 20 5.5v13a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 4 18.5v-13zM8 8h8M8 12h5M8 16h3'],
                ['label' => 'Inscripciones', 'route' => 'aspirante.inscripciones.index', 'active' => 'aspirante.inscripciones.*', 'icon' => 'M7 7h10v10H7zM9 10h6M9 14h4'],
                ['label' => 'Resultados', 'route' => 'aspirante.resultados.index', 'active' => 'aspirante.resultados.*', 'icon' => 'M9 12l2 2 4-4m5 2a8 8 0 1 1-16 0 8 8 0 0 1 16 0z'],
            ],
        ],
        [
            'label' => 'Soporte',
            'items' => [
                ['label' => 'Mi perfil', 'route' => 'aspirante.perfil', 'icon' => 'M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0zm-8 9a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v1H8v-1z'],
                ['label' => 'Fechas', 'route' => 'aspirante.fechas', 'icon' => 'M12 6v6l4 2m4-8a10 10 0 1 1-20 0 10 10 0 0 1 20 0z'],
            ],
        ],
    ],
])
