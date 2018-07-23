<?php
/**
 * Created by PhpStorm.
 * User: qujiyong
 * Date: 3018/7/18
 * Time: 下午4:27
 */

namespace Biz\User\Service\Impl;

use Codeages\Biz\Framework\Service\BaseService;
use Biz\User\Service\UserProductService;
use Wqedu\Common\ArrayToolkit;

class UserProductServiceImpl extends BaseService implements UserProductService
{
    protected $productType = array('book', 'course', 'quiz');

    protected $role = array('admin', 'teacher', 'student');

    public function getProduct($id)
    {
        return $this->getUserProductDao()->get($id);
    }

    public function createProduct($fields)
    {
        if (!ArrayToolkit::requireds($fields, array('userId','productId','productType')))
            throw new \Exception('Missing Necessary Fields', 20101);

        $fields = $this->_filterProductFields($fields, 'create');

        $product = $this->getUserProductDao()->create($fields);

        //todo, log

        return $product;
    }

    public function updateProduct($id, $fields)
    {
        $product   = $this->getUserProductDao()->get($id);
        if(empty($product))
            throw new \Exception('Product Resource Not Found', 20104);

        $fields = $this->_filterProductFields($fields);
        $fields        = $fields;
        $product = $this->getUserProductDao()->update($id, $fields);

        //todo,log

        return $product;
    }

    /*
     * 做逻辑删除
     * status->closed
     */
    public function deleteProduct($id)
    {
        $product   = $this->getUserProductDao()->get($id);
        if(empty($product))
            throw new \Exception('Product Resource Not Found', 20104);

        //todo,log

        return $this->getUserProductDao()->delete($id);
    }

    public function searchProductCount($conditions)
    {
        $conditions = $this->_prepareProductConditions($conditions);

        return $this->getUserProductDao()->count($conditions);

    }

    public function searchProducts($conditions, $sort, $start, $limit)
    {
        $conditions = $this->_prepareProductConditions($conditions);

        $orderBy = $this->_prepareProductOrderBy($sort);

        return $this->getUserProductDao()->search($conditions, $orderBy, $start, $limit);
    }

    /*
     * user Product
     */
    public function createUserProduct($userId, $productType, $productId, $role)
    {
        if( empty($userId) || empty($productType) || empty($productId) || empty($role) )
            throw new \Exception('Missing Necessary Fields', 20101);

        $fields['userId'] = $userId;
        $fields['productType'] = $productType;
        $fields['productId'] = $productId;
        $fields['role'] = $role;

        $product = $this->getUserProductByProductTypeAndProductId($fields['userId'], $fields['productType'], $fields['productId']);

        if(empty($product))
            $product = $this->createProduct($fields);

        return $product;
    }

    public function getUserProductByProductTypeAndProductId($userId, $productType, $productId)
    {
        if( empty($userId) || empty($productType) || empty($productId) )
            throw new \Exception('Missing Necessary Fields', 20101);

        return $this->getUserProductDao()->getUserProductByProductTypeAndProductId($userId, $productType, $productId);
    }

    public function findUserProducts($userId)
    {
        if( empty($userId) )
            throw new \Exception('Missing Necessary Fields', 20101);

        return $this->getUserProductDao()->findUserProducts($userId);
    }

    public function findUserProductsByProductType($userId, $productType)
    {
        if( empty($userId) || empty($productType) )
            throw new \Exception('Missing Necessary Fields', 20101);

        return $this->getUserProductDao()->findUserProductsByProductType($userId, $productType);
    }

    public function updateUserProductRole($userId, $productType, $productId, $role)
    {
        if( empty($userId) || empty($productType) || empty($productId) || empty($role) )
            throw new \Exception('Missing Necessary Fields', 20101);

        $product = $this->getUserProductByProductTypeAndProductId($userId, $productType, $productId);

        if(empty($product))
            throw new \Exception('User Product Not Found', 20104);

        return $this->updateProduct($product['id'], array('role'=>$role));
    }

    /*
     * product filter
     */

    protected function _filterProductFields($fields, $mode = 'update')
    {
        $fields = ArrayToolkit::filter($fields, array(
            'userId'            =>  0,
            'productId'          =>  0,
            'productType'        =>  'course',
            'role'              =>  'student'
        ));

        if( isset($fields['role']) && !in_array($fields['role'], $this->role) )
            throw new \Exception('Invalid Role Value', 20104);

        if( isset($fields['productType']) && !in_array($fields['productType'], $this->productType) )
            throw new \Exception('Invalid productType Value', 20104);

        $fields['updatedTime'] = time();

        if($mode=='create')
        {
            $fields['createdTime'] = time();
        }

        return $fields;
    }

    protected function _prepareProductConditions($conditions)
    {
        $conditions = array_filter(
            $conditions,
            function ($value) {
                if (0 == $value) {
                    return true;
                }

                return !empty($value);
            }
        );

        return $conditions;
    }

    protected function _prepareProductOrderBy($sort)
    {
        if (is_array($sort)) {
            $orderBy = $sort;
        } elseif ('createdTimeByAsc' == $sort) {
            $orderBy = array('createdTime' => 'ASC');
        } else {
            $orderBy = array('createdTime' => 'DESC');
        }

        return $orderBy;
    }

    /**
     * @return ProductDao
     */
    protected function getUserProductDao()
    {
        return $this->biz->dao('User:UserProductDao');
    }
}