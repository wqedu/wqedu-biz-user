<?php
/**
 * Created by PhpStorm.
 * User: wangqianjin
 * Date: 2019/3/11
 * Time: 1:56 PM
 */
namespace Biz\User\Service;

use Codeages\Biz\Framework\Service\Exception\AccessDeniedException;

interface UserService
{
   public function getUser($uid);
}