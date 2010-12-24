/*!
 * Ext JS Library 3.3.1
 * Copyright(c) 2006-2010 Sencha Inc.
 * licensing@sencha.com
 * http://www.sencha.com/license
 */
Ext.ns('Ext.ux.grid');

/**
 * @class Ext.ux.grid.CheckColumn
 * @extends Ext.grid.Column
 * <p>A Column subclass which renders a checkbox in each column cell which toggles the truthiness of the associated data field on click.</p>
 * <p><b>Note. As of ExtJS 3.3 this no longer has to be configured as a plugin of the GridPanel.</b></p>
 * <p>Example usage:</p>
 * <pre><code>
var cm = new Ext.grid.ColumnModel([{
       header: 'Foo',
       ...
    },{
       xtype: 'checkcolumn',
       header: 'Indoor?',
       dataIndex: 'indoor',
       width: 55
    }
]);

// create the grid
var grid = new Ext.grid.EditorGridPanel({
    ...
    colModel: cm,
    ...
});
 * </code></pre>
 * In addition to toggling a Boolean value within the record data, this
 * class toggles a css class between <tt>'x-grid3-check-col'</tt> and
 * <tt>'x-grid3-check-col-on'</tt> to alter the background image used for
 * a column.
 */
Ext.ux.grid.CheckColumn = Ext.extend(Ext.grid.Column, {

    /**
     * @private
     * Process and refire events routed from the GridView's processEvent method.
     */
    processEvent : function(name, e, grid, rowIndex, colIndex){
        if (name == 'mousedown') {
            var record = grid.store.getAt(rowIndex);
            if(!this.disabled) {
                record.set(this.dataIndex, !record.data[this.dataIndex]);
            }
            return false; // Cancel row selection.
        } else {
            return Ext.grid.ActionColumn.superclass.processEvent.apply(this, arguments);
        }
    },

    renderer : function(v, p, record){
        p.css += ' x-grid3-check-col-td';
        return String.format('<div class="x-grid3-check-col{0}">&#160;</div>', v ? '-on' : '');
    },

    // Deprecate use as a plugin. Remove in 4.0
    init: Ext.emptyFn
});

// register ptype. Deprecate. Remove in 4.0
Ext.preg('checkcolumn', Ext.ux.grid.CheckColumn);

// backwards compat. Remove in 4.0
Ext.grid.CheckColumn = Ext.ux.grid.CheckColumn;

// register Column xtype
Ext.grid.Column.types.checkcolumn = Ext.ux.grid.CheckColumn;


/**
 * This plugin can be either used on BasicForm or FormPanel.
 * In both cases it adds a method clear() to the object
 * which allows to clear (empty) all the forms values.
 * This is opposed to the reset() method which resets all values
 * to the last values loaded through a call to load().
 * But sometimes (e.g. when you want to recycle an existing form for use
 * for a new record, you have to clear the form and also corectly reset
 * the isDirty() flag.
 *
 *
 */
Ext.ux.FormClear=function()
{

    this.init=function(_object)
    {
        if (typeof _object.form=="object")
        { //we are a formpanel and have a form, be kind and also add the method to the basic form

            //clear method for the underlying form:
            _object.form.clear=function()
            {
                var data={};
                this.items.each(function(item)
                {
                    data[item.getName()]=null;
                });

                var emptyRecord=new Ext.data.Record(data);
                this.loadRecord(emptyRecord);
                this.reset();
            };

            //clear method for the forpanel itself
            _object.clear=function()
            {
                var data={};
                this.items.each(function(item)
                {
                    data[item.getName()]=null;
                });

                var emptyRecord=new Ext.data.Record(data);
                this.form.loadRecord(emptyRecord);
                this.getForm().reset();
            };

        }
        else
        { //we are a basicform
            _object.clear=function()
            {
                var data={};
                this.items.each(function(item)
                {
                    data[item.getName()]=null;
                });

                var emptyRecord=new Ext.data.Record(data);
                this.loadRecord(emptyRecord);
            };
        }
    };

};

/** add clearDirty to basicform */
Ext.override(Ext.form.BasicForm,{
    clearDirty : function(nodeToRecurse){
        nodeToRecurse = nodeToRecurse || this;
        nodeToRecurse.items.each(function(f){
            if(f.items){
                this.clearDirty(f);
            } else if(f.originalValue != f.getValue()){
                f.originalValue = f.getValue();
            }
        },this);
    }
});