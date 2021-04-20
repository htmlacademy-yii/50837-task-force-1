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
     */
    public function getName(): string
    {
        return 'провалено';
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getCode(): string
    {
        return 'reject';
    }

    /**
     * Может ли пользовтель отклонить не принять задачу.
     *
     * {@inheritdoc}
     */
    public function isAvailable(int $userId, int $idCustomer, ?int $idExecutor, string $role): bool
    {
        $isAuthor = ($userId === $idCustomer);

        return $role === 'customer' && $isAuthor;
    }
}
