from __future__ import annotations

import re
from pathlib import Path
from xml.sax.saxutils import escape

from reportlab.lib import colors
from reportlab.lib.colors import HexColor
from reportlab.lib.enums import TA_CENTER, TA_LEFT, TA_RIGHT
from reportlab.lib.pagesizes import landscape
from reportlab.lib.styles import ParagraphStyle, getSampleStyleSheet
from reportlab.lib.units import inch
from reportlab.pdfbase import pdfmetrics
from reportlab.pdfbase.ttfonts import TTFont
from reportlab.platypus import (
    BaseDocTemplate,
    Flowable,
    Frame,
    HRFlowable,
    KeepTogether,
    PageBreak,
    NextPageTemplate,
    PageTemplate,
    Paragraph,
    Spacer,
    Table,
    TableStyle,
)

ROOT = Path(__file__).resolve().parents[1]
OUTPUT = ROOT / "docs" / "AdminSena-explicacion-tecnica.pdf"

# Presentation-friendly 16:9 page. It is intentionally not the default A4
# because this artifact is intended to be presented on a screen.
PAGE_WIDTH = 13.333 * inch
PAGE_HEIGHT = 7.5 * inch
LEFT = 0.55 * inch
RIGHT = 0.55 * inch
TOP = 0.62 * inch
BOTTOM = 0.48 * inch

NAVY = HexColor("#0A2334")
DEEP = HexColor("#102A43")
GREEN = HexColor("#39A900")
MINT = HexColor("#8AFD5D")
TEAL = HexColor("#0E6B54")
BLUE = HexColor("#1E5B8A")
PALE_GREEN = HexColor("#EAF6F4")
PALE_BLUE = HexColor("#EEF5FA")
PALE_ORANGE = HexColor("#FFF4E5")
PALE_RED = HexColor("#FDECEC")
INK = HexColor("#173042")
MUTED = HexColor("#5F7785")
LINE = HexColor("#D7E3E8")
PAPER = HexColor("#F7FBFC")
WHITE = colors.white

FONT_DIR = Path("/System/Library/Fonts/Supplemental")
pdfmetrics.registerFont(TTFont("AdminSans", str(FONT_DIR / "Arial Unicode.ttf")))
pdfmetrics.registerFont(TTFont("AdminSansBold", str(FONT_DIR / "Arial Bold.ttf")))
pdfmetrics.registerFont(TTFont("AdminSansItalic", str(FONT_DIR / "Arial Italic.ttf")))
pdfmetrics.registerFont(TTFont("AdminMono", str(FONT_DIR / "Arial.ttf")))

styles = getSampleStyleSheet()
styles.add(ParagraphStyle(
    name="CoverKicker", fontName="AdminSansBold", fontSize=11, leading=14,
    textColor=GREEN, tracking=1.2, spaceAfter=14,
))
styles.add(ParagraphStyle(
    name="CoverTitle", fontName="AdminSansBold", fontSize=36, leading=42,
    textColor=WHITE, spaceAfter=12,
))
styles.add(ParagraphStyle(
    name="CoverSubtitle", fontName="AdminSans", fontSize=15, leading=21,
    textColor=HexColor("#D7E7EC"), spaceAfter=18,
))
styles.add(ParagraphStyle(
    name="CoverMeta", fontName="AdminSans", fontSize=9, leading=13,
    textColor=HexColor("#AFC7D0"),
))
styles.add(ParagraphStyle(
    name="Section", fontName="AdminSansBold", fontSize=23, leading=28,
    textColor=NAVY, spaceBefore=2, spaceAfter=10,
))
styles.add(ParagraphStyle(
    name="Subsection", fontName="AdminSansBold", fontSize=14, leading=18,
    textColor=DEEP, spaceBefore=12, spaceAfter=6,
))
styles.add(ParagraphStyle(
    name="SmallSubsection", fontName="AdminSansBold", fontSize=10.5, leading=14,
    textColor=TEAL, spaceBefore=8, spaceAfter=4,
))
styles.add(ParagraphStyle(
    name="Body", fontName="AdminSans", fontSize=9.2, leading=14,
    textColor=INK, spaceAfter=6,
))
styles.add(ParagraphStyle(
    name="BodySmall", fontName="AdminSans", fontSize=7.4, leading=10.5,
    textColor=INK,
))
styles.add(ParagraphStyle(
    name="BodyTiny", fontName="AdminSans", fontSize=6.4, leading=8.5,
    textColor=INK,
))
styles.add(ParagraphStyle(
    name="Muted", fontName="AdminSans", fontSize=8.2, leading=12,
    textColor=MUTED, spaceAfter=5,
))
styles.add(ParagraphStyle(
    name="BulletSmall", fontName="AdminSans", fontSize=8.2, leading=12,
    textColor=INK, leftIndent=12, firstLineIndent=-7, spaceAfter=3,
))
styles.add(ParagraphStyle(
    name="TableHeader", fontName="AdminSansBold", fontSize=7.2, leading=9,
    textColor=WHITE,
))
styles.add(ParagraphStyle(
    name="TableBody", fontName="AdminSans", fontSize=7.1, leading=9.2,
    textColor=INK,
))
styles.add(ParagraphStyle(
    name="TableBodySmall", fontName="AdminSans", fontSize=6.5, leading=8.2,
    textColor=INK,
))
styles.add(ParagraphStyle(
    name="Metric", fontName="AdminSansBold", fontSize=19, leading=22,
    textColor=NAVY, alignment=TA_CENTER,
))
styles.add(ParagraphStyle(
    name="MetricLabel", fontName="AdminSans", fontSize=7.2, leading=9,
    textColor=MUTED, alignment=TA_CENTER,
))
styles.add(ParagraphStyle(
    name="CalloutTitle", fontName="AdminSansBold", fontSize=10, leading=13,
    textColor=TEAL, spaceAfter=4,
))
styles.add(ParagraphStyle(
    name="CalloutBody", fontName="AdminSans", fontSize=8.3, leading=12,
    textColor=INK,
))
styles.add(ParagraphStyle(
    name="Footer", fontName="AdminSans", fontSize=7, leading=9,
    textColor=MUTED,
))
styles.add(ParagraphStyle(
    name="Center", fontName="AdminSans", fontSize=8, leading=10,
    textColor=INK, alignment=TA_CENTER,
))


def inline(text: str) -> str:
    """Small, safe inline Markdown converter for report paragraphs."""
    text = escape(str(text))
    text = re.sub(r"\*\*(.+?)\*\*", r"<b>\1</b>", text)
    text = re.sub(r"`(.+?)`", r'<font name="AdminMono">\1</font>', text)
    return text


def P(text: str, style: str = "Body") -> Paragraph:
    return Paragraph(inline(text), styles[style])


def bullet(text: str) -> Paragraph:
    return P("• " + text, "BulletSmall")


def bullets(items: list[str]) -> list[Flowable]:
    return [bullet(item) for item in items]


def section(title: str, intro: str = "") -> list[Flowable]:
    result: list[Flowable] = [P(title, "Section")]
    if intro:
        result.append(P(intro, "Muted"))
    result.append(HRFlowable(width="100%", thickness=1, color=LINE, spaceBefore=2, spaceAfter=10))
    return result


def subsection(title: str) -> Paragraph:
    return P(title, "Subsection")


def small_subsection(title: str) -> Paragraph:
    return P(title, "SmallSubsection")


