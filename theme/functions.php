<?php
/**
 * Catalyst theme functions.
 *
 * @package Catalyst
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access.
}

/**
 * Versioned URI for a theme asset (uses filemtime for cache-busting in dev).
 *
 * @param string $rel Path relative to the theme root, e.g. 'css/style.css'.
 * @return array{0:string,1:string} [ url, version ]
 */
function catalyst_asset( $rel ) {
	$url  = get_theme_file_uri( $rel );
	$path = get_theme_file_path( $rel );
	$ver  = file_exists( $path ) ? (string) filemtime( $path ) : '1.0';
	return array( $url, $ver );
}

/* -------------------------------------------------------------------------
 * Language (EN default; RU via the "Landing RU" page template at /ru/)
 * ---------------------------------------------------------------------- */

/**
 * Get or set the current language.
 *
 * Pass 'ru'/'en' to set it (done on template_redirect for the RU page
 * template). With no argument it returns the current language, defaulting to
 * a URL check so 404s under /ru/ are Russian too.
 *
 * @param string|null $set Optional language to set.
 * @return string 'en'|'ru'
 */
function catalyst_lang( $set = null ) {
	static $lang = null;
	if ( null !== $set ) {
		$lang = ( 'ru' === $set ) ? 'ru' : 'en';
		return $lang;
	}
	if ( null !== $lang ) {
		return $lang;
	}
	$lang = 'en';
	if ( ! empty( $_SERVER['REQUEST_URI'] ) ) {
		$path = (string) wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH );
		if ( preg_match( '#^/ru(/|$)#', $path ) ) {
			$lang = 'ru';
		}
	}
	return $lang;
}

/**
 * Return $ru on the Russian site, otherwise $en.
 *
 * @param string $en English string.
 * @param string $ru Russian string.
 * @return string
 */
function catalyst_t( $en, $ru = '' ) {
	return ( 'ru' === catalyst_lang() && '' !== $ru ) ? $ru : $en;
}

/**
 * URL of the site in the given language (used by the toggle).
 *
 * @param string $lang 'en'|'ru'
 * @return string
 */
function catalyst_lang_url( $lang ) {
	return ( 'ru' === $lang ) ? home_url( '/ru/' ) : home_url( '/' );
}

/**
 * Pick the nav menu location for the current language.
 * On the RU site the "<base>_ru" location is used.
 *
 * @param string $base Base location ('primary'|'hero'|'footer').
 * @return string
 */
function catalyst_menu_location( $base ) {
	return ( 'ru' === catalyst_lang() ) ? $base . '_ru' : $base;
}

/**
 * Use the designed SEO title for the landing instead of WordPress' auto title
 * (which would render "RU – Catalyst" for the /ru/ page).
 *
 * @param string $title Default document title.
 * @return string
 */
function catalyst_document_title( $title ) {
	if ( is_admin() ) {
		return $title;
	}
	// Per-page title (e.g. the SEO Page template).
	if ( is_singular() && function_exists( 'get_field' ) ) {
		$page_title = (string) get_field( 'meta_title' );
		if ( '' !== $page_title ) {
			return $page_title;
		}
	}
	if ( is_front_page() || is_page_template( 'page-landing-ru.php' ) ) {
		$default_en = 'UAE Visas, Residency & Company Setup in Dubai — Turnkey Legal Support | Catalyst Advisory';
		$default_ru = 'Визы ОАЭ 2026, ВНЖ при покупке недвижимости и регистрация компании в Дубае | Catalyst Advisory';
		$seo        = catalyst_opt_lang( 'seo_title', $default_en, $default_ru );
		if ( '' !== $seo ) {
			return $seo;
		}
	}
	return $title;
}
add_filter( 'pre_get_document_title', 'catalyst_document_title', 20 );

/**
 * Meta tag values: per-page ACF override (singular) falls back to the global
 * SEO settings (language-aware).
 */
function catalyst_meta_description() {
	if ( is_singular() && function_exists( 'get_field' ) ) {
		$v = (string) get_field( 'meta_description' );
		if ( '' !== $v ) {
			return $v;
		}
	}
	$default_en = 'UAE visas for foreign nationals 2026, 10-year Golden Visa, UAE residency when buying property in Dubai. Company registration, licensing, opening a bank account in the UAE. 9% corporate tax — turnkey. Legal support in Dubai.';
	$default_ru = 'Визы ОАЭ для россиян 2026, Золотая виза на 10 лет, ВНЖ в Дубае при покупке недвижимости. Регистрация компании, лицензия, открытие счета в банке ОАЭ. Корпоративный налог 9% — под ключ. Юридическое сопровождение в Дубае.';
	return catalyst_opt_lang( 'seo_description', $default_en, $default_ru );
}

function catalyst_meta_keywords() {
	if ( is_singular() && function_exists( 'get_field' ) ) {
		$v = (string) get_field( 'meta_keywords' );
		if ( '' !== $v ) {
			return $v;
		}
	}
	$default = 'Визы ОАЭ, Вид на жительство ОАЭ, Золотая виза ОАЭ, Виза инвестора ОАЭ, Открытие счета в ОАЭ, Юрист Дубай, Юридическая фирма Дубай, Учреждение компании ОАЭ, Лицензия на компанию в ОАЭ, выход на рынок ОАЭ, виза ОАЭ для россиян 2026, Золотая виза ОАЭ на 10 лет, ВНЖ в Дубае при покупке недвижимости, регистрация компании ОАЭ, открытие счёта в банке ОАЭ, корпоративный налог ОАЭ 9%, налоговый учёт ОАЭ, покупка недвижимости ОАЭ для ВНЖ';
	return catalyst_opt_lang( 'seo_keywords', $default, $default );
}

function catalyst_meta_robots() {
	if ( is_404() ) {
		return 'noindex, follow';
	}
	if ( is_singular() && function_exists( 'get_field' ) ) {
		$v = (string) get_field( 'meta_robots' );
		if ( '' !== $v ) {
			return $v;
		}
	}
	return catalyst_opt_lang( 'seo_robots', 'index, follow', 'index, follow' );
}

// We output the robots tag ourselves (from the fields above).
remove_action( 'wp_head', 'wp_robots', 1 );

// The "Landing RU" page template switches the whole page to Russian.
add_action(
	'template_redirect',
	function () {
		if ( is_page_template( 'page-landing-ru.php' ) ) {
			catalyst_lang( 'ru' );
		}
	}
);

/**
 * Theme setup.
 */
function catalyst_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support(
		'html5',
		array( 'search-form', 'gallery', 'caption', 'style', 'script' )
	);

	register_nav_menus(
		array(
			// English locations.
			'primary'    => __( 'Header overlay (EN)', 'catalyst' ),
			'hero'       => __( 'Hero right nav (EN)', 'catalyst' ),
			'footer'     => __( 'Footer menu (EN)', 'catalyst' ),
			// Russian locations (used on /ru/).
			'primary_ru' => __( 'Header overlay (RU)', 'catalyst' ),
			'hero_ru'    => __( 'Hero right nav (RU)', 'catalyst' ),
			'footer_ru'  => __( 'Footer menu (RU)', 'catalyst' ),
		)
	);
}
add_action( 'after_setup_theme', 'catalyst_setup' );

