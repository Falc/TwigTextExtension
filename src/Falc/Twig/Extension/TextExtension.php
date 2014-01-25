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
            new \Twig_SimpleFilter('br2p', array($this, 'br2p'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('hash', array($this, 'hash')),
            new \Twig_SimpleFilter('p2br', array($this, 'p2br'), array('is_safe' => array('html')))
        );
    }

    /**
     * Replaces double linebreaks formatting into paragraphs.
     *
     * Example: 'This is a text.<br /><br>This should be another paragraph.'
     * Output:  '<p>This is a text.</p><p>This should be another paragraph.</p>'
     *
     * @param   string  $data   Text to format.
     * @return  string          Formatted text.
     */
    public function br2p($data)
    {
        // Remove trailing <br> tags.
        $data = preg_replace('#(<br\s*/?>)*$#', '', $data);

        // Replace groups of <br>'s with <p> tags.
        $data = preg_replace('#(?:<br\s*/?>\s*?){2,}#', '</p><p>', $data);

        return '<p>'.$data.'</p>';
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
     * Replaces paragraph formatting with double linebreaks.
     *
     * Example: '<p>This is a text.</p><p>This should be another paragraph.</p>'
     * Output:  'This is a text.<br /><br>This should be another paragraph.'
     *
     * @param   string  $data   Text to format.
     * @return  string          Formatted text.
     */
    public function p2br($data)
    {
        // Remove opening <p> tags
        $data = preg_replace('#<p[^>]*?>#', '', $data);

        // Remove trailing </p> to prevent it to be replaced with unneeded <br />
        $data = preg_replace('#</p>$#', '', $data);

        // Replace each end of paragraph with two <br />
        $data = str_replace('</p>', '<br /><br />', $data);

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'falc_text';
    }
}
