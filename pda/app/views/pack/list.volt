<html>
	{{ partial("partials/header") }}
	<body>
	<script>
	document.body.ontouchend = function() { document.querySelector('[name="b_id"]').focus(); };
	</script>
	{{ form("pack/list", "method": "post") }}
	{{ partial("partials/body1") }}
	<table width={{d_width}} bgcolor = "#30508C" style="color:white;">
            <tr>
                    <td align='center'>패킹번호:{{ p_title }}</td>
            </tr>
	</table>
        {% if d_cnt > 0 %}
            <table width={{d_width}}>
                <tr>
                        <td align='center'><input type="button" name="o_btn" value="패킹" onclick="selectedMove('/pack/pack')" /></td>
                        <td align='center'>&nbsp;</td>
                        <td align='center'><input type="button" name="o_btn" value="취소" onclick="selectedMove('/pack')" /></td>
                </tr>
            </table>
        {% endif %}
	<table width={{ d_width }}>
	{% if err == true%}
		<tr>
			<td colspan="3">{{ text_area('comment', 'value': err_msg, 'cols': 25, 'rows': 6, 'readonly': 'readonly', 'style':'width:100%') }}</td>
		</tr>
	{% endif %}
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
                    <td align='center'><input type="button" name="o_btn" value="패킹" onclick="selectedMove('/pack/pack')" /></td>
                    <td align='center'>&nbsp;</td>
                    <td align='center'><input type="button" name="o_btn" value="취소" onclick="selectedMove('/pack')" /></td>
            </tr>
	</table>
	{{ hidden_field(security.getTokenKey(), "value": security.getToken()) }}
	{{ endform() }}
	</body>
</html>
