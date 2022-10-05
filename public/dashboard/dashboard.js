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
       $('#engine_types').attr("disabled", "disabled");
       $("#engine_volume").attr("disabled", "disabled");
       $("#transmission").attr("disabled", "disabled");
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
            $('#models').html(data);
            $('#models').attr("disabled", false);
            $('#engine_types').html('<option selected>Выберите тип двигателя</option>');
            $('#engine_volume').html('<option selected>Выберите объем ДВС</option>');
            $('#transmission').html('<option selected>Выберите тип КПП</option>');
         }
      })
   })

   //выбор модели и заполнение списка типов ДВС
   $("#models").on('change', function () {
      $("#engine_volume").attr("disabled", "disabled");
      $("#transmission").attr("disabled", "disabled");
      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $("input[name='_token']").val()
         }
      });
      $.ajax({
         url: "/cars_ajax",
         method: "POST",
         data: {
            mark_change: $('#marks').val(),
            model: $(this).val(),
         },
         success: function (data) {
            $('#engine_types').html(data);
             $("#engine_types").attr("disabled", false);
            $('#engine_volume').html('<option selected>Выберите объем ДВС</option>');
            $('#transmission').html('<option selected>Выберите тип КПП</option>');
         }
      })
   })

   //выбор типа ДВС и заполнение списка объемов ДВС
   $("#engine_types").on('change', function () {
      if ($(this).val() == 'электро') {
         $("#engine_volume").attr("disabled", "disabled");
         $("#transmission").attr("disabled", "disabled");
         $('#engine_volume').html('<option selected>N/A</option>');
         $('#transmission').html('<option selected>N/A</option>');
      } else {
         $("#transmission").attr("disabled", "disabled");
         $.ajaxSetup({
            headers: {
               'X-CSRF-TOKEN': $("input[name='_token']").val()
            }
         });
         $.ajax({
            url: "/cars_ajax",
            method: "POST",
            data: {
               mark_change: $('#marks').val(),
               model_change: $('#models').val(),
               engine_type: $(this).val(),
            },
            success: function (data) {
               $('#engine_volume').html(data);
               $("#engine_volume").attr("disabled", false);
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
         url: "/cars_ajax",
         method: "POST",
         data: {
            mark_change: $('#marks').val(),
            model_change: $('#models').val(),
            engine_type_change: $('#engine_types').val(),
            engine_volume: $(this).val(),
         },
         success: function (data) {
            $('#transmission').html(data);
             $('#transmission').attr("disabled", false);

         }
      })
   })

    // AJAX ДЛЯ ВЫБОРА ГОРОДА ПОКУПКИ АВТОМОБИЛЯ
    //выбор страны и заполнение списка регионов
    $("#countries").on('change', function () {
        $("#regions").attr("disabled", false);
        $('#cities').html('<option selected>Выберите город</option>');
        $("#cities").attr("disabled", "disabled");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $("input[name='_token']").val()
            }
        });
        $.ajax({
            url: "/city_ajax",
            method: "POST",
            data: { country: $(this).val() },
            success: function (data) {
                $('#regions').html(data);

            }
        })
    })

    //выбор региона и заполнение списка городов
    $("#regions").on('change', function () {
        $("#cities").attr("disabled", false);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $("input[name='_token']").val()
            }
        });
        $.ajax({
            url: "/city_ajax",
            method: "POST",
            data: { region: $(this).val() },
            success: function (data) {
                $('#cities').html(data);
            }
        })
    })


    $('[data-sum]').inputmask({
        prefix: "",
        groupSeparator: " ",
        alias: "currency",
        digits: 0,
        rightAlign:false,
        allowMinus: false,
        digitsOptional: !1 });

    $('[data-sum-need]').inputmask({
        prefix: "",
        groupSeparator: " ",
        alias: "currency",
        digits: 0,
        rightAlign:false,
        digitsOptional: !1 })

    $('[data-balance]').inputmask({
        prefix: "",
        groupSeparator: " ",
        alias: "currency",
        digits: 0,
        rightAlign:false,
        digitsOptional: !1 });

    $('[data-profit]').inputmask({
        prefix: "",
        groupSeparator: " ",
        alias: "currency",
        digits: 0,
        rightAlign:false,
        digitsOptional: !1 });

    $('[data-year]').inputmask({
        regex: "^[0-9]{4}$",
       // alias: "numeric",
        decimal : " ",
        digits: 0,
        rightAlign:false,
        allowMinus: false,
        });

    $('[data-num]').inputmask({
        alias: "numeric",
        decimal : " ",
        digits: 0,
        rightAlign:false,
        allowMinus: false,
    });

})
