<?php B_PROLOG_INCLUDED === true || die();

use Bitrix\Main\PhoneNumber\Parser;
use Bitrix\Main\PhoneNumber\Format;

class BAPhone extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->arResult["PHONE"] = $this->arParams["PHONE"] ?? "";
		$this->arResult["DISPLAY_PHONE"] = Parser::getInstance()->parse($this->arResult["PHONE"])->format(Format::NATIONAL);;

		$this->includeComponentTemplate();
	}
}
