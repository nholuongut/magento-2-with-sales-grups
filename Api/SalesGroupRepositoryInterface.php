<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Genaker\SalesGroup\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface SalesGroupRepositoryInterface
{

    /**
     * Save SalesGroup
     * @param \Genaker\SalesGroup\Api\Data\SalesGroupInterface $salesGroup
     * @return \Genaker\SalesGroup\Api\Data\SalesGroupInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Genaker\SalesGroup\Api\Data\SalesGroupInterface $salesGroup
    );

    /**
     * Retrieve SalesGroup
     * @param string $salesgroupId
     * @return \Genaker\SalesGroup\Api\Data\SalesGroupInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($salesgroupId);

    /**
     * Retrieve SalesGroup matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Genaker\SalesGroup\Api\Data\SalesGroupSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete SalesGroup
     * @param \Genaker\SalesGroup\Api\Data\SalesGroupInterface $salesGroup
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Genaker\SalesGroup\Api\Data\SalesGroupInterface $salesGroup
    );

    /**
     * Delete SalesGroup by ID
     * @param string $salesgroupId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($salesgroupId);
}

