<?php
/**
 * Date: 2017/12/6
 * @author joker <tanlin@staff.weibo.com>
 */
class myIterator implements Iterator
{
    /**
     * @var array
     */
    private $arr;
    private $valid = false;

    public function __construct(array $arr)
    {
        $this->arr = $arr;
    }

    public function current()
    {
        // if return null/false will not stop foreach,it just return
        return current($this->arr);
    }

    public function next()
    {
        $this->valid = (bool)(false !== next($this->arr));
    }

    public function key()
    {
        // if return null/false will not stop foreach,it just return
        return key($this->arr);
    }

    public function rewind()
    {
        $this->valid = (bool)(false !== reset($this->arr));
    }

    public function valid()
    {
        return $this->valid;
    }
}

$arr = new myIterator([1,2,3]);
foreach ($arr as $key => $value) {
    var_dump("$key => $value\n");
}

// u can also foreach like this
$arr->rewind();
while ($arr->valid()) {
    $key = $arr->key();
    $value = $arr->current();
    $arr->next();
    var_dump("$key => $value\n");
}