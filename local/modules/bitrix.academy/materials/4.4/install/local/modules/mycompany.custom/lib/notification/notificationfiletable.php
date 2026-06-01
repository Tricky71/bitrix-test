<?php

namespace MyCompany\Custom\Notification;

use Bitrix\Main\Entity;
use Bitrix\Main\Entity\Query\Join;
use Bitrix\Main\FileTable;
use Bitrix\Main\ORM\Fields\Relations\Reference;

class NotificationFileTable extends Entity\DataManager
{
	static function getTableName(): string
	{
		return 'mycmp_notification_file';
	}

	static function getMap(): array
	{
		return array(
			(new Entity\IntegerField('NOTIFICATION_ID'))
				->configurePrimary(),
			(new Reference('NOTIFICATION', NotificationTable::class,
				Join::on('this.NOTIFICATION_ID', 'ref.ID')))
				->configureJoinType('inner'),
			(new Entity\IntegerField('FILE_ID'))
				->configurePrimary(),
			(new Reference('FILE', FileTable::class,
				Join::on('this.FILE_ID', 'ref.ID')))
				->configureJoinType('inner')
		);
	}
}
