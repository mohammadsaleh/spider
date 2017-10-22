<?php
/**
 * Created by PhpStorm.
 * User: MohammadSaleh
 * Date: 10/22/2017
 * Time: 3:30 PM
 */

namespace Spider\Lib;


trait MapFieldTrait
{

    /**
     * Standard output of fields of array
     * For example:
     * [
     *  'departure_gdate'   => '_getDepartureGDate', // This value is a function
     *  'flight_number',
     *  'departure_jdate'
     * ]
     * @var array
     */
//    protected $_outputFields;


    private $__outputFields;

    /**
     * Contain index of old array to renaming to value.
     * For example:
     * [
     *  'flnum'             => 'flight_number', // Rename flnum index to 'flight_number'
     *  'fldate'            => ['key' => 'departure_jdate', 'value' => '_formatDepartureJDate'], // This value is a function name
     *  'departure_gdate'   => '_getDepartureGDate', // This value is a function name
     *  'name'              => 'saleh' // This index => value will be added to array, if "name" is not present in index of old array
     * ]
     *
     * @var array
     */
//    protected $_mapFields;

    private $__mapFields;

    /**
     * Map $_mapFields fields name and Return Standardized fields base on $_outputFields
     *
     * @param array $data
     * @return array
     */
    protected function _mapFields(Array $data = [])
    {
        $this->__setMapFields();
        $this->__setOutputFields();

        foreach($this->__getMapFields() as $fromField => $toField){
            $value = null;
            $mapKey = $fromField;
            $mapValue = $toField;
            if(isset($data[$fromField])){
                $value = $data[$fromField];
                $mapKey = $toField;
                $mapValue = $value;
            }
            if(is_array($toField)){
                $toField = array_merge(['value' => $value, 'key' => $fromField], $toField);
                $mapKey = $toField['key'];
                $mapValue = $toField['value'];
            }
            if(method_exists($this, $mapValue)){
                $mapValue = $this->{$mapValue}($value, $data);
            }
            $data[$mapKey] = $mapValue;
        }
        $data = array_intersect_key($data, array_flip($this->__getOutputFields()));
        $data = array_merge(array_fill_keys($this->__getOutputFields(), null), $data);
        return $data;
    }

    private function __setMapFields()
    {
        $callableStandardFields = array_filter($this->_outputFields,
            function($value, $key){
                return !is_integer($key);
            },
            ARRAY_FILTER_USE_BOTH
        );
        $this->__mapFields = array_merge($callableStandardFields, $this->_mapFields);
    }

    private function __getMapFields()
    {
        return $this->__mapFields;
    }

    private function __setOutputFields()
    {
        $this->__outputFields = $this->_outputFields;
        array_walk($this->__outputFields, function(&$value, $key){
            $value = is_integer($key) ? $value : $key;
        });
        $this->__outputFields = array_values($this->__outputFields);
    }

    private function __getOutputFields()
    {
        return $this->__outputFields;
    }
}