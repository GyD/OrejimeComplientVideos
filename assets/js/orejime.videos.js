(function ($) {

  $(document).ready(function () {

    tryToLoadContent();

    $("#orejime-loadconsent").on("click", function (e) {
      e.preventDefault();
      orejime.show();
    });

    $(document).on('click', ".orejime-Button--save", function () {
      tryToLoadContent();
    });

    /**
     *
     */
    function tryToLoadContent() {

      // let socialmedia = orejime.internals.manager.states.socialmedia;
      let socialmedia = orejime.internals.manager.getConsent('matomo');
        if (socialmedia) {

        $(".orejime_template").each(function () {
          const
            embededID = $(this).data('orejime-embeded-id'),
            content = $(this).html()
          ;

          $(".orejime_embed.placeholder[data-orejime-embeded-id='" + embededID + "'] .orejime_content").html(content);

        });

      }
    }

  });


}(jQuery));
