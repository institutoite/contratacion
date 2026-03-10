<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unete al equipo</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/brand-theme.css') }}" rel="stylesheet">
    <style>
        .landing-wrap {
            min-height: 100vh;
            background:
                radial-gradient(circle at 12% 8%, rgba(38, 186, 165, 0.16), transparent 38%),
                radial-gradient(circle at 88% 14%, rgba(55, 95, 122, 0.18), transparent 40%),
                linear-gradient(180deg, rgba(38, 186, 165, 0.06) 0%, #ffffff 44%, #f6f7f8 100%);
        }

        .hero {
            min-height: 78vh;
            display: flex;
            align-items: center;
        }

        .pill-tag {
            display: inline-flex;
            align-items: center;
            padding: 0.4rem 0.9rem;
            border-radius: 999px;
            font-size: 0.77rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #ffffff;
            background: linear-gradient(135deg, rgb(55, 95, 122), rgb(38, 186, 165));
        }

        .hero-title {
            font-size: clamp(2rem, 5vw, 3.6rem);
            line-height: 1.1;
            font-weight: 700;
            color: #0f1720;
        }

        .hero-subtitle {
            color: #5f6770;
            max-width: 64ch;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.85rem;
            margin-top: 1.4rem;
        }

        .stat-card {
            padding: 0.95rem;
            border: 1px solid rgba(55, 95, 122, 0.18);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.85);
        }

        .stat-value {
            font-weight: 700;
            color: rgb(55, 95, 122);
            margin-bottom: 0.15rem;
        }

        .hero-panel {
            border-radius: 20px;
            border: 1px solid rgba(55, 95, 122, 0.2);
            background: rgba(255, 255, 255, 0.84);
            box-shadow: 0 18px 40px rgba(55, 95, 122, 0.16);
        }

        .section-card {
            border-radius: 18px;
            border: 1px solid rgba(55, 95, 122, 0.2);
            background: #ffffff;
            box-shadow: 0 12px 30px rgba(55, 95, 122, 0.12);
        }

        .modal-backdrop-custom {
            position: fixed;
            inset: 0;
            background: rgba(14, 28, 37, 0.6);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1050;
            padding: 1rem;
        }

        .modal-backdrop-custom.open {
            display: flex;
        }

        .custom-modal {
            width: 100%;
            max-width: 780px;
            max-height: 90vh;
            overflow-y: auto;
            border-radius: 16px;
            border: 1px solid rgba(55, 95, 122, 0.22);
            background: #ffffff;
            box-shadow: 0 20px 50px rgba(16, 34, 45, 0.35);
        }

        @media (max-width: 992px) {
            .hero {
                min-height: auto;
                padding-top: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="landing-wrap">
        <header class="hero container py-5 py-lg-4">
            <div class="row align-items-center g-4 g-lg-5 w-100">
                <div class="col-lg-7">
                    <span class="pill-tag mb-3">Convocatoria institucional</span>
                    <h1 class="hero-title mb-3">Construye tu carrera en una institucion educativa enfocada en excelencia.</h1>
                    <p class="hero-subtitle mb-4">
                        Si quieres crecer en un entorno profesional y ordenado, registra tu postulación y elige una fecha y hora de entrevista
                        entre los espacios habilitados por nuestro equipo.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-primary px-4" type="button" data-open-apply>Quiero trabajar</button>
                        @auth
                            <a href="{{ route('applicants.index') }}" class="btn btn-outline-primary">Ir al panel</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-primary">Login administrador</a>
                        @endauth
                    </div>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-value">Proceso claro</div>
                            <small class="text-body-secondary">Registro digital y agenda transparente</small>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value">Seleccion objetiva</div>
                            <small class="text-body-secondary">Evaluacion por perfil y compromiso</small>
                        </div>
                        <div class="stat-card">
                            <div class="stat-value">Entorno profesional</div>
                            <small class="text-body-secondary">Cultura de mejora y aprendizaje continuo</small>
                        </div>
                    </div>
                    @if(session('success'))
                        <div class="alert alert-success mt-4 mb-0">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-app mt-4 mb-0">
                            <strong>Revisa los datos del formulario:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="col-lg-5">
                    <div class="hero-panel p-4 p-lg-5">
                        <h2 class="h4 fw-semibold mb-3">Nuestra propuesta</h2>
                        <ul class="ps-3 mb-0 text-body-secondary">
                            <li>Ambiente institucional con estandares altos.</li>
                            <li>Equipos colaborativos y metas medibles.</li>
                            <li>Oportunidades de crecimiento por desempeno.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <section class="container pb-5">
            <div class="section-card p-4 p-md-5">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                    <h2 class="h3 mb-0">Registro directo de entrevista</h2>
                    <small class="text-body-secondary">Tambien disponible desde el boton "Quiero trabajar".</small>
                </div>
                @include('partials.application-form', ['prefix' => 'fixed'])
            </div>
        </section>
    </div>

    <div class="modal-backdrop-custom" id="applyModal" aria-hidden="true">
        <div class="custom-modal p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h4 mb-0">Registro rapido</h2>
                <button type="button" class="btn btn-sm btn-outline-primary" data-close-apply>Cerrar</button>
            </div>
            @include('partials/application-form', ['prefix' => 'modal'])
        </div>
    </div>

    <script>
        (function () {
            const modal = document.getElementById('applyModal');
            const openButtons = document.querySelectorAll('[data-open-apply]');
            const closeButtons = document.querySelectorAll('[data-close-apply]');

            function openModal() {
                modal.classList.add('open');
                modal.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            }

            function closeModal() {
                modal.classList.remove('open');
                modal.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
            }

            openButtons.forEach((btn) => btn.addEventListener('click', openModal));
            closeButtons.forEach((btn) => btn.addEventListener('click', closeModal));

            modal.addEventListener('click', (event) => {
                if (event.target === modal) {
                    closeModal();
                }
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && modal.classList.contains('open')) {
                    closeModal();
                }
            });
        })();
    </script>
</body>
</html>


