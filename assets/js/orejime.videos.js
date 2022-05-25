/* global orejime:readonly */
(function ($) {
  /**
   * Check if the social media cookie is enabled, and load content if enabled
   */
  function tryToLoadContent() {
    // eslint-disable-next-line func-names
    $(".orejime_template").each(function () {
      const domain = $(this).attr("data-orejime-domain");

      if (!orejime.internals.manager.getConsent(domain)) {
        return;
      }

      const embededId = $(this).data("orejime-embeded-id");
      const content = $(this).html();

      $(
        `.orejime_placeholder[data-orejime-embeded-id="${embededId}"] .orejime_embed`
      ).replaceWith(content);
    });
  }

  /**
   * Change the width of the placeholder based on the width-attribute
   */
  function changeWidthOfPlacholder() {
    // eslint-disable-next-line func-names
    $(".orejime_placeholder").each(function () {
      const width = $(this).attr("width");
      $(this).width(width);
    });
  }

  // eslint-disable-next-line func-names
  $(document).ready(function () {
    changeWidthOfPlacholder();
    tryToLoadContent();

    // eslint-disable-next-line func-names
    $(document).on("click", ".orejime_loadconsent", function (e) {
      e.preventDefault();
      orejime.show();
    });

    // eslint-disable-next-line func-names
    $(document).on("click", ".orejime-Button--save", function () {
      tryToLoadContent();
    });
  });
})(jQuery);
