<?php

return [
    'accepted'             => 'El atributo :attribute tiene que estar aceptado.',
    'accepted_if'          => 'El atributo :attribute tiene que estar cuando :other es :value.',
    'active_url'           => 'El atributo :attribute tiene que ser una URL válida.',
    'after'                => 'El atributo :attribute tiene que ser una fecha posterior a :date.',
    'after_or_equal'       => 'El atributo :attribute tiene que ser una fecha posterior o igual a :date.',
    'alpha'                => 'El atributo :attribute tiene que contener solo letras.',
    'alpha_dash'           => 'El atributo :attribute tiene que contener solo letras, números, guiones o barrabajas.',
    'alpha_num'            => 'El atributo :attribute tiene que contener solo letras y números.',
    'array'                => 'El atributo :attribute tiene que ser un array.',
    'ascii'                => 'El atributo :attribute tiene que contener solo caracteres alfanuméricos o symbolos de un único byte.',
    'before'               => 'El atributo :attribute tiene que ser una fecha anterior a :date.',
    'before_or_equal'      => 'El atributo :attribute tiene que ser una fecha anterior o igual a :date.',
    'between'              => [
        'array'   => 'El atributo :attribute tiene que tener entre :min y :max items.',
        'file'    => 'El atributo :attribute tiene que tener entre :min y :max kilobytes.',
        'numeric' => 'El atributo :attribute tiene que estar entre :min y :max.',
        'string'  => 'El atributo :attribute tiene que tener entre :min y :max caracteres.',
    ],
    'boolean'              => 'El atributo :attribute tiene que ser true o false.',
    'can'                  => 'El atributo :attribute contiene un valor no autorizado.',
    'confirmed'            => 'La confirmación del atributo :attribute no concuerda.',
    'current_password'     => 'La contraseña es incorrecta.',
    'date'                 => 'El atributo :attribute tiene que ser una fecha válida.',
    'date_equals'          => 'El atributo :attribute tiene que ser una fecha igual a :date.',
    'date_format'          => 'El atributo :attribute tiene que tener el formato :format.',
    'decimal'              => 'El atributo :attribute tiene que tener :decimal decimales.',
    'declined'             => 'El atributo :attribute tiene que estar declinado.',
    'declined_if'          => 'El atributo :attribute tiene que estar declinado cuando :other es :value.',
    'different'            => 'El atributo :attribute y :other tienen que ser diferentes.',
    'digits'               => 'El atributo :attribute tiene que tener :digits dígitos.',
    'digits_between'       => 'El atributo :attribute tiene que tener entre :min y :max dígitos.',
    'dimensions'           => 'La imagen del atributo :attribute tiene dimensiones inválidas.',
    'distinct'             => 'El atributo :attribute tiene un valor duplicado.',
    'doesnt_end_with'      => 'El atributo :attribute no tiene que terminar con uno de los siguientes valores: :values.',
    'doesnt_start_with'    => 'El atributo :attribute no tiene que empezar con uno de los siguientes valores: :values.',
    'email'                => 'El atributo :attribute tiene que una dirección de email válida.',
    'ends_with'            => 'El atributo :attribute tiene que acabar con los siguientes valores: :values.',
    'enum'                 => 'El atributo seleccionado :attribute es inválido.',
    'exists'               => 'El atributo seleccionado :attribute es inválido.',
    'file'                 => 'El atributo :attribute tiene que ser un fichero.',
    'filled'               => 'El atributo :attribute tiene que estar relleno.',
    'gt'                   => [
        'array'   => 'El atributo :attribute tiene que tener más de :value valores.',
        'file'    => 'El atributo :attribute tiene que ser más grande de :value kilobytes.',
        'numeric' => 'El atributo :attribute tiene que ser mayor que :value.',
        'string'  => 'El atributo :attribute tiene que tener más de :value caracteres.',
    ],
    'gte'                  => [
        'array'   => 'El atributo :attribute tiene que tener :value o más valores.',
        'file'    => 'El atributo :attribute tiene que ser mayor o igual a :value kilobytes.',
        'numeric' => 'El atributo :attribute tiene que ser mayor o igual a :value.',
        'string'  => 'El atributo :attribute tiene que tener :value o más caracteres.',
    ],
    'image'                => 'El atributo :attribute tiene que ser una imagen.',
    'in'                   => 'El atributo seleccionado :attribute es inválido.',
    'in_array'             => 'El atributo :attribute tiene que existir en :other.',
    'integer'              => 'El atributo :attribute tiene que ser un número entero.',
    'ip'                   => 'El atributo :attribute tiene que ser una dirección IP válida.',
    'ipv4'                 => 'El atributo :attribute tiene que ser una dirección IPv4 válida.',
    'ipv6'                 => 'El atributo :attribute tiene que ser una dirección IPv6 válida.',
    'json'                 => 'El atributo :attribute tiene que tener un formato JSON válido.',
    'lowercase'            => 'El atributo :attribute tiene que estar en minúsculas.',
    'lt'                   => [
        'array'   => 'El atributo :attribute tiene que tener menos de :value valores.',
        'file'    => 'El atributo :attribute tiene que ser menor de :value kilobytes.',
        'numeric' => 'El atributo :attribute tiene que ser menor que :value.',
        'string'  => 'El atributo :attribute tiene que tener menos de :value caracteres.',
    ],
    'lte'                  => [
        'array'   => 'El atributo :attribute tiene que tener menos de :value valores.',
        'file'    => 'El atributo :attribute tiene que ser menor o igual a :value kilobytes.',
        'numeric' => 'El atributo :attribute tiene que ser menor o igual a :value.',
        'string'  => 'El atributo :attribute tiene que tener :value caracteres o menos.',
    ],
    'mac_address'          => 'El atributo :attribute tiene que ser una dirección MAC válida.',
    'max'                  => [
        'array'   => 'El atributo :attribute no tiene que tener más de :max valores.',
        'file'    => 'El atributo :attribute no tiene que ser mayor de :max kilobytes.',
        'numeric' => 'El atributo :attribute no tiene que ser mayor de :max.',
        'string'  => 'El atributo :attribute no tiene que tener más de :max caracteres.',
    ],
    'max_digits'           => 'El atributo :attribute no tiene que tener más de :max dígitos.',
    'mimes'                => 'El atributo :attribute tiene que ser un fichero del tipo: :values.',
    'mimetypes'            => 'El atributo :attribute tiene que ser un fichero del tipo: :values.',
    'min'                  => [
        'array'   => 'El atributo :attribute tiene que tener al menos :min valores.',
        'file'    => 'El atributo :attribute tiene que ser al menos de :min kilobytes.',
        'numeric' => 'El atributo :attribute tiene que ser al menos :min.',
        'string'  => 'El atributo :attribute tiene que tener al menos :min caracteres.',
    ],
    'min_digits'           => 'El atributo :attribute tiene que tener al menos :min dígitos.',
    'missing'              => 'El atributo :attribute no tiene que estar presente.',
    'missing_if'           => 'El atributo :attribute no tiene que estar presente cuando :other es :value.',
    'missing_unless'       => 'El atributo :attribute no tiene que estar presente a no ser que :other sea :value.',
    'missing_with'         => 'El atributo :attribute no tiene que estar presente cuando :values lo está.',
    'missing_with_all'     => 'El atributo :attribute no tiene que estar presente cuando :values lo están.',
    'multiple_of'          => 'El atributo :attribute tiene que be un múltiplo de :value.',
    'not_in'               => 'El atributo seleccionado :attribute es inválido.',
    'not_regex'            => 'El formato del atributo :attribute es inválido.',
    'numeric'              => 'El atributo :attribute tiene que ser un número.',
    'password'             => [
        'letters'       => 'El atributo :attribute tiene que contener al menos una letra.',
        'mixed'         => 'El atributo :attribute tiene que contener al menos una letra mayúscula y una minúscula.',
        'numbers'       => 'El atributo :attribute tiene que contener al menos un número.',
        'symbols'       => 'El atributo :attribute tiene que contener al menos un símbolo.',
        'uncompromised' => 'El atributo dado :attribute ha aparecido en una filtración. Por favor, elige un :attribute diferente.',
    ],
    'present'              => 'El atributo :attribute tiene que estar presente.',
    'present_if'           => 'El atributo :attribute tiene que estar presente cuando :other es :value.',
    'present_unless'       => 'El atributo :attribute tiene que estar presente a no ser que :other sea :value.',
    'present_with'         => 'El atributo :attribute tiene que estar presente cuando :values lo está.',
    'present_with_all'     => 'El atributo :attribute tiene que estar presente cuando :values lo están.',
    'prohibited'           => 'El atributo :attribute está prohibido.',
    'prohibited_if'        => 'El atributo :attribute está prohibido cuando :other es :value.',
    'prohibited_unless'    => 'El atributo :attribute está prohibido a no ser que :other esté en :values.',
    'prohibits'            => 'El atributo :attribute impide que :other esté presente.',
    'regex'                => 'El formato del atributo :attribute es inválido.',
    'required'             => 'El :attribute es obligatorio.',
    'required_array_keys'  => 'El atributo :attribute tiene que contener valores para: :values.',
    'required_if'          => 'El atributo :attribute es obligatorio cuando :other es :value.',
    'required_if_accepted' => 'El atributo :attribute es obligatorio cuando :other está aceptado.',
    'required_unless'      => 'El atributo :attribute es obligatorio a no ser que :other esté en :values.',
    'required_with'        => 'El atributo :attribute es obligatorio cuando :values está presente.',
    'required_with_all'    => 'El atributo :attribute es obligatorio cuando :values están presentes.',
    'required_without'     => 'El atributo :attribute es obligatorio cuando :values no está presente.',
    'required_without_all' => 'El atributo :attribute es obligatorio cuando ninguno de :values está presente.',
    'same'                 => 'El atributo :attribute tiene que coincidir con :other.',
    'size'                 => [
        'array'   => 'El atributo :attribute tiene que contener :size items.',
        'file'    => 'El atributo :attribute tiene que tener el tamaño de :size kilobytes.',
        'numeric' => 'El atributo :attribute tiene que que ser :size.',
        'string'  => 'El atributo :attribute tiene que tener :size caracteres.',
    ],
    'starts_with'          => 'El atributo :attribute tiene que empezar por con uno de los siguientes valores: :values.',
    'string'               => 'El atributo :attribute tiene que ser una cadena de caracteres.',
    'timezone'             => 'El atributo :attribute tiene que ser una zona horaria válida.',
    'unique'               => 'El atributo :attribute ya ha sido tomado.',
    'uploaded'             => 'El atributo :attribute falló al subirse.',
    'uppercase'            => 'El atributo :attribute tiene que estar en mayúsculas.',
    'url'                  => 'El atributo :attribute tiene que ser una URL válida.',
    'ulid'                 => 'El atributo :attribute tiene que ser un ULID válido.',
    'uuid'                 => 'El atributo :attribute tiene que ser un UUID válido.',

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

    'custom' => ['attribute-name' => ['rule-name' => 'custom-message',],],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],
];
