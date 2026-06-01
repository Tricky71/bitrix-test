<?php 
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

require_once $_SERVER["DOCUMENT_ROOT"] . "/local/templates/.default/include/boot.php";
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);     
?> 
			
			</div>
    </div>
  </section>
</main>
<footer id="footer" class="footer dark-background">

		<div class="footer-search">
			<div class="container">
				<div class="row justify-content-center text-center">
					<div class="col-lg-6">
						<h4>Поиск</h4>
						<form action="#" method="post">
							<div class="search-form">
								<input class="input-seach" type="text" name="q">
								<input class="button-seach" name="s" type="submit" value="Найти">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>



		<div class="container footer-top">
			<div class="row gy-4">
				<div class="col-lg-4 col-md-6 footer-about">
					<a href="index.html" class="d-flex align-items-center">
						<span class="sitename"><?=GetMessage('MAIN_LOGO')?></span>
					</a>
					<div class="footer-contact pt-3">
						<p>111111 Москва</p>
						<p>Улица, номер, офис</p>
						<p class="mt-3"><strong>Телефон:</strong> <span>+7 000 000 00 00</span></p>
						<p><strong>Email:</strong> <span>contact@company.ru</span></p>
					</div>
				</div>

				<div class="col-lg-2 col-md-3 footer-links">
					<h4>Полезные ссылки</h4>
					<ul>
						<li><i class="bi bi-chevron-right"></i> <a href="#">Главная</a></li>
						<li><i class="bi bi-chevron-right"></i> <a href="#">О Комапнии</a></li>
						<li><i class="bi bi-chevron-right"></i> <a href="#">Услуги</a></li>
						<li><i class="bi bi-chevron-right"></i> <a href="#">Портфолио</a></li>
					</ul>
				</div>

				<div class="col-lg-2 col-md-3 footer-links">
					<h4>Наши услуги</h4>
					<ul>
						<li><i class="bi bi-chevron-right"></i> <a href="#">Проектирование</a></li>
						<li><i class="bi bi-chevron-right"></i> <a href="#">Продажи</a></li>
						<li><i class="bi bi-chevron-right"></i> <a href="#">Установка</a></li>
						<li><i class="bi bi-chevron-right"></i> <a href="#">Консультации</a></li>
					</ul>
				</div>

				<div class="col-lg-4 col-md-12">
					<h4>Оставайтесь на связи</h4>
					<p>Мы рады видеть вас в наших соцсетях</p>
					<div class="social-links d-flex">
						<a class="forimg" href="#"><img src="assets/img/ico/vk_w.svg"></a>
					</div>
				</div>

			</div>
		</div>

		<div class="container copyright text-center mt-4">
			<div class="credits">
				<!-- All the links in the footer should remain intact. -->
				<!-- You can delete the links only if you've purchased the pro version. -->
				<!-- Licensing information: https://bootstrapmade.com/license/ -->
				<!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
				Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
			</div>
		</div>

	</footer>

	<!-- Scroll Top -->
	<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
			class="bi bi-arrow-up-short"></i></a>

	<!-- Preloader -->
	<!-- <div id="preloader"></div> -->

	<!-- Vendor JS Files -->
	<!-- <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="assets/vendor/aos/aos.js"></script> -->

	<!-- Main JS File -->
	<!-- <script src="assets/js/main.js"></script> -->

</body>

</html>

