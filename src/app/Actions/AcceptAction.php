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
     * выполнить действие может только авторизованный пользовтель, который является автором задачи
     * @param integer $userId Текущий пользователь
     * @param integer $idCustomer Автор задачи
     * @param integer|null $idExecutor Исполнитель
     *
     * @return boolean
     */
    public function isAvailable(int $userId, int $idCustomer, ?int $idExecutor,
    string $role): bool
    {
        $isAuthor = ($userId == $idCustomer && $userId != $idExecutor);

        return $role === 'customer' && $isAuthor;
    }
}
