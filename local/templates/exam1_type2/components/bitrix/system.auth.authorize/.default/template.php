<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?
if (!empty($arParams["~AUTH_RESULT"]))
{
	ShowMessage($arParams["~AUTH_RESULT"]);
}

if (!empty($arResult['ERROR_MESSAGE']))
{
	ShowMessage($arResult['ERROR_MESSAGE']);
}
?>
<?//php debug($_REQUEST);?>
<div class="row justify-content-center">
	<div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
		<div class="card mb-3">
			<div class="card-body">

				<div class="pt-4 pb-2">
					<p class="text-center small"><?=GetMessage("AUTH_PLEASE_AUTH")?></p>
				</div>

				<form 
					class="row g-3 needs-validation" novalidate
					name="form_auth" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>"
				>
				

				<input type="hidden" name="AUTH_FORM" value="Y" />
				<input type="hidden" name="TYPE" value="AUTH" />
				<?= bitrix_sessid_post(); ?>
				<?if ($arResult["BACKURL"] <> ''):?>
				  <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
				<?endif?>
				<?foreach ($arResult["POST"] as $key => $value):?>
				  <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
				<?endforeach?>

				
        <div class="col-12">
				<label for="yourUsername" class="form-label"><?=GetMessage("AUTH_LOGIN")?></label>
					<div class="input-group has-validation">
						<input
							type="text" class="form-control" id="yourUsername" required
							name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>"
						>
						<!-- <div class="invalid-feedback">Укажите логин!</div> -->
					</div>
				</div>

				<div class="col-12">
					<label for="yourPassword" class="form-label"><?=GetMessage("AUTH_PASSWORD")?></label>
					<input 
						class="form-control" id="yourPassword" required
						type="password" name="USER_PASSWORD" maxlength="255" autocomplete="off" 
					>
					<!-- <div class="invalid-feedback">Укажите пароль!</div> -->
				</div>

				<div class="col-12">
					<div class="form-check">
						<input 
							class="form-check-input"
							type="checkbox" id="USER_REMEMBER" name="USER_REMEMBER" value="Y"
						>
						<label class="form-check-label" for="USER_REMEMBER"><?=GetMessage('AUTH_REMEMBER_ME')?></label>
					</div>
				</div>

      <?if($arResult["CAPTCHA_CODE"]):?>
				<!-- IF USED CAPTCHA -->
				<div class="col-12">
					<label class="form-label"><?=GetMessage('AUTH_CAPTCHA')?></label>
					<div class="input-group has-validation">
						<input required class="form-control" type="text" name="captcha_word" maxlength="50"  />
						<div class="invalid-feedback"><?=GetMessage('AUTH_CAPTCHA_PROMT')?></div>
					</div>
				</div>
				<div class="col-12">
					<input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
					<img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
				</div>
				<!-- END CAPTCHA -->
      <?endif?>

				<div class="col-12">
					<button 
						class="btn btn-primary w-100" type="submit" name="Login"><?=GetMessage("AUTH_AUTHORIZE")?>
					</button>
					
				</div>

				</noindex>
				<div class="col-12">
					<p class="small mb-0"><?=GetMessage("AUTH_FIRST_ONE")?>
						<a href="<?=$arResult["AUTH_REGISTER_URL"]?>" rel="nofollow">
							<?=GetMessage("AUTH_REGISTER")?>
						</a>
					</p>
				</div>
				</noindex>
			
				<noindex>
				<div class="col-12">
					<p class="small mb-0">
						<?=GetMessage('AUTH_FORGOT_PASSWORD_2')?>
						<a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" rel="nofollow">
							<?=GetMessage('AUTH_RESTORE')?>
						</a>
					</p>
				</div>
				</noindex>
			
				</form>

			</div>
		</div>


	</div>
</div>



