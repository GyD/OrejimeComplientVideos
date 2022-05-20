;(function ($) {
  $(document).ready(function () {
    changeWidthOfPlacholder()
    tryToLoadContent()

    $("#orejime-loadconsent").on("click", function (e) {
      e.preventDefault()
      orejime.show()
    })

    $(document).on("click", ".orejime-Button--save", function () {
      tryToLoadContent()
    })

    /**
     * Check if the social media cookie is enabled, and load content if enabled
     */
    function tryToLoadContent() {
      // let socialmedia = orejime.internals.manager.states.socialmedia;
      let socialmedia = orejime.internals.manager.getConsent(
        drupalSettings.orejime_videos.consent
      )
      if (socialmedia) {
        $(".orejime_template").each(function () {
          const EMBEDEDID = $(this).data("orejime-embeded-id"),
            CONTENT = $(this).html()

          $(
            ".orejime_placeholder[data-orejime-embeded-id='" +
              EMBEDEDID +
              "'] .orejime_embed"
          ).replaceWith(CONTENT)
        })
      }
    }

    /**
     * Change the width of the placeholder based on the width-attribute
     */
    function changeWidthOfPlacholder() {
      $(".orejime_placeholder").each(function () {
        const WIDTH = $(this).attr("width")
        $(this).width(WIDTH)
      })
    }
  })
})(jQuery)
