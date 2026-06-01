<?php B_PROLOG_INCLUDED === true || die(); ?>
                </div>
            </div>
        </div>
    </div>
</main>
<footer class="footer">
	<div class="copyright">
		<div class="container-lg">
			<div class="copyright__list">
				<div class="copyright__li">
					<?=GetMessage('ACADEMY_PERSONAL_COPYRIGHT', ["#CURRENT_YEAR#" => date("Y")])?>
				</div>
				<div class="copyright__li d-flex align-items-center gap-1">
					<a class="a" href="javascript:void(0)"><?=GetMessage('ACADEMY_PERSONAL_SITE_DEVELOPMENT')?></a> —
					<img class="img img_lazy lazyload" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" alt="image" data-src="<?=DEFAULT_TEMPLATE_PATH?>/images/developer.svg">
				</div>
			</div>
		</div>
	</div>
</footer>
<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/local/templates/.default/include/footer.php";