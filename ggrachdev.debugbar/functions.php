<?php

/**
 * Красивая подсветка дебага
 * 
 * @param type $data
 * @return type
 */
function ggrach_highlight_data($data = [], $needHideBlocks = false) {

    $viewResult = '';

    $highlightItem = function ($in, $opened, $margin = 5) use (&$highlightItem, $needHideBlocks) {

        $viewRes = '';

        if (!\is_object($in) && !\is_array($in)) {
            return $in;
        }

        if ($needHideBlocks == true) {
            $opened = '';
        }

        foreach ($in as $key => $value) {
            if (\is_object($value) || \is_array($value)) {
                $viewRes .= '<details style="margin-left:' . $margin . 'px" ' . $opened . '>';
                $viewRes .= '<summary style="cursor: pointer; margin-top: 5px; margin-bottom: 5px; text-decoration: underline;">';
                $viewRes .= (is_object($value)) ? $key . ' {' . count((array) $value) . '}' : $key . ' [' . count($value) . ']';
                $viewRes .= '</summary>';
                $viewRes .= $highlightItem($value, $opened, $margin + 5);
                $viewRes .= '</details>';
            } else {
                switch (gettype($value)) {
                    case 'string':
                        $bgc = 'red';
                        $value = \strip_tags($value);
                        if (\strlen($value) > 200) {
                            $value = '[Very long string]';
                        }

                        break;
                    case 'integer':
                        $bgc = 'green';
                        break;
                }
                $viewRes .= '<div style="margin-left:' . $margin . 'px">' . $key . ' : '
                    . '<span style="color:' . $bgc . '">' . $value . '</span>  '
                    . '<span style="color: blue;">(' . gettype($value) . ')</span>'
                    . '</div>';
            }
        }

        return $viewRes;
    };

    $highlight = function ($in, $opened = true) use ($highlightItem) {

        $view = '<div>';

        if ($opened) {
            $opened = ' open';
        }

        if (is_object($in) or is_array($in)) {
            $view .= '<details' . $opened . '>';
            $view .= '<summary style="cursor: pointer; margin-top: 5px; margin-bottom: 5px; text-decoration: underline;">';
            $view .= (is_object($in)) ? 'Object {' . count((array) $in) . '}' : 'Array [' . count($in) . ']';
            $view .= '</summary>';
            $view .= $highlightItem($in, $opened);
            $view .= '</details>';
        } else {
            switch (gettype($in)) {
                case 'string':
                    $bgc = 'red';

                    $in = \strip_tags($in);

                    if (\strlen($in) > 200) {
                        $in = '[Очень длинная строка]';
                    }

                    break;
                case 'integer':
                    $bgc = 'green';
                    break;
            }

            $view .= '<div style="margin-left: 0px">'
                . '<span style="color:' . $bgc . '">' . $in . '</span>  '
                . '<span style="color: blue;">(' . gettype($in) . ')</span>'
                . '</div>';
        }


        $view .= '</div>';


        return $view;
    };

    $viewResult .= $highlight($data, !$needHideBlocks);

    return $viewResult;
}
