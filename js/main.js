$(document).ready(function(){
  initNavigation();
  $(window).scroll(function(){
    activeNavigation();
  });
});

function initNavigation(){
  var $nav = $('#yss-navigation').find('ul');
  var index = 0;
  $('.yss-content').find('h1, h2').each(function(){
    var titleContent = $(this).text();
    if($(this).is('h1')){
      index = index + 1;
      $(this).attr('id', 'chapter-'+index);
      $nav.append('<li><a id="link-chapter-'+index+'" class="link-chapter" href="#chapter-'+index+'"><strong>'+titleContent+'</strong></a></li>');
    }else {
      index = index + 1;
      $(this).attr('id', 'sub-chapter-'+index);
      $nav.append('<li><a id="link-sub-chapter-'+index+'" class="link-sub-chapter" href="#sub-chapter-'+index+'">'+titleContent+'</a></li>');
    }
  });
}

function activeNavigation(){
  var refPos = $(document).scrollTop();
  console.log(refPos);
  $('.yss-content').find('h1, h2').each(function(){
    var titlePos = $(this).offset().top;
    var titleID = $(this).attr('id');
    if(refPos > titlePos - 40){
      console.log(titleID);
      $('#yss-navigation').find('a').removeClass('yss-active');
      $("#link-"+titleID).addClass('yss-active');
    }
  });
}