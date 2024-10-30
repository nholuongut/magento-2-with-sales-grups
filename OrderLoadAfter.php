<?php
namespace Genaker\SalesGroup;

use Magento\Framework\Event\ObserverInterface;

class OrderLoadAfter implements ObserverInterface
{

public function execute(\Magento\Framework\Event\Observer $observer)
{
    $order = $observer->getOrder();
    $extensionAttributes = $order->getExtensionAttributes();
    if ($extensionAttributes === null) {
        $extensionAttributes = $this->getOrderExtensionDependency();
    }


    $attr = $order->getData('sales_group_id');

    if ($attr === null) {
        $extensionAttributes->setSalesGroupId("NONE");
    } else {
        $extensionAttributes->setSalesGroupId($attr);
    }
    $order->setExtensionAttributes($extensionAttributes);
}
private function getOrderExtensionDependency()
{
    $orderExtension = \Magento\Framework\App\ObjectManager::getInstance()->get(
        '\Magento\Sales\Api\Data\OrderExtension'
    );
    return $orderExtension;
}
}
