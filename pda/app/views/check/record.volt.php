<html>
	<?= $this->partial('partials/header') ?>
	<body>
	<?= $this->tag->form(['check', 'method' => 'post']) ?>
	<?= $this->partial('partials/body1') ?>
	<table width=<?= $d_width ?>>
		<tr>
			<td align='center'><input type="button" name="o_btn" value="확인" onclick="selectedMove('/check/record')" /></td>
			<td align='center'>&nbsp;</td>
			<td align='center'><input type="button" name="o_btn" value="취소" onclick="selectedMove('/check/cancel')" /></td>
		</tr>
	</table>
	<table width=<?= $d_width ?>>
		<tr>
			<td colspan = "3"><?= $this->tag->textArea(['comment', 'value' => $c_data, 'cols' => 25, 'rows' => 3, 'readonly' => 'readonly', 'style' => 'width:100%']) ?></td>
		</tr>
		<tr bgcolor="#B0C4DE">
			<td align="center">의뢰코드</td>
			<td align="center">상품명</td>
			<td align="center">개수</td>
		</tr>
		<?php foreach ($data as $dt) { ?>
			<tr>
				<td align="center"><?= $dt['req_code'] ?></td>
				<td align="center"><?= $dt['itm_name'] ?></td>
				<td align="center"><?= $dt['itm_ea'] ?><?= $dt['itm_iunit'] ?></td>
			</tr>
		<?php } ?>
	</table>
	<table width=<?= $d_width ?>>
		<tr>
			<td align='center'><input type="button" name="o_btn" value="확인" onclick="selectedMove('/check/record')" /></td>
			<td align='center'>&nbsp;</td>
			<td align='center'><input type="button" name="o_btn" value="취소" onclick="selectedMove('/check/cancel')" /></td>
		</tr>
	</table>
	<?= $this->tag->hiddenField([$this->security->getTokenKey(), 'value' => $this->security->getToken()]) ?>
	<?= $this->tag->endform() ?>
	</body>
</html>