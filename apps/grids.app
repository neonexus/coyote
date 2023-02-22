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
		]]>
	</js>
	<!-- The following items are used by our grid application -->
	<item var="tBox">
		<textbox allowBlank="false"/>
	</item>
	<item var="nBox">
		<numberfield allowBlank="false" allowNegative="false" maxValue="200"/>
	</item>
	<item var="nBox2">
		<numberfield allowBlank="false" maxValue="200"/>
	</item>
	<item var="nBox3">
		<numberfield allowBlank="false" maxValue="200"/>
	</item>
	<item var="dBox">
		<date format="m/d/Y" minValue="01/01/06"/>
	</item>
	
	<!-- The "dataTable" tag is a wrapper for "datarow" tags -->
	<!-- It is inteded to be used to store static data, in conjunction with the "storage" tag -->
	<!-- The "var" attribute is required -->
	<!-- NOTE: The "dataTable" MUST be defined BEFORE we reference it in a "storage" tag! -->
	<dataTable var="myData">
		<!-- The "datarow" tag is a wrapper for "datacolumn" tags -->
		<!-- It also has a shorthand name, "dr" -->
		<datarow>
			<!-- The "dataColumn" tag has no attributes, and is a simple wrapper for data -->
			<!-- It also has a shorthand name, "dc" -->
			<datacolumn>Some data</datacolumn>
			<datacolumn>86.54</datacolumn>
			<datacolumn>0.52</datacolumn>
			<datacolumn>1.03</datacolumn>
			<datacolumn>9/7 12:00am</datacolumn>
		</datarow>
		<dr>
			<dc>Dun Dun Dun</dc>
			<dc>83.81</dc>
			<dc>0.36</dc>
			<dc>0.34</dc>
			<dc>9/7 12:00am</dc>
		</dr>
		<dr>
			<dc>Numbers!</dc>
			<dc>83.81</dc>
			<dc>0.78</dc>
			<dc>0.89</dc>
			<dc>9/1 12:00am</dc>
		</dr>
		<dr>
			<dc>MORE DATA!</dc>
			<dc>52.55</dc>
			<dc>0.01</dc>
			<dc>0.02</dc>
			<dc>9/1 12:00am</dc>
		</dr>
		<dr>
			<dc>I demand more!</dc>
			<dc>64.13</dc>
			<dc>0.31</dc>
			<dc>0.49</dc>
			<dc>9/1 12:00am</dc>
		</dr>
	</dataTable>
	
	<dataTable var="myData2">
		<dr>
			<dc>3m Co</dc>
			<dc>71.72</dc>
			<dc>0.02</dc>
			<dc>0.03</dc>
			<dc>9/1 12:00am</dc>
		</dr>
		<dr>
			<dc>Alcoa Inc</dc>
			<dc>29.01</dc>
			<dc>0.42</dc>
			<dc>1.47</dc>
			<dc>9/1 12:00am</dc>
		</dr>
		<dr>
			<dc>Altria Group Inc</dc>
			<dc>83.81</dc>
			<dc>0.28</dc>
			<dc>0.34</dc>
			<dc>9/1 12:00am</dc>
		</dr>
		<dr>
			<dc>American Express Company</dc>
			<dc>52.55</dc>
			<dc>0.01</dc>
			<dc>0.02</dc>
			<dc>9/1 12:00am</dc>
		</dr>
		<dr>
			<dc>American International Group, Inc.</dc>
			<dc>64.13</dc>
			<dc>0.31</dc>
			<dc>0.49</dc>
			<dc>9/1 12:00am</dc>
		</dr>
	</dataTable>
	
	<!-- The "storage" tag is meant to be a map for "dataTable" tags -->
	<!-- 2 attributes are required, "var" and "data", where "data" is the variable of a "dataTable" -->
	<storage var="myStorage" data="myData">
		<!-- The "storageField" tag is where we define how we should handle the data in our "dataTable"-->
		<!-- This is also where we attach names to our "dataColumn" tags -->
		<storageField name="company"/>
		<storageField name="price" type="float"/>
		<storageField name="change" type="float"/>
		<storageField name="pctChange" type="float"/>
		<storageField name="lastChange" type="date" dateFormat="n/j h:ia"/>
	</storage>
	
	<storage var="myStorage2" data="myData2">
		<!-- The "storageField" tag is where we define how we should handle the data in our "dataTable"-->
		<!-- This is also where we attach names to our "dataColumn" tags -->
		<storageField name="company"/>
		<storageField name="price" type="float"/>
		<storageField name="change" type="float"/>
		<storageField name="pctChange" type="float"/>
		<storageField name="lastChange" type="date" dateFormat="n/j h:ia"/>
	</storage>
	
	<window id="grid-win" iconCls="icon-grid" layout="fit" title="Grid Window" width="600" height="350">
		<tabpanel>
			<tab title="Simple Grid" layout="fit">
				<grid storage="myStorage" autoExpandColumn="comp1" numberRows="true">
					<gridColumn header="Company" id="comp1" dataIndex="company"/>
					<gridColumn header="Price" renderer="'usMoney'" dataIndex="price" width="75"/>
					<gridColumn header="Change" renderer="change" dataIndex="change" width="75"/>
					<gridColumn header="% Change" renderer="pctChange" dataIndex="pctChange" width="75"/>
					<gridColumn header="Last Updated" renderer="Ext.util.Format.dateRenderer('m/d/Y')" dataIndex="lastChange" width="85"/>
				</grid>
			</tab>
			<tab title="Editable Grid" layout="fit">
				<editorgrid storage="myStorage2" clicksToEdit="1" autoExpandColumn="comp2" numberRows="true">
					<gridColumn header="Company" id="comp2" editor="tBox" dataIndex="company" width="160"/>
					<gridColumn header="Price" renderer="'usMoney'" editor="nBox" dataIndex="price" width="75"/>
					<gridColumn header="Change" renderer="change" editor="nBox2" dataIndex="change" width="75"/>
					<gridColumn header="% Change" renderer="pctChange" editor="nBox3" dataIndex="pctChange" width="75"/>
					<gridColumn header="Last Updated" editor="dBox" renderer="Ext.util.Format.dateRenderer('m/d/Y')" dataIndex="lastChange" width="85"/>
				</editorgrid>
			</tab>
		</tabpanel>
	</window>
</json>