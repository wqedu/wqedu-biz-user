<?php
/**
 * Created by PhpStorm.
 * User: wangqianjin
 * Date: 2019/3/11
 * Time: 1:56 PM
 */
namespace Biz\User\Service;

interface UserService
{
   public function getUser($id, $lock = false);

   public function getUserAndProfile($id);

   public function initSystemUsers();

   public function getSimpleUser($id);

   public function getUserByNickname($nickname);

   public function getUserByType($type);

   public function getUserByUUID($uuid);

   public function updateUserUpdatedTime($id);

   //根据用户名/邮箱/手机号精确查找用户
   public function getUserByLoginField($keyword);

   public function getUserBydMobile($mobile);

   public function countUsersByMobileNotEmpty();

   public function countUserHasMobile($isVerified = false);

   public function findUsersHasMobile($start, $limit, $isVerified = false);

   public function findUnlockedUserMobilesByUserIds($userIds, $needVerified = false);

   public function getUserByEmail($email);

   public function findUsersByIds(array $id);

   public function searchUsers(array $conditions, array $orderBy, $start, $limit, $columns = array());

   public function countUsers(array $conditions);



   /**
    * @param $userId
    * @param $nickname
    *
    * @return mixed
    * @Log(module="user",action="nickname_change",funcName="getUser",param="userId")
    */
   public function changeNickname($userId, $nickname);

   /**
    * @param $userId
    * @param $email
    *
    * @return mixed
    * @Log(module="user",action="email-changed",funcName="getUser",param="userId")
    */
   public function changeEmail($userId, $email);

   /**
    * @param $userId
    * @param $data
    *
    * @return mixed
    * @Log(module="user",action="avatar-changed",funcName="getUser",param="userId")
    */
   public function changeAvatar($userId, $data);

   public function isNicknameAvaliable($nickname);

   public function isEmailAvaliable($email);

   public function isMobileAvaliable($mobile);


   public function isMobileUnique($mobile);

   /**
    * @param $id
    * @param $mobile
    *
    * @return mixed
    * @Log(module="user",action="verifiedMobile-changed",funcName="getUser",param="id")
    */
   public function changeMobile($id, $mobile);

   /**
    * 变更密码
    *
    * @param [integer] $id       用户ID
    * @param [string]  $password 新密码
    * @Log(module="user",action="password-changed",funcName="getUser",param="id")
    */
   public function changePassword($id, $password);

   /**
    * 变更原始密码
    *
    * @param [integer] $id          用户ID
    * @param [string]  $rawPassword 新原始密码
    * @Log(module="user",action="raw-password-changed",funcName="getUser",param="id")
    */
   public function changeRawPassword($id, $rawPassword);

   /**
    * 校验密码是否正确.
    *
    * @param [integer] $id       用户ID
    * @param [string]  $password 密码
    *
    * @return [boolean] 密码正确，返回true；错误，返回false
    */
   public function verifyPassword($id, $password);

   /**
    * 用户注册.
    *
    * 当type为default时，表示用户从自身网站注册。
    * 当type为weibo、qq、renren时，表示用户从第三方网站连接，允许注册信息没有密码。
    *
    * @param [type] $registration 用户注册信息
    * @param string $type         注册类型
    *
    * @return array 用户信息
    */
   public function register($registration, $type = 'default');

   public function markLoginInfo();

   public function markLoginFailed($userId, $ip);

   public function markLoginSuccess($userId, $ip);


   /**
    * 绑定第三方登录的帐号到系统中的用户帐号.
    */
   public function bindUser($type, $fromId, $toId, $token);

   public function getUserBindByTypeAndFromId($type, $fromId);

   public function getUserBindByTypeAndUserId($type, $toId);

   public function getUserBindByToken($token);

   public function findBindsByUserId($userId);

   public function unBindUserByTypeAndToId($type, $toId);

}
