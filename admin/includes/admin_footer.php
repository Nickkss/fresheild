    </div> <!-- End content-wrapper -->
</div> <!-- End main-content -->

</div> <!-- End wrapper -->

<!-- Bootstrap 5 JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery (for easier AJAX and DOM manipulation) -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- Custom Admin Scripts -->
<script>
    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        $('.alert:not(.alert-permanent)').fadeOut('slow', function() {
            $(this).remove();
        });
    }, 5000);

    // Confirm delete actions
    $('.btn-delete, .delete-btn').on('click', function(e) {
        if (!confirm('정말 삭제하시겠습니까? 이 작업은 되돌릴 수 없습니다.')) {
            e.preventDefault();
            return false;
        }
    });

    // Form validation helper
    $('form[data-validate]').on('submit', function(e) {
        let valid = true;
        $(this).find('[required]').each(function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                valid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (!valid) {
            e.preventDefault();
            alert('필수 항목을 모두 입력해주세요.');
            return false;
        }
    });

    // Remove is-invalid class on input
    $('.form-control, .form-select').on('input change', function() {
        $(this).removeClass('is-invalid');
    });
</script>

</body>
</html>
