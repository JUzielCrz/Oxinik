(function (window, $) {
    'use strict';

    window.infraHasUnsavedChanges = false;
    window.infraNavigationLocked = false;

    function continuarNavegacion(url) {
        window.infraNavigationLocked = true;
        window.location.href = url;
    }

    function confirmarSalida(url) {
        if (!window.infraHasUnsavedChanges) {
            continuarNavegacion(url);
            return;
        }

        Swal.fire({
            icon: 'warning',
            title: 'Tienes cambios sin guardar',
            text: 'Si sales ahora perderás los cilindros capturados.',
            showCancelButton: true,
            confirmButtonColor: '#F9C846',
            cancelButtonColor: '#329F5B',
            confirmButtonText: 'Salir sin guardar',
            cancelButtonText: 'Continuar aquí'
        }).then(function (result) {
            if (result.isConfirmed) {
                continuarNavegacion(url);
            }
        });
    }

    window.salir_pagina = function (event, url) {
        if (event) {
            event.preventDefault();
        }
        confirmarSalida(url || (event && event.currentTarget ? event.currentTarget.href : window.location.href));
    };

    window.infraSetUnsavedChanges = function (hasChanges) {
        window.infraHasUnsavedChanges = Boolean(hasChanges);
    };

    window.addEventListener('beforeunload', function (event) {
        if (window.infraHasUnsavedChanges && !window.infraNavigationLocked) {
            event.preventDefault();
            event.returnValue = '';
        }
    });

    $(document).on('click', 'a[href]', function (event) {
        var href = $(this).attr('href');

        if (event.isDefaultPrevented() || !window.infraHasUnsavedChanges || window.infraNavigationLocked ||
            !href || href.charAt(0) === '#' || $(this).attr('target') === '_blank' ||
            $(this).attr('download') !== undefined) {
            return;
        }

        event.preventDefault();
        confirmarSalida(href);
    });
}(window, jQuery));
