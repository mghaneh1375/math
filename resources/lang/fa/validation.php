<?php

return [
    'boolean'              => 'مقدار فیلد :attribute باید صحیح یا غلط باشد.',
    'exists'               => ':attribute انتخاب شده معتبر نیست.',
    'image'                => ':attribute باید یک تصویر باشد.',
    'in'                   => ':attribute انتخاب‌شده معتبر نیست.',
    'integer'              => ':attribute باید عدد صحیح باشد.',
    'max'                  => [
        'numeric' => ':attribute نباید بیشتر از :max باشد.',
        'file'    => ':attribute نباید بیشتر از :max کیلوبایت باشد.',
        'string'  => ':attribute نباید بیشتر از :max کاراکتر باشد.',
        'array'   => ':attribute نباید بیش از :max مورد داشته باشد.',
    ],
    'mimes'                => ':attribute باید از نوع: :values باشد.',
    'min'                  => [
        'numeric' => ':attribute باید حداقل :min باشد.',
        'file'    => ':attribute باید حداقل :min کیلوبایت باشد.',
        'string'  => ':attribute باید حداقل :min کاراکتر باشد.',
        'array'   => ':attribute باید حداقل :min مورد داشته باشد.',
    ],
    'regex'                => 'فرمت :attribute معتبر نیست.',
    'required'             => 'وارد کردن :attribute الزامی است.',
    'string'               => ':attribute باید رشته‌ای باشد.',
    'unique'               => ':attribute قبلاً ثبت شده است.',
    'confirmed' => 'تأییدیه :attribute با مقدار وارد شده مطابقت ندارد.',

    'attributes' => [
        'password' => 'رمز عبور',
        'password_confirmation' => 'تکرار رمز عبور',
        'email' => 'ایمیل',
        'password' => 'رمز عبور',
        'name' => 'نام',
        'username' => 'نام کاربری',
        'mobile' => 'شماره موبایل',
        'school_name' => 'نام مدرسه'
    ],
];