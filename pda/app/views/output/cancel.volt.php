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
	<table width=<?= $d_width ?>>
		<tr>
			<td align="left"><b>1.바코드가 없는 박스:</b><br>출고할 각 의뢰코드를 차례로 입력⇒수량확인⇒출고<br><br><b>2.바코드가 있는 박스:</b><br>출고할 각 의뢰코드를 차례로 입력⇒박스 바코드를 읽어 의뢰내용과 일치하는지 확인⇒수량확인⇒출고</td>
		</tr>
	</table>
	<?= $this->tag->hiddenField([$this->security->getTokenKey(), 'value' => $this->security->getToken()]) ?>
	<?= $this->tag->endform() ?>
	</body>
</html>