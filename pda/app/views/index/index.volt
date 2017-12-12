<html>
	{{ partial("partials/header") }}
	<body>
		<table width={{ d_width }} bgcolor="gray">
			<tr>
				<td align="center"><h2>{{title}}</h2></td>
			</tr>
		</table>

		{{ form("sign/in", "method": "post") }}
		<table width={{ d_width }}>
			<tr>
				<td width="70"><label for="userid">아이디</label></td>
				<td>{{ text_field("userid", "size": 17) }}</td>
			</tr>
			<tr>
				<td width="70"><label for="dst_ps">암호</label></td>
				<td>{{ password_field("dst_ps", "size": 17) }}</td>
			</tr>
			<tr>
				<td width="70"><label for="place">사용처</label></td>
				<td>{{ select_static("place", ["001" : "1공장", "003" : "3공장", "005" : "5공장"]) }}</td>
			</tr>
			<tr>
				<td height="20" colspan="2" align="center">{{ submit_button("로그인") }}</td>
			</tr>
		</table>
		{{ hidden_field(security.getTokenKey(), "value": security.getToken()) }}
		{{ endform() }}
	</body>
</html>