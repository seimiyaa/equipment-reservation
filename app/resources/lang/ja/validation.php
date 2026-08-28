<?php

return [

    'required' => ':attributeは必須です。',
    'email' => ':attributeには正しいメールアドレスを入力してください。',
    'unique' => ':attributeはすでに使用されています。',
    'min' => [
        'string' => ':attributeは:min文字以上で入力してください。',
    ],
    'max' => [
        'string' => ':attributeは:max文字以内で入力してください。',
    ],
    'confirmed' => ':attribute確認が一致しません。',
    'date' => ':attributeには正しい日付を入力してください。',
    'after' => ':attributeには:dateより後の日時を指定してください。',
    'after_or_equal' => ':attributeには:date以降の日時を指定してください。',
    'image' => ':attributeには画像ファイルを選択してください。',
    'mimes' => ':attributeは:values形式のファイルを選択してください。',
    'in' => ':attributeの値が正しくありません。',

    'attributes' => [
        'name' => 'ユーザー名',
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'password_confirmation' => 'パスワード確認',
        'role' => '権限',

        'image' => '設備画像',
        'category_id' => 'カテゴリ',
        'description' => '説明',

        'start_date' => '利用開始日',
        'start_hour' => '利用開始時',
        'start_minute' => '利用開始分',
        'end_date' => '利用終了日',
        'end_hour' => '利用終了時',
        'end_minute' => '利用終了分',

        'start_datetime' => '利用開始日時',
        'end_datetime' => '利用終了日時',
    ],

];