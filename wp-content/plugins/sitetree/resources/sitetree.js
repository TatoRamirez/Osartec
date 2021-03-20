/**
 * Copyright 2020 Luigi Cavalieri.
 * @license GPL v3.0 (https://opensource.org/licenses/GPL-3.0).
 * *************************************************************** */


function SiteTreeSetting( id ) {
	this.id		   = id;
	this._target   = document.getElementById( id );
	this._jqTarget = null;
	this._row	   = null;
}

SiteTreeSetting.prototype.value = function() {
	if ( this._target ) {
		return this._target.value;
	}
	
	return null;
};

SiteTreeSetting.prototype.disable = function( disable ) {
	if (! this._target ) {
		return false;
	}
		
	if ( typeof disable == 'undefined' ) {
		disable = true;
	}
	
	this._target.disabled = disable;
};
	
SiteTreeSetting.prototype.bindEvent = function( event, handler ) {
	if (! this._jqTarget ) {
		this._jqTarget = jQuery( this._target );
	}
		
	this._jqTarget.on( event, handler );
};
	
SiteTreeSetting.prototype.isChecked = function() {
	if ( this._target ) {
		return this._target.checked;
	}
		
	return null;
};
	
SiteTreeSetting.prototype.hide = function( hide ) {
	if (! this._target ) {
		return false;
	}
		
	if (! this._row ) {
		this._row = this._target.parentNode.parentNode;
	}
	
	if ( hide || ( typeof hide === 'undefined' ) ) {
		this._row.style.display = 'none';
	}
	else {
		this._row.style.display = 'table-row';
	}
};

SiteTreeSetting.prototype.toggle = function() {
	if (! this._target )
		return false;
		
	if (! this._row )
		this._row = this._target.parentNode.parentNode;
		
	if ( this._row.style.display == 'none' ) {
		this._row.style.display = 'table-row';
	}
	else {
		this._row.style.display = 'none';
	}
};


function SiteTreePingUI( node ) {
    this.mouseIsOn    = false;
    this.isVisible    = false;
    this.pingInfoView = node.firstChild;

    var that = this;

    jQuery( node ).hover( function(){ that.show() }, function(){ that.hide() } );
}

SiteTreePingUI.prototype.show = function() {
    this.mouseIsOn = true;

    if (! this.isVisible ) {
        this.isVisible = true;
        this.pingInfoView.style.display = 'block';
    }
};

SiteTreePingUI.prototype.hide = function() {
    this.mouseIsOn = false;
        
    setTimeout( function( that ){
        if (! that.mouseIsOn ) {
            that.isVisible = false;
            that.pingInfoView.style.display = 'none';
        }
    }, 800, this );
};


var SiteTree = (function($) {
    return {
		init: function( page_id ) {
			switch ( page_id ) {
				case 'sitetree-dashboard':
					var site_tree_page_select = document.getElementById( 'page-for-site-tree' );
					var ping_ui_nodes         = document.getElementsByClassName( 'sitetree-ping' );

                    var ping_ui_objects = [];
   
                    if ( ping_ui_nodes ) {
                        for ( var i = 0; i < ping_ui_nodes.length; i++ ) {
                            ping_ui_objects[i] = new SiteTreePingUI( ping_ui_nodes[i] );
                        }
                    }
                    
					if ( site_tree_page_select && ( site_tree_page_select.value === '0' ) ) {
						var primary_tb_btn = document.getElementById( 'sitetree-primary-site_tree-form-btn' );

						primary_tb_btn.disabled = true;

						site_tree_page_select.onchange = function() {
							primary_tb_btn.disabled = ( site_tree_page_select.value === '0' );
						};
					}
					break;
					
				case 'sitetree-site_tree':
					var settings = {};
					var ids		 = ['page-exclude-childs', 'page-hierarchical', 'post-group-by', 
									'post-order-by', 'authors-show-avatar', 'authors-avatar-size'];
					
					for ( var i = 0; i < ids.length; i++ ) {
						settings[ ids[i].replace( /-/g, '_' ) ] = new SiteTreeSetting( ids[i] );
					}
					
					// Initialise state
					if ( settings.page_exclude_childs.isChecked() ) {
						settings.page_hierarchical.hide();
					}

					if (! settings.authors_show_avatar.isChecked() ) {
						settings.authors_avatar_size.hide();
					}
					
					if ( settings.post_group_by.value() == 'date' ) {
						settings.post_order_by.hide();
					}
					
					// Events binding
					settings.page_exclude_childs.bindEvent( 'click', function() {
						settings.page_hierarchical.toggle();
					});
					settings.authors_show_avatar.bindEvent( 'click', function() {
						settings.authors_avatar_size.toggle();
					});
					
					settings.post_group_by.bindEvent( 'change', function() {
						settings.post_order_by.hide( this.value == 'date' );
					});
					break;
			}	
		}
	};
})(jQuery);