/**
 * Front-end styles and scripts.
 */
function catalyst_assets() {
	// --- Styles (order: normalize -> vendor -> theme -> media) ---
	list( $normalize_url, $normalize_ver ) = catalyst_asset( 'css/normalize.css' );
	wp_enqueue_style( 'catalyst-normalize', $normalize_url, array(), $normalize_ver );

	list( $swiper_url, $swiper_ver ) = catalyst_asset( 'css/swiper.css' );
	wp_enqueue_style( 'catalyst-swiper', $swiper_url, array(), $swiper_ver );

	list( $aos_url, $aos_ver ) = catalyst_asset( 'css/aos.css' );
	wp_enqueue_style( 'catalyst-aos', $aos_url, array(), $aos_ver );

	list( $style_url, $style_ver ) = catalyst_asset( 'css/style.css' );
	wp_enqueue_style(
		'catalyst-style',
		$style_url,
		array( 'catalyst-normalize', 'catalyst-swiper', 'catalyst-aos' ),
		$style_ver
	);

	list( $media_url, $media_ver ) = catalyst_asset( 'css/media.css' );
	wp_enqueue_style( 'catalyst-media', $media_url, array( 'catalyst-style' ), $media_ver );

	if ( is_404() ) {
		list( $e404_url, $e404_ver ) = catalyst_asset( 'css/404.css' );
		wp_enqueue_style( 'catalyst-404', $e404_url, array( 'catalyst-style' ), $e404_ver );
	}

	if ( 'ru' === catalyst_lang() ) {
		list( $ru_url, $ru_ver ) = catalyst_asset( 'css/ru.css' );
		wp_enqueue_style( 'catalyst-ru', $ru_url, array( 'catalyst-media' ), $ru_ver );
	}

	if ( is_page_template( 'page-seo.php' ) ) {
		list( $seo_url, $seo_ver ) = catalyst_asset( 'css/seo.css' );
		wp_enqueue_style( 'catalyst-seo', $seo_url, array( 'catalyst-style' ), $seo_ver );
	}

	// --- Scripts ---
	// app.js is an ES module that pulls in the local vendor bundles
	// (AOS / Lenis / Swiper) and then main.js. See js/app.js.
	// Version off both app.js and main.js so changing main.js (imported
	// without its own enqueue) still busts the cache.
	$app_path = get_theme_file_path( 'js/app.js' );
	$main_path = get_theme_file_path( 'js/main.js' );
	$app_ver  = (string) max(
		file_exists( $app_path ) ? filemtime( $app_path ) : 0,
		file_exists( $main_path ) ? filemtime( $main_path ) : 0
	);
	wp_enqueue_script( 'catalyst-app', get_theme_file_uri( 'js/app.js' ), array(), $app_ver, true );
}
add_action( 'wp_enqueue_scripts', 'catalyst_assets' );

/**
 * Load app.js as an ES module (modules are deferred by default).
 *
 * @param string $tag    The script tag.
 * @param string $handle The script handle.
 * @param string $src    The script source URL.
 * @return string
 */
