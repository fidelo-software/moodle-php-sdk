<?php namespace MoodleSDK\Api;

abstract class ModelBaseList extends ModelBase implements \ArrayAccess, \Countable
{

    protected $list = [];
    protected $rawData = [];

    public abstract function all(ApiContext $apiContext);

    // ModelBase Methods

    public function fromJSON($data)
    {
        $listType = get_called_class();
        $itemType = substr($listType, 0, strlen($listType) - strlen('List'));

        $data = json_decode($data);

        foreach ($data as $itemData) {
            $item = new $itemType();
            $item->fromArray($itemData);

            $this->list[] = $item;
            $this->rawData[] = (array)$itemData;
        }
    }

    // ArrayAccess Methods

    public function offsetExists($offset)
    {
        return isset($this->list[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->list[$offset]) ? $this->list[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->list[] = $value;
        } else {
            $this->list[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->list[$offset]);
    }

    public function getRaw()
    {
        return $this->rawData;
    }

    // Countable Methods

    public function count()
    {
        return count($this->list);
    }
}
