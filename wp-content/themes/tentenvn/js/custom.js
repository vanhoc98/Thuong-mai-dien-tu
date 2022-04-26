
jQuery(document).ready(function(){

				// SCROLL TO DIV
				jQuery(window).scroll(function(){
					if(jQuery(this).scrollTop()>500){
						jQuery('.scrolltop').addClass('go_scrolltop');
					}
					else{
						jQuery('.scrolltop').removeClass('go_scrolltop');
					}
				});
				jQuery('.scrolltop').click(function (){
					jQuery('html, body').animate({
						scrollTop: jQuery("html").offset().top
					}, 1000);
				}); 
			// SLIDE
			jQuery('.woocommerce-product-gallery ul').slick({
				dots: true,
				infinite: true,
				speed: 300,
				slidesToShow: 3,
				slidesToScroll: 1,
				autoplay: true,
				dots: false,
				autoplaySpeed: 2000,
					// fade: true,
					cssEase: 'linear',
					responsive: [
					{
						breakpoint: 1024,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 1,
							infinite: false,
							dots: false
						}
					},
					{
						breakpoint: 600,
						settings: {
							slidesToShow: 3,
							slidesToScroll: 1
						}
					},
					{
						breakpoint: 480,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 1
						}
					}
					]
				});
		// STICKY NAVBAR
		var sticky = document.querySelector('.sticky');

		if (sticky.style.position !== 'sticky') {
			var stickyTop = sticky.offsetTop;

			document.addEventListener('scroll', function () {
				window.scrollY >= stickyTop ?
				sticky.classList.add('fixed_menu') :
				sticky.classList.remove('fixed_menu');
			});
		}

		// MENU MOBILE
		jQuery(".icon_mobile_click").click(function(){
			jQuery(this).fadeOut(300);
			jQuery("#page_wrapper").addClass('page_wrapper_active');
			jQuery("#menu_mobile_full").addClass('menu_show').stop().animate({left: "0px"},260);
			jQuery(".close_menu, .bg_opacity").show();
		});
		jQuery(".close_menu").click(function(){
			jQuery(".top_header .icon_mobile_click").fadeIn(300);
			jQuery("#menu_mobile_full").animate({left: "-260px"},260).removeClass('menu_show');
			jQuery("#page_wrapper").removeClass('page_wrapper_active');
			jQuery(this).hide();
			jQuery('.bg_opacity').hide();
			if(jQuery('.middle_header').hasClass('fixed_menu')){
				jQuery('.middle_header.fixed_menu .icon_mobile_click').show();
			}
			
		});
		jQuery('.bg_opacity').click(function(){
			jQuery("#menu_mobile_full").animate({left: "-260px"},260).removeClass('menu_show');
			jQuery("#page_wrapper").removeClass('page_wrapper_active');
			jQuery('.close_menu').hide();
			jQuery(this).hide();
			jQuery('.top_header .icon_mobile_click').fadeIn(300);
				if(jQuery('.middle_header').hasClass('fixed_menu')){
				jQuery('.middle_header.fixed_menu .icon_mobile_click').show();
			}
			});
		jQuery("#menu_mobile_full ul li a").click(function(){
			jQuery(".icon_mobile_click").fadeIn(300);
			jQuery("#page_wrapper").removeClass('page_wrapper_active');
		});

		jQuery('.mobile-menu .menu>li:not(:has(ul.sub-menu)) , .mobile-menu .menu>li ul.sub-menu>li:not(:has(ul.sub-menu))').addClass('not-have-child');

		// menu cap 2
		jQuery('.mobile-menu ul.menu').children().has('ul.sub-menu').click(function(){
			jQuery(this).children('ul').slideToggle();
			jQuery(this).siblings().has('ul.sub-menu').find('ul.sub-menu').slideUp();
			jQuery(this).siblings().find('ul.sub-menu>li').has('ul.sub-menu').removeClass('editBefore_mobile');
		}).children('ul').children().click(function(event){event.stopPropagation();});

		//menu cap 3
		jQuery('.mobile-menu ul.menu>li>ul.sub-menu').children().has('ul.sub-menu').click(function(){
			jQuery(this).children('ul.sub-menu').slideToggle();
		}).children('ul').children().click(function(event){event.stopPropagation();});

			//menu cap 4
		jQuery('.mobile-menu ul.menu>li>ul.sub-menu>li>ul.sub-menu').children().has('ul.sub-menu').click(function(){
			jQuery(this).children('ul.sub-menu').slideToggle();
		}).children('ul').children().click(function(event){event.stopPropagation();});


		jQuery('.mobile-menu ul.menu li').has('ul.sub-menu').click(function(event){
			jQuery(this).toggleClass('editBefore_mobile');
		});
		jQuery('.mobile-menu ul.menu').children().has('ul.sub-menu').addClass('menu-item-has-children');
		jQuery('.mobile-menu ul.menu>li').click(function(){
			$(this).addClass('active').siblings().removeClass('active, editBefore_mobile');
		});

		// list_products_categories
		jQuery('.list_products_categories>ul').children().has('ul.sub_product_category').click(function(){
			jQuery(this).children('ul').slideToggle();
			jQuery('.list_products_categories>ul').children().not(this).has('ul.sub_product_category').find('ul.sub_product_category').slideUp();
		}).children('ul').children().click(function(event){event.stopPropagation()});
		jQuery('.list_products_categories>ul').children().find('ul.sub_product_category').children().has('ul.sub-menu').click(function(){
			jQuery(this).find('ul.sub-menu').slideToggle();
		});
		jQuery('.list_products_categories ul li').has('ul.sub_product_category').click(function(event){
			jQuery(this).toggleClass('editBefore_li_product');
			//event.preventDefault();
		});
		jQuery('.list_products_categories ul').children().has('ul.sub_product_category').addClass('menu-item-has-children');
		jQuery('.list_products_categories ul li').click(function(){
			jQuery(this).addClass('active').siblings().removeClass('active, editBefore_li_product ');
		});

		var width = jQuery(window).width();
		if(width>1100){
			var cart = jQuery('.g_cart');
		addToCart = $('.tg_btn_acts li.add_c a.add_to_cart_button');
		addToCart.on('click', function (evt) {
	
			var el = $(this),
			item = el.parents('.product_inner'),
			img = item.find('img'),
			cartTopOffset = cart.offset().top - item.offset().top,
			cartLeftOffset = cart.offset().left - item.offset().left;
			var flyingImg = $('<img class="b-flying-img">');
			flyingImg.attr('src', img.attr('src'));
			flyingImg.css('width', '200').css('height', '200');
			flyingImg.animate({
				top: cartTopOffset,
				left: cartLeftOffset,
				width: 50,
				height: 50,
				opacity: 0.1
			}, 800, function () {
				flyingImg.remove();
			});
			el.parents('.product_inner').append(flyingImg);
		});
		} //endif
		jQuery('span.onsale').text('Sale');

		jQuery('.single-product .woocommerce-product-gallery ul li').click(function(){
			var link_img_preview =  jQuery(this).html();
			jQuery('.tg_img_product img').replaceWith(link_img_preview);
		});
		
	});

