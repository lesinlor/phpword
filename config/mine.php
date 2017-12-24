<?php
/**
 * Created by IntelliJ IDEA.
 * User: asd
 * Date: 2017/12/16
 * Time: 下午5:08
 */

return [
    /*不记录日志*/
    'unTrace' => array(
        '/',
        '/api/login',
        '/api/logout'
    ),
    /*不需要权限可以请求*/
    'unPermission' => array(
        '/api/login'
    ),
    'errorCode' => array(
        'noAuth' => 1001, //未登录
        'paramError' => 1002, //参数错误
        'noContent' => 1003, //暂无相关数据
        'invalidUserName' => 2001, //非法的登录名
        'invalidPassword' => 2002, //非法的密码
        'invalidNickName' => 2003, //非法的用户名
        'addUserFail' => 3001, //添加用户失败
        'updateUserFail' => 3002, //更新用失败
        'userNotExists' => 3003, //用户不存在
        'incorrectPassword' => 3004, //密码不正确
        'uploadImageFail' => 4001, //上传图片失败,
        'imageExtensionInvalid' => 4002, //图片格式错误
        'imageSizeIsTooLarge' => 4003, //图片内容过大
        'imageNotExists' => 4004, //图片不存在
        'deleteImageFail' => 4005, //删除图片失败
        'addConcordatFail' => 4015
    ),
    'concordatPath' => 'concordat'
];