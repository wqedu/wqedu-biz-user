<?php
/**
 * Created by PhpStorm.
 * User: qujiyong
 * Date: 2018/5/28
 * Time: 下午4:27
 */

namespace Biz\User\Dao\Impl;

use Biz\User\Dao\UserProductDao;
use Codeages\Biz\Framework\Dao\GeneralDaoImpl;

class UserProductDaoImpl extends GeneralDaoImpl implements UserProductDao
{
    protected $table = 'user_product';

    public function declares()
    {
        return array(
            'serializes' => array(
            ),
            'orderbys' => array(
                'createdTime',
                'updatedTime',
                'id',
            ),
            'timestamps' => array('createdTime', 'updatedTime'),
            'conditions' => array(
                'id = :id',
                'updatedTime >= :updatedTime_GE',
                'userId = :userId',
                'productId = :productId',
                'productType = :productType',
                'createdTime >= :startTime',
                'createdTime < :endTime',
                'id NOT IN ( :excludeIds )',
                'id IN ( :Ids )',
            ),
            'wave_cahceable_fields' => array(),
        );
    }
}