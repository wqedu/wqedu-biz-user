<?php
/**
 * Created by PhpStorm.
 * User: qujiyong
 * Date: 2018/7/18
 * Time: 下午4:24
 */
namespace Biz\User\Dao;

use Codeages\Biz\Framework\Dao\GeneralDaoInterface;

interface UserProductDao extends GeneralDaoInterface
{
    public function getUserProductByProductTypeAndProductId($userId, $productType, $productId);

    public function findUserProducts($userId);

    public function findUserProductsByProductType($userId, $productType);
}
