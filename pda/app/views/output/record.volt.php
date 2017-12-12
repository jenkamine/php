<html>
	<?= $this->partial('partials/header') ?>
	<body>
	<?= $this->tag->form(['output', 'method' => 'post']) ?>
	<?= $this->partial('partials/body2') ?>
	<table width=<?= $d_width ?>>
		<tr bgcolor="#B0C4DE">
			<td align="center">의뢰코드</td>
			<td align="center">품명[폭/길이]</td>
			<td align="center">수량</td>
		</tr>
		<?php foreach ($rdata as $rt) { ?>
		<tr>
			<td align='center'><?= $rt['req_code'] ?></td>
			<td align='center'><?= $rt['itm_name'] ?>[<?= $rt['itm_width'] ?>/<?= $rt['itm_length'] ?>]</td>
			<td align='center'><?= $rt['ord_qty'] ?></td>
		</tr>
		<?php } ?>
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
				<td align="center"><?= $dt['itm_ea'] ?><?= $dt['his_iunit'] ?></td>
			</tr>
		<?php } ?>
	</table>
	<table width=<?= $d_width ?>>
		<tr>
			<td align='center'><input type="button" name="o_btn" value="확인" onclick="selectedMove('/output')" /></td>
			<td align='center'>&nbsp;</td>
			<td align='center'><input type="button" name="o_btn" value="취소" onclick="selectedMove('/output/cancel')" /></td>
		</tr>
	</table>
	<?= $this->tag->hiddenField([$this->security->getTokenKey(), 'value' => $this->security->getToken()]) ?>
	<?= $this->tag->endform() ?>
	</body>
</html>