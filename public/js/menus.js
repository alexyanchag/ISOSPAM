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
});
