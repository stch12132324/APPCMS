<!--{php require template("headerMini","common","Admin")}-->
<script src="/Static/admin/js/admin-login.js"></script>
<div class="container-fluid loginArea" style="text-align:center;">
	<div class="myLoginArea">
		<div class="span4">
			<form action="/Admin-Index-doLogin.html" method="post" name="loginForm">
			<table class="table table-bordered" >
				<tr>
					<td>
						<input type="text" value="ÓÃ»§Ãû" class="minput username" name="username">
                        <i class="icon-user inputfr"></i>
						<input type="password" value="" class="minput password" name="password">
                        <i class="icon-cog inputfr2"></i>
						<input type="submit" class="btn btn-me btn-success pull-right" value="µÇ Â¼">
					</td>
				</tr>
	  		</table>
            <!--{if $msg!= ''}--><span class="alert alert-danger">{$msg}</span><!--{/if}-->
			</form>
		</div>
	</div>
</div>
</body>
</html>