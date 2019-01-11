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

    //'failed' => trans('dingsu.login_credentials_failed'),
    'throttle' => trans('dingsu.login_throttle') . 'seconds seconds.',
    'username_empty' => '请设置用户名.',
    'password_empty' => '请设置登录密码.',
    'phone_empty' => '请设置手机号.',
    'failed' => '密码不匹配, 登录失败.',
    'password_not_min' => '设置密码数字提示“密码必须6-12位数.',
    'phone_not_min' => '电话号码必须至少为4个字符.',
    'password_not_same' => '重复登录密码不匹配.', 
    'username_notavailable' => '该账户名已被注册.', 
    'phone_notavailable' => '手机号已注册.', 


];
