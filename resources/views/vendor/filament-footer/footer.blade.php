<div id="filament-footer" style="position: fixed; bottom: 0; left: 0; right: 0; z-index: 50; width: 100%; text-align: center; padding: 6px 0; border-top: 1px solid #e5e7eb; backdrop-filter: blur(4px);">
    <p style="font-size: 0.7rem; margin: 0; line-height: 1.4;">
        {{ \App\Models\Empresa::actual()?->nombre_comercial ?? config('app.name') }}
        &mdash; v{{ config('app.version') }} &mdash; {{ date('Y') }}
    </p>
    <p style="font-size: 0.7rem; margin: 0; line-height: 1.4;">
        {!! __('filament-footer::footer.copyright_message', [
            'app_name' => config('app.name', 'Portal'),
            'company_name' => config('filament-footer.company_name', 'Tapp Network'),
            'company_link' => '<a href="' . config('filament-footer.company_url', 'https://tappnetwork.com') . '" target="_blank" style="text-decoration: underline;">' . __('filament-footer::footer.company_link_text', ['company_name' => config('filament-footer.company_name', 'Tapp Network')]) . '</a>',
            'year' => date('Y'),
        ]) !!}
    </p>
</div>

<script>
(function () {
    function applyFooterTheme() {
        const footer = document.getElementById('filament-footer');
        if (!footer) return;
        const isDark = document.documentElement.classList.contains('dark');
        if (isDark) {
            footer.style.background = 'rgba(17,24,39,0.92)';
            footer.style.borderTopColor = '#374151';
            footer.style.color = '#9ca3af';
        } else {
            footer.style.background = 'rgba(243,244,246,0.95)';
            footer.style.borderTopColor = '#d1d5db';
            footer.style.color = '#6b7280';
        }
    }

    applyFooterTheme();

    const observer = new MutationObserver(applyFooterTheme);
    observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
})();
</script>
