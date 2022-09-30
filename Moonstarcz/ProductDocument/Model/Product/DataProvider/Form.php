<?php

namespace Moonstarcz\ProductDocument\Model\Product\DataProvider;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;

class Form extends AbstractModifier
{
    /**
     * @var Modifiers\Meta
     */
    private $metaModifier;

    /**
     * @var Modifiers\Data
     */
    private $dataModifier;

    public function __construct(
        Modifiers\Meta $metaModifier,
        Modifiers\Data $dataModifier
    ) {
        $this->dataModifier = $dataModifier;
        $this->metaModifier = $metaModifier;
    }

    /**
     * @param array $data
     * @return array
     */
    public function modifyData(array $data)
    {
        return $this->dataModifier->execute($data);
    }

    /**
     * @param array $meta
     * @return array
     */
    public function modifyMeta(array $meta)
    {
        return $this->metaModifier->execute($meta);
    }
}
