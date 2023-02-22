/*
 * Ext JS Library 2.2
 * Copyright(c) 2006-2008, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */

Ext.namespace('Ext.ux');

/**
 * @class Ext.ux.ComponentLoader
 * Provides an easy way to load components dynamically. If you provide these components
 * with an id you can use Ext.ComponentMgr's onAvailable function to manipulate the components
 * as they are added.
 * @singleton
 */
 
/*
* To load components from a server resource, use Ext.ux.ComponentLoader.load(config),
* config options include anything available in Ext.Ajax.request()
* Note: Always uses the connection of Ext.Ajax 
*/

/*
* Note: This class expects the server to return a json array,
* where the keys are components (where the components to be loaded are),
* and success (which is a bool value).
* To run a custom javascript error, put the data in the form of a string into the key "dofail".
*/

/*
* Note: Final note, Ext.ux.ComponentLoader.load() also expects to receive a container attribute
* in either the config options passed in during the call, or returned from the server in each component.
* If specified in both places, the returned value from the server takes priority. 
*/
Ext.ux.ComponentLoader=function(){var cm=Ext.ComponentMgr;return {root:'components',load:function(config){Ext.apply(config,{callback:this.ol.createDelegate(this,[config.container],true),scope:this});if(config.container){Ext.apply(config.params,{container:config.container});}Ext.Ajax.request(config);},ol:function(opts,success,response,ct){var b=Ext.decode(response.responseText);if(b.success){var a=b[this.root];for(var i=0;i<a.length;i++){var c=a[i];if(c.xtype&&c.xtype==='viewport'){cm.create(c);}else{var ct=c.container||ct;Ext.getCmp(ct).add(c);Ext.getCmp(ct).doLayout();}}}else{if(typeof b.dofail=='string'){eval(b.dofail);}else{this.ofr();}}},ofr:function(){Ext.Msg.alert('Load failed. Please try again.');}};}();