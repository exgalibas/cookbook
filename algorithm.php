<?php
/**
 * Date: 2018/3/7
 * @author joker <exgalibas@gmail.com>
 */

// sort algorithm

// insert sort
/**
 * @param array $arr
 * @return array
 */
function insertSort(array  $arr)
{
    if (($count = count($arr)) <= 1) {
        return $arr;
    }

    $length = count($arr);
    for ($i = 1; $i < $length; $i++)
    {
        $key = $arr[$i];
        $j = $i-1;
        while ($j >= 0 && $arr[$j] > $key) {
            $arr[$j+1] = $arr[$j];
            $j--;
        }
        $arr[$j+1] = $key;
    }

    return $arr;
}


// merge sort
/**
 * @param array $arr
 * @param $start
 * @param $end
 */
function mergeSort(array &$arr, $start, $end)
{
    if ($start < $end) {
        $middle = floor(($start + $end)/2);

        mergeSort($arr, $start, $middle);
        mergeSort($arr,$middle+1, $end);
        merge($arr, $start, $middle, $end);
    }
}

/**
 * @param array $arr
 * @param $start
 * @param $middle
 * @param $end
 */
function merge(array &$arr, $start, $middle, $end)
{
    $first_count = $middle - $start +1;
    $first = array_slice($arr, $start, $first_count);

    $second_count = $end - $middle;
    $second = array_slice($arr, $middle+1, $second_count);

    $i = 0;
    $j = 0;
    while ($start <= $end) {
        if ($i >= $first_count) {
            $arr[$start] = $second[$j++];
        } else if ($j >= $second_count) {
            $arr[$start] = $first[$i++];
        } else if ($first[$i] <= $second[$j]) {
            $arr[$start] = $first[$i++];
        } else {
            $arr[$start] = $second[$j++];
        }
        $start++;
    }
}

// quick sort
/**
 * @param $arr
 * @param $start
 * @param $end
 */
function quickSort(&$arr, $start, $end)
{
    if ($start >= $end || $start < 0)
        return;

    $mid = $arr[$end];
    $left = $start;
    $right = $end-1;
    while ($left < $right) {
        while ($arr[$left] < $mid && $left < $right) {
            $left++;
        }

        while ($arr[$right] >= $mid && $left < $right) {
            $right--;
        }

        $tmp = $arr[$left];
        $arr[$left] = $arr[$right];
        $arr[$right] = $tmp;

        if ($arr[$left] >= $mid) {
            $tmp = $arr[$left];
            $arr[$left] = $arr[$end];
            $arr[$end] = $tmp;
        } else {
            $left++;
        }
    }


    quickSort($arr, $start, $left-1);
    quickSort($arr, $left+1, $end);
}



