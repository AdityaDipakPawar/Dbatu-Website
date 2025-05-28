$(document).ready(function() {
    // Form submission handler
    function handleFormSubmit(formId, url) {
        $(formId).on('submit', function(e) {
            e.preventDefault();
            
            const $form = $(this);
            const $submitBtn = $form.find('button[type="submit"]');
            const $message = $form.find('.form-message');
            
            // Disable submit button and show loading state
            $submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');
            
            $.ajax({
                type: 'POST',
                url: url,
                data: $form.serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $message
                            .removeClass('error')
                            .addClass('success')
                            .html(response.message)
                            .slideDown();
                            
                        if (url === 'login.php') {
                            setTimeout(() => window.location.reload(), 1500);
                        } else {
                            setTimeout(() => {
                                $('#registerModal').modal('hide');
                                $('#loginModal').modal('show');
                            }, 1500);
                        }
                    } else {
                        $message
                            .removeClass('success')
                            .addClass('error')
                            .html(response.message)
                            .slideDown();
                    }
                },
                error: function() {
                    $message
                        .removeClass('success')
                        .addClass('error')
                        .html('An error occurred. Please try again.')
                        .slideDown();
                },
                complete: function() {
                    // Re-enable submit button and restore text
                    $submitBtn.prop('disabled', false).text(url === 'login.php' ? 'Login' : 'Create Account');
                }
            });
        });
    }

    // Initialize form handlers
    handleFormSubmit('#loginForm', 'login.php');
    handleFormSubmit('#registerForm', 'register.php');

    // Clear messages when modals are hidden
    $('.auth-modal').on('hidden.bs.modal', function() {
        $(this).find('.form-message').hide().empty();
        $(this).find('form')[0].reset();
    });
}); 