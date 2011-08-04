<?php

class De_Aktey_Secapp_Application_Security_SigninViewHelper extends Zend_View_Helper_Abstract {

	public function signin() {
		return '<form method="post" action="'. $this->view->url(array('action' => 'login')) .'">
				<table id="secapp_login">
					'. ($this->view->fail ? '
						<tr>
							<td id="secapp_login_error" colspan="2">'. $this->view->escape($this->fail) .'</td>
						</tr>' : '' ) .'
					<tr>
						<td><label for="secapp_login_user">Username:</lable></td>
						<td><input id="secapp_login_user" type="text" name="username" /></td>
					</tr>
					<tr>
						<td><label for="secapp_login_passwd">Password:</lable></td>
						<td><input id="secapp_login_passwd" type="password" name="password" /></td>
					</tr>
					<tr>
                    	<td colspan="2" align="right"><input type="submit" name="login" value="Sign in" /></td>
					</tr>
				</table>
			</form>';
	}
}