( function( $ ) {

	/**
	 * Main container object.
	 */
	function WC_MNM_Lightbox( container ) {

		var self           = this;
		this.container     = container;
		this.$form         = container.$mnm_form;
		this.$child_images = container.$mnm_items.find( '.mnm_child_product_images' );

		/**
		 * Launch popups for child images.
		 */
		this.init_photoswipe = function() {

			this.$child_images.each( function() { console.log('found');
				
				$(this).wc_product_gallery( { zoom_enabled: false, flexslider_enabled: false } );

				var $placeholder = $(this).find( 'a.placeholder_image' );

				if ( $placeholder.length > 0 ) {
					$placeholder.on( 'click', function() {
						return false;
					} );
				}

			} );


		};

		// Init PhotoSwipe if present.
		if ( typeof PhotoSwipe !== 'undefined' && 'yes' === WC_MNM_LIGHTBOX_PARAMS.photoswipe_enabled ) {
			this.init_photoswipe();
		}

	} // End WC_MNM_Lightbox.

	/*-----------------------------------------------------------------*/
	/*  Initialization.                                                */
	/*-----------------------------------------------------------------*/

	$( 'body' ).on( 'wc-mnm-initializing', function( e, container ) {
		var lightbox = new WC_MNM_Lightbox( container );
	});

} ) ( jQuery );