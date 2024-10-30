<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Genaker\SalesGroup\Api\Data;

interface SalesGroupInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const SALESGROUP_ID = 'salesgroup_id';
    const NAME = 'Name';

    /**
     * Get salesgroup_id
     * @return string|null
     */
    public function getSalesgroupId();

    /**
     * Set salesgroup_id
     * @param string $salesgroupId
     * @return \Genaker\SalesGroup\Api\Data\SalesGroupInterface
     */
    public function setSalesgroupId($salesgroupId);

    /**
     * Get Name
     * @return string|null
     */
    public function getName();

    /**
     * Set Name
     * @param string $name
     * @return \Genaker\SalesGroup\Api\Data\SalesGroupInterface
     */
    public function setName($name);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Genaker\SalesGroup\Api\Data\SalesGroupExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Genaker\SalesGroup\Api\Data\SalesGroupExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Genaker\SalesGroup\Api\Data\SalesGroupExtensionInterface $extensionAttributes
    );
}

