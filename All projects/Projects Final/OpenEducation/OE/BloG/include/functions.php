

<?php

// Validation des champs du formulaire
function validation($error,$value,$key,$min,$max) {
    if(!empty($value)) {
        if(strlen($value) < $min ) {
            $error[$key] = 'Trop court (entre '.$min.' et '.$max.' caractères).';
        } elseif(strlen($value) > $max) {
            $error[$key] = 'Trop long (entre '.$min.' et '.$max.' caractères).';
        }
    } else {
        $error[$key] = 'Veuillez renseigner ce champ.';
    }

    return $error;
}


?>