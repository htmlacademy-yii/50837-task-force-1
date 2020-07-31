<?php

use Sergei404\Actions\Action;

/**
 * Класс для действия "отклик на задачу"
 */
class AnswerAction extends Action
{
    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function getName(): string
    // public function getTitle(): string
    {
        return 'Откликнуться';
    }

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function getCode()
    {
        // return 'AnswerAction';
        // Возвращает класс вместе с нэйспейсом.
        return static::class;
    }

    /**
     * Откликнуться на задачу может только не автор задачи и не исполнитель задачи при условии что он есть
     * ...только авторизованный пользовтель, ноторый не является ни ватором, ни исполнителем данной задачи.
     *
     * На заметку: По идее исполнителем пможет быть только пользователь, который в контексте всей системы является
     * исполнителем, но по условию задания этого проверять не требуется, так что пока эту проверку игнорирую.
     *
     * @param integer $userId Текущий пользователь
     * @param integer $authorId Автор задачи
     * @param integer|null $performerId Исполнитель
     *
     * @return boolean
     */
    public function isAvailable(int $userId, int $authorId, ?int $performerId): bool
    {
        return true;
    }
}
