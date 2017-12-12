<html>
	{{ partial("partials/header") }}
	<body>
	{{ form("aging", "method": "post") }}
	{{ partial("partials/body2") }}
	<table width={{d_width}}>
		<tr>
			<td align='center'><input type="button" name="o_btn" value="확인" onclick="selectedMove('/aging')" /></td>
			<td align='center'>&nbsp;</td>
			<td align='center'><input type="button" name="o_btn" value="취소" onclick="selectedMove('/aging/cancel')" /></td>
		</tr>
	</table>
	<table width={{ d_width }}>
		<tr>
			<td colspan = "3">{{ text_area('comment', 'value': c_data, 'cols': 25, 'rows': 3, 'readonly': 'readonly', 'style':'width:100%') }}</td>
		</tr>
		<tr bgcolor="#B0C4DE">
			<td align="center">의뢰코드</td>
			<td align="center">상품명</td>
			<td align="center">개수</td>
		</tr>
		{% for dt in data %}
			<tr>
				<td align="center">{{dt['req_code']}}</td>
				<td align="center">{{dt['itm_name']}}</td>
				<td align="center">{{dt['itm_ea']}}{{dt['his_iunit']}}</td>
			</tr>
		{% endfor %}
	</table>
	<table width={{d_width}}>
		<tr>
			<td align='center'><input type="button" name="o_btn" value="확인" onclick="selectedMove('/aging')" /></td>
			<td align='center'>&nbsp;</td>
			<td align='center'><input type="button" name="o_btn" value="취소" onclick="selectedMove('/aging/cancel')" /></td>
		</tr>
	</table>
	{{ hidden_field(security.getTokenKey(), "value": security.getToken()) }}
	{{ endform() }}
	</body>
</html>