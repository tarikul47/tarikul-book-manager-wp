jQuery(document).ready(function ($) {
  // Initialize variables
  var mediaUploader;
  var imageField = $("#topic_image");
  var imagePreview = $("#topic-image-preview");
  var uploadButton = $(".upload-image-button");
  var removeButton = $(".remove-image-button");

  // Upload image functionality
  uploadButton.on("click", function (e) {
    e.preventDefault();

    // If the uploader object has already been created, reopen it
    if (mediaUploader) {
      mediaUploader.open();
      return;
    }

    // Extend the wp.media object
    mediaUploader = wp.media.frames.file_frame = wp.media({
      title: "Choose Image",
      button: {
        text: "Choose Image",
      },
      multiple: false,
    });

    // When an image is selected, run a callback
    mediaUploader.on("select", function () {
      var attachment = mediaUploader.state().get("selection").first().toJSON();
      imageField.val(attachment.url);
      imagePreview.attr("src", attachment.url).show();
      removeButton.show();
    });

    // Open the uploader dialog
    mediaUploader.open();
  });

  // Remove image functionality
  removeButton.on("click", function (e) {
    e.preventDefault();
    imageField.val("");
    imagePreview.hide();
    $(this).hide();
  });

  // Handle reset after adding a new category
  $(document).ajaxComplete(function (event, xhr, settings) {
    if (settings.data && settings.data.includes("action=add-tag")) {
      // Clear image field, preview, and remove button after adding a new term
      imageField.val("");
      imagePreview.attr("src", "").hide();
      removeButton.hide();
    }
  });
});
