(function ($) {

  $(document).ready(function() {
    
    tryToLoadContent();
    
    $("#orejime-loadconsent").on("click", function(e) {
      e.preventDefault();
      orejime.show();
    });

    $(".orejime-Button--save").bind("click", function() {
      tryToLoadContent();
    });
    
    function tryToLoadContent() {

      // let socialmedia = orejime.internals.manager.states.socialmedia;
      let socialmedia = true;
      
      if(socialmedia) {

        $(".orejime_template").each(function() {
          const videoID = $(this).attr("data-videoid");
          const contents = $(this).html();

          $(".orejime_embed.placeholder[data-videoid='"+videoID+"'] .orejime_content").html(contents);

        });

      }
    }
  
  });
  

}(jQuery));