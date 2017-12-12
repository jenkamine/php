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
	{{ hidden_field(security.getTokenKey(), "value": security.getToken()) }}
	{{ endform() }}
	</body>
</html>