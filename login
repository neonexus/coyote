<doc>
	<header title="Login" extjs="true"/>
	<ext>
		<itemset var="myBtns">
			<button text="Login"/>
			<button text="Reset"/>
		</itemset>
		<window var="myWin" title="Login" closable="false" minimizable="false" modal="true" maximizable="false">
			<form labelAlign="right" buttons="myBtns">
				<fieldset>
					<textbox name="uname" allowBlank="false" label="Username"/>
					<password name="upass" allowBlank="false" label="Password"/>
				</fieldset>
			</form>
		</window>
		<js>
			myWin.show();
		</js>
	</ext>
</doc>