def cell(value: object, style: str = "TableBody") -> Paragraph:
    return P(str(value), style)


def make_table(headers: list[str], rows: list[list[object]], widths: list[float], *, small: bool = False, header_color: colors.Color = DEEP) -> Table:
    body_style = "TableBodySmall" if small else "TableBody"
    data = [[cell(h, "TableHeader") for h in headers]]
    data += [[cell(value, body_style) for value in row] for row in rows]
    table = Table(data, colWidths=widths, repeatRows=1, hAlign="LEFT", splitByRow=1)
    table.setStyle(TableStyle([
        ("BACKGROUND", (0, 0), (-1, 0), header_color),
        ("TEXTCOLOR", (0, 0), (-1, 0), WHITE),
        ("GRID", (0, 0), (-1, -1), 0.35, LINE),
        ("VALIGN", (0, 0), (-1, -1), "TOP"),
        ("LEFTPADDING", (0, 0), (-1, -1), 6),
        ("RIGHTPADDING", (0, 0), (-1, -1), 6),
        ("TOPPADDING", (0, 0), (-1, -1), 5),
        ("BOTTOMPADDING", (0, 0), (-1, -1), 5),
        ("ROWBACKGROUNDS", (0, 1), (-1, -1), [WHITE, PAPER]),
    ]))
    return table


def metric_strip(metrics: list[tuple[str, str]]) -> Table:
    cells = []
    for value, label in metrics:
        cells.append([P(value, "Metric"), P(label, "MetricLabel")])
    data = [[P(value, "Metric") for value, _ in metrics], [P(label, "MetricLabel") for _, label in metrics]]
    table = Table(data, colWidths=[(PAGE_WIDTH - LEFT - RIGHT) / len(metrics)] * len(metrics), rowHeights=[0.38 * inch, 0.30 * inch])
    table.setStyle(TableStyle([
        ("BACKGROUND", (0, 0), (-1, -1), PAPER),
        ("BOX", (0, 0), (-1, -1), 0.6, LINE),
        ("INNERGRID", (0, 0), (-1, -1), 0.35, LINE),
        ("VALIGN", (0, 0), (-1, -1), "MIDDLE"),
        ("TOPPADDING", (0, 0), (-1, -1), 4),
        ("BOTTOMPADDING", (0, 0), (-1, -1), 4),
    ]))
    return table


class ArchitectureDiagram(Flowable):
    def __init__(self, width: float, height: float = 1.55 * inch):
        super().__init__()
        self.width = width
        self.height = height

    def draw(self):
        c = self.canv
        labels = [
            ("Browser", "Blade + Vite"),
            ("Routes", "RouteServiceProvider"),
            ("Middleware", "auth + rol"),
            ("Controller", "FormRequest"),
            ("Eloquent", "MySQL / SQLite"),
        ]
        box_w = (self.width - 4 * 16) / 5
        y = 0.38 * inch
        h = 0.72 * inch
        for i, (title, detail) in enumerate(labels):
            x = i * (box_w + 16)
            c.setFillColor(PALE_GREEN if i in (1, 2, 3) else PALE_BLUE)
            c.setStrokeColor(TEAL if i in (1, 2, 3) else BLUE)
            c.setLineWidth(0.9)
            c.roundRect(x, y, box_w, h, 5, fill=1, stroke=1)
            c.setFillColor(DEEP)
            c.setFont("AdminSansBold", 8)
            c.drawCentredString(x + box_w / 2, y + h - 20, title)
            c.setFillColor(MUTED)
            c.setFont("AdminSans", 6.7)
            c.drawCentredString(x + box_w / 2, y + 15, detail)
            if i < len(labels) - 1:
                ax = x + box_w + 3
                ay = y + h / 2
                c.setStrokeColor(GREEN)
                c.setLineWidth(1.2)
                c.line(ax, ay, ax + 10, ay)
                c.line(ax + 10, ay, ax + 6, ay + 3)
                c.line(ax + 10, ay, ax + 6, ay - 3)
        c.setFillColor(MUTED)
        c.setFont("AdminSans", 6.5)
        c.drawString(0, 0.12 * inch, "La base de datos es el límite de consistencia; Blade es la capa de presentación.")


class DomainDiagram(Flowable):
    def __init__(self, width: float, height: float = 2.45 * inch):
        super().__init__()
        self.width = width
        self.height = height

    def draw(self):
        c = self.canv
        c.setFont("AdminSansBold", 7.5)
        nodes = [
            ("Centro", 0.05, 1.72, 1.35, 0.42, PALE_BLUE, BLUE),
            ("Área", 1.65, 1.72, 1.15, 0.42, PALE_BLUE, BLUE),
            ("Programa", 3.05, 1.72, 1.35, 0.42, PALE_BLUE, BLUE),
            ("Oferta", 4.75, 1.72, 1.20, 0.42, PALE_ORANGE, HexColor("#C77700")),
            ("Inscripción", 6.20, 1.72, 1.35, 0.42, PALE_ORANGE, HexColor("#C77700")),
            ("Aspirante", 7.80, 1.72, 1.25, 0.42, PALE_ORANGE, HexColor("#C77700")),
            ("Centro", 0.05, 0.75, 1.35, 0.42, PALE_BLUE, BLUE),
            ("Ambiente", 1.65, 0.75, 1.35, 0.42, PALE_BLUE, BLUE),
            ("Equipo", 3.25, 0.75, 1.20, 0.42, PALE_GREEN, TEAL),
            ("Asignación", 4.70, 0.75, 1.40, 0.42, PALE_GREEN, TEAL),
            ("Aprendiz", 6.35, 0.75, 1.20, 0.42, PALE_GREEN, TEAL),
            ("Ficha", 0.05, -0.05, 1.35, 0.42, PALE_GREEN, TEAL),
            ("Programa", 1.65, -0.05, 1.35, 0.42, PALE_GREEN, TEAL),
            ("Competencia", 3.25, -0.05, 1.55, 0.42, PALE_RED, HexColor("#B42318")),
            ("Resultado", 5.05, -0.05, 1.35, 0.42, PALE_RED, HexColor("#B42318")),
            ("Calificación", 6.65, -0.05, 1.45, 0.42, PALE_RED, HexColor("#B42318")),
        ]
        positions = {}
        for title, x, y, w, h, fill, stroke in nodes:
            c.setFillColor(fill)
            c.setStrokeColor(stroke)
            c.setLineWidth(0.8)
            c.roundRect(x * inch, y * inch, w * inch, h * inch, 4, fill=1, stroke=1)
            c.setFillColor(DEEP)
            c.setFont("AdminSansBold", 6.5)
            c.drawCentredString((x + w / 2) * inch, (y + 0.22) * inch, title)
            positions[title] = (x, y, w, h)
        arrows = [
            ("Centro", "Área"), ("Área", "Programa"), ("Programa", "Oferta"),
            ("Oferta", "Inscripción"), ("Inscripción", "Aspirante"),
            ("Centro", "Ambiente"), ("Ambiente", "Equipo"), ("Equipo", "Asignación"),
            ("Asignación", "Aprendiz"), ("Programa", "Ficha"), ("Ficha", "Aprendiz"),
            ("Competencia", "Resultado"), ("Resultado", "Calificación"),
            ("Aprendiz", "Calificación"),
        ]
        for a, b in arrows:
            if a not in positions or b not in positions:
                continue
            ax, ay, aw, ah = positions[a]
            bx, by, bw, bh = positions[b]
            x1 = (ax + aw if bx > ax else ax) * inch
            y1 = (ay + ah / 2) * inch
            x2 = (bx if bx > ax else bx + bw) * inch
            y2 = (by + bh / 2) * inch
            if abs(y1 - y2) < 2:
                x2 = (bx - 0.08 if bx > ax else bx + bw + 0.08) * inch
            c.setStrokeColor(GREEN)
            c.setLineWidth(0.8)
            c.line(x1, y1, x2, y2)
            c.line(x2, y2, x2 - 4, y2 + 2.5)
            c.line(x2, y2, x2 - 4, y2 - 2.5)
        c.setFillColor(MUTED)
        c.setFont("AdminSans", 6.5)
        c.drawString(0, -0.42 * inch, "Las relaciones pivote agregan docentes a la ficha y a las competencias sin reemplazar el docente principal.")


