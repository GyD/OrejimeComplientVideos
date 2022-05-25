;(function ($) {
  $(document).ready(function () {
    changeWidthOfPlacholder()
    tryToLoadContent()

    $(document).on("click", ".orejime_loadconsent", function (e) {
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
      $(".orejime_template").each(function () {
        const domain = $(this).attr("data-orejime-domain");

        if (!orejime.internals.manager.getConsent(domain)) {
          return;
        }

        const embeded_id = $(this).data("orejime-embeded-id"),
          content = $(this).html()
        ;

        $(".orejime_placeholder[data-orejime-embeded-id='" + embeded_id + "'] .orejime_embed").replaceWith(content)
      })

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
