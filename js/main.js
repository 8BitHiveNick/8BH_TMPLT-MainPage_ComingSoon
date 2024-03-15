$(document).ready(function() {
    $('#contactForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: 'send_mail.php',
            data: formData + '&g-recaptcha-response=' + grecaptcha.getResponse(),
            dataType: 'json',
            success: function(response) {
                $('#contactForm').trigger("reset"); // Reset form
                if (response.success) {
                    $('#successModal').modal('show'); // Show success modal
                    setTimeout(function() {
                        $('#successModal').modal('hide'); // Hide modal after 5 seconds
                    }, 5000);
                } else {
                    $('#failureModal').modal('show'); // Show failure modal
                    setTimeout(function() {
                        $('#failureModal').modal('hide'); // Hide modal after 5 seconds
                    }, 5000);
                }
            },
            error: function() {
                $('#failureModal').modal('show'); // Show failure modal on AJAX error
                setTimeout(function() {
                    $('#failureModal').modal('hide'); // Hide modal after 5 seconds
                }, 5000);
            }
        });
    });
});
