<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Genaker\SalesGroup\Model;

use Genaker\SalesGroup\Api\Data\SalesGroupInterfaceFactory;
use Genaker\SalesGroup\Api\Data\SalesGroupSearchResultsInterfaceFactory;
use Genaker\SalesGroup\Api\SalesGroupRepositoryInterface;
use Genaker\SalesGroup\Model\ResourceModel\SalesGroup as ResourceSalesGroup;
use Genaker\SalesGroup\Model\ResourceModel\SalesGroup\CollectionFactory as SalesGroupCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

class SalesGroupRepository implements SalesGroupRepositoryInterface
{

    protected $resource;

    protected $salesGroupFactory;

    protected $salesGroupCollectionFactory;

    protected $searchResultsFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $dataSalesGroupFactory;

    protected $extensionAttributesJoinProcessor;

    private $storeManager;

    private $collectionProcessor;

    protected $extensibleDataObjectConverter;

    /**
     * @param ResourceSalesGroup $resource
     * @param SalesGroupFactory $salesGroupFactory
     * @param SalesGroupInterfaceFactory $dataSalesGroupFactory
     * @param SalesGroupCollectionFactory $salesGroupCollectionFactory
     * @param SalesGroupSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceSalesGroup $resource,
        SalesGroupFactory $salesGroupFactory,
        SalesGroupInterfaceFactory $dataSalesGroupFactory,
        SalesGroupCollectionFactory $salesGroupCollectionFactory,
        SalesGroupSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->salesGroupFactory = $salesGroupFactory;
        $this->salesGroupCollectionFactory = $salesGroupCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataSalesGroupFactory = $dataSalesGroupFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Genaker\SalesGroup\Api\Data\SalesGroupInterface $salesGroup
    ) {
        /* if (empty($salesGroup->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $salesGroup->setStoreId($storeId);
        } */
        
        $salesGroupData = $this->extensibleDataObjectConverter->toNestedArray(
            $salesGroup,
            [],
            \Genaker\SalesGroup\Api\Data\SalesGroupInterface::class
        );
        
        $salesGroupModel = $this->salesGroupFactory->create()->setData($salesGroupData);
        
        try {
            $this->resource->save($salesGroupModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the salesGroup: %1',
                $exception->getMessage()
            ));
        }
        return $salesGroupModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($salesGroupId)
    {
        $salesGroup = $this->salesGroupFactory->create();
        $this->resource->load($salesGroup, $salesGroupId);
        if (!$salesGroup->getId()) {
            throw new NoSuchEntityException(__('SalesGroup with id "%1" does not exist.', $salesGroupId));
        }
        return $salesGroup->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->salesGroupCollectionFactory->create();
        
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Genaker\SalesGroup\Api\Data\SalesGroupInterface::class
        );
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Genaker\SalesGroup\Api\Data\SalesGroupInterface $salesGroup
    ) {
        try {
            $salesGroupModel = $this->salesGroupFactory->create();
            $this->resource->load($salesGroupModel, $salesGroup->getSalesgroupId());
            $this->resource->delete($salesGroupModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the SalesGroup: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($salesGroupId)
    {
        return $this->delete($this->get($salesGroupId));
    }
}

