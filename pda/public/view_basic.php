<?php
//페이지는 UTF-8(BOM없음)이 아니면 페이지 한줄이 항상 비게 됨
$this->assets->addJs('js/output.js?'.time());
$this->assets->addJs('js/menu.js?'.time());
$this->assets->addCss('css/style.css?'.time());
for($i = 1; $i <= 5; $i++){
	if($i == self::$chk_id) $this->view->setVar('w_chk'.(string)$i,'checked');
	else $this->view->setVar('w_chk'.(string)$i,'');
}
$this->view->setVar('title',self::$chk_arr[self::$chk_id]);
?>