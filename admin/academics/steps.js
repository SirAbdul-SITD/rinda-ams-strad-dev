// Initialize wizard after event listener
$("#wizard").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    onStepChanging: function (event, currentIndex, newIndex) {
      form.validate().settings.ignore = ":disabled,:hidden";
      return form.valid();
    },
    onFinishing: function (event, currentIndex) {
      form.validate().ignore;
      return form.valid();
    },
    onFinished: function (event, currentIndex) {
      // Submit the form via AJAX
      $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize(),
        beforeSend: function () {
          $('#warningModel').modal('hide');
        },
        success: function (response) {
          // Handle success response
          console.log(response);
        },
        error: function (xhr, status, error) {
          // Handle error
          console.error(xhr.responseText);
        }
      });
    }
  });