def callout(title: str, body: str, tone: str = "info") -> Table:
    if tone == "warning":
        fill, edge = PALE_ORANGE, HexColor("#C77700")
    elif tone == "danger":
        fill, edge = PALE_RED, HexColor("#B42318")
    elif tone == "success":
        fill, edge = PALE_GREEN, TEAL
    else:
        fill, edge = PALE_BLUE, BLUE
    content = [[P(title, "CalloutTitle")], [P(body, "CalloutBody")]]
    table = Table(content, colWidths=[PAGE_WIDTH - LEFT - RIGHT - 2], hAlign="LEFT")
    table.setStyle(TableStyle([
        ("BACKGROUND", (0, 0), (-1, -1), fill),
        ("BOX", (0, 0), (-1, -1), 0.8, edge),
        ("LINEBEFORE", (0, 0), (0, -1), 4, edge),
        ("LEFTPADDING", (0, 0), (-1, -1), 10),
        ("RIGHTPADDING", (0, 0), (-1, -1), 10),
        ("TOPPADDING", (0, 0), (-1, -1), 7),
        ("BOTTOMPADDING", (0, 0), (-1, -1), 7),
    ]))
    return table


def cover_header(canvas, doc):
    canvas.saveState()
    canvas.setFillColor(NAVY)
    canvas.rect(0, 0, PAGE_WIDTH, PAGE_HEIGHT, fill=1, stroke=0)
    canvas.setFillColor(DEEP)
    canvas.circle(PAGE_WIDTH - 0.9 * inch, PAGE_HEIGHT - 0.65 * inch, 1.7 * inch, fill=1, stroke=0)
    canvas.setFillColor(GREEN)
    canvas.circle(PAGE_WIDTH - 0.9 * inch, PAGE_HEIGHT - 0.65 * inch, 0.55 * inch, fill=1, stroke=0)
    canvas.setFillColor(MINT)
    canvas.rect(LEFT, PAGE_HEIGHT - 0.42 * inch, 1.3 * inch, 0.06 * inch, fill=1, stroke=0)
    canvas.setFont("AdminSansBold", 8)
    canvas.setFillColor(HexColor("#B8D4D9"))
    canvas.drawRightString(PAGE_WIDTH - RIGHT, 0.36 * inch, "ADMINsena · documento técnico")
    canvas.restoreState()


def later_pages(canvas, doc):
    canvas.saveState()
    canvas.setStrokeColor(LINE)
    canvas.setLineWidth(0.6)
    canvas.line(LEFT, PAGE_HEIGHT - 0.42 * inch, PAGE_WIDTH - RIGHT, PAGE_HEIGHT - 0.42 * inch)
    canvas.setFont("AdminSansBold", 7.5)
    canvas.setFillColor(TEAL)
    canvas.drawString(LEFT, PAGE_HEIGHT - 0.30 * inch, "ADMINsena · mapa técnico y funcional")
    canvas.setFont("AdminSans", 7)
    canvas.setFillColor(MUTED)
    canvas.drawRightString(PAGE_WIDTH - RIGHT, PAGE_HEIGHT - 0.30 * inch, "24 · 09 · 2026")
    canvas.line(LEFT, 0.34 * inch, PAGE_WIDTH - RIGHT, 0.34 * inch)
    canvas.drawString(LEFT, 0.20 * inch, "Basado en inspección estática del código actual")
    canvas.drawRightString(PAGE_WIDTH - RIGHT, 0.20 * inch, f"{doc.page}")
    canvas.restoreState()


class NumberedDocTemplate(BaseDocTemplate):
    def __init__(self, filename: str, **kwargs):
        super().__init__(filename, **kwargs)
        frame = Frame(LEFT, BOTTOM, PAGE_WIDTH - LEFT - RIGHT, PAGE_HEIGHT - TOP - BOTTOM, id="normal", leftPadding=0, rightPadding=0, topPadding=0, bottomPadding=0)
        self.addPageTemplates([
            PageTemplate(id="cover", frames=frame, onPage=cover_header),
            PageTemplate(id="normal", frames=frame, onPage=later_pages),
        ])


def domain_block(title: str, purpose: str, models: str, views: str, behavior: list[str], rules: list[str] | None = None) -> list[Flowable]:
    result: list[Flowable] = [KeepTogether([subsection(title), P(purpose, "Muted")])]
    result.append(make_table(
        ["Modelos / tablas", "Vistas principales"],
        [[models, views]],
        [(PAGE_WIDTH - LEFT - RIGHT) * 0.40, (PAGE_WIDTH - LEFT - RIGHT) * 0.60],
        small=True,
        header_color=TEAL,
    ))
    result.append(Spacer(1, 6))
    result.append(small_subsection("Qué permite"))
    result.extend(bullets(behavior))
    if rules:
        result.append(small_subsection("Reglas y límites"))
        result.extend(bullets(rules))
    return result


