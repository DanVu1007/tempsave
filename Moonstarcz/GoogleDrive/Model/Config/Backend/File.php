<?php


namespace Moonstarcz\GoogleDrive\Model\Config\Backend;


class File extends \Magento\Config\Model\Config\Backend\File
{
    const JSON_TYPE = 'application/json';
    public function _getAllowedExtensions() {
        return ['json'];
    }
    public function beforeSave()
    {
        $value = $this->getValue();
        if ($value['type'] != self::JSON_TYPE){
            throw new \Magento\Framework\Exception\LocalizedException(__('Service account key only allows json file.'));
        }
        return parent::beforeSave();
    }
}
