<?php

namespace Sergei404\Actions;

/**
 * Класс для действия "выполнить задачу"
 */
class AcceptAction extends Action
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'Выполнить';
    }

    /**
     * {@inheritdoc}
     */
    public function getCode(): string
    {
        return 'perform';
    }

    /**
     * принять задачу может только авторизованный пользовтель, который является автором задачи и ролью - 'customer'
     *
     * {@inheritdoc}
     */
    public function isAvailable(int $userId, int $idCustomer, ?int $idExecutor,
    string $role): bool
    {
        $isAuthor = ($userId == $idCustomer && $userId != $idExecutor);

        return $role === 'customer' && $isAuthor;
    }
}
