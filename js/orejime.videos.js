(function ($) {

  $(document).ready(function() {
    
    tryToLoadContent();
    
    $("#orejime-loadconsent").on("click", function() {
      orejime.show();
    });

    $(".orejime-Button--save").bind("click", function() {
      tryToLoadContent();
    });
    
    function tryToLoadContent() {

      let socialmedia = orejime.internals.manager.states.socialmedia;
      
      if(socialmedia) {      
        contents = $('.embed').html();
        $('.orejime-embed.placeholder .content').html(contents);
      }
    }
  
  });
  

}(jQuery));