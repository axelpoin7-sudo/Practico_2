@extends('layouts.app')

@section('title', 'Instructores')

@section('content')
<div style="display: flex; flex-direction: column; gap: 1.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 1.75rem; font-weight: 800;">Planta Docente & Instructores</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Especialistas capacitadores certificados en sus respectivas áreas</p>
        </div>
        <a href="{{ route('instructores.create') }}" class="btn-modern btn-primary">
            <i class="fa-solid fa-user-plus"></i> Registrar Instructor
        </a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.5rem;">
        @foreach($instructores as $instructor)
            <div class="glass-panel" style="padding: 1.75rem; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 1rem;">
                        <div style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #38bdf8, #818cf8); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.2rem; color: #ffffff;">
                            {{ substr($instructor->nombres, 0, 1) }}{{ substr($instructor->apellidos, 0, 1) }}
                        </div>
                        <div>
                            <h2 style="font-size: 1.15rem; font-weight: 700; color: #ffffff;">{{ $instructor->nombre_completo }}</h2>
                            <span class="badge badge-purple" style="font-size: 0.7rem;">
                                <i class="fa-solid fa-certificate"></i> {{ $instructor->especialidad }}
                            </span>
                        </div>
                    </div>

                    <p style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 1.25rem;">
                        {{ Str::limit($instructor->biografia, 100) }}
                    </p>

                    <div style="display: flex; flex-direction: column; gap: 0.35rem; font-size: 0.8rem; color: var(--text-dim); margin-bottom: 1rem;">
                        <div><i class="fa-solid fa-id-card"></i> CI: <span style="color: #cbd5e1;">{{ $instructor->documento_identidad }}</span></div>
                        <div><i class="fa-solid fa-envelope"></i> Email: <span style="color: #cbd5e1;">{{ $instructor->email }}</span></div>
                        <div><i class="fa-solid fa-phone"></i> Teléfono: <span style="color: #cbd5e1;">{{ $instructor->telefono }}</span></div>
                        <div><i class="fa-solid fa-award"></i> Experiencia: <span style="color: #38bdf8; font-weight: 600;">{{ $instructor->experiencia_anos }} años</span></div>
                    </div>
                </div>

                <div style="border-top: 1px solid var(--border-glass); padding-top: 1rem; display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.8rem; color: var(--text-dim);">
                        <i class="fa-solid fa-book"></i> {{ $instructor->cursos_count }} Cursos Asignados
                    </span>
                    <a href="{{ route('instructores.show', $instructor) }}" class="btn-modern btn-secondary" style="padding: 0.45rem 0.9rem; font-size: 0.8rem;">
                        Perfil Completo &rarr;
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
