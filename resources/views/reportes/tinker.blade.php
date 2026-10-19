@extends('layouts.app')

@section('title', 'Actividad 2: 10 Consultas con Tinker')

@section('content')
<div style="display: flex; flex-direction: column; gap: 2rem;">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <div style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;">
                <span class="badge badge-purple"><i class="fa-solid fa-graduation-cap"></i> ACTIVIDAD 2</span>
                <span class="badge badge-success"><i class="fa-solid fa-circle-check"></i> 10/10 Ejecutadas con Éxito</span>
            </div>
            <h1 style="font-size: 2rem; font-weight: 800; color: #ffffff;">10 Consultas con Tinker: Integridad, Colecciones y Agregación</h1>
            <p style="color: var(--text-muted); font-size: 0.95rem;">Comprobación de integridad referencial, reglas de negocio del dominio y funciones analíticas</p>
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <button onclick="window.print()" class="btn-modern btn-secondary">
                <i class="fa-solid fa-print"></i> Imprimir Reporte Oficial
            </button>
        </div>
    </div>

    <!-- Guía de Requisitos de la Actividad 2 -->
    <div class="glass-panel" style="padding: 1.5rem; background: rgba(30, 41, 59, 0.6); border: 1px solid var(--border-accent);">
        <h3 style="font-size: 1.1rem; font-weight: 700; color: #38bdf8; margin-bottom: 0.75rem;">
            <i class="fa-solid fa-clipboard-check"></i> Cobertura de Criterios de Evaluación
        </h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem; font-size: 0.85rem;">
            <div style="background: rgba(15, 23, 42, 0.6); padding: 0.85rem; border-radius: 8px;">
                <div style="font-weight: 700; color: #ffffff; margin-bottom: 0.25rem;">
                    <i class="fa-solid fa-shield-halved" style="color: #ef4444;"></i> Restricciones de Integridad (4)
                </div>
                <p style="color: var(--text-muted);">Consultas 1, 2, 3 y 4: Unicidad (CI), Clave Foránea (Categoría) y Reglas de Dominio (Cupo Lleno y Horario Cruzado).</p>
            </div>
            <div style="background: rgba(15, 23, 42, 0.6); padding: 0.85rem; border-radius: 8px;">
                <div style="font-weight: 700; color: #ffffff; margin-bottom: 0.25rem;">
                    <i class="fa-solid fa-chart-pie" style="color: #f59e0b;"></i> Consultas de Agregación (3)
                </div>
                <p style="color: var(--text-muted);">Consultas 5, 6 y 9: Funciones COUNT, SUM, AVG, con cláusulas HAVING y conteo condicional con relaciones.</p>
            </div>
            <div style="background: rgba(15, 23, 42, 0.6); padding: 0.85rem; border-radius: 8px;">
                <div style="font-weight: 700; color: #ffffff; margin-bottom: 0.25rem;">
                    <i class="fa-solid fa-layer-group" style="color: #10b981;"></i> Laravel Collections & Eager Loading (3)
                </div>
                <p style="color: var(--text-muted);">Consultas 7, 8 y 10: Métodos filter(), groupBy(), map(), sortByDesc() y auditoría jerárquica integral.</p>
            </div>
        </div>
    </div>

    <!-- Lista de Consultas -->
    <div style="display: flex; flex-direction: column; gap: 1.75rem;">
        @foreach($consultas as $c)
            <div class="glass-panel" style="padding: 2rem; border-left: 5px solid {{ $c['numero'] <= 4 ? '#ef4444' : ($c['numero'] <= 6 ? '#f59e0b' : '#10b981') }};">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1rem;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.35rem;">
                            <span class="badge" style="background: rgba(255, 255, 255, 0.1); color: #ffffff; font-weight: 800; font-size: 0.85rem;">
                                Consulta #{{ $c['numero'] }}
                            </span>
                            <span class="badge {{ $c['numero'] <= 4 ? 'badge-danger' : ($c['numero'] <= 6 ? 'badge-warning' : 'badge-success') }}">
                                {{ $c['tipo'] }}
                            </span>
                        </div>
                        <h2 style="font-size: 1.35rem; font-weight: 800; color: #ffffff;">{{ $c['titulo'] }}</h2>
                    </div>
                </div>

                <!-- Código Ejecutado -->
                <div style="margin-bottom: 1.25rem;">
                    <div style="font-size: 0.8rem; font-weight: 700; color: var(--text-dim); text-transform: uppercase; margin-bottom: 0.4rem;">
                        <i class="fa-solid fa-code"></i> Comando / Consulta Ejecutada en Tinker:
                    </div>
                    <pre style="background: #050811; padding: 1.25rem; border-radius: 10px; border: 1px solid var(--border-glass); color: #38bdf8; font-family: 'Consolas', 'Courier New', monospace; font-size: 0.85rem; overflow-x: auto; line-height: 1.5;"><code>{{ $c['comando'] }}</code></pre>
                </div>

                <!-- Salida Real de Tinker -->
                <div style="margin-bottom: 1.25rem;">
                    <div style="font-size: 0.8rem; font-weight: 700; color: var(--text-dim); text-transform: uppercase; margin-bottom: 0.4rem;">
                        <i class="fa-solid fa-terminal"></i> Resultado y Salida Obtenida (Output):
                    </div>
                    <pre style="background: #030712; padding: 1.25rem; border-radius: 10px; border: 1px solid rgba(16, 185, 129, 0.2); color: #34d399; font-family: 'Consolas', 'Courier New', monospace; font-size: 0.825rem; overflow-x: auto; line-height: 1.45; max-height: 380px;"><code>{{ $c['salida'] }}</code></pre>
                </div>

                <!-- Justificación Técnica -->
                <div style="background: rgba(15, 23, 42, 0.7); padding: 1rem 1.25rem; border-radius: 10px; border: 1px solid var(--border-glass);">
                    <div style="font-size: 0.8rem; font-weight: 700; color: #818cf8; text-transform: uppercase; margin-bottom: 0.35rem;">
                        <i class="fa-solid fa-lightbulb"></i> Justificación Técnica y Aspecto de Integridad Validado:
                    </div>
                    <p style="font-size: 0.875rem; color: #e2e8f0; line-height: 1.6;">
                        {{ $c['justificacion'] }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
