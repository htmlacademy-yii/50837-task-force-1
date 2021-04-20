<?php

namespace Sergei404\Actions;

/**
 * Класс для действия "отменить задачу"
 */
class CancelAction extends Action {
     /**
     * {@inheritdoc}
     *
     */
    public function getName(): string
    {
        return 'Отменить';
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getCode(): string
    {
        return 'cancel';
    }

    /**
     * отменить может задачу в статусе new только авторизованный пользовтель,
     * который является автором и роль - 'customer'.
     *
     * {@inheritdoc}
     */
    public function isAvailable(int $userId, int $idCustomer, ?int $idExecutor, string $role): bool
    {
        $isAuthor = ($userId === $idCustomer);

        return $role === 'customer' && $isAuthor;
    }
}
