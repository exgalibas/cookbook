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
 * @param array $arr
 * @param $start
 * @param $end
 */
function quickSort(array &$arr, $start, $end)
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

// divide-and-conquer strategy
// find the maximum continuous sub-array
/**
 * @param array $arr
 * @param $low
 * @param $mid
 * @param $high
 * @return array|bool
 */
function findMaxMiddleArray(array $arr, $low, $mid, $high)
{
    if ($low < 0 || $low > $mid || $mid > $high)
    {
        return false;
    }

    $i = $left_id = $mid;
    $left_max = $arr[$i];
    $sum = 0;
    while ($i >= $low)
    {
        $sum += $arr[$i];
        if ($sum > $left_max) {
            $left_max = $sum;
            $left_id = $i;
        }
        $i--;
    }

    $i = $right_id = $mid+1;
    $right_max = $arr[$i];
    $sum = 0;

    while ($i <= $high)
    {
        $sum += $arr[$i];
        if ($sum > $right_max) {
            $right_max = $sum;
            $right_id = $i;
        }
        $i++;
    }

    return [$left_id, $right_id, $left_max+$right_max];
}


// heap sort
/**
 * @param array $arr
 * @param $parent
 * @param $heap_size
 */
function maxHeap(array &$arr, $parent, $heap_size)
{
    $left = 2*$parent + 1;
    $right = $left + 1;

    if ($left <= $heap_size && $arr[$left] > $arr[$parent]) {
        $largest = $left;
    } else {
        $largest = $parent;
    }

    if ($right <= $heap_size && $arr[$right] > $arr[$largest]) {
        $largest = $right;
    }

    if ($largest != $parent) {
        $tmp = $arr[$parent];
        $arr[$parent] = $arr[$largest];
        $arr[$largest] = $tmp;

        maxHeap($arr, $largest, $heap_size);
    }
}

/**
 * @param array $arr
 */
function buildMaxHeap(array &$arr)
{
    $length = count($arr);
    $start = floor(($length-2)/2);
    while ($start >= 0) {
        maxHeap($arr, $start, $length-1);
        $start--;
    }
}

/**
 * @param $arr
 */
function heapSort(&$arr)
{
    $heap_size = count($arr);
    if ($heap_size <= 1){
        return;
    }
    $heap_size--;
    buildMaxHeap($arr);
    while ($heap_size > 0) {
        $tmp = $arr[$heap_size];
        $arr[$heap_size] = $arr[0];
        $arr[0] = $tmp;

        $heap_size--;
        maxHeap($arr, 0, $heap_size);
    }
}


