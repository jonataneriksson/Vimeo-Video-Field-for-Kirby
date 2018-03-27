(function($) {
  $.fn.vimeo = function() {
    return this.each(function() {

      //Initialize
      var $self = $(this);
      var $page = 0;
      var $grid = $("<div>", {class: 'grid'});
      var $loader = $("<div>", {class: 'loader'});
      var $input = $(this).siblings('.input').first();
      var $parent =  $(this).parents('.field-name-video');
      var $nameinput =  $parent.siblings('.field-name-name').find('.input');
      var $thumbnailinput =  $parent.siblings('.field-name-thumbnail').find('.input');
      $self.prepend($grid);

      //Ajax call function
      $loadmorevideos = function() {
        $page ++;
        $grid.append($loader);
        console.log($page);
        $.getJSON( '/vimeo.json?page='+$page, function( data ) {
          $loader.remove();
          console.log(data.videos)
          $grid.append($addvideos(data));
        });
      }

      $select = function() {
        $itemdata = JSON.parse(this.dataset.item);
        $(this).addClass('selected');
        $(this).siblings().removeClass('selected');
        //Prune the data
        $itemdata.hd = $itemdata.hd.split('&profile_id')[0]+'&filler=0000000000000000000000000000';
        $itemdata.sd = $itemdata.sd.split('&profile_id')[0]+'&filler=0000000000000000000000000000';
        //Update the value
        console.log($itemdata);
        $input.val(JSON.stringify($itemdata));
        $nameinput.val($itemdata.name);
        $thumbnailinput.val($itemdata.thumbnail200);
      }

      //Video list formatter function
      $addvideos = function(data) {
        var $items = [];
        $.each( data.videos , function(index, item) {
          var $item  = $("<label>", {class: 'grid-item', click: $select, 'data-item': JSON.stringify(item)});
          var $figure  = $("<figure>", {class: 'file'});
          var $caption  = $("<figcaption>", {});//class: 'file-info'
          var $link  = $("<a>", {});
          var $title  = $("<span>", {class: 'file-name cut'});
          var $image = $("<img>", {src: item.thumbnail200});
          $figure.append($image);
          $title.html(item.name);
          $link.append($title);
          $caption.append($link);
          $figure.append($caption);
          $item.append($figure);
          $items.push($item);


        });
        return $items;
      }

      //Initial load
      $loadmorevideos($page);

      //The load button
      var $more  = $("<a>", {class: 'btn btn-rounded', text: 'More videos', click: $loadmorevideos});
      $self.append($more);

    });
  };
})(jQuery);