function catalyst_module_type( $tag, $handle, $src ) {
	if ( 'catalyst-app' === $handle ) {
		$tag = sprintf(
			'<script type="module" src="%s" id="%s-js"></script>' . "\n",
			esc_url( $src ),
			esc_attr( $handle )
		);
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'catalyst_module_type', 10, 3 );

/**
 * Render the modal Gravity Form submit button as a real <button> with the
 * design's arrow icon and the existing .modal__btn styling.
 *
 * @param string $button The default button HTML.
 * @param array  $form   The form object.
 * @return string
 */
function catalyst_gform_submit_button( $button, $form ) {
	$modal_form_id = (int) get_option( 'catalyst_modal_form_id' );
	if ( ! $modal_form_id || (int) $form['id'] !== $modal_form_id ) {
		return $button;
	}

	$text = ( ! empty( $form['button']['text'] ) ) ? $form['button']['text'] : 'Contact us';
	$text = catalyst_t( $text, 'Связаться с нами' );
	$icon = '<svg width="39" height="39" viewBox="0 0 39 39" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="19.5" cy="19.5" r="19.5" fill="#fff"/><path d="M23.0027 17.845L15.4716 25.0175L14.2344 23.8392L21.7646 16.6667H15.1278V15H24.7527V24.1667H23.0027V17.845Z" fill="#FF5300"/></svg>';

	return sprintf(
		'<button type="submit" id="gform_submit_button_%1$d" class="gform_button button modal__btn" onclick="gform.submission.handleButtonClick(this);" data-submission-type="submit">%2$s %3$s</button>',
		$modal_form_id,
		esc_html( $text ),
		$icon
	);
}
add_filter( 'gform_submit_button', 'catalyst_gform_submit_button', 10, 2 );

// The form is fully styled by the theme's .modal rules, so skip Gravity Forms'
// own (orbital) theme CSS — avoids specificity conflicts with our styles.
add_filter( 'gform_disable_form_theme_css', '__return_true' );

/**
 * Russian placeholders / button for the modal form.
 *
 * @param array $form The form object.
 * @return array
 */
function catalyst_gform_ru( $form ) {
	$modal_form_id = (int) get_option( 'catalyst_modal_form_id' );
	if ( 'ru' !== catalyst_lang() || (int) $form['id'] !== $modal_form_id ) {
		return $form;
	}
	$placeholders = array(
		'1' => 'Имя',
		'2' => '+971 00 000 0000',
		'3' => 'example@mail.com',
	);
	foreach ( $form['fields'] as $field ) {
		$fid = (string) $field->id;
		if ( isset( $placeholders[ $fid ] ) ) {
			$field->placeholder = $placeholders[ $fid ];
		}
	}
	$form['button']['text'] = 'Связаться с нами';
	return $form;
}
add_filter( 'gform_pre_render', 'catalyst_gform_ru' );
add_filter( 'gform_pre_validation', 'catalyst_gform_ru' );

/**
 * Russian validation messages for the modal form.
 *
 * @param array  $result Validation result (is_valid, message).
 * @param mixed  $value  Submitted value.
 * @param array  $form   The form object.
 * @param object $field  The field object.
 * @return array
 */
function catalyst_gform_ru_validation( $result, $value, $form, $field ) {
	$modal_form_id = (int) get_option( 'catalyst_modal_form_id' );
	if ( 'ru' !== catalyst_lang() || (int) $form['id'] !== $modal_form_id || $result['is_valid'] ) {
		return $result;
	}
	if ( false !== stripos( $result['message'], 'required' ) ) {
		$result['message'] = 'Обязательное поле';
	} elseif ( false !== stripos( $result['message'], 'email' ) ) {
		$result['message'] = 'Введите корректный email';
	}
	return $result;
}
add_filter( 'gform_field_validation', 'catalyst_gform_ru_validation', 10, 4 );

/**
 * Helper: read an ACF option with a fallback when ACF is missing/empty.
 *
 * @param string $name    Field name.
 * @param mixed  $default Fallback value.
 * @return mixed
 */
function catalyst_opt( $name, $default = '' ) {
	if ( function_exists( 'get_field' ) ) {
		$value = get_field( $name, 'option' );
		if ( null !== $value && '' !== $value && false !== $value ) {
			return $value;
		}
	}
	return $default;
}

/**
 * Read an ACF option for the current language ("<name>_ru" on RU).
 *
 * @param string $name       Base field name.
 * @param string $default_en English fallback.
 * @param string $default_ru Russian fallback.
 * @return mixed
 */
function catalyst_opt_lang( $name, $default_en = '', $default_ru = '' ) {
	if ( 'ru' === catalyst_lang() ) {
		return catalyst_opt( $name . '_ru', $default_ru );
	}
	return catalyst_opt( $name, $default_en );
}

/**
 * Site logo URL: the uploaded ACF logo, or the bundled logo.svg fallback.
 *
 * @return string
 */
function catalyst_logo_url() {
	if ( function_exists( 'get_field' ) ) {
		$logo = get_field( 'logo', 'option' );
		if ( is_array( $logo ) && ! empty( $logo['url'] ) ) {
			return $logo['url'];
		}
		if ( is_numeric( $logo ) ) {
			$url = wp_get_attachment_image_url( (int) $logo, 'full' );
			if ( $url ) {
				return $url;
			}
		}
		if ( is_string( $logo ) && '' !== $logo ) {
			return $logo;
		}
	}
	return get_theme_file_uri( 'assets/img/logo.svg' );
}

/**
 * URL of an ACF option image, or a bundled fallback.
 *
 * @param string $field        Option field name.
 * @param string $fallback_rel Theme-relative fallback path.
 * @param string $size         Image size.
 * @return string
 */
function catalyst_option_image_url( $field, $fallback_rel, $size = 'large' ) {
	if ( function_exists( 'get_field' ) ) {
		$img = get_field( $field, 'option' );
		if ( is_array( $img ) ) {
			$url = isset( $img['sizes'][ $size ] ) ? $img['sizes'][ $size ] : ( $img['url'] ?? '' );
			if ( $url ) {
				return $url;
			}
		} elseif ( is_numeric( $img ) ) {
			$url = wp_get_attachment_image_url( (int) $img, $size );
			if ( $url ) {
				return $url;
			}
		} elseif ( is_string( $img ) && '' !== $img ) {
			return $img;
		}
	}
	return get_theme_file_uri( $fallback_rel );
}

/* -------------------------------------------------------------------------
 * SVG upload support (admins only, with sanitization)
 * ---------------------------------------------------------------------- */

/**
 * Allow the SVG mime type for users who can manage options.
 */
add_filter(
	'upload_mimes',
	function ( $mimes ) {
		if ( current_user_can( 'manage_options' ) ) {
			$mimes['svg']  = 'image/svg+xml';
			$mimes['svgz'] = 'image/svg+xml';
		}
		return $mimes;
	}
);

/**
 * WordPress validates the "real" mime of an upload and rejects SVGs because
 * finfo reports them as text/plain or image/svg+xml inconsistently. Restore
 * the ext/type for .svg files so the upload is accepted.
 */
add_filter(
	'wp_check_filetype_and_ext',
	function ( $data, $file, $filename, $mimes ) {
		if ( ! empty( $data['ext'] ) && ! empty( $data['type'] ) ) {
			return $data;
		}
		$ext = strtolower( (string) pathinfo( $filename, PATHINFO_EXTENSION ) );
		if ( 'svg' === $ext || 'svgz' === $ext ) {
			$data['ext']  = $ext;
			$data['type'] = 'image/svg+xml';
		}
		return $data;
	},
	10,
	4
);

/**
 * Strip dangerous content from an SVG file in place.
 *
 * @param string $path Absolute path to the SVG on disk.
 * @return bool True on success, false if the file is invalid/unsafe.
 */
function catalyst_sanitize_svg( $path ) {
	$svg = file_get_contents( $path );
	if ( false === $svg || '' === trim( $svg ) ) {
		return false;
	}

	// Reject DOCTYPE / ENTITY declarations (XXE / billion-laughs vectors).
	if ( false !== stripos( $svg, '<!DOCTYPE' ) || false !== stripos( $svg, '<!ENTITY' ) ) {
		return false;
	}

	$prev = libxml_use_internal_errors( true );

	$dom                     = new DOMDocument();
	$dom->preserveWhiteSpace = false;

	if ( ! $dom->loadXML( $svg, LIBXML_NONET ) ) {
		libxml_use_internal_errors( $prev );
		return false;
	}

	// Root element must be <svg>.
	if ( ! $dom->documentElement || 'svg' !== strtolower( $dom->documentElement->nodeName ) ) {
		libxml_use_internal_errors( $prev );
		return false;
	}

	$xpath           = new DOMXPath( $dom );
	$disallowed_tags = array( 'script', 'foreignobject', 'iframe', 'embed', 'object', 'audio', 'video', 'handler', 'listener', 'set' );

	foreach ( $disallowed_tags as $tag ) {
		$nodes = $xpath->query( '//*[translate(local-name(), "ABCDEFGHIJKLMNOPQRSTUVWXYZ", "abcdefghijklmnopqrstuvwxyz")="' . $tag . '"]' );
		foreach ( iterator_to_array( $nodes ) as $node ) {
			$node->parentNode->removeChild( $node );
		}
	}

	// Remove event-handler attributes and javascript:/data: links.
	foreach ( iterator_to_array( $xpath->query( '//*' ) ) as $el ) {
		if ( ! $el->attributes ) {
			continue;
		}
		foreach ( iterator_to_array( $el->attributes ) as $attr ) {
			$name    = strtolower( $attr->nodeName );
			$value   = trim( (string) $attr->nodeValue );
			$is_href = in_array( $name, array( 'href', 'xlink:href' ), true );

			if ( 0 === strpos( $name, 'on' ) || ( $is_href && preg_match( '/^\s*(javascript|data)\s*:/i', $value ) ) ) {
				$el->removeAttributeNode( $attr );
			}
		}
	}

	$clean = $dom->saveXML( $dom->documentElement );
	libxml_use_internal_errors( $prev );

	if ( false === $clean || '' === $clean ) {
		return false;
	}

	$clean = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . $clean;
	return false !== file_put_contents( $path, $clean );
}

/**
 * Sanitize SVGs on upload; reject if they can't be made safe.
 */
add_filter(
	'wp_handle_upload_prefilter',
	function ( $file ) {
		if ( empty( $file['type'] ) || 'image/svg+xml' !== $file['type'] ) {
			return $file;
		}
		if ( ! current_user_can( 'manage_options' ) ) {
			$file['error'] = __( 'SVG uploads are not allowed for your role.', 'catalyst' );
			return $file;
		}
		if ( ! catalyst_sanitize_svg( $file['tmp_name'] ) ) {
			$file['error'] = __( 'This SVG could not be sanitized and was rejected. Re-export it as a plain SVG (no scripts/DOCTYPE).', 'catalyst' );
		}
		return $file;
	}
);

/**
 * Make SVG thumbnails render at a sane size in the admin media views.
 */
add_action(
	'admin_head',
	function () {
		echo '<style>img[src$=".svg"],.attachment img[src$=".svg"],.acf-image-uploader img[src$=".svg"]{width:100%;height:auto;max-width:60px;}</style>';
	}
);

/* -------------------------------------------------------------------------
 * Nav menu walkers
 * ---------------------------------------------------------------------- */

/**
 * Translate a known menu label to the current language.
 *
 * Menus stay defined in English in the admin; on the RU site their labels are
 * mapped here (custom/unknown labels fall through unchanged).
 *
 * @param string $title Menu item title.
 * @return string
 */
function catalyst_tr_menu( $title ) {
	if ( 'ru' !== catalyst_lang() ) {
		return $title;
	}
	$map = array(
		'Home'             => 'Главная',
		'Our Story'        => 'О нас',
		'Contacts'         => 'Контакты',
		'What We Do'       => 'Чем мы занимаемся',
		'Who We Work With' => 'С кем мы работаем',
		'Our Team'         => 'Наша команда',
		'HOME'             => 'ГЛАВНАЯ',
		'CONTACTS'         => 'КОНТАКТЫ',
		'WHAT WE DO'       => 'ЧЕМ МЫ ЗАНИМАЕМСЯ',
		'TEAM'             => 'КОМАНДА',
	);
	return isset( $map[ $title ] ) ? $map[ $title ] : $title;
}

/**
 * Header overlay menu: numbered items with an arrow icon.
 */
class Catalyst_Overlay_Walker extends Walker_Nav_Menu {

	/** @var int Running index for the 01/02… numbers. */
	private $count = 0;

	public function start_lvl( &$output, $depth = 0, $args = null ) {}
	public function end_lvl( &$output, $depth = 0, $args = null ) {}
	public function end_el( &$output, $item, $depth = 0, $args = null ) {}

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		if ( $depth > 0 ) {
			return; // Flat menu only.
		}

		$this->count++;
		$num   = sprintf( '%02d', $this->count );
		$arrow = '<svg class="nav-menu__item-arrow" width="30" height="28" viewBox="0 0 30 28" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.4764 15.7055L0.190557 15.7775L2.03154e-05 12.1943L22.2845 12.1211L11.9537 2.54236L14.4082 -5.71818e-05L29.3903 13.8913L15.8904 27.8746L13.1664 25.3489L22.4764 15.7055Z" fill="white"/></svg>';

		$output .= sprintf(
			'<a href="%1$s" class="nav-menu__item"><span class="nav-menu__num">%2$s</span><span class="nav-menu__item-right">%3$s<span class="nav-menu__item-text">%4$s</span></span></a>',
			esc_url( $item->url ),
			esc_html( $num ),
			$arrow,
			esc_html( $item->title )
		);
	}
}

