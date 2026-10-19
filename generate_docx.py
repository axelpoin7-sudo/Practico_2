import json
import zipfile
import html

# Leer los datos de las 10 consultas generadas
with open('storage/app/tinker_actividad2.json', 'r', encoding='utf-8') as f:
    consultas = json.load(f)

def escape_xml(text):
    return html.escape(str(text))

def build_p(text, bold=False, italic=False, size=22, color="1E293B", space_after=120):
    b_tag = "<w:b/>" if bold else ""
    i_tag = "<w:i/>" if italic else ""
    return f"""<w:p>
        <w:pPr>
            <w:spacing w:after="{space_after}"/>
        </w:pPr>
        <w:r>
            <w:rPr>
                <w:rFonts w:ascii="Segoe UI" w:hAnsi="Segoe UI"/>
                {b_tag}
                {i_tag}
                <w:color w:val="{color}"/>
                <w:sz w:val="{size}"/>
            </w:rPr>
            <w:t xml:space="preserve">{escape_xml(text)}</w:t>
        </w:r>
    </w:p>"""

def build_code_block(code_text, bg="0F172A", text_color="38BDF8"):
    paragraphs = []
    lines = code_text.split("\n")
    for line in lines:
        p = f"""<w:p>
            <w:pPr>
                <w:pBdr>
                    <w:left w:val="single" w:sz="12" w:space="4" w:color="38BDF8"/>
                </w:pBdr>
                <w:shd w:val="clear" w:color="auto" w:fill="{bg}"/>
                <w:spacing w:after="40" w:line="240" w:lineRule="auto"/>
            </w:pPr>
            <w:r>
                <w:rPr>
                    <w:rFonts w:ascii="Consolas" w:hAnsi="Consolas"/>
                    <w:color w:val="{text_color}"/>
                    <w:sz w:val="18"/>
                </w:rPr>
                <w:t xml:space="preserve">{escape_xml(line)}</w:t>
            </w:r>
        </w:p>"""
        paragraphs.append(p)
    return "".join(paragraphs)

doc_body = []

# Caratula y Encabezado
doc_body.append(build_p("ACTIVIDAD 2: COMPROBACIÓN DE INTEGRIDAD EN BASE DE DATOS Y CONSULTAS CON TINKER", bold=True, size=36, color="0284C7", space_after=200))
doc_body.append(build_p("Caso de Estudio: Plataforma de Inscripción a Cursos de Capacitación", bold=True, size=26, color="0F172A", space_after=100))
doc_body.append(build_p("Áreas Formativas: Ofimática, Programación y Diseño", italic=True, size=22, color="64748B", space_after=80))
doc_body.append(build_p("Framework: Laravel 11.x | Motor: SQLite/MySQL | Fecha: 19 de Octubre de 2026", size=20, color="64748B", space_after=300))

# Seccion 1
doc_body.append(build_p("1. RESUMEN DE REGLAS DE NEGOCIO E INTEGRIDAD", bold=True, size=28, color="0F172A", space_after=140))
doc_body.append(build_p("• Rechazo por Cupo Lleno: El sistema bloquea de manera automática cualquier solicitud de matrícula cuando el número de inscritos activos alcanza o supera el aforo máximo permitido en el paralelo (validado con el paralelo PAR-OFI-01A con cupo 4/4).", size=22, space_after=80))
doc_body.append(build_p("• Prevención de Horarios Cruzados: El sistema impide que un alumno se inscriba simultáneamente en dos paralelos que compartan el mismo rango de fechas, los mismos días de la semana y cuyo horario se solape en horas.", size=22, space_after=80))
doc_body.append(build_p("• Integridad Referencial y Unicidad: Claves foráneas estrictas entre Categorías, Cursos, Instructores, Paralelos e Inscripciones, con índices únicos en Documento de Identidad y clave compuesta participante_id + paralelo_id.", size=22, space_after=240))

# Seccion 2: Las 10 consultas
doc_body.append(build_p("2. DESARROLLO Y SALIDA DE LAS 10 CONSULTAS EN TINKER", bold=True, size=28, color="0F172A", space_after=200))

for c in consultas:
    num = c["numero"]
    tipo = c["tipo"]
    titulo = c["titulo"]
    comando = c["comando"]
    salida = c["salida"]
    justificacion = c["justificacion"]

    badge_color = "DC2626" if num <= 4 else ("D97706" if num <= 6 else "059669")

    doc_body.append(build_p(f"CONSULTA #{num}: {titulo}", bold=True, size=24, color="0F172A", space_after=60))
    doc_body.append(build_p(f"Categoría: {tipo}", bold=True, italic=True, size=20, color=badge_color, space_after=100))
    
    doc_body.append(build_p("Comando Ejecutado en Tinker (php artisan tinker):", bold=True, size=20, color="0284C7", space_after=60))
    doc_body.append(build_code_block(comando, bg="0F172A", text_color="38BDF8"))
    
    doc_body.append(build_p("Resultado Obtenido (Output Real):", bold=True, size=20, color="059669", space_after=60))
    doc_body.append(build_code_block(salida, bg="030712", text_color="6EE7B7"))
    
    doc_body.append(build_p("Justificación Técnica y Aspecto de Integridad Validado:", bold=True, size=20, color="475569", space_after=60))
    doc_body.append(build_p(justificacion, italic=False, size=21, color="1E293B", space_after=260))

# Document XML template
document_xml = f"""<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:document xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">
    <w:body>
        {''.join(doc_body)}
        <w:sectPr>
            <w:pgSz w:w="12240" w:h="15840"/>
            <w:pgMar w:top="1440" w:right="1440" w:bottom="1440" w:left="1440"/>
        </w:sectPr>
    </w:body>
</w:document>"""

content_types_xml = """<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
    <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
    <Default Extension="xml" ContentType="application/xml"/>
    <Override PartName="/word/document.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.document.main+xml"/>
</Types>"""

rels_xml = """<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
    <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="word/document.xml"/>
</Relationships>"""

# Guardar en DOCUMENTO_ACTIVIDAD_2_TINKER.docx
docx_path = "DOCUMENTO_ACTIVIDAD_2_TINKER.docx"
with zipfile.ZipFile(docx_path, 'w', compression=zipfile.ZIP_DEFLATED) as docx:
    docx.writestr('[Content_Types].xml', content_types_xml)
    docx.writestr('_rels/.rels', rels_xml)
    docx.writestr('word/document.xml', document_xml)

print(f"Documento Word generado exitosamente: {docx_path}")
