$(document).ready(function () {
    $('#createUserForm').on('submit', function (e) {
        e.preventDefault();
        var password = $('#password').val();
        var confirmPassword = $('#confirm-password').val();

        if (password !== confirmPassword) {
            var errorHtml = '<ul><li>Passwords do not match.</li></ul>';
            $('#createUserModal .alert-danger').html(errorHtml).show();
            return;
        }
        $.ajax({
            url: createUserUrl,
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    $('#createUserModal').modal('hide');
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function (xhr) {
                var errors = xhr.responseJSON.errors;
                var errorHtml = '<ul>';
                $.each(errors, function (key, value) {
                    errorHtml += '<li>' + value[0] + '</li>';
                });
                errorHtml += '</ul>';
                $('#createUserModal .alert-danger').html(errorHtml).show();
            }
        });
    });

    let initialFormData = {};

    function getFormData($form) {
        let unindexed_array = $form.serializeArray();
        let indexed_array = {};

        $.map(unindexed_array, function (n, i) {
            indexed_array[n['name']] = n['value'];
        });

        return indexed_array;
    }

    function checkFormChanges() {
        let currentFormData = getFormData($('#editUserForm'));
        let isChanged = false;

        for (let key in currentFormData) {
            if (currentFormData[key] !== initialFormData[key]) {
                isChanged = true;
                break;
            }
        }

        $('#edit-submit-btn').prop('disabled', !isChanged);
    }

    $('#editUserForm input').on('input', checkFormChanges);

    $('.edit-user-btn').on('click', function () {
        let userId = $(this).data('id');

        // Load user data via AJAX
        $.ajax({
            url: '/users/' + userId,
            method: 'GET',
            success: function (response) {
                let user = response.user;
                $('#edit-user-id').val(user.id);
                $('#edit-name').val(user.name);
                $('#edit-email').val(user.email);
                $('#edit-password').val('');
                $('#edit-confirm-password').val('');
                initialFormData = getFormData($('#editUserForm'));
                $('#edit-submit-btn').prop('disabled', true);
                $('#editUserModal').modal('show');
            },
            error: function (xhr) {
                alert('Error loading user data');
            }
        });
    });

    $('#editUserForm').on('submit', function (e) {
        e.preventDefault();
        let userId = $('#edit-user-id').val();
        let password = $('#edit-password').val();
        let confirmPassword = $('#edit-confirm-password').val();

        if (password !== confirmPassword) {
            let errorHtml = '<ul><li>Passwords do not match.</li></ul>';
            $('#editUserModal .alert-danger').html(errorHtml).show();
            return;
        }

        let url = updateUserUrl.replace(':id', userId);
        let formData = $(this).serializeArray().filter(function (field) {
            return field.name !== 'confirm-password' && (field.name !== 'password' || field.value !== '');
        });

        $.ajax({
            url: url,
            method: 'PUT',
            data: $.param(formData),
            success: function (response) {
                if (response.success) {
                    console.log('Current Email: ' + response.emails.currentEmail);
                    console.log('New Email: ' + response.emails.newEmail);
                    $('#editUserModal').modal('hide');
                    location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function (xhr) {
                let errors = xhr.responseJSON.errors;
                let errorHtml = '<ul>';
                $.each(errors, function (key, value) {
                    errorHtml += '<li>' + value[0] + '</li>';
                });
                errorHtml += '</ul>';
                $('#editUserModal .alert-danger').html(errorHtml).show();
            }
        });
    });

    var userIdToDelete;

    $('.delete-user-btn').on('click', function () {
        userIdToDelete = $(this).data('id');
        $('#deleteUserModal').modal('show');
    });

    $('#confirmDelete').on('click', function () {
        var url = deleteUserUrl.replace(':id', userIdToDelete);

        $.ajax({
            url: url,
            method: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    $('#deleteUserModal').modal('hide');
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function (xhr) {
                alert('Error: ' + xhr.responseText);
            }
        });
    });
    $('#createUserModal, #editUserModal').on('hidden.bs.modal', function () {
        $(this).find('.alert-danger').html('').hide();
        $(this).find('form')[0].reset();
    });
    $('#createUserModal, #editUserModal').on('show.bs.modal', function () {
        $(this).find('.alert-danger').html('').hide();
    });
    $('.dropdown-item').on('click', function (event) {
        event.preventDefault();
        $('#logout-form').submit();
    });
});
