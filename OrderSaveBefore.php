<?php
namespace Genaker\SalesGroup;

use Magento\Framework\Event\ObserverInterface;

class OrderSaveBefore implements ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();

        $attr = $order->setData('sales_group_id');
        $customerId = $order->getCustomerId();

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerData = $objectManager->get('Magento\Customer\Model\Customer')->load($customerId);
        $salesGroupId = $customerData->getData('sales_group');

        $salesGroupData = $objectManager->get('Genaker\SalesGroup\Model\SalesGroup')->load($salesGroupId, 'salesgroup_id');
        $salesGroupName = $salesGroupData->getData('name');

        $order->setData('sales_group_id', $salesGroupId);
        $order->setData('sales_group_name', $salesGroupName);
    }

}
