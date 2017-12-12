<html>
	{{ partial("partials/header") }}
	<body>
	{{ form("check/list", "method": "post") }}
	{{ partial("partials/body2") }}
	<table width={{d_width}}>
		<tr>
			<td align='center'>
				<select name="fac">
				{% for fc in fdata%}
					<option value="{{fc['key']}}" {{fc['chk']}}>{{fc['val']}}</option>
				{% endfor%}
				</select>
			</td>
				<td align='center'><input type="button" name="o_btn" value="실사" onclick="selectedMove('/check/record')" /></td>
			<td align='center'><input type="button" name="o_btn" value="취소" onclick="selectedMove('/check')" /></td>
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
				<td align="center">{{dt['itm_width']}}/{{dt['itm_length']}}/{{ text_field("test", "size": 4, "value":dt['itm_ea']) }}{{dt['itm_iunit']}}</td>
			</tr>
		{% endfor %}
	</table>
	<table width={{d_width}}>
		<tr>
			<td align='center'>
				<select name="fac">
				{% for fc in fdata%}
					<option value="{{fc['key']}}" {{fc['chk']}}>{{fc['val']}}</option>
				{% endfor%}
				</select>
			</td>
				<td align='center'><input type="button" name="o_btn" value="실사" onclick="selectedMove('/check/record')" /></td>
			<td align='center'><input type="button" name="o_btn" value="취소" onclick="selectedMove('/check')" /></td>
		</tr>
	</table>
	{% endif %}
	{{ hidden_field(security.getTokenKey(), "value": security.getToken()) }}
	{{ endform() }}
	</body>
</html>
