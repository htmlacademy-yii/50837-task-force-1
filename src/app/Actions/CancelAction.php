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
     * отменить может задачу в статусе new только авторизованный пользовтель,
     * который является автором
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
