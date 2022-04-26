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

        $(".orejime-template").each(function() {
          const videoID = $(this).attr("data-videoid");
          const contents = $(this).html();

          $(".orejime-embed.placeholder[data-videoid='"+videoID+"'] .orejime-content").html(contents);

        });

      }
    }
  
  });
  

}(jQuery));