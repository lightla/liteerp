<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Các Dòng Ngôn Ngữ Xác Thực Dữ Liệu
    |--------------------------------------------------------------------------
    |
    | Các dòng ngôn ngữ sau đây chứa thông điệp lỗi mặc định được sử dụng bởi
    | lớp xác thực. Một số quy tắc có nhiều phiên bản khác nhau như các quy tắc kích thước.
    | Hãy cảm thấy thoải mái để điều chỉnh từng thông điệp này ở đây.
    |
    */

    'accepted' => 'Trường này phải được chấp nhận.',
    'accepted_if' => 'Trường này phải được chấp nhận khi :other là :value.',
    'active_url' => 'Trường này phải là một URL hợp lệ.',
    'after' => 'Trường này phải là một ngày sau :date.',
    'after_or_equal' => 'Trường này phải là một ngày sau hoặc bằng :date.',
    'alpha' => 'Trường này chỉ có thể chứa chữ cái.',
    'alpha_dash' => 'Trường này chỉ có thể chứa chữ cái, số, dấu gạch ngang và dấu gạch dưới.',
    'alpha_num' => 'Trường này chỉ có thể chứa chữ cái và số.',
    'any_of' => 'Trường này là không hợp lệ.',
    'array' => 'Trường này phải là một mảng.',
    'ascii' => 'Trường này chỉ có thể chứa ký tự và ký hiệu đơn byte.',
    'before' => 'Trường này phải là một ngày trước :date.',
    'before_or_equal' => 'Trường này phải là một ngày trước hoặc bằng :date.',
    'between' => [
        'array' => 'Trường này phải có từ :min đến :max mục.',
        'file' => 'Trường này phải có từ :min đến :max kilobytes.',
        'numeric' => 'Trường này phải nằm trong khoảng từ :min đến :max.',
        'string' => 'Trường này phải có từ :min đến :max ký tự.',
    ],
    'boolean' => 'Trường này phải là true hoặc false.',
    'can' => 'Trường này chứa một giá trị không được phép.',
    'confirmed' => 'Trường này xác nhận không khớp.',
    'contains' => 'Trường này thiếu một giá trị cần thiết.',
    'current_password' => 'Mật khẩu không chính xác.',
    'date' => 'Trường này phải là một ngày hợp lệ.',
    'date_equals' => 'Trường này phải là một ngày bằng :date.',
    'date_format' => 'Trường này phải khớp với định dạng :format.',
    'decimal' => 'Trường này phải có :decimal chữ số thập phân.',
    'declined' => 'Trường này phải bị từ chối.',
    'declined_if' => 'Trường này phải bị từ chối khi :other là :value.',
    'different' => 'Trường này và :other phải khác nhau.',
    'digits' => 'Trường này phải có :digits chữ số.',
    'digits_between' => 'Trường này phải có từ :min đến :max chữ số.',
    'dimensions' => 'Trường này có kích thước hình ảnh không hợp lệ.',
    'distinct' => 'Trường này có một giá trị trùng lặp.',
    'doesnt_contain' => 'Trường này không được chứa bất kỳ giá trị nào sau đây: :values.',
    'doesnt_end_with' => 'Trường này không được kết thúc bằng một trong những giá trị sau: :values.',
    'doesnt_start_with' => 'Trường này không được bắt đầu bằng một trong những giá trị sau: :values.',
    'email' => 'Trường này phải là một địa chỉ email hợp lệ.',
    'ends_with' => 'Trường này phải kết thúc bằng một trong những giá trị sau: :values.',
    'enum' => 'Giá trị đã chọn là không hợp lệ.',
    'exists' => 'Giá trị đã chọn là không hợp lệ.',
    'extensions' => 'Trường này phải có một trong những phần mở rộng sau: :values.',
    'file' => 'Trường này phải là một tập tin.',
    'filled' => 'Trường này phải có một giá trị.',
    'gt' => [
        'array' => 'Trường này phải có nhiều hơn :value mục.',
        'file' => 'Trường này phải lớn hơn :value kilobytes.',
        'numeric' => 'Trường này phải lớn hơn :value.',
        'string' => 'Trường này phải lớn hơn :value ký tự.',
    ],
    'gte' => [
        'array' => 'Trường này phải có :value mục trở lên.',
        'file' => 'Trường này phải lớn hơn hoặc bằng :value kilobytes.',
        'numeric' => 'Trường này phải lớn hơn hoặc bằng :value.',
        'string' => 'Trường này phải lớn hơn hoặc bằng :value ký tự.',
    ],
    'hex_color' => 'Trường này phải là một màu hex hợp lệ.',
    'image' => 'Trường này phải là một hình ảnh.',
    'in' => 'Giá trị đã chọn là không hợp lệ.',
    'in_array' => 'Trường này phải tồn tại trong :other.',
    'in_array_keys' => 'Trường này phải chứa ít nhất một trong những khóa sau: :values.',
    'integer' => 'Trường này phải là một số nguyên.',
    'ip' => 'Trường này phải là một địa chỉ IP hợp lệ.',
    'ipv4' => 'Trường này phải là một địa chỉ IPv4 hợp lệ.',
    'ipv6' => 'Trường này phải là một địa chỉ IPv6 hợp lệ.',
    'json' => 'Trường này phải là một chuỗi JSON hợp lệ.',
    'list' => 'Trường này phải là một danh sách.',
    'lowercase' => 'Trường này phải là chữ thường.',
    'lt' => [
        'array' => 'Trường này phải có ít hơn :value mục.',
        'file' => 'Trường này phải nhỏ hơn :value kilobytes.',
        'numeric' => 'Trường này phải nhỏ hơn :value.',
        'string' => 'Trường này phải nhỏ hơn :value ký tự.',
    ],
    'lte' => [
        'array' => 'Trường này không được có nhiều hơn :value mục.',
        'file' => 'Trường này phải nhỏ hơn hoặc bằng :value kilobytes.',
        'numeric' => 'Trường này phải nhỏ hơn hoặc bằng :value.',
        'string' => 'Trường này phải nhỏ hơn hoặc bằng :value ký tự.',
    ],
    'mac_address' => 'Trường này phải là một địa chỉ MAC hợp lệ.',
    'max' => [
        'array' => 'Trường này không được có nhiều hơn :max mục.',
        'file' => 'Trường này không được lớn hơn :max kilobytes.',
        'numeric' => 'Trường này không được lớn hơn :max.',
        'string' => 'Trường này không được lớn hơn :max ký tự.',
    ],
    'max_digits' => 'Trường này không được có nhiều hơn :max chữ số.',
    'mimes' => 'Trường này phải là một tập tin có loại: :values.',
    'mimetypes' => 'Trường này phải là một tập tin có loại: :values.',
    'min' => [
        'array' => 'Trường này phải có ít nhất :min mục.',
        'file' => 'Trường này phải có ít nhất :min kilobytes.',
        'numeric' => 'Trường này phải ít nhất là :min.',
        'string' => 'Trường này phải có ít nhất :min ký tự.',
    ],
    'min_digits' => 'Trường này phải có ít nhất :min chữ số.',
    'missing' => 'Trường này phải bị thiếu.',
    'missing_if' => 'Trường này phải bị thiếu khi :other là :value.',
    'missing_unless' => 'Trường này phải bị thiếu trừ khi :other là :value.',
    'missing_with' => 'Trường này phải bị thiếu khi :values có mặt.',
    'missing_with_all' => 'Trường này phải bị thiếu khi :values có mặt.',
    'multiple_of' => 'Trường này phải là bội số của :value.',
    'not_in' => 'Giá trị đã chọn là không hợp lệ.',
    'not_regex' => 'Định dạng trường là không hợp lệ.',
    'numeric' => 'Trường này phải là một số.',
    'password' => [
        'letters' => 'Trường này phải chứa ít nhất một chữ cái.',
        'mixed' => 'Trường này phải chứa ít nhất một chữ cái viết hoa và một chữ cái viết thường.',
        'numbers' => 'Trường này phải chứa ít nhất một số.',
        'symbols' => 'Trường này phải chứa ít nhất một ký hiệu.',
        'uncompromised' => 'Giá trị đã cho đã xuất hiện trong một vụ rò rỉ dữ liệu. Vui lòng chọn một giá trị khác.',
    ],
    'present' => 'Trường này phải có mặt.',
    'present_if' => 'Trường này phải có mặt khi :other là :value.',
    'present_unless' => 'Trường này phải có mặt trừ khi :other là :value.',
    'present_with' => 'Trường này phải có mặt khi :values có mặt.',
    'present_with_all' => 'Trường này phải có mặt khi :values có mặt.',
    'prohibited' => 'Trường này bị cấm.',
    'prohibited_if' => 'Trường này bị cấm khi :other là :value.',
    'prohibited_if_accepted' => 'Trường này bị cấm khi :other được chấp nhận.',
    'prohibited_if_declined' => 'Trường này bị cấm khi :other bị từ chối.',
    'prohibited_unless' => 'Trường này bị cấm trừ khi :other có trong :values.',
    'prohibits' => 'Trường này cấm :other có mặt.',
    'regex' => 'Định dạng trường là không hợp lệ.',
    'required' => 'Trường này là bắt buộc.',
    'required_array_keys' => 'Trường này phải chứa các mục cho: :values.',
    'required_if' => 'Trường này là bắt buộc khi :other là :value.',
    'required_if_accepted' => 'Trường này là bắt buộc khi :other được chấp nhận.',
    'required_if_declined' => 'Trường này là bắt buộc khi :other bị từ chối.',
    'required_unless' => 'Trường này là bắt buộc trừ khi :other có trong :values.',
    'required_with' => 'Trường này là bắt buộc khi :values có mặt.',
    'required_with_all' => 'Trường này là bắt buộc khi :values có mặt.',
    'required_without' => 'Trường này là bắt buộc khi :values không có mặt.',
    'required_without_all' => 'Trường này là bắt buộc khi không có :values nào được hiện diện.',
    'same' => 'Trường này phải khớp với :other.',
    'size' => [
        'array' => 'Trường này phải chứa :size mục.',
        'file' => 'Trường này phải có kích thước :size kilobytes.',
        'numeric' => 'Trường này phải là :size.',
        'string' => 'Trường này phải có :size ký tự.',
    ],
    'starts_with' => 'Trường này phải bắt đầu bằng một trong những giá trị sau: :values.',
    'string' => 'Trường này phải là một chuỗi.',
    'timezone' => 'Trường này phải là một múi giờ hợp lệ.',
    'unique' => 'Giá trị đã có trong hệ thống.',
    'uploaded' => 'Trường này không thể tải lên.',
    'uppercase' => 'Trường này phải là chữ hoa.',
    'url' => 'Trường này phải là một URL hợp lệ.',
    'ulid' => 'Trường này phải là một ULID hợp lệ.',
    'uuid' => 'Trường này phải là một UUID hợp lệ.',

    /*
    |--------------------------------------------------------------------------
    | Các Dòng Ngôn Ngữ Xác Thực Tùy Chỉnh
    |--------------------------------------------------------------------------
    |
    | Tại đây, bạn có thể chỉ định các thông điệp xác thực tùy chỉnh cho các thuộc tính bằng cách sử dụng
    | quy ước "tên-thuộc-tính.quy-tắc" để đặt tên cho các dòng. Điều này giúp chúng tôi nhanh chóng chỉ định
    | một dòng ngôn ngữ tùy chỉnh cho một quy tắc thuộc tính nhất định.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Các Thuộc Tính Xác Thực Tùy Chỉnh
    |--------------------------------------------------------------------------
    |
    | Các dòng ngôn ngữ sau đây được sử dụng để thay thế thông điệp giữ chỗ thuộc tính
    | thành một thứ gì đó thân thiện hơn với người đọc như "Địa chỉ E-Mail" thay
    | vì "email". Điều này giúp chúng tôi làm cho thông điệp của mình biểu cảm hơn.
    |
    */

    'attributes' => [],

];
