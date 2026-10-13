<div class="card mb-3 infra-context-card">
    <div class="card-header bg-gris text-white">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
            <div>
                <h1 class="infra-page-title">{{ $title }}</h1>
                <p class="infra-page-subtitle">{{ $subtitle }}</p>
            </div>
            @isset($context)
                <span class="badge badge-light mt-1">{{ $context }}</span>
            @endisset
        </div>
    </div>
    <div class="card-body py-3">
        <ol class="infra-steps" aria-label="Progreso de la operación">
            @foreach ($steps as $index => $step)
                <li class="infra-step {{ $index + 1 === $activeStep ? 'active' : '' }} {{ $index + 1 < $activeStep ? 'complete' : '' }}">
                    <span class="infra-step-number">{{ $index + 1 }}</span>
                    <span>{{ $step }}</span>
                </li>
            @endforeach
        </ol>
    </div>
</div>
