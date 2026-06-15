<?php
/**
 * Simple Gallery Feature - Image upload on Gallery page
 */

/**
 * Enqueue Media Library Scripts
 */
function pmo_enqueue_gallery_media_scripts() {
	global $pagenow;
	if ( in_array( $pagenow, array( 'post.php', 'post-new.php' ) ) ) {
		wp_enqueue_media();
		wp_enqueue_script( 'jquery' );
	}
}
add_action( 'admin_enqueue_scripts', 'pmo_enqueue_gallery_media_scripts' );

/**
 * Add Gallery Images Meta Box to Pages
 */
function pmo_add_simple_gallery_meta_box() {
	add_meta_box(
		'pmo_simple_gallery',
		'📸 Gallery Images',
		'pmo_render_simple_gallery_meta_box',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'pmo_add_simple_gallery_meta_box' );

/**
 * Render Simple Gallery Meta Box
 */
function pmo_render_simple_gallery_meta_box( $post ) {
	wp_nonce_field( 'pmo_gallery_save', 'pmo_gallery_nonce' );

	$gallery_images = get_post_meta( $post->ID, '_pmo_gallery_images', true );
	$image_ids = $gallery_images ? array_filter( array_map( 'intval', explode( ',', $gallery_images ) ) ) : array();
	?>

	<div style="margin-bottom: 20px;">
		<button type="button" class="button button-primary" id="pmo_upload_gallery" style="padding: 8px 16px; font-size: 14px;">
			+ Add Images
		</button>
		<p style="color: #666; margin: 10px 0 0 0; font-size: 13px;">
			Select multiple images from your media library to add to the gallery.
		</p>
	</div>

	<input type="hidden" id="pmo_gallery_image_ids" name="pmo_gallery_images" value="<?php echo esc_attr( $gallery_images ); ?>">

	<div id="pmo_gallery_preview" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 10px; margin-top: 15px; padding-top: 15px; border-top: 1px solid #ddd;">
		<?php
		if ( ! empty( $image_ids ) ) {
			foreach ( $image_ids as $id ) {
				?>
				<div class="pmo-img" data-img="<?php echo intval( $id ); ?>" style="position: relative; border-radius: 4px; overflow: hidden; border: 1px solid #ddd; background: #f5f5f5;">
					<?php echo wp_get_attachment_image( $id, array( 100, 100 ), false, array( 'style' => 'width: 100%; height: 100%; object-fit: cover; display: block;' ) ); ?>
					<button type="button" class="pmo-remove" style="position: absolute; top: 2px; right: 2px; background: #dc3545; color: white; border: none; width: 20px; height: 20px; border-radius: 50%; cursor: pointer; padding: 0; font-size: 12px; line-height: 1; display: flex; align-items: center; justify-content: center;">×</button>
				</div>
				<?php
			}
		} else {
			?>
			<div style="grid-column: 1/-1; padding: 30px; text-align: center; color: #999; background: #fafafa; border-radius: 4px; font-size: 13px;">
				No images selected yet
			</div>
			<?php
		}
		?>
	</div>

	<script type="text/javascript">
	jQuery(function($) {
		let frame = null;

		function refreshPreview(ids) {
			if (!ids || ids.length === 0) {
				$('#pmo_gallery_preview').html('<div style="grid-column: 1/-1; padding: 30px; text-align: center; color: #999; background: #fafafa; border-radius: 4px; font-size: 13px;">No images selected yet</div>');
				return;
			}

			wp.ajax.post('pmo_get_gallery_preview', {
				ids: ids.join(',')
			}).done(function(response) {
				$('#pmo_gallery_preview').html(response);
				attachRemoveHandlers();
			}).fail(function(error) {
				console.error('Error fetching gallery preview:', error);
			});
		}

		function attachRemoveHandlers() {
			$(document).off('click', '.pmo-remove').on('click', '.pmo-remove', function(e) {
				e.preventDefault();
				$(this).closest('.pmo-img').remove();

				let ids = [];
				$('.pmo-img').each(function() {
					ids.push($(this).data('img'));
				});

				$('#pmo_gallery_image_ids').val(ids.join(','));
			});
		}

		$('#pmo_upload_gallery').click(function(e) {
			e.preventDefault();

			if ( ! frame ) {
				frame = wp.media({
					title: 'Select Images for Gallery',
					multiple: true,
					library: { type: 'image' },
					button: { text: 'Add to Gallery' }
				});

				frame.on('select', function() {
					let ids = [];
					let selection = frame.state().get('selection');

					selection.each(function(attachment) {
						ids.push(attachment.id);
					});

					if (ids.length > 0) {
						$('#pmo_gallery_image_ids').val(ids.join(','));
						refreshPreview(ids);
					}
				});
			}

			frame.open();
		});

		attachRemoveHandlers();
	});
	</script>
	<?php
}

/**
 * Save Gallery Images Meta
 */
function pmo_save_gallery_images( $post_id ) {
	if ( ! isset( $_POST['pmo_gallery_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['pmo_gallery_nonce'], 'pmo_gallery_save' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['pmo_gallery_images'] ) ) {
		$images = sanitize_text_field( $_POST['pmo_gallery_images'] );
		if ( ! empty( $images ) ) {
			update_post_meta( $post_id, '_pmo_gallery_images', $images );
		} else {
			delete_post_meta( $post_id, '_pmo_gallery_images' );
		}
	}
}
add_action( 'save_post_page', 'pmo_save_gallery_images' );
