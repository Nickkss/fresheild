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

<!-- Admin Footer Version Info -->
<footer class="admin-version-footer" style="position: fixed; bottom: 0; right: 0; padding: 8px 16px; background: rgba(255,255,255,0.95); border-top: 1px solid #e0e0e0; border-left: 1px solid #e0e0e0; border-top-left-radius: 8px; font-size: 11px; color: #666; z-index: 1000; box-shadow: -2px -2px 10px rgba(0,0,0,0.05);">
    <span style="font-weight: 500; color: #333;">Freshield CMS</span>
    <span style="color: #2c3e50;"><?php echo defined('APP_VERSION') ? APP_VERSION : 'v1.0'; ?></span>
    <span style="color: #999;">— Built 2025</span>
</footer>

</body>
</html>
