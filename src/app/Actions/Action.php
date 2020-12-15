<?php

namespace Sergei404\Actions;


abstract class Action
{
    /**
     * Человекопонятное имя действия
     *
     * @return string
     */
    abstract public function getName(): string;

    /**
     * Название действия в системе
     *
     * @return string
     */
    abstract public function getCode(): string;


    /**
     * Метод проверки прав
     *
     * @return bool
     */
    abstract public function isAvailable(int $userId, int $idCustomer, ?int $idExecutor, string $role): bool;
}
