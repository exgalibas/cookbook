<?php
/**
 * Date: 2017/6/6
 * @author joker <tanlin@staff.weibo.com>
 */
if (!function_exists('reverse_word')) {

    /**
     * reverse sentences with words by $split
     * @param $words
     * @param string $split
     * @return bool|string
     */
    function reverse_word($words, $split = ' ') {
        $array_words = explode($split, $words);
        if(!is_array($array_words) || empty($array_words)) {
            return false;
        }

        $reverse_array = array_reverse($array_words);
        $reverse_words = implode($split, $reverse_array);
        return $reverse_words;
    }
}