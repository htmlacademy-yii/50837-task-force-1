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
     * @param integer $authorId Автор задачи
     * @param integer|null $performerId Исполнитель
     *
     * @return boolean
     */
    public function isAvailable(int $userId, int $authorId, ?int $performerId): bool
    {
        // if($userId != $authorId && $performerId != $userId) {
        //     return true;
        // }
        // return false;

        $isPerformer = ($performerId === $userId);
        // $isPerformer = ($performerId === $userId);

        return ($userId != $authorId && !$isPerformer);
    }
}
