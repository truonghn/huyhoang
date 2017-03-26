jQuery(document).ready(function ($) {
  var arr_phuong = {
    'Hải Châu' : ['Hải Châu 1', 'Hải Châu 2'],
    'Hoà Vang' : ['Hoà Ninh', 'Hoà Phong'],
    'Cẩm Lệ' : ['Hoà Thọ', 'Hoà Xuân'],
    'Liên Chiểu' : ['Hoà Minh', 'Hoà Khánh']
  };
  $( ".filter-huyen select" ).change(function() {
    var quan = $( ".filter-huyen select" ).val();
    $('.filter-phuong select')
    .empty()
    .append('<option selected="selected" value="">Phường/Xã</option>');
    arr_phuong[quan].forEach (function(phuong) {
      $('.filter-phuong select').append('<option value="'+phuong+'">'+phuong+'</option>');
    }); 
  });
  //$('.rent-price').hide();
  select_bds_type();
  $('.filter-loai-bds select').change(function() {
    select_bds_type();
  });
  function select_bds_type() {
    var type = $( ".filter-loai-bds select").val();
    if (type == 102) {
      $('.rent-price').hide();
      $('.rent-price select').val('');
      $('.price').show();
    } else {
      $('.price').hide();
      $('.price select').val('');
      $('.rent-price').show();
    }
  }
  $("select[name='sort_result']").change(function() {
    var sort = $("select[name='sort_result']").val();
    $('select[name="bds_sort"]').val(sort);
    $('form[name="seach_bds_form"]').submit();
  });
  $(window).load(function() {
    // The slider being synced must be initialized first
  $('#carousel').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 75,
    itemMargin: 5,
    asNavFor: '#slider'
  });
 
  $('#slider').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: false,
    sync: "#carousel"
  });
  });
});