<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Genaker\SalesGroup\Api\Data;

interface SalesGroupSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get SalesGroup list.
     * @return \Genaker\SalesGroup\Api\Data\SalesGroupInterface[]
     */
    public function getItems();

    /**
     * Set Name list.
     * @param \Genaker\SalesGroup\Api\Data\SalesGroupInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

