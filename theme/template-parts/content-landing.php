<?php
/**
 * Landing content, shared by the English front page and the "Landing RU"
 * template. Text is language-aware via catalyst_t().
 *
 * @package Catalyst
 */

$catalyst_team = catalyst_team_members();
?>

<main class="site-main">

<section class="hero" id="hero">
	<video class="hero__video" autoplay muted loop playsinline>
		<source src="<?php echo esc_url( catalyst_option_file_url( 'hero_video_mobile', 'assets/vid/hero-mob.mp4' ) ); ?>" media="(max-width: 570px)">
		<source src="<?php echo esc_url( catalyst_option_file_url( 'hero_video', 'assets/vid/hero.mp4' ) ); ?>">
	</video>

	<div class="hero__inner">

		<div></div>

		<nav class="hero__nav">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => catalyst_menu_location( 'hero' ),
					'container'      => false,
					'items_wrap'     => '%3$s',
					'walker'         => new Catalyst_Hero_Walker(),
					'fallback_cb'    => 'catalyst_hero_menu_fallback',
				)
			);
			?>
		</nav>

		<div class="hero__bottom">
			<h1 class="hero__title"><?php echo esc_html( catalyst_t( 'We Solve Complex Cases at the Intersection of Law, Tax and Compliance', 'Решаем сложные задачи на стыке права, налогообложения и комплаенса' ) ); ?></h1>
			<div class="hero__mobile-wrapper">
				<button class="hero__cta">
					<?php echo esc_html( catalyst_t( 'Request a Call', 'Запросить звонок' ) ); ?>
					<svg width="39" height="39" viewBox="0 0 39 39" fill="none" xmlns="http://www.w3.org/2000/svg">
						<circle cx="19.5" cy="19.5" r="19.5" fill="#FF5300"/>
						<path d="M23.0027 17.845L15.4716 25.0175L14.2344 23.8392L21.7646 16.6667H15.1278V15H24.7527V24.1667H23.0027V17.845Z" fill="white"/>
					</svg>
				</button>
				<div class="hero__text">
					<?php echo esc_html( catalyst_t( 'We are a boutique advisory firm focused on complex, cross-functional projects. Our expertise covers corporate law, international tax planning, sanctions compliance, and reputation management.', 'Мы - бутиковая консалтинговая фирма, сфокусированная на сложных, кросс-функциональных проектах. Наша экспертиза охватывает корпоративное право, международное налоговое планирование, санкционный комплаенс и управление репутацией. Мы работаем с клиентами, чьи ситуации требуют больше, чем стандартный подход - когда правовые, налоговые и репутационные вопросы нужно решать вместе, а не по отдельности.' ) ); ?>
				</div>
			</div>
		</div>

	</div>
</section>

<section class="about" id="about">

	<p class="about__lead" data-aos="fade-up" data-aos-duration="900"><?php echo esc_html( catalyst_t( 'We are a boutique advisory firm focused on complex, cross-functional projects. Our expertise covers corporate law, international tax planning, sanctions compliance, and reputation management.', 'Мы — бутиковая консалтинговая компания, специализирующаяся на сложных междисциплинарных проектах. Наша экспертиза охватывает корпоративное право, международное налоговое планирование, санкционный комплаенс и управление репутацией.' ) ); ?></p>

	<img class="about__img" data-aos="fade-up" data-aos-duration="900" src="<?php echo esc_url( get_theme_file_uri( 'assets/img/about-us-logo.png' ) ); ?>" alt="Catalyst">

	<div class="about__bottom" data-aos="fade-up" data-aos-duration="900">
		<span class="about__label"><?php echo esc_html( catalyst_t( '// About Catalyst Advisory Services', '// О Catalyst Advisory Services' ) ); ?></span>
		<div class="about__text">
			<p class="about__p"><?php echo esc_html( catalyst_t( "Our model is project-based: we don't just advise, we implement.", 'Наша модель - проектная: мы не просто консультируем, мы реализуем.' ) ); ?></p>
			<p class="about__p"><?php echo esc_html( catalyst_t( 'We act as your personal project manager, coordinating different workstreams and bringing in the right expertise at the right time.', 'Мы выступаем в роли вашего личного проектного менеджера, координируя различные направления работы и подключая нужную экспертизу в нужный момент.' ) ); ?></p>
		</div>
	</div>

</section>

