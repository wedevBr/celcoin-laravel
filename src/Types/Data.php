<?php

namespace WeDevBr\Celcoin\Types;

use Illuminate\Contracts\Support\Arrayable;
use Psr\Http\Message\ResponseInterface;
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
                if (isset($rp) && (is_string($val) || is_int($val)) && enum_exists($rp->getType()->getName())) {
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
     */
    public function __set(string $key, mixed $value)
    {
        $this->attributes[$key] = $value;
    }

    /**
     * Get a value
     *
     * @return mixed
     */
    public function __get(string $key)
    {
        return $this->attributes[$key] ?? null;
    }

    /**
     * Check if a key is set
     *
     * @return bool
     */
    public function __isset(string $key)
    {
        return isset($this->attributes[$key]);
    }

    public function toArray(): array
    {
        $vars = get_object_vars($this);
        $array = [];

        foreach ($vars as $key => $value) {
            if ($value instanceof self) {
                $value = $value->toArray();
            } elseif (is_array($value) && $key != 'attributes') {
                foreach ($value as &$valueVal) {
                    if ($valueVal instanceof self) {
                        $valueVal = $valueVal->toArray();
                    }
                }
            } elseif ($value instanceof UnitEnum) {
                $value = $value->value;
            }
            $array[$key] = $value;
        }

        return $array;
    }
}
