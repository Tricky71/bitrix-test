<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?debug($arResult);?>
<ul class="sidebar-nav" id="sidebar-nav">

<?php if (!empty($arResult)):?>
    
    <?foreach($arResult as $arItem):?>
		  <li class="nav-item">

			
       <?//debug($arItem['PARAMS']);?>
		    <a class="nav-link <?=!$arItem['SELECTED'] ? 'collapsed' : ''?>" href="<?=$arItem['LINK']?>">

				<?php
				if ($arItem['PARAMS']['menu_ico']) {
				?>
					<i class="<?=$arItem['PARAMS']['menu_ico'];?>"></i>
				<?
				} else {
				?>
					<i class="bi bi-circle"></i>	
        <?
				}
				?>
				  <span><?=$arItem['TEXT']?></span>
				</a>
		  </li>  
		<?endforeach?>
<?endif?>

</ul>
  <!-- <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link" href="dashboard.html">
          <i class="bi bi-grid"></i>
          <span>Дашборд</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#main-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Основные</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="main-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Отчеты</span>
            </a>
          </li>
          <li>
            <a href="tables.html">
              <i class="bi bi-circle"></i><span>Данные</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#add-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-files"></i><span>Дополнительные</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="add-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Базы</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Информация</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#sample-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Пример раздела</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="sample-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Пример пункта</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Пример пункта</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Пример пункта</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Пример пункта</span>
            </a>
          </li>
        </ul>        
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="profile.html">
          <i class="bi bi-person"></i>
          <span>Профиль</span>
        </a>
      </li>
    
      <li class="nav-item">
        <a class="nav-link collapsed" href="blank.html">
          <i class="bi bi-file-earmark"></i>
          <span>Пустая страница</span>
        </a>
      </li>

    </ul> -->

