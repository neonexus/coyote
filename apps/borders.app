<window id="form-win" layout="fit" width="660" height="420" iconCls="icon-grid" title="Layout Example">
	<!-- The "borderLayout" tag is a wrapper for 5 different tags -->
	<!-- It wraps "north, south, east, west, center" tags, each of which can only appear once inside of the "borderLayout" tag -->
	<borderlayout border="false">
		<center layout="fit" shim="false" title="NeoNexus's Desktop">
			<!-- The "tabPanel" tag is a wrapper for "tab" tags -->
			<tabpanel title="Testing the tabs" border="false" tabPosition="bottom">
				<!-- The "tab" tag is a wrapper for almost any ExtJs tag -->
				<tab title="First tab" border="true" frame="true">
					<!-- The "form" tag is just a wrapper for form tags (ex. "textbox", "password", etc) -->
					<form title="Testing the nesting">
						<!-- The "fieldset" tag is a wrapper that should only be used in "form" tags -->
						<fieldset title="Some Group" checkboxToggle="true">
							<password label="Password Field" allowBlank="false" width="100"/>
							<textbox label="Just a textbox" width="100"/>
							<numberfield label="Number Field" maxValue="1000" width="100"/>
							<filefield label="File Field" width="100"/>
						</fieldset>
						<fieldset title="Another Group">
							<date label="A date field" width="100"/>
							<!--<combobox label="A combo box" width="100" storage="myStorage3"/>-->
							<textarea width="100" grow="true" label="Some textarea"/>
						</fieldset>
					</form>
				</tab>
				<tab title="Test">
					Testing
				</tab>
			</tabpanel>
		</center>
		<west title="Applications" titleCollapse="true" layout="fit" frame="true" collapsible="true" width="150" minsize="150">
			Our application tree would be shown here, or our currently open application tree...
		</west>
		<east title="File System" layout="fit" frame="true" minsize="150" width="150" collapsible="true" titleCollapse="true">
			This is where our file system tree would be
		</east>
	</borderlayout>
</window>