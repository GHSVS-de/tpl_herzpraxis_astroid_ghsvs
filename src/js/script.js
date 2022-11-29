(function ($) {

	const html = document.documentElement;
	// Opera mini doesn't accept both classes in one remove().
	html.classList.remove('no-js');
	html.classList.remove('jsNotActive');
	html.classList.add('jsActive');

   // Functions
   var lastScrollTop = 0;
   var windowloaded = false;
   var initLastScrollTop = function () {
      var st = $(window).scrollTop();
      lastScrollTop = st;
   };
   var isScrollDown = function () {
      var st = $(window).scrollTop();
      return (st > lastScrollTop);
   };

   var initDisplay = function () {
      setTimeout(function () {
         $('.d-init').removeClass('d-none');
      }, 100);
   };

   var initHeader = function () {
      var stickyHeader = $('#astroid-sticky-header');

      var _header = $('header');
      if (!_header.length) {
         return false;
      }

      var _headerTop = _header.offset().top;
      var _headerHeight = _header.height();
      var _headerBottom = _headerTop + _headerHeight;

      if (!stickyHeader.length) {
         return;
      }

      var _winScroll = $(window).scrollTop();

      var _breakpoint = deviceBreakpoint(true);

      if (_breakpoint == 'xl' || _breakpoint == 'lg') {
         if (stickyHeader.hasClass('header-sticky-desktop') && (_winScroll > _headerBottom)) {
            stickyHeader.removeClass('d-none');
            stickyHeader.addClass('d-flex');
         } else if (stickyHeader.hasClass('header-stickyonscroll-desktop') && (_winScroll > _headerBottom) && !isScrollDown()) {
            stickyHeader.removeClass('d-none');
            stickyHeader.addClass('d-flex');
         } else {
            stickyHeader.removeClass('d-flex');
            stickyHeader.addClass('d-none');
         }
      } else if (_breakpoint == 'sm' || _breakpoint == 'md') {
         if (stickyHeader.hasClass('header-static-tablet')) {
            return;
         }
         if (stickyHeader.hasClass('header-sticky-tablet') && (_winScroll > _headerBottom)) {
            stickyHeader.removeClass('d-none');
            stickyHeader.addClass('d-flex');
         } else if (stickyHeader.hasClass('header-stickyonscroll-tablet') && (_winScroll > _headerBottom) && !isScrollDown()) {
            stickyHeader.addClass('d-flex');
            stickyHeader.removeClass('d-none');
         } else {
            stickyHeader.addClass('d-none');
            stickyHeader.removeClass('d-flex');
         }
      } else {
         if (stickyHeader.hasClass('header-static-mobile')) {
            return;
         }
         if (stickyHeader.hasClass('header-sticky-mobile') && (_winScroll > _headerBottom)) {
            stickyHeader.addClass('d-flex');
            stickyHeader.removeClass('d-none');
         } else if (stickyHeader.hasClass('header-stickyonscroll-mobile') && (_winScroll > _headerBottom) && !isScrollDown()) {
            stickyHeader.addClass('d-flex');
            stickyHeader.removeClass('d-none');
         } else {
            stickyHeader.addClass('d-none');
            stickyHeader.removeClass('d-flex');
         }
      }
   };

   var initEmptyHeaderContent = function () {
      $('.header-left-section:empty').each(function () {
         if (!$.trim($(this).html())) {
            $(this).prop('hidden', true);
         }
      });

      $('.header-center-section:empty').each(function () {
         if (!$.trim($(this).html())) {
            $(this).prop('hidden', true);
         }
      });

      $('.header-right-section:empty').each(function () {
         if (!$.trim($(this).html())) {
            $(this).prop('hidden', true);
         }
      });
   };

   var deviceBreakpoint = function (_return) {
      if ($('.astroid-breakpoints').length == 0) {
         var _breakpoints = '<div class="astroid-breakpoints d-none"><div class="d-block d-sm-none device-xs"></div><div class="d-none d-sm-block d-md-none device-sm"></div><div class="d-none d-md-block d-lg-none device-md"></div><div class="d-none d-lg-block d-xl-none device-lg"></div><div class="d-none d-xl-block device-xl"></div></div>';
         $('body').append(_breakpoints);
      }
      var _sizes = ['xs', 'sm', 'md', 'lg', 'xl'];
      var _device = 'undefined';
      _sizes.forEach(function (_size) {
         var _visiblity = $('.astroid-breakpoints .device-' + _size).css('display');
         if (_visiblity == 'block') {
            _device = _size;
            return false;
         }
      });
      if (_return) {
         return _device;
      } else {
         $('body').removeClass('astroid-device-xs').removeClass('astroid-device-sm').removeClass('astroid-device-md').removeClass('astroid-device-lg').removeClass('astroid-device-xl');
         $('body').addClass('astroid-device-' + _device);
      }
   };


   // Events
   var docReady = function () {
      initDisplay();
      //initMobileMenu();
      //initOffcanvasMenu();
      //initSidebarMenu();
      //initMegamenu();
      //initSubmenu();
      //initBackToTop();
      initHeader();
      initEmptyHeaderContent();
      //initTooltip();
      deviceBreakpoint(false);
   };

   var winLoad = function () {
      deviceBreakpoint(false);
      //initProgressBar();
      windowloaded = true;
   };

   var winResize = function () {
      deviceBreakpoint(false);
      initHeader();
   };

   var winScroll = function () {
      initHeader();
      initLastScrollTop();

      deviceBreakpoint(false);
   };

   $(docReady);
   $(window).on('load', winLoad);
   $(window).on('resize', winResize);
   $(window).on('scroll', winScroll);
   window.addEventListener("orientationchange", winResize);
})(jQuery);
