document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.menu-toggle').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const target = document.querySelector(this.dataset.target);
            if (target) {
                target.classList.toggle('d-none');
                this.textContent = target.classList.contains('d-none') ? '+' : '-';
            }
        });
    });

    document.querySelectorAll('.delete-menu-btn').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('form');
            Swal.fire({
                title: '¿Eliminar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then(result => {
                if (result.isConfirmed) {
                    document.querySelector('.spinner-overlay').classList.remove('d-none');
                    form.submit();
                } else {
                    document.querySelector('.spinner-overlay').classList.add('d-none');
                }
            });
        });
    });
});
