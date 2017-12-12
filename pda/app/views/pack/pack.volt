<html>
	{{ partial("partials/header") }}
	<body>
	{{ form("output", "method": "post") }}
	{{ partial("partials/body2") }}
        <table width={{d_width}} bgcolor = "#30508C" style="color:white;">
            <tr>
                    <td align='center'>패킹번호:{{ p_title }}</td>
            </tr>
	</table>
	<table width={{d_width}}>
		<tr>
			<td align='center'><input type="button" name="o_btn" value="확인" onclick="selectedMove('/pack')" /></td>
			<td align='center'>&nbsp;</td>
			<td align='center'><input type="button" name="o_btn" value="취소" onclick="selectedMove('/pack/cancel')" /></td>
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
			<td align='center'><input type="button" name="o_btn" value="확인" onclick="selectedMove('/pack')" /></td>
			<td align='center'>&nbsp;</td>
			<td align='center'><input type="button" name="o_btn" value="취소" onclick="selectedMove('/pack/cancel')" /></td>
		</tr>
	</table>
	{{ hidden_field(security.getTokenKey(), "value": security.getToken()) }}
	{{ endform() }}
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<script type="text/javascript">barcode("{{ packing_no }}",40,2,4,2,4);</script>
	</body>
</html>