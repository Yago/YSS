$(document).ready(function(){
  $('#yss-navigation-container').height($(window).height());
  initNavigation();
  $(window).scroll(function(){
    activeNavigation();
  });
  showNavigation();
});

/*
* Create navigation items
*/
function initNavigation(){
  var $nav = $('#yss-navigation').find('ul');
  var index = 0;
  $('.yss-content').find('h1, h2').each(function(){
    var titleContent = $(this).text();
    if($(this).is('h1')){
      index = index + 1;
      $(this).attr('id', 'chapter-'+index);
      $nav.append('<li><a id="link-chapter-'+index+'" class="link-chapter" href="#chapter-'+index+'">'+titleContent+'</a></li>');
    }else {
      index = index + 1;
      $(this).attr('id', 'sub-chapter-'+index);
      $nav.append('<li><a id="link-sub-chapter-'+index+'" class="link-sub-chapter" href="#sub-chapter-'+index+'">'+titleContent+'</a></li>');
    }
  });
  $nav.find('a').click(function(event){
    event.preventDefault();
    $target = $(this).attr('href');
    $('html, body').animate({
        scrollTop: $($target).offset().top - 70
    }, 1000);
  });
  $('#yss-logo').click(function(){
    $('html, body').animate({
        scrollTop: 0
    }, 1000);
  });
}

/*
* Set active class in navigation
*/
function activeNavigation(){
  var refPos = $(document).scrollTop();
  $('.yss-content').find('h1, h2').each(function(){
    var titlePos = $(this).offset().top;
    var titleID = $(this).attr('id');
    if(refPos > titlePos - 80){
      $('#yss-navigation').find('a').removeClass('yss-active');
      $("#link-"+titleID).addClass('yss-active');
    }
  });
}


/*
* Set navigation toggle slide
*/
function showNavigation(){
  var $button = $("#yss-show-nav");
  var $navigation = $("#yss-navigation-container");
  var $body = $("body");
  var $header = $("#yss-header");

  $button.click(function(event){
    event.preventDefault();
    if($navigation.hasClass('yss-pushed')){
      $navigation.animate({left: -250}, "slow" );
      $body.animate({left: 0}, "slow" );
      $header.animate({left: 0}, "slow" );
      $navigation.removeClass('yss-pushed');
    }else {
      $navigation.animate({left: 0}, "slow" );
      $body.animate({left: 250}, "slow" );
      $header.animate({left: 250}, "slow" );
      $navigation.addClass('yss-pushed');
    }
  });
}