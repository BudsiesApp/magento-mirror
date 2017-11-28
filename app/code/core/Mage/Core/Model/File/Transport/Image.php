<?php

class Mage_Core_Model_File_Transport_Image extends Varien_Object
{
    private $pathInfo;
    private $imageInfo;

    public function setPathToImage(string $pathToImage): self
    {
        if (!file_exists($pathToImage)) {
            throw new Exception('Image file not exist');
        }

        $this->pathInfo = pathinfo($pathToImage);

        $imageInfo = getimagesize($pathToImage);
        if ($imageInfo === false) {
            throw new Exception('Failed to determine image parameters');
        }

        $this->imageInfo = $imageInfo;

        return $this;
    }

    public function getPathToImage(): string
    {
        return $this->getBaseDir() . '/' . $this->getRelativePath();
    }

    public function getMimeType(): string
    {
        return $this->imageInfo['mime'] ?? '';
    }

    public function getBaseDir(): string
    {
        return $this->pathInfo['dirname']  ?? '';
    }

    public function getRelativePath(): string
    {
        return $this->pathInfo['basename'] ?? '';
    }
}
