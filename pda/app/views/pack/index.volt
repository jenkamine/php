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
                    <td align='center'>패킹리스트 작성</td>
            </tr>
	</table>
	{{ hidden_field(security.getTokenKey(), "value": security.getToken()) }}
	{{ endform() }}
	</body>
</html>
