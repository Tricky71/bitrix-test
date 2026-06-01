<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?



?>


 <!-- FORGOTPASSWD FORM -->
<div class="row justify-content-center">
	<div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
		<div class="card mb-3">
			<div class="card-body">

				<!--IF AUTH_RESULT-->
			<?if (!empty($arParams["~AUTH_RESULT"])):?>
			  <div class="pt-4 pb-2">
					<p class="small"><?ShowMessage($arParams["~AUTH_RESULT"]);?></p>
				</div>
			<?endif?>		
				
			  <form name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>" class="row g-3" novalidate>

					<div class="pt-4 pb-2">
						<p class="small"><?=GetMessage('AUTH_TEXT')?><br /><?=GetMessage('sys_forgot_pass_note_email')?></p>
					</div>

					<input type="hidden" name="AUTH_FORM" value="Y">
					<input type="hidden" name="TYPE" value="SEND_PWD">
					<?= bitrix_sessid_post(); ?>

					<div class="col-12">
						<label for="yourUsername" class="form-label"><?=GetMessage('sys_forgot_pass_login1')?></label>
						<input id="yourUsername" class="form-control" type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["USER_LOGIN"]?>" />
					</div>

					<div class="col-12">
						<label for="yourEmail" class="form-label"><?=GetMessage('sys_forgot_pass_email')?></label>
						<input id="yourEmail" class="form-control" type="text" name="USER_EMAIL" maxlength="255" value="<?=$arResult["USER_EMAIL"]?>" />
					</div>

				<?if($arResult["USE_CAPTCHA"]):?>	
					
					<div class="col-12">
						<label class="form-label"><?=GetMessage("system_auth_captcha")?></label>
						<div class="input-group has-validation">
							<input required class="form-control" type="text" name="captcha_word" maxlength="50"  />
							<div class="invalid-feedback"><?=GetMessage("sys_forgot_pass_invalid")?></div>
						</div>
					</div>
					<div class="col-12">
						<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" /> <!-- CAPTCHA_CODE -->
						<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
					</div>
					<!-- END CAPTCHA -->
        <?endif?>

					<div class="col-12">
						<button class="btn btn-primary w-100" type="submit" name="send_account_info">
							<?=GetMessage("AUTH_SEND")?>
						</button>
					</div>

					<div class="col-12">
						<p class="small mb-0">
							<b><a href="<?=$arResult["BACKURL"]?>"><?=GetMessage("sys_forgot_pass_return")?></a></b>
						</p>
					</div>

				</form>


			</div>
		</div>
		
	</div>
</div>
      <!-- END FORGOTPASSWD FORM -->

<script type="text/javascript">
	document.bform.USER_LOGIN.focus();
</script>





