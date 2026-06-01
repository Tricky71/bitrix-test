<?php

namespace MyCompany\Custom\Notification;

use Bitrix\Main\Entity;
use Bitrix\Main\Entity\Query\Join;
use Bitrix\Main\FileTable;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\UserTable;

class NotificationTable extends Entity\DataManager
{
	static function getTableName(): string
	{
		return 'mycmp_notification';
	}

	static function getMap(): array
	{
		return array(
			(new Entity\IntegerField('ID'))
				->configurePrimary()
				->configureAutocomplete(),
			(new Entity\DatetimeField('DATE_CREATE'))
				->configureRequired()
				->configureDefaultValue(new DateTime()),
			(new Entity\DatetimeField('DATE_MODIFY'))
				->configureRequired()
				->configureDefaultValue(new DateTime()),
			(new Entity\StringField('TITLE'))
				->configureRequired()
				->addValidator(new LengthValidator(0, 250)),
			(new Entity\TextField('MESSAGE'))
				->configureRequired(),
			(new Entity\IntegerField('USER_ID'))
				->configureRequired(),
			(new Reference('USER', UserTable::class, Join::on('this.USER_ID', 'ref.ID')))
				->configureJoinType('inner'),
			(new ManyToMany('FILES', FileTable::class))
				->configureTableName('mycmp_notification_file'),
			new Entity\BooleanField('IS_READ'),
			new Entity\BooleanField('IS_IMPORTANT'),
		);
	}
}
