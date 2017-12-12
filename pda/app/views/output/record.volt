<html>
	{{ partial("partials/header") }}
	<body>
	{{ form("output", "method": "post") }}
	{{ partial("partials/body2") }}
	<table width={{d_width}}>
		<tr bgcolor="#B0C4DE">
			<td align="center">의뢰코드</td>
			<td align="center">품명[폭/길이]</td>
			<td align="center">수량</td>
		</tr>
    {% if !(rdata is empty) %}
		{% for rt in rdata %}
		<tr>
			<td align='center'>{{rt['req_code']}}</td>
			<td align='center'>{{rt['itm_name']}}[{{rt['itm_width']}}/{{rt['itm_length']}}]</td>
			<td align='center'>{{rt['ord_qty']}}</td>
		</tr>
		{% endfor %}
    {% endif %}
	</table>
	<table width={{ d_width }}>
		<tr>
			<td colspan = "3">{{ text_area('comment', 'value': c_data, 'cols': 25, 'rows': 3, 'readonly': 'readonly', 'style':'width:100%') }}</td>
		</tr>
		<tr bgcolor="#B0C4DE">
			<td align="center">상품명</td>
			<td align="center">폭/길이/수량</td>
			<td align="center">취소</td>
		</tr>	
    {% if !(data is empty) %}
		{% for dt in data %}
			<tr>
				<td align="center">{{dt['itm_name']}}</td>
				<td align="center">{{dt['itm_width']}}/{{dt['itm_length']}}/{{dt['itm_ea']}}{{dt['his_iunit']}}</td>
				<td align="center"></td>
			</tr>
		{% endfor %}
    {% endif %}
	</table>
	<table width={{d_width}}>
		<tr>
			<td align='center'><input type="button" name="o_btn" value="확인" onclick="selectedMove('/output')" /></td>
			<td align='center'>&nbsp;</td>
			<td align='center'><input type="button" name="o_btn" value="취소" onclick="selectedMove('/output/cancel')" /></td>
		</tr>
	</table>
	{{ hidden_field(security.getTokenKey(), "value": security.getToken()) }}
	{{ endform() }}
	</body>
</html>