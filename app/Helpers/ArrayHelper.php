<?php

namespace App\Helpers;

/**
 * Class ArrayHelper contains helper methods for working with arrays.
 *
 * @package App\Helpers
 * @author Gbadebo Oyelakin<gbadebo.oyelakin@supermartng.com>
 */
class ArrayHelper
{


    /**
     * Unsets the entry with the key $key from the array and returns the value.
     *
     * Example:
     * $arr = ['orange', 'black', 'gold'];
     * $value2 = Helper:removeAndReturnArrayValue($arr, 2);
     * var_dump($value2); // "string" gold
     * var_dump($arr); // "array" ['orange', 'black']
     *
     * @param array $array the array to remove and return value from
     * @param string $key the key of the value to be removed and returned
     * @return mixed the value at the key $key
     */
    public static function removeAndReturnArrayValue(array &$array, string $key)
    {
        $value = $array[$key];
        unset($array[$key]);
        return $value;
    }

    /**
     * A to array method to fix the issue of moloquent not parsing dates to string
     */
    public static function toArray($object)
    {
        $array = [];
        foreach ($object as $key => $value) {
            if (is_array($value) || $value instanceof \Traversable) {
                $array[$key ?? 0] = self::toArray($value);
            } else {
                $array[$key ?? 0] = (string)$value;
            }
        }
        return $array;
    }

    /**
     * Removes values from an array by keys. It maintains key association
     *
     * @param array $array array to remove values from
     * @param array $keys the keys of elements to remove from the array
     * @return array the array with the specified keys removed
     */
    public static function removeValuesByKey(array $array, array $keys)
    {
        foreach ($keys as $key) {
            unset($array[$key]);
        }
        return $array;
    }

    /**
     * Returns an array containing only the values that have their keys
     * specified in the $keys array. It maintains key association.
     *
     * @param array $array source array to get values from
     * @param array $keys array containing the keys of values to be returned
     * @return array an array with only the values whose keys are specified in
     * the $keys array returned
     */
    public static function getValuesByKey(array $array, array $keys)
    {
        $returnArray = [];
        foreach ($keys as $index => $key) {
            if (is_array($key)) {
                if ($index == '*') {
                    $nestedArrayData = [];
                    foreach ($array as $item) {
                        $nestedArrayData[] = self::getValuesByKey($item, $key);
                    }
                    return $nestedArrayData;
                } elseif (!empty($array[$index]) && is_array($array[$index])) {
                    $returnArray[$index] = self::getValuesByKey($array[$index], $key);
                }
            } elseif (isset($array[$key])) {
                $returnArray[$key] = $array[$key];
            }
        }
        return $returnArray;
    }

    /**
     * ArrayMapRecursive implements recursive array mapping for an array so
     * that all elements and sub-elements in the array have the callback applied
     * to it.
     *
     * @param array $array the array to perform array mapping on
     * @param callable $callback the callback to call on every member of the array
     * @return array a new array which is the result of the callback being applied
     * to every member and sub-member of the input array
     */
    public static function arrayMapRecursive(array $array, callable $callback)
    {
        $mappedArray = [];
        foreach ($array as $key => $value) {
            $mappedArray[$key] = is_array($value) ?
                self::arrayMapRecursive($value) : $callback($value);
        }
        return $mappedArray;
    }

    /**
     * Utility method to use in searching an array. It's very useful in
     * extracting values of matching keys from an array.
     *
     *
     * @param string $query the key to use to locate the value to be returned. It
     * supports '*' to use to search within arrays(e.g the query 'response.users.*.email',
     * will return(assuming response.users resolves to an array) all values from the
     * array whose key is users and whose sub-arrays has a key called email.
     * @param array $data the data to search through
     * @return array|mixed|null the resolved value
     * @throws \Exception
     */
    public static function queryArray(string $query, array $data)
    {
        $splitKey = explode(".", $query);
        $value = $data;
        $return = null;
        $predicateHelper = function ($value, $operand, $compare) {
            switch ($operand) {
                case "<":
                    $status = $value < $compare;
                    break;
                case ">":
                    $status = $value > $compare;
                    break;
                case "<=":
                    $status = $value <= $compare;
                    break;
                case ">=":
                    $status = $value >= $compare;
                    break;
                case "==":
                    $status = $value == $compare;
                    break;

                default:
                    throw new \Exception("Unsupported operand for predicate: $operand");
            }
            return $status;
        };
        foreach ($splitKey as $index => $subKey) {
            if ($subKey == "*") {
                $newKey = implode(".", array_slice($splitKey, $index + 1));
                if (empty($newKey)) {
                    return $value;
                } elseif (is_array($value)) {
                    $newValue = [];
                    foreach ($value as $subValue) {
                        $newValue[] = self::queryArray($newKey, $subValue);
                    }
                    return $newValue;
                } else {
                    return self::queryArray($newKey, $value);
                }
            }
            //check for predicates
            if (preg_match('/^\[.+\]$/i', $subKey)) {
                $subKey = preg_replace("/\s|\[|\]/", "", $subKey);
                $predicateSplit = preg_split("/>|<|<=|>=|==/", $subKey);
                if (count($predicateSplit) !== 2) {
                    throw new \Exception("Invalid predicate: $subKey");
                }
                $operand = preg_replace("/$predicateSplit[0]|$predicateSplit[1]/i", "", $subKey);
                if (!$predicateHelper($value[$predicateSplit[0]], $operand, $predicateSplit[1])) {
                    continue;
                }
                $subKey = $predicateSplit[0];
            }
            $return = $value = $value[$subKey] ?? null;
            if ($value == null) {
                break;
            }
        }
        return $return;
    }

    /**
     * Creates a new array from the source array using the resulting array from calling
     * ArrayHelper::queryArray with $keyQuery as keys, and the array returned from
     * ArrayHelper::queryArray($valueQuery) as values.
     *
     * @param array $source the source array
     * @param string $keyQuery the key to use to locate the value to be returned. It
     * supports '*' to use to search within arrays(e.g the query 'response.users.*.email',
     * will return(assuming response.users resolves to an array) all values from the. This is
     * the first argument to ArrayHelper::queryArray
     * @param string $valueQuery the key to use to locate the value to be returned. It
     * supports '*' to use to search within arrays(e.g the query 'response.users.*.email',
     * will return(assuming response.users resolves to an array) all values from the. This is
     * the first argument to ArrayHelper::queryArray
     * @return array a new associative array
     * @throws \Exception
     */
    public static function newArrayWithKeyAndValue(array $source, string $keyQuery, string $valueQuery)
    {
        $result = [];
        $keys = self::queryArray($keyQuery, $source);
        $value = self::queryArray($valueQuery, $source);
        for ($i = 0; $i < count($value); $i++) {
            if (isset($keys[$i])) {
                $result[$keys[$i]] = $value[$i];
            } else {
                $result[] = $value[$i];
            }
        }
        return $result;
    }
}