/**
 * Footer menu: flat list of plain anchors.
 */
class Catalyst_Footer_Walker extends Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = null ) {}
	public function end_lvl( &$output, $depth = 0, $args = null ) {}
	public function end_el( &$output, $item, $depth = 0, $args = null ) {}

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		if ( $depth > 0 ) {
			return;
		}
		$output .= sprintf(
			'<a href="%1$s" class="footer__nav-link">%2$s</a>',
			esc_url( $item->url ),
			esc_html( $item->title )
		);
	}
}

/**
 * Fallback for the header overlay menu (used until a menu is assigned).
 */
function catalyst_overlay_menu_fallback() {
	$items = array(
		array( '#hero', 'Home' ),
		array( '#about', 'Our Story' ),
		array( '#contacts', 'Contacts' ),
		array( '#what-we-do', 'What We Do' ),
		array( '#work', 'Who We Work With' ),
	);
	$arrow = '<svg class="nav-menu__item-arrow" width="30" height="28" viewBox="0 0 30 28" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.4764 15.7055L0.190557 15.7775L2.03154e-05 12.1943L22.2845 12.1211L11.9537 2.54236L14.4082 -5.71818e-05L29.3903 13.8913L15.8904 27.8746L13.1664 25.3489L22.4764 15.7055Z" fill="white"/></svg>';
	foreach ( $items as $i => $item ) {
		printf(
			'<a href="%1$s" class="nav-menu__item"><span class="nav-menu__num">%2$02d</span><span class="nav-menu__item-right">%3$s<span class="nav-menu__item-text">%4$s</span></span></a>',
			esc_url( $item[0] ),
			$i + 1,
			$arrow, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG.
			esc_html( catalyst_tr_menu( $item[1] ) )
		);
	}
}

/**
 * Fallback for the footer menu (used until a menu is assigned).
 */
function catalyst_footer_menu_fallback() {
	$items = array(
		array( '#team', 'Our Team' ),
		array( '#hero', 'Home' ),
		array( '#about', 'Our Story' ),
		array( '#contacts', 'Contacts' ),
	);
	foreach ( $items as $item ) {
		printf(
			'<a href="%1$s" class="footer__nav-link">%2$s</a>',
			esc_url( $item[0] ),
			esc_html( catalyst_tr_menu( $item[1] ) )
		);
	}
}

/**
 * Hero right-side navigation: plain anchors with the hero__nav-link class.
 */
class Catalyst_Hero_Walker extends Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = null ) {}
	public function end_lvl( &$output, $depth = 0, $args = null ) {}
	public function end_el( &$output, $item, $depth = 0, $args = null ) {}

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		if ( $depth > 0 ) {
			return;
		}
		$output .= sprintf(
			'<a class="hero__nav-link" href="%1$s">%2$s</a>',
			esc_url( $item->url ),
			esc_html( $item->title )
		);
	}
}

/**
 * Fallback for the hero navigation (used until a menu is assigned).
 */
function catalyst_hero_menu_fallback() {
	$items = array(
		array( '#hero', 'HOME' ),
		array( '#contacts', 'CONTACTS' ),
		array( '#what-we-do', 'WHAT WE DO' ),
		array( '#team', 'TEAM' ),
	);
	foreach ( $items as $item ) {
		printf(
			'<a class="hero__nav-link" href="%1$s">%2$s</a>',
			esc_url( $item[0] ),
			esc_html( catalyst_tr_menu( $item[1] ) )
		);
	}
}

/* -------------------------------------------------------------------------
 * Team members (ACF repeater with a static fallback)
 * ---------------------------------------------------------------------- */

/**
 * Default team members, used until the Team repeater is filled.
 *
 * @return array<int,array<string,string>>
 */
