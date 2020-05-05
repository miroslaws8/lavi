<?php

namespace bundle;

class Validator
{
    public function validate(array $data, array $rules = [])
    {
        if (empty($data)) {
            throw new \Exception('Validate data is empty');
        }

        if (empty($rules)) {
            return true;
        }

        $newData = [];
        foreach ($rules as $field => $rule) {
            if (!array_key_exists($field, $data)) {
                $this->addError($field, $field.' required!');
            }

            foreach ($rule as $key => $value) {
                if (!method_exists($this, $key)) {
                    throw new \Exception('Undefined rule');
                }

                call_user_func_array([$this, $key], [$data, $field, $value]);
            }

            $newData[$field] = is_array($data[$field]) ?
                $data[$field] : htmlspecialchars($data[$field]);
        }

        return $newData;
    }

    private function email($data, $field, $option)
    {
        if (!filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, $field.'  has an invalid e-mail!');
            return false;
        }

        return true;
    }

    private function type($data, $field, $option)
    {
        $availableTypes = ['integer', 'double', 'NULL', 'object', 'string'];
        $type           = gettype($data[$field]);

        if (!in_array($type, $availableTypes)) {
            throw new \Exception('Undefined type!');
        }

        if (strtolower($option) == gettype($data[$field])) {
            $this->addError($field, $field.' must be of type '.$option);
        }

        return true;
    }

    private function required($data, $field, $option)
    {
        if ($option === false) {
            return true;
        }

        if (empty($data[$field])) {
            $this->addError($field, $field.' required!');
            return false;
        }

        return true;
    }

    public function addError($field, string $error) : void
    {
        Session::setError($field, $error);
    }

    public function getError()
    {
        if (empty(Session::get('errors'))) {
            return false;
        }

        $error = array_shift($_SESSION['errors']);

        return $error;
    }
}