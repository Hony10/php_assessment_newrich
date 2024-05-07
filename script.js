$(document).ready(function() {
    function addFormField(fieldName, fieldType, options) {
        var formGroup = $('<div class="form-group"></div>');
        formGroup.append('<label for="' + fieldName + '">' + fieldName + ':</label>');

        // Add input based on field type
        switch (fieldType) {
            case 'text':
                formGroup.append('<input type="text" class="form-control" id="' + fieldName + '" name="' + fieldName + '">');
                break;
            case 'email':
                formGroup.append('<input type="email" class="form-control" id="' + fieldName + '" name="' + fieldName + '">');
                break;
            case 'textarea':
                formGroup.append('<textarea class="form-control" id="' + fieldName + '" name="' + fieldName + '"></textarea>');
                break;
            case 'select':
                var select = $('<select class="form-control" id="' + fieldName + '" name="' + fieldName + '"></select>');
                select.append('<option value="">Select ' + fieldName + '</option>');
                // Add options if provided
                if (options && options.length > 0) {
                    $.each(options, function(index, option) {
                        select.append('<option value="' + option.value + '">' + option.label + '</option>');
                    });
                }
                formGroup.append(select);
                break;
            case 'checkbox':
                formGroup.append('<div class="form-check"><input class="form-check-input" type="checkbox" id="' + fieldName + '" name="' + fieldName + '"><label class="form-check-label" for="' + fieldName + '">' + fieldName + '</label></div>');
                break;
            case 'radio':
                // Add radio options if provided
                if (options && options.length > 0) {
                    $.each(options, function(index, option) {
                        var radioDiv = $('<div class="form-check"></div>');
                        radioDiv.append('<input class="form-check-input" type="radio" id="' + fieldName + index + '" name="' + fieldName + '" value="' + option.value + '">');
                        radioDiv.append('<label class="form-check-label" for="' + fieldName + index + '">' + option.label + '</label>');
                        formGroup.append(radioDiv);
                    });
                }
                break;
            // Add more cases for other field types if needed
        }

        // Append form group to dynamic form
        $('#dynamicForm').append(formGroup);
    }

    $.ajax({
        url: 'get_form_fields.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            $.each(response.fields, function(fieldName, fieldData) {
                addFormField(fieldName, fieldData.type, fieldData.options);
            });
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });

    function validateForm() {

        $('.error-message').remove();
        var isValid = true;
        var validationRules = {
            'name': 'required',
            'email': 'required|email',
            'message': 'required',
            'gender': 'required',
        };

        $.each(validationRules, function(fieldName, rule) {
            var fieldValue = $('#' + fieldName).val();
            var validationArray = rule.split('|');
            $.each(validationArray, function(index, validation) {
                if (validation === 'required' && !fieldValue) {
                    $('#' + fieldName).after('<div class="error-message">This field is required</div>');
                    isValid = false;
                } else if (validation === 'email' && !isValidEmail(fieldValue)) {
                    $('#' + fieldName).after('<div class="error-message">Invalid email format</div>');
                    isValid = false;
                }
            });
        });

        return isValid;
    }

    function isValidEmail(email) {

        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    $('#dynamicForm').on('submit', function(event) {

        event.preventDefault();
        var subscribeValue = $('#subscribe').is(':checked') ? 1 : 0;
        $(this).append('<input type="hidden" name="subscribe" value="' + subscribeValue + '">');

        var isValid = validateForm();

        if (isValid) {
            $.ajax({
                url: 'save_end_point.php',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {

                    if (response.success) {
                        alert('Form submitted successfully!');
                        window.location.href = "/test/display_list.php";
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', xhr.responseText);
                    alert('An error occurred while submitting the form. Please try again later.');
                }
            });
        }
    });
});
