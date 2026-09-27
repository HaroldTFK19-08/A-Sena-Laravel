<?php

namespace Tests\Feature;

use App\Dominios\Noticias\Models\News;
use App\Dominios\Ofertas\Models\Offer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_catalogs_only_show_published_content(): void
    {
        $noticiaPublicada = News::factory()->publicada()->create([
            'titulo' => 'Noticia institucional publicada',
        ]);
        $noticiaPrivada = News::factory()->borrador()->create([
            'titulo' => 'Noticia que no debe ser pública',
        ]);

        $ofertaPublicada = Offer::factory()->publicada()->create();
        $ofertaPrivada = Offer::factory()->create(['publicada' => false]);

        $this->get(route('auth.noticias'))
            ->assertOk()
            ->assertSee($noticiaPublicada->titulo)
            ->assertDontSee($noticiaPrivada->titulo);

        $this->get(route('auth.ofertas'))
            ->assertOk()
            ->assertSee($ofertaPublicada->program->nombre)
            ->assertDontSee($ofertaPrivada->program->nombre);
    }

    public function test_public_catalog_search_finds_an_offer_by_program_name_and_code(): void
    {
        $oferta = Offer::factory()->publicada()->create();
        $otraOferta = Offer::factory()->publicada()->create();

        $this->get(route('auth.ofertas.buscar', [
            'buscar' => $oferta->program->nombre,
        ]))
            ->assertOk()
            ->assertSee($oferta->program->nombre)
            ->assertDontSee($otraOferta->program->nombre);

        $this->get(route('auth.ofertas.buscar', [
            'buscar' => $oferta->program->codigo_programa,
        ]))
            ->assertOk()
            ->assertSee($oferta->program->nombre)
            ->assertDontSee($otraOferta->program->nombre);
    }

    public function test_public_show_routes_are_available_only_for_published_content(): void
    {
        $noticia = News::factory()->publicada()->create([
            'titulo' => 'Detalle de noticia pública',
            'descripcion' => 'Contenido completo de la noticia.',
        ]);
        $oferta = Offer::factory()->publicada()->create();

        $this->get(route('auth.noticias.show', $noticia))
            ->assertOk()
            ->assertSee($noticia->titulo)
            ->assertSee($noticia->descripcion);

        $this->get(route('auth.ofertas.show', $oferta))
            ->assertOk()
            ->assertSee($oferta->program->nombre)
            ->assertSee('Cronograma de la convocatoria');

        $this->get(route('auth.noticias.show', News::factory()->borrador()->create()))
            ->assertNotFound();
        $this->get(route('auth.ofertas.show', Offer::factory()->create(['publicada' => false])))
            ->assertNotFound();
    }

    public function test_public_home_card_links_to_each_show_page(): void
    {
        $noticia = News::factory()->publicada()->create();
        $oferta = Offer::factory()->publicada()->create();

        $this->get(route('auth.inicio'))
            ->assertOk()
            ->assertSee(route('auth.noticias.show', $noticia), false)
            ->assertSee(route('auth.ofertas.show', $oferta), false);
    }
}
