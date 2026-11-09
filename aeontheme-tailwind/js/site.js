jQuery(function ($) {
  'use strict';

  /* -- 01 Header scroll state --------------------------------------------- */
  var $header = $('.js-site-header');
  function syncHeader() {
    $header.toggleClass('is-scrolled', $(window).scrollTop() > 40);
  }
  if ($header.length) {
    syncHeader();
    $(window).on('scroll', syncHeader);
  }

  /* -- 02 Desktop dropdowns + mega panel ---------------------------------
     Hover for pointer users, click/Enter for keyboard users. The header gets
     is-menu-open so its chrome switches to the solid treatment. */
  var $megaTrigger = $('.js-mega-trigger');
  var $mega = $('.js-mega-panel');

  function closeAllMenus() {
    $('.js-has-dropdown').removeClass('is-open').children('a').attr('aria-expanded', 'false');
    $mega.removeClass('is-open').attr('inert', '');
    $megaTrigger.attr('aria-expanded', 'false');
    $header.removeClass('is-menu-open');
  }

  function openDropdown($item) {
    closeAllMenus();
    $item.add($item.parents('.js-has-dropdown')).addClass('is-open').children('a').attr('aria-expanded', 'true');
    $header.addClass('is-menu-open');
  }

  $('.js-has-dropdown').on('mouseenter focusin', function (event) {
    event.stopPropagation();
    openDropdown($(this));
  });

  $('.js-site-header').on('mouseleave', closeAllMenus);

  $('.js-has-dropdown > a').on('click', function (e) {
    // Keyboard / touch: first activation opens the menu instead of navigating.
    var $item = $(this).closest('.js-has-dropdown');
    if (!$item.hasClass('is-open')) {
      e.preventDefault();
      openDropdown($item);
    }
  });

  $megaTrigger.on('mouseenter focus', function () {
    closeAllMenus();
    $mega.addClass('is-open').removeAttr('inert');
    $(this).attr('aria-expanded', 'true');
    $header.addClass('is-menu-open');
  }).on('click', function (e) {
    if (!$mega.hasClass('is-open')) {
      e.preventDefault();
      $mega.addClass('is-open').removeAttr('inert');
      $(this).attr('aria-expanded', 'true');
      $header.addClass('is-menu-open');
    }
  });

  var $megaRailItems = $('.js-mega-rail-item');
  var $megaPanes = $('.nav-mega__pane');

  $megaRailItems.on('mouseenter focus click', function () {
    var $item = $(this);
    var target = $item.data('mega-target');
    $megaRailItems.removeClass('is-active').attr('aria-pressed', 'false');
    $item.addClass('is-active').attr('aria-pressed', 'true');
    $megaPanes.removeClass('is-active');
    $megaPanes.filter('[data-mega-pane="' + target + '"]').addClass('is-active');
  });

  $(document).on('keydown', function (e) {
    if (e.key === 'Escape') {
      closeAllMenus();
      closeMobileNav();
      closeModal();
      closeLightbox();
    }
    if (e.key === 'Tab') {
      var dialog = document.querySelector('.js-aeon-modal.is-open [role="dialog"], .js-lightbox.is-open [role="dialog"], .js-mobile-nav.is-open [role="dialog"]');
      if (!dialog) { return; }
      var focusable = $(dialog).find('a[href], button, input, select, textarea, [tabindex]')
        .filter(':visible').not(':disabled, [tabindex="-1"]');
      var boundary = e.shiftKey ? focusable.first() : focusable.last();
      if (document.activeElement === boundary[0] || !dialog.contains(document.activeElement)) {
        e.preventDefault();
        (e.shiftKey ? focusable.last() : focusable.first()).trigger('focus');
      }
    }
  });

  /* -- 03 Mobile navigation ----------------------------------------------- */
  var $mobileNav = $('.js-mobile-nav');

  function openMobileNav() {
    $mobileNav.addClass('is-open').attr('aria-hidden', 'false');
    $('.js-mobile-toggle').attr('aria-expanded', 'true');
    $('body').addClass('has-modal-open');
    $mobileNav.find('.js-mobile-close').trigger('focus');
  }
  function closeMobileNav() {
    if (!$mobileNav.hasClass('is-open')) { return; }
    $mobileNav.removeClass('is-open').attr('aria-hidden', 'true');
    $('.js-mobile-toggle').attr('aria-expanded', 'false').trigger('focus');
    $('body').removeClass('has-modal-open');
  }
  $('.js-mobile-toggle').on('click', openMobileNav);
  $('.js-mobile-close, .js-mobile-scrim').on('click', closeMobileNav);

  // Accordion inside the mobile panel
  $('.js-mobile-sub-toggle').on('click', function () {
    var $item = $(this).closest('.mobile-nav__item');
    var open = $item.hasClass('is-open');
    $item.toggleClass('is-open', !open);
    $(this).attr('aria-expanded', open ? 'false' : 'true');
  });

  /* -- 04 Carousels ------------------------------------------------------
     Scroll-snap track nudged by two cards per click. Arrows disable at the
     ends. No library — the track is a plain overflow-x element. */
  $('.js-carousel').each(function () {
    var $root = $(this);
    var $track = $root.find('.js-carousel-track');
    var $prev = $root.find('.js-carousel-prev');
    var $next = $root.find('.js-carousel-next');
    if (!$track.length) { return; }

    function step() {
      var $card = $track.find('.build-row__cell').first();
      return ($card.outerWidth() || 300) + 16;
    }
    function sync() {
      var el = $track[0];
      $prev.prop('disabled', el.scrollLeft <= 2);
      $next.prop('disabled', el.scrollLeft + el.clientWidth >= el.scrollWidth - 2);
    }
    $prev.on('click', function () { $track[0].scrollBy({ left: -step() * 2, behavior: 'smooth' }); });
    $next.on('click', function () { $track[0].scrollBy({ left: step() * 2, behavior: 'smooth' }); });
    $track.on('scroll', sync);
    $(window).on('resize', sync);
    sync();
  });

  /* -- 05 Tabs ------------------------------------------------------------ */
  $('.js-tabs').each(function () {
    var $root = $(this);
    var $tabs = $root.find('.js-tab');

    function activate($tab) {
      var target = $tab.attr('data-tab-target');
      $tabs.attr('aria-selected', 'false').attr('tabindex', '-1');
      $tab.attr('aria-selected', 'true').attr('tabindex', '0');
      $root.find('.js-tab-panel').attr('hidden', true);
      $root.find('.js-tab-panel').filter(function () { return this.id === target; }).removeAttr('hidden');
    }
    $tabs.on('click', function () { activate($(this)); });
    $tabs.on('keydown', function (e) {
      var i = $tabs.index(this);
      if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
        e.preventDefault();
        $tabs.eq((i + 1) % $tabs.length).trigger('focus').trigger('click');
      } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
        e.preventDefault();
        $tabs.eq((i - 1 + $tabs.length) % $tabs.length).trigger('focus').trigger('click');
      }
    });
  });

  /* -- 06 Disclosures -----------------------------------------------------
     One pattern for the SEO read-more and both link directories: a button
     with aria-expanded + aria-controls, and a panel whose max-height is set
     from its real scrollHeight so the transition never clips. */
  $('.js-disclosure').on('click', function () {
    var $btn = $(this);
    var panel = document.getElementById($btn.attr('aria-controls'));
    if (!panel) { return; }
    var $panel = $(panel);
    var open = $btn.attr('aria-expanded') === 'true';
    $btn.attr('aria-expanded', open ? 'false' : 'true');
    panel.toggleAttribute('inert', open);
    $panel.toggleClass('is-open', !open);
    if (!open) {
      $panel.css('--aeon-reveal-h', panel.scrollHeight + 'px');
      $panel.one('transitionend', function () {
        if ($panel.hasClass('is-open')) { $panel.css('--aeon-reveal-h', 'none'); }
      });
    }
    var label = $btn.attr(open ? 'data-label-closed' : 'data-label-open');
    if (label) { $btn.find('.js-disclosure-label').text(label); }
  });

  /* The form plugin owns submission and validation. */
  var $activeModal = $();
  var $modalTrigger = $();

  function closeModal() {
    if (!$activeModal.length) { return; }
    $activeModal.removeClass('is-open').attr('aria-hidden', 'true');
    $('body').removeClass('has-modal-open');
    $activeModal = $();
    $modalTrigger.trigger('focus');
  }

  $(document).on('click', '.js-aeon-modal-open', function () {
    var $trigger = $(this);
    var modal = document.getElementById($trigger.attr('aria-controls'));
    if (!modal) { return; }

    $modalTrigger = $trigger;
    if ($mobileNav.hasClass('is-open')) {
      closeMobileNav();
      $modalTrigger = $('.js-mobile-toggle');
    }

    $activeModal = $(modal).addClass('is-open').attr('aria-hidden', 'false');
    $('body').addClass('has-modal-open');
    $activeModal.find('.js-quote-context, .financing-quote-context').val($trigger.attr('data-quote-context') || '');
    $activeModal.find('[id="quote-product"], [name="quote-product"]').val($trigger.attr('data-product') || '');
    var $field = $activeModal.find('input, select, textarea').filter(':visible').not(':disabled').first();
    ($field.length ? $field : $activeModal.find('button').first()).trigger('focus');
  });
  $(document).on('click', '.js-aeon-modal-close', closeModal);

  /* -- 08 Audience toggle (contact form) ---------------------------------- */
  $('.js-audience-toggle').on('click', function () {
    var $btn = $(this);
    $btn.closest('.contact-form__toggle').find('.js-audience-toggle').removeClass('is-active').attr('aria-pressed', 'false');
    $btn.addClass('is-active').attr('aria-pressed', 'true');
    $btn.closest('form').find('.js-audience-value').val($btn.attr('data-audience'));
  });

  /* ── 09 Filter chips + sub-tags (blog index, build gallery) ──────────── */
  $('.js-filter').each(function () {
    var $scope = $(this);
    var noun = $scope.data('filter-count') || 'item';
    var $items = $scope.find('.js-filter-item');
    var $count = $scope.find('.js-filter-count');

    function apply(group, tag) {
      var shown = 0;
      $items.each(function () {
        var $i = $(this);
        var ok = (group === '' || $i.attr('data-group') === group) && (!tag || $i.attr('data-tag') === tag);
        $i.prop('hidden', !ok);
        if (ok) { shown++; }
      });
      $count.text(shown + ' ' + noun + (shown === 1 ? '' : 's'));
      $scope.find('.js-subtags').each(function () {
        $(this).prop('hidden', $(this).attr('data-group') !== group);
      });
      $scope.find('.js-filter-btn').each(function () {
        var on = !tag && $(this).attr('data-group') === group;
        $(this).toggleClass('is-active', on).attr('aria-pressed', on);
      });
      $scope.find('.js-subtag-btn').each(function () {
        $(this).toggleClass('is-active', !!tag && $(this).attr('data-tag') === tag);
      });
    }

    $scope.on('click', '.js-filter-btn', function () {
      apply($(this).attr('data-group'), null);
    });

    $scope.on('click', '.js-subtag-btn', function () {
      var $b = $(this);
      if ($b.hasClass('is-active')) { apply($b.attr('data-group'), null); }
      else { apply($b.attr('data-group'), $b.attr('data-tag')); }
    });

    apply('', null);
  });

  /* ── 10 Lightbox (build gallery) ─────────────────────────────────────── */
  var $lightbox = $();
  var $lbTrigger = null;

  function closeLightbox() {
    if (!$lightbox.hasClass('is-open')) { return; }
    $lightbox.removeClass('is-open').attr('aria-hidden', 'true');
    $('body').removeClass('has-modal-open');
    if ($lbTrigger) { $lbTrigger.trigger('focus'); $lbTrigger = null; }
  }

  $(document).on('click', '.js-lightbox-open', function () {
    var $b = $(this);
    var lightbox = document.getElementById($b.attr('aria-controls'));
    if (!lightbox) { return; }
    $lightbox = $(lightbox);
    $lbTrigger = $b;
    var $image = $('<img>', {
      'class': 'lightbox__img',
      src: $b.attr('data-image'),
      alt: $b.attr('data-title')
    });
    $lightbox.find('.js-lightbox-media').empty().append($image);
    $lightbox.find('.js-lightbox-title').text($b.attr('data-title'));
    $lightbox.find('.js-lightbox-meta').text($b.attr('data-meta'));
    $lightbox.addClass('is-open').attr('aria-hidden', 'false');
    $('body').addClass('has-modal-open');
    $lightbox.find('.lightbox__close').trigger('focus');
  });

  $(document).on('click', '.js-lightbox-close', closeLightbox);

  /* Match navigation links to the current address, including its fragment. */
  function matchesCurrentUrl(href, current) {
    // A placeholder link (empty or "#", e.g. a model that doesn't have its
    // real page yet) resolves to the current document's own URL, which would
    // otherwise make it falsely "match" the current page — highlighting
    // every placeholder link at once instead of none of them.
    if (!href || href === '#') { return false; }
    var a = document.createElement('a');
    a.href = href;
    return a.origin === window.location.origin && (a.pathname.replace(/\/$/, '') + a.search + a.hash) === current;
  }

  function syncMegaMenuActiveState() {
    var current = window.location.pathname.replace(/\/$/, '') + window.location.search + window.location.hash;
    $('.nav-mega__link, .js-mega-rail-item, .nav-mega__pane-group-title, .site-nav__dropdown-link, .js-has-dropdown > .site-nav__link').removeClass('is-current');

    $('.nav-mega__link').each(function () {
      var $link = $(this);
      if (matchesCurrentUrl($link.attr('href'), current)) { $link.addClass('is-current'); }
    });

    // Rail items and pane group titles live in separate DOM subtrees now (rail
    // on the left, pane on the right), so "does this group have the current
    // link" is matched through data-mega-target/data-mega-pane instead of
    // .closest() — a plain ancestor lookup can't cross that gap.
    $('.js-mega-rail-item').each(function () {
      var $rail = $(this);
      var $pane = $('.nav-mega__pane[data-mega-pane="' + $rail.data('mega-target') + '"]');
      var hasCurrentChild = $pane.find('.nav-mega__link.is-current').length > 0;
      if (matchesCurrentUrl($rail.attr('href'), current) || hasCurrentChild) { $rail.addClass('is-current'); }
    });

    $('.nav-mega__pane-group-title').each(function () {
      var $title = $(this);
      var hasCurrentChild = $title.closest('.nav-mega__pane-group').find('.nav-mega__link.is-current').length > 0;
      if (matchesCurrentUrl($title.attr('href'), current) || hasCurrentChild) { $title.addClass('is-current'); }
    });

    $('.site-nav__dropdown-link').each(function () {
      var $link = $(this);
      if (matchesCurrentUrl($link.attr('href'), current)) { $link.addClass('is-current'); }
    });

    $('.js-has-dropdown').each(function () {
      var $trigger = $(this).find('> .site-nav__link');
      var hasCurrentChild = $(this).find('.site-nav__dropdown-link.is-current').length > 0;
      if (matchesCurrentUrl($trigger.attr('href'), current) || hasCurrentChild) { $trigger.addClass('is-current'); }
    });
  }
  if ($('.nav-mega__link, .site-nav__dropdown-link').length) {
    syncMegaMenuActiveState();
    $(window).on('hashchange', syncMegaMenuActiveState);
  }
});
