<?php

namespace Sergei404\Actions;

/**
 * Класс для действия "отменить задачу"
 */
class CancelAction extends Action {
     /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getName(): string
    {
        return 'Отменить';
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getCode(): string
    {
        return 'cancel';
    }

    /**
     * отменить может только авторизованный пользовтель,
     * который является автором
     * @param integer $userId Текущий пользователь
     * @param integer $authorId Автор задачи
     * @param integer|null $performerId Исполнитель
     *
     * @return boolean
     */
    public function isAvailable(int $userId, int $idCustomer, ?int $idExecutor): bool
    {
        return ($userId == $idCustomer);
    }
}
