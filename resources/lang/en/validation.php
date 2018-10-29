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

      'accepted'             => 'accepted',
    'active_url'           => 'active_url',
    'after'                => 'after::date',
    'after_or_equal'       => 'after_or_equal::date',
    'alpha'                => 'alpha',
    'alpha_dash'           => 'alpha_dash',
    'alpha_num'            => 'alpha_num',
    'array'                => 'array',
    'before'               => 'before::date',
    'before_or_equal'      => 'before_or_equal::date',
    'between'              => [
        'numeric' => 'between::min,:max',
        'file'    => 'between::min,:max', //kilobytes
        'string'  => 'between::min,:max',
        'array'   => 'between::min,:max',
    ],
    'boolean'              => 'boolean',
    'confirmed'            => 'date_format',
    'date'                 => 'date',
    'date_format'          => 'date_format::format',
    'different'            => 'different::other',
    'digits'               => 'digits::digits',
    'digits_between'       => 'digits_between::min,:max',
    'dimensions'           => 'dimensions',
    'distinct'             => 'distinct',
    'email'                => 'email',
    'exists'               => 'exists',
    'file'                 => 'file',
    'filled'               => 'filled',
    'gt'                   => [
        'numeric' => 'gt::value',
        'file'    => 'gt::value',
        'string'  => 'gt::value',
        'array'   => 'gt::value',
    ],
    'gte'                  => [
        'numeric' => 'gte::value',
        'file'    => 'gte::value',
        'string'  => 'gte::value',
        'array'   => 'gte::value',
    ],
    'image'                => 'image',
    'in'                   => 'in',
    'in_array'             => 'in_array:other',
    'integer'              => 'integer',
    'ip'                   => 'ip',
    'ipv4'                 => 'ipv4',
    'ipv6'                 => 'ipv6',
    'json'                 => 'json',
    'lt'                   => [
        'numeric' => 'lt::value',
        'file'    => 'lt::value',
        'string'  => 'lt::value',
        'array'   => 'lt::value',
    ],
    'lte'                  => [
        'numeric' => 'lte::value',
        'file'    => 'lte::value',
        'string'  => 'lte::value',
        'array'   => 'lte::value',
    ],
    'max'                  => [
        'numeric' => 'max::max',
        'file'    => 'max::max',
        'string'  => 'max::max',
        'array'   => 'max::max',
    ],
    'mimes'                => 'mimes::values',
    'mimetypes'            => 'mimetypes::values',
    'min'                  => [
        'numeric' => 'min::min',
        'file'    => 'min::min kilobytes',
        'string'  => 'min::min',
        'array'   => 'min::min items',
    ],
    'not_in'               => 'not_in',
    'not_regex'            => 'not_regex',
    'numeric'              => 'numeric',
    'present'              => 'present',
    'regex'                => 'regex',
    'required'             => 'required',
    'required_if'          => 'required_if::other,:value',
    'required_unless'      => 'required_unless::other,:values',
    'required_with'        => 'required_with::values',
    'required_with_all'    => 'required_with_all::values',
    'required_without'     => 'required_without::values',
    'required_without_all' => 'required_without_all::values',
    'same'                 => 'same::other',
    'size'                 => [
        'numeric' => 'size::size',
        'file'    => 'size::size',
        'string'  => 'size::size',
        'array'   => 'size::size',
    ],
    'string'               => 'string',
    'timezone'             => 'timezone',
    'unique'               => 'unique',
    'uploaded'             => 'uploaded',
    'url'                  => 'url',

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
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
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
