<html>
	<?= $this->partial('partials/header') ?>
	<body>
	<script>
	document.body.ontouchend = function() { document.querySelector('[name="b_id"]').focus(); };
	</script>
	<?= $this->tag->form(['pack/setting', 'method' => 'post']) ?>
	<?= $this->partial('partials/body1') ?>
	<table width=<?= $d_width ?>>
		<tr height="20" bgcolor = "#30508C" style="color:white;">
			<td align='center' valign='bottom'>가로</td>
			<td align='center' valign='bottom'>세로</td>
			<td align='center' valign='bottom'>단수</td>
			<td align='center' valign='bottom'>&nbsp;</td>
		</tr>
		<tr bgcolor = "#FFFFFF">
			<td align='center'>
				<select name="horizontal">
				<?php foreach ($hordata as $hor) { ?>
					<option value="<?= $hor['key'] ?>" <?= $hor['chk'] ?>><?= $hor['val'] ?></option>
				<?php } ?>
				</select>
			</td>
			<td align='center'>
				<select name="vertical">
				<?php foreach ($verdata as $ver) { ?>
					<option value="<?= $ver['key'] ?>" <?= $ver['chk'] ?>><?= $ver['val'] ?></option>
				<?php } ?>
				</select>
			</td>
			<td align='center'>
				<select name="depth">
				<?php foreach ($depdata as $dep) { ?>
					<option value="<?= $dep['key'] ?>" <?= $dep['chk'] ?>><?= $dep['val'] ?></option>
				<?php } ?>
				</select>
			</td>
			<td align='center'>
				<input type="submit" name="setting" value="적용" />
			</td>
		</tr>
	</table>
	<table width=<?= $d_width ?> bgcolor = "#30508C" style="color:white;">
		<tr>
			<td align='center'>
				<input type="submit" name="prev" value="◁◀이전" onclick="selectedMove('/pack/prev')" />
			</td>
			<td align='center'>패킹리스트 작성</td>
			<td align='center'>
				<input type="submit" name="next" value="다음▶▷" onclick="selectedMove('/pack/next')" />
			</td>
		</tr>
	</table>
	<table width=<?= $d_width ?>>
	<?php if ($err == true) { ?>
		<tr>
			<td><?= $this->tag->textArea(['comment', 'value' => $data, 'cols' => 25, 'rows' => 6, 'readonly' => 'readonly', 'style' => 'width:100%']) ?></td>
		</tr>
	<?php } else { ?>
		<?php foreach ($verdata as $ver) { ?>
			<tr>
				<?php foreach ($verdata as $hor) { ?>
				<td align="center">[<?= $num ?>]</td>
				<?php } ?>
			</tr>
		<?php } ?>
	</table>
	<table width=<?= $d_width ?> bgcolor = "#30508C" style="color:white;">
		<tr>
			<td align='center'>
				<input type="submit" name="prev" value="◁◀이전" onclick="selectedMove('/pack/prev')" />
			</td>
			<td align='center'>패킹리스트 작성</td>
			<td align='center'>
				<input type="submit" name="next" value="다음▶▷" onclick="selectedMove('/pack/next')" />
			</td>
		</tr>
	</table>
	<?php } ?>
	<?= $this->tag->hiddenField([$this->security->getTokenKey(), 'value' => $this->security->getToken()]) ?>
	<?= $this->tag->endform() ?>
	</body>
</html>
