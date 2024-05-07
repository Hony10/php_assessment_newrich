<?php
//Assuming this JASON coming from API end point

$form_fields = '{
    "fields": {
        "name": {"type": "text"},
        "email": {"type": "email"},
        "message": {"type": "textarea"},
        "gender": {"type": "select", "options": [{"value": "male", "label": "Male"}, {"value": "female", "label": "Female"}]},
        "subscribe": {"type": "checkbox"}
    }
}';

echo $form_fields;
?>
