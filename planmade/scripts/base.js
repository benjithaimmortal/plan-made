jQuery(document).ready(function($) {

  $('input[type=number]').change(function(){
    let count = $(this).val();
    let img = $(this).parents('label').find('.img').eq(0);
    console.log([count,img]);
    $(this).parents('label').find('.img').remove();
    for (var i=0; i < count; i++) {
      // $("&nbsp;").insertAfter($(this).parents('span'));
      $(img.clone()).insertAfter($(this).parents('span'));
    }

  })
  $('input[type=checkbox][value="👍"]').change(function(){
    if ($(this).prop('checked') == true) {
      $('.conditional').addClass('active');
    } else {
      $('.conditional').removeClass('active');
    }
  })
  $('input[type=checkbox][value="👎"]').change(function(){
    if ($(this).prop('checked') == true) {
      $('.conditional').removeClass('active');
    } else {
      $('.conditional').addClass('active');
    }
  })

  $(document).on('wpcf7submit', function(e){
    let form = $(e.target);
    if (form.find('.dot_loader')) {
      form.find('.button-outer')
        .removeClass('going')
        .addClass('gone')
    }
  })
  $(document).on('wpcf7mailsent', function(e){
    let form = $(e.target);
    if (form.find('.dot_loader')) {
      form.find('.button-outer')
        .removeClass('gone')
        .addClass('going')
    }
    setTimeout(() => {
      $(e.target).addClass('closed')
    }, 1000);
  })
  $(document).on('wpcf7invalid', function(e){
    let form = $(e.target);
    if (form.find('.dot_loader')) {
      form.find('.button-outer')
        .removeClass('going gone');
    }
  })
})