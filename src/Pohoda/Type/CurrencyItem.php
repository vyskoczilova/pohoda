<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Type;

use Riesenia\Pohoda\Agenda;
use Riesenia\Pohoda\Common\OptionsResolver;
use Riesenia\Pohoda\Common\SetNamespaceTrait;
use Riesenia\Pohoda\Common\SetNodeNameTrait;

class CurrencyItem extends Agenda
{
    use SetNamespaceTrait, SetNodeNameTrait;

    /** @var array */
    protected $_elements = ['unitPrice', 'price', 'priceVAT', 'priceSum'];

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        if ($this->_namespace === null) {
            throw new \LogicException('Namespace not set.');
        }

        if ($this->_nodeName === null) {
            throw new \LogicException('Node name not set.');
        }

        $xml = $this->_createXML()->addChild($this->_namespace . ':' . $this->_nodeName, null, $this->_namespace($this->_namespace));

        $this->_addElements($xml, $this->_elements, 'typ');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function _configureOptions(OptionsResolver $resolver)
    {
        // available options
        $resolver->setDefined($this->_elements);

        // validate / format options
        $resolver->setNormalizer('unitPrice', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('price', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('priceVAT', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('priceSum', $resolver->getNormalizer('float'));
    }
}
