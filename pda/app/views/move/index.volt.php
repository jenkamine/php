<html>
	<?= $this->partial('partials/header') ?>
	<body onload="document.getElementById('b_id').focus();">
	<?= $this->tag->form(['move/list', 'method' => 'post']) ?>
	<?= $this->partial('partials/body1') ?>
	<table width=<?= $d_width ?> bgcolor="#B0C4DE">
		<tr bgcolor="#B0C4DE">
			<td align="center">상품명</td>
			<td align="center">폭/길이/수량</td>
			<td align="center">취소</td>
		</tr>
	</table>
	<?= $this->tag->hiddenField([$this->security->getTokenKey(), 'value' => $this->security->getToken()]) ?>
	<?= $this->tag->endform() ?>
	</body>
</html>