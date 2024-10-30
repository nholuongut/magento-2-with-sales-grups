<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Genaker\SalesGroup\Model;

use Genaker\SalesGroup\Api\Data\SalesGroupInterface;
use Genaker\SalesGroup\Api\Data\SalesGroupInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;

class SalesGroup extends \Magento\Framework\Model\AbstractModel
{

    protected $salesgroupDataFactory;

    protected $dataObjectHelper;

    protected $_eventPrefix = 'salesgroup_salesgroup';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param SalesGroupInterfaceFactory $salesgroupDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Genaker\SalesGroup\Model\ResourceModel\SalesGroup $resource
     * @param \Genaker\SalesGroup\Model\ResourceModel\SalesGroup\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        SalesGroupInterfaceFactory $salesgroupDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Genaker\SalesGroup\Model\ResourceModel\SalesGroup $resource,
        \Genaker\SalesGroup\Model\ResourceModel\SalesGroup\Collection $resourceCollection,
        array $data = []
    ) {
        $this->salesgroupDataFactory = $salesgroupDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve salesgroup model with salesgroup data
     * @return SalesGroupInterface
     */
    public function getDataModel()
    {
        $salesgroupData = $this->getData();
        
        $salesgroupDataObject = $this->salesgroupDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $salesgroupDataObject,
            $salesgroupData,
            SalesGroupInterface::class
        );
        
        return $salesgroupDataObject;
    }
}

