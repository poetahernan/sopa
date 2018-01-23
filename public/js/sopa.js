 (function($) {

                'use strict';

                $(document).ready(function() {


                    var getBaseURL = function() {
                        var url = document.URL;
                        return url.substr(0, url.lastIndexOf('/'));
                    }


                    $("#form-sopa").submit(function(e) {

                        e.preventDefault();

                        $("#salida").html(0);


                        var $form = $(this), data = $form.serialize(), url = $form.attr("action");
                        var token = $('#form-sopa> input[name="_token"]').val();
                        var url = " /sopa/generarsopa ";


                        $("label[for$='-error']").text('');

                        $.ajax(
                            {
                                url:  url,
                                type: 'post',
                                dataType: 'json',
                                data: {
                                    formDatos: data,
                                    _token: token
                                }
                            }).done(
                            function(data) {

                                if (data.success) {
                                    $("#tabla_sopa > tbody").html("");
                                    $("#tabla_sopa > tbody").append(data.sopa);
                                }
                                else
                                {
                                    if(data.errors) {
                                        $.each(data.errors, function (index, value) {
                                            var errorDiv = '#' + index + '-error';
                                            $(errorDiv).addClass('error');
                                            $(errorDiv).empty().append("* " + value);
                                        });
                                    }
                                }

                            });

                    });


                    $('#btn-generar').click(function() {


                        var token = $('#form-sopa> input[name="_token"]').val();
                        var url = " /sopa/generartablasopa ";


                        var rowIndex=0;
                        var columnIndex=0;

                        var tableJson = [];


                        $("#tabla_sopa > tbody tr").each(function () {

                            var row = $(this);
                            columnIndex=0;

                            $("td input", row).each(function () {

                                var tdElem= $(this);
                                tableJson.push({row:rowIndex,column:columnIndex,value: tdElem.val()});
                                columnIndex+=1;

                            });

                            rowIndex+=1;
                        });


                        console.log( $("#txt_filas").val());
                        console.log( $("#txt_columnas").val());

                        var tabla=tableJson;

                        $.ajax(
                            {
                                url:  url,
                                type: 'post',
                                dataType: 'json',
                                data: {
                                    palabra: $("#txt_buscar").val(),
                                    rows: $("#txt_filas").val(),
                                    columns: $("#txt_columnas").val(),
                                    tabla: tabla,
                                    _token: token
                                }
                            }).done(
                            function(data) {

                                if (data.success) {

                                    $("#salida").html(data.palabras);
                                }
                                else
                                {

                                    $("#salida").html(0);
                                }

                            });


                    });



            });
                
     })(window.jQuery);