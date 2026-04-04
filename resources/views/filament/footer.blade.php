<div class="w-full text-center text-xs text-gray-400 py-2">
    {{ \App\Models\Empresa::actual()?->nombre_comercial ?? 'SigaWeb' }}
    &mdash; v{{ config('app.version') }} &mdash; {{ date('Y') }}
</div>
