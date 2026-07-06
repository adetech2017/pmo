<?php
/**
 * The header for our theme
 *
 * @package PMO_Portal_Theme
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<!-- Performance: Preconnect to external resources -->
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://cdnjs.cloudflare.com" />
	<link rel="dns-prefetch" href="//fonts.googleapis.com" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
	<!-- Premium Government Header -->
	<header id="masthead" class="site-header">
		<!-- Sticky Header Container -->
		<div class="header-wrapper" style="background: var(--color-white); position: sticky; top: 0; z-index: 999; transition: all 0.3s ease; box-shadow: var(--shadow-xs);">
			<div class="container" style="display: flex; justify-content: space-between; align-items: center; padding: var(--space-3) 0;">
				<!-- Branding - Logo -->
				<div class="site-branding" style="display: flex; align-items: center; flex-shrink: 0;">
					<?php
					if ( has_custom_logo() ) {
						the_custom_logo();
					} else {
						?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" style="font-size: var(--font-size-h4); font-weight: var(--font-weight-bold); color: var(--color-primary); text-decoration: none; display: flex; align-items: center; gap: var(--space-2);">
							<span style="font-size: 1.8rem;"><i class="fa-solid fa-landmark" aria-hidden="true"></i></span>
							<span><?php bloginfo( 'name' ); ?></span>
						</a>
						<?php
					}
					?>
				</div>

				<!-- Navigation - Center -->
				<nav id="site-navigation" class="main-navigation" style="flex: 1; margin-left: var(--space-10);">
					<?php
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'menu_class'     => 'nav-menu',
						'container'      => false,
						'fallback_cb'    => 'wp_page_menu',
						'depth'          => 2,
					) );
					?>
				</nav>

				<!-- Site Search Toggle -->
				<button id="header-search-toggle" class="header-search-toggle" aria-label="<?php esc_attr_e( 'Search this site', 'pmo-portal' ); ?>" aria-expanded="false" aria-controls="header-search-panel">
					<i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
				</button>

				<!-- Mobile Menu Toggle -->
				<button id="mobile-menu-toggle" class="mobile-menu-toggle" aria-label="<?php esc_attr_e( 'Toggle navigation', 'pmo-portal' ); ?>" aria-expanded="false" aria-controls="site-navigation" style="display: none; background: none; border: none; font-size: 1.5rem; cursor: pointer; padding: var(--space-2);">
					<span aria-hidden="true"><i class="fa-solid fa-bars" aria-hidden="true"></i></span>
				</button>
			</div>

			<!-- Site Search Panel -->
			<div id="header-search-panel" class="header-search-panel" hidden>
				<div class="container">
					<form role="search" class="header-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
						<label class="screen-reader-text" for="header-search-input"><?php esc_html_e( 'Search this site', 'pmo-portal' ); ?></label>
						<input type="search" id="header-search-input" name="s" placeholder="<?php esc_attr_e( 'Search news, programmes, events…', 'pmo-portal' ); ?>" autocomplete="off" />
						<button type="submit" class="btn btn-primary"><?php esc_html_e( 'Search', 'pmo-portal' ); ?></button>
					</form>
					<div id="header-search-results" class="header-search-results" aria-live="polite"></div>
				</div>
			</div>
		</div>
		<style>
			/* Custom Logo */
			.custom-logo {
				max-height: 50px;
				width: auto;
				display: block;
			}

			.custom-logo-link {
				display: flex;
				align-items: center;
			}

			/* Navigation Menu */
			.nav-menu {
				list-style: none;
				display: flex;
				gap: var(--space-6);
				margin: 0;
				padding: 0;
			}
			.nav-menu a {
				font-size: var(--font-size-small);
				font-weight: var(--font-weight-medium);
				color: var(--color-gray-700);
				text-decoration: none;
				transition: color var(--transition-fast);
				padding: var(--space-2) 0;
				border-bottom: 2px solid transparent;
				display: inline-block;
			}
			.nav-menu a:hover,
			.nav-menu .current-menu-item > a,
			.nav-menu .active > a {
				color: var(--color-primary);
				border-bottom-color: var(--color-accent-dark);
				font-weight: var(--font-weight-semibold);
			}

			/* Mobile Responsive */
			@media (max-width: 768px) {
				.mobile-menu-toggle {
					display: flex !important;
				}

				.main-navigation {
					position: absolute;
					top: 100%;
					left: 0;
					right: 0;
					background: var(--color-white);
					border-bottom: 1px solid var(--color-gray-200);
					max-height: 0;
					overflow: hidden;
					transition: max-height 0.3s ease;
				}

				.main-navigation.active {
					max-height: calc(100vh - 70px);
					overflow-y: auto;
				}

				.nav-menu {
					flex-direction: column;
					gap: var(--space-4);
					padding: var(--space-6);
				}

				.nav-menu a {
					border-bottom: none;
					border-left: 3px solid transparent;
					padding: var(--space-2) var(--space-3);
				}

				.nav-menu a:hover,
				.nav-menu .current-menu-item > a {
					border-left-color: var(--color-accent-dark);
					border-bottom-color: transparent;
				}

				.site-header .container {
					padding: var(--space-3) 0 !important;
				}
			}

			@media (max-width: 480px) {
				.site-branding span:not(:first-child) {
					display: none;
				}
			}
		</style>
	</header>

	<?php if ( ! is_front_page() && ! is_home() ) : ?>
		<nav class="pmo-breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'pmo-portal' ); ?>">
			<div class="container">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'pmo-portal' ); ?></a>
				<?php
				$pmo_crumb = '';
				if ( is_singular() ) {
					$pmo_post_type = get_post_type_object( get_post_type() );
					if ( $pmo_post_type && ! empty( $pmo_post_type->has_archive ) ) {
						$pmo_archive_link = get_post_type_archive_link( get_post_type() );
						if ( $pmo_archive_link ) {
							printf(
								'<span aria-hidden="true">›</span><a href="%s">%s</a>',
								esc_url( $pmo_archive_link ),
								esc_html( $pmo_post_type->labels->name )
							);
						}
					}
					$pmo_crumb = get_the_title();
				} elseif ( is_post_type_archive() ) {
					$pmo_crumb = post_type_archive_title( '', false );
				} elseif ( is_search() ) {
					$pmo_crumb = __( 'Search Results', 'pmo-portal' );
				} elseif ( is_archive() ) {
					$pmo_crumb = get_the_archive_title();
				} elseif ( is_404() ) {
					$pmo_crumb = __( 'Page Not Found', 'pmo-portal' );
				}

				if ( $pmo_crumb ) {
					printf(
						'<span aria-hidden="true">›</span><span aria-current="page">%s</span>',
						esc_html( wp_strip_all_tags( $pmo_crumb ) )
					);
				}
				?>
			</div>
		</nav>
	<?php endif; ?>
