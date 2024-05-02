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
    'accepted'             => ':attribute باید پذیرفته شود.',
    'accepted_if'          => ':attribute باید پذیرفته شود، زمانی که :other برابر با :value باشد.',
    'active_url'           => ':attribute یک URL معتبر نیفرمت رمز عبور معتبر نیستست.',
    'after'                => ':attribute باید تاریخی بعد از :date باشد.',
    'after_or_equal'       => ':attribute باید تاریخی بعد از :date، یا برابر با آن باشد.',
    'alpha'                => ':attribute باید فقط شامل حروف الفبا باشد.',
    'alpha_dash'           => ':attribute باید فقط شامل حروف الفبا، اعداد، خط تیره و زیرخط باشد.',
    'alpha_num'            => ':attribute باید فقط شامل حروف الفبا و اعداد باشد.',
    'array'                => ':attribute باید یک آرایه باشد.',
    'before'               => ':attribute باید تاریخی قبل از :date باشد.',
    'before_or_equal'      => ':attribute باید تاریخی قبل از :date، یا برابر با آن باشد.',
    'between'              => [
        'array'   => ':attribute باید بین :min و :max آیتم باشد.',
        'file'    => ':attribute باید بین :min و :max کیلوبایت باشد.',
        'numeric' => ':attribute باید بین :min و :max باشد.',
        'string'  => ':attribute باید بین :min و :max کاراکتر باشد.',
    ],
    'boolean'              => 'فیلد :attribute فقط می‌تواند true و یا false باشد.',
    'confirmed'            => ':attribute با فیلد تکرار مطابقت ندارد.',
    'current_password'     => 'رمزعبور اشتباه است.',
    'date'                 => ':attribute یک تاریخ معتبر نیست.',
    'date_equals'          => ':attribute باید تاریخی برابر با :date باشد.',
    'date_format'          => ':attribute با الگوی :format مطابقت ندارد.',
    'declined'             => ':attribute باید رد شود.',
    'declined_if'          => ':attribute باید رد شود زمانی که :other برابر با :value است.',
    'different'            => ':attribute و :other باید از یکدیگر متفاوت باشند.',
    'digits'               => ':attribute باید :digits رقم باشد.',
    'digits_between'       => ':attribute باید بین :min و :max رقم باشد.',
    'dimensions'           => ':attribute دارای ابعاد تصویر نامعتبر است.',
    'distinct'             => 'فیلد :attribute دارای یک مقدار تکراری است.',
    'doesnt_end_with'      => ':attribute ممکن است به یکی از موارد روبرو ختم نشود: :values.',
    'doesnt_start_with'    => ':attribute ممکن است با یکی از موارد روبرو شروع نشود: :values.',
    'email'                => ':attribute باید یک ایمیل معتبر باشد.',
    'ends_with'            => ':attribute باید به یکی از موارد روبرو ختم شود: :values.',
    'enum'                 => ':attribute انتخاب شده، معتبر نیست.',
    'exists'               => ':attribute انتخاب شده، معتبر نیست.',
    'file'                 => ':attribute باید یک فایل معتبر باشد.',
    'filled'               => 'فیلد :attribute باید مقدار داشته باشد.',
    'gt'                   => [
        'array'   => ':attribute باید بیشتر از :value آیتم داشته باشد.',
        'file'    => ':attribute باید بزرگتر از :value کیلوبایت باشد.',
        'numeric' => ':attribute باید بزرگتر از :value باشد.',
        'string'  => ':attribute باید بیشتر از :value کاراکتر داشته باشد.',
    ],
    'gte'                  => [
        'array'   => ':attribute باید بیشتر یا برابر با :value آیتم داشته باشد.',
        'file'    => ':attribute باید بزرگتر یا برابر با :value کیلوبایت باشد.',
        'numeric' => ':attribute باید بزرگتر یا برابر با :value باشد.',
        'string'  => ':attribute باید بیشتر یا برابر با :value کاراکتر داشته باشد.',
    ],
    'image'                => ':attribute باید یک تصویر معتبر باشد.',
    'in'                   => ':attribute انتخاب شده، معتبر نیست.',
    'in_array'             => 'فیلد :attribute در :other وجود ندارد.',
    'integer'              => ':attribute باید عدد صحیح باشد.',
    'invalid'              => ':attribute معتبر نمی‌باشد.',
    'ip'                   => ':attribute باید یک آدرس IP معتبر باشد.',
    'ipv4'                 => ':attribute باید یک آدرس معتبر از نوع IPv4 باشد.',
    'ipv6'                 => ':attribute باید یک آدرس معتبر از نوع IPv6 باشد.',
    'json'                 => 'فیلد :attribute باید یک رشته از نوع JSON باشد.',
    'lt'                   => [
        'array'   => ':attribute باید کمتر از :value آیتم داشته باشد.',
        'file'    => ':attribute باید کوچکتر از :value کیلوبایت باشد.',
        'numeric' => ':attribute باید کوچکتر از :value باشد.',
        'string'  => ':attribute باید کمتر از :value کاراکتر داشته باشد.',
    ],
    'lte'                  => [
        'array'   => ':attribute باید کمتر یا برابر با :value آیتم داشته باشد.',
        'file'    => ':attribute باید کوچکتر یا برابر با :value کیلوبایت باشد.',
        'numeric' => ':attribute باید کوچکتر یا برابر با :value باشد.',
        'string'  => ':attribute باید کمتر یا برابر با :value کاراکتر داشته باشد.',
    ],
    'mac_address'          => ':attribute باید یک MAC آدرس معتبر باشد.',
    'max'                  => [
        'array'   => ':attribute نباید بیشتر از :max آیتم داشته باشد.',
        'file'    => ':attribute نباید بزرگتر از :max کیلوبایت باشد.',
        'numeric' => ':attribute نباید بزرگتر از :max باشد.',
        'string'  => ':attribute نباید بیشتر از :max کاراکتر داشته باشد.',
    ],
    'max_digits'           => ':attribute نباید بیش از :max رقم داشته باشد.',
    'mimes'                => 'فرمت‌های معتبر فایل عبارتند از: :values.',
    'mimetypes'            => 'فرمت‌های معتبر فایل عبارتند از: :values.',
    'min'                  => [
        'array'   => ':attribute نباید کمتر از :min آیتم داشته باشد.',
        'file'    => ':attribute نباید کوچکتر از :min کیلوبایت باشد.',
        'numeric' => ':attribute نباید کوچکتر از :min باشد.',
        'string'  => ':attribute نباید کمتر از :min کاراکتر داشته باشد.',
    ],
    'min_digits'           => ':attribute باید حداقل :min رقم داشته باشد.',
    'multiple_of'          => ':attribute باید یکی از موارد :value باشد.',
    'not_in'               => ':attribute انتخاب شده، معتبر نیست.',
    'not_regex'            => 'فرمت :attribute معتبر نیست.',
    'numeric'              => ':attribute باید یک عدد باشد.',
    'password'             => [
        'letters'       => ':attribute باید حداقل یک حرف داشته باشد.',
        'mixed'         => ':attribute باید حداقل دارای یک حرف بزرگ و یک حرف کوچک باشد.',
        'numbers'       => ':attribute باید حداقل دارای یک عدد باشد.',
        'symbols'       => ':attribute باید حداقل دارای یک نماد (Symbol) باشد.',
        'uncompromised' => ':attribute داده شده در نشت داده ظاهر شده است. لطفاً یک :attribute متفاوت انتخاب کنید.',
    ],
    'present'              => 'فیلد :attribute باید وجود داشته باشد.',
    'prohibited'           => 'فیلد :attribute ممنوع است.',
    'prohibited_if'        => 'فیلد :attribute وقتی :other برابر با :value باشد ممنوع است.',
    'prohibited_unless'    => 'فیلد :attribute ممنوع است مگر اینکه :other در :values باشد.',
    'prohibits'            => 'فیلد :attribute حضور :other را ممنوع می کند.',
    'regex'                => 'فرمت :attribute معتبر نیست.',
    'required'             => 'فیلد :attribute الزامی است.',
    'required_array_keys'  => 'فیلد :attribute باید شامل موارد روبرو باشد: :values.',
    'required_if'          => 'وقتی :other برابر با :value باشد، فیلد :attribute الزامی است.',
    'required_unless'      => 'فیلد :attribute الزامی است مگر اینکه :other در :values باشد.',
    'required_with'        => 'فیلد :attribute در صورت وجود فیلد :values الزامی است.',
    'required_with_all'    => 'در صورت وجود فیلدهای :values، فیلد :attribute الزامی است.',
    'required_without'     => 'در صورت عدم وجود فیلد :values، فیلد :attribute الزامی است.',
    'required_without_all' => 'در صورت عدم وجود هر یک از فیلدهای :values، فیلد :attribute الزامی است.',
    'same'                 => ':attribute و :other باید همانند هم باشند.',
    'size'                 => [
        'array'   => ':attribute باید شامل :size آیتم باشد.',
        'file'    => ':attribute باید برابر با :size کیلوبایت باشد.',
        'numeric' => ':attribute باید برابر با :size باشد.',
        'string'  => ':attribute باید برابر با :size کاراکتر باشد.',
    ],
    'starts_with'          => ':attribute باید با یکی از موارد روبرو شروع شود: :values.',
    'string'               => 'فیلد :attribute باید رشته باشد.',
    'timezone'             => 'فیلد :attribute باید یک منطقه زمانی معتبر باشد.',
    'unique'               => ':attribute قبلا انتخاب شده است.',
    'uploaded'             => 'بارگذاری فایل :attribute موفقیت آمیز نبود.',
    'url'                  => ':attribute باید یک URL معتبر باشد.',
    'uuid'                 => ':attribute باید یک UUID معتبر باشد.',
    'wrong'                => ':attribute اشتباه است.',

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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => require 'validation-attributes.php',
];
