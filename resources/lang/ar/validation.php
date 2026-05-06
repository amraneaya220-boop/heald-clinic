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

    'accepted' => 'يجب قبول :attribute.',
    'active_url' => ':attribute لا يُعتبر رابطًا صحيحًا.',
    'after' => ':attribute يجب أن يكون تاريخًا لاحقًا لـ :date.',
    'after_or_equal' => ':attribute يجب أن يكون تاريخًا لاحقًا أو مطابقًا لـ :date.',
    'alpha' => ':attribute يجب أن يحتوي على حروف فقط.',
    'alpha_dash' => ':attribute يجب أن يحتوي على حروف، أرقام، و _ و -.',
    'alpha_num' => ':attribute يجب أن يحتوي على حروف وأرقام فقط.',
    'array' => ':attribute يجب أن يكون مصفوفة.',
    'before' => ':attribute يجب أن يكون تاريخًا سابقًا لـ :date.',
    'before_or_equal' => ':attribute يجب أن يكون تاريخًا سابقًا أو مطابقًا لـ :date.',
    'between' => [
        'numeric' => ':attribute يجب أن يكون بين :min و :max.',
        'file' => ':attribute يجب أن يكون بين :min و :max كيلوبايت.',
        'string' => ':attribute يجب أن يكون بين :min و :max حرف.',
        'array' => ':attribute يجب أن يكون بين :min و :max عنصر.',
    ],
    'boolean' => ':attribute يجب أن يكون صحيحًا أو خطأ.',
    'confirmed' => ':attribute لا تتطابق التحقق.',
    'date' => ':attribute ليس تاريخًا صحيحًا.',
    'date_equals' => ':attribute يجب أن يكون تاريخًا يساوي :date.',
    'date_format' => ':attribute لا يتوافق مع الصيغة :format.',
    'different' => ':attribute و :other يجب أن يكونا مختلفين.',
    'digits' => ':attribute يجب أن يكون :digits رقمًا.',
    'digits_between' => ':attribute يجب أن يكون بين :min و :max رقم.',
    'dimensions' => ':attribute لديه أبعاد صورة غير صحيحة.',
    'distinct' => ':attribute الميدان لديه قيمة مكررة.',
    'email' => ':attribute يجب أن يكون بريدًا إلكترونيًا صحيحًا.',
    'exists' => ':attribute المختار غير موجود.',
    'file' => ':attribute يجب أن يكون ملفًا.',
    'filled' => ':attribute الميدان مطلوب.',
    'image' => ':attribute يجب أن يكون صورة.',
    'in' => ':attribute المختار غير صحيح.',
    'in_array' => ':attribute الميدان غير موجود في :other.',
    'integer' => ':attribute يجب أن يكون رقمًا صحيحًا.',
    'ip' => ':attribute يجب أن يكون عنوان IP صحيحًا.',
    'ipv4' => ':attribute يجب أن يكون عنوان IPv4 صحيحًا.',
    'ipv6' => ':attribute يجب أن يكون عنوان IPv6 صحيحًا.',
    'json' => ':attribute يجب أن يكون سلسلة JSON صحيحة.',
    'max' => [
        'numeric' => ':attribute لا يجب أن يكون أكبر من :max.',
        'file' => ':attribute لا يجب أن يكون أكبر من :max كيلوبايت.',
        'string' => ':attribute لا يجب أن يكون أكبر من :max حرف.',
        'array' => ':attribute لا يجب أن يكون أكبر من :max عنصر.',
    ],
    'mimes' => ':attribute يجب أن يكون ملفًا من القنوع: :values.',
    'mimetypes' => ':attribute يجب أن يكون ملفًا من القنوع: :values.',
    'min' => [
        'numeric' => ':attribute يجب أن يكون :min على الأقل.',
        'file' => ':attribute يجب أن يكون :min كيلوبايت على الأقل.',
        'string' => ':attribute يجب أن يكون :min أحرف على الأقل.',
        'array' => ':attribute يجب أن يكون :min عناصر على الأقل.',
    ],
    'not_in' => ':attribute المختار غير صحيح.',
    'not_regex' => ':attribute صيغة غير صحيحة.',
    'numeric' => ':attribute يجب أن يكون رقمًا.',
    'present' => ':attribute الميدان يجب أن يكون موجودًا.',
    'regex' => ':attribute صيغة غير صحيحة.',
    'required' => ':attribute الميدان مطلوب.',
    'required_if' => ':attribute الميدان مطلوب عندما :other يكون :value.',
    'required_unless' => ':attribute الميدان مطلوب ما لم :other يكون في :values.',
    'required_with' => ':attribute الميدان مطلوب عند وجود :values.',
    'required_with_all' => ':attribute الميدان مطلوب عند وجود أي :values.',
    'required_without' => ':attribute الميدان مطلوب عند عدم وجود :values.',
    'required_without_all' => ':attribute الميدان مطلوب عند عدم وجود أي :values.',
    'same' => ':attribute و :other يجب أن تتطابق.',
    'size' => [
        'numeric' => ':attribute يجب أن يكون :size.',
        'file' => ':attribute يجب أن يكون :size كيلوبايت.',
        'string' => ':attribute يجب أن يكون :size حرف.',
        'array' => ':attribute يجب أن يحتوي على :size عناصر.',
    ],
    'string' => ':attribute يجب أن يكون سلسلة.',
    'timezone' => ':attribute يجب أن يكون منطقة زمنية صحيحة.',
    'unique' => ':attribute قد تم اختياره من قبل.',
    'validated' => ':attribute قواعد التحقق غير صحيحة.',
    'url' => ':attribute صيغة غير صحيحة.',
    'uuid' => ':attribute يجب أن يكون UUID صحيحًا.' // تمت إزالة الفاصلة بعد هذا السطر

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This allows almost as
    | much control as possible while leveraging Laravel's built-in validation.
    |
    */

    
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holder
    | values in validation messages. This makes it quick to specify a specific
    | message for each situation and to provide localized attribute names.
    |
    | "password.0" - password field #0
    | "password.1" - password field #1
    | "password.*" - all password fields
    |
    */

    

];