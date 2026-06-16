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
	<meta name="description" content="Lagos State Parastatals Monitoring Office - Government Digital Platform" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<!-- Performance: Preconnect to external resources -->
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://cdnjs.cloudflare.com" />
	<link rel="dns-prefetch" href="//fonts.googleapis.com" />
	<!-- Premium Theme Stylesheet -->
	<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/style.css' ); ?>?v=<?php echo time(); ?>" />
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
							<span style="font-size: 1.8rem;">🏛️</span>
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
						'link_before'    => '',
						'link_after'     => '',
						'walker'         => new PMO_Menu_Walker(),
					) );
					?>
				</nav>

				<!-- Mobile Menu Toggle -->
				<button id="mobile-menu-toggle" class="mobile-menu-toggle" aria-label="Toggle navigation" style="display: none; background: none; border: none; font-size: 1.5rem; cursor: pointer; padding: var(--space-2); margin-left: auto;">
					<span>☰</span>
				</button>
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
				border-bottom-color: var(--color-accent);
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
					max-height: 500px;
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
					border-left-color: var(--color-accent);
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
