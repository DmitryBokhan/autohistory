$(document).ready(function () {
   //подсветка выбранного раздела меню 
   $(".nav-treeview .nav-link, .nav-link").each(function () {
      var location2 = window.location.protocol + '//' + window.location.host + window.location.pathname;
      var link = this.href;
      if (link == location2) {
         $(this).addClass('active');
         $(this).parent().parent().parent().addClass('menu-is-opening menu-open');

      }
   });

   //окно подтверждения действия на удаление 
   $('.delete-btn').click(function () {
      var res = confirm('Подтвердите действия');
      if (!res) {
         return false;
      }
   });


   $('#myModal').on('shown.bs.modal', function () {
      $('#myInput').trigger('focus')
   })


   // AJAX ДЛЯ ВЫБОРА МОДЕЛИ АВТОМОБИЛЯ 
   //выбор марки и заполнение списка моделей
   $("#marks").on('change', function () {
      $("#engine_volume").attr("disabled", false);
      $("#transmission").attr("disabled", false);
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $("input[name='_token']").val()
         }
      });
      $.ajax({
         url: "/cars_ajax",
         method: "POST",
         data: { mark: $(this).val() },
         success: function (data) {
            $('#models').html(data),
               $('#engine_types').html('<option selected>Выберите тип ДВС</option>'),
               $('#engine_volume').html('<option selected>Выберите объем ДВС</option>'),
               $('#transmission').html('<option selected>Выберите тип КПП</option>')
         }
      })
   })

   //выбор модели и заполнение списка типов ДВС
   $("#models").on('change', function () {
      $("#engine_volume").attr("disabled", false);
      $("#transmission").attr("disabled", false);
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $("input[name='_token']").val()
         }
      });
      $.ajax({
         url: "cars_ajax",
         method: "POST",
         data: {
            mark_change: $('#marks').val(),
            model: $(this).val(),
         },
         success: function (data) {
            $('#engine_types').html(data)
            $('#engine_volume').html('<option selected>Выберите объем ДВС</option>'),
               $('#transmission').html('<option selected>Выберите тип КПП</option>')
         }
      })
   })

   //выбор типа ДВС и заполнение списка объемов ДВС
   $("#engine_types").on('change', function () {
      if ($(this).val() == 'электро') {
         $("#engine_volume").attr("disabled", "disabled");
         $("#transmission").attr("disabled", "disabled");
         $('#engine_volume').html('<option selected>N/A</option>')
         $('#transmission').html('<option selected>N/A</option>')
      } else {
         $("#engine_volume").attr("disabled", false);
         $("#transmission").attr("disabled", false);
         $.ajaxSetup({
            headers: {
               'X-CSRF-TOKEN': $("input[name='_token']").val()
            }
         });
         $.ajax({
            url: "cars_ajax",
            method: "POST",
            data: {
               mark_change: $('#marks').val(),
               model_change: $('#models').val(),
               engine_type: $(this).val(),
            },
            success: function (data) {
               $('#engine_volume').html(data),
                  $('#transmission').html('<option selected>Выберите тип КПП</option>')
            }
         })
      }

   })

   //выбор объема ДВС и заполнение списка типов КПП
   $("#engine_volume").on('change', function () {
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $("input[name='_token']").val()
         }
      });
      $.ajax({
         url: "cars_ajax",
         method: "POST",
         data: {
            mark_change: $('#marks').val(),
            model_change: $('#models').val(),
            engine_type_change: $('#engine_types').val(),
            engine_volume: $(this).val(),
         },
         success: function (data) {
            $('#transmission').html(data)
         }
      })
   })
})