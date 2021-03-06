<?php
/**
 * This file contains the TextExtension class.
 *
 * @author      Aitor García (Falc) <aitor.falc@gmail.com>
 * @copyright   2014-2015 Aitor García (Falc) <aitor.falc@gmail.com>
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
            new \Twig_SimpleFilter('p2br', array($this, 'p2br'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('paragraphs_slice', array($this, 'paragraphs_slice'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('regex_replace', array($this, 'regex_replace')),
            new \Twig_SimpleFilter('repeat', array($this, 'repeat'))
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
     * Extracts paragraphs from a string.
     *
     * This function uses array_slice(). The function signatures are similar.
     *
     * @see     http://www.php.net/manual/en/function.array-slice.php
     *
     * @param   string      $text       String containing paragraphs.
     * @param   integer     $offset     Number of paragraphs to offset. Default: 0.
     * @param   integer     $length     Number of paragraphs to extract. Default: null.
     * @return  string[]
     */
    public function paragraphs_slice($text, $offset = 0, $length = null)
    {
        $result = array();
        preg_match_all('#<p[^>]*>(.*?)</p>#', $text, $result);

        // Null length = all the paragraphs
        if ($length === null) {
            $length = count($result[0]) - $offset;
        }

        return array_slice($result[0], $offset, $length);
    }

    /**
     * Performs a regular expression search and replace.
     *
     * @see     http://php.net/manual/en/function.preg-replace.php
     *
     * @param   string  $subject        String or array of strings to search and replace.
     * @param   mixed   $pattern        Pattern to search for. It can be either a string or an array with strings.
     * @param   mixed   $replacement    String or array with strings to replace.
     * @param   integer $limit          Maximum possible replacements for each pattern in each subject string. Default is no limit.
     * @return  string
     */
    public function regex_replace($subject, $pattern, $replacement, $limit = -1)
    {
        return preg_replace($pattern, $replacement, $subject, $limit);
    }

    /**
     * Repeats a string.
     *
     * @see     http://php.net/manual/en/function.str-repeat.php
     *
     * @param   string      $string     String to repeat.
     * @param   integer     $num        Number of times.
     * @return  string
     */
    public function repeat($string, $num)
    {
        return str_repeat($string, $num);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'falc_text';
    }
}
