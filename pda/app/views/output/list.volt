<html>
	{{ partial("partials/header") }}
	<body>
	<script>
		function onlyNumber(event){
			event = event || window.event;
			var keyID = (event.which) ? event.which : event.keyCode;
			if ( (keyID >= 48 && keyID <= 57) || (keyID >= 96 && keyID <= 105) || keyID == 8 || keyID == 46 || keyID == 37 || keyID == 39 ) 
				return;
			else
				return false;
		}
		function removeChar(event) {
			event = event || window.event;
			var keyID = (event.which) ? event.which : event.keyCode;
			if ( keyID == 8 || keyID == 46 || keyID == 37 || keyID == 39 ) 
				return;
			else
				event.target.value = event.target.value.replace(/[^0-9]/g, "");
		}
	</script>
	</script>
	{{ form("output/list", "method": "post") }}
	{{ partial("partials/body1") }}
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
			<td align='center'><input type="button" name="n_btn" size='1' value="▼" onclick="decrease_num('{{rt['req_code']}}')" /><input type='text' id='{{rt['req_code']}}' name='o_qty' value='{{rt['ord_qty']}}' size='4' onkeydown='return onlyNumber(event)' onkeyup='removeChar(event)' style='ime-mode:disabled;' /d><input type="button" name="n_btn" size='1' value="▲" onclick="increase_num('{{rt['req_code']}}')" /></td>
		</tr>
		{% endfor %}  
    {% endif %}
		<input type="submit" style="position: absolute; left: -9999px; width: 1px; height: 1px;"/>
	</table>
	{% if err == true%}
	<table width={{ d_width }}>
		<tr>
			<td colspan="3">{{ text_area('comment', 'value': err_msg, 'cols': 25, 'rows': 6, 'readonly': 'readonly', 'style':'width:100%') }}</td>
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
				<td align="center"><input type="button" name="del" value='Del' onclick="{{dt['post']}}" /></td>
			</tr>
		{% endfor %}
    {% endif %}             
	</table>
	{% else %}
	<table width={{d_width}}>
		<tr>
			<td align='center'><input type="button" name="o_btn" value="출고" onclick="arrPost('/output/record','o_qty')" /></td>
			<td align='center'><input type="button" name="o_btn" value="샘플출고" onclick="arrPost('/output/srecord','o_qty')" /></td>
			<td align='center'><input type="button" name="o_btn" value="취소" onclick="post('/output')" /></td>
		</tr>
	</table>
	<table width={{ d_width }}>
		<tr bgcolor="#B0C4DE">
			<td align="center">상품명</td>
			<td align="center">폭/길이/수량</td>
			<td align="center">취소</td>
		</tr>
		{% if d_cnt > 0 %}     
			{% for dt in data %}
				<tr>
					<td align="center">{{dt['itm_name']}}</td>
					<td align="center">{{dt['itm_width']}}/{{dt['itm_length']}}/{{dt['itm_ea']}}{{dt['his_iunit']}}</td>
					<td align="center"><input type="button" name="del" value='Del' onclick="{{dt['post']}}" /></td>
				</tr>
			{% endfor %}   
		{% else %}
				<tr>
					<td align="center" colspan = "3">박스라벨의 바코드를 읽지 않고 출고하면 의뢰코드의 상품이 출고된 것으로 처리됩니다.</td>
				</tr>
		{% endif %}
	</table>
	<table width={{d_width}}>
		<tr>
			<td align='center'><input type="button" name="o_btn" value="출고" onclick="arrPost('/output/record','o_qty')" /></td>
			<td align='center'><input type="button" name="o_btn" value="샘플출고" onclick="arrPost('/output/srecord','o_qty')" /></td>
			<td align='center'><input type="button" name="o_btn" value="취소" onclick="post('/output')" /></td>
		</tr>
	</table>
	{% endif %}
	{{ hidden_field(security.getTokenKey(), "value": security.getToken()) }}
	{{ endform() }}
	</body>
</html>
