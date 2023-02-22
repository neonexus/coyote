<json>
	<js>
		Ext.getCmp('desktop').getTopToolbar().disable();
		desktop.menus.cmenu.disable();
	</js>
	<window id="login" border="false" title="Restricted Access" modal="true" resizable="false" width="300" height="135" maximizable="false" closable="false">
		<form>
			<textbox label="Username" id="login-uname" value="demo"/>
			<password label="Password" id="login-pass" value="demo"/>
			<submit text="Login"/>
		</form>
		<button text="Not Registered? Register for FREE!" handler="desktop.openApp('register');"/>
	</window>
</json>