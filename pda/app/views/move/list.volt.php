<html>
	<?= $this->partial('partials/header') ?>
	<body>
	<?= $this->tag->form(['move/list', 'method' => 'post']) ?>
	<?= $this->partial('partials/body1') ?>
	<table width=<?= $d_width ?>>
		<tr>
			<td align='center'>
				<select name="fac">
				<?php foreach ($fdata as $fc) { ?>
					<option value="<?= $fc['key'] ?>" <?= $fc['chk'] ?>><?= $fc['val'] ?></option>
				<?php } ?>
				</select>
			</td>
			<?php if ($udata == 0) { ?>
				<td align='center'><input type="button" name="o_btn" value="반출" onclick="selectedMove('/move/recordout')" /></td>
			<?php } else { ?>
				<td align='center'><input type="button" name="o_btn" value="반입" onclick="selectedMove('/move/recordin')" /></td>
			<?php } ?>
			<td align='center'><input type="button" name="o_btn" value="취소" onclick="selectedMove('/move')" /></td>
		</tr>
	</table>
	<table width=<?= $d_width ?>>
	<?php if ($err == true) { ?>
		<tr>
			<td><?= $this->tag->textArea(['comment', 'value' => $data, 'cols' => 25, 'rows' => 6, 'readonly' => 'readonly', 'style' => 'width:100%']) ?></td>
		</tr>
	<?php } else { ?>
		<tr bgcolor="#B0C4DE">
			<td align="center">상품명</td>
			<td align="center">폭/길이/수량</td>
			<td align="center">취소</td>
		</tr>
		<?php foreach ($data as $dt) { ?>
			<tr>
				<td align="center"><?= $dt['itm_name'] ?></td>
				<td align="center"><?= $dt['itm_width'] ?>/<?= $dt['itm_length'] ?>/<?= $dt['itm_ea'] ?><?= $dt['his_iunit'] ?></td>
				<td align="center"><input type="button" name="del" value='Del' onclick="<?= $dt['post'] ?>" /></td>
			</tr>
		<?php } ?>
	</table>
	<table width=<?= $d_width ?>>
		<tr>
			<td align='center'>
				<select name="fac">
				<?php foreach ($fdata as $fc) { ?>
					<option value="<?= $fc['key'] ?>" <?= $fc['chk'] ?>><?= $fc['val'] ?></option>
				<?php } ?>
				</select>
			</td>
			<?php if ($udata == 0) { ?>
				<td align='center'><input type="button" name="o_btn" value="반출" onclick="selectedMove('/move/recordout')" /></td>
			<?php } else { ?>
				<td align='center'><input type="button" name="o_btn" value="반입" onclick="selectedMove('/move/recordin')" /></td>
			<?php } ?>
			<td align='center'><input type="button" name="o_btn" value="취소" onclick="selectedMove('/move')" /></td>
		</tr>
	</table>
	<?php } ?>
	<?= $this->tag->hiddenField([$this->security->getTokenKey(), 'value' => $this->security->getToken()]) ?>
	<?= $this->tag->endform() ?>
	</body>
</html>
