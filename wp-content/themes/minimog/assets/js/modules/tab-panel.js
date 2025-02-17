(function( $ ) {
	'use strict';

	var $window = $( window );

	var MinimogTabPanel = function( $el, options ) {
		this.$el             = $el;
		this.$contentWrapper = $el.find( '.minimog-tabs__content' );
		this.ACTIVE_CLASS    = 'active';
		this.SWITCHING_CLASS = 'switching';

		this.defaults = {
			navType: 'list',
			contentHeight: 0
		};
		this.settings = $.extend( {}, this.defaults, options );

		// jQuery methods.
		this.triggerMethod = ( method, options ) => {
			if ( typeof this[method] === 'function' ) {
				this[method]( options );
			}
		};

		this.setOptions = function( options ) {
			options = options || {};

			this.settings = $.extend( {}, this.settings, options );
		};

		this.getOptions = function() {
			return this.settings;
		};

		this.update = function( options ) {
			this.setOptions( options );

			this.updateContentHeight();
		};

		this.init = function() {
			var plugin       = this,
			    $contentTabs = this.$contentWrapper.children( '.tab-content' );

			if ( 'dropdown' === plugin.settings.navType ) {
				$el.on( 'change', '.tab-select', function( evt ) {
					var index = $( this ).val();

					plugin.switchTab( index );
				} );

				if ( $.fn.MinimogNiceSelect() ) {
					$el.find( '.tab-select' ).MinimogNiceSelect();
				}
			} else {
				$el.on( 'click', '.tab-title', function( evt ) {
					evt.preventDefault();

					var $thisTab = $( this ),
					    index    = $thisTab.data( 'tab' );

					if ( $thisTab.hasClass( plugin.ACTIVE_CLASS ) ) {
						return;
					}

					$thisTab.siblings().removeClass( plugin.ACTIVE_CLASS ).attr( 'aria-selected', 'false' ).attr( 'tabindex', '-1' );
					$thisTab.addClass( plugin.ACTIVE_CLASS ).attr( 'aria-selected', 'true' ).attr( 'tabindex', '0' );

					plugin.switchTab( index );
				} );

				if ( $.fn.perfectScrollbar && ! window.minimog.Helpers.isHandheld() ) {
					$el.find( '.minimog-tabs__header-inner' ).perfectScrollbar( {
						suppressScrollY: true,
						useBothWheelAxes: true,
					} );
				}
			}

			this.$activeTab = $el.find( '.tab-content.active' );
			this.updateLayout();

			// Update Tab when child components size changed.
			if ( $.fn.MinimogAccordion ) {
				var $accordion = plugin.$el.find( '.minimog-accordion' );
				if ( 0 < $accordion.length ) {
					$accordion.on( 'MinimogAccordionBeforeChange', function() {
						plugin.$el.addClass( plugin.SWITCHING_CLASS );
					} );

					$accordion.on( 'MinimogAccordionChange', function() {
						plugin.updateLayout();
						setTimeout( function() {
							plugin.$el.removeClass( plugin.SWITCHING_CLASS );
						}, 400 );
					} );
				}
			}

			const observer = new ResizeObserver( entries => {
				this.updateLayout();
			} );
			$contentTabs.each( function() {
				// Start listening for size changes.
				observer.observe( $( this ).get( 0 ) );
			} );

			$el.addClass( 'initialized' );
		};

		this.switchTab = function( index ) {
			var plugin = this;
			$el.addClass( plugin.SWITCHING_CLASS );
			var $panel = $el.find( '.tab-content' );
			$panel.removeClass( plugin.ACTIVE_CLASS ).attr( 'aria-expanded', false ).prop( 'hidden', true );

			this.$activeTab =
				$panel.filter( '[data-tab="' + index + '"]' ).addClass( plugin.ACTIVE_CLASS ).attr( 'aria-expanded', true ).prop( 'hidden', false );
			plugin.updateLayout();

			setTimeout( function() {
				$el.removeClass( plugin.SWITCHING_CLASS );
			}, 400 );

			$( document.body ).trigger( 'MinimogTabChange', [ $el, this.$activeTab ] );
		};

		/**
		 * Calculate tab content height
		 */
		this.updateLayout = function() {
			this.settings.contentHeight = this.$activeTab.outerHeight();
			this.updateContentHeight();
		};

		this.updateContentHeight = function() {
			this.$contentWrapper.css( 'height', this.settings.contentHeight + 'px' );
		};

		this.init();
	};

	const namespace = 'minimogTabPanel';

	$.fn.extend( {
		MinimogTabPanel: function( args, update ) {
			// Check if selected element exist.
			if ( ! this.length ) {
				return this;
			}

			// We need to return options.
			if ( args === 'options' ) {
				return $.data( this.get( 0 ), namespace ).getOptions();
			}

			return this.each( function() {
				var $el = $( this );

				let instance = $.data( this, namespace );

				if ( instance ) { // Already created then trigger method.
					instance.triggerMethod( args, update );
				} else { // Create new instance.
					instance = new MinimogTabPanel( $el, args );
					$.data( this, namespace, instance );
				}
			} );
		}
	} );
}( jQuery ));
