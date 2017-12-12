<html>
	<?= $this->partial('partials/header') ?>
	<body onload="document.getElementById('b_id').focus();">
	<?= $this->tag->form(['output/list', 'method' => 'post']) ?>
	<?= $this->partial('partials/body1') ?>
	<table width=<?= $d_width ?> bgcolor="#B0C4DE">
		<tr>
			<td><?= $this->tag->checkField(['chk_all', 'value' => 0]) ?></td>
			<td align="center">상품명</td>
			<td align="center">폭/길이/수량/단위</td>
		</tr>
	</table>
	<?= $this->tag->hiddenField([$this->security->getTokenKey(), 'value' => $this->security->getToken()]) ?>
	<?= $this->tag->endform() ?>
	</body>
</html>