function catalyst_team_fallback() {
	$bio_default    = '<p>Over 19 years of legal experience in international law, corporate structures, compliance, and transactional support. Her professional background includes work with international law firms and ultra-high-net-worth families. She builds and supports complex international structures - from trusts and foundations to holding companies and underlying asset-holding structures.</p><p>Specialisation: international corporate structures and their protection, sanctions law and compliance, legal architecture of private capital, legal risk management, legal support for assets (real estate, yachts, art), comprehensive KYC support.</p><p>Her approach is geared towards strategic decisions and creating a legal architecture that ensures security, stability, and protection of client assets in the current environment.</p>';
	$bio_default_ru = '<p>Более 19 лет юридического опыта в области международного права, корпоративных структур, комплаенса и сопровождения сделок. Её профессиональный опыт включает работу с международными юридическими фирмами и семьями со сверхкрупным капиталом. Она создаёт и сопровождает сложные международные структуры — от трастов и фондов до холдинговых компаний и структур, непосредственно владеющих активами.</p><p>Специализация: международные корпоративные структуры и их защита, санкционное право и комплаенс, юридическая архитектура частного капитала, управление юридическими рисками, юридическое сопровождение активов (недвижимость, яхты, предметы искусства), комплексное сопровождение процедур KYC.</p><p>Её подход ориентирован на стратегические решения и создание юридической архитектуры, обеспечивающей безопасность, стабильность и защиту активов клиентов в современных условиях.</p>';

	return array(
		array(
			'image'   => get_theme_file_uri( 'assets/img/team-card-1.jpg' ),
			'alt'     => 'Dmitry Semchishen',
			'name'    => 'Dmitry Semchishen',
			'role'    => 'Partner, Head of Tax and Finance',
			'bio'     => '<p>Dmitry has extensive experience advising high-net-worth individuals and international businesses on tax matters and leading large international structuring projects. His professional background includes work in UHNWI family offices and Big 4 companies.</p><p>Specialisation: tax law (UAE, Hong Kong, Switzerland, France, Cyprus), transaction structuring and tax due diligence, establishment of holding, trust, and foundation structures, design of payment routes and opening of bank accounts.</p><p>His approach combines deep technical expertise with a pragmatic understanding of cross-border business realities — delivering tax solutions that are both structurally sound and commercially viable.</p>',
			'name_ru' => 'Дмитрий Семчишен',
			'role_ru' => 'Партнёр, руководитель налогового и финансового направлений',
			'bio_ru'  => '<p>Дмитрий имеет обширный опыт консультирования состоятельных частных лиц и международного бизнеса по налоговым вопросам, а также руководства крупными международными структурными проектами. Профессиональный опыт включает работу в family office для UHNWI и компаниях Большой четвёрки.</p><p>Специализация: налоговое право (ОАЭ, Гонконг, Швейцария, Франция, Кипр), структурирование сделок и налоговый due diligence, создание холдинговых структур, трастов и фондов, разработка платёжных маршрутов и открытие банковских счетов.</p><p>Подход сочетает глубокую техническую экспертизу с прагматичным пониманием реалий международного бизнеса — обеспечивая налоговые решения, которые одновременно безупречны с точки зрения структуры и жизнеспособны коммерчески.</p>',
		),
		array(
			'image'   => get_theme_file_uri( 'assets/img/team-card-2.jpg' ),
			'alt'     => 'Ekaterina Ponka',
			'name'    => 'Ekaterina Ponka',
			'role'    => 'Partner, Head of Corporate Division',
			'bio'     => '<p>Over 19 years of legal experience in international law, corporate structures, compliance, and transactional support. Her professional background includes work with international law firms and ultra-high-net-worth families. She builds and supports complex international structures - from trusts and foundations to holding companies and underlying asset-holding structures.</p><p>Specialisation: international corporate structures and their protection, sanctions law and compliance, legal architecture of private capital, legal risk management, legal support for assets (real estate, yachts, art), comprehensive KYC support.</p><p>Her approach is geared towards strategic decisions and creating a legal architecture that ensures security, stability, and protection of client assets in the current environment.</p>',
			'name_ru' => 'Екатерина Понка',
			'role_ru' => 'Партнёр, руководитель корпоративного направления',
			'bio_ru'  => '<p>Более 19 лет юридического опыта в области международного права, корпоративных структур, комплаенса и сопровождения сделок. Профессиональный опыт включает работу с международными юридическими фирмами и семьями со сверхкрупным капиталом. Создаёт и сопровождает сложные международные структуры — от трастов и фондов до холдинговых компаний и структур, непосредственно владеющих активами.</p><p>Специализация: международные корпоративные структуры и их защита, санкционное право и compliance, юридическая архитектура частного капитала, управление юридическими рисками, правовое сопровождение активов (недвижимость, яхты, искусство), комплексная KYC-поддержка.</p><p>Подход ориентирован на стратегические решения и создание юридической архитектуры, обеспечивающей безопасность, устойчивость и защиту активов клиентов в текущих условиях.</p>',
		),
		array(
			'image'   => get_theme_file_uri( 'assets/img/team-card-3.jpg' ),
			'alt'     => 'Anastasia Lion',
			'name'    => 'Anastasia Lion',
			'role'    => 'Project Manager',
			'bio'     => $bio_default,
			'name_ru' => 'Анастасия Лион',
			'role_ru' => 'Менеджер проектов',
			'bio_ru'  => $bio_default_ru,
		),
		array(
			'image'   => get_theme_file_uri( 'assets/img/team-card-4.jpg' ),
			'alt'     => 'Carmen Akkerman',
			'name'    => 'Carmen Akkerman',
			'role'    => 'Associate',
			'bio'     => $bio_default,
			'name_ru' => 'Кармен Аккерман',
			'role_ru' => 'Юрист',
			'bio_ru'  => $bio_default_ru,
		),
	);
}

/**
 * Team members for rendering, resolved to the current language.
 * Uses the ACF repeater if filled, otherwise the fallback. Russian values
 * fall back to English when empty.
 *
 * @return array<int,array<string,string>>
 */
function catalyst_team_members() {
	$is_ru = ( 'ru' === catalyst_lang() );
	$raw   = array();

	if ( function_exists( 'have_rows' ) && have_rows( 'team_members', 'option' ) ) {
		while ( have_rows( 'team_members', 'option' ) ) {
			the_row();
			$img = get_sub_field( 'image' );
			$url = '';
			$alt = '';
			if ( is_array( $img ) ) {
				$url = isset( $img['sizes']['large'] ) ? $img['sizes']['large'] : ( $img['url'] ?? '' );
				$alt = $img['alt'] ?? '';
			} elseif ( is_numeric( $img ) ) {
				$url = (string) wp_get_attachment_image_url( (int) $img, 'large' );
			}
			$raw[] = array(
				'image'   => $url,
				'alt'     => $alt,
				'name'    => (string) get_sub_field( 'name' ),
				'role'    => (string) get_sub_field( 'role' ),
				'bio'     => (string) get_sub_field( 'bio' ),
				'name_ru' => (string) get_sub_field( 'name_ru' ),
				'role_ru' => (string) get_sub_field( 'role_ru' ),
				'bio_ru'  => (string) get_sub_field( 'bio_ru' ),
			);
		}
	}

	if ( empty( $raw ) ) {
		$raw = catalyst_team_fallback();
	}

	$members = array();
	foreach ( $raw as $m ) {
		$name_ru = isset( $m['name_ru'] ) ? $m['name_ru'] : '';
		$role_ru = isset( $m['role_ru'] ) ? $m['role_ru'] : '';
		$bio_ru  = isset( $m['bio_ru'] ) ? $m['bio_ru'] : '';

		$members[] = array(
			'image' => $m['image'],
			'alt'   => ( $is_ru && '' !== $name_ru ) ? $name_ru : $m['alt'],
			'name'  => ( $is_ru && '' !== $name_ru ) ? $name_ru : $m['name'],
			'role'  => ( $is_ru && '' !== $role_ru ) ? $role_ru : $m['role'],
			'bio'   => ( $is_ru && '' !== $bio_ru ) ? $bio_ru : $m['bio'],
		);
	}

	return $members;
}

