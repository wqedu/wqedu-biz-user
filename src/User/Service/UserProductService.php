<?php
/**
 * Created by PhpStorm.
 * User: qujiyong
 * Date: 2018/7/18
 * Time: 下午4:24
 */
namespace Biz\User\Service;

use Codeages\Biz\Framework\Service\Exception\AccessDeniedException;

interface UserProductService
{
    public function getProduct($id);

    public function createProduct($fields);

    public function updateProduct($id, $fields);

    public function deleteProduct($id);

    public function searchProductCount($conditions);

    public function searchProducts($conditions, $sort, $start, $limit);

    /*
     * user product
     */
    public function createUserProduct($userId, $productType, $productId, $role);

    public function updateUserProductRole($userId, $productType, $productId, $role);

    public function getUserProductByProductTypeAndProductId($userId, $productType, $productId);

    public function findUserProductsByProductType($userId, $productType);

    public function findUserProducts($userId);

}
