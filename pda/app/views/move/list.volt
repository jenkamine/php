<html>
	{{ partial("partials/header") }}
	<body>
	{{ form("move/list", "method": "post") }}
	{{ partial("partials/body1") }}
	<table width={{d_width}}>
		<tr>
			<td align='center'>
				<select name="fac">
				{% for fc in fdata%}
					<option value="{{fc['key']}}" {{fc['chk']}}>{{fc['val']}}</option>
				{% endfor%}
				</select>
			</td>
			{% if udata == 0%}
				<td align='center'><input type="button" name="o_btn" value="반출" onclick="selectedMove('/move/recordout')" /></td>
			{% else %}
				<td align='center'><input type="button" name="o_btn" value="반입" onclick="selectedMove('/move/recordin')" /></td>
			{% endif %}
			<td align='center'><input type="button" name="o_btn" value="취소" onclick="selectedMove('/move')" /></td>
		</tr>
	</table>
	<table width={{ d_width }}>
	{% if err == true%}
		<tr>
			<td>{{ text_area('comment', 'value': data, 'cols': 25, 'rows': 6, 'readonly': 'readonly', 'style':'width:100%') }}</td>
		</tr>
	{% else %}
		<tr bgcolor="#B0C4DE">
			<td align="center">상품명</td>
			<td align="center">폭/길이/수량</td>
			<td align="center">취소</td>
		</tr>
		{% for dt in data %}
			<tr>
				<td align="center">{{dt['itm_name']}}</td>
				<td align="center">{{dt['itm_width']}}/{{dt['itm_length']}}/{{dt['itm_ea']}}{{dt['his_iunit']}}</td>
				<td align="center"><input type="button" name="del" value='Del' onclick="{{dt['post']}}" /></td>
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
			{% if udata == 0%}
				<td align='center'><input type="button" name="o_btn" value="반출" onclick="selectedMove('/move/recordout')" /></td>
			{% else %}
				<td align='center'><input type="button" name="o_btn" value="반입" onclick="selectedMove('/move/recordin')" /></td>
			{% endif %}
			<td align='center'><input type="button" name="o_btn" value="취소" onclick="selectedMove('/move')" /></td>
		</tr>
	</table>
	{% endif %}
	{{ hidden_field(security.getTokenKey(), "value": security.getToken()) }}
	{{ endform() }}
	</body>
</html>
