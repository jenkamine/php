<html>
	<?= $this->partial('partials/header') ?>
	<body>
		<table width=<?= $d_width ?> bgcolor="gray">
			<tr>
				<td align="center"><h2><?= $title ?></h2></td>
			</tr>
		</table>

		<?= $this->tag->form(['sign/in', 'method' => 'post']) ?>
		<table width=<?= $d_width ?>>
			<tr>
				<td width="70"><label for="userid">아이디</label></td>
				<td><?= $this->tag->textField(['userid', 'size' => 17]) ?></td>
			</tr>
			<tr>
				<td width="70"><label for="dst_ps">암호</label></td>
				<td><?= $this->tag->passwordField(['dst_ps', 'size' => 17]) ?></td>
			</tr>
			<tr>
				<td width="70"><label for="place">사용처</label></td>
				<td><?= $this->tag->selectStatic(['place', ['001' => '1공장', '002' => '2공장', '003' => '3공장', '004' => '4공장', '005' => '5공장']]) ?></td>
			</tr>
			<tr>
				<td height="20" colspan="2" align="center"><?= $this->tag->submitButton(['로그인']) ?></td>
			</tr>
		</table>
		<?= $this->tag->hiddenField([$this->security->getTokenKey(), 'value' => $this->security->getToken()]) ?>
		<?= $this->tag->endform() ?>
	</body>
</html>