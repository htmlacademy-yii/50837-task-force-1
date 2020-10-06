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
     * @return string
     */
    public function getName(): string
    {
        return 'Отказаться';
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getCode(): string
    {
        return 'refuse';
    }

    /**
     * Отказаться может только авторизованный пользовтель, который является исполнителем.
     * @param integer $userId Текущий пользователь
     * @param integer $authorId Автор задачи
     * @param integer|null $performerId Исполнитель
     *
     * @return boolean
     */
    public function isAvailable(int $userId, int $idCustomer, ?int $idExecutor): bool
    {
        return($userId == $idExecutor);
    }
}