/* -------------------------------------------------------------------------
 * "What We Do" items (ACF repeater with a static fallback)
 * ---------------------------------------------------------------------- */

/**
 * Default "What We Do" items (8, matching the SVG dots data-i 0..7).
 *
 * @return array<int,array<string,string>>
 */
function catalyst_whatwedo_fallback() {
	return array(
		array(
			'title'       => 'Corporate Law & Structuring',
			'title_ru'    => 'Корпоративное право и структурирование',
			'description' => 'Setting up and restructuring companies, holding structures, and funds in the UAE and other jurisdictions. Corporate governance, shareholder agreements, M&A support.',
			'description_ru' => 'Создание и реструктуризация компаний, холдинговых структур и фондов в ОАЭ и других юрисдикциях. Корпоративное управление, акционерные соглашения, сопровождение сделок по слияниям и поглощениям.',
		),
		array(
			'title'       => 'Tax Planning',
			'title_ru'    => 'Налоговое планирование',
			'description' => 'Tax strategy for businesses and private clients in the UAE, EU, Switzerland, and other jurisdictions. Tax due diligence, structuring transactions, handling tax disputes.',
			'description_ru' => 'Налоговая стратегия для бизнеса и частных клиентов в ОАЭ, ЕС, Швейцарии и других юрисдикциях. Налоговый due diligence, структурирование сделок, ведение налоговых споров.',
		),
		array(
			'title'       => 'Dispute settlement',
			'title_ru'    => 'Урегулирование споров',
			'description' => 'Mediation and structured negotiation between counterparties. Drafting and negotiating settlement agreements. Debt restructuring and creditor-debtor negotiations. Pre-litigation risk assessment and strategy.',
			'description_ru' => 'Медиация и структурированные переговоры между сторонами. Разработка и согласование мировых соглашений. Реструктуризация долга и переговоры между кредиторами и должниками. Оценка рисков и стратегия до начала судебного разбирательств.',
		),
		array(
			'title'       => 'Corporate services in the UAE',
			'title_ru'    => 'Корпоративные услуги в ОАЭ',
			'description' => 'Comprehensive business support: legal, tax, accounting, HR administration, payment administration, communication with regulators and banks.',
			'description_ru' => 'Комплексная поддержка бизнеса по подписке: право, налоги, бухгалтерия, HR-администрирование, администрирование платежей, коммуникация с регуляторами и банками.',
		),
		array(
			'title'       => 'VIP Banking & Payment Routes',
			'title_ru'    => 'VIP-банкинг',
			'description' => 'Opening bank accounts for businesses and individuals in the UAE, Hong Kong, Singapore.',
			'description_ru' => 'Открытие банковских счетов для бизнеса и частных лиц в ОАЭ, Гонконге, Сингапуре.',
		),
		array(
			'title'       => 'Private Wealth & Asset Protection',
			'title_ru'    => 'Управление частным капиталом и защита активов',
			'description' => 'Foundations and establishment of structures for private clients. Succession planning, pre-migration structuring, asset segregation across jurisdictions.',
			'description_ru' => 'Структурирование фондов и family office для частных клиентов. Планирование преемственности, предмиграционное структурирование, защита активов в разных юрисдикциях.',
		),
		array(
			'title'       => 'Sanctions & Compliance',
			'title_ru'    => 'Санкции и комплаенс',
			'description' => 'Sanctions law advice, KYC support, compliance risk management, dealing with regulatory inquiries.',
			'description_ru' => 'Консультирование по санкционному праву, поддержка KYC, управление комплаенс-рисками, работа с запросами регуляторов.',
		),
		array(
			'title'       => 'Employment & Mobility',
			'title_ru'    => 'Трудовое право',
			'description' => 'UAE employment contracts, termination and settlement structuring, golden visa and residency planning, cross-border employment across MENA.',
			'description_ru' => 'Трудовые договоры по праву ОАЭ, структурирование увольнений и расчётов, планирование «золотой визы» и резидентства, трансграничная занятость в странах MENA.',
		),
	);
}

/**
 * "What We Do" items resolved to the current language.
 * Uses the ACF repeater if filled, otherwise the fallback.
 *
 * @return array<int,array<string,string>>
 */
function catalyst_whatwedo_items() {
	$is_ru = ( 'ru' === catalyst_lang() );
	$raw   = array();

	if ( function_exists( 'have_rows' ) && have_rows( 'what_we_do_items', 'option' ) ) {
		while ( have_rows( 'what_we_do_items', 'option' ) ) {
			the_row();
			$raw[] = array(
				'title'          => (string) get_sub_field( 'title' ),
				'title_ru'       => (string) get_sub_field( 'title_ru' ),
				'description'    => (string) get_sub_field( 'description' ),
				'description_ru' => (string) get_sub_field( 'description_ru' ),
			);
		}
	}

	if ( empty( $raw ) ) {
		$raw = catalyst_whatwedo_fallback();
	}

	$items = array();
	foreach ( $raw as $r ) {
		$title_ru = isset( $r['title_ru'] ) ? $r['title_ru'] : '';
		$desc_ru  = isset( $r['description_ru'] ) ? $r['description_ru'] : '';
		$items[]  = array(
			'title' => ( $is_ru && '' !== $title_ru ) ? $title_ru : $r['title'],
			'desc'  => ( $is_ru && '' !== $desc_ru ) ? $desc_ru : $r['description'],
		);
	}

	return $items;
}

/* -------------------------------------------------------------------------
 * ACF: Theme Settings (options page + footer fields). Requires ACF Pro.
 * ---------------------------------------------------------------------- */

