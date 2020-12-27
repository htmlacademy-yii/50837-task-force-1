<?php

namespace Sergei404\Actions;

/**
 * Класс для действия "отказаться от задачи"
 */
class RefuseAction extends Action
{
    /**
     * {@inheritdoc}
     *
     */
    public function getName(): string
    {
        return 'Отказаться';
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getCode(): string
    {
        return 'refuse';
    }

    /**
     * Отказаться от задачи может только авторизованный пользовтель, который является исполнителем, роль - 'executor'.
     *
     * {@inheritdoc}
     */
    public function isAvailable(int $userId, int $idCustomer, ?int $idExecutor, string $role): bool
    {
        $isExecutor = ($userId == $idExecutor);

        return $role === 'executor' && $isExecutor;
    }
}
