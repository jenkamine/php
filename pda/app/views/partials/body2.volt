<table width={{ d_width }} bgcolor="gray" cellspacing = "0" cellpadding = "0">
	<tr>
		<td align="center" width ="42%"><h2>{{title}}</h2></td>
		<td width="58%"></td>
	</tr>
</table>
<table width={{ d_width }} cellspacing = "0" cellpadding = "0">
	<tr>
		<td><input type="radio" name="work" value="O" onClick="redirectUser(1)" {{w_chk1}}>출고</td>
		<td><input type="radio" name="work" value="A" onClick="redirectUser(2)" {{w_chk2}}>숙성</td>
		<td><input type="radio" name="work" value="M" onClick="redirectUser(3)" {{w_chk3}}>이동</td>
		<td><input type="radio" name="work" value="C" onClick="redirectUser(4)" {{w_chk4}}>실사</td>
		<td><input type="radio" name="work" value="C" onClick="redirectUser(5)" {{w_chk5}}>패킹</td>
	</tr>
	</tr>
</table>