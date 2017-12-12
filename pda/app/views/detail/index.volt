<html>
	{{ partial("partials/header") }}
	<body onload="document.getElementById('b_id').focus();">
	{{ form("output/list", "method": "post") }}
	{{ partial("partials/body1") }}
	<table width={{ d_width }} bgcolor="#B0C4DE">
		<tr>
			<td>{{ check_field('chk_all','value':0) }}</td>
			<td align="center">상품명</td>
			<td align="center">폭/길이/수량/단위</td>
		</tr>
	</table>
	<table width={{ d_width }}>
		<tr>
			<td align="left"><b>1.바코드가 없는 박스:</b><br>출고할 각 의뢰코드를 차례로 입력⇒수량확인⇒출고<br><br><b>2.바코드가 있는 박스:</b><br>출고할 각 의뢰코드를 차례로 입력⇒박스 바코드를 읽어 의뢰내용과 일치하는지 확인⇒수량확인⇒출고</td>
		</tr>
	</table>
	{{ hidden_field(security.getTokenKey(), "value": security.getToken()) }}
	{{ endform() }}
	</body>
</html>