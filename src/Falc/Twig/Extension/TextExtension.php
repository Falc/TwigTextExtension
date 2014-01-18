<?php
/**
 * This file contains the TextExtension class.
 *
 * @author      Aitor García (Falc) <aitor.falc@gmail.com>
 * @copyright   2014 Aitor García (Falc) <aitor.falc@gmail.com>
 * @license     MIT
 */

namespace Falc\Twig\Extension;

/**
 * Contains some text filters.
 */
class TextExtension extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('hash', array($this, 'hash')),
        );
    }

    /**
     * Generates a hash value.
     *
     * @param   string      $data       Data to be hashed.
     * @param   string      $algorithm  Name of selected hashing algorithm (i.e. "md5", "sha256", "haval160,4", etc..).
     * @param   boolean     $rawOutput  When set to True, outputs raw binary data. False outputs lowercase hexits.
     */
    public function hash($data, $algorithm, $rawOutput = false)
    {
        return hash($algorithm, $data, $rawOutput);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'falc_text';
    }
}
