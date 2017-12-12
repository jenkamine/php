<html>
	{{ partial("partials/header") }}
	<body>
	{{ form("aging/list", "method": "post") }}
	{{ partial("partials/body2") }}
	<table width={{d_width}}>
		<tr>
		{% if process == 'A'%}
			<td align='center'><input type="button" name="o_btn" value="반입" onclick="selectedMove('/aging/recordin')" /></td>
		{% else %}
			<td align='center'><input type="button" name="o_btn" value="반출" onclick="selectedMove('/aging/recordout')" /></td>
		{% endif %}
			<td align='center'>&nbsp;</td>
			<td align='center'><input type="button" name="o_btn" value="취소" onclick="selectedMove('/aging')" /></td>
		</tr>
	</table>
	<table width={{ d_width }}>
	{% if err == true%}
		<tr>
			<td>{{ text_area('comment', 'value': data, 'cols': 25, 'rows': 6, 'readonly': 'readonly', 'style':'width:100%') }}</td>
		</tr>
	{% else %}
		<tr bgcolor="#B0C4DE">
			<td align="center"><input type="checkbox" name="chk_all" value="1" checked onchange="checkAll()" /></td>
			<td align="center">상품명</td>
			<td align="center">폭/길이/수량</td>
		</tr>
		{% for dt in data %}
			<tr>
				<td align="center"><input type="checkbox" name="chk" value='1' checked /></td>
				<td align="center">{{dt['itm_name']}}</td>
				<td align="center">{{dt['itm_width']}}/{{dt['itm_length']}}/{{dt['itm_ea']}}{{dt['his_iunit']}}</td>
			</tr>
		{% endfor %}
	</table>
	<table width={{d_width}}>
		<tr>
		{% if process == 'A'%}
			<td align='center'><input type="button" name="o_btn" value="반입" onclick="selectedMove('/aging/recordin')" /></td>
		{% else %}
			<td align='center'><input type="button" name="o_btn" value="반출" onclick="selectedMove('/aging/recordout')" /></td>
		{% endif %}
			<td align='center'>&nbsp;</td>
			<td align='center'><input type="button" name="o_btn" value="취소" onclick="selectedMove('/aging')" /></td>
		</tr>
	</table>
	{% endif %}
	{{ hidden_field(security.getTokenKey(), "value": security.getToken()) }}
	{{ endform() }}
	</body>
</html>
