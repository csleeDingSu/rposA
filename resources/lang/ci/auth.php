<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    //'failed' => '登录密码输入错误.',
    'throttle' => trans('dingsu.login_throttle') . 'seconds seconds.',
    'username_empty' => '请输入账户与密码.',
    'password_empty' => '请输入密码.',
    'phone_empty' => '请输入账户与密码.',
    'failed' => '登录密码输入错误.',
    'password_not_min' => '密码必须6-12位数.',
    'reg_username_empty' => '请输入正确账户名.',
    'reg_phone_empty' => '请输入正确手机号码.',
    'reg_password_empty' => '请设置登录密码.',
    'log_username_empty' => '请输入账户.',
    'log_password_empty' => '请输入密码.',
    'reg_username_not_min' => '请输入正确账户名.',
    'reg_password_not_min' => '密码必须6-12位数.',
    'log_password_not_min' => '密码必须6-12位数.',


    'phone_not_min' => '请输入正确手机号码.',
    'password_not_same' => '两次密码不一致，请重新输入.', 
    'username_notavailable' => '该账户名已被注册.', 
    'phone_notavailable' => '手机号已注册.', 
    'username_notexists' => '输入账号未注册.',
    //'password_notexists' => '登录密码输入错误.',
    
    'alpha_num' => '密码只能包含字母和数字。',
    'memberid_empty'=>'请输入正确账户ID',
    'packageid_empty'=>'请输入正确package ID',
    'quantity_empty'=>'请输入正确数量',
    'address_empty'=>'请输入正确地址',
    'receiver_name_empty'=>'请输入收货人姓名',
    'contact_number_empty'=>'请输入联络号码',
];
