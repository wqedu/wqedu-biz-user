<?php
/**
 * Created by PhpStorm.
 * User: qujiyong
 * Date: 2018/5/29
 * Time: 下午12:04
 */

namespace Tests;

class UserProductServiceTest extends IntegrationTestCase
{
    public function testCreateUserProduct()
    {
        $mockUserProduct = $this->mockUserProduct();
        $createUserProduct = $this->getUserProductService()->createUserProduct($mockUserProduct['userId'], $mockUserProduct['productType'], $mockUserProduct['productId'], $mockUserProduct['role']);
        print_r($createUserProduct);

        $this->assertEquals($mockUserProduct['userId'], $createUserProduct['userId']);
        $this->assertEquals($mockUserProduct['productId'], $createUserProduct['productId']);
        $this->assertEquals($mockUserProduct['productType'], $createUserProduct['productType']);
        $this->assertEquals($mockUserProduct['role'], $createUserProduct['role']);

        fwrite(STDOUT, __METHOD__ . "\n =======testCreateUserProduct======= \n");
    }

    public function testGetUserProduct()
    {
        $mockUserProduct = $this->mockUserProduct();
        $createUserProduct = $this->getUserProductService()->createUserProduct($mockUserProduct['userId'], $mockUserProduct['productType'], $mockUserProduct['productId'], $mockUserProduct['role']);
        print_r($createUserProduct);

        $getUserProduct = $this->getUserProductService()->getUserProductByProductTypeAndProductId($mockUserProduct['userId'], $mockUserProduct['productType'], $mockUserProduct['productId']);
        print_r($getUserProduct);

        $this->assertEquals($mockUserProduct['userId'], $getUserProduct['userId']);
        $this->assertEquals($mockUserProduct['productId'], $getUserProduct['productId']);
        $this->assertEquals($mockUserProduct['productType'], $getUserProduct['productType']);
        $this->assertEquals($mockUserProduct['role'], $getUserProduct['role']);

        fwrite(STDOUT, __METHOD__ . "\n =======testGetUserProduct======= \n");
    }

    public function testFindUserProducts()
    {
        $mockUserProduct = $this->mockUserProduct();
        $createUserProduct = $this->getUserProductService()->createUserProduct($mockUserProduct['userId'], $mockUserProduct['productType'], $mockUserProduct['productId'], $mockUserProduct['role']);

        $mockUserProduct2 = $this->mockUserProduct2();
        $createUserProduct2 = $this->getUserProductService()->createUserProduct($mockUserProduct2['userId'], $mockUserProduct2['productType'], $mockUserProduct2['productId'], $mockUserProduct2['role']);

        $findUserProducts = $this->getUserProductService()->findUserProducts($mockUserProduct['userId']);

        print_r($findUserProducts);
        $this->assertEquals(2, count($findUserProducts));
        fwrite(STDOUT, __METHOD__ . "\n =======testFindUserProducts======= \n");
    }

    public function testUpdateProduct()
    {
        $mockUserProduct = $this->mockUserProduct();
        $createUserProduct = $this->getUserProductService()->createUserProduct($mockUserProduct['userId'], $mockUserProduct['productType'], $mockUserProduct['productId'], $mockUserProduct['role']);

        $mockUpdateUserProduct = $this->mockUpdateUserProduct();

        $updateUserProduct = $this->getUserProductService()->updateUserProductRole($mockUpdateUserProduct['userId'], $mockUpdateUserProduct['productType'], $mockUpdateUserProduct['productId'], $mockUpdateUserProduct['role']);
        print_r($updateUserProduct);

        $this->assertEquals($updateUserProduct['role'], $mockUpdateUserProduct['role']);
        fwrite(STDOUT, __METHOD__ . "\n =======testFindUserProducts======= \n");
    }

    protected function mockUserProduct()
    {
        return array(
            'userId'            =>  1,
            'productId'         =>  10,
            'productType'       =>  'course',
            'role'              =>  'student',
        );
    }

    protected function mockUserProduct2()
    {
        return array(
            'userId'            =>  1,
            'productId'         =>  12,
            'productType'       =>  'quiz',
            'role'              =>  'teacher',
        );
    }

    protected function mockUpdateUserProduct()
    {
        return array(
            'userId'            =>  1,
            'productId'         =>  10,
            'productType'       =>  'course',
            'role'              =>  'teacher',
        );
    }


    protected function getUserProductService()
    {
        return $this->biz->service('User:UserProductService');
    }
}