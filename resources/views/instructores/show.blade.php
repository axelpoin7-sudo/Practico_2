@extends('layouts.app')

@section('title', 'Instructor: ' . $instructor->nombre_completo)

@section('content')
<div style="display: flex; flex-direction: column; gap: 2rem;">
    <div>
        <a href="{{ route('instructores.index') }}" style="color: var(--text-dim); text-decoration: none; font-size: 0.85rem;">
            <i class="fa-solid fa-arrow-left"></i> Volver a instructores
        </a>
    </div>

    <!-- Perfil Header -->
    <div class="glass-panel" style="padding: 2rem; display: flex; gap: 2rem; align-items: center; flex-wrap: wrap;">
        <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #38bdf8, #818cf8); display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 800; color: #ffffff;">
            {{ substr($instructor->nombres, 0, 1) }}{{ substr($instructor->apellidos, 0, 1) }}
        </div>
        <div style="flex: 1;">
            <div style="display: flex; gap: 0.75rem; align-items: center; margin-bottom: 0.5rem;">
                <h1 style="font-size: 1.85rem; font-weight: 800; color: #ffffff;">{{ $instructor->nombre_completo }}</h1>
                <span class="badge badge-success"><i class="fa-solid fa-check"></i> Activo</span>
            </div>
            <p style="color: #38bdf8; font-weight: 600; font-size: 1rem; margin-bottom: 0.5rem;">
                <i class="fa-solid fa-certificate"></i> {{ $instructor->especialidad }}
            </p>
            <p style="color: var(--text-muted); font-size: 0.9rem; max-width: 800px; line-height: 1.6;">
                {{ $instructor->biografia ?? 'Docente acreditado con sólida experiencia profesional en la materia.' }}
            </p>
        </div>
        <div style="display: flex; flex-direction: column; gap: 0.5rem; border-left: 1px solid var(--border-glass); padding-left: 2rem; font-size: 0.85rem; color: var(--text-muted);">
            <div><i class="fa-solid fa-id-card"></i> CI: <strong style="color: #ffffff;">{{ $instructor->documento_identidad }}</strong></div>
            <div><i class="fa-solid fa-envelope"></i> <strong style="color: #ffffff;">{{ $instructor->email }}</strong></div>
            <div><i class="fa-solid fa-phone"></i> <strong style="color: #ffffff;">{{ $instructor->telefono }}</strong></div>
            <div><i class="fa-solid fa-business-time"></i> Experiencia: <strong style="color: #38bdf8;">{{ $instructor->experiencia_anos }} años</strong></div>
        </div>
    </div>

    <!-- Cursos a su cargo -->
    <div>
        <h2 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 1.25rem;">Cursos a su Cargo ({{ $instructor->cursos->count() }})</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.5rem;">
            @forelse($instructor->cursos as $curso)
                <div class="glass-panel" style="padding: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                        <span class="badge" style="background: {{ $curso->categoria->color ?? '#38bdf8' }}20; color: {{ $curso->categoria->color ?? '#38bdf8' }};">
                            {{ $curso->categoria->nombre ?? 'General' }}
                        </span>
                        <span class="badge badge-info">{{ $curso->codigo }}</span>
                    </div>
                    <h3 style="font-size: 1.15rem; font-weight: 700; margin-bottom: 0.5rem; color: #ffffff;">{{ $curso->nombre }}</h3>
                    <p style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 1rem;">
                        {{ Str::limit($curso->descripcion, 90) }}
                    </p>
                    <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border-glass); padding-top: 0.75rem;">
                        <span style="font-weight: 700; color: #34d399;">Bs. {{ number_format($curso->costo, 2) }}</span>
                        <a href="{{ route('cursos.show', $curso) }}" class="btn-modern btn-secondary" style="font-size: 0.8rem; padding: 0.4rem 0.8rem;">
                            Ver Curso
                        </a>
                    </div>
                </div>
            @empty
                <div class="glass-panel" style="grid-column: 1 / -1; padding: 2.5rem; text-align: center; color: var(--text-dim);">
                    El instructor no tiene cursos asignados actualmente.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
