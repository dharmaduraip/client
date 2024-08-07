<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'El :atributo debe ser aceptado.',
    'active_url'           => 'El :atributo no es una URL válida.',
    'after'                => 'El :atributo debe ser una fecha después :fecha.',
    'after_or_equal'       => 'El :atributo debe ser una fecha después o igual a :fecha.',
    'alpha'                => 'El :atributo puede contener letras.',
    'alpha_dash'           => 'El :atributo puede solo contener letras, números, y espacios.',
    'alpha_num'            => 'El :atributo puede contener solo letras y números.',
    'array'                => 'El :atributo debe ser una matriz.',
    'before'               => 'El :atributo debe ser una fecha antes :fecha.',
    'before_or_equal'      => 'El :atributo debe ser a una fecha antes o igual a :fecha.',
    'between'              => [
        'numeric' => 'El :atributo debe ser entre :min y :max.',
        'file'    => 'EL :atributo debe ser entre :min y :max kilobytes.',
        'string'  => 'El :atributo debe ser entre :min y :max caracteres.',
        'array'   => 'EL :atributO debe ser entre :min y :max artículos.',
    ],
    'boolean'              => 'El :atributo el campo debe ser verdadero o falso.',
    'confirmed'            => 'El :atributo la confirmación no coincide.',
    'date'                 => 'El :atributo no es una fecha válida.',
    'date_format'          => 'El :atributo no coincide con el formato :formato.',
    'different'            => 'El :atributo y  :otro deben ser diferente.',
    'digits'               => 'El :atributo debe ser :dígitos dígitos.',
    'digits_between'       => 'El :atributo debe ser entre :min y :max dígitos.',
    'dimensions'           => 'El :atributo tiene dimensiones de imagen inválidas.',
    'distinct'             => 'El :atributo campo tiene un valor duplicado.',
    'email'                => 'EL :atributo debe ser un correo electrónico válido.',
    'exists'               => 'Lo seleccionado :atributo es inválido.',
    'file'                 => 'EL :attribute debe ser un archivo.',
    'filled'               => 'el :atributo campo requerido.',
    'image'                => 'El :atributo debe ser un imagen.',
    'in'                   => 'Lo seleccionado :atributo es inválido.',
    'in_array'             => 'El :atributo campo no existe en :otro.',
    'integer'              => 'EL :atributo debe ser un entero.',
    'ip'                   => 'El :atributo debe ser una dirección válida de IP.',
    'json'                 => 'El :atributo debe ser una válida JSON string.',
    'max'                  => [
        'numeric' => 'El :atributo no puede ser mayor a :max.',
        'file'    => 'El :atributo no puede exceder a :max kilobytes.',
        'string'  => 'El :atributo no puede exceder a :max caracteres.',
        'array'   => 'El :atributo no puede tener mayor de :max artículos.',
    ],
    'mimes'                => 'El :atributo debe ser tipo archivo: :valores.',
    'mimetypes'            => 'El :atributo debe ser un tipo de archivo: :valores.',
    'min'                  => [
        'numeric' => 'El :atributo debe ser al menos :min.',
        'file'    => 'El :atributo deber ser al menos :min kilobytes.',
        'string'  => 'El :atributo debe ser al menos :min caracteres.',
        'array'   => 'El :atributo debe tener al menos :min artículos.',
    ],
    'not_in'               => 'Lo seleccionado:atributo es inválido.',
    'numeric'              => 'El :atributo debe ser un número.',
    'present'              => 'El :atributo campo debe ser presente.',
    'regex'                => 'El :atributo formato es inválido.',
    'required'             => 'El :atributo campo es requerido.',
    'required_if'          => 'El :atributo campo es requerido cuando :otro es :valor,
    'required_unless'      => 'El :atributo campo es requerido hasta :otro está en :valores.',
    'required_with'        => 'El :atributo campo es requerido cuando :valor está presente.',
    'required_with_all'    => 'El :atributo campo es requerido cuando :valor está presente.',
    'required_without'     => 'El :atributo campo es requerido cuando :valor no está presente.',
    'required_without_all' => 'El :atributo campo es requerido cuando ninguno de :valores están presente.',
    'same'                 => 'El :atributo y :otro debe coincidir.',
    'size'                 => [
        'numeric' => 'El :atributo debe ser :tamaño.',
        'file'    => 'El :atributo debe ser :tamaño kilobytes.',
        'string'  => 'El :atributo debe ser :tamaño caracteres.',
        'array'   => 'El :atributo debe contener :tamaño de artículos.',
    ],
    'string'               => 'El :atributo debe ser una string.',
    'timezone'             => 'El :atributo debe ser una zona válida.',
    'unique'               => 'El :atributo ya está tomado.',
    'uploaded'             => 'El :atributo no se pudo subir.',
    'url'                  => 'El :atributo formato es inválido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        's_latitude' => [
            'required' => 'Dirección de fuente requerido',
        ],
        'd_latitude' => [
            'required' => 'Dirección de destino requerido',
        ],
        'user_address_id_required' => 'Por favor seleccione dirección de entrega'

    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
