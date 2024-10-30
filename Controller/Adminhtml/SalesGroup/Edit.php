<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Genaker\SalesGroup\Controller\Adminhtml\SalesGroup;

class Edit extends \Genaker\SalesGroup\Controller\Adminhtml\SalesGroup
{

    protected $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('salesgroup_id');
        $model = $this->_objectManager->create(\Genaker\SalesGroup\Model\SalesGroup::class);
        
        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Salesgroup no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->_coreRegistry->register('salesgroup_salesgroup', $model);
        
        // 3. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Salesgroup') : __('New Salesgroup'),
            $id ? __('Edit Salesgroup') : __('New Salesgroup')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Salesgroups'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? __('Edit Salesgroup %1', $model->getId()) : __('New Salesgroup'));
        return $resultPage;
    }
}

