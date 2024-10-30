<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Genaker\SalesGroup\Model\Data;

use Genaker\SalesGroup\Api\Data\SalesGroupInterface;

class SalesGroup extends \Magento\Framework\Api\AbstractExtensibleObject implements SalesGroupInterface
{

    /**
     * Get salesgroup_id
     * @return string|null
     */
    public function getSalesgroupId()
    {
        return $this->_get(self::SALESGROUP_ID);
    }

    /**
     * Set salesgroup_id
     * @param string $salesgroupId
     * @return \Genaker\SalesGroup\Api\Data\SalesGroupInterface
     */
    public function setSalesgroupId($salesgroupId)
    {
        return $this->setData(self::SALESGROUP_ID, $salesgroupId);
    }

    /**
     * Get Name
     * @return string|null
     */
    public function getName()
    {
        return $this->_get(self::NAME);
    }

    /**
     * Set Name
     * @param string $name
     * @return \Genaker\SalesGroup\Api\Data\SalesGroupInterface
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Genaker\SalesGroup\Api\Data\SalesGroupExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Genaker\SalesGroup\Api\Data\SalesGroupExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Genaker\SalesGroup\Api\Data\SalesGroupExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}

