<?php

return [

    /*
    |--------------------------------------------------------------------------
    | バリデーション言語行
    |--------------------------------------------------------------------------
    |
    | 以下の言語行は認証クラスで使用されるデフォルトのエラーメッセージを含んでいます。
    | サイズルールのように、いくつかのルールには複数のバージョンがあります。
    | ここで各メッセージを自由に調整してください。
    |
    */

    'accepted' => ':attributeを承認してください。',
    'accepted_if' => ':otherが:valueの場合、:attributeを承認してください。',
    'active_url' => ':attributeは有効なURLではありません。',
    'after' => ':attributeには:date以降の日付を指定してください。',
    'after_or_equal' => ':attributeには:date以降、または同じ日付を指定してください。',
    'alpha' => ':attributeには英字のみを使用してください。',
    'alpha_dash' => ':attributeには英数字、ハイフン、アンダースコアのみを使用してください。',
    'alpha_num' => ':attributeには英数字のみを使用してください。',
    'any_of' => ':attributeの値が正しくありません。',
    'array' => ':attributeは配列形式でなければなりません。',
    'ascii' => ':attributeには半角英数記号のみを使用してください。',
    'before' => ':attributeには:date以前の日付を指定してください。',
    'before_or_equal' => ':attributeには:date以前、または同じ日付を指定してください。',
    'between' => [
        'array' => ':attributeの項目数は:min個から:max個の間でなければなりません。',
        'file' => ':attributeのサイズは:min KBから:max KBの間でなければなりません。',
        'numeric' => ':attributeは:minから:maxの間でなければなりません。',
        'string' => ':attributeは:min文字から:max文字の間でなければなりません。',
    ],
    'boolean' => ':attributeはtrueかfalseでなければなりません。',
    'can' => ':attributeに許可されていない値が含まれています。',
    'confirmed' => ':attributeの確認用入力が一致しません。',
    'contains' => ':attributeに必要な値が含まれていません。',
    'current_password' => 'パスワードが正しくありません。',
    'date' => ':attributeには有効な日付を指定してください。',
    'date_equals' => ':attributeには:dateと同じ日付を指定してください。',
    'date_format' => ':attributeは:format形式と一致しません。',
    'decimal' => ':attributeには小数点以下:decimal桁の数値を指定してください。',
    'declined' => ':attributeを拒否してください。',
    'declined_if' => ':otherが:valueの場合、:attributeを拒否してください。',
    'different' => ':attributeと:otherには異なる値を指定してください。',
    'digits' => ':attributeは:digits桁の数値でなければなりません。',
    'digits_between' => ':attributeは:min桁から:max桁の間でなければなりません。',
    'dimensions' => ':attributeの画像サイズが無効です。',
    'distinct' => ':attributeに重複した値があります。',
    'doesnt_contain' => ':attributeに次の値を含めることはできません: :values',
    'doesnt_end_with' => ':attributeの末尾は次のいずれかであってはなりません: :values',
    'doesnt_start_with' => ':attributeの先頭は次のいずれかであってはなりません: :values',
    'email' => ':attributeには有効なメールアドレスを指定してください。',
    'ends_with' => ':attributeの末尾は次のいずれかである必要があります: :values',
    'enum' => '選択された:attributeは無効です。',
    'exists' => '選択された:attributeは無効です。',
    'extensions' => ':attributeには次の拡張子のいずれかを指定してください: :values',
    'file' => ':attributeはファイル形式でなければなりません。',
    'filled' => ':attributeの値を入力してください。',
    'gt' => [
        'array' => ':attributeの項目数は:value個より多くなければなりません。',
        'file' => ':attributeのサイズは:value KBより大きくなければなりません。',
        'numeric' => ':attributeは:valueより大きくなければなりません。',
        'string' => ':attributeは:value文字より長くなければなりません。',
    ],
    'gte' => [
        'array' => ':attributeの項目数は:value個以上でなければなりません。',
        'file' => ':attributeのサイズは:value KB以上でなければなりません。',
        'numeric' => ':attributeは:value以上でなければなりません。',
        'string' => ':attributeは:value文字以上でなければなりません。',
    ],
    'hex_color' => ':attributeには有効な16進数の色を指定してください。',
    'image' => ':attributeには画像ファイルを指定してください。',
    'in' => '選択された:attributeは無効です。',
    'in_array' => ':attributeは:otherの中に存在しなければなりません。',
    'in_array_keys' => ':attributeには次のキーのいずれかが含まれていなければなりません: :values',
    'integer' => ':attributeには整数を指定してください。',
    'ip' => ':attributeには有効なIPアドレスを指定してください。',
    'ipv4' => ':attributeには有効なIPv4アドレスを指定してください。',
    'ipv6' => ':attributeには有効なIPv6アドレスを指定してください。',
    'json' => ':attributeには有効なJSON文字列を指定してください。',
    'list' => ':attributeはリスト形式でなければなりません。',
    'lowercase' => ':attributeには小文字のみを使用してください。',
    'lt' => [
        'array' => ':attributeの項目数は:value個より少なくなければなりません。',
        'file' => ':attributeのサイズは:value KBより小さくなければなりません。',
        'numeric' => ':attributeは:valueより小さくなければなりません。',
        'string' => ':attributeは:value文字より短くなければなりません。',
    ],
    'lte' => [
        'array' => ':attributeの項目数は:value個以下でなければなりません。',
        'file' => ':attributeのサイズは:value KB以下でなければなりません。',
        'numeric' => ':attributeは:value以下でなければなりません。',
        'string' => ':attributeは:value文字以下でなければなりません。',
    ],
    'mac_address' => ':attributeには有効なMACアドレスを指定してください。',
    'max' => [
        'array' => ':attributeの項目数は:max個以下でなければなりません。',
        'file' => ':attributeのサイズは:max KB以下でなければなりません。',
        'numeric' => ':attributeは:max以下でなければなりません。',
        'string' => ':attributeは:max文字以下でなければなりません。',
    ],
    'max_digits' => ':attributeは:max桁以下でなければなりません。',
    'mimes' => ':attributeには次のタイプのファイルを指定してください: :values',
    'mimetypes' => ':attributeには次のタイプのファイルを指定してください: :values',
    'min' => [
        'array' => ':attributeの項目数は少なくとも:min個必要です。',
        'file' => ':attributeのサイズは少なくとも:min KB必要です。',
        'numeric' => ':attributeには:min以上の数値を指定してください。',
        'string' => ':attributeは少なくとも:min文字以上必要です。',
    ],
    'min_digits' => ':attributeは少なくとも:min桁以上必要です。',
    'missing' => ':attributeは入力しないでください。',
    'missing_if' => ':otherが:valueの場合、:attributeは入力しないでください。',
    'missing_unless' => ':otherが:valueでない限り、:attributeは入力しないでください。',
    'missing_with' => ':valuesが存在する場合、:attributeは入力しないでください。',
    'missing_with_all' => ':valuesが存在する場合、:attributeは入力しないでください。',
    'multiple_of' => ':attributeは:valueの倍数でなければなりません。',
    'not_in' => '選択された:attributeは無効です。',
    'not_regex' => ':attributeの形式が正しくありません。',
    'numeric' => ':attributeには数値を指定してください。',
    'password' => [
        'letters' => ':attributeには少なくとも1つの文字を含める必要があります。',
        'mixed' => ':attributeには少なくとも1つの大文字と小文字を含める必要があります。',
        'numbers' => ':attributeには少なくとも1つの数字を含める必要があります。',
        'symbols' => ':attributeには少なくとも1つの記号を含める必要があります。',
        'uncompromised' => '入力された:attributeはデータ漏洩により流出しています。別の値を入力してください。',
    ],
    'present' => ':attributeフィールドが存在している必要があります。',
    'present_if' => ':otherが:valueの場合、:attributeフィールドが存在している必要があります。',
    'present_unless' => ':otherが:valueでない限り、:attributeフィールドが存在している必要があります。',
    'present_with' => ':valuesが存在する場合、:attributeフィールドが存在している必要があります。',
    'present_with_all' => ':valuesが存在する場合、:attributeフィールドが存在している必要があります。',
    'prohibited' => ':attributeの入力は禁止されています。',
    'prohibited_if' => ':otherが:valueの場合、:attributeの入力は禁止されています。',
    'prohibited_if_accepted' => ':otherを承認した場合、:attributeの入力は禁止されています。',
    'prohibited_if_declined' => ':otherを拒否した場合、:attributeの入力は禁止されています。',
    'prohibited_unless' => ':otherが:valuesに含まれない限り、:attributeの入力は禁止されています。',
    'prohibits' => ':attributeを入力する場合、:otherの入力はできません。',
    'regex' => ':attributeの形式が正しくありません。',
    'required' => ':attributeは必須項目です。',
    'required_array_keys' => ':attributeには次のキーが含まれている必要があります: :values',
    'required_if' => ':otherが:valueの場合、:attributeは必須です。',
    'required_if_accepted' => ':otherを承認した場合、:attributeは必須です。',
    'required_if_declined' => ':otherを拒否した場合、:attributeは必須です。',
    'required_unless' => ':otherが:valuesにない限り、:attributeは必須です。',
    'required_with' => ':valuesが存在する場合、:attributeは必須です。',
    'required_with_all' => ':valuesが存在する場合、:attributeは必須です。',
    'required_without' => ':valuesが存在しない場合、:attributeは必須です。',
    'required_without_all' => ':valuesのいずれも存在しない場合、:attributeは必須です。',
    'same' => ':attributeと:otherが一致しません。',
    'size' => [
        'array' => ':attributeの項目数は:size個でなければなりません。',
        'file' => ':attributeのサイズは:size KBでなければなりません。',
        'numeric' => ':attributeは:sizeでなければなりません。',
        'string' => ':attributeは:size文字でなければなりません。',
    ],
    'starts_with' => ':attributeの先頭は次のいずれかである必要があります: :values',
    'string' => ':attributeには文字列を指定してください。',
    'timezone' => ':attributeには有効なタイムゾーンを指定してください。',
    'unique' => 'この:attributeは既に存在します。',
    'uploaded' => ':attributeのアップロードに失敗しました。',
    'uppercase' => ':attributeには大文字のみを使用してください。',
    'url' => ':attributeには有効なURLを指定してください。',
    'ulid' => ':attributeには有効なULIDを指定してください。',
    'uuid' => ':attributeには有効なUUIDを指定してください。',

    /*
    |--------------------------------------------------------------------------
    | カスタムバリデーション言語行
    |--------------------------------------------------------------------------
    |
    | ここでは、"attribute.rule"という形式で属性のカスタムバリデーションメッセージを
    | 指定することができます。これにより、特定の属性ルールに対して独自の言語行を
    | 素早く定義することが可能になります。
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | カスタム属性名
    |--------------------------------------------------------------------------
    |
    | 以下の言語行は、属性のプレースホルダを「email」の代わりに「メールアドレス」のような
    | より読みやすい名前に置き換えるために使用されます。これにより、メッセージを
    | より分かりやすくすることができます。
    |
    */

    'attributes' => [
        'supplier_id'            => '仕入先ID',
        'purchase_date'          => '仕入日',
        'expected_date'          => '入荷予定日',
        'shipping_fee'           => '送料',
        'payment_method'         => '支払い方法',
        'hotline'                => 'ホットライン',

        'customer_id'            => '顧客ID',
        'order_date'             => '注文日',
        'expected_delivery_date' => '配送予定日',
        'type'                   => '種別', 

        'order_no'               => '注文番号',
        'address_shipping'       => '配送先住所',
        'customer_name'          => '顧客名',
        'unit_price'             => '単価',
        'total_price'            => '合計金額',

        'category_id'            => 'カテゴリID',
        'sku'                    => 'SKU',
        'name'                   => '商品名',
        'unit'                   => '単位',
        'description'            => '説明',
        'unit_name'              => '会社名 / 団体名',
        'phone'                  => '電話番号',
        'address'                => '住所',
        'tax_code'               => '税番号',

        'bank_account'           => '銀行口座',
        'contact_name'           => '担当者名',
        'product_id'             => '商品ID',
        'warehouse_id'           => '倉庫ID',
        'qty_adjusted'           => '調整数量',
        'reason'                 => '理由',
        'adjustment_date'        => '調整日',
        'current_qty'            => '現在庫数',
        'new_qty'                => '調整後数量',
    ],

];