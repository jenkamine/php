<html>
	<?= $this->partial('partials/header') ?>
	<body>
	<script>
		document.body.ontouchend = function() { document.querySelector('[name="b_id"]').focus(); };
		function onlyNumber(event){
			event = event || window.event;
			var keyID = (event.which) ? event.which : event.keyCode;
			if ( (keyID >= 48 && keyID <= 57) || (keyID >= 96 && keyID <= 105) || keyID == 8 || keyID == 46 || keyID == 37 || keyID == 39 ) 
				return;
			else
				return false;
		}
		function removeChar(event) {
			event = event || window.event;
			var keyID = (event.which) ? event.which : event.keyCode;
			if ( keyID == 8 || keyID == 46 || keyID == 37 || keyID == 39 ) 
				return;
			else
				event.target.value = event.target.value.replace(/[^0-9]/g, "");
		}
	</script>
	</script>
	<?= $this->tag->form(['output/list', 'method' => 'post']) ?>
	<?= $this->partial('partials/body1') ?>
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
			<td align='center'><input type='text' id='<?= $rt['req_code'] ?>' name='o_qty' value='<?= $rt['ord_qty'] ?>' size='5' onkeydown='return onlyNumber(event)' onkeyup='removeChar(event)' style='ime-mode:disabled;' /></td>
		</tr>
		<?php } ?>
		<input type="submit" style="position: absolute; left: -9999px; width: 1px; height: 1px;"/>
	</table>
	<?php if ($err == true) { ?>
	<table width=<?= $d_width ?>>
		<tr>
			<td colspan="3"><?= $this->tag->textArea(['comment', 'value' => $err_msg, 'cols' => 25, 'rows' => 6, 'readonly' => 'readonly', 'style' => 'width:100%']) ?></td>
		</tr>
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
	<?php } else { ?>
	<table width=<?= $d_width ?>>
		<tr>
			<td align='center'><input type="button" name="o_btn" value="출고" onclick="arrPost('/output/record','o_qty')" /></td>
			<td align='center'><input type="button" name="o_btn" value="샘플출고" onclick="arrPost('/output/srecord','o_qty')" /></td>
			<td align='center'><input type="button" name="o_btn" value="취소" onclick="post('/output')" /></td>
		</tr>
	</table>
	<table width=<?= $d_width ?>>
		<tr bgcolor="#B0C4DE">
			<td align="center">상품명</td>
			<td align="center">폭/길이/수량</td>
			<td align="center">취소</td>
		</tr>
		<?php if ($d_cnt > 0) { ?>
			<?php foreach ($data as $dt) { ?>
				<tr>
					<td align="center"><?= $dt['itm_name'] ?></td>
					<td align="center"><?= $dt['itm_width'] ?>/<?= $dt['itm_length'] ?>/<?= $dt['itm_ea'] ?><?= $dt['his_iunit'] ?></td>
					<td align="center"><input type="button" name="del" value='Del' onclick="<?= $dt['post'] ?>" /></td>
				</tr>
			<?php } ?>
		<?php } else { ?>
				<tr>
					<td align="center" colspan = "3">박스라벨의 바코드를 읽지 않고 출고하면 의뢰코드의 상품이 출고된 것으로 처리됩니다.</td>
				</tr>
		<?php } ?>
	</table>
	<table width=<?= $d_width ?>>
		<tr>
			<td align='center'><input type="button" name="o_btn" value="출고" onclick="arrPost('/output/record','o_qty')" /></td>
			<td align='center'><input type="button" name="o_btn" value="샘플출고" onclick="arrPost('/output/srecord','o_qty')" /></td>
			<td align='center'><input type="button" name="o_btn" value="취소" onclick="post('/output')" /></td>
		</tr>
	</table>
	<?php } ?>
	<?= $this->tag->hiddenField([$this->security->getTokenKey(), 'value' => $this->security->getToken()]) ?>
	<?= $this->tag->endform() ?>
	</body>
</html>
