<?php

namespace WeDevBr\Celcoin\Types;

use Illuminate\Contracts\Support\Arrayable;
use Psr\Http\Message\ResponseInterface;
use ReflectionClass;
use ReflectionProperty;
use UnitEnum;

abstract class Data implements Arrayable
{
    /**
     * Private internal struct attributes
     */
    protected array|ResponseInterface $attributes = [];

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $val) {
            if (property_exists($this, $key)) {
                $rp = new ReflectionProperty($this, $key);
                if (isset($rp) && enum_exists($rp->getType()->getName())) {
                    $val = call_user_func([$rp->getType()->getName(), 'from'], $val);
                }
                $this->$key = $val;
                continue;
            }

            $this->attributes[$key] = $val;
        }
    }

    /**
     * Set a value
     * @param string $key
     * @param mixed $value
     */
    public function __set(string $key, mixed $value)
    {
        $this->attributes[$key] = $value;
    }

    /**
     * Get a value
     * @param string $key
     * @return mixed
     */
    public function __get(string $key)
    {
        return $this->attributes[$key] ?? null;
    }

    /**
     * Check if a key is set
     * @param string $key
     * @return bool
     */
    public function __isset(string $key)
    {
        return isset($this->attributes[$key]);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $vars = get_object_vars($this);
        $array = [];

        foreach ($vars as $key => $value) {
            if ($value instanceof self) {
                $value = $value->toArray();
            } else if (is_array($value) && $key != 'attributes') {
                foreach ($value as &$valueVal) {
                    if ($valueVal instanceof self) {
                        $valueVal = $valueVal->toArray();
                    }
                }
            } else if ($value instanceof UnitEnum) {
                $value = $value->value;
            }
            $array[$key] = $value;
        }

        return $array;
    }
}