add_action(
	'acf/init',
	function () {
		if ( ! function_exists( 'acf_add_options_page' ) ) {
			return; // ACF Pro not active.
		}

		acf_add_options_page(
			array(
				'page_title' => __( 'Theme Settings', 'catalyst' ),
				'menu_title' => __( 'Theme Settings', 'catalyst' ),
				'menu_slug'  => 'theme-settings',
				'capability' => 'manage_options',
				'icon_url'   => 'dashicons-admin-customizer',
				'position'   => 59,
				'redirect'   => false,
			)
		);

		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		acf_add_local_field_group(
			array(
				'key'        => 'group_catalyst_branding',
				'title'      => __( 'Branding', 'catalyst' ),
				'menu_order' => -5,
				'fields'     => array(
					array(
						'key'           => 'field_catalyst_logo',
						'label'         => 'Logo',
						'name'          => 'logo',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'library'       => 'all',
						'mime_types'    => 'svg,png,jpg,jpeg,webp',
						'instructions'  => 'Used in the header, overlay menu and footer. Falls back to the bundled logo if empty.',
					),
				),
				'location'   => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-settings',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_catalyst_footer',
				'title'    => __( 'Footer & Contacts', 'catalyst' ),
				'fields'   => array(
					array(
						'key'           => 'field_catalyst_contact_title',
						'label'         => 'Contact title',
						'name'          => 'contact_title',
						'type'          => 'text',
						'default_value' => 'Get in Touch',
					),
					array(
						'key'           => 'field_catalyst_contact_title_ru',
						'label'         => 'Contact title (RU)',
						'name'          => 'contact_title_ru',
						'type'          => 'text',
						'default_value' => 'Свяжитесь с нами',
					),
					array(
						'key'           => 'field_catalyst_contact_desc',
						'label'         => 'Contact description',
						'name'          => 'contact_desc',
						'type'          => 'textarea',
						'rows'          => 3,
						'new_lines'     => '',
						'default_value' => 'If our expertise is relevant to your situation, contact us for a confidential discussion of your case',
					),
					array(
						'key'           => 'field_catalyst_contact_desc_ru',
						'label'         => 'Contact description (RU)',
						'name'          => 'contact_desc_ru',
						'type'          => 'textarea',
						'rows'          => 3,
						'new_lines'     => '',
						'default_value' => 'Если наша экспертиза кажется вам релевантной, пожалуйста, свяжитесь с нами. Мы назначим конфиденциальную беседу, чтобы обсудить вашу ситуацию и понять, чем можем быть полезны',
					),
					array(
						'key'           => 'field_catalyst_phone_number',
						'label'         => 'Phone (displayed)',
						'name'          => 'phone_number',
						'type'          => 'text',
						'default_value' => '+971 58 512 3578',
					),
					array(
						'key'           => 'field_catalyst_phone_href',
						'label'         => 'Phone link (href)',
						'name'          => 'phone_href',
						'type'          => 'text',
						'instructions'  => 'Full link target, e.g. tel:+971585123578',
						'default_value' => 'tel:+971585123578',
					),
					array(
						'key'          => 'field_catalyst_socials',
						'label'        => 'Social links',
						'name'         => 'socials',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => __( 'Add social', 'catalyst' ),
						'sub_fields'   => array(
							array(
								'key'           => 'field_catalyst_social_icon',
								'label'         => 'Icon',
								'name'          => 'icon',
								'type'          => 'image',
								'return_format' => 'array',
								'preview_size'  => 'thumbnail',
								'library'       => 'all',
								'mime_types'    => 'svg,png,jpg,jpeg,webp',
							),
							array(
								'key'   => 'field_catalyst_social_url',
								'label' => 'URL',
								'name'  => 'url',
								'type'  => 'url',
							),
							array(
								'key'          => 'field_catalyst_social_label',
								'label'        => 'Label (accessibility)',
								'name'         => 'label',
								'type'         => 'text',
								'instructions' => 'Used for alt / aria-label, e.g. Telegram',
							),
						),
					),
					array(
						'key'           => 'field_catalyst_privacy_label',
						'label'         => 'Privacy link text',
						'name'          => 'privacy_label',
						'type'          => 'text',
						'default_value' => 'Privacy Policy',
					),
					array(
						'key'           => 'field_catalyst_privacy_label_ru',
						'label'         => 'Privacy link text (RU)',
						'name'          => 'privacy_label_ru',
						'type'          => 'text',
						'default_value' => 'Политика конфиденциальности',
					),
					array(
						'key'           => 'field_catalyst_privacy_url',
						'label'         => 'Privacy link URL (EN)',
						'name'          => 'privacy_url',
						'type'          => 'url',
					),
					array(
						'key'           => 'field_catalyst_privacy_url_ru',
						'label'         => 'Privacy link URL (RU)',
						'name'          => 'privacy_url_ru',
						'type'          => 'url',
					),
					array(
						'key'           => 'field_catalyst_copyright',
						'label'         => 'Copyright',
						'name'          => 'copyright',
						'type'          => 'text',
						'default_value' => '© 2026',
					),
					array(
						'key'           => 'field_catalyst_brand_text',
						'label'         => 'Brand / license text',
						'name'          => 'brand_text',
						'type'          => 'text',
						'default_value' => 'Catalyst Advisory Services FZ-LLC. License number 47032659',
					),
					array(
						'key'           => 'field_catalyst_brand_text_ru',
						'label'         => 'Brand / license text (RU)',
						'name'          => 'brand_text_ru',
						'type'          => 'text',
						'default_value' => 'Catalyst Advisory Services FZ-LLC. Лицензия № 47032659',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-settings',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'        => 'group_catalyst_seo',
				'title'      => __( 'SEO (meta tags)', 'catalyst' ),
				'menu_order' => 5,
				'fields'     => array(
					array(
						'key'           => 'field_catalyst_seo_title',
						'label'         => 'Title (EN)',
						'name'          => 'seo_title',
						'type'          => 'text',
						'default_value' => 'UAE Visas, Residency & Company Setup in Dubai — Turnkey Legal Support | Catalyst Advisory',
					),
					array(
						'key'           => 'field_catalyst_seo_title_ru',
						'label'         => 'Title (RU)',
						'name'          => 'seo_title_ru',
						'type'          => 'text',
						'default_value' => 'Визы ОАЭ 2026, ВНЖ при покупке недвижимости и регистрация компании в Дубае | Catalyst Advisory',
					),
					array(
						'key'           => 'field_catalyst_seo_description',
						'label'         => 'Description (EN)',
						'name'          => 'seo_description',
						'type'          => 'textarea',
						'rows'          => 3,
						'new_lines'     => '',
						'default_value' => 'UAE visas for foreign nationals 2026, 10-year Golden Visa, UAE residency when buying property in Dubai. Company registration, licensing, opening a bank account in the UAE. 9% corporate tax — turnkey. Legal support in Dubai.',
					),
					array(
						'key'           => 'field_catalyst_seo_description_ru',
						'label'         => 'Description (RU)',
						'name'          => 'seo_description_ru',
						'type'          => 'textarea',
						'rows'          => 3,
						'new_lines'     => '',
						'default_value' => 'Визы ОАЭ для россиян 2026, Золотая виза на 10 лет, ВНЖ в Дубае при покупке недвижимости. Регистрация компании, лицензия, открытие счета в банке ОАЭ. Корпоративный налог 9% — под ключ. Юридическое сопровождение в Дубае.',
					),
					array(
						'key'           => 'field_catalyst_seo_keywords',
						'label'         => 'Keywords (EN)',
						'name'          => 'seo_keywords',
						'type'          => 'textarea',
						'rows'          => 2,
						'new_lines'     => '',
						'default_value' => 'Визы ОАЭ, Вид на жительство ОАЭ, Золотая виза ОАЭ, Виза инвестора ОАЭ, Открытие счета в ОАЭ, Юрист Дубай, Юридическая фирма Дубай, Учреждение компании ОАЭ, Лицензия на компанию в ОАЭ, выход на рынок ОАЭ',
					),
					array(
						'key'           => 'field_catalyst_seo_keywords_ru',
						'label'         => 'Keywords (RU)',
						'name'          => 'seo_keywords_ru',
						'type'          => 'textarea',
						'rows'          => 2,
						'new_lines'     => '',
						'default_value' => 'Визы ОАЭ, Вид на жительство ОАЭ, Золотая виза ОАЭ, Виза инвестора ОАЭ, Открытие счета в ОАЭ, Юрист Дубай, Юридическая фирма Дубай, Учреждение компании ОАЭ, Лицензия на компанию в ОАЭ, выход на рынок ОАЭ, виза ОАЭ для россиян 2026, Золотая виза ОАЭ на 10 лет, ВНЖ в Дубае при покупке недвижимости, регистрация компании ОАЭ, открытие счёта в банке ОАЭ, корпоративный налог ОАЭ 9%, налоговый учёт ОАЭ, покупка недвижимости ОАЭ для ВНЖ',
					),
					array(
						'key'           => 'field_catalyst_seo_robots',
						'label'         => 'Robots (EN)',
						'name'          => 'seo_robots',
						'type'          => 'text',
						'default_value' => 'index, follow',
						'instructions'  => 'e.g. "index, follow" or "noindex, nofollow"',
					),
					array(
						'key'           => 'field_catalyst_seo_robots_ru',
						'label'         => 'Robots (RU)',
						'name'          => 'seo_robots_ru',
						'type'          => 'text',
						'default_value' => 'index, follow',
					),
				),
				'location'   => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-settings',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'        => 'group_catalyst_work',
				'title'      => __( 'Who We Work With', 'catalyst' ),
				'menu_order' => 6,
				'fields'     => array(
					array(
						'key'           => 'field_catalyst_work_image_1',
						'label'         => 'Image card 1',
						'name'          => 'work_image_1',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'library'       => 'all',
						'instructions'  => 'Top-left image card. Falls back to the bundled image if empty.',
					),
					array(
						'key'           => 'field_catalyst_work_image_2',
						'label'         => 'Image card 2',
						'name'          => 'work_image_2',
						'type'          => 'image',
						'return_format' => 'array',
						'preview_size'  => 'medium',
						'library'       => 'all',
						'instructions'  => 'Second image card. Falls back to the bundled image if empty.',
					),
				),
				'location'   => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-settings',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'        => 'group_catalyst_whatwedo',
				'title'      => __( 'What We Do', 'catalyst' ),
				'menu_order' => 7,
				'fields'     => array(
					array(
						'key'          => 'field_catalyst_wwd_items',
						'label'        => 'Items',
						'name'         => 'what_we_do_items',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => __( 'Add item', 'catalyst' ),
						'instructions' => 'The section is built around 8 points matching the diagram — keep 8 rows, in order.',
						'sub_fields'   => array(
							array(
								'key'   => 'field_catalyst_wwd_title',
								'label' => 'Title (EN)',
								'name'  => 'title',
								'type'  => 'text',
							),
							array(
								'key'   => 'field_catalyst_wwd_title_ru',
								'label' => 'Title (RU)',
								'name'  => 'title_ru',
								'type'  => 'text',
							),
							array(
								'key'       => 'field_catalyst_wwd_desc',
								'label'     => 'Description (EN)',
								'name'      => 'description',
								'type'      => 'textarea',
								'rows'      => 3,
								'new_lines' => '',
							),
							array(
								'key'       => 'field_catalyst_wwd_desc_ru',
								'label'     => 'Description (RU)',
								'name'      => 'description_ru',
								'type'      => 'textarea',
								'rows'      => 3,
								'new_lines' => '',
							),
						),
					),
				),
				'location'   => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-settings',
						),
					),
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'        => 'group_catalyst_team',
				'title'      => __( 'Team members', 'catalyst' ),
				'menu_order' => 10,
				'fields'   => array(
					array(
						'key'          => 'field_catalyst_team_members',
						'label'        => 'Members',
						'name'         => 'team_members',
						'type'         => 'repeater',
						'layout'       => 'block',
						'button_label' => __( 'Add member', 'catalyst' ),
						'sub_fields'   => array(
							array(
								'key'           => 'field_catalyst_team_image',
								'label'         => 'Photo',
								'name'          => 'image',
								'type'          => 'image',
								'return_format' => 'array',
								'preview_size'  => 'medium',
								'library'       => 'all',
							),
							array(
								'key'   => 'field_catalyst_team_name',
								'label' => 'Name',
								'name'  => 'name',
								'type'  => 'text',
							),
							array(
								'key'   => 'field_catalyst_team_name_ru',
								'label' => 'Name (RU)',
								'name'  => 'name_ru',
								'type'  => 'text',
							),
							array(
								'key'   => 'field_catalyst_team_role',
								'label' => 'Position',
								'name'  => 'role',
								'type'  => 'text',
							),
							array(
								'key'   => 'field_catalyst_team_role_ru',
								'label' => 'Position (RU)',
								'name'  => 'role_ru',
								'type'  => 'text',
							),
							array(
								'key'          => 'field_catalyst_team_bio',
								'label'        => 'Bio (shown in the profile modal)',
								'name'         => 'bio',
								'type'         => 'wysiwyg',
								'tabs'         => 'visual',
								'media_upload' => 0,
							),
							array(
								'key'          => 'field_catalyst_team_bio_ru',
								'label'        => 'Bio RU (shown in the profile modal)',
								'name'         => 'bio_ru',
								'type'         => 'wysiwyg',
								'tabs'         => 'visual',
								'media_upload' => 0,
							),
						),
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'theme-settings',
						),
					),
				),
			)
		);

		// Per-page SEO meta for the SEO Page template.
		acf_add_local_field_group(
			array(
				'key'      => 'group_catalyst_seo_page',
				'title'    => __( 'SEO meta (this page)', 'catalyst' ),
				'fields'   => array(
					array(
						'key'   => 'field_catalyst_page_meta_title',
						'label' => 'Meta title',
						'name'  => 'meta_title',
						'type'  => 'text',
					),
					array(
						'key'       => 'field_catalyst_page_meta_description',
						'label'     => 'Meta description',
						'name'      => 'meta_description',
						'type'      => 'textarea',
						'rows'      => 3,
						'new_lines' => '',
					),
					array(
						'key'       => 'field_catalyst_page_meta_keywords',
						'label'     => 'Meta keywords',
						'name'      => 'meta_keywords',
						'type'      => 'textarea',
						'rows'      => 2,
						'new_lines' => '',
					),
					array(
						'key'           => 'field_catalyst_page_meta_robots',
						'label'         => 'Robots',
						'name'          => 'meta_robots',
						'type'          => 'text',
						'default_value' => 'index, follow',
						'instructions'  => 'e.g. "index, follow" or "noindex, nofollow"',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'page_template',
							'operator' => '==',
							'value'    => 'page-seo.php',
						),
					),
				),
			)
		);
	}
);
