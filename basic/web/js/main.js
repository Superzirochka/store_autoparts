window.addEventListener(
  "load",
  function () {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    let forms = document.getElementsByClassName("needs-validation");
    // Loop over them and prevent submission
    let validation = Array.prototype.filter.call(forms, function (form) {
      form.addEventListener(
        "submit",
        function (event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add("was-validated");
        },
        false
      );
    });
  },
  false
);

$("#exampleModal").on("show.bs.modal", function (event) {
  let button = $(event.relatedTarget); // Button that triggered the modal
  let recipient = button.data("whatever"); // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  let modal = $(this);
  // modal.find(".modal-title").text("New message ");
  modal.find(".modal-body input").val(recipient);
});

// accordion category menu

$(function () {
  $("#accordion").accordion({
    collapsible: true,
    heightStyle: "content",
  });
});

$(function () {
  $(".owl-carousel").owlCarousel({
    items: 10,
    loop: true,
    margin: 10,
    autoplay: true,
    autoplayTimeout: 3000,
    autoplayHoverPause: true,
  });
});

$(function () {
  $(".owl-carouselRec").owlCarousel({
    items: 4,
    loop: true,
    margin: 10,
    autoplay: true,
    autoplayTimeout: 3000,
    autoplayHoverPause: true,
  });
});

$("a.gallery2").fancybox({
  padding: 20,
  imageScale: true,
  zoomOpacity: false,
  zoomSpeedIn: 1000,
  zoomSpeedOut: 1000,
  zoomSpeedChange: 1000,
  frameWidth: 700,
  frameHeight: 600,
  overlayShow: true,
  overlayOpacity: 0.8,
  hideOnContentClick: false,
  centerOnScroll: true,
});

$('[data-fancybox="images"]').fancybox({
  afterLoad: function (instance, current) {
    var pixelRatio = window.devicePixelRatio || 1;

    if (pixelRatio > 1.5) {
      current.width = current.width / pixelRatio;
      current.height = current.height / pixelRatio;
    }
  },
});

(function () {
  "use strict";
  window.addEventListener(
    "load",
    function () {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName("needs-validation");
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function (form) {
        form.addEventListener(
          "submit",
          function (event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add("was-validated");
          },
          false
        );
      });
    },
    false
  );
})();

// $(document).ready(function () {
//   $("#sortform-sort").on("change", function () {
//     // Получаем объект формы
//     var $testform = $(this);
//     // отправляем данные на сервер
//     $.ajax({
//       // Метод отправки данных (тип запроса)
//       type: $testform.attr("method"),
//       // URL для отправки запроса
//       url: $testform.attr("action"),
//       // Данные формы
//       data: $testform.serializeArray(),
//     })
//       .done(function (data) {
//         if (data.error == null) {
//           // Если ответ сервера успешно получен
//           $("#output").text(data.data.text);
//         } else {
//           // Если при обработке данных на сервере произошла ошибка
//           $("#output").text(data.error);
//         }
//       })
//       .fail(function () {
//         // Если произошла ошибка при отправке запроса
//         $("#output").text("error3");
//       });
//     // Запрещаем прямую отправку данных из формы
//     return false;
//   });
// });
