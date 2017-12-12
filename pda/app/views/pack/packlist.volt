<html>
	{{ partial("partials/header") }}
	<body>
	<script>
	document.body.ontouchend = function() { document.querySelector('[name="b_id"]').focus(); };
	</script>
	{{ form("pack/add", "method": "post") }}
	{{ partial("partials/body1") }}
	<table width={{d_width}}>
		<tr>
			<td align='center'><input type="submit" name="o_btn" value="확정" /></td>
			<td align='center'><input type="button" name="o_btn" value="취소" onclick="selectedMove('/pack')" /></td>
		</tr>
	</table>
	<table width={{ d_width }}>
	{% if err == true%}
		<tr>
			<td>{{ text_area('comment', 'value': data, 'cols': 25, 'rows': 6, 'readonly': 'readonly', 'style':'width:100%') }}</td>
		</tr>
	{% else %}
		<tr>
			<td colspan = "3">{{ text_area('comment', 'value': c_data, 'cols': 25, 'rows': 3, 'readonly': 'readonly', 'style':'width:100%') }}</td>
		</tr>
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
			<td align='center'><input type="submit" name="o_btn" value="확정" /></td>
			<td align='center'><input type="button" name="o_btn" value="취소" onclick="selectedMove('/pack')" /></td>
		</tr>
	</table>
	{% endif %}
	{{ hidden_field(security.getTokenKey(), "value": security.getToken()) }}
	{{ endform() }}
	</body>
</html>
