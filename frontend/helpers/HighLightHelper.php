<?php
/**
 * Created by PhpStorm.
 * User: 55555
 * Date: 16.09.2018
 * Time: 11:35
 */

namespace frontend\helpers;

class HighLightHelper
{
    /**
     * @param $keyword string
     * @param $content string
     * @return string
     *
     * подчёркивает текст в переданном массиве
     */
    public static function process($keyword, $content)
    {
        $keyword = preg_quote($keyword);

        $words = explode(' ', trim($keyword));

        return preg_replace('/' . implode('|', $words) . '/i', '<b>$0</b>', $content);
    }
}