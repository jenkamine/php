<html>
	<?= $this->partial('partials/header') ?>
	<body>
		<table width=<?= $d_width ?> bgcolor="gray">
			<tr>
				<td align="center"><h2><?= $title ?></h2></td>
			</tr>
		</table>
		<table width=<?= $d_width ?> cellpadding="20">
			<tr height = "70">
				<td><button class="rep1" onclick="redirectUser(1)">제품출고</button></td>
				<td><button class="rep2" onclick="redirectUser(2)">숙&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;성</button></td>
				<td><button class="rep3" onclick="redirectUser(3))">창고이동</button></td>
			</tr>
			<tr height = "70">
				<td><button class="rep4" onclick="redirectUser(4)">재고실사</button></td>
				<td><button class="rep5" onclick="redirectUser(5)">패킹관리</button></td>
				<td><button class="rep6">미&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;정</button></td>
			</tr>
			<tr height = "70">
				<td><button class="rep7" onclick="redirectUser(7)">바코드<br>확인</button></td>
				<td><button class="rep8">미&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;정</button></td>
				<td><button class="rep9" onclick="redirectUser(0)">로그아웃</button></td>
			</tr>
		</table>
	</body>
</html>