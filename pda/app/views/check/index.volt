<html>
	{{ partial("partials/header") }}
	<body onload="document.getElementById('b_id').focus();">
	{{ form("check/list", "method": "post") }}
	{{ partial("partials/body1") }}
	<table width={{ d_width }} bgcolor="#B0C4DE">
		<tr bgcolor="#B0C4DE">
			<td align="center">상품명</td>
			<td align="center">폭/길이/수량</td>
			<td align="center">취소</td>
		</tr>
	</table>
	{{ hidden_field(security.getTokenKey(), "value": security.getToken()) }}
	{{ endform() }}
	</body>
</html>