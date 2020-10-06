<?php

namespace Sergei404\Actions;

/**
 * Класс для действия "выполнить задачу"
 */
class AcceptAction extends Action
{
    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getName(): string
    {
        return 'Выполнить';
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getCode(): string
    {
        return 'perform';
    }

    /**
     * выполнить может только авторизованный пользовтель, который является автором
     * @param integer $userId Текущий пользователь
     * @param integer $authorId Автор задачи
     * @param integer|null $performerId Исполнитель
     *
     * @return boolean
     */
    public function isAvailable(int $userId, int $idCustomer, ?int $idExecutor): bool
    {
        return ($userId == $idCustomer && $userId != $idExecutor);
    }
}
