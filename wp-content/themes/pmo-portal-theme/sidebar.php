<?php
/**
 * The sidebar
 *
 * @package PMO_Portal_Theme
 */

if ( ! is_active_sidebar( 'primary-sidebar' ) ) {
	return;
}
?>

<aside id="secondary" class="sidebar primary-sidebar" role="complementary">
	<?php dynamic_sidebar( 'primary-sidebar' ); ?>
</aside>