<section class="work" id="work">

	<div class="work__header">
		<h2 class="work__title" data-aos="fade-up" data-aos-duration="900"><span class="work__title-accent">\\ <?php echo esc_html( catalyst_t( 'Who We', 'С кем мы' ) ); ?></span> <?php echo esc_html( catalyst_t( 'Work With', 'работаем' ) ); ?></h2>
	</div>

	<div class="work__grid" data-aos="fade-up" data-aos-duration="900">

		<!-- 01: image card -->
		<div class="work-card work-card--img" style="background-image: url('<?php echo esc_url( catalyst_option_image_url( 'work_image_1', 'assets/img/workwith-card-1.png' ) ); ?>')">
			<div class="work-card__head">
				<span class="work-card__num">[ 01</span>
				<svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M6.68066 2.276L0.942667 8.014L0 7.07133L5.73733 1.33333H0.680667V0H8.01399V7.33333H6.68066V2.276Z" fill="white" fill-opacity="0.4" />
				</svg>
			</div>
		</div>

		<!-- 02: text card -->
		<div class="work-card work-card--text work-card--text--first">
			<div class="work-card__top">
				<div class="work-card__head">
					<span class="work-card__num">[ 02</span>
					<svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M1.33301 5.73792L7.07101 -8.39233e-05L8.01367 0.942582L2.27634 6.68058L7.33301 6.68058V8.01392L-0.000322342 8.01392L-0.000322342 0.680583H1.33301L1.33301 5.73792Z" fill="white" fill-opacity="0.4"/>
					</svg>
				</div>
				<span class="work-card__desc"><?php echo esc_html( catalyst_t( 'Company setup, bank accounts, visas, legal and tax support - as one integrated process.', 'Регистрация компании, банковские счета, визы, юридическая и налоговая поддержка - как единый процесс.' ) ); ?></span>
			</div>
			<h3 class="work-card__title"><?php echo esc_html( catalyst_t( 'For Those Entering the UAE Market', 'Для тех, кто выходит на рынок ОАЭ' ) ); ?></h3>
		</div>

		<!-- plain: description (no border) -->
		<div class="work-card work-card--plain">
			<p class="work-card__info"><?php echo esc_html( catalyst_t( 'Our clients are entrepreneurs, private investors, family offices, and businesses operating across multiple jurisdictions.', 'Наши клиенты это предприниматели, частные инвесторы, семейные офисы и компании, работающие в нескольких юрисдикциях.' ) ); ?></p>
		</div>

		<!-- 03: text card -->
		<div class="work-card work-card--text work-card--text--second">
			<div class="work-card__top">
				<div class="work-card__head">
					<span class="work-card__num">[ 03</span>
					<svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M1.33301 5.73792L7.07101 -8.39233e-05L8.01367 0.942582L2.27634 6.68058L7.33301 6.68058V8.01392L-0.000322342 8.01392L-0.000322342 0.680583H1.33301L1.33301 5.73792Z" fill="white" fill-opacity="0.4"/>
					</svg>
				</div>
				<span class="work-card__desc"><?php echo esc_html( catalyst_t( 'Advising clients on responding to regulatory inquiries and adverse media findings. Supporting clients through enhanced due diligence processes and account review procedures.', 'Консультирование клиентов по ответам на запросы регуляторов и выявленным негативным публикациям. Сопровождение клиентов в процессах расширенной проверки и процедурах оценки профиля.' ) ); ?></span>
			</div>
			<h3 class="work-card__title"><?php echo esc_html( catalyst_t( 'For those Requiring Regulatory & Compliance Navigation', 'Для тех, кому нужна комплаенс-навигация' ) ); ?></h3>
		</div>

		<!-- plus card (no border) -->
		<div class="work-card work-card--plus">
			<span class="work-card__plus">+</span>
		</div>

		<!-- 04: image card -->
		<div class="work-card work-card--img" style="background-image: url('<?php echo esc_url( catalyst_option_image_url( 'work_image_2', 'assets/img/workwith-card-2.png' ) ); ?>')">
			<div class="work-card__head">
				<span class="work-card__num">[ 04</span>
				<svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M6.68066 2.276L0.942667 8.014L0 7.07133L5.73733 1.33333H0.680667V0H8.01399V7.33333H6.68066V2.276Z" fill="white" fill-opacity="0.4" />
				</svg>
			</div>
		</div>

		<!-- bottom-text card (no border) -->
		<div class="work-card work-card--bottom-text">
			<p class="work-card__bottom-info"><?php echo esc_html( catalyst_t( 'We understand that these situations are rarely simple,', 'Мы понимаем, что такие ситуации редко бывают простыми,' ) ); ?> <span class="work-card__info-accent"><?php echo esc_html( catalyst_t( 'and we know how to work with them.', 'и знаем, как с ними работать.' ) ); ?></span></p>
		</div>

		<!-- 05: text card -->
		<div class="work-card work-card--text work-card--text--third">
			<div class="work-card__top">
				<div class="work-card__head">
					<span class="work-card__num">[ 05</span>
					<svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M1.33301 5.73792L7.07101 -8.39233e-05L8.01367 0.942582L2.27634 6.68058L7.33301 6.68058V8.01392L-0.000322342 8.01392L-0.000322342 0.680583H1.33301L1.33301 5.73792Z" fill="white" fill-opacity="0.4"/>
					</svg>
				</div>
				<span class="work-card__desc"><?php echo esc_html( catalyst_t( 'Corporate restructuring, ownership planning, tax strategy, asset protection across jurisdictions.', 'Корпоративная реструктуризация, планирование структуры владения, налоговая стратегия и защита активов в разных юрисдикциях.' ) ); ?></span>
			</div>
			<h3 class="work-card__title"><?php echo esc_html( catalyst_t( 'For Those Restructuring Their Business or Assets', 'Для тех, кто реструктурирует бизнес или активы' ) ); ?></h3>
		</div>

		<!-- CTA button card (no border) -->
		<div class="work-card work-card--cta">
			<button class="work-card__btn">
				<?php echo esc_html( catalyst_t( 'Request a Call', 'Запросить звонок' ) ); ?>
				<svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M8.76837 2.98725L1.23725 10.5184L0 9.28113L7.53024 1.75H0.893375V0H10.5184V9.625H8.76837V2.98725Z" fill="white" />
				</svg>
			</button>
		</div>

	</div>

</section>

<section class="what-we-do" id="what-we-do">

	<h2 class="what-we-do__title" data-aos="fade-up" data-aos-duration="900"><span class="what-we-do__accent">\\ <?php echo esc_html( catalyst_t( 'What', 'Чем мы' ) ); ?></span> <?php echo esc_html( catalyst_t( 'We Do', 'занимаемся' ) ); ?></h2>

	<div class="scene" id="scene">
		<svg width="1311" height="1311" viewBox="0 0 1311 1311" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M242.891 242.891C309.139 176.644 415.209 162.373 533.505 193.336C651.761 224.288 781.928 300.389 895.904 414.365C1009.88 528.341 1085.98 658.508 1116.93 776.764C1147.9 895.06 1133.63 1001.13 1067.38 1067.38C1001.13 1133.63 895.06 1147.9 776.764 1116.93C658.508 1085.98 528.341 1009.88 414.365 895.904C300.389 781.928 224.288 651.761 193.336 533.505C162.373 415.209 176.644 309.139 242.891 242.891Z" stroke="url(#paint1_radial_2015_17)" stroke-width="3"/>
			<path d="M1067.38 242.891C1133.62 309.139 1147.9 415.209 1116.93 533.505C1085.98 651.761 1009.88 781.928 895.904 895.904C781.928 1009.88 651.761 1085.98 533.505 1116.93C415.208 1147.9 309.138 1133.63 242.891 1067.38C176.643 1001.13 162.373 895.06 193.335 776.764C224.287 658.508 300.388 528.341 414.364 414.365C528.34 300.389 658.507 224.288 776.763 193.336C895.06 162.373 1001.13 176.644 1067.38 242.891Z" stroke="url(#paint2_radial_2015_17)" stroke-width="3"/>
			<circle cx="655.135" cy="655.635" r="436" fill="url(#paint0_radial_2015_17)"/>
			<path d="M655.135 72.1348C748.823 72.1348 833.917 137.047 895.671 242.589C957.404 348.095 995.635 493.948 995.635 655.135C995.635 816.321 957.404 962.175 895.671 1067.68C833.917 1173.22 748.823 1238.13 655.135 1238.13C561.447 1238.13 476.353 1173.22 414.599 1067.68C352.866 962.175 314.635 816.321 314.635 655.135C314.635 493.948 352.866 348.095 414.599 242.589C476.353 137.047 561.447 72.1348 655.135 72.1348Z" stroke="url(#paint3_radial_2015_17)" stroke-width="3"/>
			<path d="M72.1348 655.135C72.1348 561.447 137.047 476.353 242.589 414.599C348.095 352.866 493.948 314.635 655.135 314.635C816.321 314.635 962.175 352.866 1067.68 414.599C1173.22 476.353 1238.13 561.447 1238.13 655.135C1238.13 748.823 1173.22 833.917 1067.68 895.671C962.175 957.404 816.321 995.635 655.135 995.635C493.948 995.635 348.095 957.404 242.589 895.671C137.047 833.917 72.1348 748.823 72.1348 655.135Z" stroke="url(#paint4_radial_2015_17)" stroke-width="3"/>
			<g class="btn-dot" data-i="0"><circle cx="654.635" cy="70.1348" r="22.5" fill="#FF5300"/><path d="M653.611 77.6348V71.4468H647.507V69.7948H653.611V63.6068H655.459V69.7948H661.563V71.4468H655.459V77.6348H653.611Z" fill="white"/></g>
			<g class="btn-dot" data-i="1"><circle cx="1239.63" cy="655.135" r="22.5" fill="#FF5300"/><path d="M1238.61 662.635V656.447H1232.51V654.795H1238.61V648.607H1240.46V654.795H1246.56V656.447H1240.46V662.635H1238.61Z" fill="white"/></g>
			<g class="btn-dot" data-i="2"><circle cx="70.6348" cy="655.135" r="22.5" fill="#FF5300"/><path d="M69.6108 662.635V656.447H63.5068V654.795H69.6108V648.607H71.4588V654.795H77.5628V656.447H71.4588V662.635H69.6108Z" fill="white"/></g>
			<g class="btn-dot" data-i="3"><circle cx="654.635" cy="1239.13" r="22.5" fill="#FF5300"/><path d="M653.611 1246.63V1240.45H647.507V1238.79H653.611V1232.61H655.459V1238.79H661.563V1240.45H655.459V1246.63H653.611Z" fill="white"/></g>
			<g class="btn-dot" data-i="4"><circle cx="228.635" cy="1048.13" r="22.5" fill="#FF5300"/><path d="M227.611 1055.63V1049.45H221.507V1047.79H227.611V1041.61H229.459V1047.79H235.563V1049.45H229.459V1055.63H227.611Z" fill="white"/></g>
			<g class="btn-dot" data-i="5"><circle cx="1081.63" cy="262.135" r="22.5" fill="#FF5300"/><path d="M1080.61 269.635V263.447H1074.51V261.795H1080.61V255.607H1082.46V261.795H1088.56V263.447H1082.46V269.635H1080.61Z" fill="white"/></g>
			<g class="btn-dot" data-i="6"><circle cx="1081.63" cy="1048.13" r="22.5" fill="#FF5300"/><path d="M1080.61 1055.63V1049.45H1074.51V1047.79H1080.61V1041.61H1082.46V1047.79H1088.56V1049.45H1082.46V1055.63H1080.61Z" fill="white"/></g>
			<g class="btn-dot" data-i="7"><circle cx="228.635" cy="262.135" r="22.5" fill="#FF5300"/><path d="M227.611 269.635V263.447H221.507V261.795H227.611V255.607H229.459V261.795H235.563V263.447H229.459V269.635H227.611Z" fill="white"/></g>
			<defs>
				<radialGradient id="paint0_radial_2015_17" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(459.635 326.135) rotate(61.4528) scale(795.174)"><stop stop-color="#FFA102"/><stop offset="0.441598" stop-color="#FE1D04"/><stop offset="0.672216" stop-color="#D31803"/><stop offset="1"/></radialGradient>
				<radialGradient id="paint1_radial_2015_17" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(655.488 655.488) rotate(45) scale(584 479.619)"><stop stop-color="white"/><stop offset="1" stop-color="white" stop-opacity="0.05"/></radialGradient>
				<radialGradient id="paint2_radial_2015_17" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(654.78 655.488) rotate(135) scale(584 479.619)"><stop stop-color="white"/><stop offset="1" stop-color="white" stop-opacity="0.05"/></radialGradient>
				<radialGradient id="paint3_radial_2015_17" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(655.135 655.635) rotate(90) scale(584 479.619)"><stop stop-color="white"/><stop offset="1" stop-color="white" stop-opacity="0.05"/></radialGradient>
				<radialGradient id="paint4_radial_2015_17" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(655.635 655.135) scale(584 479.619)"><stop stop-color="white"/><stop offset="1" stop-color="white" stop-opacity="0.05"/></radialGradient>
			</defs>
		</svg>
	</div>

	<div class="what-we-do__label-panel">
		<?php foreach ( catalyst_whatwedo_items() as $catalyst_i => $catalyst_wwd ) : ?>
			<div class="info-label" data-i="<?php echo (int) $catalyst_i; ?>">
				<h3><?php echo esc_html( $catalyst_wwd['title'] ); ?></h3>
				<p><?php echo esc_html( $catalyst_wwd['desc'] ); ?></p>
			</div>
		<?php endforeach; ?>
	</div>

</section>

<section class="team" id="team">

	<div class="team__header" data-aos="fade-up" data-aos-duration="900">
		<h2 class="team__title"><span class="team__title-light"><?php echo esc_html( catalyst_t( "Who You'll", 'С кем вы будете' ) ); ?></span> <?php echo esc_html( catalyst_t( 'Work With', 'работать' ) ); ?></h2>
		<div class="team__arrows">
			<button class="team__arrow team__arrow--prev" aria-label="<?php echo esc_attr( catalyst_t( 'Previous', 'Предыдущий сотрудник' ) ); ?>">
				<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M3.34963 7.68064L14.0002 7.68065L14.0002 5.93091L3.35025 5.93029L8.04323 1.23731L6.80579 -0.0001244L-0.000109048 6.80577L6.80579 13.6117L8.04323 12.3742L3.34963 7.68064Z" fill="white"/>
				</svg>
			</button>
			<button class="team__arrow team__arrow--next" aria-label="<?php echo esc_attr( catalyst_t( 'Next', 'Следующий сотрудник' ) ); ?>">
				<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg" style="transform: rotate(180deg)">
					<path d="M3.34963 7.68064L14.0002 7.68065L14.0002 5.93091L3.35025 5.93029L8.04323 1.23731L6.80579 -0.0001244L-0.000109048 6.80577L6.80579 13.6117L8.04323 12.3742L3.34963 7.68064Z" fill="white"/>
				</svg>
			</button>
		</div>
	</div>

	<div class="swiper team__swiper" data-aos="fade-up" data-aos-duration="900">
		<div class="swiper-wrapper">
			<?php
			foreach ( $catalyst_team as $i => $member ) :
				$profile_id = 'team-profile-' . ( $i + 1 );
				?>
				<div class="swiper-slide team-card">
					<div class="team-card__img-wrap">
						<img class="team-card__img" src="<?php echo esc_url( $member['image'] ); ?>" alt="<?php echo esc_attr( $member['alt'] ? $member['alt'] : $member['name'] ); ?>">
						<button class="team-card__profile-btn" type="button" data-profile="<?php echo esc_attr( $profile_id ); ?>" aria-haspopup="dialog" aria-controls="team-profile-modal">
							<?php echo esc_html( catalyst_t( 'View profile', 'Подробнее' ) ); ?>
							<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M10.0055 3.40871L1.41181 12.0024L0 10.5906L8.59265 1.9969H1.01942V0H12.0024V10.9829H10.0055V3.40871Z" fill="white" />
							</svg>
						</button>
					</div>
					<div class="team-card__info">
						<span class="team-card__name"><?php echo esc_html( $member['name'] ); ?></span>
						<span class="team-card__role"><?php echo esc_html( $member['role'] ); ?></span>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

</section>

<section class="cta" id="contacts">
	<video class="cta__video" src="<?php echo esc_url( get_theme_file_uri( 'assets/vid/cta.mp4' ) ); ?>" autoplay muted loop playsinline></video>

	<div class="cta__inner">

		<h2 class="cta__title" data-aos="fade-up" data-aos-duration="900"><?php echo esc_html( catalyst_t( 'Reaction Starts Here', 'Реакция начинается здесь' ) ); ?></h2>

		<div class="cta__middle" data-aos="fade-up" data-aos-duration="900">
			<div class="cta__divider" data-aos="fade-right" data-aos-duration="900">
				<span class="cta__divider-rect"></span>
			</div>
			<span class="cta__discover"><?php echo esc_html( catalyst_t( 'Discover more', 'Узнать больше' ) ); ?></span>
			<svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
				<g clip-path="url(#clip0_192_184)">
					<path d="M25 12.5C25 5.60762 19.3924 8.47668e-07 12.5 5.46392e-07C5.60762 2.45116e-07 1.66223e-06 5.60762 1.36096e-06 12.5C1.05968e-06 19.3924 5.60762 25 12.5 25C19.3924 25 25 19.3924 25 12.5ZM1.5625 12.5C1.5625 6.46895 6.46895 1.5625 12.5 1.5625C18.5311 1.5625 23.4375 6.46895 23.4375 12.5C23.4375 18.5311 18.5311 23.4375 12.5 23.4375C6.46895 23.4375 1.5625 18.5311 1.5625 12.5ZM13.0523 17.7398C12.7471 18.0451 12.2527 18.0451 11.9477 17.7398L8.04141 13.8336C7.88887 13.6811 7.8125 13.4811 7.8125 13.2813C7.8125 13.0814 7.88887 12.8814 8.04141 12.7289C8.34668 12.4236 8.84102 12.4236 9.14609 12.7289L11.7188 15.3016L11.7188 7.8125C11.7188 7.38106 12.0682 7.03125 12.5 7.03125C12.9318 7.03125 13.2813 7.38106 13.2813 7.8125L13.2813 15.3016L15.8539 12.7289C16.1592 12.4236 16.6535 12.4236 16.9586 12.7289C17.2637 13.0342 17.2639 13.5285 16.9586 13.8336L13.0523 17.7398Z" fill="white"/>
				</g>
				<defs><clipPath id="clip0_192_184"><rect width="25" height="25" fill="white" transform="translate(25 1.09278e-06) rotate(90)"/></clipPath></defs>
			</svg>
		</div>

		<div class="cta__bottom" data-aos="fade-up" data-aos-duration="900">
			<p class="cta__text"><?php echo esc_html( catalyst_t( 'We deliver corporate services for entity setup, maintenance, and regulatory support — with precise, senior-led guidance at every stage.', 'Мы оказываем корпоративные услуги по регистрации и сопровождению компаний, а также взаимодействию с регуляторами — на каждом этапе вы получаете точные рекомендации опытных специалистов.' ) ); ?></p>
			<button class="cta__btn hero__cta">
				<?php echo esc_html( catalyst_t( 'Request an Introduction', 'Запросить консультацию' ) ); ?>
				<svg width="39" height="39" viewBox="0 0 39 39" fill="none" xmlns="http://www.w3.org/2000/svg">
					<circle cx="19.5" cy="19.5" r="19.5" fill="#FF5300"/>
					<path d="M23.0027 17.845L15.4716 25.0175L14.2344 23.8392L21.7646 16.6667H15.1278V15H24.7527V24.1667H23.0027V17.845Z" fill="white"/>
				</svg>
			</button>
		</div>

	</div>
</section>

<!-- Team Profile Modals -->
<div class="team-profile-overlay" id="team-profile-modal" aria-hidden="true">
	<?php
	foreach ( $catalyst_team as $i => $member ) :
		$profile_id = 'team-profile-' . ( $i + 1 );
		?>
		<div class="team-profile-modal" data-profile-modal="<?php echo esc_attr( $profile_id ); ?>" role="dialog" aria-modal="true" aria-labelledby="<?php echo esc_attr( $profile_id ); ?>-name" hidden>
			<button class="team-profile-modal__close" type="button" aria-label="<?php echo esc_attr( catalyst_t( 'Close profile', 'Закрыть профиль' ) ); ?>">
				<svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M1.26013 15C0.937327 15 0.614525 14.8775 0.369269 14.6304C-0.12309 14.1381 -0.12309 13.3399 0.369269 12.8475L12.8475 0.369261C13.3401 -0.123087 14.1384 -0.123087 14.6307 0.369261C15.1231 0.861609 15.1231 1.65983 14.6307 2.15248L2.15222 14.6304C1.90358 14.8775 1.58109 15 1.26013 15Z" fill="white" />
					<path d="M13.7381 15C13.4156 15 13.0928 14.8775 12.8476 14.6304L0.369496 2.15264C-0.123165 1.66024 -0.123165 0.861933 0.369496 0.369532C0.861849 -0.123177 1.66008 -0.123177 2.15243 0.369532L14.6305 12.8488C15.1232 13.3412 15.1232 14.1395 14.6305 14.6319C14.3837 14.8775 14.0609 15 13.7381 15Z" fill="white" />
				</svg>
			</button>
			<span class="team-profile-modal__role"><?php echo esc_html( $member['role'] ); ?></span>
			<span class="team-profile-modal__name" id="<?php echo esc_attr( $profile_id ); ?>-name"><?php echo esc_html( $member['name'] ); ?></span>
			<div class="team-profile-modal__text">
				<?php echo wp_kses_post( $member['bio'] ); ?>
			</div>
		</div>
	<?php endforeach; ?>
</div>

</main>
