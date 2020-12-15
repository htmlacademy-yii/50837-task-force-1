<?php

namespace Sergei404\Actions;

/**
 * Класс для действия "отклик на задачу" в плане задача выполнена
 * плохо либо не выполнена вообще
 */
class RejectAction extends Action
{
    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getName(): string
    {
        return 'провалено';
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getCode(): string
    {
        return 'reject';
    }

    /**
     * Может ли пользовтель отклонить задачу.
     *
     * @param integer $userId Текущий пользователь
     * @param integer $idCustomer Автор задачи
     * @param integer|null $idExecutor Исполнитель
     *
     * @return boolean
     */
    public function isAvailable(int $userId, int $idCustomer, ?int $idExecutor, string $role): bool
    {
        $isAuthor = ($userId === $idCustomer);

        return $role === 'customer' && $isAuthor;
    }
}
