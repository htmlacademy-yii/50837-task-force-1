<?php

namespace Sergei404\Actions;

/**
 * Класс для действия "отклик на задачу"
 */
class AnswerAction extends Action
{
    /**
     * {@inheritdoc}
     *
     */
    public function getName(): string
    {
        return 'Откликнуться';
    }

    /**
     * {@inheritdoc}
     *
     */
    public function getCode(): string
    {
        return 'answer';
    }

    /**
     * откликнуться может только авторизованный пользовтель, который не является ни автором, ни исполнителем данной
     * задачи, роль - 'executor'.
     *
     * {@inheritdoc}
     */
    public function isAvailable(int $userId, int $idCustomer, ?int $idExecutor, string $role): bool
    {
        $isNewExecutor = ($userId != $idCustomer && $userId != $idExecutor);

        return $role === 'executor' && $isNewExecutor;
    }
}
