<?php

/**
 * Lucas
 * Copyright (C) 2019
 *
 * This file is part of OmnyfyCustomzation/ElectricalSpecification.
 *
 * OmnyfyCustomzation/ElectricalSpecification is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace OmnyfyCustomzation\ElectricalSpecification\Setup;

use Magento\Catalog\Model\Product;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

class UpgradeData implements UpgradeDataInterface
{

    private $eavSetupFactory;

    /**
     * Constructor
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function upgrade(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        if (version_compare($context->getVersion(), "1.0.1", "<")) {
            $lightningAttributes = $this->getLightingAttributes();
            foreach ($lightningAttributes as $lightningAttribute) {
                $eavSetup->removeAttribute(Product::ENTITY, $lightningAttribute['code']);

                $eavSetup->addAttribute(
                    Product::ENTITY,
                    $lightningAttribute['code'],
                    [
                        'type' => 'varchar',
                        'backend' => '',
                        'frontend' => '',
                        'label' => $lightningAttribute['label'],
                        'input' => $lightningAttribute['input'],
                        'class' => '',
                        'source' => '',
                        'global' => 1,
                        'visible' => true,
                        'required' => false,
                        'user_defined' => true,
                        'default' => null,
                        'searchable' => false,
                        'filterable' => false,
                        'comparable' => false,
                        'visible_on_front' => false,
                        'used_in_product_listing' => true,
                        'unique' => false,
                        'apply_to' => '',
                        'system' => 1,
                        'group' => 'Lighting',
                        'option' => $lightningAttribute['option']
                    ]
                );
            }
        }
    }

    private function getLightingAttributes()
    {
        return [
            [
                'code' => 'power_source',
                'label' => 'Power Source',
                'input' => 'select',
                'option' => ['values' => ['Hardwired', 'Plug-in', 'Battery']]
            ],
            [
                'code' => 'color_temp',
                'label' => 'Color Temp',
                'input' => 'text',
                'option' => ''
            ],
            [
                'code' => 'cri',
                'label' => 'CRI',
                'input' => 'text',
                'option' => ''
            ],
            [
                'code' => 'led_life',
                'label' => 'LED Life',
                'input' => 'text',
                'option' => ''
            ],
            [
                'code' => 'battery_life',
                'label' => 'Battery Life',
                'input' => 'text',
                'option' => ''
            ],
            [
                'code' => 'charging_time',
                'label' => 'Charging Time',
                'input' => 'text',
                'option' => ''
            ],
            [
                'code' => 'battery',
                'label' => 'Battery',
                'input' => 'text',
                'option' => ''
            ]
        ];
    }
}
