document.addEventListener('DOMContentLoaded', function () {
    function hideChildren(id) {
        document.querySelectorAll(`.parent-${id}`).forEach(row => {
            row.classList.add('d-none');
            const toggle = row.querySelector('.menu-toggle');
            if (toggle) toggle.textContent = '+';
            hideChildren(row.dataset.menuId);
        });
    }

    document.querySelectorAll('.menu-toggle').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            const children = document.querySelectorAll(`.parent-${id}`);
            if (children.length === 0) return;
            const anyVisible = Array.from(children).some(row => !row.classList.contains('d-none'));
            if (anyVisible) {
                hideChildren(id);
                this.textContent = '+';
            } else {
                children.forEach(row => row.classList.remove('d-none'));
                this.textContent = '-';
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
