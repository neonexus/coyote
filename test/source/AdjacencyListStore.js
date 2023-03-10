/**
 * Tree store for adjacency list tree representation.
 */
Ext.ux.maximgb.treegrid.AdjacencyListStore = Ext.extend(Ext.ux.maximgb.treegrid.AbstractTreeStore,
{
	/**
	 * @cfg {String} parent_id_field_name Record parent id field name.
	 */
	parent_id_field_name : '_parent',
	
	getRootNodes : function()
	{
		var i, 
				len, 
				result = [], 
				records = this.data.getRange();
		
		for (i = 0, len = records.length; i < len; i++) {
			if (records[i].get(this.parent_id_field_name) == null) {
				result.push(records[i]);
			}
		}
		
		return result;
	},
	
	getNodeDepth : function(rc)
	{
		return this.getNodeAncestors(rc).length;
	},
	
	getNodeParent : function(rc)
	{
		return this.getById(rc.get(this.parent_id_field_name));
	},
	
	getNodeChildren : function(rc)
	{
		var i, 
				len, 
				result = [], 
				records = this.data.getRange();
		
		for (i = 0, len = records.length; i < len; i++) {
			if (records[i].get(this.parent_id_field_name) == rc.id) {
				result.push(records[i]);
			}
		}
		
		return result;
	}
});