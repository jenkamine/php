<html>
	<?= $this->partial('partials/header') ?>
	<body>
	<script>
	document.body.ontouchend = function() { document.querySelector('[name="b_id"]').focus(); };
	</script>
	<?= $this->tag->form(['pack/list', 'method' => 'post']) ?>
	<?= $this->partial('partials/body1') ?>
	<table width=<?= $d_width ?>>
		<tr>
			<td align='center'><input type="button" name="o_btn" value="신규" onclick="selectedMove('/pack/pack')" /></td>
			<td align='center'><input type="button" name="o_btn" value="추가" onclick="selectedMove('/pack/packlist')" /></td>
			<td align='center'><input type="button" name="o_btn" value="해제" onclick="selectedMove('/pack/unpack')" /></td>
			<td align='center'><input type="button" name="o_btn" value="취소" onclick="selectedMove('/pack')" /></td>
		</tr>
	</table>
	<table width=<?= $d_width ?>>
	<?php if ($err == true) { ?>
		<tr>
			<td><?= $this->tag->textArea(['comment', 'value' => $data, 'cols' => 25, 'rows' => 6, 'readonly' => 'readonly', 'style' => 'width:100%']) ?></td>
		</tr>
	<?php } else { ?>
		<tr bgcolor="#B0C4DE">
			<td align="center"><input type="checkbox" name="chk_all" value="1" checked onchange="checkAll()" /></td>
			<td align="center">상품명</td>
			<td align="center">폭/길이/수량</td>
		</tr>
		<?php foreach ($data as $dt) { ?>
			<tr>
				<td align="center"><input type="checkbox" name="chk" value='1' checked /></td>
				<td align="center"><?= $dt['itm_name'] ?></td>
				<td align="center"><?= $dt['itm_width'] ?>/<?= $dt['itm_length'] ?>/<?= $dt['itm_ea'] ?><?= $dt['his_iunit'] ?></td>
			</tr>
		<?php } ?>
	</table>
	<table width=<?= $d_width ?>>
		<tr>
			<td align='center'><input type="button" name="o_btn" value="신규" onclick="selectedMove('/pack/pack')" /></td>
			<td align='center'><input type="button" name="o_btn" value="추가" onclick="selectedMove('/pack/packlist')" /></td>
			<td align='center'><input type="button" name="o_btn" value="해제" onclick="selectedMove('/pack/unpack')" /></td>
			<td align='center'><input type="button" name="o_btn" value="취소" onclick="selectedMove('/pack')" /></td>
		</tr>
	</table>
	<?php } ?>
	<?= $this->tag->hiddenField([$this->security->getTokenKey(), 'value' => $this->security->getToken()]) ?>
	<?= $this->tag->endform() ?>
	</body>
</html>
