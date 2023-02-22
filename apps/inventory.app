<json>
	<js>
		<![CDATA[		
		function change(val){
			if(val > 0){
				return '<span style="color:green;">' + val + '</span>';
			}else if(val < 0){
				return '<span style="color:red;">' + val + '</span>';
			}
			return val;
		}

		function pctChange(val){
			if(val > 0){
				return '<span style="color:green;">' + val + '%</span>';
			}else if(val < 0){
				return '<span style="color:red;">' + val + '%</span>';
			}
			return val;
		}
		
		Ext.ns('desktop.inventory');
		]]>
	</js>
	<dataTable ns="desktop.inventory.data">
		<dr>
			<dc><text>X35-black</text><hr align="left" size="2" width="100%"/><text>Neat!</text></dc>
			<dc><text>Cases</text><hr align="left" size="2" width="100%"/><text>This rules!</text></dc>
			<dc>Some Company</dc>
			<dc>40</dc>
			<dc>3</dc>
			<dc>120</dc>
		</dr>
		<dr>
			<dc>2GB (1GB X 2) Stick of RAM</dc>
			<dc>Memory</dc>
			<dc>Generic CO.</dc>
			<dc>75</dc>
			<dc>2</dc>
			<dc>150</dc>
		</dr>
	</dataTable>
	
	<storage ns="desktop.inventory.storage" data="desktop.inventory.data">
		<storageField name="product"/>
		<storageField name="cat"/>
		<storageField name="manuf"/>
		<storageField name="cost" type="float"/>
		<storageField name="quant" type="float"/>
		<storageField name="total" type="float"/>
	</storage>
	
	<window title="Inventory Manager" id="invenman" layout="fit" width="650" height="400">
		<tabpanel>
			<tab title="View" layout="fit">
				<grid storage="desktop.inventory.storage" autoExpandColumn="comp1" numberRows="true">
					<gridColumn header="Product" id="comp1" dataIndex="product"/>
					<gridColumn header="Category" dataIndex="cat" width="60"/>
					<gridColumn header="Manufacturer" dataIndex="manuf" width="115"/>
					<gridColumn header="Cost" renderer="'usMoney'" dataIndex="cost" width="55"/>
					<gridColumn header="Quantity" renderer="change" dataIndex="quant" width="50"/>
					<gridColumn header="Total Cost" renderer="'usMoney'" dataIndex="total" widht="60"/>
				</grid>
			</tab>
			<tab title="Create New" border="false" layout="anchor">
				<form id="new-prod" anchor="100%">
					<fieldset title="New Product">
						<textbox label="Product Name" id="prod-name" allowBlank="false"/>
						<textbox label="Category" id="prod-cat" allowBlank="false"/>
						<textbox label="Manufacturer" id="prod-manuf" allowBlank="false"/>
						<numberfield label="Cost" id="prod-cost" allowNegative="false" allowBlank="false" minValue="0" maxValue="10000"/>
						<numberfield label="Quantity" id="prod-quan" allowNegative="false" allowDecimals="false" allowBlank="false"/>
					</fieldset>
				</form>
			</tab>
		</tabpanel>
	</window>
</json>