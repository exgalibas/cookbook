<?php
/**
 * Date: 2017/9/7
 * @author joker <tanlin@staff.weibo.com>
 */

/**
 * strict param type: class name, interface name, array, callable   version < 7
 * + (int, string...)  version >= 7
 */

/**
 * ## func with variable params
 * function mean()
 * mean(1,2,3,4)
 * func_num_args() => 4
 * func_get_arg($i) => args[$i]
 * func_get_args() => (array)args
 */

/**
 * ## return quote
 * function &mean()
 * $quote =& mean()
 */

/**
 * ## ignore some return
 * list(, $need, ) = func(){ return array(1,2,3) }
 */

/**
 * ## unset global params
 * func(){
 *     global $arr;
 *     unset($arr) != unset($GLOBALS['arr'])
 * }
 */

/**
 * check for php7
 */
function checkPHP7()
{
    if (!defined('PHP_MAJOR_VERSION') || PHP_MAJOR_VERSION < 7) {
        die(
            'Upgrade to php7' . PHP_EOL .
            'Deployer 5.x supports only php7 and above.' . PHP_EOL .
            'If you want to use older php version use Deployer 4.x' . PHP_EOL
        );
    }
}

/**
 * check that our installed curl version supports SSL
 */
function checkCurlSsl()
{
    $curl_version = curl_version();
    if (!(CURL_VERSION_SSL & $curl_version['features'])) {
        return false;
    }
    return true;
}

/**
 * format url by given GET data
 */
function formatUrl($url, $data = null, $append = true)
{
    if (empty($data)) {
        return $url;
    }

    $query = parse_url($url, PHP_URL_QUERY);
    $data = is_array($data) ? http_build_query($data, null, '&') : $data;
    if (!$query) {
        return $url . '?' . $data;
    }

    if ($append) {
        return $url . '&' . $data;
    }

    return str_replace($query, $data, $url);
}

/**
 * check if the specified extension is loaded
 */
function checkExtensionLoad($name)
{
    if (extension_loaded($name)) {
        return true;
    }
    return false;
}


/**
 * call some callable function
 */
function call()
{
    $query = func_get_args();
    if (!$query) return;
    $func = array_shift($query);
    if (!is_callable($func)) return;
    call_user_func_array($func, $query);
}

/**
 * compare php_version
 * @param $version
 * @return mixed
 */
function versionCompare($version)
{
    return version_compare(phpversion(), $version);
}

/**
 * clean decode function with php version
 * @return mixed
 */
function jsonCleanDecode()
{
    //array [json, assoc, depth, options]
    $args = func_get_args();
    if (versionCompare('5.4.0') !== -1) {
        $args = array_slice($args, 0, 4);
    } else if (versionCompare('5.3.0') !== -1) {
        $args = array_slice($args, 0, 3);
    } else {
        $args = array_slice($args, 0, 2);
    }

    $response = call_user_func_array('json_decode', $args);
    if ($response === null) {
        $response = $args[0];
    }
    return $response;
}

/**
 *
 * recursive version of function array_change_key_case()
 * example:
 *  $array = ['A' => ['B' => 1],  'C' => ['D' => 1, 'E' => ['F' => 1]]]
 *  array_change_key_case_recursive($arr, 2, CASE_LOWER)
 * output:
 *  Array
 * (
 * [a] => Array
 * (
 * [b] => 1
 * )
 *
 * [c] => Array
 * (
 * [d] => 1
 * [e] => Array
 * (
 * [F] => 1
 * )
 * )
 * )
 * @param $array
 * @param int $deep
 * @param int $case
 * @return array
 */
function arrayChangeKeyCaseRecursive($array, $deep = 1, $case = CASE_LOWER)
{
    static $count = 0;
    if (!is_array($array) || $count == $deep) {
        return $array;
    }

    $array = array_change_key_case($array, $case);
    $count++;
    $map_function = function ($item) use ($deep, $case) {
        return arrayChangeKeyCaseRecursive($item, $deep, $case);
    };
    $rtn = array_map($map_function, $array);
    $count--;
    return $rtn;
}

/**
 * convert $bytes to K/M/G/T with $precision
 * @param $bytes
 * @param int $precision
 * @return string
 */
function formatSize($bytes, $precision = 2)
{
    $bytes = floatval($bytes);
    $size_map = [
        [
            'unit' => 'TB',
            'value' => pow(1024, 4),
        ],
        [
            'unit' => 'GB',
            'value' => pow(1024, 3),
        ],
        [
            'unit' => 'MB',
            'value' => pow(1024, 2),
        ],
        [
            'unit' => 'KB',
            'value' => 1024,
        ],
        [
            'unit' => 'B',
            'value' => 1,
        ],
    ];

    $unit = 'B';
    foreach ($size_map as $map) {
        if ($bytes >= $map['value']) {
            $bytes = $bytes / $map['value'];
            $unit = $map['unit'];
            break;
        }
    }

    $bytes = round($bytes, $precision);

    return $bytes . ' ' . $unit;
}

/**
 * deployer func
 * getopt
 * is_readable
 * file_exists
 * dirname
 * getcwd
 * set_include_path
 * (new ReflectionMethod)->isStatic
 * file_get_contents
 */