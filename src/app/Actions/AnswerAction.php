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
     * @return string
     */
    public function getName(): string
    {
        return 'Откликнуться';
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getCode(): string
    {
        return 'answer';
    }

    /**
     * откликнуться может только авторизованный пользовтель, ноторый не является ни автором, ни исполнителем данной
     * задачи.
     *
     * @param integer $userId Текущий пользователь
     * @param integer $$idCustomer Автор задачи
     * @param integer|null $idExecutor Исполнитель
     *
     * @return boolean
     */
    public function isAvailable(int $userId, int $idCustomer, ?int $idExecutor): bool
    {
        return ($userId != $idCustomer && $idExecutor != $userId);
    }
}
