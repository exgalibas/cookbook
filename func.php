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