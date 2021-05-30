<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profiles".
 *
 * @property int $id
 * @property string $address
 * @property string|null $bd
 * @property string|null $about
 * @property string|null $phone
 * @property string|null $skype
 * @property int $user_id
 * @property string|null $telegram
 * @property int|null $notify_of_messages
 * @property int|null $notify_of_actions
 * @property int|null $notify_of_responses
 * @property int|null $show_contacts
 * @property int|null $show_profile
 *
 * @property Users $user
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profiles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address', 'user_id'], 'required'],
            [['bd'], 'safe'],
            [['about'], 'string'],
            [['user_id', 'notify_of_messages', 'notify_of_actions', 'notify_of_responses', 'show_contacts', 'show_profile'], 'integer'],
            [['address'], 'string', 'max' => 256],
            [['phone'], 'string', 'max' => 70],
            [['skype', 'telegram'], 'string', 'max' => 129],
            [['address'], 'unique'],
            [['phone'], 'unique'],
            [['skype'], 'unique'],
            [['telegram'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address' => 'Address',
            'bd' => 'Bd',
            'about' => 'About',
            'phone' => 'Phone',
            'skype' => 'Skype',
            'user_id' => 'User ID',
            'telegram' => 'Telegram',
            'notify_of_messages' => 'Notify Of Messages',
            'notify_of_actions' => 'Notify Of Actions',
            'notify_of_responses' => 'Notify Of Responses',
            'show_contacts' => 'Show Contacts',
            'show_profile' => 'Show Profile',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
