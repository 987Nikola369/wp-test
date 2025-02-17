(function( window, $ ) {
	'use strict';

	window.minimog              = window.minimog || {};
	var $supports_html5_storage = true;

	try {
		$supports_html5_storage = ('sessionStorage' in window && window.sessionStorage !== null);
		window.sessionStorage.setItem( 'mg', 'test' );
		window.sessionStorage.removeItem( 'mg' );
		window.localStorage.setItem( 'mg', 'test' );
		window.localStorage.removeItem( 'mg' );
	} catch ( err ) {
		$supports_html5_storage = false;
	}

	minimog.Storage = {
		isSupported: $supports_html5_storage,
		set: function( key, value ) {
			var settings = JSON.parse( localStorage.getItem( 'minimog' ) );
			settings     = settings ? settings : {};

			settings[key] = value;

			localStorage.setItem( 'minimog', JSON.stringify( settings ) );
		},
		get: function( key, defaults = '' ) {
			var settings = JSON.parse( localStorage.getItem( 'minimog' ) );

			if ( settings && settings.hasOwnProperty( key ) ) {
				return settings[key];
			}

			return defaults;
		},
	};

	minimog.Helpers = {
		getAjaxUrl: ( action ) => {
			return $minimog.minimog_ajax_url.toString().replace( '%%endpoint%%', action );
		},

		isEmptyObject: ( obj ) => {
			for ( let name in obj ) {
				return false;
			}

			return true;
		},

		isValidSelector: ( selector ) => {
			if ( selector.match( /^([.#])(.+)/ ) ) {
				return true;
			}

			return false;
		},

		isHandheld: () => {
			let check = false;
			(function( a ) {
				if ( /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test( a ) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test( a.substr( 0, 4 ) ) ) {
					check = true;
				}
			})( navigator.userAgent || navigator.vendor || window.opera );
			return check;
		},

		randomInteger: ( min, max ) => {
			return Math.floor( Math.random() * (max - min + 1) ) + min;
		},

		/**
		 * Add a URL parameter (or changing it if it already exists)
		 * @param {string} url - This is typically document.location.search
		 * @param {string} key - The key to set
		 * @param {string} val - Value
		 */
		addUrlParam( url, key, val ) {
			key = encodeURI( key );
			val = encodeURI( val );

			if ( '' !== val ) {
				var re        = new RegExp( "([?&])" + key + "=.*?(&|$)", "i" );
				var separator = url.indexOf( '?' ) !== - 1 ? "&" : "?";

				// Update value if key exist.
				if ( url.match( re ) ) {
					url = url.replace( re, '$1' + key + "=" + val + '$2' );
				} else {
					url += separator + key + '=' + val;
				}
			} else {
				this.removeUrlParam( url, key );
			}

			return url;
		},

		removeUrlParam( url, key ) {
			const params = new URLSearchParams( url );
			params.delete( key );
			return url;
		},

		getUrlParamsAsObject: ( query ) => {
			var params = {};

			if ( - 1 === query.indexOf( '?' ) ) {
				return params;
			}

			query = query.substring( query.indexOf( '?' ) + 1 );

			var re       = /([^&=]+)=?([^&]*)/g;
			var decodeRE = /\+/g;

			var decode = function( str ) {
				return decodeURIComponent( str.replace( decodeRE, " " ) );
			};

			var e;
			while ( e = re.exec( query ) ) {
				var k = decode( e[1] ),
				    v = decode( e[2] );
				if ( k.substring( k.length - 2 ) === '[]' ) {
					k = k.substring( 0, k.length - 2 );
					(params[k] || (params[k] = [])).push( v );
				} else {
					params[k] = v;
				}
			}

			var assign = function( obj, keyPath, value ) {
				var lastKeyIndex = keyPath.length - 1;
				for ( var i = 0; i < lastKeyIndex; ++ i ) {
					var key = keyPath[i];
					if ( ! (key in obj) ) {
						obj[key] = {}
					}
					obj = obj[key];
				}
				obj[keyPath[lastKeyIndex]] = value;
			}

			for ( var prop in params ) {
				var structure = prop.split( '[' );
				if ( structure.length > 1 ) {
					var levels = [];
					structure.forEach( function( item, i ) {
						var key = item.replace( /[?[\]\\ ]/g, '' );
						levels.push( key );
					} );
					assign( params, levels, params[prop] );
					delete (params[prop]);
				}
			}
			return params;
		},

		getScrollbarWidth: () => {
			// When not has scrollbar
			if ( window.innerWidth <= document.documentElement.clientWidth ) {
				return 0;
			}

			// Creating invisible container.
			const outer                 = document.createElement( 'div' );
			outer.style.visibility      = 'hidden';
			outer.style.overflow        = 'scroll'; // forcing scrollbar to appear.
			outer.style.msOverflowStyle = 'scrollbar'; // needed for WinJS apps.
			document.body.appendChild( outer );

			// Creating inner element and placing it in the container.
			const inner = document.createElement( 'div' );
			outer.appendChild( inner );

			// Calculating difference between container's full width and the child width.
			const scrollbarWidth = (outer.offsetWidth - inner.offsetWidth);

			// Removing temporary elements from the DOM.
			outer.parentNode.removeChild( outer );

			return scrollbarWidth;
		},

		setBodyOverflow() {
			$( 'body' ).css( {
				'overflow': 'hidden',
				'paddingRight': this.getScrollbarWidth() + 'px'
			} );
		},

		unsetBodyOverflow: () => {
			$( 'body' ).css( {
				'overflow': 'visible',
				'paddingRight': 0
			} );
		},

		setBodyHandling: () => {
			$( 'body' ).removeClass( 'completed' ).addClass( 'handling' );
		},

		setBodyCompleted: () => {
			$( 'body' ).removeClass( 'handling' ).addClass( 'completed' );
		},

		setElementHandling: ( $element ) => {
			$element.addClass( 'updating-icon' );
		},

		unsetElementHandling: ( $element ) => {
			$element.removeClass( 'updating-icon' );
		},

		getStyle: ( el, style ) => {
			if ( window.getComputedStyle ) {
				return style ? document.defaultView.getComputedStyle( el, null ).getPropertyValue( style ) : document.defaultView.getComputedStyle( el, null );
			} else if ( el.currentStyle ) {
				return style ? el.currentStyle[style.replace( /-\w/g, ( s ) => {
					return s.toUpperCase().replace( '-', '' );
				} )] : el.currentStyle;
			}
		},

		setCookie: ( cname, cvalue, exdays ) => {
			let d = new Date();
			d.setTime( d.getTime() + (exdays * 24 * 60 * 60 * 1000) );
			let expires     = 'expires=' + d.toUTCString();
			document.cookie = cname + '=' + cvalue + '; ' + expires + '; path=/';
		},

		getCookie: ( cname ) => {
			var name = cname + '=';
			var ca   = document.cookie.split( ';' );
			for ( var i = 0; i < ca.length; i ++ ) {
				var c = ca[i];
				while ( c.charAt( 0 ) == ' ' ) {
					c = c.substring( 1 );
				}
				if ( c.indexOf( name ) == 0 ) {
					return c.substring( name.length, c.length );
				}
			}
			return '';
		},

		copyToClipboard: ( text ) => {
			if ( window.clipboardData && window.clipboardData.setData ) {
				// Internet Explorer-specific code path to prevent textarea being shown while dialog is visible.
				return window.clipboardData.setData( "Text", text );

			} else if ( document.queryCommandSupported && document.queryCommandSupported( "copy" ) ) {
				var textarea            = document.createElement( "textarea" );
				textarea.textContent    = text;
				textarea.style.position = "fixed";  // Prevent scrolling to bottom of page in Microsoft Edge.
				document.body.appendChild( textarea );
				textarea.select();
				try {
					return document.execCommand( "copy" );  // Security exception may be thrown by some browsers.
				} catch ( ex ) {
					console.warn( "Copy to clipboard failed.", ex );
					return prompt( "Copy to clipboard: Ctrl+C, Enter", text );
				} finally {
					document.body.removeChild( textarea );
				}
			}
		},

		/**
		 * Store html string into data-o_content attribute
		 * @param $element
		 * @param content
		 */
		setContentHTML: ( $element, content ) => {
			if ( undefined === $element.attr( 'data-o_content' ) ) {
				$element.attr( 'data-o_content', $element.html() );
			}
			$element.html( content );
		},

		/**
		 * Restore original html from data-o_content
		 * @param $element
		 */
		resetContentHTML: ( $element ) => {
			if ( undefined !== $element.attr( 'data-o_content' ) ) {
				$element.html( $element.attr( 'data-o_content' ) );
			}
		},

		/**
		 * Run given callback on each image loaded
		 * @param $container
		 * @param callback
		 */
		onImagesLoaded( $container, callback ) {
			$container.find( 'img' ).each( function( i, img ) {
				img.complete && callback();
				img.addEventListener( 'load', () => callback() );
				img.addEventListener( 'error', () => callback() );
			} );
		},

		imagesLoaded( $container ) {
			var plugin   = this,
			    observer = [],
			    $images  = $container.find( 'img' );

			$images && $images.each( function() {
				observer.push( plugin.getImgLoadPromise( $( this ) ) );
			} );

			return observer;
		},

		getImgLoadPromise: ( $img ) => {
			return new Promise( ( res, rej ) => {
				if ( $img.prop( 'complete' ) ) {
					return res();
				}
				$img.on( 'load', () => res() );
				$img.on( 'error', () => res() );
			} );
		}
	}

}( window, jQuery ));
