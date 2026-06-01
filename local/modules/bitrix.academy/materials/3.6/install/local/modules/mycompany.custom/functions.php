<?php
function LogAgent($agent, $operation, $result = false, $return = false)
{
	static $log = [];

	$time = date('Y-m-d-H:i:s');

	if ($operation == 'start') {
		$log[$agent['ID']] = microtime(true);
		\Bitrix\Main\Diag\Debug::writeToFile($_SERVER["REQUEST_TIME_FLOAT"] . '-' . $time . '-' . $agent['ID'] . '-start: ' . $agent['NAME'] .
			' [' . $agent['MODULE_ID'] . '], ' . $agent['AGENT_INTERVAL'], "", "academy.log");
	}
	elseif ($operation == 'finish') {
		\Bitrix\Main\Diag\Debug::writeToFile($_SERVER["REQUEST_TIME_FLOAT"] . '-' . $time . '-' . $agent['ID'] . '-finish (' .
			number_format(microtime(true) - $log[$agent['ID']], 4, '.', ' ') .
			's): ' . $agent['NAME'] . ' [' . $agent['MODULE_ID'] . '], ' . $agent['AGENT_INTERVAL'], "", "academy.log");
	}
}
