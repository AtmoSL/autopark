<?php

namespace service;

class Validator
{
    /**
     * Проверка на то, что поля не пустые
     * @param array $array
     * @return bool
     */
    protected static function isEmpty(array $array): bool
    {
        foreach ($array as $value) {
            if (empty($value)) return true;
        }
        return false;
    }

    /**
     * Проверка на то, что поле состоит только из букв (англ или рус)
     * @param $field
     * @return bool
     */
    protected static function isOnlyLetters($field):bool
    {
        if (preg_match('/^[\p{Cyrillic}\p{Latin}]+$/u', $field)) {
            return true;
        }

        return false;
    }
}