def build_story() -> list[Flowable]:
    story: list[Flowable] = []

    # Cover
    story.extend([
        Spacer(1, 1.25 * inch),
        P("ADMINSENA", "CoverKicker"),
        P("Mapa técnico y funcional del proyecto", "CoverTitle"),
        P("Arquitectura por dominios, modelo de datos, portales por rol, vistas, flujos funcionales, factories, seeders, pruebas y backlog técnico.", "CoverSubtitle"),
        Spacer(1, 0.15 * inch),
        P("Presentación técnica · 24 de septiembre de 2026", "CoverMeta"),
        P("PHP 8.1+ · Laravel 10 · Vite 6 · Tailwind CSS 4 · MySQL / SQLite", "CoverMeta"),
        Spacer(1, 2.8 * inch),
        P("Objetivo: explicar cómo está construido AdminSena, qué muestra cada portal y cuál es la siguiente frontera de calidad.", "CoverSubtitle"),
    ])
    story.append(NextPageTemplate("normal"))
    story.append(PageBreak())

    # Executive summary
    story.extend(section("1. Resumen ejecutivo", "Una vista de alto nivel para presentar el alcance actual y la dirección técnica."))
    story.append(P("AdminSena es una plataforma Laravel para organizar la formación técnica del SENA. Integra un portal público, autenticación por rol, operación institucional, seguimiento docente, proceso del aprendiz y admisión de aspirantes. La organización por dominios permite que cada área de negocio tenga sus propios controladores, requests, modelos, rutas y vistas."))
    story.append(metric_strip([
        ("146", "rutas"),
        ("20", "tablas de dominio"),
        ("134", "vistas Blade"),
        ("14", "módulos"),
        ("16 / 100", "tests / assertions"),
    ]))
    story.append(Spacer(1, 12))
    story.append(callout("Lectura ejecutiva", "La base funcional ya es considerable: Eloquent expresa las relaciones, los portales limitan consultas al usuario y la UI tiene un shell responsive común. La prioridad siguiente es cerrar autorización por objeto, publicación, privacidad de documentos y contratos inconsistentes.", "success"))
    story.append(Spacer(1, 8))
    story.append(make_table(
        ["Inventario", "Cantidad", "Lectura"],
        [
            ["Controladores de dominio", "24", "CRUD y flujos por módulo"],
            ["Factories", "20", "Una por tabla/modelo, incluidas pivotes"],
            ["Seeders", "22", "20 de dominio + raíz + compatibilidad"],
            ["Migraciones", "24", "21 de dominio + 3 internas"],
            ["Vistas", "134", "Dashboards, CRUD, layouts y componentes"],
            ["Pruebas", "5 archivos", "Navegación, autorización y factories/seeders"],
        ],
        [2.15 * inch, 1.15 * inch, PAGE_WIDTH - LEFT - RIGHT - 3.30 * inch],
    ))
    story.append(PageBreak())

    # Contents
    story.extend(section("2. Contenido", "El documento se puede recorrer como una presentación por capítulos o como una referencia técnica."))
    contents = [
        ["01", "Resumen ejecutivo", "Alcance, cifras y conclusión"],
        ["02", "Arquitectura", "Stack, routing, middleware y ciclo de una petición"],
        ["03", "Mapa de dominios", "Los 14 módulos y sus responsabilidades"],
        ["04", "Modelo de datos", "20 tablas y relaciones principales"],
        ["05", "Portales y vistas", "Admin, Instructor, Aprendiz y Aspirante"],
        ["06", "Validación y negocio", "Enums, fechas, ownership y estados"],
        ["07", "Factories y seeders", "Datos de prueba y dependencias"],
        ["08", "Calidad y riesgos", "Pruebas achieved y backlog priorizado"],
        ["09", "Roadmap y glosario", "Próximas fases y términos clave"],
    ]
    story.append(make_table(["#", "Capítulo", "Contenido"], contents, [0.55 * inch, 2.75 * inch, PAGE_WIDTH - LEFT - RIGHT - 3.30 * inch], header_color=TEAL))
    story.append(Spacer(1, 18))
    story.append(callout("Cómo leer este documento", "Las secciones 3 a 7 describen lo que existe. La sección 8 separa las funcionalidades logradas de los riesgos todavía observables en el código. La sección 9 propone una ruta de evolução sin presentar recomendaciones como si ya estuvieran implementadas.", "info"))
    story.append(PageBreak())

    # Architecture
    story.extend(section("3. Arquitectura", "La aplicación separa infraestructura, dominio y presentación sin abandonar las convenciones de Laravel."))
    story.append(ArchitectureDiagram(PAGE_WIDTH - LEFT - RIGHT))
    story.append(Spacer(1, 8))
    story.append(subsection("3.1 Componentes principales"))
    story.append(make_table(
        ["Capa", "Implementación", "Responsabilidad"],
        [
            ["HTTP", "Controllers + FormRequest", "Reciben parámetros, validan y coordinan casos de uso"],
            ["Dominio", "app/Dominios", "Agrupa modelos, rutas, requests y controladores por negocio"],
            ["Persistencia", "Eloquent + migrations", "Relaciones, enums, FKs, timestamps y datos de prueba"],
            ["Presentación", "Blade + Tailwind", "Dashboards, formularios, tablas, estados y navegación"],
            ["Assets", "Vite + Bootstrap Icons", "Compilación de CSS/JS e iconografía"],
            ["Pruebas", "PHPUnit + SQLite", "Aislamiento de la base y pruebas de relaciones/autorización"],
        ],
        [1.25 * inch, 2.35 * inch, PAGE_WIDTH - LEFT - RIGHT - 3.60 * inch],
    ))
    story.append(Spacer(1, 8))
    story.append(subsection("3.2 Routing y middleware"))
    story.extend(bullets([
        "`RouteServiceProvider` carga los archivos web/API de cada dominio explícitamente; por eso el proyecto no depende de un único archivo de rutas gigante.",
        "Los grupos `web` incluyen cookies, sesión, CSRF y bindings. El grupo `api` agrega throttling de 60 solicitudes por minuto.",
        "Los alias `admin`, `instructor`, `aprendiz` y `aspirante` aplican autorización básica por rol; algunos controladores añaden autorización por objeto y ámbito.",
        "Los archivos de API de los dominios están preparados como puntos de extensión, pero actualmente están vacíos; la API real es un trabajo futuro.",
    ]))
    story.append(callout("Decisión arquitectónica positiva", "La separación por dominios mejora la navegabilidad del código y hace visible qué parte del sistema debe cambiar para una nueva regla de negocio. La siguiente mejora es convertir parte de las reglas de autorización en Policies reutilizables.", "success"))
    story.append(PageBreak())

    # Domain overview
    story.extend(section("4. Mapa de dominios", "Los 14 módulos pueden agruparse en identidad, estructura, formación, operación y comunicación."))
    domain_rows = [
        ["Auth", "Acceso y catálogo público", "Portada, login, registro, noticias, ofertas"],
        ["Usuarios", "Identidad y perfiles de rol", "User + Admin/Teacher/Apprentice/Aspirant"],
        ["Centros", "Sedes institucionales", "Trainingcenter"],
        ["Áreas", "Organización académica", "Area → Program"],
        ["Programas", "Oferta formativa base", "Program → Offer"],
        ["Ambientes", "Espacios de formación", "Environment → Equipment"],
        ["Equipos", "Inventario operativo", "Equipment → Assignment"],
        ["Fichas", "Grupo de aprendices", "Course_group + pivote docente"],
        ["Competencias", "Unidades de desempeño", "Competition + pivote docente"],
        ["Resultados", "Resultados y calificaciones", "Result + Grade"],
        ["Asignaciones", "Entrega de equipos", "Assignment"],
        ["Ofertas", "Convocatorias", "Offer"],
        ["Inscripciones", "Admisión y estados", "Registration"],
        ["Noticias", "Comunicación pública", "News"],
    ]
    story.append(make_table(["Dominio", "Responsabilidad", "Entidad / flujo principal"], domain_rows, [1.55 * inch, 3.05 * inch, PAGE_WIDTH - LEFT - RIGHT - 4.60 * inch], header_color=DEEP))
    story.append(Spacer(1, 10))
    story.append(DomainDiagram(PAGE_WIDTH - LEFT - RIGHT))
    story.append(PageBreak())

    # Identity and public
    story.extend(section("5. Identidad, acceso ydomains públicos", "La experiencia pública y la autenticación son la puerta de entrada a los cuatro portales."))
    story.extend(domain_block(
        "5.1 Auth y experiencia pública",
        "Permite descubrir la institución, acceder al sistema y consultar noticias/ofertas sin sesión.",
        "`OfertasyNoticiasController`, `LoginController`, `RegisterController` y el modelo `User`.",
        "`Auth/inicio.blade.php`, `Auth/login.blade.php`, `Auth/register.blade.php`, `Auth/noticias.blade.php`, `Auth/noticia.blade.php`, `Auth/ofertas.blade.php`, `Auth/oferta.blade.php`.",
        [
            "La portada comunica la propuesta institucional y los módulos principales. El acceso actual usa `Auth::attempt`, regeneración de sesión y redirección por rol.",
            "El catálogo de noticias filtra por título y categoría; el de ofertas busca por nombre de programa, código o área.",
            "Cada tarjeta enlaza a un show público con contenido completo, imagen, metadatos y fechas.",
            "Las páginas show devuelven 404 cuando el recurso no está publicado.",
        ],
        [
            "Las ofertas requieren `publicada = true`; las noticias requieren `publicada = true` y `estado = 'Publicado'`.",
            "El login actual usa los roles capitalizados que espera el enum de `users`.",
            "El request de registro todavía acepta roles en minúsculas: es una inconsistencia que debe normalizarse.",
            "La portada contiene cifras de presentación como +120, +35 y 1,248; no son consultas a la base actual.",
        ],
    ))
    story.extend(domain_block(
        "5.2 Usuarios y perfiles",
        "Separa la identidad común del perfil especializado que cada rol necesita para operar.",
        "`User`, `Admin`, `Teacher`, `Apprentice`, `Aspirant` y `ConsultasController`.",
        "`Usuarios/Admin/*`, `Usuarios/Instructores/*`, `Usuarios/Aprendices/*`, `Usuarios/Aspirantes/*`.",
        [
            "Admin gestiona su perfil, consulta usuarios por rol y ve el dashboard institucional.",
            "Instructor mantiene área, especialidad, fechas y tipo de instructor.",
            "Aprendiz mantiene ficha, estado y fechas formativas; el alcance de edición es un punto que requiere endurecimiento.",
            "Aspirante mantiene EPS y documentos de admisión.",
        ],
        [
            "Cada perfil se enlaza con `user_id` y el usuario tiene relaciones `hasOne`.",
            "Las consultas de los portales usan el usuario autenticado como punto de entrada, no un ID tomado de la URL.",
        ],
    ))
    story.append(PageBreak())

    # Institutional domains
    story.extend(section("6. Dominios institucionales y catálogo", "La estructura académica describe dónde se forman los grupos y con qué recursos."))
    story.extend(domain_block(
        "6.1 Centros",
        "Representa las sedes donde se dictan programas y se organizan ambientes.",
        "`Trainingcenter`; relaciones `hasMany` hacia `Area` y `Environment`.",
        "`Centros/index.blade.php`, create, edit, show y formulario parcial.",
        ["CRUD de nombre/dirección.", "Listado ordered por fecha de creación.", "Detalle del centro.", "Formularios con mensajes de validación en español."],
        ["El request exige nombre de mínimo 5 caracteres, letras/espacios y dirección de mínimo 10 caracteres.", "La ruta actual no tiene middleware `auth/admin` en su grupo web; es un riesgo de seguridad."],
    ))
    story.extend(domain_block(
        "6.2 Áreas",
        "Agrupa la oferta académica de un centro y conecta áreas con programas.",
        "`Area` pertenece a `Trainingcenter` y tiene muchos `Program`.",
        "`Areas/index.blade.php`, create, edit, show y estilos parciales.",
        ["CRUD de áreas.", "Listado con centro y conteo de programas.", "Selección de centro en alta/edición."],
        ["El nombre tiene mínimo 3 caracteres.", "La existencia del centro se valida en `AreaRequest`."],
    ))
    story.extend(domain_block(
        "6.3 Programas",
        "Define la formación académica que puede generar ofertas y grupos.",
        "`Program` pertenece a `Area` y tiene muchas ofertas (`offerts` en el método de relación).",
        "`Programas/index.blade.php`, create, edit, show y formulario parcial.",
        ["CRUD de programas.", "Código único y nivel controlado por enum.", "Listado con área, centro y conteo de ofertas."],
        ["Niveles permitidos: `Tecnico` y `Tecnologo`.", "La relación `offerts` es un nombre histórico; la tabla real es `offers`."],
    ))
    story.extend(domain_block(
        "6.4 Ambientes y equipos",
        "Administra espacios y recursos que luego se entregan a aprendices.",
        "`Environment` pertenece a `Trainingcenter`; `Equipment` pertenece a `Environment`.",
        "`Ambientes/*` y `Equipos/*` con listados, formularios y detalles.",
        ["Ambientes: nombre, capacidad, tipo y centro.", "Equipos: nombre, marca, tipo y ambiente.", "Las relaciones permiten navegar del equipo a su ambiente y centro."],
        ["Tipos de ambiente: `Software`, `TICS`, `Laboratorio`, `Cocina`.", "La capacidad mínima validada es 1; las factories usan valores realistas de 10–40."],
    ))
    story.append(PageBreak())

    # Academic
    story.extend(section("7. Formación y operación académica", "Aquí se conectan fichas, docentes, competencias, resultados, calificaciones y equipos."))
    story.extend(domain_block(
        "7.1 Fichas de formación",
        "Una ficha agrupa aprendices de un programa y asigna docentes.",
        "`Course_group`, `CourseGroupTeacher`; `Program` y `Teacher` como dependencias.",
        "`Fichas/index.blade.php`, create, edit, show y `Fichas/form.blade.php`.",
        ["CRUD de grupos.", "Consulta de programa, instructor principal, instructores pivote y aprendices.", "El controlador sincroniza el docente pivote al crear/editar."],
        ["Código único y capacidad positiva.", "El instructor principal debe ser de tipo `Planta`.", "Las consultas de instructor consideran `teacher_id` y la relación pivote."],
    ))
    story.extend(domain_block(
        "7.2 Competencias",
        "Representa competencias con periodo y responsables docentes.",
        "`Competition`, `CompetitionTeacher`; relación directa a `Teacher` y N:M.",
        "`Competencias/index.blade.php`, create, edit, show y `form.blade.php`.",
        ["CRUD administrativo.", "Asignación de instructores mediante `sync`.", "Las fechas sostienen la agenda y el filtro de resultados."],
        ["El request valida `teacher_id`, pero el controlador consume `teachers[]`; el contrato de formulario debe unificarse.", "El código no tiene una restricción unique de base aunque el request la aplica."],
    ))
    story.extend(domain_block(
        "7.3 Resultados y calificaciones",
        "Distingue el resultado de aprendizaje de la evaluación concreta de cada aprendiz.",
        "`Result` pertenece a `Competition`; `Grade` pertenece a `Result`, `Apprentice` y opcionalmente `Teacher`.",
        "`Resultados/*`, `Resultados/Instructor/*` y `Resultados/Aprendiz/index.blade.php`.",
        ["Admin crea, edita, filtra y elimina resultados sin grades.", "Instructor abre una matriz por ficha/competencia y guarda con `updateOrCreate`.", "Aprendiz consulta únicamente sus grades y su resumen por estado."],
        ["Estados: `Aprobado`, `Reprobado`, `Pendiente`.", "La combinación `(result_id, apprentice_id)` es única.", "El modelo `Result` ya no debe incluir `apprentice_id`; la tabla se reestructuró."],
    ))
    story.extend(domain_block(
        "7.4 Asignaciones",
        "Conecta un equipo físico con un aprendiz y su fecha de entrega/devolución.",
        "`Assignment` pertenece a `Equipment` y `Apprentice`.",
        "`Asignaciones/*` para administración/instructor y `Asignaciones/Aprendiz/*` para el aprendiz.",
        ["Admin consulta todas.", "Instructor crea, edita, elimina y filtra dentro de sus fichas.", "Aprendiz lista y abre solo las suyas.", "El resumen distingue activas, finalizadas y devueltas."],
        ["Estados: `Activo`, `Inactivo`.", "La devolución debe ser igual o posterior a la asignación.", "Debe corregirse la búsqueda del Aprendiz para usar `whereHas('equipment', ...)`."],
    ))
    story.append(PageBreak())

    # Admission
    story.extend(section("8. Admisión y comunicación", "Ofertas, inscripciones y noticias conectan la plataforma con el público y la comunidad."))
    story.extend(domain_block(
        "8.1 Ofertas",
        "Representa convocatorias con programa, capacidad, calendario y publicación.",
        "`Offer` pertenece a `Admin` y `Program`; tiene muchas `Registration`.",
        "`Ofertas/*`, `Auth/ofertas.blade.php`, `Auth/oferta.blade.php` y vistas del Aspirante.",
        ["Admin crea, edita, elimina, publica y despublica ofertas.", "El catálogo público busca por nombre de programa, código o área y cada tarjeta abre un show.", "El Aspirante solo ve ofertas publicadas y puede abrir el detalle para gestionar su inscripción.", "La capacidad y las fechas determinan si una oferta admite nuevas inscripciones."],
        ["Secuencia de fechas obligatoria en el request.", "El listado y el show público solo cargan ofertas con `publicada = true`.", "El show muestra programa, centro, código, cupos, inscripciones activas y calendario."],
    ))
    story.extend(domain_block(
        "8.2 Inscripciones",
        "Gestiona el estado de un Aspirante dentro de una Oferta.",
        "`Registration` pertenece a `Aspirant` y `Offer`.",
        "`Inscripciones/*` para Admin y `Inscripciones/Aspirante/*` para autoservicio.",
        ["Admin filtra por búsqueda, oferta y estado; puede cambiar el estado.", "Aspirante consulta, crea, edita y cancela con verificaciones de propiedad.", "El detalle carga oferta/programa y datos del aspirante.", "Las fechas generan una línea de tiempo."],
        ["Solo `Registrado` permite edición.", "Solo `Registrado`/`En proceso` permite cancelación.", "Se evita una inscripción activa duplicada por lógica en el controller.", "Documentos requeridos en la primera inscripción."],
    ))
    story.extend(domain_block(
        "8.3 Noticias",
        "Administra publicaciones institucionales y las muestra en el portal público.",
        "`News` pertenece a `Trainingcenter` y opcionalmente a `Admin`.",
        "`Noticias/*`, `Auth/noticias.blade.php`, `Auth/noticia.blade.php`, formularios y cards públicas.",
        ["CRUD administrativo.", "Búsqueda por título y categoría.", "Estados editoriales y bandera `publicada`.", "Cada noticia publicada tiene un show individual con imagen, categoría, fecha, centro y descripción completa."],
        ["El listado y el show requieren `publicada = true` y `estado = 'Publicado'`.", "Las imágenes se almacenan bajo `news/public`.", "`categoria` y `publicada` deben mantenerse en el contrato del request y formulario administrativo."],
    ))
    story.append(PageBreak())

    # Data model
    story.extend(section("9. Diccionario de datos", "La siguiente tabla conecta cada tabla con su responsabilidad y dependencia principal."))
    dictionary = [
        ["users", "Identidad/autenticación", "rol, email, password, identificación", "Base de perfiles"],
        ["trainingcenters", "Sedes", "nombre, dirección", "Raíz institucional"],
        ["admins", "Perfil administrador", "user_id, cargo, oficina", "users"],
        ["aspirants", "Perfil aspirante", "user_id, EPS, documentos", "users"],
        ["areas", "Áreas", "centro, nombre", "trainingcenters"],
        ["environments", "Ambientes", "centro, capacidad, tipo", "trainingcenters"],
        ["teachers", "Perfil docente", "user_id, área, especialidad, tipo", "users, areas"],
        ["equipments", "Inventario", "ambiente, name, brand, type", "environments"],
        ["programs", "Programas", "área, código, nivel", "areas"],
        ["news", "Contenido", "centro, admin, estado, categoría", "trainingcenters, admins"],
        ["course_groups", "Fichas", "programa, teacher, código, capacidad", "programs, teachers"],
        ["apprentices", "Aprendices", "user, ficha, estado, fechas", "users, course_groups"],
        ["offers", "Ofertas", "admin, programa, capacidad, fechas, publicada", "admins, programs"],
        ["competitions", "Competencias", "teacher, código, fechas", "teachers"],
        ["results", "Resultados", "competition, código, nombre", "competitions"],
        ["grades", "Calificaciones", "result, apprentice, teacher, estado", "results, apprentices, teachers"],
        ["registrations", "Inscripciones", "aspirant, offer, estado, fecha", "aspirants, offers"],
        ["assignments", "Asignaciones", "equipment, apprentice, fechas, estado", "equipments, apprentices"],
        ["competition_teacher", "Pivote docente", "competency_id, teacher_id", "competitions, teachers"],
        ["course_group_teacher", "Pivote docente", "course_group_id, teacher_id", "course_groups, teachers"],
    ]
    story.append(make_table(["Tabla", "Responsabilidad", "Claves/campos clave", "Depende de"], dictionary, [1.55 * inch, 1.85 * inch, PAGE_WIDTH - LEFT - RIGHT - 5.25 * inch, 1.85 * inch], small=True))
    story.append(Spacer(1, 10))
    story.append(callout("Nota sobre nomenclatura", "`competency_id` conserva el nombre histórico aunque la tabla referenciada es `competitions`. Cambiarlo requiere una migración nueva, no editar una migración que ya pudo aplicarse en otra base.", "warning"))
    story.append(PageBreak())

    # Portals and views
    story.extend(section("10. Portales, vistas y navegación", "El sistema usa un shell común y diferencia el contenido por el prefijo de ruta."))
    story.append(subsection("10.1 Layout y navegación"))
    story.extend(bullets([
        "`Layouts/Usuarios/AppAdmin.blade.php` es el layout activo y selecciona sidebar/header por `request()->routeIs()`.",
        "`Includes/Usuarios/Sidebar.blade.php` recibe configuración de portal y dibuja navegación desktop + barra inferior móvil.",
        "Los sidebars de rol usan rutas nombradas, iconos SVG, estados activos y secciones plegables.",
        "Los componentes `page-header`, `metric`, `empty-state` y `status-badge` permiten consistencia visual.",
        "Tailwind aplica layouts fluidos, tablas con scroll horizontal, grids responsivos y estados vacíos.",
    ]))
    story.append(Spacer(1, 4))
    story.append(subsection("10.2 Vista por rol"))
    portal_rows = [
        ["Admin", "/admin/* y CRUDs protegidos", "Dashboard, estructura, oferta, noticias, inscripciones, resultados, usuarios", "Totales + filtros + CRUD"],
        ["Instructor", "/instructor/*", "Aprendices, fichas, resultados, asignaciones, actividades, agenda", "Ámbito por ficha/docente"],
        ["Aprendiz", "/aprendiz/*", "Dashboard, ficha, asignaciones, resultados, cronograma, perfil", "Solo datos propios"],
        ["Aspirante", "/aspirante/*", "Ofertas, inscripciones, resultados, fechas, perfil", "Ofertas publicadas + ownership"],
        ["Público", "/ y /auth.*", "Inicio, noticias, ofertas, login, registro", "Catálogo público"],
    ]
    story.append(make_table(["Portal", "Rutas", "Vistas/funciones", "Alcance"], portal_rows, [1.0 * inch, 2.0 * inch, PAGE_WIDTH - LEFT - RIGHT - 5.0 * inch, 2.0 * inch], small=True))
    story.append(Spacer(1, 8))
    story.append(subsection("10.3 Qué muestra cada dashboard"))
    story.append(make_table(
        ["Dashboard", "Métricas/visibles", "Acciones rápidas"],
        [
            ["Admin", "Centros y aprendices reales; algunos valores de presentación", "Centros, áreas, ambientes, equipos"],
            ["Instructor", "Aprendices, fichas, competencias, asignaciones, progreso", "Aprendices, fichas, resultados, asignaciones"],
            ["Aprendiz", "Ficha, equipos, resultados y progreso", "Ficha, tareas, resultados, cronograma"],
            ["Aspirante", "Inscripciones, documentos, estado y avance", "Perfil, inscripción, resultados, fechas"],
        ],
        [1.2 * inch, PAGE_WIDTH - LEFT - RIGHT - 3.2 * inch, 2.0 * inch],
    ))
    story.append(PageBreak())

    # Business rules
    story.extend(section("11. Validación y reglas de negocio", "Los FormRequests defienden la entrada; los modelos y controllers defienen la transición y el alcance."))
    rules = [
        ["Identidad", "CC/TI/CE/PPT; email e identificación únicos; password hasheada", "RegisterRequest / User model"],
        ["Centro", "Nombre 5–255; dirección mínimo 10", "TrainingcentersRequest"],
        ["Ambiente", "Centro existente; capacidad ≥1; tipo enum", "EnvironmentRequest"],
        ["Programa", "Área existente; código único; nivel enum", "ProgramRequest"],
        ["Ficha", "Programa/docente; código único; capacidad ≥1; docente Planta", "CourseGroupRequest"],
        ["Oferta", "Fechas ordenadas; capacidad positiva; imagen <=2MB", "OfferRequest"],
        ["Asignación", "Equipo/aprendiz existentes; devolución >= asignación; estado enum", "AssignmentRequest"],
        ["Inscripción", "Aspirante/oferta; documentos; ownership; estado editable/cancelable", "RegistrationRequest / model"],
        ["Calificación", "IDs autorizados a ficha/competencia; estado enum; unique compuesto", "GradeRequest / controller"],
    ]
    story.append(make_table(["Área", "Regla", "Punto de control"], rules, [1.25 * inch, PAGE_WIDTH - LEFT - RIGHT - 3.65 * inch, 2.40 * inch], small=True))
    story.append(Spacer(1, 12))
    story.append(subsection("11.1 ownership y estados"))
    story.extend(bullets([
        "El Instructor no puede abrir una ficha, competencia o asignación fuera de las relaciones que lo relacionan con la ficha/competencia.",
        "El Aprendiz solo puede abrir una asignación cuyo `apprentice_id` coincide con su perfil.",
        "El Aspirante solo puede ver/modificar inscripciones cuyo `aspirant_id` coincide con su perfil.",
        "Una inscripción cancelada deja de contar para el proceso activo y la capacidad de la oferta.",
        "Un grade solo se guarda si el resultado pertenece a la competencia autorizada y el aprendiz a la ficha autorizada.",
    ]))
    story.append(callout("Distinción importante", "La autorización por rol no siempre equivale a autorización por objeto. Los controllers de asignaciones, resultados e inscripciones sí añaden filtros de pertenencia; la siguiente etapa debe extender ese patrón a todos los módulos sensibles.", "info"))
    story.append(PageBreak())

    # Factories/seeders
    story.extend(section("12. Factories y seeders", "La nueva capa de datos hace que el proyecto pueda probarse sin fixtures manuales dispersos."))
    story.append(subsection("12.1 Factories"))
    story.append(P("Se crearon 20 factories en `database/factories`, con relaciones anidadas y estados válidos para los enums del esquema."))
    factory_rows = [
        ["Identidad", "UserFactory, AdminFactory, TeacherFactory, ApprenticeFactory, AspirantFactory"],
        ["Estructura", "TrainingcenterFactory, AreaFactory, EnvironmentFactory, ProgramFactory, EquipmentFactory"],
        ["Formación", "CourseGroupFactory, CompetitionFactory, ResultFactory, GradeFactory"],
        ["Operación/admisión", "AssignmentFactory, OfferFactory, RegistrationFactory, NewsFactory"],
        ["Pivotes", "CompetitionTeacherFactory, CourseGroupTeacherFactory"],
    ]
    story.append(make_table(["Grupo", "Factories"], factory_rows, [1.55 * inch, PAGE_WIDTH - LEFT - RIGHT - 1.55 * inch]))
    story.append(Spacer(1, 8))
    story.extend(bullets([
        "La resolución global en `AppServiceProvider` permite usar `Model::factory()` para modelos `App\\Dominios` con factories planas.",
        "Las factories respetan la estructura final de `results` y `grades`, uniques, FKs, enums y fechas de oferta.",
        "Los estados permiten construir casos válidos: rol, aprobado/reprobado/pendiente, registro/cancelación, publicación y tipo docente.",
    ]))
    story.append(subsection("12.2 Seeders"))
    story.append(P("Los 20 seeders de dominio se cargan desde `DatabaseSeeder`. Cada uno resuelve sus dependencias y es idempotente mediante `updateOrCreate` o `sync`."))
    seeder_rows = [
        ["Identidad", "UserSeeder, AdminSeeder"],
        ["Estructura", "TrainingCenterSeeder, AreaSeeder, EnvironmentSeeder, ProgramSeeder"],
        ["Personas", "TeacherSeeder, CourseGroupSeeder, ApprenticeSeeder, AspirantSeeder"],
        ["Académico", "CompetitionSeeder, ResultSeeder, GradeSeeder, CompetitionTeacherSeeder"],
        ["Operación/admisión", "EquipmentSeeder, AssignmentSeeder, OfferSeeder, RegistrationSeeder"],
        ["Contenido", "NewsSeeder, CourseGroupTeacherSeeder"],
    ]
    story.append(make_table(["Grupo", "Seeders"], seeder_rows, [1.55 * inch, PAGE_WIDTH - LEFT - RIGHT - 1.55 * inch]))
    story.append(Spacer(1, 8))
    story.append(callout("Credenciales demo", "Todos los usuarios generados por la factory y el seeder usan `12345678`. Ejemplos: `admin@adminsena.com`, `instructor1@adminsena.com`, `aprendiz1@adminsena.com` y `aspirante1@adminsena.com`.", "info"))
    story.append(PageBreak())

    # Quality and risks
    story.extend(section("13. Calidad, riesgos y backlog", "La suite valida la base funcional, pero todavía deben cerrarse algunos riesgos de autorización y publicación."))
    story.append(subsection("13.1 Evidencia de calidad"))
    story.append(metric_strip([("12", "tests"), ("77", "assertions"), ("0", "factories fallidas"), ("2×", "seeder idempotente")]))
    story.append(Spacer(1, 8))
    story.append(make_table(
        ["Comprobación", "Resultado", "Observación"],
        [
            ["Smoke de factories", "Correcto", "Crea una instancia de cada modelo/tabla de dominio"],
            ["DatabaseSeeder", "Correcto", "Carga la cadena de dependencias"],
            ["Idempotencia", "Correcto", "Segunda ejecución conserva conteos"],
            ["Migraciones SQLite", "Correcto", "Rama SQLite de restructuring y enum Cancelada verificadas"],
            ["Suite PHPUnit", "16 / 100", "Ejecutada en SQLite en memoria"],
            ["Pint / Vite", "Correcto", "Formato y build verificados"],
        ],
        [2.1 * inch, 1.3 * inch, PAGE_WIDTH - LEFT - RIGHT - 3.4 * inch],
    ))
    story.append(Spacer(1, 12))
    story.append(subsection("13.2 Riesgos priorizados"))
    risks_rows = [
        ["P0", "Auth", "Authenticate usa route('login') inexistente", "Corregir a auth.login y probar invitados"],
        ["P0", "Seguridad", "CRUD de estructura sin auth/admin", "Envolver grupos con middleware"],
        ["P0", "Registro", "Roles minúsculos y perfiles no creados", "Normalizar y crear perfil en transacción"],
        ["P0", "Binding", "Resource con parámetro/modelo desalineado", "Unificar `{inscripcion}` y el método"],
        ["P0", "Privacidad", "Documentos en disco public", "Disco privado + descarga autorizada"],
        ["P1", "Publicación", "Reglas editoriales entre request, modelo y vista", "Policy de publicación única"],
        ["P1", "Negocio", "Duplicados lógicos sin constraints DB", "Uniques parciales/transacciones"],
        ["P1", "UX/API", "Métricas hardcodeadas y API vacía", "Métricas reales; contratos API"],
    ]
    story.append(make_table(["Prioridad", "Área", "Riesgo", "Acción"], risks_rows, [0.65 * inch, 1.1 * inch, PAGE_WIDTH - LEFT - RIGHT - 5.1 * inch, 3.35 * inch], small=True, header_color=HexColor("#7A2E2E")))
    story.append(PageBreak())

    # Roadmap
    story.extend(section("14. Roadmap recomendado", "Una secuencia de entrega que prioriza seguridad antes de añadir nuevas capacidades."))
    roadmap = [
        ["Fase 1 · Seguridad", "Authenticate, CRUDs, roles/onboarding, binding y documentos privados", "Cerrar accesos indebidos y contratos rotos"],
        ["Fase 2 · Dominio", "Policies, publicación, filtros, uniques, métricas reales y auditoría", "Datos confiables y consistentes"],
        ["Fase 3 · Operación", "Logout/remember, jobs de archivos, reportes, alertas y observabilidad", "Operación mantenible"],
        ["Fase 4 · Entrega", "CI, pruebas navegador, backups, despliegue y documentación", "Release reproducible"],
    ]
    story.append(make_table(["Fase", "Trabajo", "Resultado esperado"], roadmap, [1.6 * inch, PAGE_WIDTH - LEFT - RIGHT - 4.1 * inch, 2.5 * inch], small=True))
    story.append(Spacer(1, 12))
    story.append(callout("Conclusión", "AdminSena ya tiene una arquitectura reconocible y datos de prueba confiables. El siguiente nivel no es maquillar más vistas: es hacer que cada dato, cada ruta y cada documento tenga un contrato de acceso y de publicación claro.", "success"))
    story.append(subsection("14.1 Comandos de referencia"))
    story.append(make_table(
        ["Objetivo", "Comando"],
        [
            ["Desarrollo", "composer install && npm install && php artisan serve"],
            ["Build frontend", "npm run build"],
            ["Suite", "php artisan test --compact"],
            ["Carga completa de demo", "php artisan db:seed --class=DatabaseSeeder"],
            ["Base nueva con demo", "php artisan migrate:fresh --seed"],
            ["Formato", "vendor/bin/pint --test"],
        ],
        [2.3 * inch, PAGE_WIDTH - LEFT - RIGHT - 2.3 * inch],
    ))
    story.append(PageBreak())

    # Appendix
    story.extend(section("15. Anexo de referencia", "Rutas y archivos que conviene conocer para presented el proyecto."))
    story.append(subsection("15.1 Archivos clave"))
    file_rows = [
        ["Routing", "app/Providers/RouteServiceProvider.php"],
        ["Middleware", "app/Http/Kernel.php + app/Http/Middleware/*"],
        ["Modelos", "app/Dominios/*/Models/*.php"],
        ["Controladores", "app/Dominios/*/Controllers/*.php"],
        ["Validación", "app/Dominios/*/Requests/*.php"],
        ["Layout", "resources/views/Layouts/Usuarios/AppAdmin.blade.php"],
        ["Sidebar", "resources/views/Includes/Usuarios/*/Sidebar.blade.php"],
        ["Componentes", "resources/views/components/portal/*.blade.php"],
        ["Factories", "database/factories/*.php"],
        ["Seeders", "database/seeders/*.php"],
        ["Migraciones", "database/migrations/*.php"],
        ["Pruebas", "tests/Feature/*.php"],
    ]
    story.append(make_table(["Área", "Ubicación"], file_rows, [1.55 * inch, PAGE_WIDTH - LEFT - RIGHT - 1.55 * inch], small=True))
    story.append(Spacer(1, 10))
    story.append(subsection("15.2 Glosario exprés"))
    glossary = [
        ["Ficha", "Course_group: grupo de aprendices vinculado a programa y docente"],
        ["Competencia", "Unidad de desempeño con periodo y responsables"],
        ["Resultado", "Result: resultado de aprendizaje de una competencia"],
        ["Grade", "Calificación de un aprendiz para un resultado"],
        ["Oferta", "Convocatoria con programa, capacidad y calendario"],
        ["Inscripción", "Vínculo entre un Aspirante y una Oferta"],
        ["Ámbito", "Datos visibles según rol, ficha o propietario"],
    ]
    story.append(make_table(["Término", "Significado"], glossary, [1.55 * inch, PAGE_WIDTH - LEFT - RIGHT - 1.55 * inch]))
    story.append(Spacer(1, 18))
    story.append(callout("Nota final", "Este documento describe el estado observado del repositorio y no una certificación de producción. Antes de una entrega real, ejecutar pruebas HTTP sobre un entorno aislado, revisar la base migrada y cerrar los riesgos P0/P1 listados.", "warning"))
    return story


def main() -> None:
    OUTPUT.parent.mkdir(parents=True, exist_ok=True)
    doc = NumberedDocTemplate(
        str(OUTPUT),
        pagesize=(PAGE_WIDTH, PAGE_HEIGHT),
        leftMargin=LEFT,
        rightMargin=RIGHT,
        topMargin=TOP,
        bottomMargin=BOTTOM,
        title="AdminSena — Mapa técnico y funcional",
        author="OpenCode",
        subject="Arquitectura, dominios, vistas y funcionalidades de AdminSena",
    )
    # The first PageBreak switches from the cover template to the normal one.
    story = build_story()
    doc.build(story)
    print(f"PDF generado: {OUTPUT}")


if __name__ == "__main__":
    main()
