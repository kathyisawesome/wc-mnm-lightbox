<?php
/**
 * Mix and Match Item Thumbnail, with lightbox support
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/mnm/mnm-product-thumbnail.php.
 *
 * HOWEVER, on occasion WooCommerce Mix and Match will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  Kathy Darling
 * @package WooCommerce Mix and Match/Templates
 * @since   1.0.0
 */
if ( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}
?>
<div class="mnm_child_product_images mnm_image"><?php

	if ( has_post_thumbnail( $mnm_item->get_id() ) ) {

		$image_post_id = get_post_thumbnail_id( $mnm_item->get_id() );
		$image_title   = esc_attr( get_the_title( $image_post_id ) );
		$image_data    = wp_get_attachment_image_src( $image_post_id, 'full' );
		$image_link    = $image_data[ 0 ];

		/**
		 * Child item thumbnail size.
		 *
		 * @param $size
		 */
		$image_size    = apply_filters( 'woocommerce_mnm_product_thumbnail_size', WC_MNM_Core_Compatibility::is_wc_version_gte( '3.3' ) ? 'woocommerce_thumbnail' : 'shop_thumbnail' );

		$image_rel     = current_theme_supports( 'wc-product-gallery-lightbox' ) ? 'photoSwipe' : 'prettyPhoto';

		$image         = get_the_post_thumbnail( $mnm_item->get_id(), $image_size, array(
			'title'                   => $image_title,
			'data-caption'            => get_post_field( 'post_excerpt', $image_post_id ),
			'data-large_image'        => $image_link,
			'data-large_image_width'  => $image_data[ 1 ],
			'data-large_image_height' => $image_data[ 2 ],
		) );

		$html  = '<figure class="mnm_child_product_images woocommerce-product-gallery__image">';
		$html .= sprintf( '<a href="%1$s" class="image zoom" title="%2$s" data-rel="%3$s">%4$s</a>', $image_link, $image_title, $image_rel, $image );
		$html .= '</figure>';

	} else {

		$html  = '<figure class="mnm_child_product_images woocommerce-product-gallery__image--placeholder">';
		$html .= sprintf( '<a href="%1$s" class="placeholder_image zoom" data-rel="%3$s"><img class="wp-post-image" src="%1$s" alt="%2$s"/></a>', wc_placeholder_img_src(), __( 'Child product placeholder image', 'wc-mnm-lightbox' ), $image_rel );
		$html .= '</figure>';
	}

	echo apply_filters( 'wc_mnm_child_product_image_html', $html, $mnm_item->get_id(), $mnm_item );

?></div>

