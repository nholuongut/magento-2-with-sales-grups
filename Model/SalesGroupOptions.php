<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Genaker\SalesGroup\Model;

use Genaker\SalesGroup\Model\SalesGroup;

class SalesGroupOptions extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{

    /**
     * getAllOptions
     *
     * @return array
     */
    public function getAllOptions()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $collection = $objectManager->get(SalesGroup::class)->getCollection();

        $collection = $collection->
        load();

        if ($this->_options === null) {
            $this->_options[] = ['value' => 0, 'label' => "None"];
            foreach ($collection as $group){
                $this->_options[] = [
                    'value' => $group['salesgroup_id'], 'label' => $group['name'] . ' - ' . $group['sales_group_code'] 
                ];
            }
        }
        return $this->_options;
    }
}
